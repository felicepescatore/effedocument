<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!-- Applicazione:eFFe Document-->
<!-- Versione: 1.0.0.0 - Licenza GPL-->
<!-- Data Rilascio: 02 Febbraio 2010-->
<!-- Developer: ing. Felice Pescatore-->

<?php
include("../../common/core/core.php");
include("../_include/adminconfig.php");

$arr = array($objCore->getRuoloProtocollatoreId());
applySecurity($objCore->getLoggedOperatoreRole(), $arr, $objCore);

if (isset($_GET['tipo'])) $tipo=$_GET['tipo'];
else $tipo=0;
?>
<script language="JavaScript" src="../../common/script/effescript.js"></script>  
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
<title>Amministrazione effedocument</title>
<link href="../../common/css/effecss.css" rel="stylesheet">
 
</head>
<body>
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
createMenu($objCore,3, $objCore->getLoggedOperatoreRole());
?>
</div>
<div id="spazio" style="padding:7px;font-size:14px;"></div>          
<div align="center">                
  <div class="row"><fieldset>
 
    <legend>
      <img src="../../common/images/layout/protocolla.png" width="60" height="60"></legend>
    <p><img src="../../common/images/extra/longmenu_right.gif" width="455"></p>
    <p>
      <?php
    if($_POST['op']=="ins"){
		//cattura i dati dal modulo
		$id_servizio =$_POST['servizio'];
		$id_ufficio=$_POST['ufficio'];
		$id_modalita_ricezione=$_POST['idx_modalita_ricezione'];
		if (isset($_POST['numero_protocollo_esterno'])) $protocollo_esterno=$_POST['numero_protocollo_esterno'];
		else $protocollo_esterno="";
		if (isset($_POST['data_invio'])) $data_invio=$_POST['data_invio'];		
		else $data_invio="";
		
		$cognome_ragionesociale=checkText($_POST['cognome']);
		$nome_ragionesociale=checkText($_POST['nome']);
		$telefono=$_POST['telefono'];
		$email=$_POST['email'];
		
		$oggetto =checkText($_POST['oggetto']);
		$data_protocollo= date("j/n/Y");


		//Calcolo il nuovo protocollo
		$nuovo_protocollo=$objCore->creaNuovoProtocollo($tipo);

		//Aggiungo il richiedente nel DB se non presente
		if (!$objCore->isInDatabase($email))
			!$objCore->insertUtenti($nome_ragionesociale, $cognome_ragionesociale, $email, $telefono);
		
		//Recupero l'id dell'utente
		$id_utente = $objCore->getUtenteId($email);

		//Ricavo il nome del file
		if ($_FILES['file1']['name'] !="")
			$nome_file=$objCore->getNuovoProtocolloCompletoUfficio($nuovo_protocollo,$id_ufficio)."_".$_FILES['file1']['name'];
		else $nome_file="";
		
		//Eseguo l'upload dell'eventuale file inserito
		if ($nome_file!="") upload($_FILES['file1'], getDocumentiUploadDir(),$nome_file);
		
		//Inserisco la richiesta
		$ultimoid = $objCore->insertDocument($id_ufficio, $id_servizio, $id_utente, $tipo, $nuovo_protocollo, $id_modalita_ricezione, $protocollo_esterno, $data_invio, $oggetto, $nome_file, $data_protocollo);

		
		if($ultimoid){
			//assegno il document all'utente responsabile d'area
			$utente_assegnatario =  $objCore->getResponsabileServizio($id_servizio, $id_ufficio);
			
			if ($utente_assegnatario!=-1)
				$result_insert = $objCore->insertDocumentAssegnatario ($ultimoid,$utente_assegnatario,$objCore->getStatoAssegnato(),'','', $data_protocollo);
			else
				$result_insert = $objCore->insertDocumentAssegnatario ($ultimoid,$utente_assegnatario,$objCore->getStatoIniziale(),'','', $data_protocollo);			

			echo"<table border=\"0\" cellpadding=\"3\" cellspacing=\"1\" width=\"100%\">";
			echo"<tr class=\"errorbox\">";
			echo"<td width=\"16\" align=\"left\" valign=\"middle\"><img src=\"../../common/images/icon/info.gif\" border=\"0\" />";
			echo"</td>";
			echo"<td align=\"middle\">";
			echo"<span class=\"smalltext\">Documento registrato con successo</span>";
			echo"</td>";
			echo"<td align=\"middle\">";
			echo"<span class=\"smalltext\">Protocollo assegnato alla richiesta: <b>".$objCore->getProtocolloCompleto($ultimoid)."</b></span>";
			echo"</td>";			
			echo"</tr>";
			echo"</table>";			
		}else{
			echo"<table border=\"0\" cellpadding=\"3\" cellspacing=\"1\" width=\"100%\">";
			echo"<tr class=\"errorbox\">";
			echo"<td width=\"16\" align=\"left\" valign=\"middle\"><img src=\"../../common/images/icon/icon_error.gif\" border=\"0\" />";
			echo"</td>";
			echo"<td align=\"left\">";
			echo"<span class=\"smalltext\">Documento non registrato, vi preghiamo di riprovare o contattarci telefonicamente</span>";
			echo"</td>";
			echo"</tr>";
			echo"</table>";
		}

	}
	?>
    </p>
    <table width="80%" border="0" align="center">
      <tr>
        <td align="center"><a href="javascript:apri('protocollo','../common/barcode/make.php?protocollo=<?php echo $objCore->getProtocolloNumerico($objCore->getProtocolloCompleto($ultimoid))?>',500,600)"><img src="../../common/images/icon/barcode.png" width="97" height="48"></a></td>
      </tr>
      <tr>
        <td align="center"><a href="javascript:apri('protocollo','../common/barcode/make.php?protocollo=<?php echo $objCore->getProtocolloNumerico($objCore->getProtocolloCompleto($ultimoid))?>',500,600)">genera codice a barre</a></td>
      </tr>
      </table>
  </fieldset>
 </p>
    
    </fieldset>
                <div class="row"><br><?php include("../_include/bofooter.php");?></div>        </div>
</div>
</body>
</html>