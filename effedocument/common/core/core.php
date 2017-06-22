<!-- Applicazione:eFFe Document-->
<!-- Versione: 1.0.0.0 - Licenza GPL-->
<!-- Data Rilascio: 02 Febbraio 2010-->
<!-- Developer: ing. Felice Pescatore-->

<?php 
session_start();
include_once("genera_log.class.php");

//Configurarione realtiva alla visualizzazione degli Avvisi e delle Faq
//======================================================================
$arr_extra=array('avvisi','faq');
$_SESSION['extra']=$arr_extra;

$arr_priorita=array();
$_SESSION['priorita']=$arr_priorita;
$_SESSION['max_num_extra']=5;

//LOG
//============================================================================
//Tiene traccia se la funzione di log è attivata e fornisce l'oggetto relativo
$_SESSION['log_active']=false;
$_SESSION['log']="";

//Nel caso sia necessario inserire nuovi valori negli array seguenti, bisogna inserirli in coda
//=============================================================================================
//Popolo l'array delle tipologie di work flow
$arr_work_flow=array('semplice','avanzato');
$_SESSION['work_flow']=$arr_work_flow;

//Popolo l'array delle priorità
$arr_priorita=array('bassa','normale','urgente','critica');
$_SESSION['priorita']=$arr_priorita;

$array_temporale_priorita=array(5,10,15);
$_SESSION['temporale_priorita']= $array_temporale_priorita;

//Popolo l'array degli Stati
$arr_stati=array('assegnazione','assegnato','lavorazione','predisposto','validato','autorizzato','evaso');
$_SESSION['stati']=$arr_stati;

//Stati in cui può intervenire il protocollatore
$arr_stati_modifica_protocollatore=array('assegnazione');
$_SESSION['stati_modifica_protocollatore']=$arr_stati_modifica_protocollatore;

//Stati in cui può intervenire il responsabile
$arr_stati_modifica_responsabile=array('assegnazione','predisposto');
$_SESSION['stati_modifica_responsabile']=$arr_stati_modifica_responsabile;

//Stati in cui può intervenire l'assegnatario (validato solo se il workflow è di tipo semplice $workflow=0)
$arr_stati_modifica_assegnatario=array('assegnato','lavorazione','validato','autorizzato');
$_SESSION['stati_modifica_assegnatario']=$arr_stati_modifica_assegnatario;

//Stati in cui può intervenire il responsabile di ufficio (validato solo se il workflow è di tipo complessa $workflow=1)
$arr_stati_modifica_supervisore=array('validato');
$_SESSION['stati_modifica_supervisore']=$arr_stati_modifica_supervisore;

//Popolo l'array dei ruoli
$arr_ruoli=array('amministratore','responsabile servizio','collaboratore servizio','protocollatore','visualizzatore report', 'supervisore');
$_SESSION['ruoli']= $arr_ruoli;

//Popolo l'array delle modalità di recezione dei reclami/info. La modalità WEB deve essere obbligatoriamente la prima [indice=0]
$array_modalita_ricezione=array('Web','E-mail','Fax','Posta Ordinaria','Posta Raccomandata');
$_SESSION['modalita_ricezione']= $array_modalita_ricezione;

//Tiene traccia dei parametri di configurazione
$_SESSION['LDAP']="";
$_SESSION['ENTE']="";
$_SESSION['ENTE_SIGLA']="";
$_SESSION['PREFIX_PROTOCOLLO']=array('i','u');

//Sezione relativa al calcolo della Priorità
function calcPriorita($data_document)
{
	// carico la data da controllare nelle 3 variabili
	// puoi utilizzare date passate o future
	list($giorno, $mese, $anno) = explode("/",visualizzaDataEuro($data_document)); 

	// calcolo la differenza tra il timestamp della data definita e la data attuale
	// il risultato dovrò dividerlo per 86400 (il numero di secondi in un giorno)
	$differenza=(strtotime(date("Y/m/d"))- strtotime("$anno/$mese/$giorno"))/(86400); 

	// qui stampo giorni o giorno a seconda se la differenza è composta da 1 giorno o più giorni
	// funziona anche con i numeri negativi
	$pluraleosingolare = ((ceil(abs($differenza)>1)) or ceil($differenza)==0)?"giorni":"giorno";


	//calcolo la priorità e la ritorno
	if ($differenza < $_SESSION['temporale_priorita'][0]) return 0;
	if (($differenza > $_SESSION['temporale_priorita'][0]) && ($differenza < $_SESSION['temporale_priorita'][1])) 
		return 1;
	if (($differenza > $_SESSION['temporale_priorita'][1]) && ($differenza < $_SESSION['temporale_priorita'][2]) )
		return 2;
	if ($differenza > $_SESSION['temporale_priorita'][2]) return 3;		
	
}
//Sezione relativa ai Report
//===========================
$array_report[0]=array('Storico','Richieste Evase/Inevase', 'Assegnazione Evase/Inevase','Servizi', 'Modalità di Ricezione - Richieste Evase/Inevase');
$array_report[1]=array('Tempistica Richieste Evase', 'Servizi - Richieste Evase', 'Servizi - Tempistica Richieste Evase', 'Modalità di Ricezione - Richieste Evase');
$array_report[2]=array('Tempistica Richieste Inevase', 'Servizi - Richieste Inevase', 'Servizi - Tempistica Richieste Inevase', 'Modalità di Ricezione - Richieste Inevase');

$_SESSION['tipo_report']= $array_report;


//Sezione relativa all'upload
//============================
//viene ridefinito, se presente, nel file di conf XML
$_SESSION['file_upload']="_documenti_allegati";
$_SESSION['dimensione_massima_file']=3000000; 
$_SESSION['filtrare']=0; //filtrare x estensioni ammesse? 1=si 0=no
$_SESSION['array_estensioni_ammesse']=array('.jpg','.jpeg','.gif','.png','.tif'); //estensioni ammesse

function getDocumentiUploadDir(){
	return $_SESSION['file_upload'];
}


//funzione per l'upload dei file
function upload($file, $cartella_upload, $nome_destinatario){
	
	$dimensione_massima=$_SESSION['dimensione_massima_file'];
	$dimensione_massima_KB=$_SESSION['dimensione_massima_file']/1024;

	$array_estensioni_ammesse=$_SESSION['array_estensioni_ammesse'];
	$errore="";
	$messaggio="";
	$nome_file="";
	$uploadok_flag=true;

	if(!isset($file) || $file['size']==0)
	{
		$uploadok_flag=false;	
		$messaggio="Nessun file selezionato per l'upload 0";
	}elseif($file['size']>$dimensione_massima)
	{	$uploadok_flag=false;
		$messaggio="Il file selezionato per l'upload supera dimensione massima di $dimensione_massima_Kb Kb";
		$errore="Dimesione massima superata";
	}else{	
		if($_SESSION['filtrare']==1){		
			$estensione = strtolower(substr($nome_file, strrpos($nome_file, "."), strlen($nome_file)-strrpos($nome_file, ".")));						
			if(!in_array($estensione,$array_estensioni_ammesse))
			{	$uploadok_flag=false;
				$errore.="Upload file non ammesso. Estensioni ammesse: ".implode(", ",$array_estensioni_ammesse)."<br/>";		
			}
		}	
		if(!file_exists($cartella_upload))
		{	$uploadok_flag=false;
			$errore.="La cartella di destinazione non esiste</br>";	
		}		
		if($errore==""){		
			if(move_uploaded_file($file['tmp_name'], $cartella_upload.$nome_destinatario)){
				chmod($cartella_upload.$nome_destinatario,0777); //permessi per poterci sovrascrivere/scaricare			
				$messaggio="Operazione eseguita con successo. Upload riuscito.";		
			}else{			
				$uploadok_flag=false;
				$messaggio="Impossibile effettuare l'upload del file";		
			}	
		}else{		
			$_SESSION['log']->scrivi_riga($errore);
		}
	}
	if ($messaggio!="") $_SESSION['log']->scrivi_riga($messaggio);
	return ($uploadok_flag);
}

