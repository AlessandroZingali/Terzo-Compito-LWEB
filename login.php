<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$db_name = "Tabella_Fiori";
$table_users = "Tabella_Utenti";
$table_product = "Tabella_Prodotti";

$mysqliConnection = new mysqli("localhost", "Alessandro", "belandi", $db_name);

if (mysqli_connect_errno()) {
    printf("Non riesco a connettermi %s\n", mysqli_connect_error());
    exit();
}

?>
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>Login page</title>
  <link rel="stylesheet" type="text/css" media="screen"href="login.css?v=<?php echo time(); ?>">
</head>

<body>
<h3>Inserite username e password per accedere al sito</h3>
<img src ="media/logo.png" height="400" width="400" alt="logo" class="sfondo" />
<form action="<?php $_SERVER['PHP_SELF']?>" method="post">
<h4>
  <p>Nome Utente:<input type="text" name="userName" size="30" /></p>
  <p>Password:<input type="password" name="password" size="30" /></p>
<?php 
if (isset($_POST['invio'])){
  if (empty($_POST['userName']) || empty($_POST['password']))
	echo "<p>Accesso negato</p>";
    $sql = "SELECT *
            FROM $table_users
    WHERE userName = \"{$_POST['userName']}\" AND password =\"{$_POST['password']}\" ";

    if (!$resultQ = mysqli_query($mysqliConnection, $sql)) {
        printf("La query non ha un utente valido\n");
    exit();
    }
    $row = mysqli_fetch_array($resultQ);
    if ($row){ 
      session_start();
      $_SESSION['userName']=$_POST['userName'];
      $_SESSION['dataLogin']=time();
      $_SESSION['accessoPermesso']=$row['tipologia'];
	  if($_SESSION['accessoPermesso']=="admin"){
		header('Location: tabella fiori.php');  
	  }
       else header('Location: Homepage sito.php');
      exit();
    }

  }	
?>
<input type="submit" name="invio" value="Accedi">
<input type="reset" name="reset" value="Reset">
</h4>
</form>

</body>
</html>