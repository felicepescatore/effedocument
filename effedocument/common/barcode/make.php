<?php

if (isset($_GET['protocollo']))
{
	require('ezbarcode.php');
	$pdf = new PDF('a4','portrait');
	$pdf->selectFont('./fonts/Courier');
	$pdf->EAN13(40,700,$_GET['protocollo']);
	$pdf->stream();
}
?>
