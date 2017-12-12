<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Fantacalcio</title>
    <?=include('templates/mainStyle.php')?>
    <link rel="stylesheet" href="static/css/logged.css?a=3">
    <link rel="stylesheet" href="static/css/game.css?a=3">
  </head>
  <body>
    <?php
      include('functions\global.php');
      include('functions\uploaderFunctions.php');
      include('functions/readerFunctions.php');
      include('templates/header.html');
      session_start();

      chdir('fanta');
      $remove = $_POST['removeFile'] ?? '';
      $cUrl = returnURL();
      if (isset($_SESSION["autorizzato"]) && $remove){ 
        $removeLeague = urldecode(explode('|',$remove)[0]);
        $removeFile = explode('|',$remove)[1];
        if(is_dir($removeLeague)) chdir($removeLeague);
        removeFile($cUrl,$removeFile); 
      }
      chdir('..');

      echo "<div class='container' id='main_cont'>";
        echo "<h1 class='main_title'>Fantacalcio</h1>";
        $return = $_POST['fileUpload'] ?? '';
        $changeMacro = $_POST['macro'] ?? '';        
        if ($return) {
          chdir('fanta');
          if($changeMacro != 'other') chdir(urldecode($changeMacro));

          $value = urldecode($changeMacro);
          $newName = $_POST['newName'] ?? '';

          if($value == 'other'){
            $newFolder = $_POST['newFolder'] ?? '';
            if(!is_dir($newFolder)){ createNewCat($newFolder,false); }
            $value = $newFolder;
          }

          $ufilename = $_FILES['userfile']['name'];
          $ufilebasename = basename($_FILES['userfile']['name']);
          $ext = pathinfo($ufilename, PATHINFO_EXTENSION);
          $uploadfile =  $ufilebasename;

          if ($newName){
            updateFileName($changeMacro,'fanta');
          } else if (file_exists($uploadfile)) {
            saveInTemp($value,$ext);
            chdir('fanta');
          } else if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
            $_SESSION['already_exist'] = false;
            ?>
              <div class="success_msg"> File caricato con successo </div>
            <?php
            $setHomepage = $_POST['sethomepage'] ?? '';
            if ($setHomepage != '') { writeFeed($uploadfile,$value); }
            $_SESSION['upload_success'] = true;
          } else {
            echo "<div class='error_msg'>Caricamento fallito</div>";
          }
          chdir('..');
        }
        
      ?>
        <form enctype="multipart/form-data" action="fantacalcio" method="POST">
          <input type="hidden" name="MAX_FILE_SIZE" value="10000000000" />
          <?php $hideClassI = isset($_SESSION['already_exist']) && $_SESSION['already_exist'] ? 'hide' : '' ?>
          <div class="gap <?=$hideClassI?>">        
            <select name="macro" id="changeLeague">
          
            <?php
              chdir('fanta');
              $dir = getcwd();
              $files = scandir($dir.'/');
              $files = sortFiles($files);
              foreach($files as $file) {
                if (is_dir($file) && $file != '.' && $file!='..') {
                  $selectedM = '';
                  if($file == urldecode($changeMacro)){ $selectedM = "selected='selected'"; }
                  echo "<option ".$selectedM." value=".urlencode($file).">".$file . "</option>";
                }
              }
              if (isset($_SESSION["autorizzato"])) {
                $selectedM = '';
                if('other' == urldecode($changeMacro)){ $selectedM = "selected='selected'"; }
                echo "<option ".$selectedM." value='other'>Nuova Serie</option>";
              }
              ?>
              </select>
          </div>
          <div class="hide"><input type="submit" name="selectMacro" value="Seleziona" class="changeLeagueBtn"></div>
          
          <?php
            if(!isset($changeMacro) || $changeMacro == ''){     
              $dir = scandir(getcwd().'/');
              $sorted = sortFiles($dir);
              foreach($sorted as $fol){
                if($fol != '..' && $fol != '.') {
                  $changeMacro = $fol;
                  break;
                }
              }
            }
          ?>

          <?php if ($changeMacro && isset($_SESSION["autorizzato"])) { ?>
            <div class="<?=$hideClassI?>">
              <div class="row gap">
                <div class="col-12 col-sm-4 line_height_40">File:</div> 
                <div class="col-12 col-sm-8">
                  <input id="userfile" name="userfile" type="file" />
                  <label for="userfile">Seleziona un file</label>
                </div>
              </div>
              <?php $hideClass = $changeMacro != 'other' ? 'hide' : '' ?>
              <div class="row gap <?=$hideClass?>">
                <div class="col-12 col-sm-4 line_height_40">Nome nuova serie: </div>
                <div class="col-12 col-sm-8"> <input type="text" name="newFolder" placeholder="Nuova Serie"/> </div>
              </div>
            </div>

            <?php
            if (isset($_SESSION['already_exist']) && $_SESSION['already_exist']) {
              ?>
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
            
          <?php 
            } 

            if($changeMacro && is_dir(urldecode($changeMacro))) {
              chdir(urldecode($changeMacro));
              $files = scandir(getcwd().'/');
              $sorted = sortFiles($files);            
              echo "<ul class='file_list'>";
              foreach($sorted as $file) {
                if (!is_dir($file)) {
                  $ad = pathinfo($file);
                  $ext = pathinfo($file, PATHINFO_EXTENSION);
                  $lastModified = date('F d Y, H:i:s',filemtime($file));
                  ?>
                  <div class="row">
                    <div class="col-10">
                      <span><?=$ext?></span>
                      <a href="fanta/<?=urldecode($changeMacro)?>/<?=$file?>"><?=$file?></a>
                    </div>
                    <div class="col-2 text-right">
                      <?php if(isset($_SESSION['autorizzato'])){ ?>
                        <span>
                          <button class="remove_btn" name="removeFile" value="<?=$changeMacro.'|'.$file?>">
                            <img src="static/images/delete.png" alt="Elimina File">
                          </button>
                        </span>
                      <?php } ?>
                    </div>
                  </div>
                  <?php
                }
              }
              echo '</ul>';
            } 
          ?>
        </form>
      </div>
    <?php
      include('templates/footer.php');
    ?>
    <script type="text/javascript" src="static/js/uploader.js?update=1"></script>
  </body>
</html>
