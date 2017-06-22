<!-- Applicazione:eFFe Document-->
<!-- Versione: 1.0.0.0 - Licenza GPL-->
<!-- Data Rilascio: 02 Febbraio 2010-->
<!-- Developer: ing. Felice Pescatore-->

<?php 
include ("../../common/core/core.php");


$login=mysql_escape_string($_POST['login']);
$password=mysql_escape_string($_POST['password']);

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