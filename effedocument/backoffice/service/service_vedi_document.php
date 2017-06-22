<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!-- Applicazione:eFFe Document-->
<!-- Versione: 1.0.0.0 - Licenza GPL-->
<!-- Data Rilascio: 02 Febbraio 2010-->
<!-- Developer: ing. Felice Pescatore-->

<?php
include("../../common/core/core.php");
include("../_include/adminconfig.php");

	$arr = array($objCore->getRuoloCollaboratoreId(),$objCore->getRuoloResponsabileId(),$objCore->getRuoloProtocollatoreId(),$objCore->getRuoloSupervisoreId());
	applySecurity($objCore->getLoggedOperatoreRole(), $arr, $objCore);
	
	$id=$_GET['id'];
	$id_servizio=$_GET['id_servizio'];
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
<title>Dettagli</title>
<link href="../../common/css/effecss.css" rel="stylesheet">

</head>
 <body>
<div id="page">
  <div align="center">                
           <div class="row">
					<?php
						if(strlen($id)>0) $array = $objCore->getDocument($id);

						$result_ass = $objCore->getDocumentAss($id);
						echo "<b><fieldset><legend><img src=\"../../common/images/icon/doc_identita.gif\"> Documento: ".$objCore->getProtocolloCompleto($array['id'])." [".visualizzaDataEuro($array['data'])."]</legend></b><br>";
						echo "&nbsp;&nbsp;oggetto:&nbsp;<textarea name=\"textarea\" id=\"textarea\" cols=\"45\" rows=\"8\" enabled>".$array['oggetto']."</textarea><br>";
						echo "&nbsp;&nbsp;data di ricezione del documento dall'utente:&nbsp;<b><font color=#CCCC33>".$array['data_invio']."</b></font><br>";
						$index=$objCore->getDocumentNumFasi($id);
						while($array_ass=mysql_fetch_array($result_ass)){
							echo "<br>";
							echo "[#".$index."] Stato:&nbsp;<b><font color=#CCCC33>".$objCore->getStatoNome($array_ass['id_stato'])."</b></font><br>";
							echo "Data inizio Stato:&nbsp;<b><font color=#CCCC33>".visualizzaDataEuro($array_ass['data'])."</b></font><br>";
							//recupero l'utente
							echo "Utente:&nbsp;<b><font color=#CCCC33>".$objCore->getOperatoreNome($array_ass['id_operatore'])."</b></font><br>";
							echo "Priorita:&nbsp;<b><font color=#CCCC33>".$objCore->getPrioritaNome(calcPriorita($array['data']))."</b></font><br>";
							echo "Note:&nbsp;<b><font color=#CCCC33>".$array_ass['nota']."</b></font><br>";		
							
							echo "Allegati:&nbsp;<a href=\"..\\".getDocumentiUploadDir().$array_ass['allegato']."\"><b><font color=#00ccff>".$array_ass['allegato']."</b></font></a><br>";
							
							$risposta=$objCore->checkDocumentoRisposta($array_ass['id']);
							
							if ($risposta!=-1)
								echo "<a href=service_vedi_risposta.php?iddocument=".$id."&idrisposta=".$risposta['id'].">visualizza risposta</a><br>";			$index--;
					}
					?>
</fieldset>
            </p>
                </div>
                  <?php include("../_include/bofooter.php");?>
</body>
</html>