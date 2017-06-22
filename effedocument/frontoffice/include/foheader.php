<!-- Applicazione:eFFe Document-->
<!-- Versione: 1.0.0.0 - Licenza GPL-->
<!-- Data Rilascio: 02 Febbraio 2010-->
<!-- Developer: ing. Felice Pescatore-->
<?php 	
	if (isset($level) && $level==2) $prefix = "../";
	else $prefix = "";
?>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="52%" align="left" valign="bottom"><a href="<?php echo $prefix ?>index.php"><img src="<?php echo $prefix ?>../common/images/loghi/effedocument_top.png" border="0" /></a></td>
        <td width="48%" align="right" valign="bottom"><b><font color="#707070">Document Managemet</font></b></td>
      </tr>
      <tr>
        <td align="left" valign="bottom">&nbsp;</td>
        <td align="right" valign="bottom">&nbsp;</td>
      </tr>
      <tr>
        <td align="left" valign="bottom"><a href="<?php echo $prefix ?>index.php" id="footerlink">Home</a> | <a href="<?php echo $prefix ?>wizard/docwizard1.php" id="footerlink">Registra Documento</a> | <a href="<?php echo $prefix ?>extra/extra.php?tipo=<?php echo $objCore->getExtraKnowledgebaseId(); ?>" id="footerlink">Knowledgebase</a> | <a href="<?php echo $prefix ?>extra/extra.php?tipo=<?php echo $objCore->getExtraAvvisiId(); ?>" id="footerlink">Avvisi</a></td>
        <td align="right" valign="bottom"><form action="<?php echo $prefix ?>extra/extra_cerca.php" method="post" id="formSearch">
              <label>
                <input type="text" name="keyword" id="keyword" />
              </label>
              <label>
                <input type="submit" name="button" id="button" value="Knowledge Search" />
              </label>
              <br />
          </form></td>
      </tr>
    </table></td>
  </tr>
</table>