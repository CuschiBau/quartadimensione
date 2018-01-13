<!DOCTYPE html>
<html>
  <head>
    <title>Login</title>
    <?=include('templates/mainStyle.php')?>
    <link rel="stylesheet" href="static/css/logged.css?a=0">
  </head>
  <body>
    <?php
      include('templates/header.html');
      session_start();
      $_SESSION['start'] = true;
      if (isset($_SESSION["autorizzato"])) {
        echo "già loggato";
        } else {
          $error = false;
          $submitted = $_POST['login'] ?? '';
          if ($submitted) {
            $config = include('config/config.php');
            $connessione = mysqli_connect($config['host'],$config['username'],$config['psw']);
            $database = mysqli_select_db($connessione,$config['dbname']);
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
               header('Location: uploader.php');

              } else {
                /*Username e password errati, redirect alla pagina di login*/
                $error = true;
              }
            }
            ?>
            <div class="container" id="main_cont">

              <h1 class="main_title">Admin Login</h1>

              <?php
                if ($error) { echo "<div class='error_msg'>Errore. Riprovare.</div>"; }
              ?>

              <form id="login" action="access.php" method="post">
                <div class="row">
                  <div class="col-12 col-sm-4 gap"> <input id="username" name="username" type="text" placeholder="Username" autofocus required> </div>
                  <div class="col-12 col-sm-4 gap"> <input id="password" name="password" type="password" placeholder="Password" required> </div>
                  <div class="col-12 col-sm-4 gap m100"> <input type="submit" id="submit" name="login" value="Accedi"> </div>
                </div>
              </form>
            </div>
            <?php

        }

        include('templates/footer.php')
      ?>
  </body>
</html>
