-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: 12 ott, 2009 at 07:50 PM
-- Versione MySQL: 5.1.36
-- Versione PHP: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `effedocument`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `configurazioni`
--

CREATE TABLE IF NOT EXISTS `configurazioni` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ldap` tinyint(1) NOT NULL,
  `ente` varchar(80) NOT NULL,
  `ente_sigla` varchar(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dump dei dati per la tabella `configurazioni`
--

INSERT INTO `configurazioni` (`id`, `ldap`, `ente`, `ente_sigla`) VALUES
(1, 0, 'avellino2', 'av');

-- --------------------------------------------------------

--
-- Struttura della tabella `document`
--

CREATE TABLE IF NOT EXISTS `document` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_ufficio` int(11) NOT NULL,
  `id_servizio` int(11) NOT NULL DEFAULT '0',
  `id_utente` int(11) NOT NULL,
  `protocollo_tipo` int(11) NOT NULL COMMENT '0=ingresso, 1=uscita',
  `protocollo` bigint(20) NOT NULL,
  `id_modalita_ricezione` int(11) NOT NULL DEFAULT '-1',
  `protocollo_esterno` varchar(20) NOT NULL,
  `data_invio` date NOT NULL,
  `oggetto` text NOT NULL,
  `allegato` varchar(200) NOT NULL,
  `data` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=58 ;

--
-- Dump dei dati per la tabella `document`
--

