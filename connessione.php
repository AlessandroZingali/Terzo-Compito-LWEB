<?php

$db_name = "Latina_Fiori";
$table_users = "Tabella_Utenti";
$table_product = "Tabella_Prodotti";

$mysqliConnection = new mysqli("localhost", "Alessandro", "belandi", $db_name);

if (mysqli_connect_errno()) {
    printf("problemi di connessione: %s\n", mysqli_connect_error($mysqliConnection));
    exit();
}
?> 