<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!-- Applicazione:eFFe Document-->
<!-- Versione: 1.0.0.0 - Licenza GPL-->
<!-- Data Rilascio: 02 Febbraio 2010-->
<!-- Developer: ing. Felice Pescatore-->

<?php
include("../../common/core/core.php");
include("../_include/adminconfig.php");

$arr = array($objCore->getRuoloResponsabileId(), $objCore->getRuoloProtocollatoreId());
applySecurity($objCore->getLoggedOperatoreRole(), $arr, $objCore);
	
if (isset($_GET['id'])) $id=$_GET['id'];
else $id="";
if (isset($_GET['id_servizio'])) $id_servizio=$_GET['id_servizio'];
else $id_servizio="";
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
<title>Amministrazione effedocument</title>
<link href="../../common/css/effecss.css" rel="stylesheet">

  <script language="JavaScript">
  function invia(){
  	document.formData.op.value="";
 	document.formData.action = "modifica_document_servizio.php?id="+<?php echo $id?>+"&id_servizio="+<?php echo $id_servizio?>;
    document.formData.submit();
   	}
		
  </script> 
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
<div id="spazio" style="padding:7px;font-size:14px;"></div>
<div align="center">                
	<div class="row"><fieldset><legend></legend>
<form action="modifica_document_servizio.php" method="post" name="formData" id="formData">
<input type="hidden" name="op" value="modd">
<input type="hidden" name="idx" value="<?php echo $id;?>">
<table width="60%">
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td width="49%">Servizio di competenza del Documento Attuale:</td>
  <td width="51%"><B><?php echo $objCore->getServizioNome($id_servizio)?></B></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>Tipologia di Richiesta</td>
  <td><select name="tipologia" size="1" id="tipologia" onChange="invia()">
    <?php
		echo "<option value=\"-1\">[seleziona la tipologia di richiesta]</option>"; 
		$result=$objCore->getTipologieAttive();
		while($array_tipologie=mysql_fetch_array($result)){
			echo "<option value=\"".$array_tipologie['id']."\"";
				if (isset($_POST['tipologia']) && $_POST['tipologia']==$array_tipologie['id']) echo " selected=true";
			echo">".$array_tipologie['nome']."</option>";
		}
	?>
  </select></td>
  <?php if (isset($_POST['tipologia']) && $_POST['tipologia'] !=-1 && $_POST['tipologia'] !="") { ?> 
  <tr>
    <td>Servizio:</td>
    <td><select name="servizio" size="1" id="servizio" onChange="invia()">
        <?php 
		echo "<option value=\"-1\">[seleziona il servizio]</option>"; 
		$result=$objCore->getServiziAttivi($_POST['tipologia']);
		while($array_servizi=mysql_fetch_array($result)){
			echo "<option value=\"".$array_servizi['id']."\"";
				if (isset($_POST['servizio']) && $_POST['servizio']==$array_servizi['id']) echo " selected=true";
			echo">".$array_servizi['nome']."</option>";
		}
	?>
    </select></td>
  </tr>
  <?php } ?>
<tr>
<tr>
  <td></td>
  <td>&nbsp;</td>
</tr>
<tr><td></td><td>
  <?php if ((isset($_POST['tipologia']) && isset($_POST['servizio'])) && $_POST['servizio'] !=-1 && $_POST['servizio'] !="" && $_POST['tipologia'] !=-1 && $_POST['tipologia'] !="")
		echo "<input type=\"submit\" value=\"Modifica\">";
	else echo "<input type=\"submit\" value=\"Modifica\" disabled>";
?>  
</td></tr>
</table>
</form></fieldset>
<?php
	if(isset($_POST['op']) && $_POST['op']=="modd"){
	echo "Modifico";
		$idx=$_POST['idx'];
		$idx_servizio=$_POST['servizio'];
		$dati=$objCore->updateDocumentoServizio($idx, $idx_servizio);
		$data= date("j/n/Y");
		
		//assegno il document all'utente responsabile d'area
		$utente_assegnatario =  $objCore->getResponsabileServizio($idx_servizio);
		
		if ($utente_assegnatario==-1) $stato=$objCore->getStatoIniziale();
		else if ($objCore->getLoggedOperatoreRole() == $objCore->getRuoloProtocollatoreId())
			$stato=$objCore->getStatoAssegnato();
		else
			$stato=$objCore->getStatoAttuale($idx);
			
		if($objCore->insertDocumentAssegnatario($idx,$utente_assegnatario,$stato,"","",$data)) $objCore->logWrite("modifica del Sevizio associato al documento effettuata");
		else  $objCore->logWrite("modifica del Sevizio associato al documento non effettuata");
		
		echo"<script language=javascript>";
		echo"document.location.href='../service/service_pannello.php'";
		echo"</script>";}
	?>
</center>
                 </p>
                </div>
                <div class="row">&nbsp;</div>
                <div class="row"><?php include("../_include/bofooter.php");?></div>
                        </div>
</div>
</body>
</html>