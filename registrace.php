<?php
  $error_db = false;

  if(count($_POST)>0) {
    $error_registration = false;
      
    /* Email Validation */
    if (!filter_var($_POST["userEmail"], FILTER_VALIDATE_EMAIL)) {
      $error_email = "Neplatný email!";
      $error_registration = true;
    } else if (strlen($_POST["userEmail"]) > 30) {
      $error_email = "Email nesmí obsahovat víc, než 30 znaků!";
      $error_registration = true;
    }

    /* Username Empty Validation */
    if ($_POST["userName"] == "") {
      $error_name = "Uživateslké jméno nesmí být prázdné!";
      $error_registration = true;
    }

    /* Username Length and Character Validation */
    if (!preg_match('/^[a-zA-Z\d]{1,20}$/', $_POST["userName"]) && ($_POST["userName"] != "")) {
      $error_name = "Neplatné uživatelské jméno max. 20 znaků (pouze písmena a čísla)!";
      $error_registration = true;
    }

    /* 1st Password Validation */
    if (($_POST["password1"] == "") && ($_POST["password1"] == $_POST["password2"])) {
      $error_password1 = "Heslo nesmí být prázdné!";
      $error_registration = true;
    } else if ((($_POST["password1"] != "") || (!isset($_POST["password1"]))) && ($_POST["password1"] == $_POST["password2"]) && (strlen($_POST["password1"])) > 30) {
      $error_password1 = "Heslo nesmí obsahovat víc, než 30 znaků!";
      $error_registration = true;
    } else if ((($_POST["password1"] != "") || (!isset($_POST["password1"]))) && ($_POST["password1"] == $_POST["password2"]) && (strlen($_POST["password1"])) < 5) {
      $error_password1 = "Heslo musí mít alespoň 5 znaků!";
      $error_registration = true;
    }

    /* 2nd Password Validation */
    if ((($_POST["password2"] == "") || (!isset($_POST["password2"]))) && ($_POST["password1"] == $_POST["password2"]))  {
      $error_password2 = "Heslo nesmí být prázdné!";
      $error_registration = true;
    } else if ((($_POST["password2"] != "") || (!isset($_POST["password2"]))) && ($_POST["password1"] == $_POST["password2"]) && (strlen($_POST["password2"])) > 30) {
      $error_password2 = "Heslo nesmí obsahovat víc, než 30 znaků!";
      $error_registration = true;
    } else if ((($_POST["password2"] != "") || (!isset($_POST["password2"]))) && ($_POST["password1"] == $_POST["password2"]) && (strlen($_POST["password1"])) < 5) {
      $error_password2 = "Heslo musí mít alespoň 5 znaků!";
      $error_registration = true;
    }

    /* Password Matching Validation */
    if ((($_POST["password1"] != "") || ($_POST["password2"] != "")) && ($_POST["password1"] != $_POST["password2"])) {
      $error_password_match = "Hesla se musí shodovat!";
      $error_registration = true;
    }

    /* Phone Number Validation */
    if (!preg_match('/^[0-9]{9,16}$/', $_POST["phone"]) && ($_POST["phone"] != "")) {
      $error_phone = "Telefonní číslo se musí skládat pouze z 9-16 číslic!";
      $error_registration = true;
    }

    # Success - proceed with propagating values into DB
    # set-up DB connection
    if ($error_registration == false) {
      try {
        $dbh = new PDO('mysql:host=127.0.0.1;dbname=jdemevarit','jdeme.varit','Jdemevarit123');
      }
      catch (PDOException $exception)
      {
        $error_db = true;
      }

    }

        #if($name != "") {echo'alert("AAAAAa")';}

        ## select, jestli uzivatel uz neexistuje
        # a kdyz jo, tak vyhodit warning
        # kdyz ne, tak potvrdit uspesnou registraci
      }
    ?>
