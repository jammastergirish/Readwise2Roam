<!DOCTYPE html>
<html>
<body>

<?php
function RandomString($length = 8)
{   //https://stackoverflow.com/questions/4356289/php-random-string-generator
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}
?>

<form action="readwise2roam-www.php" method="POST" enctype="multipart/form-data">
    Select your Readwise CSV:
    <input type="file" name="fileToUpload" id="fileToUpload" accept=".csv">
    <input type="hidden" name="fileName" id="fileName" value="<?php echo RandomString(8); ?>">
    <input type="submit" value="Upload Readwise CSV" name="submit">
</form>

</body>
</html>