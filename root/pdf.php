<meta charset="utf-8">
<?php
$path = $_GET["url"];
$fp = fopen("$path", "r");
header("Content-type: application/pdf");
fpassthru($fp);
fclose($fp);
?>
