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

<div id="js_container">
  <script type="text/javascript" src="static/js/jquery-3.2.1.js"></script>
  <script type="text/javascript" src="static/js/main.js?p=2"></script>
</div>

<?php
  return '';
?>
