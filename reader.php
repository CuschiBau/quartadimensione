<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Categorie</title>
    <?=include('templates/mainStyle.php')?>
  </head>
  <body>
    <?php
      session_start();
      include('templates/header.html');
      include('functions/global.php');
      include('functions/readerFunctions.php');
      chdir('categories');
      $macro = $_GET['macro'] ?? '';
      $folder = $_GET['folder'] ?? '';
      $cUrl = returnURL().'?macro='.$macro.'&folder='.$folder;

      if ($folder != '' && $macro != '') {
        chdir($macro);
        chdir($folder);

        $imageUpload = $_POST['imageUpload'] ?? '';
        $newTitle = $_POST['newTitle'] ?? '';
        $description = $_POST['description'] ?? '';
        if (isset($_SESSION["autorizzato"])){
          if ($imageUpload) { changeImage($macro,$folder); }
          if($newTitle) { changeTitle($macro,$folder,$newTitle);}
          if ($description) { changeDesc($macro,$folder,$description); }
        }

        $files = scandir(getcwd());
        $src = $folder.'-fimg.*';
        $result = glob ($src);
        if (count($result) > 0) {
          $src = $macro.'/'.$folder.'/'.$result[0];
          ?>
            <div class="">
              <img src="categories/<?=$src?>" style="width:200px;" />
            </div>
          <?php
        }
        $uImage = $_GET['changeImage'] ?? '';
        if ($uImage && isset($_SESSION["autorizzato"])) {
          ?>
          <form enctype="multipart/form-data" class="" action="<?=$cUrl?>" method="post">
            <input type="hidden" name="MAX_FILE_SIZE" value="10000000000" />
            <div>Send this file: <input name="newImage" type="file" /></div>
            <input type="submit" name="imageUpload" value="Send File" />
          </form>
          <?php
        } elseif (isset($_SESSION["autorizzato"])) {
          $actual_link = $cUrl."&changeImage=1";
          echo "<a href='".$actual_link."'>Modifica Immagine</a>";
        }

        $return = $_POST['fileUpload'] ?? '';
        if ($return) { uploadInGallery($macro,$folder); }

        if (file_exists($folder.'-dT.txt')) {
          $title = file_get_contents($folder.'-dT.txt');
          $uTitle = $_GET['changeTitle'] ?? '';
          if ($uTitle && isset($_SESSION["autorizzato"])) {
            ?>
            <form class="" action="<?=$cUrl?>" method="post">
              <input type="text" name="newTitle" value="<?=$title?>">
              <input type="submit" name="submit" value="Modifica" />
            </form>
            <?php
          } else {
            echo "<h1>".$title."</h1>";
            if (isset($_SESSION["autorizzato"])) {
              $actual_link = $cUrl."&changeTitle=1";
              echo "<a href='".$actual_link."'>Modifica Titolo</a>";
            }
          }
        }

        if (file_exists($folder.'-d.txt')) {
          $desc = file_get_contents($folder.'-d.txt');
          $uDesc = $_GET['changeDesc'] ?? '';
          if ($uDesc && isset($_SESSION["autorizzato"])) {
            ?>
            <form class="" action="<?=$cUrl?>" method="post">
              <textarea name="description" rows="8" cols="80"><?=$desc?></textarea>
              <input type="submit" name="submit" value="Modifica" />
            </form>
            <?php
          } else {
            echo "<div>".$desc."</div>";
            if (isset($_SESSION["autorizzato"])) {
              $actual_link = $cUrl."&changeDesc=1";
              echo "<a href='".$actual_link."'>Modifica Descrizione</a>";
            }
          }
        }
        echo "<ul>";

        foreach($files as $file) {
          if (!is_dir($file)) {
            $ad = pathinfo($file);
            if ($ad['filename'] != $folder.'-fimg' && $ad['filename'] != $folder.'-d' && $ad['filename'] != $folder.'-dT' ) {
              echo '<li><a href="categories/'.$macro.'/'.$folder.'/'.$file.'">'.$file.'</a></li>';
            }
          }
        }
        echo "</ul>";

        if (isset($_SESSION["autorizzato"])) {
          $uGallery = $_GET['uploadGallery'] ?? '';
          if ($uGallery) {
            ?>
              <form enctype="multipart/form-data" class="" action="<?=$cUrl?>" method="post">
                <input type="hidden" name="MAX_FILE_SIZE" value="10000000000" />
                <div>Send this file: <input name="userfile" type="file" /></div>
                <input type="submit" name="fileUpload" value="Send File" />
              </form>
            <?php
          }else {
            $actual_link = $cUrl."&uploadGallery=1";
            echo "<a href='".$actual_link."'>Carica Immagini Gallery</a>";
          }
        }

        printGallery($macro,$folder);
      }
    // header("Content-Type: application/octet-stream");
    // header("Content-Transfer-Encoding: Binary");
    // header("Content-disposition: attachment; filename=\"".$files[2]."\"");
    // echo readfile($url);
    // rsort($files);
    //
    // print_r($files);
      include('templates/footer.php');
    ?>
  </body>
</html>
