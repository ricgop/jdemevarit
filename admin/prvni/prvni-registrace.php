<?php
  header("Content-Type: text/html; charset=utf-8");

  $error_db = false;
  $success = false;

  try {
    #set-up db connection
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=jdemevarit','jdeme.varit','Jdemevarit123');
  }
  catch (PDOException $exception)
  {
    $error_db = true;
  }

  if(count($_POST)>0) {
    $error_registration = false;
      
    /* Email Validation */
    if (!filter_var($_POST["userEmail"], FILTER_VALIDATE_EMAIL)) {
      $error_email = "Neplatný email!";
      $error_registration = true;
      } else 
      {
        if (strlen($_POST["userEmail"]) > 30) {
          $error_email = "Email nesmí obsahovat víc, než 30 znaků!";
          $error_registration = true;
        } else {
          try {
            # check if email is already used
            $email = $_POST["userEmail"];
            $email_query = "SELECT count(*) FROM admins WHERE email='$email'";
            $email_result = $dbh->query($email_query)->fetchColumn();
            if ($email_result > 0) {
              $error_email_exists = "Tento email již někdo používá - vyberte si prosím jiný.";
              $error_registration = true;
            };
          }
          catch (PDOException $exception)
          {
            $error_db = true;
          }
        }
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
    
    # check if all details are correct and if we didn't miss any of the DB checks
    if ($error_registration == false && $error_db == false) {
      $password = $_POST["password1"];
      $hash = password_hash($password, PASSWORD_DEFAULT);

      try {
        # if everything is OK, register admin
        if ($email_result == 0 && $error_db == false) {
          $insert_users_table = "INSERT INTO admins (email,active) VALUES ('$email','1')";
          $dbh->exec($insert_users_table);

          $insert_passwords_table = "INSERT INTO admin_passwords (email,password) VALUES ((SELECT email FROM users WHERE email='$email'),'$hash')";
          $dbh->exec($insert_passwords_table);

          $success = true;
          session_start();
          # set username
          $_SESSION['admin_email'] = $email;

        } else {
          $error_db = true;
        }
      }
      catch (PDOException $exception)
      {
        $error_db = true;
      }
    }

  }
?>

<!DOCTYPE html>
<html lang="cs">

  <head>
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

    <div class="container-fluid" id="registration-text">
      <div id="content">
        <div id="registration">
          <h1>První registrace</h1>
          <h3>Po první registraci tento soubor smažte z důvodu bezpečnosti!</h3>
          <?php if($success == true) {
            echo '<div class="alert alert-success" id="login"><strong>Registrace</strong> proběhla úspěšně!</div>';
            header( "refresh:3;url=http://localhost/jdemevarit/admin/pridat-administratora.php" );}?>
          <?php if($error_db == true) {echo '<div class="alert alert-danger"><strong>Nastala chyba</strong> - opakujte prosím akci později...</div>';}?>

            <div id="registration-container">
              <div class="col-xs-12 col-sm-4">
              <form id="registration" method="POST">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title">Registrační údaje</h3>
                  </div>                
                    <div id="registration-details">
                      <div class="<?php if(!isset($error_email) && (!isset($error_email_exists))) {echo "form-group";} else {echo "form-group has-error";} ?>" id="form-email">
                        <label for="email">Email</label><span class="star"> *</span>
                        <input class="form-control" id="email" name="userEmail" type="text" placeholder="např. jan.novak@email.cz" value="<?php if(isset($_POST['userEmail'])) echo $_POST['userEmail']; ?>">
                        <div class="error"><?php if(isset($error_email)) echo $error_email; ?></div>
                        <div class="error"><?php if(isset($error_email_exists)) echo $error_email_exists; ?></div>
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
                      <span class="info">Pole označená </span><span class="star"> *</span><span class="info"> jsou povinná</span>
                      <p></p>
                    </div> <!-- #registration details -->

                  <button type="submit" class="btn btn-primary">Registrovat</button>
                </div>

                </form>
              </div> <!-- .col-sm-4 -->
            </div> <!-- #registration-container -->

        </div> <!-- #registration -->
      </div> <!-- .content -->
    </div> <!-- .container-fluid -->
  </body>
</html>