INSERT INTO `document` (`id`, `id_ufficio`, `id_servizio`, `id_utente`, `protocollo_tipo`, `protocollo`, `id_modalita_ricezione`, `protocollo_esterno`, `data_invio`, `oggetto`, `allegato`, `data`) VALUES
(1, 2, 3, 1, 0, 1, 1, '', '0000-00-00', 'TestTest', '', '2009-10-12'),
(11, 1, 3, 2, 1, 1, 0, '', '0000-00-00', 'TESTTESTTESTTEST', '', '2009-10-12'),
(12, 1, 3, 2, 1, 2, 0, '', '0000-00-00', 'TESTTESTTESTTEST', '', '2009-10-12'),
(13, 1, 3, 2, 1, 3, 0, '', '0000-00-00', 'TESTTESTTESTTEST', '', '2009-10-12'),
(14, 1, 3, 3, 1, 4, 0, '', '0000-00-00', 'rrrrrrrrrrrrrrrrrr', '', '2009-10-12'),
(15, 1, 3, 3, 1, 5, 0, '', '0000-00-00', 'rrrrrrrrrrrrrrrrrr', '', '2009-10-12'),
(16, 1, 3, 3, 1, 6, 0, '', '0000-00-00', 'rrrrrrrrrrrrrrrrrr', '', '2009-10-12'),
(17, 1, 3, 3, 1, 7, 0, '', '0000-00-00', 'rrrrrrrrrrrrrrrrrr', '', '2009-10-12'),
(19, 1, 3, 3, 1, 8, 0, '', '0000-00-00', 'rrrrrrrrrrrrrrrrrr', '', '2009-10-12'),
(20, 1, 3, 3, 1, 9, 0, '', '0000-00-00', 'rrrrrrrrrrrrrrrrrr', '', '2009-10-12'),
(21, 1, 3, 3, 1, 10, 0, '', '0000-00-00', 'rrrrrrrrrrrrrrrrrr', '', '2009-10-12'),
(39, 2, 3, 3, 0, 2, 2, '12', '0000-00-00', 'ddddddddddd', '', '2009-10-12'),
(40, 2, 3, 3, 0, 3, 2, '12', '0000-00-00', 'ddddddddddd', '', '2009-10-12'),
(41, 2, 3, 6, 0, 4, 1, 'pino', '0000-00-00', '', 'av4_2009_09_10_STP_STR_SWApplicativo_vers_0_01.doc', '2009-10-12'),
(42, 2, 3, 6, 0, 5, 1, 'pino', '0000-00-00', '', 'av5_2009_09_10_STP_STR_SWApplicativo_vers_0_01.doc', '2009-10-12'),
(43, 2, 3, 7, 0, 6, 1, '', '0000-00-00', 'ssssssssssssssssssss', 'av6_080909_rodomonti_e_molino_convegno.pdf', '2009-10-12'),
(44, 2, 3, 7, 0, 7, 3, '', '0000-00-00', 'ssssssssssssss', 'av7_080909_rodomonti_e_molino_convegno.pdf', '2009-10-12'),
(45, 2, 3, 7, 0, 8, 2, '', '0000-00-00', 'wwwwww', 'av8_2009_09_10_STP_STR_SWApplicativo_vers_0_01.doc', '2009-10-12'),
(46, 1, 3, 7, 0, 9, 1, '', '0000-00-00', '', '', '2009-10-12'),
(47, 2, 3, 7, 0, 10, 3, '', '0000-00-00', 'ddddddddd', 'av10_080909_rodomonti_e_molino_convegno.pdf', '2009-10-12'),
(48, 2, 3, 7, 0, 11, 1, '', '0000-00-00', 'ssssssssssss', 'av11_acchiapparella.jpg', '2009-10-12'),
(49, 2, 3, 7, 0, 12, 1, '', '0000-00-00', 'ddddddddddd', 'av12_2.jpg', '2009-10-12'),
(50, 2, 3, 7, 0, 13, 1, '', '0000-00-00', 'ddddddddddd', 'av13_2.jpg', '2009-10-12'),
(51, 1, 3, 7, 0, 14, 1, '', '0000-00-00', 'addada', 'av14_50_1_b.jpg', '2009-10-12'),
(52, 1, 3, 7, 0, 15, 1, '', '0000-00-00', 'wwwwwwwwwwwww', 'av15_2.jpg', '2009-10-12'),
(53, 1, 3, 7, 0, 16, 1, '', '0000-00-00', 'wwwwwwwwwwwww', 'av16_2.jpg', '2009-10-12'),
(54, 2, 3, 8, 0, 17, 1, '', '0000-00-00', 'ùùùùùùùùùùùùù', 'av17_copertina_carnevale_2008.jpg', '2009-10-12'),
(55, 1, 3, 7, 1, 11, 0, '', '0000-00-00', 'ssssssssssssss', 'av11_4322.jpg', '2009-10-12'),
(56, 1, 3, 7, 1, 12, 0, '', '0000-00-00', 'dddddddddddddd', 'av12_4322.jpg', '2009-10-12'),
(57, 1, 3, 7, 1, 13, 0, '', '0000-00-00', 'dddddddddddddd', 'av13_4322.jpg', '2009-10-12');

-- --------------------------------------------------------

--
-- Struttura della tabella `document_ass`
--

