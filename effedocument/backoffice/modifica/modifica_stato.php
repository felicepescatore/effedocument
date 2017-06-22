<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!-- Applicazione:eFFe Document-->
<!-- Versione: 1.0.0.0 - Licenza GPL-->
<!-- Data Rilascio: 02 Febbraio 2010-->
<!-- Developer: ing. Felice Pescatore-->

<?php
include("../../common/core/core.php");
include("../_include/adminconfig.php");

$arr = array($objCore->getRuoloCollaboratoreId(),$objCore->getRuoloResponsabileId(), $objCore->getRuoloProtocollatoreId(), $objCore->getRuoloSupervisoreId());

applySecurity($objCore->getLoggedOperatoreRole(), $arr, $objCore);
	
if (isset($_GET['id'])) $id=$_GET['id'];
else if (isset($_POST['idx'])) $id=$_POST['idx'];
else $id="";

if (isset($_GET['id_stato'])) $id_stato=$_GET['id_stato'];
else if (isset($_POST['idx_stato'])) $id_stato=$_POST['idx_stato'];
else $id_stato="";

$workflow=$objCore->getDocumentWorkflow($id);

//RTE
function freeRTE_Preload($content) {
	// Strip newline characters.
	$content = str_replace(chr(10), " ", $content);
	$content = str_replace(chr(13), " ", $content);
	// Replace single quotes.
	$content = str_replace(chr(145), chr(39), $content);
	$content = str_replace(chr(146), chr(39), $content);
	// Return the result.
	return $content;
}
// Send the preloaded content to the function.
$content = freeRTE_Preload("<i>Inserisci un evenutale nota <b><br>di cambio stato</b></i>")	
?>
<html>
<head>
<script language="JavaScript" type="text/javascript" src="../_rte/html2xhtml.js"></script>
<script language="JavaScript" type="text/javascript" src="../_rte/richtext_compressed.js"></script>
<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
<title>Amministrazione effedocument</title>
<link href="../../common/css/effecss.css" rel="stylesheet">

 <style type="text/css">
<!--
.table {		border-collapse:collapse;
		border:1px solid #000000;
		width:450px;
}
.table_body {		border:1px solid #070707;
		background-color:#EBEBEB;
		font-family: Verdana, Arial, sans-serif;
		font-size: 10pt;
		color: #000000;
		padding:2px;
}
.table_footer {		border:1px solid #070707;
		background-color:#C03738;
		text-align:center;
		padding:2px;
}
.table_header {		border:1px solid #070707;
		background-color:#C03738;
		font-family: Verdana, Arial, sans-serif;
		font-size: 11pt;
		font-weight:bold;
		color: #FFFFFF;
		text-align:center;
		padding:2px;
}
.upload_info {		border:1px solid #070707;
		background-color:#EBEBEB;
		font-family: Verdana, Arial, sans-serif;
		font-size: 8pt;
		color: #000000;
		padding:4px;
}
.error_message {		font-family: Verdana, Arial, sans-serif;
		font-size: 11pt;
		color: #FF0000;
}
-->
 </style>
</head><body>
<div id="page">
<div class="row">
  <table width="100%" border="0">
    <tr>
      <td width="38%"><img src="../../common/images/loghi/effedocument_top.png" alt="logo"></td>
      <td width="62%"><div align="right">
        <?php include ("../_include/boheader.php"); ?>
      </div></td>
    </tr>
  </table>
</div>
<div id="bar1">
<?php 
createMenu($objCore,1, $objCore->getLoggedOperatoreRole());
?>
</div>
<div id="spazio" style="padding:7px;font-size:14px;"><a href="../service/service/service_pannello.php">Torna alla visualizzazione dei Documento</a></div>
<div align="center">                
	<div class="row">
                 <p>
