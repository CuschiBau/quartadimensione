<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <form class="" action="manage.php" method="post">


      <?php
        // TODO DELETE ALSO FROM HOMEFEED
        include('templates/header.html');
        session_start(); //inizio la sessione

        if (isset($_SESSION["autorizzato"]) && $_SESSION["autorizzato"]) {
          chdir('categories');
          $deleting = $_POST['toDelete'] ?? '';
          if ($deleting) {
            $folderD = explode('|',$deleting)[0] ?? '';
            $fileD = explode('|',$deleting)[1] ?? '';
            if ($folderD != '') {

              if ($fileD != '') {
                chdir($folderD);
                unlink($fileD);
                chdir('..');
              } else {
                array_map('unlink', glob("$folderD/*.*"));
                 rmdir($folderD);
              }


            }
          }
          $dir = getcwd();
          $files = scandir($dir.'/');
          echo "<ul>";
          foreach($files as $file) {
            if ($file != '.' && $file != '..' && $file != 'homefeed.txt') {
              if (is_dir($file)) {
                ?>
                <li>
                  <div class="">
                    <div class=""><?=$file?></div>
                    <div class="">
                      <button type="submit" name="toDelete" value="<?=$file?>">Cancella cartella</button>
                    </div>
                  </div>
                </li>
                <?php
                $newPath =  getcwd() . '/' . $file;
                $newFiles = scandir($newPath.'/');
                echo "<ul>";
                foreach($newFiles as $trueFile) {
                  if ($trueFile != '.' && $trueFile != '..') {
                    ?>
                    <li>
                      <div class="">
                        <div class=""><?=$trueFile?></div>
                        <div class="">
                          <button type="submit" name="toDelete" value="<?=$file?>|<?=$trueFile?>">Cancella file</button>
                        </div>
                      </div>
                    </li>
                    <?php
                  }
                }
                echo "</ul>";
              }else{
                echo '<li>'.$file.'</li>';
              }
            }
          }
          echo "</ul>";
        }else {
          echo "NON LOGGATO";
        }
        include('templates/footer.php');
      ?>

    </form>
  </body>
</html>