//Funzione di check per il testo
function checkText($testo){
	return str_replace("'", "''", $testo);
}

//Funzioni di conversione date
function convertiData($data)
{	
	$rsl = explode ('/',$data);
	$rsl = array_reverse($rsl);
	return implode($rsl,'-');
}

function visualizzaDataEuro($data)
{	
	$rsl = explode ('-',$data);
	$rsl = array_reverse($rsl);
	return implode($rsl,'/');
}

//Classe di accesso al DB

class sast1com
{
	var $user;
	var $password;
	var $host;
	var $database; 
	var $ldapserver;
	var $partialdn;
	var $log;
	
	var $loggedOperatore="";
	var $loggedOperatoreId="";
	var $loggedOperatoreRole="";

		function connessione()
		 {
			$quanti	= 1;
			$indice = 256;
			$contatore = 0;

			$file_config=substr(dirname(__FILE__),0,(strlen(dirname(__FILE__))-strlen("core")))."\config\effeconfig.xml";
			
			if ($file_config) 
			{
				$xml = simplexml_load_file($file_config);

				$this->user = (string)$xml->database[0]->user;
				$this->password = (string)$xml->database[0]->password;
				$this->host = (string)$xml->database[0]->host;
				$this->dbname = (string)$xml->database[0]->dbname;
			
			
				$this->ldapserver = (string)$xml->ldap[0]->server;
				$this->partialdn = (string)$xml->ldap[0]->partialdn;


				$_SESSION['log_active'] = (bool)$xml->other[0]->effelog->attributes()->active;
				if ($_SESSION['log_active'])
					$_SESSION['log'] = new genera_log('../../log/',((string)$xml->other[0]->effelog));

				$_SESSION['file_upload']=(string)$xml->other[0]->dirallegati;

			} else {
				exit("Errore nell'apertura del file di configurazione");
			}				
			
	 
		   mysql_connect($this->host,$this->user,$this->password)or die("non riesco a connettermi".mysql_error());
		   mysql_select_db($this->dbname)or die("non riesco selezionare il database");
		   
		   //carico le impostazioni
		   $conf_array=mysql_fetch_array(mysql_query("select * from configurazioni order by id desc"));
			if ($conf_array)
			{
				$_SESSION['LDAP']=$conf_array['ldap'];
				$_SESSION['ENTE']=$conf_array['ente'];
				$_SESSION['ENTE_SIGLA']=$conf_array['ente_sigla'];
			}
			else
			{
				$_SESSION['LDAP']="";
				$_SESSION['ENTE']="";
				$_SESSION['ENTE_SIGLA']="";
			}
 	} 
	
	function disconnessione()
 	{
   		mysql_close();
 	}

	function loginOperatore($user,$password)
 	{	
		if($user and $password) 
		{
			if ($user=="admin" || !$_SESSION['LDAP'])
			{
				$result=mysql_query("select * from operatori where login='".$user."' and password='".$password."' and abilitato=1");
				$array=mysql_fetch_array($result);
			}else if ($_SESSION['LDAP'])
			{
				//DN
				$ldaprdn="cn=".$user.",".$this->partialdn;

				// Connessione al server ldap
				ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
		
				//$ldapconn = ldap_connect("ldap://127.0.0.1")
				$ldapconn = ldap_connect($this->ldapserver)
				or die("Non riesco a connettermi al server LDAP.");
		
				if ($ldapconn) 
				{
					// binding
					$ldapbind = @ldap_bind($ldapconn, $ldaprdn, $password);
			
					// recupero gli attributi specifici dal db dell'applicativo
					if ($ldapbind) 
					{
						$result=mysql_query("select * from operatori where login='".$user."' and abilitato=1");
						$array=mysql_fetch_array($result);
					} 
				}			
			}
		}
	
		if ($array){	
			$this->loggedOperatore=$user;
			$this->loggedOperatoreId=$array["id"];
			$this->loggedOperatoreRole=$array["id_ruolo"];
		}else {	
			$this->loggedOperatore="";
			$this->loggedOperatoreId="";
			$this->loggedOperatoreRole="";
		}
		
		
		return $array;
	}
	
	function isLogged()
	{	
		return $this->loggedOperatore!="";
	}
	
	function getLoggedOperatore()
	{	
		return $this->loggedOperatore;
	}
	
	function getLoggedOperatoreId()
	{	
		return $this->loggedOperatoreId;
	}

	function getLoggedOperatoreRole()
	{	
		return $this->loggedOperatoreRole;
	}
	
	function getLoggedOperatorePassword()
	{	
		$array=mysql_fetch_array(mysql_query("select * from operatori where id='".$this->loggedOperatoreId."'"));

		if ($array) return $array['password'];
		return "";
	}
	
	function getLoggedOperatoreServizi()
	{	
		return $this->getServiziOperatore($this->getLoggedOperatoreId());
	}

	
	//LOG FUNCTION
	function logWrite($stringa)
	{
		if (isset($_SESSION['log_active']) && $_SESSION['log_active'])
			$_SESSION['log']->scrivi_riga("--> ".$stringa);
		
	}
	
	function getServizioNome($id_servizio)
 	{
		$array=mysql_fetch_array(mysql_query("select * from servizi where id='".$id_servizio."'"));

		if ($array) return $array['nome'];
		return "nessuna";
	}	
	
	function getServizioId($id_document)
 	{	
		$array=mysql_fetch_array(mysql_query("select * from document where id='".$id_document."'"));

		if ($array) return $array['id_servizio'];
		return -1;
	}
	
	function getServizioDati($id_servizio)
 	{	
		return mysql_query("select * from servizi where id='".$id_servizio."'");
	}	
	

	function getUfficiAll()
	{
		return mysql_query("select * from uffici");
	}
	
	function getUfficioId($id_document)
 	{	
		$array=mysql_fetch_array(mysql_query("select * from document where id='".$id_document."'"));

		if ($array) return $array['id_ufficio'];
		return -1;
	}
		

	function getUfficioDati($id_ufficio)
 	{		
		return mysql_query("select * from uffici where id='".$id_ufficio."'");
	}
	
	function getUfficioNome($id_ufficio)
 	{	
		$array=mysql_fetch_array(mysql_query("select * from uffici where id='".$id_ufficio."'"));

		if ($array) return $array['nome'];
		else return "[impossibile determinare l'ufficio]";
	}

