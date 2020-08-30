<?php
ob_start( 'ob_gzhandler' );

$iPod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
$iPhone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
$iPad = strpos($_SERVER['HTTP_USER_AGENT'],"iPad");
$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");

if($iPad||$iPhone||$iPod||$android)
{
    $mobile = true;
}
else
{
    $mobile = false;
}
?>
<html>
<head>
<title>Readwise2Roam</title>
<meta name="google-site-verification" content="rYMpfHzwDgKFYC4oQUIpzbQJiMUoz0grMtsFq7SzDC4" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" 
      type="image/png" 
      href="https://www.readwise2roam.com/favicon.png">
</script>
<style>
<?php
require_once(__DIR__."/style.php");
?>
* {
  box-sizing: border-box;
}

.row {
  display: flex;
}

.column {
  padding: 10px;
}
</style>
</head>
<body>
<CENTER>

<br><br>
<a href="/"><img src="logo.png" width=400 height=70 alt="Readwise2Roam"></a><br><br><br><br>

<?php

require_once 'vendor/autoload.php';  
  
use Google\Cloud\Storage\StorageClient;

$ProjectID = "readwise2roam-1";

$client = new StorageClient(['projectId' => $ProjectID]);
$client->registerStreamWrapper();

// foreach ($client->buckets() as $bucket) {
//     printf('Bucket: %s' . PHP_EOL, $bucket->name());
// }

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



// https://www.w3schools.com/php/php_file_upload.asp
$target_dir = "gs://".$ProjectID.".appspot.com/";

$fileName = $_POST['fileName'];

$target_file = $target_dir.$fileName.".csv";

$uploadOk = true;

if(isset($_POST["submit"]))
{
    if ($_FILES["fileToUpload"]["size"] > 20000000)
    {
        $error = "Your file is greater than 20 MB. Perhaps either break it down or run the code on your own machine.";
        $uploadOk = false;
    }
    
    // if((strtolower(pathinfo($target_file,PATHINFO_EXTENSION))!="csv")||$_FILES["fileToUpload"]["type"]!="text/csv")
    // {
    //     $error = "Only CSV files are allowed.";
    //     $uploadOk = false;
    // }
    
    if (!$uploadOk)
    {
        echo "<p><font color=red>".$error."</font></p>";
    
    }
    else
    {
        if (!move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
        {
            $error = "There was an error uploading your file.";
        }
        else
        {
            $StartTime = microtime(TRUE);

            //Bring in the data
            $ReadwiseDataFile = $target_file;

            //Reverse the file
            $PreReverse = explode("\n", file_get_contents($ReadwiseDataFile));

            unlink($ReadwiseDataFile);

            $AllLinesInReversedList = array();

            foreach(array_reverse($PreReverse) as $Line)
            { 
                $AllLinesInReversedList[] = $Line;
            }

            //unlink($ReadwiseDataFile);     
            
            $i=0;
            $NumberOfHighlights=0;
            $NumberOfFiles=0;

            foreach($AllLinesInReversedList as $Line)
            {
                // $num = count($data); // Number of fields
                $data = str_getcsv($Line, ",");

                $text = decode_code(substr($data[0],0));
                $title = decode_code(substr($data[1],0));
                $author = decode_code(substr($data[2],0));

                if ($title!="Book Title") // If not in header row
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

            //ISSUE AND FIX IN test.php
            $dir = sys_get_temp_dir();
            $tmp = tempnam($dir, $fileName.".zip");

            $zip = new ZipArchive; 
            $zip->open($tmp,ZipArchive::CREATE);
            foreach ($Books as $Book)
            {
                $zip->addFromString($Book->title.".md", implode("", $Book->highlights));
            }
            $zip->close();

            copy($tmp, "gs://".$ProjectID.".appspot.com/".$fileName.".zip");

            $EndTime = microtime(TRUE);

            echo "<p>Added ".number_format($NumberOfHighlights)." highlights from ".number_format($NumberOfFiles)." books (in just ".number_format((($EndTime-$StartTime)*1000))." milliseconds)!";
            echo "<br><br><br><br>";
            echo "<a href=\"https://storage.googleapis.com/".$ProjectID.".appspot.com/".$fileName.".zip\" class=\"btn-primary\">Download zip file!</a>";
            echo "<br><br><br><br>";
            echo "Unzip the file, go to <a href=\"https://www.roamresearch.com\">Roam</a>, click the three dots on the top right, press \"Import\" and select the books you'd like to import.</p>";
        }
    }
}

echo "<br><br>";

include("footer.php");
?>