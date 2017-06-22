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
?>
<html>
<head>
<script src="../../common/script/validation.js" language="JavaScript"></script>
 <script language="JavaScript">	
 	function init(){
		define('nome','string','Nome',null,null);
	}
  </script> 
  <script language="JavaScript">
  function invia(){
	  //document.formData.action = "inserisci_servizi.php";
    //document.formData.submit();
   	}  
	</script>
<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
<title>Amministrazione effedocument</title>
<link href="../../common/css/effecss.css" rel="stylesheet">

</head>
<body onLoad="init();">
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
createMenu($objCore,11, $objCore->getLoggedOperatoreRole());
?>
  </div>
  <div id="spazio" style="padding:7px;font-size:14px;"></div>
<div align="center">                <div class="row">
                  <MAP name=Map2>
                    <AREA title=AOSTA shape=RECT 
              alt=AOSTA coords=41,22,67,38 
              href="http://finanzalocale.interno.it/ind_fin/7/aosta.html">
                  </MAP>
                  <MAP 
            name=Map3>
                    <AREA title=VERBANO-CUSIO-OSSOLA shape=RECT 
              alt=VERBANO-CUSIO-OSSOLA coords=114,43,140,59 
              href="http://finanzalocale.interno.it/ind_fin/7/verbano-cusio-ossola.html">
                    <AREA 
              title=BIELLA shape=RECT alt=BIELLA coords=95,90,115,105 
              href="http://finanzalocale.interno.it/ind_fin/7/biella.html">
                    <AREA 
              title=TORINO shape=RECT alt=TORINO coords=50,131,77,146 
              href="http://finanzalocale.interno.it/ind_fin/7/torino.html">
                    <AREA 
              title=CUNEO shape=RECT alt=CUNEO coords=52,198,82,212 
              href="http://finanzalocale.interno.it/ind_fin/7/cuneo.html">
                    <AREA 
              title=ASTI shape=RECT alt=ASTI coords=96,153,127,170 
              href="http://finanzalocale.interno.it/ind_fin/7/asti.html">
                    <AREA 
              title=ALESSANDRIA shape=RECT alt=ALESSANDRIA 
              coords=140,163,165,178 
              href="http://finanzalocale.interno.it/ind_fin/7/alessandria.html">
                    <AREA 
              title=VERCELLI shape=RECT alt=VERCELLI coords=104,113,131,129 
              href="http://finanzalocale.interno.it/ind_fin/7/vercelli.html">
                    <AREA 
              title=NOVARA shape=RECT alt=NOVARA coords=128,93,159,109 
              href="http://finanzalocale.interno.it/ind_fin/7/novara.html">
                  </MAP>
                  <MAP 
            name=Map4>
                    <AREA title=VARESE shape=RECT alt=VARESE 
              coords=6,70,32,86 
              href="http://finanzalocale.interno.it/ind_fin/7/varese.html">
                    <AREA 
              title=COMO shape=RECT alt=COMO coords=27,38,53,56 
              href="http://finanzalocale.interno.it/ind_fin/7/como.html">
                    <AREA 
              title=SONDRIO shape=RECT alt=SONDRIO coords=75,33,100,48 
              href="http://finanzalocale.interno.it/ind_fin/7/sondrio.html">
                    <AREA 
              title=LECCO shape=RECT alt=LECCO coords=57,59,80,72 
              href="http://finanzalocale.interno.it/ind_fin/7/lecco.html">
                    <AREA 
              title=BERGAMO shape=RECT alt=BERGAMO coords=76,78,101,91 
              href="http://finanzalocale.interno.it/ind_fin/7/bergamo.html">
                    <AREA 
              title=MILANO shape=RECT alt=MILANO coords=25,103,53,121 
              href="http://finanzalocale.interno.it/ind_fin/7/milano.html">
                    <AREA 
              title=PAVIA shape=RECT alt=PAVIA coords=24,134,49,150 
              href="http://finanzalocale.interno.it/ind_fin/7/pavia.html">
                    <AREA 
              title=LODI shape=RECT alt=LODI coords=65,127,91,142 
              href="http://finanzalocale.interno.it/ind_fin/7/lodi.html">
                    <AREA 
              title=CREMONA shape=RECT alt=CREMONA coords=99,132,126,146 
              href="http://finanzalocale.interno.it/ind_fin/7/cremona.html">
                    <AREA 
              title=MANTOVA shape=RECT alt=MANTOVA coords=146,135,175,151 
              href="http://finanzalocale.interno.it/ind_fin/7/mantova.html">
                    <AREA 
              title=BRESCIA shape=RECT alt=BRESCIA coords=118,90,143,104 
              href="http://finanzalocale.interno.it/ind_fin/7/brescia.html">
                  </MAP>
                  <MAP 
            name=Map5>
                    <AREA title=TRENTO shape=RECT alt=TRENTO 
              coords=25,90,50,106 
              href="http://finanzalocale.interno.it/ind_fin/7/trento.html">
                    <AREA 
              title=BOLZANO shape=RECT alt=BOLZANO coords=56,30,84,46 
              href="http://finanzalocale.interno.it/ind_fin/7/bolzano.html">
                  </MAP>
                  <MAP 
            name=Map6>
                    <AREA title=PORDENONE shape=RECT alt=PORDENONE 
              coords=15,44,43,58 
              href="http://finanzalocale.interno.it/ind_fin/7/pordenone.html">
                    <AREA 
              title=UDINE shape=RECT alt=UDINE coords=55,42,82,58 
              href="http://finanzalocale.interno.it/ind_fin/7/udine.html">
                    <AREA 
              title=GORIZIA shape=RECT alt=GORIZIA coords=81,63,108,76 
              href="http://finanzalocale.interno.it/ind_fin/7/gorizia.html">
                    <AREA 
              title=TRIESTE shape=RECT alt=TRIESTE coords=91,82,112,97 
              href="http://finanzalocale.interno.it/ind_fin/7/trieste.html">
                  </MAP>
                  <MAP 
            name=Map7>
                    <AREA title=VERONA shape=RECT alt=VERONA 
              coords=10,104,38,119 
              href="http://finanzalocale.interno.it/ind_fin/7/verona.html">
                    <AREA 
              title=VICENZA shape=RECT alt=VICENZA coords=43,83,69,98 
              href="http://finanzalocale.interno.it/ind_fin/7/vicenza.html">
                    <AREA 
              title=BELLUNO shape=RECT alt=BELLUNO coords=91,20,116,35 
              href="http://finanzalocale.interno.it/ind_fin/7/belluno.html">
                    <AREA 
              title=TREVISO shape=RECT alt=TREVISO coords=104,81,131,95 
              href="http://finanzalocale.interno.it/ind_fin/7/treviso.html">
                    <AREA 
              title=VENEZIA shape=RECT alt=VENEZIA coords=100,111,124,125 
              href="http://finanzalocale.interno.it/ind_fin/7/venezia.html">
                    <AREA 
              title=PADOVA shape=RECT alt=PADOVA coords=74,128,98,143 
              href="http://finanzalocale.interno.it/ind_fin/7/padova.html">
                    <AREA 
              title=ROVIGO shape=RECT alt=ROVIGO coords=64,153,90,167 
              href="http://finanzalocale.interno.it/ind_fin/7/rovigo.html">
                  </MAP>
                  <MAP 
            name=Map8>
                    <AREA title=IMPERIA shape=RECT alt=IMPERIA 
              coords=11,64,35,76 
              href="http://finanzalocale.interno.it/ind_fin/7/imperia.html">
                    <AREA 
              title=SAVONA shape=RECT alt=SAVONA coords=44,27,68,41 
              href="http://finanzalocale.interno.it/ind_fin/7/savona.html">
                    <AREA 
              title=GENOVA shape=RECT alt=GENOVA coords=107,10,135,23 
              href="http://finanzalocale.interno.it/ind_fin/7/genova.html">
                    <AREA 
              title="LA SPEZIA" shape=RECT alt="LA SPEZIA" coords=144,38,169,54 
              href="http://finanzalocale.interno.it/ind_fin/7/la%20spezia.html">
                  </MAP>
                  <MAP 
            name=Map9>
                    <AREA title=PIACENZA shape=RECT alt=PIACENZA 
              coords=18,20,41,35 
              href="http://finanzalocale.interno.it/ind_fin/7/piacenza.html">
                    <AREA 
              title=PARMA shape=RECT alt=PARMA coords=51,41,74,57 
              href="http://finanzalocale.interno.it/ind_fin/7/parma.html">
                    <AREA 
              title="REGGIO EMILIA" shape=RECT alt="REGGIO EMILIA" 
              coords=87,42,115,57 
              href="http://finanzalocale.interno.it/ind_fin/7/reggio%20emilia.html">
                    <AREA 
              title=MODENA shape=RECT alt=MODENA coords=97,72,125,89 
              href="http://finanzalocale.interno.it/ind_fin/7/modena.html">
                    <AREA 
              title=BOLOGNA shape=RECT alt=BOLOGNA coords=140,61,169,78 
              href="http://finanzalocale.interno.it/ind_fin/7/bologna.html">
                    <AREA 
              title=FERRARA shape=RECT alt=FERRARA coords=182,28,205,43 
              href="http://finanzalocale.interno.it/ind_fin/7/ferrara.html">
                    <AREA 
              title=RAVENNA shape=RECT alt=RAVENNA coords=190,59,216,75 
              href="http://finanzalocale.interno.it/ind_fin/7/ravenna.html">
                    <AREA 
              title="FORLI' CESENA" shape=RECT alt="FORLI' CESENA" 
              coords=184,98,209,113 
              href="http://finanzalocale.interno.it/ind_fin/7/forli%27%20cesena.html">
                    <AREA 
              title=RIMINI shape=RECT alt=RIMINI coords=228,96,252,111 
              href="http://finanzalocale.interno.it/ind_fin/7/rimini.html">
                  </MAP>
                  <MAP 
            name=Map10>
                    <AREA title=PERUGIA shape=RECT alt=PERUGIA 
              coords=29,38,56,54 
              href="http://finanzalocale.interno.it/ind_fin/7/perugia.html">
                    <AREA 
              title=TERNI shape=RECT alt=TERNI coords=30,91,55,106 
              href="http://finanzalocale.interno.it/ind_fin/7/terni.html">
                  </MAP>
                  <MAP 
            name=Map11>
                    <AREA title="PESARO URBINO" shape=RECT 
              alt="PESARO URBINO" coords=32,21,56,33 
              href="http://finanzalocale.interno.it/ind_fin/7/pesaro%20urbino.html">
                    <AREA 
              title=ANCONA shape=RECT alt=ANCONA coords=67,34,94,49 
              href="http://finanzalocale.interno.it/ind_fin/7/ancona.html">
                    <AREA 
              title=MACERATA shape=RECT alt=MACERATA coords=62,77,88,91 
              href="http://finanzalocale.interno.it/ind_fin/7/macerata.html">
                    <AREA 
              title="ASCOLI PICENO" shape=RECT alt="ASCOLI PICENO" 
              coords=89,96,115,110 
              href="http://finanzalocale.interno.it/ind_fin/7/ascoli%20piceno.html">
                  </MAP>
                  <MAP 
            name=Map12>
                    <AREA title=VITERBO shape=RECT alt=VITERBO 
              coords=27,35,52,52 
              href="http://finanzalocale.interno.it/ind_fin/7/viterbo.html">
                    <AREA 
              title=ROMA shape=RECT alt=ROMA coords=67,79,95,94 
              href="http://finanzalocale.interno.it/ind_fin/7/roma.html">
                    <AREA 
              title=RIETI shape=RECT alt=RIETI coords=94,43,117,60 
              href="http://finanzalocale.interno.it/ind_fin/7/rieti.html">
                    <AREA 
              title=LATINA shape=RECT alt=LATINA coords=105,129,128,143 
              href="http://finanzalocale.interno.it/ind_fin/7/latina.html">
                    <AREA 
              title=FROSINONE shape=RECT alt=FROSINONE coords=147,112,172,127 
              href="http://finanzalocale.interno.it/ind_fin/7/frosinone.html">
                  </MAP>
                  <MAP 
            name=Map13>
                    <AREA title=PESCARA shape=RECT alt=PESCARA 
              coords=56,40,80,56 
              href="http://finanzalocale.interno.it/ind_fin/7/pescara.html">
                    <AREA 
              title=TERAMO shape=RECT alt=TERAMO coords=36,19,59,35 
              href="http://finanzalocale.interno.it/ind_fin/7/teramo.html">
                    <AREA 
              title="L'AQUILA" shape=RECT alt="L'AQUILA" coords=27,74,56,91 
              href="http://finanzalocale.interno.it/ind_fin/7/l%27aquila.html">
                    <AREA 
              title=CHIETI shape=RECT alt=CHIETI coords=84,69,109,83 
              href="http://finanzalocale.interno.it/ind_fin/7/chieti.html">
                  </MAP>
                  <MAP 
            name=Map14>
                    <AREA title=SASSARI shape=RECT alt=SASSARI 
              coords=30,49,54,65 
              href="http://finanzalocale.interno.it/ind_fin/7/sassari.html">
                    <AREA 
              title=ORISTANO shape=RECT alt=ORISTANO coords=27,113,56,129 
              href="http://finanzalocale.interno.it/ind_fin/7/oristano.html">
                    <AREA 
              title=NUORO shape=RECT alt=NUORO coords=71,109,100,124 
              href="http://finanzalocale.interno.it/ind_fin/7/nuoro.html">
                    <AREA 
              title=CAGLIARI shape=RECT alt=CAGLIARI coords=29,178,54,192 
              href="http://finanzalocale.interno.it/ind_fin/7/cagliari.html">
                  </MAP>
                  <MAP 
            name=Map15>
                    <AREA title=ISERNIA shape=RECT alt=ISERNIA 
              coords=10,35,32,49 
              href="http://finanzalocale.interno.it/ind_fin/7/isernia.html">
                    <AREA 
              title=CAMPOBASSO shape=RECT alt=CAMPOBASSO coords=50,24,76,40 
              href="http://finanzalocale.interno.it/ind_fin/7/campobasso.html">
                  </MAP>
                  <MAP 
            name=Map16>
                    <AREA title=CASERTA shape=RECT alt=CASERTA 
              coords=17,24,42,39 
              href="http://finanzalocale.interno.it/ind_fin/7/caserta.html">
                    <AREA 
              title=BENEVENTO shape=RECT alt=BENEVENTO coords=55,21,81,35 
              href="http://finanzalocale.interno.it/ind_fin/7/benevento.html">
                    <AREA 
              title=NAPOLI shape=RECT alt=NAPOLI coords=21,70,48,84 
              href="http://finanzalocale.interno.it/ind_fin/7/napoli.html">
                    <AREA 
              title=AVELLINO shape=RECT alt=AVELLINO coords=82,48,111,64 
              href="http://finanzalocale.interno.it/ind_fin/7/avellino.html">
                    <AREA 
              title=SALERNO shape=RECT alt=SALERNO coords=103,100,126,117 
              href="http://finanzalocale.interno.it/ind_fin/7/salerno.html">
                  </MAP>
                  <MAP 
            name=Map17>
                    <AREA title=FOGGIA shape=RECT alt=FOGGIA 
              coords=25,37,51,56 
              href="http://finanzalocale.interno.it/ind_fin/7/foggia.html">
                    <AREA 
              title=BARI shape=RECT alt=BARI coords=100,83,128,98 
              href="http://finanzalocale.interno.it/ind_fin/7/bari.html">
                    <AREA 
              title=TARANTO shape=RECT alt=TARANTO coords=145,120,171,136 
              href="http://finanzalocale.interno.it/ind_fin/7/taranto.html">
                    <AREA 
              title=BRINDISI shape=RECT alt=BRINDISI coords=185,122,212,137 
              href="http://finanzalocale.interno.it/ind_fin/7/brindisi.html">
                    <AREA 
              title=LECCE shape=RECT alt=LECCE coords=221,165,244,198 
              href="http://finanzalocale.interno.it/ind_fin/7/lecce.html">
                  </MAP>
                  <MAP 
            name=Map18>
                    <AREA title=POTENZA shape=RECT alt=POTENZA 
              coords=13,29,37,45 
              href="http://finanzalocale.interno.it/ind_fin/7/potenza.html">
                    <AREA 
              title=MATERA shape=RECT alt=MATERA coords=66,54,93,70 
              href="http://finanzalocale.interno.it/ind_fin/7/matera.html">
                  </MAP>
                  <MAP 
            name=Map19>
                    <AREA title=COSENZA shape=RECT alt=COSENZA 
              coords=30,55,57,71 
              href="http://finanzalocale.interno.it/ind_fin/7/cosenza.html">
                    <AREA 
              title=CROTONE shape=RECT alt=CROTONE coords=79,83,109,97 
              href="http://finanzalocale.interno.it/ind_fin/7/crotone.html">
                    <AREA 
              title=CATANZARO shape=RECT alt=CATANZARO coords=45,106,70,122 
              href="http://finanzalocale.interno.it/ind_fin/7/catanzaro.html">
                    <AREA 
              title="VIBO VALENTIA" shape=RECT alt="VIBO VALENTIA" 
              coords=23,136,51,152 
              href="http://finanzalocale.interno.it/ind_fin/7/vibo%20valentia.html">
                    <AREA 
              title="REGGIO CALABRIA" shape=RECT alt="REGGIO CALABRIA" 
              coords=13,180,40,196 
              href="http://finanzalocale.interno.it/ind_fin/7/reggio%20calabria.html">
                  </MAP>
                  <MAP 
            name=Map20>
                    <AREA title=TRAPANI shape=RECT alt=TRAPANI 
              coords=4,37,30,55 
              href="http://finanzalocale.interno.it/ind_fin/7/trapani.html">
                    <AREA 
              title=PALERMO shape=RECT alt=PALERMO coords=64,32,90,48 
              href="http://finanzalocale.interno.it/ind_fin/7/palermo.html">
                    <AREA 
              title=AGRIGENTO shape=RECT alt=AGRIGENTO coords=60,77,89,93 
              href="http://finanzalocale.interno.it/ind_fin/7/agrigento.html">
                    <AREA 
              title=ENNA shape=RECT alt=ENNA coords=132,52,158,69 
              href="http://finanzalocale.interno.it/ind_fin/7/enna.html">
                    <AREA 
              title=MESSINA shape=RECT alt=MESSINA coords=178,18,205,33 
              href="http://finanzalocale.interno.it/ind_fin/7/messina.html">
                    <AREA 
              title=CATANIA shape=RECT alt=CATANIA coords=171,51,198,67 
              href="http://finanzalocale.interno.it/ind_fin/7/catania.html">
                    <AREA 
              title=CALTANISSETTA shape=RECT alt=CALTANISSETTA 
              coords=115,96,139,111 
              href="http://finanzalocale.interno.it/ind_fin/7/caltanissetta.html">
                    <AREA 
              title=RAGUSA shape=RECT alt=RAGUSA coords=145,124,174,139 
              href="http://finanzalocale.interno.it/ind_fin/7/ragusa.html">
                    <AREA 
              title=SIRACUSA shape=RECT alt=SIRACUSA coords=174,109,198,123 
              href="http://finanzalocale.interno.it/ind_fin/7/siracusa.html">
                  </MAP>
      <fieldset>
        <legend><img src="../../common/images/layout/servizi.png" width="60" height="60">Nuovo Servizio per il quale si pu&ograve; richiedere assistenza</legend>
                 <br>
          <!-- pagina inserimento dati by phpdbwizard -->
        <form action="<?php $PHP_SELF ?>" method="post" id="formData"  onSubmit="validate();return returnVal;">
          <input type="hidden" name="op" value="ins">
          <table width="60%">
            <tr>
              <td>Tipologia Primaria:</td>
              <td><select name="tipologia" size="1" id="tipologia"  onChange="invia()">
                  <?php echo "<option value=\"0\">[nessuna categoria padre]</option>";
		$result=$objCore->getTipologieAttive();
		while($array_tipologie=mysql_fetch_array($result)){
			echo "<option value=\"".$array_tipologie['id']."\">".$array_tipologie['nome']."</option>";
		}
	?>
              </select></td>
            </tr>
            <tr>
              <td>Ufficio</td>
              <td><select name="ufficio" size="1" id="ufficio">
                  <?php 
		echo "<option value=\"-1\">[seleziona ufficio]</option>"; 
		$result=$objCore->getUfficiAll();
		while($array_uffici=mysql_fetch_array($result)){
			echo "<option value=\"".$array_uffici['id']."\"";
				if (isset($_POST['ufficio']) && ($_POST['ufficio']==$array_uffici['id'])) echo " selected=true";
			echo">".$array_uffici['nome']."</option>";
		}
	?>
              </select></td>
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
              <td>Nome</td>
              <td><input type="text" name="nome"> <img src="../../common/images/icon/star.gif" width="16" height="16">                       </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <?php if (!isset($_GET['tipologia'])){ ?>
            <?php } ?>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td></td>
              <td><input type="submit" value="Inserisci"></td>
            </tr>
          </table>
        </form>
        <?php
    if(isset($_POST['op']) && $_POST['op']=="ins" && $_POST['tipologia']!= "" && $_POST['tipologia']!=-1){
        //cattura i dati dal modulo
        $nome =$_POST['nome'];
        $tipologia = $_POST['tipologia'];

        //li inserisce nella tabella
        if($objCore->insertServizio($nome,"1",$tipologia))echo"inserimento avvenuto correttamente";
        else echo"inserimento fallito";
		
		echo"<script language=javascript>";
		echo"document.location.href='../service/service_servizi.php'";
		echo"</script>";
				
    }
    ?>
        </p>
        </fieldset>
</div>
    <div class="row">&nbsp;</div>
                <div class="row"><?php include("../_include/bofooter.php");?></div>        </div>
</div>
</body>
</html>