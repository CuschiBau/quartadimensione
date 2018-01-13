<?php
  function writeFeed($uploadfile,$changeMacro,$cat) {
    $addFanta = '';

    if ($cat == 'fanta') { $addFanta = 'fanta/'; }
    
    chdir(__DIR__.'/..');
    chdir('categories');
    
    $myfile = fopen("homefeed.txt","r");
    $home = [];

    while(! feof($myfile)) { $home[] = fgets($myfile); }

    fclose($myfile);

    $myfile = fopen("homefeed.txt","w");
    $rHome = array_reverse($home);
    if ($changeMacro != null) { $uploadfile = urldecode($changeMacro).'/'.$uploadfile; }
    $uploadfile = $addFanta . $uploadfile;
    array_push($rHome,$uploadfile.'');
    $fHome = array_reverse($rHome);
    $txt = '';
    array_pop($fHome);
    for ($i=0; $i < 5 ; $i++) {
      if (count($fHome) > $i && $fHome[$i] != '') {
        $txt = $txt.trim($fHome[$i]);
          $txt = $txt."\n";
      }
    }
    fwrite($myfile, $txt);
    fclose($myfile);
  }

  function createNewCat($newFolder,$cat){
    mkdir($newFolder, 0700);
    chdir($newFolder);
    if ($cat) {
      mkdir('gallery', 0700);
      chdir('..');
      if ($_FILES['folderfile']) {
        $allowed =  array('png' ,'jpg','jpeg');
        $filename = $_FILES['folderfile']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(in_array($ext,$allowed) ) {
          $uploadfileimg = $newFolder . '/' . $newFolder .'-fimg.'.$ext;
          if (move_uploaded_file($_FILES['folderfile']['tmp_name'], $uploadfileimg)) {

          } else {
             echo "Upload failed";
          }
        }
      }
      $descTitle = $_POST['descTitle'] ?? '';
      $description = $_POST['description'] ?? '';
      chdir($newFolder);
      if ($descTitle != '') {
        $desT = fopen($newFolder."-dT.txt","w");
        fwrite($desT, $descTitle);
        fclose($desT);
      }
      if ($description != '') {
        $desC = fopen($newFolder."-d.txt","w");
        fwrite($desC, $description);
        fclose($desC);
      }
      chdir('..');
    }
  }

  function updateFileName($changeMacro,$location,$value){
    chdir('../..');
    $src = 'temp/keep.*';
    $temp = glob ($src);
    if (count($temp) > 0) {
      $tExt = explode('.',$temp[0])[1];
      $folderD = $_SESSION['tmp_cat'] ?? '';
      $filePath = $location == 'fanta' ? $location.'/'.$folderD.'/' : $location.'/'.urldecode($changeMacro).'/'.$folderD.'/';
      $filePath = $filePath.$_POST['newName'].'.'.$tExt;
      if(file_exists($filePath)){
        saveInTemp($value,$tExt);
      }else{
        if ($folderD == '') {
          $_SESSION['empty_tmp_cat'] = true;
        }else{
          rename($temp[0],$filePath);
        }
        chdir('categories');
        $uploadfile = urldecode($changeMacro).'/'.$folderD.'/'.$_POST['newName'].'.'.$tExt;
        if (isset($_SESSION['write_feed']) && $_SESSION['write_feed']) { writeFeed($uploadfile,null,null); }
        $_SESSION['upload_success'] = true;
      }
    }
  }

  function saveInTemp($value,$ext){
    $_SESSION['empty_tmp_cat'] = false;
    $_SESSION['already_exist'] = true;
    chdir('../..');
    $uploadfile = 'temp/keep.' . $ext;
    move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);
    $setHomepage = $_POST['sethomepage'] ?? '';
    if ($setHomepage != '') { $_SESSION['write_feed'] = true; }

    $_SESSION['tmp_cat'] = $value;
  }

?>
