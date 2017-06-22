<!-- Applicazione:eFFe Document-->
<!-- Versione: 1.0.0.0 - Licenza GPL-->
<!-- Data Rilascio: 02 Febbraio 2010-->
<!-- Developer: ing. Felice Pescatore-->

<?php 
	include ("../../common/core/core.php");
	// Desetta tutte le variabili di sessione.
	session_unset();
	// Infine , distrugge la sessione.
	$_SESSION = Array();
	
	echo"<script language=javascript>";
	echo"document.location.href='../index.php'";
	echo"</script>>";
?>