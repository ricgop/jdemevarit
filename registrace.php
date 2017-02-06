<!DOCTYPE html>
<html lang="cs">
<?php
  include 'user-registration.php';
  if (isset($u_email)){$message = "blablabla"; }
  if (!isset($u_name)){$message = "bebebebebe"; }
  if (isset($aaa)){$message = $aaa; }
?>
  <head>
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrace</title>

    <link rel="icon" type="image/png" href="images/favicon.png">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <script>

      function sendData () {
        // reset any previous form errors
        $(".form-group").removeClass("has-error");

        // get form variables
        var user_name = document.getElementById("name").value;
        var user_email = document.getElementById("email").value;
        var user_passwd1 = document.getElementById("password1").value;
        var user_passwd2 = document.getElementById("password2").value;
        var user_phone = document.getElementById("phone").value;
        var valid = true;

        // mark empty mandatory fields
        if (user_name == "") {
          $("#form-name").addClass("has-error");
          valid = false;
        }
        if (user_email == "") {
          $("#form-email").addClass("has-error");
          valid = false;
        }
        if (user_passwd1 == "") {
          $("#form-password1").addClass("has-error");
          valid = false;
        }
        if (user_passwd2 == "") {
          $("#form-password2").addClass("has-error");
          valid = false;
        }
        if (user_passwd1 != user_passwd2) {
          $("#form-password1").addClass("has-error");
          $("#form-password2").addClass("has-error");
          valid = false;
        }

        //if (valid == true) {alert("ano... jedeme!");} else alert("Houstone, mame problem!");
        
      }

    /*
      function hideFilter() {
        document.getElementById("filter").style.display = "none";
      }

      function showFilter() {
        document.getElementById("filter").style.display = "unset";
      }

      function showLogin() {
        document.getElementById("recipes").style.display = "none";
        document.getElementById("register").style.display = "none";
        document.getElementById("login").style.display = "unset";
        hideFilter();
      }

        function showRegistration() {
        document.getElementById("recipes").style.display = "none";
        document.getElementById("login").style.display = "none";
        document.getElementById("register").style.display = "unset";
        hideFilter();
      }

      function showRecipes() {
        document.getElementById("register").style.display = "none";
        document.getElementById("login").style.display = "none";
        document.getElementById("recipes").style.display = "unset";
        showFilter();
      }
    */
    </script>

    <link href="css/style.css" rel="stylesheet">

  </head>

  <body>

    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#top-navbar" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="recepty.html"><img alt="Brand" src="images/main.png"></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="top-navbar">
          <ul class="nav navbar-nav">
            <li><a href="recepty.html">Recepty</a></li>
            <li class="active"><a href="registrace.php">Registrace</a></li>
            <li><a href="prihlaseni.php">Přihlášení</a></li>
          </ul>

        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>

    <div class="container-fluid">
      <div id="content">
        <div id="registration">
          <h1>Registrace</h1>
          <form>
            <div id="registration-container">
              <div class="col-xs-12 col-sm-4">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title">Registrační údaje</h3>
                  </div>

                  <form id="registration" method="POST">
                    <div id="registration-details">
                      <div class="form-group" id="form-email">
                        <label for="email">Email</label><span class="star"> *</span>
                        <input class="form-control" id="email" type="text" placeholder="např. jan.novak@email.cz">
                      </div>
                      <div class="form-group" id="form-name">
                        <label for="nickName">Přezdívka</label><span class="star"> *</span>
                        <input class="form-control" id="name" type="text" placeholder="např. kuchar1">
                      </div>
                      <div class="form-group" id="form-password1">
                        <label for="password1">Heslo</label><span class="star"> *</span>
                        <input class="form-control" id="password1" type="password" placeholder="heslo">
                      </div>
                       <div class="form-group" id="form-password2">
                        <label for="password2">Heslo (pro potvrzení)</label><span class="star"> *</span>
                        <input class="form-control" id="password2" type="password" placeholder="heslo">
                      </div>
                      <div class="form-group">
                        <label for="phone">Telefon</label>
                        <input class="form-control" id="phone" type="text" placeholder="např. 123456789">
                      </div>
                      <span class="info">Pole označená </span><span class="star"> *</span><span class="info"> jsou povinná</span>
                      <p></p>
                    </div> <!-- #registration details -->
                  
                </div> <!-- .panel-default -->
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title">Zdravotní omezení</h3>
                  </div>
                  <div id="limitations">
                    <div class="checkbox">
                      <label><input type="checkbox" value="">Onemocnění žlučníku</label>
                    </div>
                    <div class="checkbox">
                      <label><input type="checkbox" value="">Onemocnění jater</label>
                    </div>
                    <div class="checkbox">
                      <label><input type="checkbox" value="">Alergie na pyl</label>
                    </div>
                    <div class="checkbox">
                      <label><input type="checkbox" value="">Alergie na ořechy</label>
                    </div>
                    <div class="checkbox">
                      <label><input type="checkbox" value="">Alergie na laktózu</label>
                    </div>
                    <div class="checkbox">
                      <label><input type="checkbox" value="">Celiakie</label>
                    </div>
                  </div>
                  <p></p>
                </div> <!-- .panel-default -->
                <div class="message"><?php if(isset($message)) echo $message; ?></div>
                  <p></p>
                </form>

                <div id="message"> <!-- to display success or error message upon registration -->
                  
                  <?php include 'user-registration.php';?>
                  <?php if(isset($msg)){ ?><div class="alert alert-success" role="alert"><?php echo $msg ?></div><?php } ?>
                  <?php if(isset($emsg)){ ?><div class="alert alert-danger" role="alert"><?php echo $emsg ?></div><?php } ?>
                </div>
                <div>
                  <button type="button" class="btn btn-primary" onclick="sendData();">Registrovat</button>
                </div>
              </div> <!-- .col-sm-4 -->
            </div> <!-- #registration-container -->
          </form>
        </div> <!-- #registration -->
      </div> <!-- .content -->
    </div> <!-- .container-fluid -->
  </body>
</html>