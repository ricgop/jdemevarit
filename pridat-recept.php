<?php
  header("Content-Type: text/html; charset=utf-8");
  session_start();
  $error_db = false;
  $success = false;
  $email = $_SESSION['login_email'];

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

    /* Get status of checkboxes */
    if(isset($_POST['limitation1'])) {
      $limitation1 = 1;
    } else $limitation1 = 0;

    if(isset($_POST['limitation2'])) {
       $limitation2 = 1;
    } else $limitation2 = 0;

    if(isset($_POST['limitation3'])) {
      $limitation3 = 1;
    } else $limitation3 = 0;

    if(isset($_POST['limitation4'])) {
      $limitation4 = 1;
    } else $limitation4 = 0;

    if(isset($_POST['limitation5'])) {
      $limitation5 = 1;
    } else $limitation5 = 0;

    if(isset($_POST['limitation6'])) {
      $limitation6 = 1;
    } else $limitation6 = 0;
      
    /* Empty recipeName Validation */
    if ($_POST["recipeName"] == "") {
      $error_name = "Název receptu nesmí být prázdný!";
      $error_add = true;
    }
    /* recipeName Length and Character Validation */
    if (strlen($_POST["recipeName"]) > 60) {
      $error_name = "Neplatný název receptu - max. 60 znaků!";
      $error_add = true;
    }

    /* Empty recipeContent Validation */
    if ($_POST["recipeContent"] == "") {
      $error_content = "Seznam přísad nesmí být prázdný!";
      $error_add = true;
    }
    /* recipeContent Length and Character Validation */
    if (strlen($_POST["recipeContent"]) > 200) {
      $error_content = "Seznam přísad je příliš dlouhý - max. 200 znaků!";
      $error_add = true;
    }

    /* Empty recipeContent Validation */
    if ($_POST["recipeProcess"] == "") {
      $error_process = "Název receptu nesmí být prázdný!";
      $error_add = true;
    }
    /* recipeContent Length and Character Validation */
    if (strlen($_POST["recipeProcess"]) > 3000) {
      $error_process = "Neplatný popis receptu - max. 3000 znaků!";
      $error_add = true;
    }

  }

  # if registration details are correct - proceed
  if (isset($error_add) && $error_add == false) {

    try {
      # insert data into recipes table
      $recipe_name = $_POST["recipeName"];
      $recipe_content = $_POST["recipeContent"];
      $recipe_process = $_POST["recipeProcess"];
      $insert_recipes_table = "INSERT INTO recipes (email, recipe_name, recipe_content, recipe_process) VALUES ('$email', '$recipe_name', '$recipe_content', '$recipe_process')";
      $dbh->exec($insert_recipes_table);
      # get max id 
      $id_query = "SELECT MAX(recipe_id) FROM recipes WHERE email='$email'";
      $result = $dbh->query($id_query)->fetchAll();
      $rec_id = implode(array_unique($result[0]));
      $_SESSION['$recid'] = $rec_id;
 
      # insert data to recipe_limitations table
      $recipe_limitation = $_POST["recipeProcess"];
      $insert_limitations_table = "INSERT INTO recipe_limitations (recipe_id,limitation_1,limitation_2,limitation_3,limitation_4,limitation_5,limitation_6) VALUES ('$rec_id', '$limitation1', '$limitation2', '$limitation3', '$limitation4', '$limitation5', '$limitation6')";
      $dbh->exec($insert_limitations_table);

      # file upload if present
      $file = $_FILES['fileToUpload']["name"];
      if(($file != "") && isset($file)) {
      include 'common/upload.php';
      } else {
        $insert_photo = "INSERT INTO recipe_photo (recipe_id, file_name) VALUES ('$rec_id', null)";
        $dbh->exec($insert_photo);
        $picture_ok = true;
      }
    }
    catch (PDOException $exception)
    {
    $error_db = true;
    }

    if ($error_db == false) $success = true;
  }
?>

<!DOCTYPE html>
<html lang="cs">

  <head>
    
    <meta charset="utf-8">
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
          <a class="navbar-brand" href="recepty.php?page=1"><img alt="Brand" src="images/main.png"/></a>
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
              <?php if(isset($_SESSION['login_username'])) {
                echo '<li><a href="common/logout.php" id="logout"><u>Odhlásit</u></a></li>';
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

          <?php if($success == true && $picture_ok == true) {echo '<div class="alert alert-success" id="recipe-added"><strong>Recept</strong> byl úspěšně přidán!</div>'; header( "refresh:2;url=http://localhost/jdemevarit/pridat-recept.php" );}?>
          <?php if(isset($picture_error) && count($_POST)>0) {echo '<div class="alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' . $picture_error . '</div>';}?>
          <?php if($error_db == true) {echo '<div class="alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Nastala chyba</strong> - opakujte prosím akci později...</div>';}?>

            <div id="recipe-container">
              <div class="col-xs-12 col-sm-12">
              <form id="recipe" method="POST" enctype="multipart/form-data">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title">Recept</h3>
                  </div>                
                  <div id="recipe-details">
                    <div class="<?php if(!isset($error_name)) {echo "form-group";} else {echo "form-group has-error";} ?>" id="form-name">
                      <label for="name">Název receptu</label><span class="star"> *</span>
                      <input class="form-control" rows="5" id="name" name="recipeName" type="text" placeholder="např. Bábovka" value="<?php if(isset($_POST['recipeName'])) echo htmlspecialchars($_POST['recipeName']); ?>">
                      <div class="error"><?php if(isset($error_name)) echo $error_name; ?></div>
                    </div>
                    <div class="<?php if(!isset($error_content)) {echo "form-group";} else {echo "form-group has-error";} ?>" id="form-name">
                      <label for="RContent">Seznam přísad</label><span class="star"> *</span>
                      <textarea class="form-control" id="RContent" name="recipeContent" type="text" placeholder="např. 200ml Oleje, 500g Mouky,..."><?php if(isset($_POST['recipeContent'])) echo htmlspecialchars($_POST['recipeContent']); ?></textarea>
                      <div class="error"><?php if(isset($error_content)) echo $error_content; ?></div>
                    </div>
                    <div class="<?php if(!isset($error_process)) {echo "form-group";} else {echo "form-group has-error";} ?>" id="form-name">
                      <label for="process">Postup</label><span class="star"> *</span>
                      <textarea class="form-control" rows="20" id="process" name="recipeProcess" type="text" placeholder="např. Smícháme a vaříme 5 minut"><?php if(isset($_POST['recipeProcess'])) echo htmlspecialchars($_POST['recipeProcess']); ?></textarea>
                      <div class="error"><?php if(isset($error_process)) echo $error_process; ?></div>
                    </div>
                    <span class="info">Pole označená </span><span class="star"> *</span><span class="info"> jsou povinná</span>
                    <p></p>
                    <p>Nahrát fotografii [max 3MB]:</p>
                    <input type="file" name="fileToUpload" id="fileUpload">
                    <p></p>
                  </div> <!-- #registration details -->
                </div> <!-- .panel-default -->
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title">Recept je <b>nevhodný</b> pro osoby s omezením</h3>
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
                  <a href="pridat-recept.php" id="reset-page"><u>Zrušit změny</u></a>
                </div>

                </form>
              </div> <!-- .col-sm-4 -->
            </div> <!-- #recipe-container -->

        </div> <!-- #recipe -->
      </div> <!-- .content -->
    </div> <!-- .container-fluid -->
  </body>
</html>