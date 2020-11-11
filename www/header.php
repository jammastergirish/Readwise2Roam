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

<table border="0" cellpadding="4" cellspacing="0" style="table-layout:fixed" width=700 align=center>
<tr>
<td bgcolor="lightgrey" width="100" valign="top" align="center">
<font face=verdana size=1><p align=justify>There's no longer any need to use Readwise2Roam as Readwise have built their own <a href="https://help.readwise.io/article/71-how-does-the-readwise-to-roam-export-integration-work">plugin</a>! Please use that instead. Thank you everybody who supported Readwise2Roam in the interim.<br><br><p align=right><i><a href="https://www.girishgupta.com/"><font color=black>Girish Gupta</font></a></i></p></p></font>
</td>
</tr>
</table>

<br><br>
<a href="/"><img src="logo.png" width=400 height=70 alt="Readwise2Roam"></a><br><br><br><br>