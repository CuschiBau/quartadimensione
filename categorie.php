<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title><?=$_GET['macro'] ?? 'Categoria'?></title>
    <?=include('templates/mainStyle.php')?>
    <link rel="stylesheet" href="static/css/categories.css?a=2">
  </head>
  <body>
    <?php
      include('templates/header.html');
      include('functions/global.php');
    ?>
    <div id="main_cont">
      <?php
        $macro = $_GET['macro'] ?? '';
        if ($macro) {

          echo '<h1 class="container main_title">'.$macro.'</h1>';

          chdir('categories');
          chdir(urldecode($macro));

          $dir = getcwd();
          $files = scandir($dir.'/');
          $sortedD = sortDir($files);
          echo "<div class='container'>";
            echo "<div class='row'>";
            foreach($sortedD as $file) {
              if (is_dir($file)) {
                $ad = pathinfo($file);
                if ($file != '.' && $file != '..') {
                  $src = $file.'/'.$file.'-fimg.*';
                  $result = glob ($src);
                  echo "<div class='game_item col-12 col-md-3 col-sm-6'>";
                  if (count($result) > 0) {
                    ?>
                      <a href="reader.php?macro=<?=$macro?>&folder=<?=$file?>" class="align-middle">
                        <img src="categories/<?=$macro?>/<?=$result[0]?>" class="align-middle"/>
                      </a>
                    <?php
                  }else{
                    ?>
                      <a href="reader.php?macro=<?=$macro?>&folder=<?=$file?>">
                        <div style="font-size:20px;color:red;"> <?=$file?> </div>
                      </a>
                    <?php
                  }
                  echo "</div>";
                }

                //print_r($files);
              }
            }
            echo "</div>"; 
          echo "</div>";
      }
        //}
      // header("Content-Type: application/octet-stream");
      // header("Content-Transfer-Encoding: Binary");
      // header("Content-disposition: attachment; filename=\"".$files[2]."\"");
      // echo readfile($url);
      // rsort($files);
      //
      // print_r($files);
      ?>
      </div>
    <?php
      include('templates/footer.php');
    ?>
  </body>
</html>
