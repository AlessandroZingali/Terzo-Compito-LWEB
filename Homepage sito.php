<?php
session_start();
require_once("connessione.php");

?>
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">
<head>
  <title>--Homepage Latina Fiori--</title>
    <link rel="stylesheet" type="text/css" media="screen"href="tabella.css?v=<?php echo time(); ?>">
</head>

<body>



<h1>Negozio Latina Fiori:Tutti i nostri fiori</h1>

<table style="margin: 5% 40%">   
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
foreach ( file("provacartella/fiori.xml") as $node ) {
	$xmlString .= trim($node);
}


$doc = new DOMDocument();
$doc->loadXML($xmlString);
$root = $doc->documentElement;
$elementi = $root->childNodes;


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

if (isset($_POST['logout']))header('Location:logout.php');
?>

</tbody>
</table>

<form style="margin:1% 30%; text-align:center;"action="<?php $_SERVER['PHP_SELF']?>" method="post">
<input type="submit" name="logout" value="Fai logout"/>

</form>
</body>
</html>