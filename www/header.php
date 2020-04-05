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