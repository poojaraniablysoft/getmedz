<?php
ob_start();
session_start();
if (!isset($_SESSION['WYSIWYGFileManagerRequirements']) || !is_file($_SESSION['WYSIWYGFileManagerRequirements'])){
	die('File manager authentication not set.');
}
require_once $_SESSION['WYSIWYGFileManagerRequirements'];
$imageData = isset($_REQUEST['hidImage']) ? $_REQUEST['hidImage'] : "";
$tempPath = isset($_REQUEST['hidPath']) ? $_REQUEST['hidPath'] : "";
$filename = isset($_REQUEST['hidFile']) ? $_REQUEST['hidFile'] : "";

$root=$_SERVER["DOCUMENT_ROOT"] ; //website root

$suffix = date("Y-m-d-H-i-s");

$filenew = $tempPath . $filename . "-" . $suffix . ".png";

$fileNameWitPath = $root . $filenew;

$fp = fopen( $fileNameWitPath, 'wb' );
fwrite( $fp, base64_decode($imageData));
fclose( $fp );

echo "<html><body onload=\"parent.imageSaved('" . $filenew . "')\"></body></html>";
?>
