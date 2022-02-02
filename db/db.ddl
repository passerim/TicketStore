-- *********************************************
-- * SQL MySQL generation                      
-- *--------------------------------------------
-- * DB-MAIN version: 11.0.1              
-- * Generator date: Dec  4 2018              
-- * Generation date: Thu Jun 11 15:16:45 2020 
-- * LUN file: C:\Users\MetBook\Documents\UNIVERSITA\DB20\PROGETTO\TicketStoreDB.lun 
-- * Schema: TicketStoreRel/2.2 
-- ********************************************* 


-- Database Section
-- ________________ 

create database TicketStoreRel;
use TicketStoreRel;


-- Tables Section
-- _____________ 

create table AFFERENZA (
     Nome char(64) not null,
     IdEvento int not null,
     constraint ID_AFFERENZA_ID primary key (Nome, IdEvento));

create table AMMINISTRATORE (
     Email varchar(128) not null,
     Password varchar(256) not null,
     constraint ID_AMMINISTRATORE_ID primary key (Email));

create table APPROVAZIONE (
     IdEvento int not null,
     Data date not null,
     Email varchar(128) not null,
     constraint FKAPP_EVE_ID primary key (IdEvento));

create table BIGLIETTO (
     Codice int not null auto_increment,
     IdEvento int not null,
     NomeClasse char(64) not null,
     constraint ID_BIGLIETTO_ID primary key (Codice));

create table CATEGORIA (
     Nome char(64) not null,
     constraint ID_CATEGORIA_ID primary key (Nome));

create table CLASSE_BIGLIETTO (
     IdEvento int not null,
     NomeClasse char(64) not null,
     Prezzo int not null,
     Quantita int not null,
     constraint ID_CLASSE_BIGLIETTO_ID primary key (IdEvento, NomeClasse));

create table COMPOSIZIONE (
     Codice int not null,
     IdOrdine int not null,
     constraint IDCOMPOSIZIONE primary key (Codice));

create table EVENTO (
     IdEvento int not null auto_increment,
     Stato int not null default 0,
     Nome varchar(64) not null,
     Data date not null,
     Luogo varchar(64) not null,
     Anteprima varchar(512) not null,
     Descrizione varchar(1024) not null,
     Immagine varchar(128) not null,
     IdOrganizzatore int not null,
     constraint ID_EVENTO_ID primary key (IdEvento));

create table ORDINE (
     IdOrdine int not null auto_increment,
     IdEvento int not null,
     IdUtente int not null,
     Data date not null,
     Importo float(1) not null,
     constraint ID_ORDINE_ID primary key (IdOrdine),
     constraint SID_ORDINE_1_ID unique (IdUtente, IdEvento));

create table ORGANIZZATORE (
     IdOrganizzatore int not null auto_increment,
     Nome char(64) not null,
     Indirizzo varchar(128) not null,
     Citta varchar(64) not null,
     Email varchar(128) not null,
     Password varchar(256) not null,
     Descrizione varchar(256) not null,
     Attivo tinyint(1) not null default 1,
     constraint ID_ORGANIZZATORE_ID primary key (IdOrganizzatore),
     constraint SID_ORGANIZZATORE_ID unique (Email),
     constraint IDORGANIZZATORE_1 unique (Nome));

create table STATO_EVENTO (
    IdStato int not null,
    Descrizione char(32) not null,
    constraint ID_STATO_EVENTO primary key (IdStato));

create table TIPO_UTENTE (
	IdTipo int not null,
	Descrizione char(32) not null,
	constraint ID_TIPO_UTENTE primary key (IdTipo));

create table UTENTE (
     IdUtente int not null auto_increment,
     Tipo int not null default 0,
     Nome char(64) not null,
     Cognome char(64) not null,
     Indirizzo varchar(128) not null,
     Citta varchar(64) not null,
     Email varchar(128) not null,
     Password varchar(256) not null,
     Attivo tinyint(1) not null default 1,
     constraint ID_UTENTE_ID primary key (IdUtente),
     constraint SID_UTENTE_ID unique (Email));


-- Constraints Section
-- ___________________ 

alter table BIGLIETTO
  modify `Codice` int not null auto_increment, auto_increment=260;

alter table ORDINE
  modify `IdOrdine` int not null auto_increment, auto_increment=7;  