	function getUfficioDescrizione($id_ufficio)
 	{	
		$array=mysql_fetch_array(mysql_query("select * from uffici where id='".$id_ufficio."'"));

		if ($array) return $array['descrizione'];
		else return "[descrizione non presente]";
	}	
		
	function getRuoliOperatori()
 	{	
		return $_SESSION['ruoli'];
	}
	
	function getRuoloNome($id_ruolo)
 	{	

		if ($id_ruolo < count($_SESSION['ruoli']) && $id_ruolo>=0)
			return $_SESSION['ruoli'][$id_ruolo];
		
		return "[ruolo non disponibile]";		
	}	

	function getRuolo($id_operatore)
 	{	
		return mysql_fetch_array(mysql_query("select * from operatori_ruoli where id='".$id_operatore."'"));
	}
	
	function getListaPriorita()
 	{	
		return $_SESSION['priorita'];
	}
	
	function getPrioritaNome($id_priorita)
 	{	
		return $_SESSION['priorita'][$id_priorita];
	}	

	function getExtra($id_extra)
 	{	
		return mysql_fetch_array(mysql_query("select * from extra where id='".$id_extra."'"));
	}	
	
	function getExtraServizio($servizio, $tipo)
 	{
		return mysql_query("select * from extra where id_servizio='".$servizio."' and id_tipo='".$tipo."' and abilitato=1");
	}	
		
	function getDocument($id_document)
 	{	
		return mysql_fetch_array(mysql_query("select * from document where id='".$id_document."'"));
	}
	
	function getDocumentWorkflow($id_document)
 	{	
		$array_document=$this->getDocument($id_document);
		$array=$this->getTipologia($array_document['id_servizio']);

		if ($array) return $array['workflow'];
		else return -1;
	}
		
	function getDocuments()
 	{	
		return mysql_query("select * from document order by protocollo_tipo, protocollo desc");
	}
	
	function getDocumentNumFasi($id_document)
 	{	
		$array= mysql_fetch_array(mysql_query("select count(id) as totale from document_ass where id_document='".$id_document."'"));
		return $array['totale'];
	}
		
	function getAllDocuments()
 	{	
		return mysql_query("select * from document order by protocollo desc");
	}

	function getDocumentsOperatore()
 	{	
		return mysql_query("select distinct * from document_ass where id_operatore='".$this->loggedOperatoreId."' group by id_document order by id desc");
	}

	
	function getDocumentsServizioSpecifico($servizio, $ufficio)
 	{	
		return mysql_query("select * from document where id_ufficio=".$ufficio." and id_servizio='".$servizio."' order by protocollo desc");

	}
	
	function getDocumentServiziOperatore()
	{
		$sql_string="select * from document where";
		$servizi=$this->getServiziOperatore($this->getLoggedOperatoreId());
		$sql_string=$sql_string." id_servizio='".$servizi[0]."'";
		for ($i=1; $i<count($servizi); $i++)
			$sql_string=$sql_string." or id_servizio='".$servizi[$i]."'";
		
		$sql_string=$sql_string." order by protocollo desc";

		return mysql_query($sql_string);
	}
	
	function getDocumentsServizioPriorita($priorita)
 	{	
			$result=mysql_query("select * from document where id_servizio='".$this->loggedOperatoreServizio."'");
			
			$index=0;
			while($array=mysql_fetch_array($result)){
				if (calcPriorita($array['data'])==$priorita)
				{
					$array_return[index]=$array;
					$index+=1;
				}
			}
			return array_return;
	}

	function getDocumentAss($id_document){
		return mysql_query("select * from document_ass where id_document='".$id_document."' order by id DESC");
	}	
	
	function getDocumentAssId($id_document){
		$array=mysql_fetch_array($this->getDocumentAss($id_document));

		if ($array) return $array['id_operatore'];
		return -1;
	}	

	function getDocumentAssNome($id){
		$array=mysql_fetch_array($this->getDocumentAss($id));
		$array_op=$this->getOperatore($array['id_operatore']);
		
		if ($array_op) return $array_op['nome'];
		return "[nome operatore non disponibile]";
	}	

	function getDocumentAssInLavorazione($id){
		$result=$this->getDocumentAss($id);
		
		while ($array=mysql_fetch_array($result)){
			if ($array['id_stato']==$this->getStatoInLavorazione())
				return $array['id_operatore'];
		}
		return -1;
	}		
	
	function getDocumentDataInLavorazione($id){
		$result=$this->getDocumentAss($id);
		
		while ($array=mysql_fetch_array($result)){
			if ($array['id_stato']==$this->getStatoInLavorazione())
				return visualizzaDataEuro($array['data']);
		}
		return "non disponile";
	}		
	
	//Prende l'ultima validazione (ci possono essere + predisposizioni in base alla Validazione)
	function getDocumentDataPredisposto($id){
		$result=$this->getDocumentAss($id);
		$data = "non disponibile";
		
		while ($array=mysql_fetch_array($result)){
			if ($array['id_stato']==$this->getStatoPredisposto())
				$data=visualizzaDataEuro($array['data']);
		}
		return $data;
	}		

	//Prende l'ultima validazione (ci possono essere + validazione in base all'Autorizzazione)
	function getDocumentDataValidato($id){
		$result=$this->getDocumentAss($id);
		$data = "non disponibile";
		
		while ($array=mysql_fetch_array($result)){
			if ($array['id_stato']==$this->getStatoValidato())
				$data=visualizzaDataEuro($array['data']);
		}
				
		return $data;
	}		
	
	function getDocumentDataEvaso($id){
		$result=$this->getDocumentAss($id);
		
		while ($array=mysql_fetch_array($result)){
			if ($array['id_stato']==$this->getStatoFinale())
				return visualizzaDataEuro($array['data']);
		}
		return "non disponibile";
	}				

	function checkDocumentoRisposta($id_assegnazione){
		$array=mysql_fetch_array(mysql_query("select * from document_risp where id_document_ass='".$id_assegnazione."'"));

		if ($array) return $array;
		return -1;
	}	
		
	function getDocumentRisposta($id_risposta){
		return mysql_fetch_array(mysql_query("select * from document_risp where id='".$id_risposta."'"));
	}

	function getDocumentRispostaApprovata($id_document){
		$result=mysql_query("select * from document_risp where id_document='".$id_document."' order by id desc");

		return mysql_fetch_array($result);
	}		
	
	function getCollaboratoriServizio($id_servizio)
 	{	
		$result_op= mysql_query("select * from servizi_operatori where id_servizio='".$id_servizio."'");
		$query="select * from operatori where id_ruolo='".$this->getRuoloCollaboratoreId()."'";

		$array=mysql_fetch_array($result_op);
		$array=mysql_fetch_array($result_op);
		if ($array) $query=$query." and (id='".$array['id_operatore']."'";
		while ($array=mysql_fetch_array($result_op)){
			$query=$query." or id='".$array['id_operatore']."'";
		}
		$query=$query.") order by nome";	
		
		return mysql_query($query);
	}	

