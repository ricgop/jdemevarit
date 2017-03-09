<?php
  header("Content-Type: text/html; charset=utf-8");
  $error_db = false;
  $error_login = false;
  $success = false;
  $passwd_empty = false;
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
          # check if email exists
          $email = $_POST["userEmail"];
          $email_query = "SELECT count(*) FROM users WHERE email='$email' AND active='1'";
          $email_result = $dbh->query($email_query)->fetchColumn();
          # if user doesn't exists
          if ($email_result == 0) {
            $error_general = "Email nenalezen!";
            $error_login = true;
          }
        }
        catch (PDOException $exception)
        {
          $error_db = true;
        }
      }
    }

    # login credentials correct - generate email
    if ($error_db == false && $error_login == false) {
      # get user's nickname from db
      try {
        $hash = password_hash($email, PASSWORD_DEFAULT);
        $pwurl = 'http://localhost/jdemevarit/reset-hesla.php?id=' . $hash;
        
        # create & send email
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $mail_url = 'http://localhost/jdemevarit/reset-hesla.php?id=' . $pwurl;
        $mailbody = '<html>
						<head>
						    <title>Reset hesla</title>
						</head>
						<body>
							<h2>Reset hesla</h2>
						    <p>Tento mail byl vytvořen na základě žádosti o změnu hesla na stránkách www.jdemevarit.cz<br><br>Pokud Vám byl 
						zaslán omylem, prosím ignorujte ho.<br>Heslo resetujete kliknutím na tento link: <a href="' . $mail_url . '">' . $mail_url . '</a><br><br>Váš tým jdemevarit</p>
						</body>
					</html>';
        mail($email, 'Reset hesla - www.jdemevarit.cz', $mailbody, $headers);
        $success = true;
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
    <title>Zapomenuté heslo</title>

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
            <li class="active"><a href="prihlaseni.php">Zapomenuté heslo</a></li>
          </ul>
        </div>  <!-- .navbar-collapse -->
      </div>  <!-- .container-fluid -->
    </nav>

    <div class="container-fluid">
      <div id="content">
        <div id="login">
          <h1>Zapomenuté heslo</h1>
          <p><u>Upozornění</u>: pro dokončení akce potvrďte prosím email.</p>
          <?php if($success == true) {echo '<div class="alert alert-success" id="login-success"><strong>Reset hesla</strong> proběhl úspěšně!</div>'; header( "refresh:2;url=http://localhost/jdemevarit/zapomenute-heslo.php" );}?>
          <?php if($error_db == true) {echo '<div class="alert alert-danger"><strong>Nastala chyba</strong> - opakujte prosím akci později...</div>';}?>
          <div id="login-container">
            <div class="col-xs-12 col-sm-4">
              <form id="reset-form" method="POST">
               <div class="<?php if((!isset($error_general)) && $error_login == false) {echo "form-group";} else {echo "form-group has-error";} ?>" id="form-email">
                 <label for="userEmail">Email</label><span class="star"> *</span>
                 <input class="form-control" id="email" name="userEmail" type="text" placeholder="např. jan.novak@email.cz" value="<?php if(isset($_POST['userEmail'])) echo $_POST['userEmail']; ?>">
                 <div class="error"><?php if(isset($error_email)) echo $error_email; ?></div>
                 <div class="error"><?php if(isset($error_general) && (!isset($error_email)) && (!isset($error_password))) echo $error_general; ?></div>
              </div>
              <div>
                <button type="submit" class="btn btn-primary"">Odeslat</button>
              </div>
              </form>
            </div> <!-- .col-sm-4 -->
          </div> <!-- #login-container -->
        </div> <!-- #login -->
      </div> <!-- #content -->
    </div> <!-- .container-fluid -->
  </body>
</html>