alter table UTENTE
  modify `IdUtente` int not null auto_increment, auto_increment=5;

alter table EVENTO
  modify `IdEvento` int not null auto_increment, auto_increment=5;

alter table ORGANIZZATORE
  modify `IdOrganizzatore` int not null auto_increment, auto_increment=3;

alter table AFFERENZA add constraint FKAFF_EVE_FK
     foreign key (IdEvento)
     references EVENTO (IdEvento);

alter table AFFERENZA add constraint FKAFF_CAT
     foreign key (Nome)
     references CATEGORIA (Nome);

alter table APPROVAZIONE add constraint FKAPP_EVE_FK
     foreign key (IdEvento)
     references EVENTO (IdEvento);

alter table APPROVAZIONE add constraint FKAPP_AMM_FK
     foreign key (Email)
     references AMMINISTRATORE (Email);

-- Not implemented
-- alter table ARTISTA add constraint ID_ARTISTA_CHK
--     check(exists(select * from PERFORMANCE
--                  where PERFORMANCE.Nome = Nome)); 

alter table BIGLIETTO add constraint GRBIGLIETTO
     foreign key (IdEvento, NomeClasse)
     references CLASSE_BIGLIETTO (IdEvento, NomeClasse);

alter table CLASSE_BIGLIETTO add constraint FKOFFERTA
     foreign key (IdEvento)
     references EVENTO (IdEvento);

alter table COMPOSIZIONE add constraint GRCOMPOSIZIONE
     foreign key (Codice)
     references BIGLIETTO (Codice);

alter table COMPOSIZIONE add constraint GRCOMPOSIZIONE_1
     foreign key (IdOrdine)
     references ORDINE (IdOrdine);

-- Not implemented
-- alter table EVENTO add constraint ID_EVENTO_CHK
--     check(exists(select * from AFFERENZA
--                  where AFFERENZA.IdEvento = IdEvento)); 

-- Not implemented
-- alter table EVENTO add constraint ID_EVENTO_CHK
--     check(exists(select * from CLASSE_BIGLIETTO
--                  where CLASSE_BIGLIETTO.IdEvento = IdEvento)); 

alter table EVENTO add constraint FKORGANIZZAZIONE_FK
     foreign key (IdOrganizzatore)
     references ORGANIZZATORE (IdOrganizzatore);

alter table EVENTO add constraint FKSTATO_EVENTO
     foreign key (Stato)
     references STATO_EVENTO (IdStato);

alter table ORDINE add constraint FKRICEZIONE
     foreign key (IdEvento)
     references EVENTO (IdEvento);

alter table ORDINE add constraint FKEFFETTUAZIONE
     foreign key (IdUtente)
     references UTENTE (IdUtente);

alter TABLE UTENTE add constraint FK_TIPO 
     foreign key (Tipo) 
     references TIPO_UTENTE (IdTipo);

-- Insert Section
-- _____________ 

insert into `AMMINISTRATORE` (`Email`, `Password`) values
('mattia@ticketstore.com', '21dda7961d1db06b84ec3bf0caaa96e0f23ea0f89ac8e0aa5a9c2c549dbc3575');

insert into `ORGANIZZATORE` (`IdOrganizzatore`, `Nome`, `Indirizzo`, `Citta`, `Email`, `Password`, `Descrizione`) values
(1, 'Grandi Concerti', 'Via Lince 9', 'Roma', 'grandiconcerti@ticketstore.com', '7267bbbf498a29d18d754de5dc2c45bc8e3803e257d76f681a2d9dd9ea322b1f', 'Organizziamo emozionanti concerti delle migliori star del momento, sia in Italia che fuori.'),
(2, 'Mostre&Cinema', 'Via Daqui 20', 'Rimini', 'mostrecinema@ticketstore.com', '91b8a74c7a9664ae13da287a2f9abdb6edc16324c27f528b655ef1896465c19a', 'Affermato organizzatore di mostre artistiche e proiezioni cinematografiche, operante da anni nel settore.');

insert into STATO_EVENTO (IdStato, Descrizione) values
(0, 'Non approvato'),
(1, 'Acquistabile'),
(2, 'Sold Out');

insert into TIPO_UTENTE (IdTipo, Descrizione) values
(0, 'Bronze'),
(1, 'Silver'),
(2, 'Gold');

