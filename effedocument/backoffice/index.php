<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!-- Applicazione:eFFe Document-->
<!-- Versione: 1.0.0.0 - Licenza GPL-->
<!-- Data Rilascio: 02 Febbraio 2010-->
<!-- Developer: ing. Felice Pescatore-->

<HTML><HEAD><TITLE>Amministrazione eFFe Document</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
	<link href="../common/css/effecss.css" rel="stylesheet">
</HEAD>
<BODY><br><br><br><center>
<div style="width:530px; height:480px; background:#ffffff; border:1px solid #cecece; padding:20px; text-align: right;"><span style="text-align: center"></span><img src="../common/images/loghi/effedocument.png" alt="Effe Document" border=0 align="left"><br>
<?php if (isset($_GET['errore'])){ 
		echo "<font color=red>ERRORE di Autenticazione</font>"; 
}
?>
    <FORM name="login" action="_security/valida.php" method="post">
      <P><FONT size=-1><B><img src="../common/images/extra/longmenu_left.gif" width="455"></B></FONT></P>
      <table width="98%%" border="0">
        <tr>
          <td width="45%" align="right"><FONT size=-1><B><img src="../common/images/extra/backoffice.png" width="149" height="197"></B></FONT></td>
          <td width="27%" align="left" valign="bottom"><P>&nbsp;</P>
            <P><FONT size=-1><B>Username</B></FONT><BR>
              <INPUT name="login" id="login">
            </P>
            <P><FONT size=-1><B>Password</B></FONT><BR>
              <INPUT type="password" name="password" id="password">
          </td>
          <td width="28%" align="right" valign="bottom"><p><img src="../common/images/extra/lucchetto.png" width="40">            
            </p>
            <p>
              <INPUT class="login" type="submit" value="Login" name="Submit">
          </p></td>
        </tr>
      </table>
      <P>&nbsp;</P>
      <P>&nbsp;</P>
    </FORM>
      <div class="row">
        <p align="center"><a href="http://www.felicepescatore.it" target="_blank"><img src="../common/images/loghi/logofp.png" alt="ing. Felice Pescatore"border="0" /></a></p>
<p align="center" class="Stile1">versione 1.0.0</p>
      </div>
<br>
      </p>
  </div>
</center>
</BODY></HTML>