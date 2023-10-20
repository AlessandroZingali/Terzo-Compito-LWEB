<?php			

error_reporting(E_ALL &~E_NOTICE);

$db_name = "Latina_Fiori";
$table_users = "Tabella_Utenti";
$table_product = "Tabella_Prodotti";

$mysqliConnection = new mysqli("localhost", "Alessandro", "belandi");
//da modificare per accedere a mysql
if (mysqli_connect_errno()) {
    printf("problemi di connessione : %s\n", mysqli_connect_error());
}


$queryCreazioneDatabase = "CREATE DATABASE $db_name";

if ($resultQ = mysqli_query($mysqliConnection, $queryCreazioneDatabase)) {
	printf("Database creato ...\n");
}
else {
	printf("Errore creazione Database.\n");
}

$mysqliConnection->close();
require_once("connessione.php");

if (mysqli_errno($mysqliConnection)) {
    printf("Errore creazione connessione\n", mysqli_error($mysqliConnection));
    exit();
}

$sqlQuery = "CREATE TABLE if not exists $table_product (";
$sqlQuery.= "productId int NOT NULL auto_increment, primary key (productId), ";
$sqlQuery.= "Nome varchar (100) NOT NULL, ";
$sqlQuery.= "Costo float,";
$sqlQuery.= "Quantita_Rimasta int";
$sqlQuery.= ");";

echo "<P>$sqlQuery</P>";

if ($resultQ = mysqli_query($mysqliConnection, $sqlQuery))
    printf("tabella prodotti creata ...\n");
else {
    printf("problema creazione prodotti.\n");
  exit();
}
$sql = "INSERT INTO $table_product
	(Nome,Costo,Quantita_Rimasta)
	VALUES
	(\"Rosa rossa\",\"20\",\"20\"),
	(\"Rosa rosa\",\"20\",\"20\"),
	(\"Rosa bianca\",\"20\",\"20\"),
	(\"Rosa nera\",\"20\",\"20\"),
	(\"Margherita \",\"20\",\"20\")
	";
echo $sql;

if ($resultQ = mysqli_query($mysqliConnection, $sql))
    printf("popolamento prodotti eseguito ...\n");
else {
    printf("problema aggiunta tabella prodotti.\n");
  exit();
}

$sqlQuery = "CREATE TABLE if not exists $table_users (";
$sqlQuery.= "userId int NOT NULL auto_increment, primary key (userId), ";
$sqlQuery.= "username varchar (100) NOT NULL, ";
$sqlQuery.= "password varchar (100) NOT NULL, ";
$sqlQuery.= "tipologia varchar (100) NOT NULL, ";
$sqlQuery.= "saldo float ";
$sqlQuery.= ");";

echo "<P>$sqlQuery</P>";

if ($resultQ = mysqli_query($mysqliConnection, $sqlQuery))
    printf("Tabella utenti creata ...\n");
else {
    printf("errore creazione tabella utenti\n");
  exit();
}

$sql = "INSERT INTO $table_users
	(username,password,tipologia,saldo)
	VALUES
	(\"Alessandro\",\"belandi\",\"admin\",\"NULL\")
	";
echo $sql;

if ($resultQ = mysqli_query($mysqliConnection, $sql))
    printf("popolamento utenti eseguito ...\n");
else {
    printf("errore popolamento utenti.\n");
  exit();
}


$sql = "INSERT INTO $table_users
	(username,password ,tipologia,saldo)
	VALUES
	(\"Bob\", \"Pidgeon\", \"utente\",\"0\")
	";
echo $sql;

if ($resultQ = mysqli_query($mysqliConnection, $sql))
    printf("popolamento utenti eseguito ...\n");
else {
    printf("ops errore popolamento utenti\n");
  exit();
}
echo mysqli_errno($mysqliConnection);
?>
