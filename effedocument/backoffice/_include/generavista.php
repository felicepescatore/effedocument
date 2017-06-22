<!-- Applicazione:eFFe Document-->
<!-- Versione: 2.1.0.200-->
<!-- Data Rilascio: 02 Febbraio 2010-->
<!-- Developer: ing. Felice Pescatore-->

<?php
		$paginazione=30;
		if (isset($_GET['pagina'])) $pagina=$_GET['pagina'];
		else $pagina="";
		if ($pagina=="" || $pagina <1) $pagina=1;
		
		$inizio_visualizzazione = $paginazione*($pagina-1);

        echo "<tr style=\"background-image:url(../../common/images/icon/bgfooter.gif);\">";
   		echo "<td width=\"6\"><b>dettagli</b></td>";
		echo "<td width=\"6\"><b>barcode</b></td>";
		echo "<td><b>tipo</b></td>";		
        echo "<td><b>protocollo</b></td>";		
        echo "<td><b>data</b></td>";
       	echo "<td><b>tipologia</b></td>";
		echo "<td><b>servizio</b></td>";
        echo"<td><b>stato</b></td>";
        echo "<td><b>priorita</b></td>";
		if (($objCore->getLoggedOperatoreRole()==$objCore->getRuoloResponsabileId()) || ($objCore->getLoggedOperatoreRole()==$objCore->getRuoloProtocollatoreId()) ||($objCore->getLoggedOperatoreRole()==$objCore->getRuoloSupervisoreId()))
        	echo "<td><b>operatore</b></td>";
		echo "<td width=\"5\"><b>allegato</b></td>";
		if ($objCore->getLoggedOperatoreRole() != $objCore->getRuoloProtocollatoreId())
			echo "<td width=\"5\"><b>rispondi</b></td>";
        echo "</tr>";
		
		//Salto i record per la paginazione
		$iter=0;
		while($iter++<$inizio_visualizzazione && ($array=mysql_fetch_array($result)));

		$iter=0;
        while($iter++<$paginazione && (isset($result) && $result && $array=mysql_fetch_array($result))){//recupero lo stato
			//necessario perchè la funzione getDocumentOperatore() ritorna i valori della tabella document_ass
			if (($objCore->getLoggedOperatoreRole()==$objCore->getRuoloCollaboratoreId() || $objCore->getLoggedOperatoreRole()==$objCore->getRuoloSupervisoreId())){
				echo "in";
				$array_doc = $objCore->getDocument($array['id_document']);
			} else $array_doc=$array;
			
			//calcolo la priorità del document
			$calc_priorita=calcPriorita($array_doc['data']);

			//verifico se l'utente ha selezionato ingresso/uscita e se il document attuale è corrispondente
			if (isset($ingressouscita) && $ingressouscita!="" && $ingressouscita!=-1 &&($ingressouscita!=$array_doc['protocollo_tipo'])) continue;
			
			//verifico se l'utente ha selezionato una priorita e se il document attuale è corrispondente
			if (isset($priorita) && $priorita!="" && $priorita!=-1 &&($calc_priorita!=$priorita)) continue;

			//verifico se l'utente ha selezionato una operatore è se il document attuale è corrispondente
			if (isset($operatore) && $operatore!="" && $operatore!=-1 && ($objCore->getDocumentAssId($array_doc['id'])!=$operatore)) continue;

			//verifico se l'utente ha selezionato una operatore è se il document attuale è corrispondente
			if (isset($_ricerca) && $_ricerca==true && ($objCore->getLoggedOperatoreRole()==$objCore->getRuoloCollaboratoreId()) && ($objCore->getDocumentAssId($array_doc['id'])!=$objCore->getLoggedOperatoreID())) continue;				

			//verifico se l'utente ha selezionato un servizio e se il document attuale è corrispondente
			if (isset($servizio) && $servizio!="" && $servizio!=-1 && ($objCore->getServizioId($array_doc['id'])!=$servizio)) continue;
				
			$array_statot = $objCore->getDocumentAss($array_doc['id']);
			$document_stato=$objCore->getStatoAttuale($array_doc['id']);
			$document_stato_nome=$objCore->getStatoAttualeNome($array_doc['id']);
			$document_stato_data=$objCore->getStatoAttualeData($array_doc['id']);
			$document_protocollo=$objCore->getProtocolloCompleto($array_doc['id']);
			$document_tipoprotocollo=$objCore->getProtocolloIngressoUscita($array_doc['id']);
			$document_data=$array_doc['data'];
			$document_tipologia=$objCore->getTipologiaNome($array_doc['id_servizio']);
			$document_workflow=$objCore->getDocumentWorkflow($array_doc['id']);
			$document_assegnatario_id=$objCore->getDocumentAssId($array_doc['id']);
			$document_assegnatario_nome=$objCore->getDocumentAssNome($array_doc['id']);
			$document_servizio=$objCore->getServizioNome($array_doc['id_servizio']);
			$utente=$objCore->getUtente($array_doc['id_utente']);

			if($calc_priorita==0)echo "<tr bgcolor=\"#ffffff\">";
            else if($calc_priorita==1)echo "<tr bgcolor=\"#99ffcc\">";
            elseif($calc_priorita==2)echo "<tr bgcolor=\"#ffcc99\">";
            elseif($calc_priorita=3)echo "<tr bgcolor=\"#ff6666\">";

			if($document_stato==$objCore->getStatoFinale()) echo "<tr bgcolor=\"#999999\">";

			echo "<td><a href=\"javascript:apri('dettagli','service_vedi_document.php?id=".$array_doc['id']."&id_servizio=".$array_doc['id_servizio']."',500,600);\"><img src=\"../../common/images/icon/vedi.gif\" border=0></a></td>";         
			echo "<td align=\"center\"><a href=\"javascript:apri('protocollo','../../common/barcode/make.php?protocollo=".$objCore->getProtocolloNumerico($document_protocollo)."',500,600)\"><img src=\"../../common/images/icon/minibarcode.png\"></a></td>";
			echo "<td>".$document_tipoprotocollo."</td>";
            echo "<td>".$document_protocollo."</td>";			
            echo "<td>".visualizzaDataEuro($document_data)."</td>";		
			echo "<td>".$document_tipologia."</td>";
			echo "<td>";
			echo $document_servizio;				
			if ((($objCore->getLoggedOperatoreRole() == $objCore->getRuoloResponsabileId()) && ($document_stato==$objCore->getStatoAssegnato() && ($document_assegnatario_id == $objCore->getLoggedOperatoreID()))) || (($objCore->getLoggedOperatoreRole() == $objCore->getRuoloProtocollatoreId()) && ($document_stato==$objCore->getStatoIniziale())))
            	echo " <a onclick=\"return(confirm('Sei sicuro di voler cambiare il tipo di servizio?'))\" href=\"../modifica/modifica_document_servizio.php?id=".$array_doc['id']."&id_servizio=$array_doc[id_servizio]\">[cambia]</a>";
			echo "</td>";
            echo"<td>".$document_stato_nome." [".visualizzaDataEuro($document_stato_data)."]";
			if ($objCore->canModifyStato($document_workflow, $document_assegnatario_id,$document_stato_nome))
				echo " <a onclick=\"return(confirm('Sei sicuro di voler cambiare lo stato??'))\" href=\"../modifica/modifica_stato.php?id=".$array_doc['id']."&id_stato=".$document_stato."\">[cambia]</a></td>";
            echo"<td>".$objCore->getPrioritaNome($calc_priorita);
			if (($objCore->getLoggedOperatoreRole()==$objCore->getRuoloResponsabileId()) || ($objCore->getLoggedOperatoreRole()==$objCore->getRuoloProtocollatoreId())|| ($objCore->getLoggedOperatoreRole()==$objCore->getRuoloSupervisoreId())){
				echo "<td>".$document_assegnatario_nome;
				if ($document_assegnatario_id==$objCore->getLoggedOperatoreId() && $document_stato<=$objCore->getStatoAssegnato())
				echo " <a onclick=\"return(confirm('Sei sicuro di voler cambiare  operatore??'))\" href=\"../modifica/modifica_assegnatario.php?id=".$array_doc['id']."&id_servizio=$array_doc[id_servizio]\">[cambia]</a></td>";
			}
			echo "<td><a href=\"..\\".getDocumentiUploadDir().$array_doc['allegato']."\"><b><font color=#00ccff>".$array_doc['allegato']."</b></font></a></td>";
			if ($objCore->getLoggedOperatoreRole() != $objCore->getRuoloProtocollatoreId()){
				if (($objCore->getStatoAttuale($array_doc['id'])==$objCore->getStatoValidato() && $document_workflow==0) || ($objCore->getStatoAttuale($array_doc['id'])==$objCore->getStatoAutorizzato() && $document_workflow==1))
					echo "<td><a href=\"..\service\service_invia_risposta.php?id=".$array_doc['id']."\"><img src=\"../../common/images/icon/email.gif\" border=0></a></td>"; 			
				else
					echo "<td><img src=\"../../common/images/icon/icon_error.gif\" border=0></td>"; 	
			}
            echo "</tr>";
        }

	//Visualizza i link relativi alla navigazione dovuta alla paginazione
    if ($inizio_visualizzazione != 0){
        $prevoffset = $pagina-1;
        print "<a href=\"..\service\service_pannello.php?pagina=$prevoffset\">PREV</a>&nbsp;\n";
    }
    if ($iter==$paginazione){
        $nextoffset = $pagina+1;
        print "<a href=\"..\service\service_pannello.php?pagina=$nextoffset\">NEXT</a>&nbsp;\n";
    }	
    ?>