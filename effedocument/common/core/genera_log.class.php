<?php
 
class genera_log
{
#
# Esempio di utilizzo della classe:
# $log = new genera_log('directory dei log','file di log');
# $log->intestazione_log();
# $log->scrivi_riga('stringa da scrivere esempio nome utente, ora di accesso, ecc...');
# $log->scrivi_riga('seconda riga da scrivere');
# ...
# $log->scrivi_riga_separatore();
# $log->chiudi_file_log();

	var $handler;
	var $nome_file;
	var $data;
 
	function genera_log($dir,$nome_file) 
	{
 		$this->data = date("d-m-Y");
 		$this->apri_file_scrittura($dir,$nome_file);
	}
 
	function apri_file_scrittura($dir,$nome_file)
	{
 		if (($dir != "")&&($nome_file != ""))
		{
 			$nome_file = $nome_file."_".$this->data.".log";
			$this->nome_file = $nome_file;
			if (file_exists($dir.$nome_file)) 
				$this->handler = @fopen($dir.$nome_file,'a');
			else{
				$this->handler = @fopen($dir.$nome_file,'w');
				$this->intestazione_log();
			}
 		}
 	}
 
	function get_nome_file_log()
 	{
 		return $this->nome_file;
	}
 
	function intestazione_log()
 	{
		$out = "# eFFe Document::log automatico generato il ".$this->data;
		$this->scrivi_riga($out);
		$out = "## Nome file : ".$this->nome_file;
		$this->scrivi_riga($out);
		$out = "## --------------------------------------------------------------------";
		$this->scrivi_riga($out);
		$this->scrivi_riga($out);

 	}
 
	function scrivi_riga($stringa)
 	{
 		if ($this->handler != FALSE)
 		{
 			if (fwrite($this->handler,".".$stringa."\r\n"))
 			{ return 1;}
			return 0;
 		}
 		return 0;
 	}
 
	function scrivi_riga_separatore()
 	{
 		$this->scrivi_riga("*********************************************************n");
 	}
 
	function chiudi_file_log()
 	{
 		fclose($this->handler);
 	}
 
}
 
?>