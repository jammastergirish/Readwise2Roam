<?php

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

//Bring in the data
$ReadwiseDataFile = "readwise-data.csv";

//Reverse the file
$PreReverse = explode("\n", file_get_contents($ReadwiseDataFile));

$AllLinesInReversedList = array();

foreach(array_reverse($PreReverse) as $Line)
{ 
    $AllLinesInReversedList[] = $Line;
}

$i=0;
$NumberOfHighlights=0;
$NumberOfFiles=0;

foreach($AllLinesInReversedList as $Line)
{
    // $num = count($data); // Number of fields
    $data = str_getcsv($Line, ",");

    $text = decode_code(substr($data[0],2,-1));
    $title = decode_code(substr($data[1],2,-1));
    $author = decode_code(substr($data[2],2,-1));

    if ($title!="ok Titl") // ok Titl = substr("Book Title",2,-1) (If we're not on the header row (which will be the last))
    {
        echo "\n\n";
        $OutputofFindBookFunction = FindBook($Books, $title); // Is the book already within our data structure?

        if ($OutputofFindBookFunction<0) // If not, create a new Book.
        {
            $BookNumber = $NumberOfFiles; // Hold this constant for the iteration.
            $Books[$BookNumber] = new Book;
            $Books[$BookNumber]->title = $title; // Add title and basic information
            $Books[$BookNumber]->highlights[] = "- By [[".$author."]]\n- (Imported by [[Readwise2Roam]].)\n";

            echo "Adding book ".$title." and adding author (".$author.").\n"; 

            $NumberOfFiles++;
        }

        $Books[$BookNumber]->highlights[] = "- ".$text."\n"; // Add the highlight.
        echo "\tAdding :\n\t\t".substr($text, 0, 1000)."...\n";
        $NumberOfHighlights++;
    }
        
    $i++;
}

//Create all the MD files
$i=0;
foreach ($Books as $Book)
{
    $file = fopen($Book->title.".md", "w");
    fwrite($file, implode("", $Book->highlights));
    $i++;
}

$EndTime = microtime(TRUE);

echo "\nIn ".number_format((($EndTime-$StartTime)*1000))." milliseconds, added ".number_format($NumberOfHighlights)." highlights to ".number_format($NumberOfFiles)." markdown (.md) files, each of which corresponds to a Roam Research note";

?>