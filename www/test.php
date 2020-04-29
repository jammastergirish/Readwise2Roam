<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$ProjectID = "readwise2roam-1";

require_once 'vendor/autoload.php';  
  
use Google\Cloud\Storage\StorageClient;

$client = new StorageClient(['projectId' => $ProjectID]);
$client->registerStreamWrapper();

// $zip = new ZipArchive;
// if ($zip->open("gs://".$ProjectID.".appspot.com/tests/test.zip", ZipArchive::CREATE) === TRUE)
// {
//     echo "Opened zip file.<br><br>";
//     $zip->addFromString("test.txt", "Tetgdfgdgfgd fg sdf gsdf ");
// }
// $zip->close();

// Thanks to John at the Hunger Project! https://issuetracker.google.com/issues/35897760
$fname = "test.zip";

$dir = sys_get_temp_dir();
$tmp = tempnam($dir, $fname);

$zip = new ZipArchive; 
$zip->open($tmp,ZipArchive::CREATE);
$zip->addFromString("test1.txt", "Contents of 1.");
$zip->addFromString("test2.txt", "Contents of 2.");
$zip->close();

copy($tmp, "gs://".$ProjectID.".appspot.com/tests/".$fname);


?>

