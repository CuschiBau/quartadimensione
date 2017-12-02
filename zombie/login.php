<?php
include('header.html');
session_start(); //inizio la sessione
//includo i file necessari a collegarmi al db con relativo script di accesso
$connessione = mysqli_connect('localhost','root','');
$database = mysqli_select_db($connessione,'dim');
//variabili POST con anti sql Injection
$value = $_POST['username'] ?? '';
$valueP = $_POST['password'] ?? '';
$username=mysqli_real_escape_string($connessione,$value); //faccio l'escape dei caratteri dannosi
$password=mysqli_real_escape_string($connessione,sha1($valueP)); //sha1 cifra la password anche qui in questo modo corrisponde con quella del db

$query = "SELECT * FROM login WHERE username = '$username' AND password = '$password' ";
$ris = mysqli_query($connessione,$query) or die (mysqli_error($connessione));
$riga= mysqli_fetch_array($ris);

/*Prelevo l'identificativo dell'utente */
$cod=$riga['username'];

/* Effettuo il controllo */
if ($cod == NULL) $trovato = 0 ;
else $trovato = 1;

/* Username e password corrette */
if($trovato === 1) {

 /*Registro la sessione*/
 // session_register('autorizzato');

  $_SESSION["autorizzato"] = 1;

  /*Registro il codice dell'utente*/
  $_SESSION['cod'] = $cod;
  $_SESSION['login_error'] = false;
  $_SESSION['already_exist'] = false;
  $_SESSION['write_feed'] = false;
 /*Redirect alla pagina riservata*/
   echo '<script language=javascript>document.location.href="uploader.php"</script>';

} else {

/*Username e password errati, redirect alla pagina di login*/
  $_SESSION['login_error'] = true;
  echo '<script language=javascript>document.location.href="access.php"</script>';

}
?>
