<?php
  header("Content-Type: text/html; charset=utf-8");
  $error_db = false;
  $error_login = false;
  $success = false;
  $passwd_empty = false;
  $wrong_link = false;
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
          $email_query = "SELECT count(*) FROM users WHERE email='$email' AND active='1'";
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
    # Password Validation
    if (($_POST["password"] == "") || (!isset($_POST["password"]))) {
      $error_password = "Heslo nesmí být prázdné!";
      $error_login = true;
      $passwd_empty = true;
    } else {
      if (strlen($_POST["password"]) > 30) {
        $error_password = "Heslo nesmí obsahovat víc, než 30 znaků!";
        $error_login = true;
      }
    }
    # login credentials correct - log the user in
    if ($error_login == false && $error_db == false && (($_POST["password"] != "") || isset($_POST["password"]))) {
      # get user's nickname from db
      try {
        $email = $_POST['userEmail'];
        if(isset($_GET['id'])) $hash = $_GET['id'];
      }
      catch (PDOException $exception)
      {
        $error_db = true;
      }
      # log the user in
      if (isset($hash)) {
        if (password_verify($email, $hash)) {
          session_start();
          $_SESSION['login_username'] = $nickname; // session initialization with value of PHP variables
          $_SESSION['login_email'] = $email;
          try {
            $password = $_POST["password"];
            $p_hash = password_hash($password, PASSWORD_DEFAULT);
            $upate_passwd = "UPDATE user_passwords SET password ='" . $p_hash . "' WHERE email='$email'";
            $limitations_query = "SELECT * FROM user_limitations WHERE email='$email'";
            $limitations = $dbh->query($limitations_query)->fetchAll();
            $_SESSION['limitation1'] = $limitations[0]['limitation_1'];
            $_SESSION['limitation2'] = $limitations[0]['limitation_2'];
            $_SESSION['limitation3'] = $limitations[0]['limitation_3'];
            $_SESSION['limitation4'] = $limitations[0]['limitation_4'];
            $_SESSION['limitation5'] = $limitations[0]['limitation_5'];
            $_SESSION['limitation6'] = $limitations[0]['limitation_6'];
          }
          catch (PDOException $exception)
          {
            $error_db = true;
          }
          $success = true;
        } else $wrong_link = true;
      } else $wrong_link = true;
    }
  }
?>

<!DOCTYPE html>
<html lang="cs">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset hesla</title>

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
            <li><a href="recepty.php?page=1">Recepty</a></li>
            <li><a href="registrace.php">Registrace</a></li>
            <li><a href="prihlaseni.php">Přihlášení</a></li>
            <li class="active"><a href="prihlaseni.php">Reset hesla</a></li>
          </ul>
        </div>  <!-- .navbar-collapse -->
      </div>  <!-- .container-fluid -->
    </nav>

    <div class="container-fluid">
      <div id="content">
        <div id="login">
          <h1>Reset hesla</h1>
          <?php if($success == true) {echo '<div class="alert alert-success" id="login-success"><strong>Přihlášení</strong> proběhlo úspěšně!</div>'; header( "refresh:2;url=http://localhost/jdemevarit/recepty.php?page=1" );}?>
          <?php if($error_db == true || $wrong_link = true) {echo '<div class="alert alert-danger"><strong>Nastala chyba</strong>... použili jste správný link?</div>';}?>
          <div id="login-container">
            <div class="col-xs-12 col-sm-4">
              <form id="login-form" method="POST">
               <div class="<?php if(!isset($error_email) && ((!isset($error_general)) || ($passwd_empty == true))) {echo "form-group";} else {echo "form-group has-error";} ?>" id="form-email">
                 <label for="userEmail">Email</label><span class="star"> *</span>
                 <input class="form-control" id="email" name="userEmail" type="text" placeholder="např. jan.novak@email.cz" value="<?php if(isset($_POST['userEmail'])) echo $_POST['userEmail']; ?>">
                 <div class="error"><?php if(isset($error_email)) echo $error_email; ?></div>
                 <div class="error"><?php if(isset($error_general) && (!isset($error_email)) && (!isset($error_password))) echo $error_general; ?></div>
              </div>
              <div class="<?php if(!isset($error_password) && (!isset($error_general))) {echo "form-group";} else {echo "form-group has-error";} ?>" id="form-email">
                <label for="password">Nové heslo</label><span class="star"> *</span>
                <input class="form-control" id="password" name="password" type="password" placeholder="heslo" value="<?php if(isset($_POST['password'])) echo $_POST['password']; ?>">
                <div class="error"><?php if(isset($error_password)) echo $error_password; ?></div>
                <div class="error"><?php if(isset($error_general) && (!isset($error_email)) && (!isset($error_password))) echo $error_general; ?></div>
              </div>
              <div>
                <button type="submit" class="btn btn-primary"">Změnit</button>

              </div>
              </form>
              <p></p>
            </div> <!-- .col-sm-4 -->
          </div> <!-- #login-container -->
        </div> <!-- #login -->
      </div> <!-- #content -->
    </div> <!-- .container-fluid -->
  </body>
</html>