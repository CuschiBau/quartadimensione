<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <?=include('templates/mainStyle.php')?>
    <link rel="stylesheet" href="static/css/categories.css?a=3">
  </head>
  <body>
    <?php
      include('templates/header.html');
    ?>

    <h1 class="main_title container">Giochi</h1>

    <section class="container">
    <?php
    $cat = simplexml_load_file('templates/categorie.xml');
    foreach($cat->section as $section){
    ?>
      <div class="section_cont">
        <div class="section_title"><?=$section->title?></div>
        <div class="section_scroll">
          <table>
            <tr>
            <?php foreach($section->item as $item){ ?>
              <td>
                <div class="section_item">
                  <a href="<?=$item->link?>"> <img src="<?=$item->image?>" alt="<?=$item->name?>"> </a>
                </div>
              </td>
            <?php } ?>
              <td>
                <div class="section_item">
                  <a class="text-center" href="<?=$section->moreLink?>"> Altri Giochi </a>          
                </div>      
              </td>
            </tr>
          </table>
        </div>
      </div>
    <?php } ?>
    </section>

    <?php
      include('templates/footer.php')
    ?>
  </body>
</html>