CREATE TABLE IF NOT EXISTS `document_ass` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_document` int(11) NOT NULL,
  `id_operatore` int(11) NOT NULL,
  `id_stato` int(11) NOT NULL DEFAULT '1',
  `nota` longtext NOT NULL,
  `allegato` varchar(200) NOT NULL,
  `data` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=62 ;

--
-- Dump dei dati per la tabella `document_ass`
--

INSERT INTO `document_ass` (`id`, `id_document`, `id_operatore`, `id_stato`, `nota`, `allegato`, `data`) VALUES
(1, 1, -1, 0, '', '', '2009-10-12'),
(2, 1, -1, 0, '', '', '2009-10-12'),
(3, 1, -1, 0, '', '', '2009-10-12'),
(4, 1, -1, 0, '', '', '2009-10-12'),
(5, 1, -1, 0, '', '', '2009-10-12'),
(6, 1, -1, 0, '', '', '2009-10-12'),
(7, 1, -1, 0, '', '', '2009-10-12'),
(8, 1, 4, 1, '', '', '2009-10-12'),
(9, 5, 4, 1, '', '', '2009-10-12'),
(10, 6, 4, 1, '', '', '2009-10-12'),
(11, 7, 4, 1, '', '', '2009-10-12'),
(12, 8, 4, 1, '', '', '2009-10-12'),
(13, 9, 4, 1, '', '', '2009-10-12'),
(14, 10, 4, 1, '', '', '2009-10-12'),
(15, 11, 4, 1, '', '', '2009-10-12'),
(16, 12, 4, 1, '', '', '2009-10-12'),
(17, 13, 4, 1, '', '', '2009-10-12'),
(18, 14, 4, 1, '', '', '2009-10-12'),
(19, 15, 4, 1, '', '', '2009-10-12'),
(20, 16, 4, 1, '', '', '2009-10-12'),
(21, 17, 4, 1, '', '', '2009-10-12'),
(22, 18, 4, 1, '', '', '2009-10-12'),
(23, 19, 4, 1, '', '', '2009-10-12'),
(24, 20, 4, 1, '', '', '2009-10-12'),
(25, 21, 4, 1, '', '', '2009-10-12'),
(26, 22, 4, 1, '', '', '2009-10-12'),
(27, 23, 4, 1, '', '', '2009-10-12'),
(28, 24, 4, 1, '', '', '2009-10-12'),
(29, 25, 4, 1, '', '', '2009-10-12'),
(30, 26, 4, 1, '', '', '2009-10-12'),
(31, 27, 4, 1, '', '', '2009-10-12'),
(32, 28, 4, 1, '', '', '2009-10-12'),
(33, 29, 4, 1, '', '', '2009-10-12'),
(34, 30, 4, 1, '', '', '2009-10-12'),
(35, 31, 4, 1, '', '', '2009-10-12'),
(36, 32, 4, 1, '', '', '2009-10-12'),
(37, 33, 4, 1, '', '', '2009-10-12'),
(38, 34, 4, 1, '', '', '2009-10-12'),
(39, 35, 4, 1, '', '', '2009-10-12'),
(40, 36, 4, 1, '', '', '2009-10-12'),
(41, 37, 4, 1, '', '', '2009-10-12'),
(42, 38, 4, 1, '', '', '2009-10-12'),
(43, 39, 4, 1, '', '', '2009-10-12'),
(44, 40, 4, 1, '', '', '2009-10-12'),
(45, 41, 4, 1, '', '', '2009-10-12'),
(46, 42, 4, 1, '', '', '2009-10-12'),
(47, 43, 4, 1, '', '', '2009-10-12'),
(48, 44, 4, 1, '', '', '2009-10-12'),
(49, 45, 4, 1, '', '', '2009-10-12'),
(50, 46, 4, 1, '', '', '2009-10-12'),
(51, 47, 4, 1, '', '', '2009-10-12'),
(52, 48, 4, 1, '', '', '2009-10-12'),
(53, 49, 4, 1, '', '', '2009-10-12'),
(54, 50, 4, 1, '', '', '2009-10-12'),
(55, 51, 4, 1, '', '', '2009-10-12'),
(56, 52, 4, 1, '', '', '2009-10-12'),
(57, 53, 4, 1, '', '', '2009-10-12'),
(58, 54, 4, 1, '', '', '2009-10-12'),
(59, 55, 4, 1, '', '', '2009-10-12'),
(60, 56, 4, 1, '', '', '2009-10-12'),
(61, 57, 4, 1, '', '', '2009-10-12');

-- --------------------------------------------------------

--
-- Struttura della tabella `document_risp`
--

CREATE TABLE IF NOT EXISTS `document_risp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_document` int(11) NOT NULL,
  `id_document_ass` int(11) NOT NULL,
  `testo` text NOT NULL,
  `allegato` varchar(200) NOT NULL,
  `data_risposta` date NOT NULL,
  `nota_responsabile` longtext NOT NULL,
  `data_nota` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dump dei dati per la tabella `document_risp`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `extra`
--

CREATE TABLE IF NOT EXISTS `extra` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_tipo` int(11) NOT NULL DEFAULT '0',
  `id_servizio` int(11) NOT NULL DEFAULT '-1',
  `abilitato` tinyint(1) NOT NULL DEFAULT '1',
  `titolo_domanda` varchar(200) NOT NULL,
  `breve` varchar(200) NOT NULL DEFAULT '',
  `descrizione_risposta` longtext NOT NULL,
  `data` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dump dei dati per la tabella `extra`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `operatori`
