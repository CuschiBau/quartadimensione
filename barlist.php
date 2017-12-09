<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Quarta Dimensione - Bar Menu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <?=include('templates/mainStyle.php')?>
    <link rel="stylesheet" href="static/css/bar.css?a=1">
    <?php
      ob_start();
    ?>
  </head>
  <body>
    <?php include('templates/header.html');?>
    <h1>Food & Drinks</h1>

    <div class="container text_center">
        <div class="row">
            <div class="menu_selector col selected_menu" data-selector="#panini">PANINI</div>
            <div class="menu_selector col" data-selector="#bevande">BEVANDE</div>
            <div class="menu_selector col" data-selector="#snacks">SNACKS</div>
            <div class="menu_selector col" data-selector="#dolci">DOLCI</div>
        </div>
    </div>

    <section class="menu_lists">
        
        <?php
            $menu = simplexml_load_file('templates/bar.xml');
            foreach($menu->sezione as $section){
                $display = $section["data-name"] != 'panini' ? 'hide' : '';
                echo '<div class="container item-cont '. $display .'" id="'.$section["data-name"].'">';
                    foreach($section->elemento as $elemento){
                    ?>

                    <div>
                        <div class="row">
                            <div class="col">
                                <div><?=$elemento->nome?></div>
                            </div>
                            <div class="col text_right">
                            <?=$elemento->prezzo?>
                            </div>
                        </div>
                        <div><?=$elemento->ingredienti?></div>
                    </div>
                        
                    <?php
                    }
                echo '</div>';
            }
        ?>
       
    </section>

    <?=include('templates/footer.php');?>
    <script type="text/javascript" src="static/js/barlist.js"></script>
  </body>
</html>