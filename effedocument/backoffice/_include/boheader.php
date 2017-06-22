<!-- Applicazione:eFFe Document-->
<!-- Versione: 1.0.0.0 - Licenza GPL-->
<!-- Data Rilascio: 02 Febbraio 2010-->
<!-- Developer: ing. Felice Pescatore-->

<table width="0%" border="0">
  <tr>
    <td><div align="right">
      <fieldset>
          <legend><img src="../../common/images/icon/1.gif" alt="home" /><b><i>info Utente Connesso</i></b></legend>
        login: <b><?php echo $objCore->getLoggedOperatore() ?></b>, ruolo: <i><?php echo $objCore->getRuoloNome($objCore->getLoggedOperatoreRole()) ?></i>
        </fieldset>
    </div></td>
  </tr>
  <tr>
    <td><div align="right"></div></td>
  </tr>
  <tr>
    <td><div align="right">
    <?php if (!$_SESSION['LDAP']){?>
    		<img src="../../common/images/icon/edit.png" alt="home" /> <a href="../modifica/modifica_password.php">Modifica Password</a>&nbsp;&nbsp;
    <?php } ?>
	<img src="../../common/images/icon/info.gif" alt="guida" /><a href="javascript:apri('Help','../_help/effedoc.php',500,600);">Guida</a>&nbsp;&nbsp; <img src="../../common/images/icon/esci.gif" alt="esci" /> <a href="../_security/logout.php?private=true">Esci</a></div></td>
  </tr>
</table>
