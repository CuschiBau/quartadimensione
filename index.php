<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Quarta Dimensione - Home</title>
    <?=include('templates/mainStyle.php')?>
    <link rel="stylesheet" type="text/css" href="static/css/slick.css"/>
    <link rel="stylesheet" type="text/css" href="static/css/slick-theme.css"/>
    <link rel="stylesheet" type="text/css" href="static/css/index.css?update=4"/>

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
                  $result = glob (addslashes($src));
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

      <div class="container">
          <div class="desktop_view">
            <div class="row box_content chi_siamo">
              <div class="col-6 left_box">
                <div class="opacize"></div>
                <span>CHI SIAMO</span>
              </div>
              <div class="col-6 right_box">
                <div>
                  <span class="orange_text">Quarta Dimensione</span> è un locale dedicato all'incontro e alla socializzazione attraverso il 
                  <span class="blue_text">Gioco di Società</span> con adeguato servizio di 
                  <span class="green_text">Bar e ristorazione</span>
                </div>
              </div>
            </div>

            
            <div class="row box_content dove_siamo times_cont">
              <div class="col-6 left_box">
                <div class="opacize"></div>
                <span>DOVE SIAMO</span>
              </div>
              <div class="col-6 right_box">
                <div class="row">
                  <div class="col-2" style="margin-top:5px;"> <img src="static/images/pin.png" alt="" aria-hidden="true"> </div>
                  <div class="col-10"> 
                    <div>Via Ermes di Colloredo 14</div>
                    <div>Udine, Italy</div> 
                  </div>
                </div>
                <div class="text_right">
                  <a href="https://www.google.it/maps/place/Quarta+Dimensione/@46.0716838,13.2310544,17z/data=!4m12!1m6!3m5!1s0x477a355f02cccdc5:0x6d9f7709b20a53e7!2sQuarta+Dimensione!8m2!3d46.0716801!4d13.2332485!3m4!1s0x477a355f02cccdc5:0x6d9f7709b20a53e7!8m2!3d46.0716801!4d13.2332485?hl=en" target="_blank">
                    <span>Apri in Maps</span>
                    <img src="static/images/directions.png" alt="" aria-hidden="true">
                  </a>
                </div>
                <div class="orari">
                  <img src="static/images/time.png" alt="" aria-hidden="true">
                  <span>ORARI</span>
                </div>
              </div>
              <div class="times_body col-6">
                <div class="close_times">INDIRIZZO</div>
                <div class="times_table">
                  <div class="row"> <div class="col">Lunedì</div> <div class="col text_right">16.00 - 01.00</div> </div>
                  <div class="row"> <div class="col">Martedì</div> <div class="col text_right">16.00 - 01.00</div> </div>
                  <div class="row"> <div class="col">Mercoledì</div> <div class="col text_right">16.00 - 01.00</div> </div>
                  <div class="row"> <div class="col">Giovedì</div> <div class="col text_right">16.00 - 01.00</div> </div>
                  <div class="row"> <div class="col">Venerdì</div> <div class="col text_right">10.00 - 01.00</div> </div>
                  <div class="row"> <div class="col">Sabato</div> <div class="col text_right">10.00 - 01.00</div> </div>
                  <div class="row"> <div class="col">Domenica</div> <div class="col text_right">15.00 - 01.00</div> </div>
                </div>
              </div>  
            </div>

            <div class="row box_content contatti">
              <div class="col-6 left_box">
                <div class="opacize"></div>
                <span>CONTATTI</span>
              </div>
              <div class="col-6 right_box">
                <div class="gap">
                  <a target="_blank" href="https://www.facebook.com/quarta.dimensione.50/">
                    <img src="static/images/fb.png" alt="Facebook link">
                    <span>@quarta.dimensione.50</span>
                  </a>
                </div>
                <div class="gap">
                  <a href="mailto:info@quarta-dimensione.net">
                    <img src="static/images/email.png" alt="Manda email">
                    <span>info@quarta-dimensione.net</span>
                  </a>
                </div>
                <div class="gap">
                  <a href="tel:0432477575">
                    <img src="static/images/phone.png" alt="Chiama">
                    <span>0432 477575</span>
                  </a>
                </div>
              </div>
            </div>
          </div>

          <div class="mobile_view">

            <div class="box_content chi_siamo">
              <div class="box_background">
                <div class="top_image">
                  <div class="opacize"></div>
                </div>
                <div class="bottom_bg"></div>
              </div>
              <div class="box_body">
                <div class="box_title">CHI SIAMO</div>
                <div>
                  <span class="orange_text">Quarta Dimensione</span> è un locale dedicato all'incontro e alla socializzazione attraverso il 
                  <span class="blue_text">Gioco di Società</span> con adeguato servizio di 
                  <span class="green_text">Bar e ristorazione</span>
                </div>
              </div>
            </div>
            
          </div>

      </div>

      <?=include('templates/footer.php');?>
    </div>


    <!-- ALL JS -->
    
    <script type="text/javascript" src="static/js/slick.min.js"></script>
    <script type="text/javascript" src="static/js/index.js?update=3"></script>
  </body>
</html>
