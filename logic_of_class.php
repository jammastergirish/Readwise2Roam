<?php

class Book
{
    public $title;
    public $highlights;
}

function FindBook($Books, $TitleThatIAmLookingFor)
{
    $j=0;
    while ($j<count($Books))
    {
        if ($Books[$j]->title==$TitleThatIAmLookingFor)
        {
            $NumberThatIWant = $j;   
        }
        $j++;
    }
    return $NumberThatIWant;
}

$i=0;

$Books[$i] = new Book();
$Books[$i]->title = "Title of book ".$i;
$Books[$i]->highlights[] = "Highlight 1\n";

$Books[$i]->highlights[] = "Highlight 2\n";

$Books[$i]->highlights[] = "Highlight 3\n";

$i=1;

$Books[$i] = new Book();
$Books[$i]->title = "Title of book ".$i;
$Books[$i]->highlights[] = "Highlight 1a\n";

$Books[$i]->highlights[] = "Highlight 2a\n";

$Books[$i]->highlights[] = "Highlight 3a\n";



// $j=0;
// while ($j<count($Books))
// {
//     if ($Books[$j]->title==$TitleThatIAmLookingFor)
//     {
//         $NumberThatIWant = $j;   
//     }
//     $j++;
// }

$Books[FindBook($Books, "Title of book 0")]->highlights[] = "Highlight 4a\n";





$i=0;
foreach ($Books as $Book)
{
    echo "<b>".$Book->title."</b>\n";
    foreach ($Book->highlights as $Highlight)
    {
        echo $Highlight."\n";
    }
    $i++;
}

?>