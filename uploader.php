<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
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
        $_SESSION['upload_success'] = false;
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
          updateFileName($changeMacro,'categories');
        } else if (file_exists($uploadfile)) {
          saveInTemp($value,$ext);
        } else if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
          $_SESSION['already_exist'] = false;
          ?>
            <div style="color:green; font-size:20px;"> File uploaded successfully </div>
          <?php
          $setHomepage = $_POST['sethomepage'] ?? '';
          if ($setHomepage != '') { writeFeed($uploadfile,$changeMacro); }
          $_SESSION['upload_success'] = true;
        } else {
           echo "Upload failed";
        }
      }

      if (isset($_SESSION['empty_tmp_cat']) && $_SESSION['empty_tmp_cat']) {
        echo "An error has occurred please reload the page";
        $_SESSION['empty_tmp_cat'] = false;
      }else if (isset($_SESSION["autorizzato"])) {
        ?>

        <form enctype="multipart/form-data" action="uploader.php" method="POST">
          <input type="hidden" name="MAX_FILE_SIZE" value="10000000000" />
          <div class="">
            Selezionare macro categoria: <select name="macro">'

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
            <input type="submit" name="selectMacro" value="Seleziona">
          </div>
          <?php if ($changeMacro) { ?>
            <div>Send this file: <input name="userfile" type="file" /></div>
          <div>Select Folder: <select name="dir">'

          <?php
            chdir('categories');
            chdir(urldecode($changeMacro));
            $dir = getcwd();
            $files = scandir($dir.'/');
            foreach($files as $file) {
              if (is_dir($file) && $file != '.' && $file!='..') {
                echo "<option value=".urlencode($file).">".$file . "</option>";
              }
            }
            echo '<option value="other">other</option></select></div>';
            ?>

            <div>New Folder Name: <input type="text" name="newFolder"/></div>
            <div>Folder Image: <input name="folderfile" type="file" /></div>
            <div class="">Description title: <input type="text" name="descTitle" value=""> </div>
            <div class="">Description: <textarea name="description" rows="8" cols="80"></textarea> </div>
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
          <?php } ?>
        </form>
    <?php
      }else {
        echo "no bravo";
      }
      include('templates/footer.php');
    ?>
  </body>
</html>
