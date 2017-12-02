<?php

    function writeFeed($uploadfile) {
      $myfile = fopen("homefeed.txt","r");
      $home = [];

      while(! feof($myfile)) { $home[] = fgets($myfile); }

      fclose($myfile);

      $myfile = fopen("homefeed.txt","w");
      $rHome = array_reverse($home);


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

    session_start();
    //$_SESSION['empty_tmp_cat'] = false;
    $_SESSION['upload_success'] = false;
    chdir('categories');
    $value = $_POST['dir'] ?? '';
    $newName = $_POST['newName'] ?? '';
    $dirEfile = false;

    if($value == 'other'){
      $newFolder = $_POST['newFolder'] ?? '';
      if(!is_dir($newFolder)){
        mkdir($newFolder, 0700);
        if ($_FILES['folderfile']) {
          $allowed =  array('png' ,'jpg','jpeg');
          $filename = $_FILES['folderfile']['name'];
          $ext = pathinfo($filename, PATHINFO_EXTENSION);
          if(in_array($ext,$allowed) ) {
            $uploadfileimg = $newFolder . '/' . $newFolder .'-fimg.'.$ext;
            if (move_uploaded_file($_FILES['folderfile']['tmp_name'], $uploadfileimg)) {
              echo "File is valid, and was successfully uploaded.\n";
              echo  $uploadfileimg."";
            } else {
               echo "Upload failed";
            }
          }
        }
        $descTitle = $_POST['descTitle'] ?? '';
        $description = $_POST['description'] ?? '';
        chdir($newFolder);
        if ($descTitle != '') {
          echo "desT: " . $newFolder."-dT.txt\n";
          $desT = fopen($newFolder."-dT.txt","w");
          fwrite($desT, $descTitle);
          fclose($desT);
        }
        if ($description != '') {
          echo "desC: " . $newFolder."-d.txt\n";
          $desC = fopen($newFolder."-d.txt","w");
          fwrite($desC, $description);
          fclose($desC);
        }
        chdir('..');
      }

      //$dirEfile = $newFolder == pathinfo($_FILES['userfile']['name'])['filename'];
      $value = $newFolder;
    }

    $ufilename = $_FILES['userfile']['name'];
    $ufilebasename = basename($_FILES['userfile']['name']);
    $ext = pathinfo($ufilename, PATHINFO_EXTENSION);
    //if ($_POST['newName']) { $ufilebasename = $_POST['newName'] . '.' . $ext; }
    $uploadfile = $value . '/' . $ufilebasename;

    echo "<p>";
    // if ($dirEfile) {
    //   echo "file e dir uguali no bene";
    // }else
    if ($newName){
      chdir('..');
      //echo "newName";
      $src = 'temp/keep.*';
      $temp = glob ($src);
      if (count($temp) > 0) {
        $tExt = explode('.',$temp[0])[1];
        $folderD = $_SESSION['tmp_cat'] ?? '';
        if ($folderD == '') {
          $_SESSION['empty_tmp_cat'] = true;
        }else{
          rename($temp[0],'categories/'.$folderD.'/'.$_POST['newName'].'.'.$tExt);
        }
        chdir('categories');
        $uploadfile = $folderD.'/'.$_POST['newName'].'.'.$tExt;
        if (isset($_SESSION['write_feed']) && $_SESSION['write_feed']) { writeFeed($uploadfile); }
        $_SESSION['upload_success'] = true;
      }
    } else if (file_exists($uploadfile)) {
      $_SESSION['empty_tmp_cat'] = false;
      echo "This file already exist";
      $_SESSION['already_exist'] = true;
      chdir('..');
      $uploadfile = 'temp/keep.' . $ext;
      move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);
      $setHomepage = $_POST['sethomepage'] ?? '';
      if ($setHomepage != '') { $_SESSION['write_feed'] = true; }

      $_SESSION['tmp_cat'] = $value;
    } else if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
      $_SESSION['already_exist'] = false;
      echo "File is valid, and was successfully uploaded.</br>";
      $setHomepage = $_POST['sethomepage'] ?? '';
      if ($setHomepage != '') { writeFeed($uploadfile); }
      $_SESSION['upload_success'] = true;
    } else {
       echo "Upload failed";
    }

    echo "</p>";
    echo '<pre>';
    echo 'Here is some more debugging info:';
    print_r($_FILES);
    print "</pre>";
    echo '<script language=javascript>document.location.href="uploader.php"</script>';

  ?>
