<div class="footer container-fluid">
  <ul class="row">
    <li class="col"><a href="access">Login</a></li>

    <?php
    if (!isset($_SESSION)) {
    session_start();
    }

      if (isset($_SESSION["autorizzato"])) {
        ?>
          <li class="col"><a href="uploader">Carica Files</a> </li>
          <li class="col"><a href="manage">Gestisci Files</a> </li>
          <li class="col"><a href="logout">Logout</a> </li>
        <?php
      }
    ?>
  </ul>
</div>
<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<?php
  return '';
?>
