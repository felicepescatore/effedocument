<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!-- Applicazione:eFFe Document-->
<!-- Versione: 1.0.0.0 - Licenza GPL-->
<!-- Data Rilascio: 02 Febbraio 2010-->
<!-- Developer: ing. Felice Pescatore-->

<?php
include("../../common/core/core.php");
include("../_include/adminconfig.php");

$arr = array($objCore->getRuoloAmministratoreId());
applySecurity($objCore->getLoggedOperatoreRole(), $arr, $objCore);
	
$id=$_GET['id'];
?>
<html>
<head>
  <script language="JavaScript">
  function invia(){
  	document.formData.op.value="-1";
 	document.formData.action = "modifica_servizio_operatori.php?id=<?php echo $id ?>";
    document.formData.submit();
   	}
  </script>
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
createMenu($objCore,6, $objCore->getLoggedOperatoreRole());
?>
</div>
<div id="spazio" style="padding:7px;font-size:14px;"><a href="../inserimento/inserisci_operatori.php">Inserisci operatori</a> ||
<a href="../service/service/service_operatori.php">Vedi operatori</a></div>
<div align="center">                
          <div class="row"><fieldset><legend></legend>
          <p>
<table width="60%">
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td width="27%" valign="top">Servizi Attuali:</td>
  <td width="73%"><table width="100%" border="1" cellspacing="0" bordercolor="1">
    <tr>
      <td bgcolor="#CCCCCC">Tipologia</td>
      <td bgcolor="#CCCCCC">Servizio</td>
      <td>&nbsp;</td>
    </tr>
      <?php $array=$objCore->getServiziOperatore($id);
		for ($i=0; $i < count($array); $i++){
			echo "<tr>";
			echo "<td>".$objCore->getTipologiaNome($array[$i])."</td>";
			echo "<td>".$objCore->getServizioNome($array[$i])."</td>";
			echo "<td><a href=\"../modifica/modifica_servizio_operatori.php?op=del&id=".$id."&servizio=".$array[$i]."\">[rimuovi]</a></td>";			
			echo "</tr>";
	}
  ?>
  </table>
    <p>&nbsp;</p></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
</table>
 <form action="modifica_servizio_operatori.php" method="post" name="formData" id="formData">
<input type="hidden" name="op" value="ins">
<input type="hidden" name="idx" value="<?php echo $id;?>">
<table>
<tr>
  <td align="left" valign="top" class="row2"><span class="smalltext">Tipologia: </span></td>
  <td><select name="tipologia" size="1" id="tipologia" onChange="invia()">
    <?php echo "<option value=\"-1\">[seleziona tipologia]</option>";
				$result = $objCore->getTipologieAttive();
				while($array_tipologie=mysql_fetch_array($result)){
					echo "<option value=\"".$array_tipologie['id']."\"";
					if (isset($_POST['tipologia']) && ($array_tipologie['id']==$_POST['tipologia']) && $_POST['op']==-1) echo " selected";
					echo ">".$array_tipologie['nome']."</option>";
				}
				?>
  </select></td>
</tr>
<tr>
<?php if (isset($_POST['op']) && $_POST['op']==-1 && $_POST['tipologia']!=-1 && $_POST['tipologia']!="") {?>
  <td align="left" valign="top" class="row2"><span class="smalltext">Servizio: </span></td>
  <td><select name="servizio" size="1" id="servizio">
    <?php echo "<option value=\"-1\">[seleziona servizio]</option>";
				$result = $objCore->getServiziAttivi($_POST['tipologia']);
				while($array_tematiche=mysql_fetch_array($result)){
					echo "<option value=\"".$array_tematiche['id']."\">".$array_tematiche['nome']."</option>";
				}
				?>
  </select></td>
        <?php } ?>
</tr>

<tr>
  <td></td>
  <td>&nbsp;</td>
</tr>
<tr><td></td>
<td><input type="submit" value="Aggiungi"></td></tr>
</table>
</form>
</fieldset>
<?php
	if(isset($_POST['op']) && $_POST['op']=="ins"){
		$idx=$_POST['idx'];
		$idx_servizio=$_POST['servizio'];

		
		if($objCore->insertServizioOperatore($idx,$idx_servizio)) echo  $objCore->logWrite("modifica dell'Operatore associato al servizio effettuata");
		else echo $objCore->logWrite("modifica dell'Operatore associato al servizio non effettuata");
		
		echo"<script language=javascript>";
		echo"document.location.href='modifica_servizio_operatori.php?id=".$idx." and servizio=".$idx_servizio."'";
		echo"</script>";
	}else if(isset($_POST['op']) && $_GET['op']=="del"){
	echo "in";
		$idx=$_GET['id'];
		$idx_servizio=$_GET['servizio'];

		
		if($objCore->eliminaAssegnazioneServizio($idx,$idx_servizio)) $objCore->logWrite("aggiornamento Servizio Operatore effettuato");
		else $objCore->logWrite("aggiornamento Servizio Operatore non effettuato");
		
		echo"<script language=javascript>";
		echo"document.location.href='modifica_servizio_operatori.php?id=".$idx." and servizio=".$idx_servizio."'";
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