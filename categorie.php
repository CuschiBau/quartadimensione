<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <?=include('templates/mainStyle.php')?>
  </head>
  <body>
    <?php
      include('templates/header.html');
      include('functions/global.php');

      $macro = $_GET['macro'] ?? '';
      if ($macro) {
        chdir('categories');
        chdir(urldecode($macro));

        $dir = getcwd();
        $files = scandir($dir.'/');
        $sortedD = sortDir($files);
        echo "<ul>";
        foreach($sortedD as $file) {
          if (is_dir($file)) {
            $ad = pathinfo($file);
            if ($file != '.' && $file != '..') {
              $src = $file.'/'.$file.'-fimg.*';
              $result = glob ($src);
              echo "<li>";
              if (count($result) > 0) {
                ?>
                  <a href="reader?macro=<?=$macro?>&folder=<?=$file?>">
                    <img src="categories/<?=$macro?>/<?=$result[0]?>" style="width:200px;" />
                    <div><?=$file?></div>
                  </a>
                <?php
              }else{
                ?>
                  <a href="reader?macro=<?=$macro?>&folder=<?=$file?>">
                    <div style="font-size:20px;color:red;"> <?=$file?> </div>
                  </a>
                <?php
              }
              echo "</li>";
            }

            //print_r($files);
          }
        }
        echo "</ul>";
    }
      //}
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
