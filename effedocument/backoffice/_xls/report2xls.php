<?php
include ("../../common/core/core.php");
include("../_include/adminconfig.php");
?>
<?php
	$arr = array($objCore->getRuoloVisualizzatoreReportId());
	applySecurity($objCore->getLoggedOperatoreRole(), $arr, $objCore);
?>
<?php
   $filename="sheet.xls";
   header ("Content-Type: application/vnd.ms-excel");
   header ("Content-Disposition: inline; filename=$filename");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang=it><head>
<title>Titolo</title></head>
<body>
<table border="1">
<?php
echo $_POST['hiddenXLS'];
?>
</table>
</body></html>