<?php ob_start(); // buffer dell'output: header e sessione funzionano anche senza output_buffering nel php.ini ?><!-- Applicazione:eFFe Document-->
<!-- Versione: 1.5.0.0 - Licenza GPL-->
<!-- Data Rilascio: 01 Novembre 2026 (prima versione: 02 Febbraio 2010)-->
<!-- Developer: ing. Felice Pescatore-->

<?php 
include ("../../common/core/core.php");


// l'escape SQL avviene ora dentro loginOperatore()
$login=isset($_POST['login']) ? (string)$_POST['login'] : "";
$password=isset($_POST['password']) ? (string)$_POST['password'] : "";

$objCore->loginOperatore($login,$password);

	if($objCore->isLogged()){	
		echo"<script language=javascript>";
		if ($objCore->getRuoloAmministratoreId()==$objCore->getLoggedOperatoreRole())
    		echo"document.location.href='../service/service_amministratore.php'";
		else if ($objCore->getRuoloVisualizzatoreReportId()==$objCore->getLoggedOperatoreRole())
    		echo"document.location.href='../service/service_report.php'";
		else
			echo"document.location.href='../service/service_pannello.php'";
    	echo"</script>";
	} else {
		echo"<script language=javascript>";
		echo"document.location.href='../index.php?errore=true'";
		echo"</script>";
	}	
?>