insert into `EVENTO` (`IdEvento`, `Stato`,`Nome`, `Descrizione`, `Data`, `Luogo`, `Anteprima`, `Immagine`, `IdOrganizzatore`) values
(1, 1, 'VASCO ROSSI – NON STOP LIVE FESTIVAL', 'Il 2020 sarà l’anno dei Festival rock per Vasco Rossi che, per l’estate prossima, ha scelto di fare una pausa dagli stadi e di esibirsi nei più importanti Festival Rock della penisola. Il Blasco tornerà ad Imola per concludere il Tour del Non Stop Live Festival con un concerto imperdibile: il 26 giugno all’Autodromo Internazionale Enzo e Dino Ferrari di Imola,  si esibirà davanti al suo pubblico proprio dove nel 1998 fece il tutto esaurito con 130.000 fan durante l’indimenticabile prima edizione dell’Heineken Jammin’ Festival.', '2020-06-26', 'Imola', 'Vasco Non Stop Live Festival! Vasco torna live nel 2020 per 5 concerti nei 4 festival rock più importanti dell’estate!', 'vasco.jpg', 1),
(2, 1, 'FELLINI100. Genio Immortale. La mostra', 'Il 20 gennaio del 1920 nasceva a Rimini Federico Fellini, il Maestro del cinema mondiale. Se l’Italia è diventata, per tutto il mondo, il paese della "dolce vita" lo si deve al suo sguardo unico e inconfondibile. Pochissimi artisti sono riusciti a rappresentare l’intera storia del nostro Paese come ha fatto Fellini. Un artista che attraverso il cinema è riuscito a inventare un mondo intero, creando un immaginario capace non solo di raccontare la propria generazione ma anche di entrare in contatto con quelle successive. Fellini ci ha mostrato come, viaggiando a ritroso nel tempo, si possono trovare magici suggerimenti per comprendere il presente. "Tutto si immagina" non è solo una celebre espressione del regista riminese, genio immortale, ma la chiave di volta per fotografarne l’eredità artistica e creativa attuale e senza tempo. Questa grande mostra, che sarà ospitata il prossimo aprile 2020 a Roma (Palazzo Venezia) per poi varcare i confini nazionali con esposizioni a Los Angeles, Mosca e Berlino, inaugura le iniziative dedicate al Maestro nel centenario della nascita. Rappresenta infatti l’occasione per riportare in primo piano memorie, emozioni, fotogrammi, scene, suggestioni provenienti da quel mondo straordinario capace di dirci tutta la verità su noi stessi con l’irresistibile fascino universale del sogno.', '2020-03-22', 'Roma', 'Questa grande mostra rappresenta l’occasione per riportare in primo piano memorie, emozioni, fotogrammi, scene, suggestioni provenienti dal mondo straordinario del maestro Fellini.', 'fellini.jpg', 2),
(3, 0, 'Tolo Tolo', 'Stavolta Zalone vestirà i panni di un comico napoletano minacciato da un boss malavitoso e volerà fino in Kenya, più precisamente nella città di Malindi, località costiera di Watamu. Nel film Checco sarà affiancato anche da un carabiniere, il quale diventa suo amico e compagno di peripezie.', '2020-02-10', 'Rimini', 'Stavolta Zalone vestirà i panni di un comico napoletano minacciato da un boss malavitoso e volerà fino in Kenya, più precisamente nella città di Malindi, località costiera di Watamu.', 'tolo-tolo.jpg', 2),
(4, 1, 'Imagine Dragons Firenze 2020', 'Imagine Dragons in Italia in concerto a Firenze nel 2020 – La band che ha conquistato certificazioni multi-Platino e vinto un Grammy Award, si esibirà live nel nostro Paese il 2 giugno 2020 alla Visarno Arena di Firenze. Disponibile servizio Bus Concerto Imagine Dragons. Quella in Italia sarà l’unica tappa Europea del tour della band capitanata da Dan Reynolds. Sul palco, oltre ai loro più grandi successi, gli Imagine Dragons presenteranno dal vivo i brani contenuti nel quarto album “ORIGINS”. “ORIGINS” è stato concepito come un album gemello di “EVOLVE”, uscito 16 mesi prima, continuando le esplorazioni sonore del precedente lavoro.', '2020-06-02', 'Firenze', 'Imagine Dragons in Italia in concerto a Firenze nel 2020 – La band che ha conquistato certificazioni multi-Platino e vinto un Grammy Award, si esibirà live nel nostro Paese il 2 giugno 2020 alla Visarno Arena di Firenze.', 'imagined.jpg', 1);

