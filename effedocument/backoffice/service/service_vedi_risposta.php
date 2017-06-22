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
	
	$iddocument=$_GET['iddocument'];
	$idrisposta=$_GET['idrisposta'];
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
						if(strlen($iddocument)>0) $array = $objCore->getDocument($iddocument);
						if(strlen($idrisposta)>0) $array_risposta = $objCore->getDocumentRisposta($idrisposta);

						echo "<b><fieldset><legend><img src=\"../common/images/document_open.png\" width=\"60\" height=\"60\"> Documento: ".$objCore->getProtocolloCompleto($array['id'])." [".visualizzaDataEuro($array['data'])."]</legend></b><br>";
						echo "&nbsp;&nbsp;Risposta:&nbsp;  (".visualizzaDataEuro($array_risposta['data_risposta']).") ";
						echo "<br>&nbsp;&nbsp;===============================<br>";
						echo $array_risposta['testo']."<br><br>";
						echo "&nbsp;&nbsp;Nota del Responsabile:&nbsp; (".visualizzaDataEuro($array_risposta['data_nota']).") ";
						echo "<br>&nbsp;&nbsp;===============================<br>";
						echo $array_risposta['nota_responsabile']."<br><br>";					

					?>
                    <form>
					<input type="button" value="Indietro" onClick="javascript:history.back()" name="button">
						</form> 
</fieldset>
            </p>
                </div>
                  <?php include("../_include/bofooter.php");?>
</body>
</html>