	function getProtocolloIngressoUscita($id_document)
 	{	
		$array = $this->getDocument($id_document);
		
		if ($array)
		{
			if ($array['protocollo_tipo'] == 0) return "ingresso";
			else if ($array['protocollo_tipo'] == 1) return "uscita";
			else return "[non disponibile]";
		}
		return "[non disponibile]";
	}
	
	function getStatoAttualeNome($id_document)
 	{	
		$array = mysql_fetch_array($this->getDocumentAss($id_document));
		
		if ($array) return $this->getStatoNome($array['id_stato']);
		return "[non definito]";
	}
	
	function getStatoAttualeData($id_document)
 	{	
		$array = mysql_fetch_array($this->getDocumentAss($id_document));
		
		if ($array) return $array['data'];
		return "[non definita]";
	}
	
	function getStatoAttuale($id_document)
 	{	
		$array = mysql_fetch_array($this->getDocumentAss($id_document));
		if ($array) return $array['id_stato'];
		return -1;
	}

		
	function getStatoNome($id)
 	{		
		if ($id < count($_SESSION['stati']) && $id>=0)
			return $_SESSION['stati'][$id];
		
		return "[stato non disponibile]";
	}

	function getStatoIniziale()
 	{		
		return 0;
	}
	
	function getStatoAssegnato()
 	{		
		return 1;
	}
	
	function getStatoInLavorazione()
 	{		
		return 2;
	}
	
	function getStatoPredisposto()
 	{		
		return 3;
	}

	function getStatoValidato()
 	{		
		return 4;
	}
	
	function getStatoAutorizzato()
 	{		
		return 5;
	}	
	
	function getStatoFinale()
 	{		
		return 6;
	}
	
	function getNextStato($workflow, $id_stato)
 	{	
		$next_stato=-1;
		
		if ($workflow==0 && $id_stato==$this->getStatoValidato()) {
			$next_stato = $this->getStatoFinale();
		}
		
		else{
			if ($id_stato>=0 && $id_stato < count($_SESSION['stati'])-1)
				$next_stato=$id_stato+1;
		}


		return $next_stato;
				
	}

	function getLowerStato($workflow, $id_stato)
 	{	
		$lower_stato=-1;
		
		if ($workflow==0 && $id_stato==$this->getStatoFinale()) {
			$lower_stato = $this->getStatoValidato();
		}
		
		else{
			if ($id_stato>0)
				$lower_stato=$id_stato-1;
		}


		return $lower_stato;
				
	}

	function getNextStatoNome($workflow, $id_stato)
 	{	
		$next_stato=$this->getNextStato($workflow, $id_stato);

		if ($next_stato!=-1) return	$_SESSION['stati'][$next_stato];
		else return "[nome stato non disponibile]";
				
	}
	
	function getLowerStatoNome($workflow, $id_stato)
 	{	
		$lower_stato=$this->getLowerStato($workflow, $id_stato);

		if ($lower_stato!=-1) return $_SESSION['stati'][$lower_stato];
		else return "[nome stato non disponibile]";
				
	}

	function getUtenti()
 	{	
		return mysql_query("select * from utenti order by cognome,nome");
	}

	function getUtenteId($email)
 	{	
		$array=mysql_fetch_array(mysql_query("select * from utenti where email='".$email."'"));

		if ($array) return $array['id'];
		return -1;
	}
	
	function getUtenteNome($id)
 	{	
		$array=mysql_fetch_array(mysql_query("select * from utenti where id='".$id."'"));

		if ($array) return $array['nome'];
	}	

	function getUtenteCognome($id)
 	{	
		$array=mysql_fetch_array(mysql_query("select * from utenti where id='".$id."'"));

		if ($array) return $array['cognome'];
	}		
	
	function getUtente($id_utente)
 	{	
		$array=mysql_fetch_array(mysql_query("select * from utenti where id='".$id_utente."'"));

		return $array;
	}	
	
	function getOperatore($id)
 	{	
		return mysql_fetch_array(mysql_query("select * from operatori where id='".$id."'"));
	}

	function getOperatoreNome($id)
 	{	
		$array=$this->getOperatore($id);
		
		if ($array) return $array['cognome']." ".$array['nome'];
		return "[nome operatore non disponibile]";
	}
	
	function getOperatoreLogin($login)
 	{	
		$array=mysql_fetch_array(mysql_query("select * from operatori where login='".$login."'"));
		
		if ($array) return true;
		return false;
	}
	
	
	function getOperatoriRuolo($id_ruolo)
 	{	
		return mysql_query("select * from operatori where id_ruolo='".$id_ruolo."'");
	}

	function getOperatori()
 	{	
		return mysql_query("select * from operatori");
	}
	
	function getProtocollatore()
 	{	
		$array=mysql_fetch_array(mysql_query("select * from operatori where id_ruolo='".$this->getRuoloProtocollatoreId()."' and abilitato='1'"));

		if ($array) return $array;
		return -1;
	}

	function getResponsabileServizio($id_servizio)
 	{
			$id_resp=-1;
			$array=mysql_query("select * from servizi_operatori where id_servizio='".$id_servizio."'");
			while (($id_resp==-1) && ($array_operatori=mysql_fetch_array($array)))
			{
				$array_res=mysql_fetch_array(mysql_query("select * from operatori where id='".$array_operatori['id_operatore']."' and abilitato='1'"));
				
				if ($array_res['id_ruolo']==$this->getRuoloResponsabileId()) $id_resp=$array_res['id'];
			}
			
		return $id_resp;
	}
	
	function getSupervisore()
 	{  
		$array_res=mysql_fetch_array(mysql_query("select * from operatori where id_ruolo='".$this->getRuoloSupervisoreID()."' and abilitato='1'"));

		if ($array_res) return $array_res;
		return -1;
	}
		

	function getRuoloAmministratoreId()
 	{	
		return 0;
	}	
	
	function getRuoloResponsabileId()
 	{	
		return 1;
	}	
	function getRuoloCollaboratoreId()
 	{	
		return 2;
	}	
	function getRuoloProtocollatoreId()
 	{	
		return 3;
	}	

	function getRuoloVisualizzatoreReportId()
 	{	
		return 4;
	}	
	
	function getRuoloSupervisoreId()
 	{	
		return 5;
	}
	
	function getEmail(){
		return mysql_fetch_array(mysql_query("select email from configurazione where id=1"));
	}

	function getExtraVisibili($tipo){
		return mysql_query("select * from extra where id_tipo='".$tipo."' and abilitato=1 order by id desc");	
	}

	function getExtraNonVisibili($tipo){
		return mysql_query("select * from extra where id_tipo='".$tipo."' and abilitato=0 order by id desc");
	}
		
	function getExtraHomePage($tipo){
		return mysql_query("select * from extra where id_tipo='".$tipo."' and abilitato=1 order by id desc limit ".$_SESSION['max_num_extra']);	
	}		

	function getAvvisiHomePage(){
		return $this->getExtraHomePage(0);
	}		

	function getKnowledgebaseHomePage(){
		return $this->getExtraHomePage(1);
	}			

	function getExtraServizioTotale($id_servizio, $tipo){
		$result =  mysql_query("select * from extra where id_servizio='".$id_servizio."' and id_tipo='".$tipo."' and abilitato=1 order by id desc");
		$tot = mysql_num_rows($result);
		
		return $tot;
	}		
	
