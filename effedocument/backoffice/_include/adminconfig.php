<!-- Applicazione:eFFe Document-->
<!-- Versione: 1.0.0.0 - Licenza GPL-->
<!-- Data Rilascio: 02 Febbraio 2010-->
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
	
	function createMenu($objCore, $selected, $ruolo){
	  echo"<div id=\"menuTop\">";
		echo"<ul class=\"ul\">";
		  if ($ruolo==$objCore->getRuoloAmministratoreId()){
			echo"<li id=\"but1\""; if($selected==1) echo"class=\"sel\""; echo"><a href=\"..\service\service_amministratore.php\" title=\"Home\"><span>Home</span></a></li>";
			echo"<li id=\"but11\""; if($selected==11) echo"class=\"sel\""; echo"><a href=\"..\service\service_servizi.php\" title=\"Servizi\"><span>Servizi</span></a></li>";			
			echo"<li id=\"but11\""; if($selected==12) echo"class=\"sel\""; echo"><a href=\"..\service\service_uffici.php\" title=\"Uffici\"><span>Uffici</span></a></li>";			
		  }
		  if ($ruolo==$objCore->getRuoloResponsabileId() || $ruolo==$objCore->getRuoloCollaboratoreId() || $ruolo==$objCore->getRuoloProtocollatoreId() || $ruolo==$objCore->getRuoloSupervisoreId()){
			echo"<li id=\"but1\""; if($selected==1) echo"class=\"sel\""; echo"><a href=\"..\service\service_pannello.php\" title=\"Pannello\"><span>Pannello</span></a></li>";
			echo"<li id=\"but2\""; if($selected==2) echo"class=\"sel\""; echo"><a href=\"..\service\service_ricerca.php\" title=\"Ricerca\"><span>Ricerca</span></a></li>";
		  }
		  if ($ruolo==$objCore->getRuoloProtocollatoreId()){
			echo"<li id=\"but3\""; if($selected==3) echo"class=\"sel\""; echo"><a href=\"..\service\service_protocolla.php?tipo=0\" title=\"Protocollo Ingresso\"><span>Protocollo Ingresso</span></a></li>";
			echo"<li id=\"but31\""; if($selected==31) echo"class=\"sel\""; echo"><a href=\"..\service\service_protocolla.php?tipo=1\" title=\"Protocollo Uscita\"><span>Protocollo Uscita</span></a></li>";

}
		  if ($ruolo==$objCore->getRuoloAmministratoreId()){
			  echo"<li id=\"but4\""; if($selected==4) echo"class=\"sel\""; echo"><a href=\"..\service\service_configurazioni.php\" title=\"Configurazioni\"><span>Configurazioni</span></a></li>";
			  echo"<li id=\"but5\""; if($selected==5) echo"class=\"sel\""; echo"><a href=\"..\service\service_utenti.php\" title=\"Utenti\"><span>Utenti</span></a></li>";
			  echo"<li id=\"but6\""; if($selected==6) echo"class=\"sel\""; echo"><a href=\"..\service\service_operatori.php\" title=\"Operatori\"><span>Operatori</span></a></li>";
		  } 
		   if ($ruolo==$objCore->getRuoloVisualizzatoreReportId())
			echo"<li id=\"but1\" class=\"sel\"> <a href=\"..\service\service_report.php\" title=\"Report\"><span>Report</span></a></li>"; 
		echo "</ul>";
	   echo"</div>";
	 }

?>