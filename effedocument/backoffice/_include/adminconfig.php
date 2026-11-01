<!-- Applicazione:eFFe Document-->
<!-- Versione: 1.5.0.0 - Licenza GPL-->
<!-- Data Rilascio: 01 Novembre 2026 (prima versione: 02 Febbraio 2010)-->
<!-- Developer: ing. Felice Pescatore-->

<?php 
	function applySecurity($ruolo, $livelli_richiesti, $objCore)
	{
		if(!$objCore->isLogged())
		{
			echo"<script language=javascript>";
			echo"document.location.href='index.php?errore=true'";
			echo"</script>";
		}else{
			$autorizzato=false;
					
			for ($i=0; $i<count($livelli_richiesti); $i++)
				if ($livelli_richiesti[$i]==$ruolo) $autorizzato=true;

			if (!$autorizzato)			
			{
				echo"<script language=javascript>";
				echo"document.location.href='index.php?errore=true'";
				echo"</script>";
			}
		}
	}
	
	// Menu principale del backoffice: le voci dipendono dal ruolo dell'operatore
	function createMenu($objCore, $selected, $ruolo){
		$voci = array();
		if ($ruolo==$objCore->getRuoloAmministratoreId()){
			$voci[] = array(1,  "service_amministratore.php", "Home");
			$voci[] = array(11, "service_servizi.php", "Servizi");
			$voci[] = array(12, "service_uffici.php", "Uffici");
			$voci[] = array(4,  "service_configurazioni.php", "Configurazioni");
			$voci[] = array(5,  "service_utenti.php", "Utenti");
			$voci[] = array(6,  "service_operatori.php", "Operatori");
		}
		if ($ruolo==$objCore->getRuoloResponsabileId() || $ruolo==$objCore->getRuoloCollaboratoreId() || $ruolo==$objCore->getRuoloProtocollatoreId() || $ruolo==$objCore->getRuoloSupervisoreId()){
			$voci[] = array(1, "service_pannello.php", "Pannello");
			$voci[] = array(2, "service_ricerca.php", "Ricerca");
		}
		if ($ruolo==$objCore->getRuoloProtocollatoreId()){
			$voci[] = array(3,  "service_protocolla.php?tipo=0", "Protocollo in ingresso");
			$voci[] = array(31, "service_protocolla.php?tipo=1", "Protocollo in uscita");
		}
		if ($ruolo==$objCore->getRuoloVisualizzatoreReportId())
			$voci[] = array(1, "service_report.php", "Report");

		echo "<nav class=\"nav\" id=\"menu\" aria-label=\"Menu principale\"><ul>";
		foreach ($voci as $v){
			$attuale = ($v[0]==$selected) ? " class=\"sel\"" : "";
			$aria = ($v[0]==$selected) ? " aria-current=\"page\"" : "";
			echo "<li".$attuale."><a href=\"../service/".$v[1]."\"".$aria.">".$v[2]."</a></li>";
		}
		echo "</ul></nav>";
	}

	// Pagina iniziale dell'operatore, in base al ruolo
	function paginaIniziale($objCore, $ruolo){
		if ($ruolo==$objCore->getRuoloAmministratoreId()) return "../service/service_amministratore.php";
		if ($ruolo==$objCore->getRuoloVisualizzatoreReportId()) return "../service/service_report.php";
		return "../service/service_pannello.php";
	}

?>