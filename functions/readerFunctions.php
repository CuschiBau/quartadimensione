<?php
  function changeTitle($macro,$folder,$newTitle){
    $file = $folder.'-dT.txt';
    $desT = fopen($file,"w");
    fwrite($desT, $newTitle);
    fclose($desT);
    
  }

  function changeDesc($macro,$folder,$desc){
    $file = $folder.'-d.txt';
    $desT = fopen($file,"w");
    fwrite($desT, $desc);
    fclose($desT);
  }

  function changeImage($macro,$folder){
    if ($_FILES['newImage']) {
      $allowed =  array('png' ,'jpg','jpeg');
      $filename = $_FILES['newImage']['name'];
      $ext = pathinfo($filename, PATHINFO_EXTENSION);
      if(in_array($ext,$allowed) ) {
        // delete old file to avoid duplicates
        // TODO keep old file in tmp so if upload file can be uploaded again
        $src = $folder.'-fimg.*';
        $result = glob ($src);
        if (count($result) > 0) { unlink($result[0]); }

        $uploadfileimg = $folder .'-fimg.'.$ext;
        if (move_uploaded_file($_FILES['newImage']['tmp_name'], $uploadfileimg)) {

        } else {
           echo "Upload failed";
        }
      }
    }
  }

  function printGallery($macro,$folder){
    if (is_dir('gallery')) {
      chdir('gallery');
      echo "<div class='gallery_flex'>";
      $images = scandir(getcwd().'/');
      $sortedImg = sortFiles($images);
      foreach($sortedImg as $img) {
        if (!is_dir($img)) {
          $src = $macro.'/'.$folder.'/gallery/'.$img;
          ?>
            <div class="gallery_item_cont">
              <div class="gallery_item"> 
                <a target="_blank" href="categories/<?=$src?>"> <img src="categories/<?=$src?>"/> </a> 
              </div> 
            </div>
          <?php
        }
      }
      echo "</div>";
      chdir('..');
    }
  }

  function uploadInGallery($macro,$folder){
    if (!is_dir('gallery')) {
      mkdir('gallery',0700);
    }
    chdir('gallery');
    $ufilename = $_FILES['userfile']['name'];
    $ufilebasename = basename($_FILES['userfile']['name']);
    $ext = pathinfo($ufilename, PATHINFO_EXTENSION);
    $fi = new FilesystemIterator(getcwd(), FilesystemIterator::SKIP_DOTS);
    $uploadfile = 'img'.iterator_count($fi).'.'.$ext;

    if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
      //echo "File is valid, and was successfully uploaded.</br>";
    }
    chdir('..');
  }

?>