<form action="modifica_stato.php" method="post" enctype="multipart/form-data" name="formData" id="formData" onsubmit="return submitForm();">
<input type="hidden" name="op" value="modd">
<input type="hidden" name="idx" value="<?php echo $id;?>">
<input type="hidden" name="idx_stato" value="<?php echo $id_stato;?>">
<?php //Nel caso in cui lo stato non è Predisposto, passo direttamente allo stato successivo
	if ($objCore->getStatoAttuale($id) != $objCore->getStatoPredisposto())
		echo "<input name=\"idx_stato_successivo\" type=\"hidden\" id=\"idx_stato_successivo\" value=\"".$objCore->getNextStato($workflow, $id_stato)."\">";
?>
<table width="90%">
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td width="41%"><em>Stato Attuale:</em></td>
  <td width="58%"><B><?php echo $objCore->getStatoNome($id_stato);?></B></td>
  </tr>
<tr>
  <td><em>Nuovo stato:</em></td>
  <td><?php 
		 if ($objCore->getStatoAttuale($id)==$objCore->getStatoPredisposto())
		 {
			echo "<select name=\"idx_stato_successivo\" id=\"idx_stato_successivo\">";
			echo "<option value=\"".$objCore->getStatoValidato()."\">Validato</option>";	
			echo "<option value=\"".$objCore->getStatoInLavorazione()."\">Lavorazione</option>";
			echo "</select>";			
		 }
		 else if (($objCore->getStatoAttuale($id)==$objCore->getStatoValidato()) && $workflow==$objCore->getWorkflowAvanzato())
		 {
			echo "<select name=\"idx_stato_successivo\" id=\"idx_stato_successivo\">";
			echo "<option value=\"".$objCore->getStatoAutorizzato()."\">Autorizzato</option>";	
			echo "<option value=\"".$objCore->getStatoPredisposto()."\">Predisposto</option>";
			echo "</select>";			
		 } else echo $objCore->getNextStatoNome($workflow, $id_stato)
		?></td>
  </tr>
<tr>
  <td valign="top">&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td valign="top"><em>
    <?php if ($objCore->getStatoAttuale($id) !=$objCore->getStatoInLavorazione())
  			echo "Inserisci nota del cambiamento di stato:";
		 else
		 	echo "Inserire la rispota da inoltrare al richiedente:";
	?>
  </em> </td>
  <td><script language="JavaScript" type="text/javascript">
<!--
function submitForm() {
	//make sure hidden and iframe values are in sync for all rtes before submitting form
	updateRTEs();
	return true;
}

//Usage: initRTE(imagesPath, includesPath, cssFile, genXHTML, encHTML)
initRTE("rte/images/", "rte/", "", true);
//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--
//build new richTextEditor
var rte1 = new richTextEditor('rte1');
rte1.toggleSrc = false;
rte1.cmdSpellcheck = false;
rte1.build();
//-->
</script>

</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td><div align="left"><em>Aggiungi un documento:</em></div></td>
  <td><input name="file1" type="file" id="file1" /><br /></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>
    <div align="left">
      <input type="submit" value="Modifica">
      </div></td>
</tr>
</table>
  </tr>
<tr>
  <td></td>
  </tr>
