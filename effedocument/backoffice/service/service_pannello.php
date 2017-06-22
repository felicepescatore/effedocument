<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!-- Applicazione:eFFe Document-->
<!-- Versione: 1.0.0.0 - Licenza GPL-->
<!-- Data Rilascio: 02 Febbraio 2010-->
<!-- Developer: ing. Felice Pescatore-->

<?php
include ("../../common/core/core.php");
include("../_include/adminconfig.php");

	$arr = array($objCore->getRuoloCollaboratoreId(),$objCore->getRuoloResponsabileId(),$objCore->getRuoloProtocollatoreId(), $objCore->getRuoloSupervisoreId());
	applySecurity($objCore->getLoggedOperatoreRole(), $arr, $objCore);

	if (isset($_GET['ingressouscita'])) $ingressouscita=$_GET['ingressouscita'];
	else $ingressouscita="";
	if (isset($_GET['tipologia'])) $tipologia=$_GET['tipologia'];
	else $tipologia="";
	if (isset($_GET['servizio'])) $servizio=$_GET['servizio'];
	else $servizio="";
	if (isset($_GET['priorita'])) $priorita=$_GET['priorita'];
	else $priorita="";
	if (isset($_GET['operatore'])) $operatore=$_GET['operatore'];
	else $operatore="";
	
?>

<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
<title>Amministrazione effedocument</title>
<link href="../../common/css/effecss.css" rel="stylesheet">

<script language="JavaScript" src="../../common/script/effescript.js"></script>  
   <script language="JavaScript">
  function invia_ingressouscita(){
	document.location.href = "service_pannello.php?ingressouscita="+document.filter.ingressouscita.value;
   	}
	function invia_priorita(){
	document.location.href = "service_pannello.php?priorita="+document.filter.priorita.value;
   	}
   function invia_operatore(){
	document.location.href = "service_pannello.php?operatore="+document.filter.operatore.value;
   	}
  function invia_tipologia(){
	document.location.href = "service_pannello.php?tipologia="+document.filter.tipologia.value;
   	}
   function invia_servizio(){
	document.location.href = "service_pannello.php?tipologia="+document.filter.tipologia.value+"&servizio="+document.filter.servizio.value;
   	}
  </script>
   <style type="text/css">
<!--
.Stile2 {
	color: #999999;
	font-style: italic;
}
-->
   </style>
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
  <div></div>
  <div id="bar1">
<?php 
createMenu($objCore,1, $objCore->getLoggedOperatoreRole());
?>
</div>
  <span class="Stile2">in grigio scuro vengono evidenziati i document chiusi</span>  
<div id="spazio" style="padding:7px;font-size:14px;"></div>
<div align="center">
    <div class="row">
    <fieldset>
    <legend><img src="../../common/images/layout/pannello.png" width="60" height="60">Gestione dei Documento di competenza</legend>
    <p>
      <?php
					$numperpag=30;
					if (empty( $minimo)){
						$minimo = 0;
					}
					?>
</p>
    <p><img src="../../common/images/extra/longmenu_right.gif" width="455"></p>
<table>
                   <tr>
                     <td>
                     <form name="filter" id="filter">
                           <a href="service_pannello.php">Tutti</a> | Filtra per 
                            <select name="ingressouscita" size="1" id="ingressouscita" onChange="invia_ingressouscita()">
                           <option name="ingressouscita" value="-1" id="tipologia">[ingresso/uscita]</option>
                           <option value="0" <?php if ($ingressouscita==0) echo "selected" ?>>ingresso</option>
                           <option value="1" <?php if ($ingressouscita==1) echo "selected" ?>>uscita</option>

                           </select>
||||
				   <?php if ($objCore->getLoggedOperatoreRole()==$objCore->getRuoloProtocollatoreId()) {?>
                           <select name="tipologia" size="1" id="tipologia" onChange="invia_tipologia()">
                           <option name="tipologia" value="-1" id="tipologia">[tipologia]</option>
                             <?php
								$dati=$objCore->getTipologieAttive();
								while($array=mysql_fetch_array($dati)){
									echo"<option value=\"".$array['id']."\"";
									if ($array['id']==$tipologia) echo "selected ";
									echo ">".$array['nome']."</option>";
								 }
    			             ?>
                           </select>
                           <?php if (!empty($tipologia)){?>
                           <select name="servizio" size="1" id="servizio" onChange="invia_servizio()">
                           <option name="servizio" value="-1" id="servizio">[servizio]</option>
                             <?php echo"<option value=\"-1\">Tutte</option>";
								$dati=$objCore->getServiziAttivi($tipologia);
								while($array=mysql_fetch_array($dati)){
									echo"<option value=\"".$array['id']."\"";
									if ($array['id']==$servizio) echo "selected ";
									echo ">".$array['nome']."</option>";
								}
                 			?>
                           </select>
                           <?php } ?>
                           |||| 
                           <?php }?>                    
                           <select name="priorita" size="1" id="priorita" onChange="invia_priorita()">
                             <option name="priorita" value="-1" id="priorita">[priorita]</option>
                             <?php echo"<option value=\"-1\">Tutte</option>";
							  $array_priorita=$objCore->getListaPriorita();
							  $num_priorita= count($array_priorita);
							  echo "count: ".$num_priorita;
							  for($i=0; $i<$num_priorita;$i++){
								echo"<option value=\"$i\"";
								if (isset($priorita) && ($i==$priorita)) echo "selected ";
								echo ">".$array_priorita[$i]."</option>";
							}
						?>
                           </select>
                           <?php if (($objCore->getLoggedOperatoreRole()==$objCore->getRuoloResponsabileId()) || ($objCore->getLoggedOperatoreRole()==$objCore->getRuoloProtocollatoreId())) {?>
                           <select name="operatore" size="1" id="operatore" onChange="invia_operatore()">
                         <option name="operatore" value="-1" id="operatore">[operatore]</option>
                         <?php echo"<option value=\"-1\">Tutti</option>";
								if ($objCore->getLoggedOperatoreRole()==$objCore->getRuoloResponsabileId())
									$result="";
								else 
									$result = $objCore->getOperatori();
								while($array=mysql_fetch_array($result)){
									echo "<option value=\"".$array['id']."\">".$array['nome']."</option>";
								}
                		?>
                       </select>
                       <?php }?> 
                     </form>                       </td>
              </table>
      <br>   <div class="table">
    <table width="100%">
	    <?php 
			if ($objCore->getLoggedOperatoreRole()==$objCore->getRuoloResponsabileId())
				$result=$objCore->getDocumentServiziOperatore();
			else if ($objCore->getLoggedOperatoreRole()==$objCore->getRuoloProtocollatoreId())
				$result=$objCore->getDocuments();
			else $result=$objCore->getDocumentsOperatore();
		?>
        <?php include("../_include/generavista.php");?>
	</table>
</div>
<br>
	<?php
	if(isset($_GET['op']) && $_GET['op']=="modd"){

	echo"<script language=javascript>";
	echo"document.location.href='service_pannello.php'";
	echo"</script>";
	
	}
	?>
</center>
              </p>
    </fieldset>
     </div>
    <div class="row"><?php include("../_include/bofooter.php");?></div>        
    </div>
</div>
</body>
</html>