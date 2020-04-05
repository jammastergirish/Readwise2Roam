<?php

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
$PreReverseFile = explode("\n",file_get_contents($ReadwiseDataFile));

$ReverseFile = fopen("REVERSED-".$ReadwiseDataFile, "w");

foreach(array_reverse($PreReverseFile) as $Line)
{ 
    fwrite($ReverseFile, $Line."\n");
}

$row = 0;
if (($handle = fopen("REVERSED-".$ReadwiseDataFile, "r")) !== FALSE) // Open the reversed file
{
    $i=0;
    $NumberOfHighlights=0;
    $NumberOfFiles=0;
    while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) //https://www.php.net/manual/en/function.fgetcsv.php
    {
        $num = count($data); // Number of fields
        $row++; // Row number

        $text = decode_code(substr($data[0],2,-1));
        $title = decode_code(substr($data[1],2,-1));
        $author = decode_code(substr($data[2],2,-1));

        if ($title!="ok Titl")
        {
            $filename = $title.".md";

            echo "\n\n";
            if(!file_exists($filename))
            {
                $file = fopen($filename, "w");
                fwrite($file, "- By [[".$author."]]\n");
                fwrite($file, "- (Imported by Readwise2Roam.)\n");

                echo "Creating ".$title.".md and adding author (".$author.").\n";

                $NumberOfFiles++;
            }
            else
            {
                // $file = fopen($filename, "w+"); No need to actually open the file as we're using file_put_contents() below
                echo "Opening ".$title.".md.\n";
            }

            if(strpos(file_get_contents($filename),$text) !== false) // If the highlight isn't already in the file
            {
            
            }
            else
            {
                file_put_contents($filename, "- ".$text."\n", FILE_APPEND);
                echo "\tAdding :\n\t\t".substr($text, 0, 1000)."...\n";

                $NumberOfHighlights++;
            }
        }
            
        $i++;
    }
    fclose($handle);
}

$EndTime = microtime(TRUE);

echo "\nIn ".number_format(($EndTime-$StartTime)*1000)." milliseconds, added ".number_format($NumberOfHighlights)." highlights to ".number_format($NumberOfFiles)." markdown (.md) files, each of which corresponds to a Roam Research note";

?>