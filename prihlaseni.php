<?php
  header("Content-Type: text/html; charset=utf-8");

  $error_db = false;
  $error_login = false;

  try {
    #set-up db connection
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=jdemevarit','jdeme.varit','Jdemevarit123');
  }
  catch (PDOException $exception)
  {
    $error_db = true;
  }

  if(count($_POST)>0) {

    /* Email Validation */
    if (!filter_var($_POST["userEmail"], FILTER_VALIDATE_EMAIL)) {
      $error_email = "Neplatný email!";
      $error_login = true;
      } else 
      {
        if (strlen($_POST["userEmail"]) > 30) {
          $error_general = "Špatně zadaný email nebo heslo!";
          $error_login = true;
        } else {
          try {
            # check if email is already used
            $email = $_POST["userEmail"];
            $email_query = "SELECT count(*) FROM users where email='$email'";
            $email_result = $dbh->query($email_query)->fetchColumn();

            # if user doesn't exists
            if ($email_result == 0) {
              $error_general = "Špatně zadaný email nebo heslo!";
              $error_login = true;
            }
          }
          catch (PDOException $exception)
          {
            $error_db = true;
          }
        }
      }

    /* Password Validation */
    if (($_POST["password"] == "") || (!isset($_POST["password"]))) {
      $error_password = "Heslo nesmí být prázdné!";
      $error_login = true;
    } else {
      if (strlen($_POST["password"]) > 30) {
        $error_password = "Heslo nesmí obsahovat víc, než 30 znaků!";
        $error_login = true;
      }
    }

    # login credentials correct - log the user in
    if ($error_login == false && $error_db == false) {
      echo "loging in...";
    }
  }

?>

<!DOCTYPE html>
<html lang="cs">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Přihlášení</title>

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
          <a class="navbar-brand" href="prihlaseni.php"><img alt="Brand" src="images/main.png"/></a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#top-navbar" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="top-navbar">
          <ul class="nav navbar-nav">
            <li><a href="recepty.php">Recepty</a></li>
            <li><a href="registrace.php">Registrace</a></li>
            <li class="active"><a href="prihlaseni.php">Přihlášení</a></li>
          </ul>
        </div>  <!-- .navbar-collapse -->
      </div>  <!-- .container-fluid -->
    </nav>

    <div class="container-fluid">
      <div id="content">
        <div id="login">
          <h1>Přihlášení</h1>
          <form method="POST">
            <div id="login-container">
              <div class="col-xs-12 col-sm-4">
                <div class="<?php if(!isset($error_email) && (!isset($error_general))) {echo "form-group";} else {echo "form-group has-error";} ?>" id="form-email">
                  <label for="userEmail">Email</label><span class="star"> *</span>
                  <input class="form-control" id="email" name="userEmail" type="text" placeholder="např. jan.novak@email.cz" value="<?php if(isset($_POST['userEmail'])) echo $_POST['userEmail']; ?>">
                  <div class="error"><?php if(isset($error_email)) echo $error_email; ?></div>
                  <div class="error"><?php if(isset($error_general) && (!isset($error_email)) && (!isset($error_password))) echo $error_general; ?></div>
                </div>
                <div class="<?php if(!isset($error_password) && (!isset($error_general))) {echo "form-group";} else {echo "form-group has-error";} ?>" id="form-email">
                  <label for="password">Heslo</label><span class="star"> *</span>
                  <input class="form-control" id="password" name="password" type="password" placeholder="heslo" value="<?php if(isset($_POST['password'])) echo $_POST['password']; ?>">
                  <div class="error"><?php if(isset($error_password)) echo $error_password; ?></div>
                  <div class="error"><?php if(isset($error_general) && (!isset($error_email)) && (!isset($error_password))) echo $error_general; ?></div>
                </div>
                <div>
                  <button type="submit" class="btn btn-primary"">Přihlásit</button>
                </div>
              </div> <!-- .col-sm-4 -->
            </div> <!-- #login-container -->
          </form>
        </div> <!-- /.recipes -->
      </div> <!-- /.content -->
    </div> <!-- /.container-fluid -->

  </body>
</html>
