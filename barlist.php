<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Quarta Dimensione - Bar Menu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <?=include('templates/mainStyle.php')?>
    <link rel="stylesheet" type="text/css" href="static/css/slick.css"/>
    <link rel="stylesheet" type="text/css" href="static/css/slick-theme.css"/>
    <link rel="stylesheet" href="static/css/bar.css?a=4">
    <?php
      ob_start();
    ?>
  </head>
  <body>
    <?php include('templates/header.html');?>
    <h1 class="main_title container">Food & Drinks</h1>

    <div class="container text_center menu_container">
        <div class="row">
            <div class="menu_selector col selected_menu" data-selector="0">PANINI</div>
            <div class="menu_selector col" data-selector="1">BEVANDE</div>
            <div class="menu_selector col" data-selector="2">SNACKS</div>
            <div class="menu_selector col" data-selector="3">DOLCI</div>
        </div>
    </div>

    <div class="menu_lists container">        
    <?php
        $menu = simplexml_load_file('templates/bar.xml');
        foreach($menu->sezione as $section){
            $display = $section["data-name"] != 'panini' ? '' : '';
            echo '<div class="item_cont '. $display .'" id="'.$section["data-name"].'">';
                foreach($section->elemento as $elemento){
                ?>

                <div>
                    <div class="row bar_nameprice">
                        <div class="col">
                            <div><?=$elemento->nome?></div>
                        </div>
                        <div class="col text_right">
                        <?=$elemento->prezzo?>
                        </div>
                    </div>
                    <div class="bar_ingredients"><?=$elemento->ingredienti?></div>
                </div>
                    
                <?php
                }
            echo '</div>';
        }
    ?>
    </div>

    <?=include('templates/footer.php');?>
    <script type="text/javascript" src="static/js/slick.min.js"></script>
    <script type="text/javascript" src="static/js/barlist.js?a=3"></script>
  </body>
</html>