--

CREATE TABLE IF NOT EXISTS `operatori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_ruolo` int(11) NOT NULL,
  `abilitato` tinyint(1) NOT NULL DEFAULT '0',
  `nome` varchar(60) NOT NULL DEFAULT '',
  `cognome` varchar(60) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `login` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL DEFAULT '',
  `data` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dump dei dati per la tabella `operatori`
--

INSERT INTO `operatori` (`id`, `id_ruolo`, `abilitato`, `nome`, `cognome`, `email`, `login`, `password`, `data`) VALUES
(1, 0, 1, 'admin1', 'admin1', '', 'admin', 'admin', ''),
(2, 3, 1, 'proto1', 'proto1', 'proto1@mail.com', 'proto1', 'proto1', '11 October 2009, 5:02 pm'),
(3, 4, 1, 'report', 'report', 'report@report.it', 'report', 'report', '12 October 2009, 7:05 am'),
(4, 1, 1, 'felice', 'felice', 'felice@mail.com', 'felice', 'felice', '12 October 2009, 10:42 am');

-- --------------------------------------------------------

--
-- Struttura della tabella `servizi`
--

CREATE TABLE IF NOT EXISTS `servizi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_ufficio` int(11) NOT NULL,
  `abilitato` tinyint(1) NOT NULL DEFAULT '0',
  `nome` varchar(50) NOT NULL,
  `workflow` binary(1) NOT NULL DEFAULT '0',
  `id_padre` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dump dei dati per la tabella `servizi`
--

INSERT INTO `servizi` (`id`, `id_ufficio`, `abilitato`, `nome`, `workflow`, `id_padre`) VALUES
(1, 1, 0, 'Dia2', '1', 0),
(2, 2, 1, 'Richieste UTC', '0', 0),
(3, 1, 1, 'DIA', '0', 2),
(4, 2, 1, 'Richiesta DIa', '0', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `servizi_operatori`
--

CREATE TABLE IF NOT EXISTS `servizi_operatori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_servizio` int(11) NOT NULL,
  `id_operatore` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dump dei dati per la tabella `servizi_operatori`
--

INSERT INTO `servizi_operatori` (`id`, `id_servizio`, `id_operatore`) VALUES
(1, -1, 2),
(2, 0, 3),
(3, 3, 4);

-- --------------------------------------------------------

--
-- Struttura della tabella `uffici`
--

CREATE TABLE IF NOT EXISTS `uffici` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `abilitato` tinyint(1) NOT NULL DEFAULT '0',
  `nome` varchar(40) NOT NULL,
  `descrizione` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dump dei dati per la tabella `uffici`
--

INSERT INTO `uffici` (`id`, `abilitato`, `nome`, `descrizione`) VALUES
(1, 1, 'roma2', 'roma'),
(2, 1, 'Avellino22', 'avellino33');

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE IF NOT EXISTS `utenti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) NOT NULL DEFAULT '',
  `cognome` varchar(60) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `telefono` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`id`, `nome`, `cognome`, `email`, `telefono`) VALUES
(1, '', '', 'antonio.romano@mail.com', ''),
(2, 'Mario', 'Marino', 'ciccio@mail.com', ''),
(3, 'civ', 'vi', 'aaa@mailc.om', ''),
(4, '', '', 'mairio@som.it', ''),
(5, 'civ', '', 'report@report.it', ''),
(6, 'salerno', 'pinmo', 'pino@salenro.com', ''),
(7, 'admin', 'admin', 'felice.pescatore@gmail.com', ''),
(8, 'admin', 'admin1', 'Ss@mail.com', '');