</form>
<p>
<p><?php 
	function rteSafe($strText) {
		//returns safe code for preloading in the RTE
		$tmpString = $strText;
		
		//convert all types of single quotes
		$tmpString = str_replace(chr(145), chr(39), $tmpString);
		$tmpString = str_replace(chr(146), chr(39), $tmpString);
		$tmpString = str_replace("'", "&#39;", $tmpString);
		
		//convert all types of double quotes
		$tmpString = str_replace(chr(147), chr(34), $tmpString);
		$tmpString = str_replace(chr(148), chr(34), $tmpString);
	//	$tmpString = str_replace("\"", "\"", $tmpString);
		
		//replace carriage returns & line feeds
		$tmpString = str_replace(chr(10), " ", $tmpString);
		$tmpString = str_replace(chr(13), " ", $tmpString);
		
		return $tmpString;
	}

	if(isset($_POST['op']) && $_POST['op']=="modd")
	{
		$idx=$_POST['idx'];
		$idx_stato_successivo=$_POST['idx_stato_successivo'];
		$nota_risposta=rteSafe($_POST["rte1"]);
		$id_utente_assegnatario=$objCore->getLoggedOperatoreId();
		$data= date("j/n/Y");
		$stato_pre_modifica=$objCore->getStatoAttuale($idx);
		$workflow = $objCore->getDocumentWorkflow($idx);
		
		//Eseguo l'upload del file
		$nome_file=$objCore->getProtocolloCompleto($idx)."_".$objCore->getStatoAttualeNome($idx)."_".$_FILES['file1']['name'];

		if(!upload($_FILES['file1'], "../".getDocumentiUploadDir(), $nome_file)) $nome_file="";
		
		//inserisco l'eventuale nota del responsabile relativa alla rispsota
		if ($stato_pre_modifica == $objCore->getStatoPredisposto())
		{
			$array = mysql_fetch_array($objCore->getDocumentAss($idx));
			$array_risposta= $objCore->checkDocumentoRisposta($array['id']);

			if ($array_risposta)
			{
				$objCore->insertDocumentNotaRisposta($array_risposta['id'],$nota_risposta,$data);
				$objCore->logWrite("aggiornamento della rispota effettuata");
			}else bjCore->logWrite("aggiornamento della risposta non effettuata");
			//nel caso di stato=predisposto chi opera è il responsabile ma devo riassegnarlo al collaboratore
			//eliminando l'istruzione successiva, il document viene riassegnato al reponsabile
			if ($workflow==$objCore->getWorkflowSemplice() || ($idx_stato_successivo==$objCore->getStatoInLavorazione())){
				$id_collaboratore=$objCore->getDocumentAssInLavorazione($idx);
				if ($id_collaboratore !=-1)	$id_utente_assegnatario=$id_collaboratore;
			}
			else{//Seleziono l'id del responabile per la riassegnazione nel caso il prossimo stato sia VALIDATO e il Workflow COMPLESSO
				$id_responsabile_ufficio=$objCore->getSupervisore();
				if ($id_responsabile_ufficio !=-1)	$id_utente_assegnatario=$id_responsabile_ufficio['id'];
			}
			//Seleziono l'id del responabile per la riassegnazione nel caso il prossimo stato sia PREDISPOSTO
		}else if ($idx_stato_successivo==$objCore->getStatoPredisposto()){
				$id_utente_assegnatario=$objCore->getResponsabileServizio($objCore->getServizioId($idx), $objCore->getUfficioId($idx));
		}else if ($idx_stato_successivo==$objCore->getStatoAutorizzato()){
				$id_collaboratore=$objCore->getDocumentAssInLavorazione($idx);
				if ($id_collaboratore !=-1)	$id_utente_assegnatario=$id_collaboratore;
		}

		if ($objCore->getNextStato($workflow, $stato_pre_modifica) == $objCore->getStatoPredisposto())
		{
			$ultimoid=$objCore->insertDocumentAssegnatario($idx,$id_utente_assegnatario,$idx_stato_successivo,"",$nome_file, $data);			
		
			//Aggiorno la risposta nel caso si passi allo stato PREDISPOSTO
			if($ultimoid)
			{
				$objCore->insertDocumentRisposta($idx,$ultimoid,$nota_risposta,$nome_file, $data);
				$objCore->logWrite("modifica dello stato effettuato");
			}
			else $objCore->logWrite("modifica dello stato non effettuato");
		}
		else
			$ultimoid=$objCore->insertDocumentAssegnatario($idx,$id_utente_assegnatario,$idx_stato_successivo,$nota_risposta,$nome_file, $data);	

		echo"<script language=javascript>";
		echo"document.location.href='../service/service_pannello.php'";
		echo"</script>";
	}
?></p>
</div>
                <div class="row">&nbsp;</div>
                <div class="row"><?php include("../_include/bofooter.php");?></div>        </div>
</div>
</body>
</html>