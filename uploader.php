<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <?=include('templates/mainStyle.php')?>
    <link rel="stylesheet" href="static/css/logged.css?a=5">
  </head>
  <body>
    <?php
      include('functions/global.php');
      include('functions/uploaderFunctions.php');
      include('templates/header.html');
      session_start();
      echo "<div class='container' id='main_cont'>";
        echo "<h1 class='main_title'>Carica Files</h1>";
        $return = $_POST['fileUpload'] ?? '';
        $changeMacro = $_POST['macro'] ?? '';
        $_SESSION['upload_success'] = false;
        
        if ($return) {
          chdir('categories');
          chdir(urldecode($changeMacro));
          $value = $_POST['dir'] ?? '';
          $value = urldecode($value);
          $newName = $_POST['newName'] ?? '';
          $dirEfile = false;

          if($value == 'other'){
            $newFolder = $_POST['newFolder'] ?? '';
            if(!is_dir($newFolder)){ createNewCat($newFolder,true); }
            $value = $newFolder;
          }

          $ufilename = $_FILES['userfile']['name'];
          $ufilebasename = basename($_FILES['userfile']['name']);
          $ext = pathinfo($ufilename, PATHINFO_EXTENSION);
          $uploadfile = $value . '/' . $ufilebasename;

          echo "<p>";
          if ($newName){
            updateFileName($changeMacro,'categories',$value);
          } else if (file_exists($uploadfile)) {
            saveInTemp($value,$ext);
          } else if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
            $_SESSION['already_exist'] = false;
            $setHomepage = $_POST['sethomepage'] ?? '';
            if ($setHomepage != '') { writeFeed($uploadfile,$changeMacro,null); }
            $_SESSION['upload_success'] = true;
          } else {
            echo "Upload failed";
          }
        }

        if($_SESSION['upload_success']){
          ?>
           <div class="success_msg"> File caricato con successo </div>
          <?php
          $_SESSION['upload_success'] = false;
        }

        if (isset($_SESSION['empty_tmp_cat']) && $_SESSION['empty_tmp_cat']) {
          echo "An error has occurred please reload the page";
          $_SESSION['empty_tmp_cat'] = false;
        }else if (isset($_SESSION["autorizzato"])) {
          chdir(__DIR__); // reset position
          ?>

          <form enctype="multipart/form-data" action="uploader.php" method="POST">
            <input type="hidden" name="MAX_FILE_SIZE" value="10000000000" />
            <?php $hideClass = isset($_SESSION['already_exist']) && $_SESSION['already_exist'] ? 'hide' : ''  ?>
            <div class ="<?=$hideClass?>">
              <div class="row gap">
                <div class="col-12 col-sm-4"> Selezionare categoria: </div>
                <div class="col-12 col-sm-8">
                  <div class="row">
                    <div class="col-7 col-sm">
                      <select name="macro">

                      <?php
                      chdir('categories');
                      $dir = getcwd();
                      $files = scandir($dir.'/');
                      foreach($files as $file) {
                        if (is_dir($file) && $file != '.' && $file!='..') {
                          $selectedM = '';
                          if($file == urldecode($changeMacro)){ $selectedM = "selected='selected'"; }
                          echo "<option ".$selectedM." value=".urlencode($file).">".$file . "</option>";
                        }
                      }
                      ?>
                      </select>
                    </div>
                    <div class="col-5 col-sm"> <input type="submit" name="selectMacro" value="Seleziona"> </div>
                  </div>
                </div>
              </div>
            </div>
            <?php if ($changeMacro) { ?>
            <div class ="<?=$hideClass?>">
              <div class="row gap">
                <div class="col-12 col-sm-4">File:</div> 
                <div class="col-12 col-sm-8">
                  <input id="userfile" name="userfile" type="file" />
                  <label for="userfile">Seleziona un file</label>
                </div>
              </div>
              <div class="row gap">
                <div class="col-12 col-sm-4">Selezionare gioco:</div>
                <div class="col-12 col-sm-8">
                  <select name="dir" class="gameSelector">

                  <?php
                    if(is_dir('categories')) chdir('categories');
                    chdir(urldecode($changeMacro));
                    $dir = getcwd();
                    $files = scandir($dir.'/');
                    foreach($files as $file) {
                      if (is_dir($file) && $file != '.' && $file!='..') {
                        echo "<option value=".urlencode($file).">".$file . "</option>";
                      }
                    }
                    echo '<option value="other">Nuovo Gioco</option>';
                  ?>
                  </select>
                </div>
              </div>

              <div id="newGameInfo" class="hide">
                <div class="row gap">
                  <div class="col-12 col-sm-4">Nome nuovo gioco: </div>
                  <div class="col-12 col-sm-8"> <input type="text" name="newFolder" placeholder="Nuovo Gioco"/> </div>
                </div>
                <div class="row gap">
                  <div class="col-12 col-sm-4">Copertina gioco:</div> 
                  <div class="col-12 col-sm-8">
                    <input id="folderfile" name="folderfile" type="file" />
                    <label for="folderfile">Seleziona un file</label>
                  </div>
                </div>
                <div class="row gap">
                  <div class="col-12 col-sm-4">Titolo Descrizione: </div>
                  <div class="col-12 col-sm-8"> <input type="text" name="descTitle" value="" placeholder="Titolo"> </div>
                </div>
                <div class="row gap">
                  <div class="col-12 col-sm-4"> Descrizione: </div>
                  <div class="col-12 col-sm-8"> <textarea name="description" rows="8" cols="80"></textarea> </div>
                </div>
              </div>
            </div>

            <?php if (isset($_SESSION['already_exist']) && $_SESSION['already_exist']) {  ?>
            <div class="row">
              <div class="col-12 col-sm-7">
                <div class="error_msg">Questo file esiste già. Scegliere un nome diverso: </div>
              </div>
              <div class="col-12 col-sm-5">
                <input type="text" name="newName" placeholder="Nuovo nome file"/>
              </div>
            </div>
            <?php
                $_SESSION['already_exist'] = false;
              }
            ?>

            <div class="row gap">
              <div class="col-12 col-sm-4">
                <input id="homefeed" type="checkbox" name="sethomepage" />
                <label for="homefeed">Mostra nella homepage</label>
              </div>
              <div class="final_btn col-12 col-sm-8">
                <input type="submit" name="fileUpload" value="Carica" />
              </div>
            </div>
          <?php } ?>
          </form>
        <?php
        }else {
          header('location:access');
        }
      echo "</div>";
      include('templates/footer.php');
    ?>
    <script type="text/javascript" src="static/js/uploader.js?update=1"></script>
  </body>
</html>
