<?php

  function returnURL(){
    $actual_link ="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $decUrl = parse_url($actual_link);
    $cleanUrl = $decUrl['scheme'].'://'.$decUrl['host'].$decUrl['path'];
    return $cleanUrl;
  }

  function sortFiles($files){
    usort($files, function($a, $b) {
      return filectime($a) < filectime($b);
    });

    return $files;
  }

  function sortDir($files){
    usort($files, function($a, $b) {
      return $a > $b;
    });

    return $files;
  }

?>
