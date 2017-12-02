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
    ?>

    <ul>
      <li> <a href="categorie?macro=Macro%201">Macro 1</a> </li>
      <li> <a href="categorie?macro=Macro%202">Macro 2</a> </li>
    </ul>

    <?php
      include('templates/footer.php')
    ?>
  </body>
</html>
