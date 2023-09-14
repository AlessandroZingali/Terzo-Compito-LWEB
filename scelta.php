<?php
session_start();
if($_SESSION['accessoPermesso']=="admin")header('Location: tabella fiori.php');
	  if($_SESSION['accessoPermesso']=="utente")header('Location: home.php'); 
?>