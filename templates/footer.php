<div class="footer container-fluid">
  <div class="container">
    <div class="row">
      <?php
      if (!isset($_SESSION)) { session_start(); }
        ?>
        <div class="col-12 col-sm-3 social-icons">
          <span>
            <a target="_blank" href="https://www.facebook.com/quarta.dimensione.50/"><img src="static/images/fb.png" alt="Facebook link"></a>
          </span>
          <span>
            <a href="mailto:info@quarta-dimensione.net"><img src="static/images/mail.png" alt="Manda email"></a>
          </span>
          <span>
            <a href="tel:0432477575"><img src="static/images/phone.png" alt="Chiama"></a>
          </span>
        </div>
        <div class="col-12 col-sm-6 text-center footer_menu">
          <span class="align-middle"><a href="index"><span>HOME |</span></a></span>
          <span class="align-middle"><a href="fantacalcio"><span>FANTACALCIO |</span></a></span>
          <span class="align-middle"><a href="bbleague"><span>BLOOD BOWL |</span></a></span>
          <span class="align-middle"><a href="macro"><span>ALTRI GIOCHI |</span></a></span>
          <span class="align-middle"><a href="barlist"><span>FOOD &amp; DRINKS</span></a></span>
        </div>
        <div class="col-12 col-sm-3 admin_links">
        <?php
        if (isset($_SESSION["autorizzato"])) {
          ?>
            <div class="login_icon gap">
              <a href="uploader">
                <img src="static/images/upload.png" alt="Upload Files">
                <span>UPLOAD FILES</span>                
              </a>
            </div>   
            <div class="login_icon">
              <a href="logout">
                <img src="static/images/user.png" alt="Login">
                <span>LOGOUT</span>                
              </a>
            </div>            
          <?php
        }else{
          ?>
            <div class="login_icon">
              <a href="access">
                <img src="static/images/user.png" alt="Login">
                <span>ADMIN LOGIN</span>                
              </a>
            </div>
          <?php  
        }
        ?>
      </div>
    </div>
  </div>
</div>

<div id="js_container">
  <script type="text/javascript" src="static/js/jquery-3.2.1.js"></script>
  <script type="text/javascript" src="static/js/main.js?p=6"></script>
</div>

<?php
  return '';
?>
