<?php

// https://www.w3schools.com/php/php_file_upload.asp
$target_dir = "/opt/bitnami/apache2/htdocs/uploads/";

$fileName = $_POST['fileName'];

$target_file = $target_dir.$fileName.".csv";

$uploadOk = true;

if(isset($_POST["submit"]))
{
    if (file_exists($target_file))
    {
        echo "Sorry, file already exists.";
        $uploadOk = false;
    }
    
    if ($_FILES["fileToUpload"]["size"] > 10000000)
    {
        echo "Sorry, your file is too large";
        $uploadOk = false;
    }
    
    if((strtolower(pathinfo($target_file,PATHINFO_EXTENSION))!="csv")||$_FILES["fileToUpload"]["type"]!="text/csv")
    {
        echo "Sorry, only CSV files are allowed.";
        $uploadOk = false;
    }
    
    if (!$uploadOk)
    {
        echo "Sorry, your file was not uploaded.";
    
    }
    else
    {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
        {
            echo "The file ".basename($_FILES["fileToUpload"]["name"]). " has been uploaded. ";
        }
        else
        {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}


class Book // Create class containing the books
{
    public $title;
    public $highlights;
}

function FindBook($Books, $TitleThatIAmLookingFor) // Find a particular title within my array of Books 
{
    $IsBookInBooksArrayAndIfSoWhatNumberBookIsIt = -1; // I originally wanted to return FALSE here but PHP sees FALSE as equal to 0 but I still need to differentiate between the zeroth (i.e., first) book and not having found the book in the object so we use -1 (https://softwareengineering.stackexchange.com/questions/198284/why-is-0-false)
    $j=0;
    while ($j<count($Books)) 
    {
        if (($Books[$j]->title)==$TitleThatIAmLookingFor) // Is this book's title the same as the title I'm looking for
        {
            $IsBookInBooksArrayAndIfSoWhatNumberBookIsIt = $j;   
            $j = count($Books); // Now that we've found the book, let's get out of this loop.
        }
        $j++;
    }

    return $IsBookInBooksArrayAndIfSoWhatNumberBookIsIt;
}

//To deal with horrible character encodings. mb_convert_encoding("xxx\xc3\xadxxx", 'UTF-8'); didn't always work so used https://stackoverflow.com/a/19606250/13136079
function decode_code($code) 
{
    return preg_replace_callback('@\\\(x)?([0-9a-f]{2,3})@',
        function ($m) {
            if ($m[1]) {
                $hex = substr($m[2], 0, 2);
                $unhex = chr(hexdec($hex));
                if (strlen($m[2]) > 2) {
                    $unhex .= substr($m[2], 2);
                }
                return $unhex;
            } else {
                return chr(octdec($m[2]));
            }
        }, $code);
}

$StartTime = microtime(TRUE);

$ReadwiseDataFile = $target_file;

//Reverse the file
$PreReverseFile = explode("\n",file_get_contents($ReadwiseDataFile));

$ReverseFile = fopen("/opt/bitnami/apache2/htdocs/uploads/"."REVERSED-".$fileName.".csv", "w");

foreach(array_reverse($PreReverseFile) as $Line)
{ 
    fwrite($ReverseFile, $Line."\n");
}

unlink($ReadwiseDataFile);

if (($handle = fopen("/opt/bitnami/apache2/htdocs/uploads/"."REVERSED-".$fileName.".csv", "r")) !== FALSE) // Open the reversed file
{
    $i=0;
    $NumberOfHighlights=0;
    $NumberOfFiles=0;

    while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) //https://www.php.net/manual/en/function.fgetcsv.php
    {
        // $num = count($data); // Number of fields

        $text = decode_code(substr($data[0],2,-1));
        $title = decode_code(substr($data[1],2,-1));
        $author = decode_code(substr($data[2],2,-1));

        if ($title!="ok Titl") // ok Titl = substr("Book Title",2,-1) (If we're not on the header row (which will be the last))
        {
            $OutputofFindBookFunction = FindBook($Books, $title); // Is the book already within our data structure?
            if ($OutputofFindBookFunction<0) // If not, create a new Book.
            {
                $BookNumber = $NumberOfFiles; // Hold this constant for the iteration.
                $Books[$BookNumber] = new Book;
                $Books[$BookNumber]->title = $title; // Add title and basic information
                $Books[$BookNumber]->highlights[] = "- By [[".$author."]]\n- (Imported by [[Readwise2Roam]].)\n";

                $NumberOfFiles++;
            }

            $Books[$BookNumber]->highlights[] = "- ".$text."\n"; // Add the highlight.

            $NumberOfHighlights++;
        }
            
        $i++;
    }
    fclose($handle);
}

unlink("/opt/bitnami/apache2/htdocs/uploads/"."REVERSED-".$fileName.".csv");
ini_set('track_errors', 1);
$zip = new ZipArchive; //https://www.virendrachandak.com/techtalk/how-to-create-a-zip-file-using-php/

if ($zip->open("output/".$fileName.".zip", ZipArchive::CREATE) === TRUE)
{
    $i=0;
    foreach ($Books as $Book)
    {
        $zip->addFromString($Book->title.".md", implode("", $Book->highlights));
    }
}
$zip->close();

echo "<a href=\"output/".$fileName.".zip\">Download your zip file!</a>";

?>