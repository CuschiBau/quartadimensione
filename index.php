<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Home</title>
    <?=include('templates/mainStyle.php')?>
  </head>
  <body>
    <div class="">

      <?php

          include('templates/header.html');
          chdir('categories');

          if (file_exists("homefeed.txt")) {
            $myfile = fopen("homefeed.txt","r");

            $home = [];

            while(! feof($myfile)) { $home[] = fgets($myfile); }

            fclose($myfile);
            //print_r($home);

            echo "<ul>";
            foreach ($home as $feed) {
              if (trim($feed) != '') {
                $macro = explode('/',trim($feed))[0];
                $folder = explode('/',trim($feed))[1];
                $file = explode('/',trim($feed))[2];
                $src = $folder.'/'.$folder.'-fimg.*';
                $fileName =  explode('.',trim($file))[0];
                $fileExt =  explode('.',trim($file))[1];
                $startingF = "categories/";
                if ($macro == 'fanta') {
                  chdir('..');
                  chdir($macro);
                  $startingF = '';
                }else { chdir($macro); }
                $result = glob ($src);
                ?>
                  <li>
                    <div class="">
                      <?php
                        if (count($result) > 0) {
                          ?>
                            <img src="<?=$startingF.'/'.$macro.'/'.$result[0]?>" style="width:200px;" />
                          <?php
                        }else if($macro == 'fanta'){
                          ?>
                            <img src="static/images/fanta.jpg" style="width:200px;" />
                          <?php
                        } else {
                          ?>
                            <div style="font-size:20px;color:red;"> <?=$folder?> </div>
                          <?php
                        }
                      ?>

                      <div class=""> Ext ico: <?=$fileExt?> </div>
                      <div class=""> File: <a href="<?=$startingF?><?=$macro?>/<?=$folder?>/<?=$file?>"><?=$fileName?></a></div>
                      <div class=""> Caricato in: <a href="reader?macro=<?=$macro?>&folder=<?=$folder?>"><?=$folder?></a> </div>
                    </div>
                  </li>
                  <?php
                  chdir('..');
                  if ($macro == 'fanta') { chdir('categories'); }
              }
            }
            echo "</ul>";
          }

      ?>


      <?=include('templates/footer.php');?>
    </div>
  </body>
</html>
