<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Categorie</title>
    <?=include('templates/mainStyle.php')?>
    <link rel="stylesheet" type="text/css" href="static/css/game.css?update=8"/>
  </head>
  <body>
    <?php
      session_start();
      include('templates/header.html');
      $loggedClass = isset($_SESSION["autorizzato"]) ? 'logged_user' : 'guest_user';
      echo "<div id='main_cont' class='container ".$loggedClass."'>";

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
          $remove = $_POST['removeFile'] ?? '';
          if (isset($_SESSION["autorizzato"])){
            if ($imageUpload) { changeImage($cUrl,$macro,$folder); }
            if($newTitle) { changeTitle($cUrl,$macro,$folder,$newTitle);}
            if ($description) { changeDesc($cUrl,$macro,$folder,$description); }
            if ($remove) { removeFile($cUrl,$remove); }
          }

          $files = scandir(getcwd());
          $src = $folder.'-fimg.*';
          $result = glob ($src);
          echo '<div class="game_logo">';
            if (count($result) > 0) {
              $src = $macro.'/'.$folder.'/'.$result[0];
              ?>
              <img src="categories/<?=$src?>" />
              <?php
            }
            $uImage = $_GET['changeImage'] ?? '';
            if ($uImage && isset($_SESSION["autorizzato"])) {
              ?>
              <form enctype="multipart/form-data" class="" action="<?=$cUrl?>" method="post">
                <input type="hidden" name="MAX_FILE_SIZE" value="10000000000" />
                <div class="gap"></div>
                <div class="row">
                  <div class="col-8">
                    <input id="newImage" name="newImage" type="file" />
                    <label for="newImage">Seleziona Immagine </label>
                  </div>
                  <div class="col-4">
                    <input type="submit" name="imageUpload" value="Carica" />
                  </div>
                </div>
              </form>
              <?php
            } elseif (isset($_SESSION["autorizzato"])) {
              $actual_link = $cUrl."&changeImage=1";
              echo "<a href='".$actual_link."' class='edit_link image'><img alt='Modifica Immagine' src='static/images/edit.png'></a>";
            }
          echo '</div>';

          $return = $_POST['fileUpload'] ?? '';
          if ($return) { uploadInGallery($cUrl,$macro,$folder); }

          echo "<div class='row'>";
            echo "<div class='col-12 col-sm-6'>";
              echo '<div class="title_cont">';
                $uTitle = $_GET['changeTitle'] ?? '';
                if (file_exists($folder.'-dT.txt')) {
                  $title = file_get_contents($folder.'-dT.txt');
                  if ($uTitle && isset($_SESSION["autorizzato"])) {
                    ?>
                    <form class="" action="<?=$cUrl?>" method="post">
                      <div class="row">
                        <div class="col-8">
                          <input type="text" name="newTitle" value="<?=$title?>" class="title_field">
                        </div>
                        <div class="col-4">
                          <input type="submit" name="submit" value="Modifica" />
                        </div>
                      </div>
                    </form>
                    <?php
                  } else {
                    echo "<h1 class='game_title'>".$title."</h1>";
                  }
                }else if ($uTitle && isset($_SESSION["autorizzato"])) {
                  ?>
                  <form class="" action="<?=$cUrl?>" method="post">
                    <div class="row">
                        <div class="col-8">
                          <input type="text" name="newTitle" value="">
                        </div>
                        <div class="col-4">
                          <input type="submit" name="submit" value="Modifica" />
                        </div>
                      </div>
                  </form>
                  <?php
                }
                if (isset($_SESSION["autorizzato"]) && !$uTitle) {
                  $actual_link = $cUrl."&changeTitle=1";
                  echo "<a href='".$actual_link."' class='edit_link titolo'><img alt='Modifica Titolo' src='static/images/edit.png'></a>";
                }
              echo "</div>";
              
              echo "<div class='desc_cont'>";
                $uDesc = $_GET['changeDesc'] ?? '';
                if (file_exists($folder.'-d.txt')) {
                  $desc = file_get_contents($folder.'-d.txt');
                
                  if ($uDesc && isset($_SESSION["autorizzato"])) {
                    ?>
                    <form class="" action="<?=$cUrl?>" method="post">
                      <textarea name="description" rows="8" cols="80"><?=$desc?></textarea>
                      <input type="submit" name="submit" value="Modifica" />
                    </form>
                    <?php
                  } else {
                    echo "<div>".$desc."</div>";
                  }
                } else if ($uDesc && isset($_SESSION["autorizzato"])) {
                  ?>
                  <form class="" action="<?=$cUrl?>" method="post">
                    <textarea name="description" rows="8" cols="80"></textarea>
                    <input type="submit" name="submit" value="Modifica" />
                  </form>
                  <?php
                }
                if (isset($_SESSION["autorizzato"]) && !$uDesc) {
                  $actual_link = $cUrl."&changeDesc=1";
                  echo "<a href='".$actual_link."' class='edit_link descrizione'><img alt='Modifica Descrizione' src='static/images/edit.png'></a>";
                }
              echo "</div>";
            echo "</div>";
            echo "<div class='col-12 col-sm-6'>";
              echo "<h2 class='files_title'>Files</h2>";
              echo '<form class="" action="'.$cUrl.'" method="post">';
                echo "<ul class='file_list'>";

                $sorted = sortFiles($files);
                foreach($sorted as $file) {
                  if (!is_dir($file)) {
                    $ad = pathinfo($file);
                    $ext = pathinfo($file, PATHINFO_EXTENSION);
                    if ($ad['filename'] != $folder.'-fimg' && $ad['filename'] != $folder.'-d' && $ad['filename'] != $folder.'-dT' ) {
                      ?>
                      <li>
                        <div class="row">
                          <div class="col-10">
                            <span><?=$ext?></span>
                            <a href="categories/<?=$macro?>/<?=$folder?>/<?=$file?>"><?=$file?></a>
                          </div>
                          <div class="col-2 text-right">
                            <?php if(isset($_SESSION['autorizzato'])){ ?>
                              <span>
                                <button class="remove_btn" name="removeFile" value="<?=$file?>">
                                  <img src="static/images/delete.png" alt="Elimina File">
                                </button>
                              </span>
                            <?php } ?>
                          </div>
                        </div>
                      </li>
                      <?php
                    }
                  }
                }
                echo "</ul>";
              echo "</form>";
            echo "</div>";
          echo "</div>";

          echo "<div class='gallery_cont'>";
            echo "<h2 class='gallery_title'>Gallery</h2>";
            if (isset($_SESSION["autorizzato"])) {
              $uGallery = $_GET['uploadGallery'] ?? '';
              if ($uGallery) {
                ?>
                  <form enctype="multipart/form-data" class="" action="<?=$cUrl?>" method="post">
                    <input type="hidden" name="MAX_FILE_SIZE" value="10000000000" />
                    <div class="row gap">
                      <div class="col-12 col-sm-8">
                        <input id="userfile" name="userfile" type="file" />
                        <label for="userfile">Seleziona Immagine </label>
                      </div>
                      <div class="col-12 col-sm-4">
                        <input type="submit" name="fileUpload" value="Carica" />
                      </div>
                    </div>
                  </form>
                <?php
              }else {
                $actual_link = $cUrl."&uploadGallery=1";
                echo "<a href='".$actual_link."' class='edit_link gallery'><img alt='Carica Immagini Gallery' src='static/images/add.png'></a>";                
              }
            }
          echo "</div>";
          
          echo "<div class=''>";
            printGallery($macro,$folder);
          echo "</div>";
        }
      echo "</div>";
      include('templates/footer.php');
    ?>
  </body>
</html>