insert into `CATEGORIA` (`Nome`) values
('Arte'),
('Musica'),
('Spettacolo'),
('Eventi'),
('Cinema');

insert into `AFFERENZA` (`IdEvento`, `Nome`) values
(1, 'Musica'),
(1, 'Eventi'),
(2, 'Arte'),
(2, 'Cinema'),
(3, 'Cinema'),
(4, 'Musica'),
(4, 'Spettacolo');

insert into `UTENTE` (`IdUtente`, `Tipo`, `Nome`, `Cognome`, `Email`, `Password`, `Indirizzo`, `Citta`) values
(1, 1,'Giuseppe', 'Zucchi', 'giuseppez@ticketstore.com', '524f04e8e0a4f1fbbc5d5ea30c95b3b1cf664eb600ac9d06035e3b787be0bf04', 'Viale Elaiv 69', 'Cesenatico'),
(2, 1,'Mariella', 'Pecoraro', 'mariellapecoraro@ticketstore.com', 'd4398c6054ad861c3225a95474b595e9973e8dc1dd9482b0ed4a16c5fa63a396', 'Via Vai 2', 'Taormina'),
(3, 1,'Luca', 'Bianchi', 'luca.bianchi@ticketstore.com', '0966f7e686fc70db08ff162d7dfc3a65dbdcffade96015831018b7f0268dccbc', 'Largo Lago 7', 'Rimini'),
(4, 1,'Pinco', 'Pallino', 'pallino@ticketstore.com', '084761fbb2b91236a4b4c2983af45d379c974e36d56bbd31a7892d706b7fa61a', 'Via Rossi 24', 'Forlì');

insert into APPROVAZIONE (IdEvento, Data, Email) values
(1, '2020-01-01', 'mattia@ticketstore.com'),
(2, '2020-01-01', 'mattia@ticketstore.com'),
(4, '2020-01-01', 'mattia@ticketstore.com');

insert into CLASSE_BIGLIETTO (IdEvento, NomeClasse, Prezzo, Quantita) values
(1, 'Tribuna', 60, 99),
(2, 'Standard', 10, 50),
(3, 'Standard', 7, 30),
(4, 'Prato', 40, 80);

insert into ORDINE (IdOrdine, IdEvento, IdUtente, Data, Importo) values
(1, 1, 2, '2020-01-03', 120),
(2, 4, 3, '2020-01-22', 80),
(3, 2, 2, '2020-01-27', 40),
(4, 2, 4, '2020-02-11', 20),
(5, 1, 3, '2020-03-14', 60),
(6, 1, 1, '2020-05-10', 180);

