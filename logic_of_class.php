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

$i=0; 
while ($i<10) // Create 10 books
{
    $Books[$i] = new Book();
    $Books[$i]->title = "Title".$i;
    $Books[$i]->highlights[] = "Highlight 1 in Book".$i."\n";
    
    $Books[$i]->highlights[] = "Highlight 2 in Book".$i."\n";
    
    $Books[$i]->highlights[] = "Highlight 3 in Book".$i."\n";

    $i++;
}


$BookTitleIAmLookingFor = "Title5"; // I'm looking for a book called "Title5"

$OutputofFindBookFunction = FindBook($Books, $BookTitleIAmLookingFor);

if ($OutputofFindBookFunction>=0) // Does the function I wrote return 0 or positive integer, meaning that the book was previously added?
{
    //book has been found so add highlight
    echo "Found it at position ".$OutputofFindBookFunction."!\n\n\n";
    $Books[$OutputofFindBookFunction]->highlights[] = "Highlight 4\n";
}
else // It returned -1, implying that book not peviously added
{
    //book not found so need to create book
    echo "Didn't find it\n\n\n";
}



//Print out all the books and their highlights in order.
$i=0;
foreach ($Books as $Book)
{
    echo $Book->title."\n";
    foreach ($Book->highlights as $Highlight)
    {
        echo $Highlight."\n";
    }
    $i++;
}

?>