<?xml version="1.0" encoding="ISO-8859-1"?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">
    <head>
        <title>Tabella fiori</title>
		<link rel="stylesheet" type="text/css" media="screen" href="tabella.css?v=<?php echo time();?>"> 
    </head>
<body>
<?php
ini_set('display_errors', 1);
error_reporting(E_ERROR | E_PARSE);
session_start();
$db_name = "Tabella_Fiori";
$table_users = "Tabella_Utenti";
$table_product = "Tabella_Prodotti";
$mysqliConnection = new mysqli("localhost", "Alessandro", "belandi", $db_name);
?>
   
<h1>Negozio Latina Fiori:Tutti i nostri fiori</h1>
<div class="row">
  <div class="column left"><table>   
<thead>
 <tr>
 <th>Index</th>
  <th>Nome Fiore</th>
  <th>Costo</th>
  <th>Quantita rimasta</th>

 </tr>
</thead>

<tbody>

<?php

$t2=microtime();
$xmlString = "";
foreach ( file("fiori.xml") as $node ) {
	$xmlString .= trim($node);
}


$doc = new DOMDocument();
$doc->loadXML($xmlString);
$root = $doc->documentElement;
$elementi = $root->childNodes;


if(isset($_POST['invio'])){
$newRecord = $doc->createElement("record");
$newFiore = $doc->createElement("Fiore", $_POST['nome']);
$newPrezzo = $doc->createElement("Prezzo", $_POST['costo']);
$newQuantità = $doc->createElement("Quantita", $_POST['quantita']);

$newRecord->appendChild($newFiore);
$newRecord->appendChild($newPrezzo);
$newRecord->appendChild($newQuantità);
$root->appendChild($newRecord);
$doc->save("fiori.xml");
}



if(isset($_POST['svuota'])){
	  $child = $root->lastElementChild; 
        while ($child) {
            $root->removeChild($child);
            $child = $root->lastElementChild;
		}
	$doc->save("fiori.xml");
}

if(isset($_POST['Rimuovi'])){
	if($_POST['Rimuovi']=="" or $_POST['Rimuovi']==null) echo "<h3>non hai scritto un numero</h3>\n";

$numero=$_POST['numero'];
$nodoscelto = $elementi->item($numero);
$root->removeChild($nodoscelto);
$doc->save("fiori.xml");
}


for ($i=0; $i<$elementi->length; $i++) {
    $elemento = $elementi->item($i);
	
	$Fiore = $elemento->firstChild;
	$nome = $Fiore->textContent;
	
	$Prezzo = $Fiore->nextSibling;
	$Prezzo1 = $Prezzo->textContent;
	
	$Quantita = $elemento->lastChild;
	$rimasti = $Quantita->textContent;
	
	print "<tr><td>$i</td><td>$nome</td><td>$Prezzo1 € </td><td>$rimasti</td></tr>\n";
}
echo "</tbody>\n</table>";


if (isset($_POST['salva'])) {
	for ($i=0; $i<$elementi->length;$i++){
		$elemento = $elementi->item($i);
		$Fiore = $elemento->firstChild;
		$nome = $Fiore->textContent;
		$Prezzo = $Fiore->nextSibling;
		$Prezzo1 = $Prezzo->textContent;
		$Quantita = $elemento->lastChild;
		$rimasti = $Quantita->textContent;
		$sql = "INSERT INTO $table_product
	(productId,Nome,Costo,Quantita_Rimasta)
	VALUES
	('{$i}','{$nome}','{$Prezzo1}','{$rimasti}')
	";
	echo $sql;
	if ($resultQ = mysqli_query($mysqliConnection, $sql))
    printf("aggiunta al database  eseguito ...\n");
	else{
    printf("aggiunta non eseguita.\n");
	exit();
	}
}
}

if (isset($_POST['carica'])){
	 $child = $root->lastElementChild; 
        while ($child) {
            $root->removeChild($child);
            $child = $root->lastElementChild;
		}

	$doc->save("fiori.xml");
	$sql = "SELECT * FROM $table_product";

	if (!$resultQ = mysqli_query($mysqliConnection, $sql)) {
		printf("Problema col caricamento .\n");
		exit();
	}
	while ($row = mysqli_fetch_array($resultQ)){ 
		$newRecord = $doc->createElement("record");
		$newFiore = $doc->createElement("Fiore",$row['Nome'] );
		$newPrezzo = $doc->createElement("Prezzo", $row['Costo']);
		$newQuantità = $doc->createElement("Quantita",$row['Quantita_Rimasta']);
		$newRecord->appendChild($newFiore);
		$newRecord->appendChild($newPrezzo);
		$newRecord->appendChild($newQuantità);
		$root->appendChild($newRecord);
	}
	$doc->save("fiori.xml");
	header("Refresh:0");
}


if(isset($_POST['logout']))header("Location:logout.php");

?>
</div>
<div class="column right">
<form action="tabella fiori.php" method="post">
<p>Nome <input type="text" name="nome" size="20" /></p>
<p>Costo <input type="text" name="costo" size="10" /></p>
<p>Quantita <input type="text" name="quantita" size="10" /></p>
<input type="submit" name="invio" value="Aggiungi prodotto" />
<p>Numero <input type="text" name="numero" size="5" />  
<input type="submit" name="Rimuovi" value="Rimuovi dalla tabella" />
</p>
<input type="submit" name="svuota" value="Svuota tabella" />
</p>
<input type="submit" name="carica" value="Carica  la tabella dal database" />
<input type="submit" name="salva" value="Salva la Tabella nel database" />

<input type="submit" name="logout" value="fai log out" />

</form>
</div>
</div>
</body>
</html>