	function updateDocumentoServizio($id, $id_servizio)
	{
		return mysql_query("update document set id_servizio='".$id_servizio."' where id='".$id."'");
	}
	
	function updateServizio($id, $nome, $workflow)
	{
		return mysql_query("update servizi set nome='".$nome."',workflow='".$workflow."' where id='".$id."'");
	}	

	function updateUfficio($id, $nome, $descrizione)
	{
		return mysql_query("update uffici set nome='".$nome."', descrizione='".$descrizione."' where id='".$id."'");
	}	
	
	function updateRuolo($id, $nome)
	{
		return mysql_query("update operatori_ruoli set nome='".$nome."' where id='".$id."'");
	}	

	function updatePassword($nuova_password)
	{
		return mysql_query("update operatori set password='".$nuova_password."' where id='".$this->loggedOperatoreId."'");
	}
	
	function updateRuoloOperatore($id, $id_ruolo)
	{
		return mysql_query("update operatori set id_ruolo='".$id_ruolo."' where id='".$id."'");
	}	

	function updateExtra($id, $stato)
	{
		return mysql_query("update extra set stato='".$stato."' where id='".$id."'");
	}
	
	function updateOperatore($nome, $cognome, $email, $login, $id)
	{
		return mysql_query ("update operatori set nome='".$nome."',cognome='".$cognome."',email='".$email."',login='".$login."' where id='".$id."'");
	}

	function getOperatoriAttivi(){
		return mysql_query("select * from operatori where abilitato=1 order by login");
	}

	function getOperatoriNonAttivi(){
		return mysql_query("select * from operatori where abilitato=0 order by login");
	}	
	
	function getUfficiAttivi(){
		return mysql_query("select * from uffici where abilitato=1 order by nome");
	}

	function getUfficiNonAttivi(){
		return mysql_query("select * from uffici where abilitato=0 order by nome");
	}		

	function getTipologieAttive(){
		return mysql_query("select * from servizi where abilitato=1 and id_padre=0 order by nome");
	}
	

	function getTipologieNonAttive(){
		return mysql_query("select * from servizi where abilitato=0 and id_padre=0 order by nome");
	}	
	
	function getTipologia($id_servizio){

		$array= mysql_fetch_array(mysql_query("select * from servizi where id='".$id_servizio."'"));
		
		if ($array)
		{	
			$array_padre=mysql_fetch_array(mysql_query("select * from servizi where id='".$array['id_padre']."'"));
		 	if ($array_padre) return $array_padre;
		 }
		return "[tipologia non disponibile]";
	}

	function getUfficioServizio($id_servizio){

		$array= mysql_fetch_array(mysql_query("select * from servizi where id='".$id_servizio."'"));
		return $array['id_ufficio'];
	}	
	
	function getTipologiaNome($id_servizio){

		$array= mysql_fetch_array(mysql_query("select * from servizi where id='".$id_servizio."'"));
		
		if ($array)
		{	
			$array_padre=mysql_fetch_array(mysql_query("select * from servizi where id='".$array['id_padre']."'"));
		 	if ($array_padre) return $array_padre['nome'];
		 }
		return "nessuna";
	}				
	
	function getWorkflow(){

		return $_SESSION['work_flow'];
	}	
	
	function getWokflowNome($id_workflow){

		return $_SESSION['work_flow'][$id_workflow];
	}

	function getWorkflowSemplice(){

		return 0;
	}	
	
	function getWorkflowAvanzato(){

		return 1;
	}		
		
	function getServiziAttivi($id_padre)
 	{	
		return mysql_query("select * from servizi where id_padre='".$id_padre."' and abilitato=1 order by nome");
	}
	
	function getServiziAttiviTutti()
 	{	
		return mysql_query("select * from servizi where id_padre<>0 and abilitato=1 order by nome");
	}
	
	function getServiziNonAttivi($id_padre)
 	{	
		return mysql_query("select * from servizi where id_padre='".$id_padre."' and abilitato=0 order by nome");
	}
	
	function getServiziNonAttiviTutti()
 	{	
		return mysql_query("select * from servizi where id_padre<>0 and abilitato=0 order by nome");
	}

	function geServizi($id_padre)
 	{	
		return mysql_query("select * from servizi where id_padre='".$id_padre."' order by nome");
	}

	function getServiziOperatore($id_operatore)
 	{	
		$result=mysql_query("select * from servizi_operatori where id_operatore='".$id_operatore."'");
		
		$index=0;
		while ($array=mysql_fetch_array($result)){
			$array_res[$index]=$array['id_servizio'];
			$index++;
		}

		return $array_res;
	}

	function isInDatabase($email){
		$array=mysql_fetch_array(mysql_query("select * from utenti where email='".$email."'"));

		if ($array) return true;
		return false;
	}	
		
	//Funzioni di inserimento
	//=======================
	function insertServizio($nome, $abilitato, $id_padre){
		return mysql_query ("insert into servizi(nome,abilitato,id_padre) values('".$nome."','".$abilitato."','".$id_padre."')");
	}

	function insertServizioOperatore($id_operatore, $id_servizio){
		return mysql_query ("insert into servizi_operatori(id_operatore,id_servizio) values('".$id_operatore."','".$id_servizio."')");
	}	

	function insertUfficio($abilitata, $nome, $descrizione){
		return mysql_query ("insert into uffici(abilitato, nome,descrizione) values('".$abilitata."','".$nome."','".$descrizione."')");
	}	
		
	function insertOperatori($servizio, $ruolo, $abilitato, $nome, $cognome, $email, $login, $password, $today){
		$res=mysql_query ("insert into operatori(id_ruolo,abilitato,nome,cognome,email,login,password,data) values('".$ruolo."','".$abilitato."','".$nome."','".$cognome."','".$email."','".$login."','".$password."','".$today."')");

		//aggiungo la corrispondenza servizio/operatore
		mysql_query("insert into servizi_operatori(id_operatore,id_servizio) values('".mysql_insert_id()."','".$servizio."')");

		return $res;
	}
	
	function insertRuolo($nome){
		return mysql_query ("insert into operatori_ruoli(nome) values('".$nome."')");
	}

	function insertUtenti($nome, $cognome, $email, $telefono){
		return mysql_query ("insert into utenti(nome,cognome,email,telefono) values('".$nome."','".$cognome."','".$email."','".$telefono."')");
	}
	
	function insertExtra($titolo_domanda, $tipo, $servizio, $abilitato, $breve, $descrizione_risposta, $data){
		return mysql_query ("insert into extra(id_tipo,id_servizio,abilitato,titolo_domanda,breve,descrizione_risposta,data) values('".$tipo."','".$servizio."','".$abilitato."','".$titolo_domanda."','".$breve."','".$descrizione_risposta."','".convertiData($data)."')");
	}
	
	function insertDocument($id_ufficio, $id_servizio, $id_utente, $protocollo_tipo, $protocollo, $id_modalita_ricezione, $protocollo_esterno, $data_invio, $oggetto, $allegato, $data){

		$result=mysql_query ("insert into document(id_ufficio,id_servizio,id_utente, protocollo_tipo, protocollo, id_modalita_ricezione, protocollo_esterno, data_invio, oggetto, allegato,data) values('".$id_ufficio."','".$id_servizio."','".$id_utente."','".$protocollo_tipo."','".$protocollo."','".$id_modalita_ricezione."','".$protocollo_esterno."','".convertiData($data_invio)."','".$oggetto."','".$allegato."','".convertiData($data)."')");

		return mysql_insert_id();
	}

