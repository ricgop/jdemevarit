<?php
  header("Content-Type: text/html; charset=utf-8");
  session_start();
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
    $error_add = false;
      
    /* Empty recipeName Validation */
    if ($_POST["recipeName"] == "") {
      $error_name = "Název receptu nesmí být prázdný!";
      $error_add = true;
    }
    /* recipeName Length and Character Validation */
    if (!preg_match('/^[a-zA-Z]{1,40}$/', $_POST["recipeName"])) {
      $error_name = "Neplatný název receptu - max. 40 znaků (pouze písmena)!";
      $error_add = true;
    }

    /* Empty recipeContent Validation */
    if ($_POST["recipeContent"] == "") {
      $error_content = "Seznam přísad nesmí být prázdný!";
      $error_add = true;
    }
    /* recipeContent Length and Character Validation */
    if (!preg_match('/^[a-zA-Z]{1,200}$/', $_POST["recipeContent"])) {
      $error_content = "Seznam přísad je příliš dlouhý - max. 200 znaků!";
      $error_add = true;
    }

    /* Empty recipeContent Validation */
    if ($_POST["recipeProcess"] == "") {
      $error_process = "Název receptu nesmí být prázdný!";
      $error_add = true;
    }
    /* recipeContent Length and Character Validation */
    if (!preg_match('/^[a-zA-Z]{1,3000}$/', $_POST["recipeProcess"])) {
      $error_process = "Neplatný popis receptu - max. 3000 znaků!";
      $error_add = true;
    }

  }
?>

<!DOCTYPE html>
<html lang="cs">

  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Přidat recept</title>

    <link rel="icon" type="image/png" href="images/favicon.png">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <script type="text/JavaScript">
      function logOut() {
        $.get("odhlaseni.php");
      }
    </script>

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
            <li class="active"><a href="pridat-recept.php">Přidat recept</a></li>
            <li><a href="me-recepty.php">Mé recepty</a></li>
          </ul>
          <form class="navbar-right">
            <ul class="nav navbar-nav">
              <?php if(isset($_SESSION['login_user'])) {
                echo '<li><a href="recepty.php" onclick="logOut();"><u>Odhlásit</u></a></li>';
              } ?>
            </ul>
          </form>
        </div>  <!-- .navbar-collapse -->
      </div>  <!-- .container-fluid -->
    </nav>

    <div class="container-fluid">
      <div id="content">
        <div id="newRecipe">
          <h1>Přidat recept</h1>
          <?php if($success == true) {echo '<div class="alert alert-success" id="login"><strong>Recept</strong> byl úspěšně přidán!</div>'; header( "refresh:3;url=http://localhost/jdemevarit/me-recepty.php" );}?>
          <?php if($error_db == true) {echo '<div class="alert alert-danger"><strong>Nastala chyba</strong> - opakujte prosím akci později...</div>';}?>

            <div id="recipe-container">
              <div class="col-xs-12 col-sm-12">
              <form id="recipe" method="POST">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title">Recept</h3>
                  </div>                
                  <div id="recipe-details">
                    <div class="<?php if(!isset($error_name)) {echo "form-group";} else {echo "form-group has-error";} ?>" id="form-name">
                      <label for="name">Název receptu</label><span class="star"> *</span>
                      <input class="form-control" id="name" name="recipeName" type="text" placeholder="např. Bábovka" value="<?php if(isset($_POST['recipeName'])) echo $_POST['recipeName']; ?>">
                      <div class="error"><?php if(isset($error_name)) echo $error_name; ?></div>
                    </div>
                    <div class="<?php if(!isset($error_content)) {echo "form-group";} else {echo "form-group has-error";} ?>" id="form-name">
                      <label for="RContent">Seznam přísad</label><span class="star"> *</span>
                      <input class="form-control" id="RContent" name="recipeContent" type="text" placeholder="např. 200ml Oleje, 500g Mouky,..." value="<?php if(isset($_POST['recipeContent'])) echo $_POST['recipeContent']; ?>">
                      <div class="error"><?php if(isset($error_content)) echo $error_content; ?></div>
                    </div>
                    <div class="<?php if(!isset($error_process)) {echo "form-group";} else {echo "form-group has-error";} ?>" id="form-name">
                      <label for="process">Postup</label><span class="star"> *</span>
                      <input class="form-control" id="process" name="recipeProcess" type="text" placeholder="např. 200ml Oleje, 500g Mouky,..." value="<?php if(isset($_POST['recipeProcess'])) echo $_POST['recipeProcess']; ?>">
                      <div class="error"><?php if(isset($error_process)) echo $error_process; ?></div>
                    </div>
                    <span class="info">Pole označená </span><span class="star"> *</span><span class="info"> jsou povinná</span>
                    <p></p>
                  </div> <!-- #registration details -->
                </div> <!-- .panel-default -->
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title">Vhodnost receptu dle omezení</h3>
                  </div>
                  <div id="limitations">
                    <div class="checkbox">
                      <label><input type="checkbox" name="limitation1" <?php if(isset($_POST['limitation1'])) echo 'checked="checked"'; ?>>Onemocnění žlučníku</label>
                    </div>
                    <div class="checkbox">
                      <label><input type="checkbox" name="limitation2" <?php if(isset($_POST['limitation2'])) echo 'checked="checked"'; ?>>Onemocnění jater</label>
                    </div>
                    <div class="checkbox">
                      <label><input type="checkbox" name="limitation3" <?php if(isset($_POST['limitation3'])) echo 'checked="checked"'; ?>>Alergie na pyl</label>
                    </div>
                    <div class="checkbox">
                      <label><input type="checkbox" name="limitation4" <?php if(isset($_POST['limitation4'])) echo 'checked="checked"'; ?>>Alergie na ořechy</label>
                    </div>
                    <div class="checkbox">
                      <label><input type="checkbox" name="limitation5" <?php if(isset($_POST['limitation5'])) echo 'checked="checked"'; ?>>Alergie na laktózu</label>
                    </div>
                    <div class="checkbox">
                      <label><input type="checkbox" name="limitation6" <?php if(isset($_POST['limitation6'])) echo 'checked="checked"'; ?>>Celiakie</label>
                    </div>
                  </div>
                  <p></p>
                </div> <!-- .panel-default -->
                <div>

                  <button type="submit" class="btn btn-primary">Vytvořit</button>
                </div>

                </form>
              </div> <!-- .col-sm-4 -->
            </div> <!-- #recipe-container -->

        </div> <!-- #recipe -->
      </div> <!-- .content -->
    </div> <!-- .container-fluid -->
  </body>
</html>