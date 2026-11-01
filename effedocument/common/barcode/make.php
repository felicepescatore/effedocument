<?php ob_start(); // buffer dell'output: header e sessione funzionano anche senza output_buffering nel php.ini ?><?php

if (isset($_GET['protocollo']))
{
	require('ezbarcode.php');
	$pdf = new PDF('a4','portrait');
	$pdf->selectFont('./fonts/Courier');
	$pdf->EAN13(40,700,$_GET['protocollo']);
	$pdf->stream();
}
?>