	function insertDocumentAssegnatario($id,$id_operatore,$id_stato,$nota,$file,$data)
	{	
		$result=mysql_query("insert into document_ass(id_document,id_operatore,id_stato,nota,allegato,data) values('".$id."','".$id_operatore."','".$id_stato."','".$nota."','".$file."','".convertiData($data)."')");

		return mysql_insert_id();

	}
	
	function insertDocumentRisposta($id_document,$id_document_assegnazione,$risposta,$allegato,$data_risposta)
	{	$result=mysql_query("insert into document_risp(id_document,id_document_ass,testo,allegato,data_risposta) values('".$id_document."','".$id_document_assegnazione."','".$risposta."','".$allegato."','".convertiData($data_risposta)."')");

		return mysql_insert_id();
	}
	
	function insertDocumentNotaRisposta($id_risposta,$nota,$data_nota)
	{	
		return mysql_query("update document_risp set nota_responsabile='".$nota."', data_nota='".convertiData($data_nota)."' where id=".$id_risposta);
	}	
	
	//Funzioni di eliminazione
	//========================
	
	function eliminaExtra($id_extra){
		return mysql_query ("delete from extra where id='".$id_extra."'");
	}

	function eliminaAssegnazioneServizio($id_operatore, $id_servizio){
		return mysql_query ("delete from servizi_operatori where id_operatore='".$id_operatore."' and id_servizio='".$id_servizio."'");
	}	
	
	//Funzioni di modifica
	//=======================
	
	function abilitaDisabilita($tabella, $id){
		$result = mysql_query("select * from ".$tabella." where id=".$id);

		if ($result){
			$array=mysql_fetch_array($result);
			if ($array['abilitato']==0) $abilitato=1;
			else $abilitato=0;

			return mysql_query ("update ".$tabella." set abilitato='".$abilitato."' where id='".$id."'");
		}
	}
		
	function abilitaDisabilitaOperatore($id){
		return $this->abilitaDisabilita("operatori",$id);
	}	
	

	function abilitaDisabilitaUfficio($id)
	{
		return $this->abilitaDisabilita("uffici",$id);
	}

	function abilitaDisabilitaServizi($id)
	{
		return $this->abilitaDisabilita("servizi",$id);
	}
	
	function abilitaDisabilitaLDAP(){
		$result = mysql_query("select * from configurazioni order by id desc");

		if ($result){
			$array=mysql_fetch_array($result);
			if ($array['ldap']==0) $abilitato=1;
			else $abilitato=0;

			return mysql_query ("update configurazioni set ldap='".$abilitato."' where id='".$array['id']."'");
		}
	}	
		
	function updateSet($id, $table, $constraints_name, $constraints_value)
	{
		if ($id !="" and $table!="" and $constraints_name!="" and $constraints_value!="")
			return mysql_query("update ".$table." set ".$constraints_name."='".$constraints_value."' where id=".$id);
	}

	function abilitaDisabilitaExtra($id_extra)
	{
		return $this->abilitaDisabilita("extra",$id_extra);
	}			

	//Funzioni varie
	//======================
	

	function creaNuovoProtocollo($tipo)
	{
			$result_last = mysql_query ("select * from document where protocollo_tipo='".$tipo."' order by protocollo desc");
			$array_last=mysql_fetch_array($result_last);	

			if ($array_last) return ((int)$array_last['protocollo'])+1;		
			return 1;		
	}
	
	function getSiglaEnte()
	{
		return $_SESSION['ENTE_SIGLA'];
	}	

	function getNomeEnte()
	{
		return $_SESSION['ENTE'];
	}	
	
	function updateEnte($nome, $sigla)
	{	$result = mysql_query("select * from configurazioni order by id desc");

		if ($result){
			$array=mysql_fetch_array($result);
			$_SESSION['ENTE']=$nome;
			$_SESSION['ENTE_SIGLA']=$sigla;
			return mysql_query ("update configurazioni set ente='".$nome."', ente_sigla='".$sigla."' where id='".$array['id']."'");
		}
	}	
	
	function getNuovoProtocolloCompletoUfficio($nuovo_protocollo, $ufficio)
	{
		return $this->getSiglaEnte().$nuovo_protocollo;
	}	
	

	function getProtocolloCompleto($id)
	{
		$tk= $this->getDocument($id);
		if ($tk)	
		{	
			$result_document = mysql_query ("select * from document where id='".$id."'");
			$array_document=mysql_fetch_array($result_document);	 
			
			return $_SESSION['ENTE_SIGLA'].$array_document['protocollo'];
		}
		return "";	
	}

	function getProtocolloNumerico($protocollo)
	{
		return substr($protocollo, 2);
	}		

	function canModifyStato($workflow, $id_document_ass, $id_document_stato_nome)
	{
		$aut = 0;
		
		if (($id_document_stato_nome==$_SESSION['stati'][$this->getStatoValidato()]) && $workflow==$this->getWorkflowAvanzato())
		{
			if ($this->loggedOperatoreRole==$this->getRuoloSupervisoreId())	
			{
				$num_stati = count($_SESSION['stati_modifica_supervisore']);
				$i=0;
				while ($i<$num_stati && !$aut){
					$aut=$_SESSION['stati_modifica_supervisore'][$i]==$id_document_stato_nome;
					$i=$i+1;
				}
			}
		} else{
			if ($id_document_ass==$this->loggedOperatoreId)
			{ 
				$num_stati = count($_SESSION['stati_modifica_assegnatario']);
	
				$i=0;
				while ($i<$num_stati && !$aut){
					$aut=$_SESSION['stati_modifica_assegnatario'][$i]==$id_document_stato_nome;
					$i=$i+1;
				}
				
			}if ($this->loggedOperatoreRole==$this->getRuoloResponsabileId())
			{
				$num_stati = count($_SESSION['stati_modifica_responsabile']);
				$i=0;
				while ($i<$num_stati && !$aut){
					$aut=$_SESSION['stati_modifica_responsabile'][$i]==$id_document_stato_nome;			
					$i=$i+1;
				}
			}	
		} 
				
		return $aut;
	}	

	function getModalitaRicezione()
	{
		return $_SESSION['modalita_ricezione'];
	}

	function getModalitaRicezioneNome($id_modalita_ricezione)
	{
		return $_SESSION['modalita_ricezione'][$id_modalita_ricezione];
	}

	function getIDreportDocumentEvasiInevasi()
	{
		return 0;
	}

	function getIDreportDocumentEvasi()
	{
		return 1;
	}
	
	function getIDreportDocumentInevasi()
	{
		return 2;
	}
	
	function getReport($tipo)
	{
		return $_SESSION['tipo_report'][$tipo];
	}

	function getExtraAvvisiId()
	{
		return 0;
	}	

	function getExtraKnowledgebaseId()
	{
		return 1;
	}	
	
