<?php ob_start(); // buffer dell'output: header e sessione funzionano anche senza output_buffering nel php.ini ?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!-- Applicazione:eFFe Document-->
<!-- Versione: 1.5.0.0 - Licenza GPL-->
<!-- Data Rilascio: 01 Novembre 2026 (prima versione: 02 Febbraio 2010)-->
<!-- Developer: ing. Felice Pescatore-->

<?php
include("../../common/core/core.php");
include("../_include/adminconfig.php");

$arr = array($objCore->getRuoloAmministratoreId());
applySecurity($objCore->getLoggedOperatoreRole(), $arr, $objCore);
	
$id=$_GET['id'];
$array_servizi = mysql_fetch_array($objCore->getServizioDati($id));
if (!$array_servizi)
{		
	echo"<script language=javascript>";
	echo"document.location.href='../service/service_servizi.php'";
	echo"</script>";
}
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
<title>Amministrazione effedocument</title>
<link href="../../common/css/effecss.css?v=1.5.0-5759dd" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="../../common/script/effe-ui.js?v=1.5.0-5759dd" defer></script>

</head>
<body>
<div id="page">
<?php $menuSelezionato=11; include("../_include/bonav.php"); ?>
<div id="spazio" style="padding:7px;font-size:14px;"></div>          
<div align="center">                
 <div class="row">
 <fieldset>
   <legend><img src="../../common/images/layout/servizi.png" width="60" height="60">Modifica il nome del servizio 
    <?php if ($array_servizi['id_padre']==0) echo " (tipologia di document)";
		else echo " (sotto tipologie)";
	?>
   </legend>
   <br><br>
   <form method="post" action="">
     <input type="hidden" name="op" value="modd">
     <input type="hidden" name="idx" value="<?php echo $id;?>">
     <table width="60%">
     <tr>
       <td width="26%">Nome</td>
       <td width="74%"><input type="text" name="nome" value="<?php echo $array_servizi['nome'];?>"></td>
     </tr>
     <?php if ($array_servizi['id_padre']==0){?>

  <td>
</tr>
<tr>
  <td>Work Flow</td>
  <td><p>
    <label>
      <?php $arr_workflow=$objCore->getWorkflow();
				$index_workflow=0;
		   		while ($index_workflow<count($arr_workflow)){
					echo "<label>";
					echo "<input type=\"radio\" name=\"workflow\" value=\"".$index_workflow."\" id=\"".$arr_workflow[$index_workflow]."\""; 
	              	if  ($array_servizi['workflow']==$index_workflow) echo "checked=\"true\"";
					echo ">";
             		echo $arr_workflow[$index_workflow];
					echo "</label>";
					
					$index_workflow=$index_workflow+1;
				}
			?>
    </label>
  </td>
  <p></p>
</tr>
<?php }else  echo "<input name=\"workflow\" type=\"hidden\" value=\"0\">" ?>
<tr>
  <td></td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td></td>
  <td><input type="submit" value="Modifica"></td>
</tr>
     </table>
   </form>
   <?php
	if(isset($_POST['op']) && $_POST['op']=="modd")
	{
		$idx=$_POST['idx'];
		$nome=$_POST['nome'];
		$workflow=$_POST['workflow'];
		
		if($objCore->updateServizio($idx, $nome, $workflow)) $objCore->logWrite("aggiornamento Servizio effettuato");
		else $$objCore->logWrite("aggiornamento Servizio non effettuato");
		
		echo"<script language=javascript>";
		echo"document.location.href='../service/service_servizi.php'";
		echo"</script>";}
?>
   </center>
   </p>
 </fieldset>
 </div>
         
 </div>
<?php include("../_include/bofooter.php"); ?>
</div>
</body>
</html>