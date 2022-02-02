# TicketStore

### Progetto per il corso di Tecnologie Web e Basi di Dati, a.a. 2019/2020.

L'applicativo realizzato è un applicativo web che fa uso dello stack WAMP,
si è usato XAMPP per gestire l'esecuzione del server Apache e del dbms MySql.
Vengono usati strumenti open source di sviluppo web come jQuery e Bootstrap.
Il DBMS utilizzato è MySql: credenziali database, presenti anche nel file "bootstap.php"
("localhost", "root", "", "ticketstoredb") -> mysqli($servername, $username, $password, $dbname).
Per il funzionamento dell'applicativo è necessario l'accesso agli account degli utilizzatori:

`AMMINISTRATORE` (`Email`, `Password`) values
('mattia@ticketstore.com', 'mattia');

`ORGANIZZATORE` (`Email`, `Password`) values
('grandiconcerti@ticketstore.com', 'grandiconcerti'),
('mostrecinema@ticketstore.com', 'mostrecinema');

`UTENTE` (`Email`, `Password`) values
('giuseppez@ticketstore.com', 'giuseppez'),
('mariellapecoraro@ticketstore.com', 'mariellapecoraro'),
('luca.bianchi@ticketstore.com', 'luca.bianchi'),
('pallino@ticketstore.com', 'pallino');

Per popolare il database con dei dati "di prova" si può eseguire il file "db.dll" nella directory /db.

Mattia Passeri, email: mattia.passeri2@studio.unibo.it