	//Funzioni di ricerca
	//=====================
	function cercaPerProtocollo($protocollo)
	{
		if ($this->getLoggedOperatoreRole()==$this->getRuoloProtocollatoreId() || $this->getLoggedOperatoreRole()==$this->getRuoloSupervisoreId())
		{
			$query="select * from document where protocollo='".$protocollo."'";
		}else 
		{
			$servizi=$this->getLoggedOperatoreServizi();
			
			$query="select * from document where protocollo='".$protocollo."'";
			
			if (count($servizi)>0)
			{
				$query=$query." and (id_servizio='".$servizi[0]."'";
	
				for ($index=1; $index<count($servizi); $index++)
					$query=$query." or id_servizio='".$servizi[$index]."'";
	
				$query=$query." )";
			}
			
			//$query=$query." and id_ufficio='".getUfficioServizio($this->loggedOperatore."'";
			
			//verifico se l'eventuale utente collaboratore è colui che ha lavorato il document
			//$array_tmp=mysql_fetch_array(mysql_query($query));
			//if ($this->getLoggedOperatoreRole()==$this->getRuoloCollaboratoreId())
			//if ($this->getDocumentAssInLavorazione($array_tmp['id'])!=$this->getLoggedOperatoreID()) $query="";

		}
		return mysql_query($query);
	}


	function cercaPerData($data)
	{
		if ($this->getLoggedOperatoreRole()==$this->getRuoloProtocollatoreId() || $this->getLoggedOperatoreRole()==$this->getRuoloSupervisoreId())
		{
			$query="select * from document where data='".convertiData($data)."'";
		}else
		{	
			$servizi=$this->getLoggedOperatoreServizi();
			
			$query="select * from document where data='".convertiData($data)."'";
			
			if (count($servizi)>0)
			{
				$query=$query." and (id_servizio='".$servizi[0]."'";
	
				for ($index=1; $index<count($servizi); $index++)
					$query=$query." or id_servizio='".$servizi[$index]."'";
	
				$query=$query." )";
			}
			
			//$query=$query." and id_ufficio='".$this->loggedOperatore."'";
		}

		return mysql_query($query);
		
	}	

	function cercaPerUtente($utente)
	{
		if ($this->getLoggedOperatoreRole()==$this->getRuoloProtocollatoreId() || $this->getLoggedOperatoreRole()==$this->getRuoloSupervisoreId())
		{
			$query="select * from document where id_utente='".$utente."'";
		}else 
		{		
			$servizi=$this->getLoggedOperatoreServizi();
			
			$query="select * from document where id_utente='".$utente."'";
			
			if (count($servizi)>0)
			{
				$query=$query." and (id_servizio='".$servizi[0]."'";
	
				for ($index=1; $index<count($servizi); $index++)
					$query=$query." or id_servizio='".$servizi[$index]."'";
	
				$query=$query." )";
			}
			
			//$query=$query." and id_ufficio='".$this->loggedOperatore."'";
		}
		return mysql_query($query);
		
	}	
	
	function cercaExtra($keyword)
	{
		return mysql_query("select * from extra where titolo_domanda like '%".$keyword."%' or descrizione_risposta like '%".$keyword."%' and abilitato=1");
	}	
	
	//Funzioni per la generazione dei Report
	//=======================================
	
	function reportGetNomeTipologia($id_report, $id_tipo)
	{
		return $_SESSION['tipo_report'][$id_tipo][$id_report];
	}	
		
	function reportFilterQuery($ufficio, $modalita_ricezione, $tipo_protocollo, $tipologia, $servizio,$da, $a)
	{	
		$constraints="";
		if ($modalita_ricezione!=-1)
			$constraints=" and id_modalita_ricezione='".$modalita_ricezione."'"; 
			
		if ($tipo_protocollo!=-1)
			$constraints=" and protocollo_tipo='".$tipo_protocollo."'"; 			

		if ($servizio!=-1 && $servizio!=0)
			$constraints=$constraints." and id_servizio='".$servizio."'";
		else if ($tipologia!=-1)
			{
				$result_servizi_tipologia = $this->getServiziAttivi($tipologia);
				$array_atp=mysql_fetch_array($result_servizi_tipologia);
				$constraints=$constraints." and (id_servizio='".$array_atp['id']."'";
				
				do{
					$constraints=$constraints." or id_servizio='".$array_atp['id']."'";
				}while ($array_atp=mysql_fetch_array($result_servizi_tipologia));
				
				$constraints=$constraints.")";		
		}
		
		if ($da!="" && $da!=-1) $constraints=$constraints." and data >='".convertiData($da)."'";
		if ($a!="" && $a!=-1) $constraints=$constraints." and data <='".convertiData($a)."'";

		return mysql_query("select * from document where id_ufficio='".$ufficio."' ".$constraints. " order by id_ufficio, protocollo DESC");
		
	}	

	function reportDocumentsHistory($ufficio, $modalita_ricezione, $tipo_protocollo, $tipologia, $servizio,$da, $a, $chiuse)
	{	
		$result = $this->reportFilterQuery((int)$ufficio, (int)$modalita_ricezione, (int)$tipo_protocollo, (int)$tipologia, (int)$servizio,$da, $a);		
		
		//$array[x][0] Protocollo
		//$array[x][1] Nome Utente
		//$array[x][2] Tipologia
		//$array[x][3] Servizio
		//$array[x][4] Modalità di Ricezione
		//$array[x][5] Data Pervenimento
		//$array[x][6] Data di Presa in Carico
		//$array[x][7] Data di Predisposizione
		//$array[x][8] Data di Validazione
		//$array[x][9] Data di Evasione

		$index=0;
		
		$array=array();
		while($array_tmp=mysql_fetch_array($result))
		{	
			$array[$index][0] = $this->getProtocolloCompleto($array_tmp['id']);
			$array[$index][1] = $this->getUtenteNome($array_tmp['id_utente'])." ".$this->getUtenteCognome($array_tmp['id_utente']);
			$array[$index][2] = $this->getTipologiaNome($array_tmp['id_servizio']);
			$array[$index][3] = $this->getServizioNome($array_tmp['id_servizio']);
			$array[$index][4] = $this->getModalitaRicezioneNome($array_tmp['id_modalita_ricezione']);
			$array[$index][5] = visualizzaDataEuro($array_tmp['data']);
			$array[$index][6] = $this->getDocumentDataInLavorazione($array_tmp['id']);
			$array[$index][7] = $this->getDocumentDataPredisposto($array_tmp['id']);
			$array[$index][8] = $this->getDocumentDataValidato($array_tmp['id']);
			$array[$index][9] = $this->getDocumentDataEvaso($array_tmp['id']);
			
			$index=$index+1;
		}		
		
		return $array;
	}
	
