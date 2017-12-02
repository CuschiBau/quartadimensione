<?php

  function returnURL(){
    $actual_link ="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $decUrl = parse_url($actual_link);
    $cleanUrl = $decUrl['scheme'].'://'.$decUrl['host'].$decUrl['path'];
    return $cleanUrl;
  }

?>
