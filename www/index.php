<?php

include("header.php");

//https://philipwalton.github.io/solved-by-flexbox/demos/vertical-centering/
//https://www.w3schools.com/howto/tryit.asp?filename=tryhow_css_two_columns

?>

<?php
if (!$mobile)
{
?>
<div class="row" style="align-items: center; justify-content: center;">
  <div class="column" style="flex: 50%;">
<?php
}
?>
    <p>
    Readwise2Roam brings together two of my favorite products:
    <br><br>
    - <a href="https://www.readwise.io">Readwise</a> which syncs with Amazon Kindle, Apple Books, Instapaper and many others to bring your highlights into its database and email you a selection every morning.
    <br><br>
    - <a href="https://www.roamresearch.com">Roam Research</a> which is a note-taking app that allows all notes to be relative to each other.
    <br><br>
As soon as I started using Roam, I wanted to bring my Readwise highlights into it. So I wrote some code to do it for me—and realized I wasn't the only one who would want such a hack.
    </p>
<?php
if (!$mobile)
{
?>
  </div>
  <div class="column" style="flex: 50%;">
<?php
}
else // if $mobile
{
?>
  <br><br>
<?php
}
?>
    
<?php
function RandomString($length = 8)
{   //https://stackoverflow.com/questions/4356289/php-random-string-generator
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}
?>

<p>
    Simply upload your <a href="https://readwise.io/export">exported Readwise CSV</a>, download the ZIP file, unzip it and import the MD files into Roam!
    </p>
<br><br>
<form action="readwise2roam-www.php" method="POST" enctype="multipart/form-data">

    <input type="file" name="fileToUpload" id="fileToUpload" accept=".csv" class="text_input" required><br><br>
    <input type="hidden" name="fileName" id="fileName" value="<?php echo RandomString(8); ?>">
    <input type="submit" class="btn-primary" value="Upload Readwise CSV" name="submit">
</form>
<p><font size=1>To get your Readwise CSV, go to Readwise's <a href="https://readwise.io/export">Export Your Data</a> page and upload the file you get here.<br><br>When you've downloaded the zip file after clicking the button above, unzip that and click the three dots on the top right in <a href="https://www.roamresearch.com">Roam</a>, press "Import" and select the books you'd like to import.</font>

<?php
// if (!$mobile) // I think $mobile is being lost somewhere along the line. Either way, two non-used </div> tags on mobile isn't worst thing in the world
// {
?>
  </div>
</div>
<?php
// }
?>

<br><br>

<div class="row">
  <div class="column" style="flex: 33%;"><p><b>Security</b></p><p style="font-size: 0.8em;">This site contains no cookies, trackers or ads. Still unsure? <a href="https://github.com/jammastergirish/Readwise2Roam">Read through the code and run it on your own machine!</a></p></div>
  <div class="column" style="flex: 33%;"><p><b>About</b></p><p style="font-size: 0.8em;">Readwise2Roam was created by  <a href="https://www.girishgupta.com">Girish Gupta</a>.</p></div>
  <div class="column" style="flex: 34%;"><p><b>Support</b></p><p style="font-size: 0.8em;">If you have any questions, comments or feedback please <a href="mailto:girish@girishgupta.com">send an email</a>.</p></div>
</div> 

<?php
include("footer.php");
?>