	function reportRichiesteEvaseInevase($ufficio, $modalita_ricezione, $tipo_protocollo, $tipologia, $servizio,$da, $a, $chiuse)
	{	
		$result = $this->reportFilterQuery((int)$ufficio, (int)$modalita_ricezione, (int)$tipo_protocollo, (int)$tipologia, (int)$servizio,$da, $a);		

		$array[0]=0; //Totale Aperti
		$array[1]=0; //Totale Chiusi
		$array[2]=0; //Totale
		$array[3]=0; //%Aperte
		$array[4]=0; //%Chiuse

		while($array_tmp=mysql_fetch_array($result))
		{	
			$stato_document=$this->getStatoAttuale($array_tmp['id']);
			if (($chiuse==1 || $chiuse==-1) && ($stato_document==$this->getStatoFinale())){
				$array[0]=$array[0]+1;
				$array[2]=$array[2]+1;
			}
			else if (($chiuse==0 || $chiuse==-1) && ($stato_document!=$this->getStatoFinale())){
				$array[1]=$array[1]+1;
				$array[2]=$array[2]+1;
			}
		}
		
		
		//%evasi
		if ($array[2] >0){
			$array[3]=(int)(($array[0]/$array[2])*100);
			$array[4]=100-$array[3];
		}

		return $array;
		
	}
	
	function reportComposizioneEvaseInevase($ufficio, $modalita_ricezione, $tipo_protocollo, $tipologia, $servizio,$da, $a)
	{	
		$result = $this->reportFilterQuery((int)$ufficio, (int)$modalita_ricezione, (int)$tipo_protocollo, (int)$tipologia, (int)$servizio,$da, $a);	

		$array[0]=0; //Totale Chiusi
		$array[1]=0; //Totale Aperti
		$array[2]=0; //Totale
		$array[3]=0; //%Evasi
		$array[4]=0; //%Inevasi
		
		while($array_tmp=mysql_fetch_array($result))
		{
			$stato_document=$this->getStatoAttuale($array_tmp['id']);
			if ($stato_document!=$this->getStatoIniziale()) $array[0]=$array[0]+1;
			else $array[1]=$array[1]+1;
			//totale
			$array[2]=$array[2]+1;
		}
		
		//%evasi
		if ($array[2] >0){
			$array[3]=(int)(($array[0]/$array[2])*100);
			$array[4]=100-$array[3];
		}

		return $array;
		
	}	
	

	//$stato = "": document tutti
	//$stato = -1: document tutti	aperti
	//$stato = xx: document nello stato specificato
	function reportServizi($ufficio, $modalita_ricezione, $tipo_protocollo, $tipologia, $servizio,$da, $a, $stato)
	{	
		
		$result = $this->reportFilterQuery((int)$ufficio, (int)$modalita_ricezione, (int)$tipo_protocollo, (int)$tipologia, (int)$servizio,$da, $a);
		$result_servizi =$this->getServiziAttiviTutti();
	
		//creo le posizioni per i servizi
		while($array_servizi=mysql_fetch_array($result_servizi))
		{
			$array_totale_servizio[$array_servizi['id']]=0;
		}
		
		$totale_document=0;
		while($array_tmp=mysql_fetch_array($result))
		{ 
			//verifico quale tipo di document visualizzare in base alla stato
			if ($stato!="" && (($stato!=-1 && ($this->getStatoAttuale($array_tmp['id'])!=$stato)) || ($stato==-1 && ($this->getStatoAttuale($array_tmp['id'])==$this->getStatoFinale()))))
				continue;
				
			$array_totale_servizio[$array_tmp[id_servizio]]=$array_totale_servizio[$array_tmp[id_servizio]]+1;
			$totale_document=$totale_document+1;
		}

		mysql_data_seek ($result_servizi, 0);
		while($array_servizi=mysql_fetch_array($result_servizi))
		{
			if ($totale_document!= 0)
				$array_percentuale_servizio[$array_servizi['id']]=(int)(($array_totale_servizio[$array_servizi['id']]/$totale_document)*100);
			else $array_percentuale_servizio[$array_servizi['id']]=0;
		}		

		//Sistemo la somma delle percentuali in modo che sia esattamente 100
		mysql_data_seek ($result_servizi, 0);
		$totale_percentuale=0;
		$ultimo_id=0;
		while($array_servizi=mysql_fetch_array($result_servizi))
		{
			if ($array_percentuale_servizio[$array_servizi['id']]!= 0){
				$totale_percentuale = $totale_percentuale + $array_percentuale_servizio[$array_servizi['id']];
				$ultimo_id=$array_servizi['id'];
			}
		}		
		if ($totale_percentuale!=100)
		{		
				$totale_percentuale = $totale_percentuale - $array_percentuale_servizio[$ultimo_id];
				$array_percentuale_servizio[$ultimo_id] = 100 - $totale_percentuale;
		}
		
		$array_res[0]=$array_totale_servizio;
		$array_res[1]=$array_percentuale_servizio;
		$array_res[2]=$totale_document;
		
		return $array_res;
		
	}	

function reportTempisticaRichieste($ufficio, $modalita_ricezione, $tipo_protocollo, $tipologia, $servizio,$da, $a, $chiuse)
	{	
		$result = $this->reportFilterQuery((int)$ufficio, (int)$modalita_ricezione, (int)$tipo_protocollo, (int)$tipologia, (int)$servizio,$da, $a);

		$array[0]=0; //Tempistica > 15gg
		$array[1]=0; //Tempistica 11-15 gg
		$array[2]=0; //Tempistica 6-10 gg
		$array[3]=0; //Tempistica <= 5 gg
		$array[4]=0; //Totale	
		$array[5]=0; //%Tempistica > 15gg
		$array[6]=0; //%Tempistica 11-15 gg
		$array[7]=0; //%Tempistica 6-10 gg
		$array[8]=0; //%Tempistica <= 5 gg

		while($array_tmp=mysql_fetch_array($result))
		{
			$stato_document=$this->getStatoAttuale($array_tmp['id']);
			$diff_gg="";

			if (($chiuse==1 || $chiuse==-1) && ($stato_document==$this->getStatoFinale())){
				$diff_gg=(strtotime($ass_tmp['data']) - strtotime($array_tmp['data']))/(86400);
				}
			if (($chiuse==0 || $chiuse==-1) && ($stato_document!=$this->getStatoFinale())){
				$diff_gg=(strtotime(date("Y/m/d")) - strtotime($array_tmp['data']))/(86400);
				}

			if ($diff_gg!=""){
				if ($diff_gg > 15){ $array[0]=$array[0]+1; }
				else if ($diff_gg < 15 && $diff_gg >= 11){ $array[1]=$array[1]+1;}
				else if ($diff_gg < 11 && $diff_gg >= 6){ $array[2]=$array[2]+1;}
				else if ($diff_gg <= 5){ $array[3]=$array[3]+1;}
	
				//totale
				$array[4]=$array[4]+1;
			}

		}
		
		//% >15
		if ($array[4] >0){
			$array[5]=(int)(($array[0]/$array[4])*100);
		
			//% 11-15
			$array[6]=(int)(($array[1]/$array[4])*100);
	
			//% 6-10
			$array[7]=(int)(($array[2]/$array[4])*100);

			//% <=5
			$array[8]=100-$array[5]-$array[6]-$array[7];
		}	
		return $array;
		
	}

}
	

// se non c'è l'oggetto in sessione allora lo creo e lo inserisco   
if (!isset($_SESSION['connessione'])) $_SESSION['connessione'] = new sast1com();   
  
// lego la variabile $oggetto all'oggetto in sessione   
$objCore = &$_SESSION['connessione'];  

$objCore->connessione();
?>