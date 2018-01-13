<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bar Menu</title>
    <?=include('templates/mainStyle.php')?>
    <link rel="stylesheet" type="text/css" href="static/css/slick.css"/>
    <link rel="stylesheet" type="text/css" href="static/css/slick-theme.css"/>
    <link rel="stylesheet" href="static/css/bar.css?a=8">
  </head>
  <body>
    <?php include('templates/header.html');?>
    <div id="main_cont">
        <h1 class="main_title container">Food & Drinks</h1>

        <?php 
            $menu = simplexml_load_file('templates/bar.xml');
        ?>

        <div class="container text_center menu_container">
            <div class="row menu_row">
                <?php 
                    $i = 0;
                    foreach($menu->sezione as $section){
                        $selected = $i == 0 ? 'selected_menu' : '';
                        echo '<div class="menu_selector col '.$selected.'" data-selector="'.$i.'">'.strtoupper($section["data-name"]).'</div>';
                        $i++;
                    }
                ?>
            </div>
        </div>

        <div class="menu_lists container">        
        <?php
            
            foreach($menu->sezione as $section){
                $display = $section["data-name"] != 'panini' ? '' : '';
                echo '<div class="item_cont '. $display .'" id="'.$section["data-name"].'">';
                    foreach($section->elemento as $elemento){
                        if($elemento->subsection){

                            ?>
                                <div class="subtitle"><?=$elemento->subsection?></div>
                            <?php
                            
                        }else{                        
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
                    }
                echo '</div>';
            }
        ?>
        </div>
    </div>
    <?=include('templates/footer.php');?>
    <script type="text/javascript" src="static/js/slick.min.js"></script>
    <script type="text/javascript" src="static/js/barlist.js?a=3"></script>
  </body>
</html>