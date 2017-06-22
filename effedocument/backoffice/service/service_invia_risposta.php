<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!-- Applicazione:eFFe Document-->
<!-- Versione: 1.0.0.0 - Licenza GPL-->
<!-- Data Rilascio: 02 Febbraio 2010-->
<!-- Developer: ing. Felice Pescatore-->

<?php
include("../../common/core/core.php");
include("../_include/adminconfig.php");

$arr = array($objCore->getRuoloCollaboratoreId(),$objCore->getRuoloResponsabileId(),$objCore->getRuoloProtocollatoreId());
applySecurity($objCore->getLoggedOperatoreRole(), $arr, $objCore);
	
$iddocument=$_GET['id'];
?>

<?php
if ($_POST['action']=="send"){
	require("../_mail/Mail.php");
	require("../_mail/AttachmentMail.php");
	require("../_mail/Multipart.php");
	

    $array_document = 		$objCore->getDocument($iddocument);
	$array_utente=			$objCore->getUtente($array_document[id_utente]);
	$array_assegnatario= 	mysql_fetch_array($objCore->getDocumentAss($iddocument));
	$array_operatore=		$objCore->getOperatore($array_assegnatario[id_operatore]);
	$array_risposta=		$objCore->getDocumentRispostaApprovata($iddocument);

	// Preparazione dei parametri dell'email
	echo "TO:".$array_utente[email];
	$to=$array_utente[email];
	$from="equitaliapolis@equitaliapolis.com";
	$addCC = $array_operatore[email];
	$msgOK = "Invio Corretto";
	$msgFAILED = "Invio Fallito";
	$subject = "Risposta Equitalia relativa al Documento:".$objCore->getProtocolloCompleto($array_document['id']);
	$message = $array_risposta[testo];

	

	//$mp1 = new Multipart("..\\..\\".getDocumentiUploadDir().$array_risposta[allegato]);
	if ($array_risposta[allegato]!=""){
		$mail = new AttachmentMail($to, $subject, "", $from);
		$mp1 = new Multipart("..\\".getDocumentiUploadDir().$array_risposta[allegato]);
		$mail->addAttachment($mp1);	
		echo "con allegato";
	}else $mail = new Mail($to, $subject, "", $from);
	
	$mail->addCC($addCC);
	$mail->setBodyHtml("<h1>".$message."</h1>");
	$mail->setPriority(AbstractMail::HIGH_PRIORITY);
	if ($mail->send())
		$message=$msgOK;
	else
		$message=$msgFAILED;
		
			echo"<script language=javascript>";
			$_SESSION['message_to_show']=$message;
			echo"document.location.href='service_message.php'";
			echo"</script>";
					
}
?>
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
createMenu($objCore,0, $objCore->getLoggedOperatoreRole());
?>
</div>
<div id="spazio" style="padding:7px;font-size:14px;"></div>
<div align="center">                
          <div class="row">
            <p><?php	
						if(strlen($iddocument)>0) $array = $objCore->getDocument($iddocument);
						if(strlen($iddocument)>0) $array_risposta = $objCore->getDocumentRispostaApprovata($iddocument);

						echo "<b><fieldset><legend><img src=\"images/document.png\" width=\"60\" height=\"60\"> Documento: ".$objCore->getProtocolloCompleto($array['id'])." [".visualizzaDataEuro($array['data'])."]</legend></b><br>";
						echo "&nbsp;&nbsp;Risposta:&nbsp;  (".visualizzaDataEuro($array_risposta[data_risposta]).") ";
						echo "<br>&nbsp;&nbsp;===============================<br>";
						echo $array_risposta[testo]."<br><br>";
						echo "&nbsp;&nbsp;Nota del Responsabile:&nbsp; (".visualizzaDataEuro($array_risposta[data_nota]).") ";
						echo "<br>&nbsp;&nbsp;===============================<br>";
						echo $array_risposta[nota_responsabile]."<br><br>";			

						echo "<br>&nbsp;&nbsp;=============allegato=================<br>";
						echo "<a href=..\\".getDocumentiUploadDir().$array_risposta[allegato].">".$array_risposta[allegato]."</a>";


					?>
            <form name="form1" method="post" action="service_invia_risposta.php?id=<?php echo $iddocument?>">
              <label>
              <input type="submit" name="button" id="button" value="Invia">
              </label>
              <input name="action" type="hidden" id="action" value="send">
            </form>
            <p>
    </div>
    <div class="row">&nbsp;</div>
                <div class="row"><?php include("../_include/bofooter.php");?></div>        </div>
</div>

</body>
</html>