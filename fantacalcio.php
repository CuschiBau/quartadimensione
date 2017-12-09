<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Fantacalcio</title>
    <?=include('templates/mainStyle.php')?>
  </head>
  <body>
    <?php
      include('functions\global.php');
      include('functions\uploaderFunctions.php');
      include('templates/header.html');
      session_start();

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
            <div style="color:green; font-size:20px;"> File uploaded successfully </div>
          <?php
          $setHomepage = $_POST['sethomepage'] ?? '';
          if ($setHomepage != '') { writeFeed($uploadfile,$value); }
          $_SESSION['upload_success'] = true;
        } else {
           echo "Upload failed";
        }
        chdir('..');
      }
      
    ?>
      <form enctype="multipart/form-data" action="fantacalcio" method="POST">
        <input type="hidden" name="MAX_FILE_SIZE" value="10000000000" />
        <div class="">        
        Selezionare lega categoria: <select name="macro">'
        
        <?php
          chdir('fanta');
          $dir = getcwd();
          $files = scandir($dir.'/');
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
            echo "<option ".$selectedM." value='other'>Altro</option>";
          }
          ?>
          </select>
         
          <input type="submit" name="selectMacro" value="Seleziona">
          
        </div>
        
        <?php
          if(!isset($changeMacro) || $changeMacro == ''){
            $dir = scandir(getcwd().'/');
            $sorted = sortFiles($dir);
            $changeMacro = $sorted[0];
          }
        ?>

        <?php if ($changeMacro && isset($_SESSION["autorizzato"])) { ?>
          <div>Send this file: <input name="userfile" type="file" /></div>
          <div>New Folder Name: <input type="text" name="newFolder"/></div>
          <div>Has to be on homepage : <input type="checkbox" name="sethomepage" /></div>
          <?php

          if (isset($_SESSION['already_exist']) && $_SESSION['already_exist']) {
            ?>
              <div style="color:red; font-size:20px">This file already exist. Please set a new name below:</div>
              <div class="">
                <input type="text" name="newName"/>
              </div>
            <?php
            $_SESSION['already_exist'] = false;
          }
          ?>
          <input type="submit" name="fileUpload" value="Send File" />
        <?php 
          } 

          if($changeMacro) {
            chdir(urldecode($changeMacro));
            $files = scandir(getcwd().'/');
            $sorted = sortFiles($files);            
            echo '<ul>';
            foreach($sorted as $file) {
              if (!is_dir($file)) {
                $ad = pathinfo($file);
                $lastModified = date('F d Y, H:i:s',filemtime($file));
                echo '<li><a href="fanta/'.urldecode($changeMacro).'/'.$file.'">'.$file.'</a></li>';
              }
            }
            echo '</ul>';
          } 
        ?>
      </form>
    <?php
      include('templates/footer.php');
    ?>
  </body>
</html>
