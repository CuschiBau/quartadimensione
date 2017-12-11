<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Quarta Dimensione - Home</title>
    <?=include('templates/mainStyle.php')?>
    <link rel="stylesheet" type="text/css" href="static/css/slick.css"/>
    <link rel="stylesheet" type="text/css" href="static/css/slick-theme.css"/>
    <link rel="stylesheet" type="text/css" href="static/css/index.css?update=1"/>

  </head>
  <body>
    <div class="">

      <?php

          include('templates/header.html');
          chdir('categories');
          echo "<div id='main_cont'>";
            if (file_exists("homefeed.txt")) {
              $myfile = fopen("homefeed.txt","r");

              $home = [];

              while(! feof($myfile)) { $home[] = fgets($myfile); }

              fclose($myfile);
              //print_r($home);

              echo "<div id='cards_container'><div class='cards_title'>Ultime Notizie</div><div id='cards_slider'>";
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
                  echo '1: '.addslashes($src);
                  $result = glob ($src);
                  ?>
                    <div>
                      <div class="card">
                        
                          <?php
                            if (count($result) > 0) {
                              ?>
                              <div class="img_cont" style="background-image: url('<?=$startingF.'/'.$macro.'/'.$result[0]?>')"></div>
                              <?php
                            }else if($macro == 'fanta'){
                              ?>
                              <div class="img_cont" style="background-image: url('static/images/fanta.jpg')"></div>
                              <?php
                            } else {
                              ?>
                                <div class="img_cont" style="font-size:20px;color:red;"> <?=$folder?> </div>
                              <?php
                            }
                          ?>
                        
                        <div class="card_infos">
                          <div class="card_ext"> <?=$fileExt?> </div>
                          <div class="card_text">
                          <div class="card_fileName"><a href="<?=$startingF?><?=$macro?>/<?=$folder?>/<?=$file?>"><?=$fileName?></a></div>
                          <div class="card_category"> Caricato in <span class="card_label"><a href="reader?macro=<?=$macro?>&folder=<?=$folder?>"><?=$folder?></a><span> </div>
                          </div>
                        </div>
                      </div>
                        </div>
                    <?php
                    chdir('..');
                    if ($macro == 'fanta') { chdir('categories'); }
                }
              }
              echo "</div></div>";
            }
          echo "</div>";
      ?>


      <?=include('templates/footer.php');?>
    </div>


    <!-- ALL JS -->
    
    <script type="text/javascript" src="static/js/slick.min.js"></script>
    <script type="text/javascript" src="static/js/index.js?update=1"></script>
  </body>
</html>
