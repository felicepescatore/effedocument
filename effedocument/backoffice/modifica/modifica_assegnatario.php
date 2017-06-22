<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!-- Applicazione:eFFe Document-->
<!-- Versione: 1.0.0.0 - Licenza GPL-->
<!-- Data Rilascio: 02 Febbraio 2010-->
<!-- Developer: ing. Felice Pescatore-->

<?php
include("../../common/core/core.php");
include("../_include/adminconfig.php");

$arr = array($objCore->getRuoloCollaboratoreId(),$objCore->getRuoloResponsabileId());
applySecurity($objCore->getLoggedOperatoreRole(), $arr, $objCore);
	
$id=$_GET['id'];
$id_servizio=$_GET['id_servizio'];	
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
createMenu($objCore,1, $objCore->getLoggedOperatoreRole());
?>
</div>
<div id="spazio" style="padding:7px;font-size:14px;"></div>
<div align="center">                
          <div class="row">
                 <p>
<form method="post" action="modifica_assegnatario.php?id=<?php echo $id;?>">
<input type="hidden" name="op" value="modd">
<table width="60%">
<tr>
  <td width="46%">Protocollo Documento:</td>
  <?php
			  $array_selected=$objCore->getDocument($id);
  ?>
  <td width="54%"><B><?php echo $objCore->getProtocolloCompleto($array_selected['id']); ?></B></td>
</tr>
<tr>
  <td>Operatore Attuale:</td>
  <td><B><?php echo $objCore->getDocumentAssNome($id)?></B></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
<?php
$result_operatori = $objCore->getCollaboratoriServizio($id_servizio);
?>
  <td>Nuovo Operatore:</td><td><select name="idx_operatore" size="1" id="idx_operatore">
    <?php
	//$result_operatori = $objCore->getCollaboratoriServizio($id_servizio);
	$numCollaboratori=0;
	while($array_operatori=mysql_fetch_array($result_operatori))
	{
		echo "<option value=\"".$array_operatori['id']."\">".$array_operatori['nome']."</option>";
		$numCollaboratori+=1;
	}
	if ($numCollaboratori==0 && $_POST['op']!="modd")
	{
		$_SESSION['message_to_show']="Nessun collaboratore esistente per il servizio specificato";
		echo"<script language=javascript>";
		echo"document.location.href='../service/service_message.php'";
		echo"</script>";
	}
	?>
    </select></td></tr>
<tr><td></td><td><input type="submit" value="Modifica"></td></tr>
</table>
</form>
<?php
	if($_POST['op']=="modd"){
		$idx=$_GET['id'];
		$idx_operatore=$_POST['idx_operatore'];
		$data= date("j/n/Y");		

		if($objCore->insertDocumentAssegnatario($idx,$idx_operatore,$objCore->getStatoAttuale($idx),"","",$data)) $objCore->logWrite("aggiornamento Assegnatario effettuato");
		else $objCore->logWrite("aggiornamento Assegnatario non effettuato");
	
		echo"<script language=javascript>";
		echo"document.location.href='../service/service_pannello.php'";
		echo"</script>";
	}
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