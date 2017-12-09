<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Quarta Dimensione - Bar Menu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <?=include('templates/mainStyle.php')?>
    <link rel="stylesheet" href="static/css/bar.css">
    <?php
      ob_start();
    ?>
  </head>
  <body>
    <?php include('templates/header.html');?>
    <h1>Food & Drinks</h1>

    <div>
        <div>Panini</div>
        <div>Bevande</div>
        <div>Snacks</div>
        <div>Dolci</div>
    </div>

    <section>
        <div class="container item-cont">
            <div>
                <div class="row">
                    <div class="col">
                        <div>Panino1</div>
                    </div>
                    <div class="col">
                        € 4.50
                    </div>
                </div>
                <div>Salciccia, Peroni, Ketchap</div>
            </div>

            <div>
                <div class="row">
                    <div class="col">
                        <div>Panino2</div>
                    </div>
                    <div class="col">
                        € 10.50
                    </div>
                </div>
                <div>Salciccia, asd, carad</div>
            </div>

            <div>
                <div class="row">
                    <div class="col">
                        <div>Panino3</div>
                    </div>
                    <div class="col">
                        € 14.50
                    </div>
                </div>
                <div>Salciccia, Peroni, Ketchap</div>
            </div>
        </div>
    </section>

    <?=include('templates/footer.php');?>
  </body>
</html>