insert into BIGLIETTO (Codice, IdEvento, NomeClasse) values
(1, 1, 'Tribuna'),
(2, 1, 'Tribuna'),
(3, 1, 'Tribuna'),
(4, 1, 'Tribuna'),
(5, 1, 'Tribuna'),
(6, 1, 'Tribuna'),
(7, 1, 'Tribuna'),
(8, 1, 'Tribuna'),
(9, 1, 'Tribuna'),
(10, 1, 'Tribuna'),
(11, 1, 'Tribuna'),
(12, 1, 'Tribuna'),
(13, 1, 'Tribuna'),
(14, 1, 'Tribuna'),
(15, 1, 'Tribuna'),
(16, 1, 'Tribuna'),
(17, 1, 'Tribuna'),
(18, 1, 'Tribuna'),
(19, 1, 'Tribuna'),
(20, 1, 'Tribuna'),
(21, 1, 'Tribuna'),
(22, 1, 'Tribuna'),
(23, 1, 'Tribuna'),
(24, 1, 'Tribuna'),
(25, 1, 'Tribuna'),
(26, 1, 'Tribuna'),
(27, 1, 'Tribuna'),
(28, 1, 'Tribuna'),
(29, 1, 'Tribuna'),
(30, 1, 'Tribuna'),
(31, 1, 'Tribuna'),
(32, 1, 'Tribuna'),
(33, 1, 'Tribuna'),
(34, 1, 'Tribuna'),
(35, 1, 'Tribuna'),
(36, 1, 'Tribuna'),
(37, 1, 'Tribuna'),
(38, 1, 'Tribuna'),
(39, 1, 'Tribuna'),
(40, 1, 'Tribuna'),
(41, 1, 'Tribuna'),
(42, 1, 'Tribuna'),
(43, 1, 'Tribuna'),
(44, 1, 'Tribuna'),
(45, 1, 'Tribuna'),
(46, 1, 'Tribuna'),
(47, 1, 'Tribuna'),
(48, 1, 'Tribuna'),
(49, 1, 'Tribuna'),
(50, 1, 'Tribuna'),
(51, 1, 'Tribuna'),
(52, 1, 'Tribuna'),
(53, 1, 'Tribuna'),
(54, 1, 'Tribuna'),
(55, 1, 'Tribuna'),
(56, 1, 'Tribuna'),
(57, 1, 'Tribuna'),
(58, 1, 'Tribuna'),
(59, 1, 'Tribuna'),
(60, 1, 'Tribuna'),
(61, 1, 'Tribuna'),
(62, 1, 'Tribuna'),
(63, 1, 'Tribuna'),
(64, 1, 'Tribuna'),
(65, 1, 'Tribuna'),
(66, 1, 'Tribuna'),
(67, 1, 'Tribuna'),
(68, 1, 'Tribuna'),
(69, 1, 'Tribuna'),
(70, 1, 'Tribuna'),
(71, 1, 'Tribuna'),
(72, 1, 'Tribuna'),
(73, 1, 'Tribuna'),
(74, 1, 'Tribuna'),
(75, 1, 'Tribuna'),
(76, 1, 'Tribuna'),
(77, 1, 'Tribuna'),
(78, 1, 'Tribuna'),
(79, 1, 'Tribuna'),
(80, 1, 'Tribuna'),
(81, 1, 'Tribuna'),
(82, 1, 'Tribuna'),
(83, 1, 'Tribuna'),
(84, 1, 'Tribuna'),
(85, 1, 'Tribuna'),
(86, 1, 'Tribuna'),
(87, 1, 'Tribuna'),
(88, 1, 'Tribuna'),
(89, 1, 'Tribuna'),
(90, 1, 'Tribuna'),
(91, 1, 'Tribuna'),
(92, 1, 'Tribuna'),
(93, 1, 'Tribuna'),
(94, 1, 'Tribuna'),
(95, 1, 'Tribuna'),
(96, 1, 'Tribuna'),
(97, 1, 'Tribuna'),
(98, 1, 'Tribuna'),
(99, 1, 'Tribuna'),
(100, 2, 'Standard'),
(101, 2, 'Standard'),
(102, 2, 'Standard'),
(103, 2, 'Standard'),
(104, 2, 'Standard'),
(105, 2, 'Standard'),
(106, 2, 'Standard'),
(107, 2, 'Standard'),
(108, 2, 'Standard'),
(109, 2, 'Standard'),
(110, 2, 'Standard'),
(111, 2, 'Standard'),
(112, 2, 'Standard'),
(113, 2, 'Standard'),
(114, 2, 'Standard'),
(115, 2, 'Standard'),
(116, 2, 'Standard'),
(117, 2, 'Standard'),
(118, 2, 'Standard'),
(119, 2, 'Standard'),
(120, 2, 'Standard'),
(121, 2, 'Standard'),
(122, 2, 'Standard'),
(123, 2, 'Standard'),
(124, 2, 'Standard'),
(125, 2, 'Standard'),
(126, 2, 'Standard'),
(127, 2, 'Standard'),
(128, 2, 'Standard'),
(129, 2, 'Standard'),
(130, 2, 'Standard'),
(131, 2, 'Standard'),
(132, 2, 'Standard'),
(133, 2, 'Standard'),
(134, 2, 'Standard'),
(135, 2, 'Standard'),
(136, 2, 'Standard'),
(137, 2, 'Standard'),
(138, 2, 'Standard'),
(139, 2, 'Standard'),
(140, 2, 'Standard'),
(141, 2, 'Standard'),
(142, 2, 'Standard'),
(143, 2, 'Standard'),
(144, 2, 'Standard'),
(145, 2, 'Standard'),
(146, 2, 'Standard'),
(147, 2, 'Standard'),
(148, 2, 'Standard'),
(149, 2, 'Standard'),
(150, 3, 'Standard'),
(151, 3, 'Standard'),
(152, 3, 'Standard'),
(153, 3, 'Standard'),
(154, 3, 'Standard'),
(155, 3, 'Standard'),
(156, 3, 'Standard'),
(157, 3, 'Standard'),
(158, 3, 'Standard'),
(159, 3, 'Standard'),
(160, 3, 'Standard'),
(161, 3, 'Standard'),
(162, 3, 'Standard'),
(163, 3, 'Standard'),
(164, 3, 'Standard'),
(165, 3, 'Standard'),
(166, 3, 'Standard'),
(167, 3, 'Standard'),
(168, 3, 'Standard'),
(169, 3, 'Standard'),
(170, 3, 'Standard'),
(171, 3, 'Standard'),
(172, 3, 'Standard'),
(173, 3, 'Standard'),
(174, 3, 'Standard'),
(175, 3, 'Standard'),
(176, 3, 'Standard'),
(177, 3, 'Standard'),
(178, 3, 'Standard'),
(179, 3, 'Standard'),
(180, 4, 'Prato'),
(181, 4, 'Prato'),
(182, 4, 'Prato'),
(183, 4, 'Prato'),
(184, 4, 'Prato'),
(185, 4, 'Prato'),
(186, 4, 'Prato'),
(187, 4, 'Prato'),
(188, 4, 'Prato'),
(189, 4, 'Prato'),
(190, 4, 'Prato'),
(191, 4, 'Prato'),
(192, 4, 'Prato'),
(193, 4, 'Prato'),
(194, 4, 'Prato'),
(195, 4, 'Prato'),
(196, 4, 'Prato'),
(197, 4, 'Prato'),
(198, 4, 'Prato'),
(199, 4, 'Prato'),
(200, 4, 'Prato'),
(201, 4, 'Prato'),
(202, 4, 'Prato'),
(203, 4, 'Prato'),
(204, 4, 'Prato'),
(205, 4, 'Prato'),
(206, 4, 'Prato'),
(207, 4, 'Prato'),
(208, 4, 'Prato'),
(209, 4, 'Prato'),
(210, 4, 'Prato'),
(211, 4, 'Prato'),
(212, 4, 'Prato'),
(213, 4, 'Prato'),
(214, 4, 'Prato'),
(215, 4, 'Prato'),
(216, 4, 'Prato'),
(217, 4, 'Prato'),
(218, 4, 'Prato'),
(219, 4, 'Prato'),
(220, 4, 'Prato'),
(221, 4, 'Prato'),
(222, 4, 'Prato'),
(223, 4, 'Prato'),
(224, 4, 'Prato'),
(225, 4, 'Prato'),
(226, 4, 'Prato'),
(227, 4, 'Prato'),
(228, 4, 'Prato'),
(229, 4, 'Prato'),
(230, 4, 'Prato'),
(231, 4, 'Prato'),
(232, 4, 'Prato'),
(233, 4, 'Prato'),
(234, 4, 'Prato'),
(235, 4, 'Prato'),
(236, 4, 'Prato'),
(237, 4, 'Prato'),
(238, 4, 'Prato'),
(239, 4, 'Prato'),
(240, 4, 'Prato'),
(241, 4, 'Prato'),
(242, 4, 'Prato'),
(243, 4, 'Prato'),
(244, 4, 'Prato'),
(245, 4, 'Prato'),
(246, 4, 'Prato'),
(247, 4, 'Prato'),
(248, 4, 'Prato'),
(249, 4, 'Prato'),
(250, 4, 'Prato'),
(251, 4, 'Prato'),
(252, 4, 'Prato'),
(253, 4, 'Prato'),
(254, 4, 'Prato'),
(255, 4, 'Prato'),
(256, 4, 'Prato'),
(257, 4, 'Prato'),
(258, 4, 'Prato'),
(259, 4, 'Prato');

insert into COMPOSIZIONE (Codice, IdOrdine) values
(1, 1),
(2, 1),
(180, 2),
(181, 2),
(100, 3),
(101, 3),
(102, 3),
(103, 3),
(104, 4),
(105, 4),
(3, 5),
(4, 6),
(5, 6),
(6, 6);
