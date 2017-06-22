<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
include("../../common/core/core.php");

$image_page="document_open.png";
?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	<title>EffE Document - DocWizard 3</title>
	<script language="JavaScript" src="../../common/script/ts_picker.js"></script>
	<script src="../../common/script/validation.js" language="JavaScript"></script>
	<script src="../../common/script/effescript.js" language="JavaScript"></script>
	<link rel="stylesheet" type="text/css" media="all" href="../../common/css/effecss.css" />    
</head>
<body">
<div id="wrapper">
  <h1>
   	<?php $level=2 ?>
	<?php include("../include/foheader.php"); ?>
  </h1>
</div>
<div id="wrapper">
    	<div id="secWrapper">
       	  <div id="container" class="clearfix">
       	    <center>
       	      <table width="830" border="0" cellspacing="0" cellpadding="0">
       	        <tr>
       	          <td colspan="2"><div class="qbtitle">
       	            <div align="left">Doc Wizard, fase 3: conferma</div>
     	            </div></td>
   	            </tr>
       	        <tr>
       	          <td colspan="2" valign="top"><br />
       	            <fieldset class="swiftfieldset">
       	              <legend>Dettagli </legend>
       	              <div align="center">
       	                <p>
       	                  <?php
    if(isset($_POST['op']) && $_POST['op']=="ins"){
		//cattura i dati dal modulo
		$id_servizio =$_POST['id_servizio'];
		$id_ufficio=$_POST['id_ufficio'];

		$cognome=checkText($_POST['cognome']);
		$nome=checkText($_POST['nome']);
		$telefono=$_POST['telefono'];
		$email=$_POST['email'];
		
		$oggetto =checkText($_POST['oggetto']);
		$data_protocollazione= date("j/n/Y");

		//Calcolo il nuovo protocollo
		$nuovo_protocollo=$objCore->creaNuovoProtocollo(1);

		
		//Aggiungo il richiedente nel DB se non presente
		if (!$objCore->isInDatabase($email))
			!$objCore->insertUtenti($nome, $cognome, $email, $telefono);
		
		//Recupero l'id dell'utente
		$id_utente = $objCore->getUtenteId($email);
		
		//Ricavo il nome del file
		if ($_FILES['file1']['name'] !="")
			$nome_file=$objCore->getNuovoProtocolloCompletoUfficio($nuovo_protocollo,$id_ufficio)."_".$_FILES['file1']['name'];
		else $nome_file="";
		
		//Inserisco la richiesta
		$ultimoid = $objCore->insertDocument($id_ufficio, $id_servizio, $id_utente, 1, $nuovo_protocollo, 0, '', '', $oggetto, $nome_file, $data_protocollazione);

		//Eseguo l'upload dell'eventuale file inserito
		if ($nome_file!="") upload($_FILES['file1'],  getDocumentiUploadDir(),$nome_file);
		
		if($ultimoid){
			//assegno il document all'utente responsabile d'area
			$utente_assegnatario =  $objCore->getResponsabileServizio($id_servizio);
			
			if ($utente_assegnatario!=-1)
				$result_insert = $objCore->insertDocumentAssegnatario ($ultimoid,$utente_assegnatario,$objCore->getStatoAssegnato(),'','', $data_protocollazione);
			else
				$result_insert = $objCore->insertDocumentAssegnatario ($ultimoid,$utente_assegnatario,$objCore->getStatoIniziale(),'','', $data_protocollazione);			

			echo"<table border=\"0\" cellpadding=\"3\" cellspacing=\"1\" width=\"100%\">";
			echo"<tr class=\"errorbox\">";
			echo"<td width=\"16\" align=\"left\" valign=\"middle\"><img src=\"../../common/images/icon/info.gif\" border=\"0\" />";
			echo"</td>";
			echo"<td align=\"middle\">";
			echo"<span class=\"smalltext\">Documento inserito con successo</span>";
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
			echo"<span class=\"smalltext\">Documento non iserito, vi preghiamo di riprovare o contattarci telefonicamente</span>";
			echo"</td>";
			echo"</tr>";
			echo"</table>";
		}
	}
	?>
   	                    </p>
       	                <p>&nbsp;</p>
       	                <table width="80%" border="0">
       	                  <tr>
       	                    <td align="center"><a href="javascript:apri('protocollo','../../common/barcode/make.php?protocollo=<?php echo $objCore->getProtocolloNumerico($objCore->getProtocolloCompleto($ultimoid))?>',500,600)"><img src="../../common/images/icon/barcode.png" width="97" height="48" /></a></td>
   	                      </tr>
       	                  <tr>
       	                    <td align="center"><a href="javascript:apri('protocollo','../../common/barcode/make.php?protocollo=<?php echo $objCore->getProtocolloNumerico($objCore->getProtocolloCompleto($ultimoid))?>',500,600)">genera codice a barre</a></td>
   	                      </tr>
   	                    </table>
   	                  </div>
   	                </fieldset></td>
   	            </tr>
   	          </table>
       	    </center>
       	  </div>
          <?php include("../include/folfooter.php"); ?>
  </div>
</div>
</body>
</html>
