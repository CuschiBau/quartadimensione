<?php
  session_start();
  session_unset();
  session_destroy();
  echo '<script language=javascript>document.location.href="index"</script>';
?>