<!DOCTYPE html>
<html lang="cs">

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
          <?php if(isset($error_registration) && ($error_registration == false)) {echo '<div class="alert alert-success"><strong>Registrace</strong>proběhla úspěšně!</div>'; header( "refresh:3;url=http://localhost/jdemevarit/recepty.html" );}?>
          <?php if($error_db == true) {echo '<div class="alert alert-danger"><strong>Nastala chyba</strong> - opakujte prosím akci později...</div>';}?>
          <form method="POST">
            <div id="registration-container">
              <div class="col-xs-12 col-sm-4">
              <form id="registration" method="POST">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title">Registrační údaje</h3>
                  </div>                
                    <div id="registration-details">
                      <div class="<?php if(!isset($error_email)) {echo "form-group";} else {echo "form-group has-error";} ?>" id="form-email">
                        <label for="email">Email</label><span class="star"> *</span>
                        <input class="form-control" id="email" name="userEmail" type="text" placeholder="např. jan.novak@email.cz" value="<?php if(isset($_POST['userEmail'])) echo $_POST['userEmail']; ?>">
                        <div class="error"><?php if(isset($error_email)) echo $error_email; ?></div>
                      </div>

                      <div class="<?php if(!isset($error_name)) {echo "form-group";} else {echo "form-group has-error";} ?>" id="form-name">
                        <label for="name">Přezdívka</label><span class="star"> *</span>
                        <input class="form-control" id="name" name="userName" type="text" placeholder="např. kuchar1" value="<?php if(isset($_POST['userName'])) echo $_POST['userName']; ?>">
                        <div class="error"><?php if(isset($error_name)) echo $error_name; ?></div>
                      </div>
                      <div class="<?php if((!isset($error_password1)) && (!isset($error_password_match))) {echo "form-group";} else {echo "form-group has-error";} ?>" id="form-password1">
                        <label for="password1">Heslo</label><span class="star"> *</span>
                        <input class="form-control" id="password1" name="password1" type="password" placeholder="heslo" value="<?php if(isset($_POST['password1'])) echo $_POST['password1']; ?>">
                        <div class="error"><?php if(isset($error_password1)) echo $error_password1; ?></div>
                        <div class="error"><?php if(isset($error_password_match)) echo $error_password_match; ?></div>
                      </div>
                      <div class="<?php if((!isset($error_password2)) && (!isset($error_password_match))) {echo "form-group";} else {echo "form-group has-error";} ?>" id="form-password2">
                        <label for="password2">Heslo (pro potvrzení)</label><span class="star"> *</span>
                        <input class="form-control" id="password2" name="password2" type="password" placeholder="heslo" value="<?php if(isset($_POST['password2'])) echo $_POST['password2']; ?>">
                        <div class="error"><?php if(isset($error_password2)) echo $error_password2; ?></div>
                         <div class="error"><?php if(isset($error_password_match)) echo $error_password_match; ?></div>
                      </div>
                      <div class="<?php if(!isset($error_phone)) {echo "form-group";} else {echo "form-group has-error";} ?>" id="form-phone">
                        <label for="phone">Telefon</label>
                        <input class="form-control" id="phone" name="phone" type="text" placeholder="např. 123456789" value="<?php if(isset($_POST['phone'])) echo $_POST['phone']; ?>">
                        <div class="error"><?php if(isset($error_phone)) echo $error_phone; ?></div>
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
                      <label><input type="checkbox" name="limitation1" <?php if(isset($_POST['limitation1'])) echo 'checked="checked"'; ?>">Onemocnění žlučníku</label>
                    </div>
                    <div class="checkbox">
                      <label><input type="checkbox" name="limitation2" <?php if(isset($_POST['limitation2'])) echo 'checked="checked"'; ?>">Onemocnění jater</label>
                    </div>
                    <div class="checkbox">
                      <label><input type="checkbox" name="limitation3" <?php if(isset($_POST['limitation3'])) echo 'checked="checked"'; ?>">Alergie na pyl</label>
                    </div>
                    <div class="checkbox">
                      <label><input type="checkbox" name="limitation4" <?php if(isset($_POST['limitation4'])) echo 'checked="checked"'; ?>">Alergie na ořechy</label>
                    </div>
                    <div class="checkbox">
                      <label><input type="checkbox" name="limitation5" <?php if(isset($_POST['limitation5'])) echo 'checked="checked"'; ?>">Alergie na laktózu</label>
                    </div>
                    <div class="checkbox">
                      <label><input type="checkbox" name="limitation6" <?php if(isset($_POST['limitation6'])) echo 'checked="checked"'; ?>">Celiakie</label>
                    </div>
                  </div>
                  <p></p>
                </div> <!-- .panel-default -->
                <div>

                  <button type="submit" class="btn btn-primary" onclick="sendData();">Registrovat</button>
                </div>

                </form>
              </div> <!-- .col-sm-4 -->
            </div> <!-- #registration-container -->
          </form>
        </div> <!-- #registration -->
      </div> <!-- .content -->
    </div> <!-- .container-fluid -->
  </body>
</html>