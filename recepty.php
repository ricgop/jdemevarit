<?php 
session_start();
# see if there was a problem when working with db
$error_db = false;
# max. recipes shown on a single page
$paging = 2;
?>
<!DOCTYPE html>
<html lang="cs">
  <head>
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recepty</title>

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
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#top-navbar" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="recepty.php"><img alt="Brand" src="images/main.png"></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="top-navbar">
          <ul class="nav navbar-nav">
            <li class="active"><a href="recepty.php">Recepty</a></li>
            <?php if(!isset($_SESSION['login_username'])) {echo '<li><a href="registrace.php">Registrace</a></li>';} ?>
            <?php if(!isset($_SESSION['login_username'])) {echo '<li><a href="prihlaseni.php">Přihlášení</a></li>';} ?>
            <?php if(isset($_SESSION['login_username'])) {echo '<li><a href="pridat-recept.php">Přidat recept</a></li>';} ?>
            <?php if(isset($_SESSION['login_username'])) {echo '<li><a href="me-recepty.php">Mé recepty</a></li>';} ?>
          </ul> <!-- .nav navbar-nav -->
            
            <!-- search bar -->
            <form class="navbar-form navbar-left" method="post">
            <ul class="nav navbar-nav">
              <li class="dropdown">
                <button type="button" class="btn btn-primary  dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="filter">Zdravotní omezení <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                  <li><label><input type="checkbox" name="limitation1" <?php if(isset($_POST['limitation1'])) echo 'checked="checked"'; ?>> Onemocnění žlučníku</label></li>
                  <li><label><input type="checkbox" name="limitation2" <?php if(isset($_POST['limitation2'])) echo 'checked="checked"'; ?>> Onemocnění jater</label></li>
                  <li><label><input type="checkbox" name="limitation3" <?php if(isset($_POST['limitation3'])) echo 'checked="checked"'; ?>> Alergie na pyl</label></li>
                  <li><label><input type="checkbox" name="limitation4" <?php if(isset($_POST['limitation4'])) echo 'checked="checked"'; ?>> Alergie na ořechy</label></li>
                  <li><label><input type="checkbox" name="limitation5" <?php if(isset($_POST['limitation5'])) echo 'checked="checked"'; ?>> Alergie na laktózu</label></li>
                  <li><label><input type="checkbox" name="limitation6" <?php if(isset($_POST['limitation6'])) echo 'checked="checked"'; ?>> Celiakie</label></li>
                  <button type="submit" class="btn btn-primary" id="limitation-button">Filtrovat</button>
                </ul> <!-- .dropdown menu -->
              </li> <!-- .dropdown -->
            </ul> <!-- .nav navbar-nav -->
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Hledat recept" name="find" value="<?php if(isset($_POST['find'])) echo $_POST['find']; ?>">
            </div>
            <button type="submit" class="btn btn-default">Hledej</button>
          </form>
          <form class="navbar-right">
            <ul class="nav navbar-nav">
              <?php if(isset($_SESSION['login_username'])) {
                echo '<li><a href="recepty.php" onclick="logOut();" id="logout"><u>Odhlásit</u></a></li>';
              } ?>
            </ul>
          </form>
        </div> <!-- .navbar-collapse -->
      </div> <!-- .container-fluid -->
    </nav>

    <div class="container-fluid">
      <div id="content">
        <div id="recipes">
          <h1>Recepty</h1>

          <!-- error message if there are problems with db -->
          <?php if($error_db == true) {echo '<div class="alert alert-danger"><strong>Nastala chyba</strong> - zkuste prosím přijít později...</div>';}?>

          <!-- draw recipe thumbnails -->
          <?php
              try {
                #set-up db connection
                $dbh = new PDO('mysql:host=127.0.0.1;dbname=jdemevarit','jdeme.varit','Jdemevarit123');

                # variable to set page number if empty
                if(isset($_GET['page'])) {$page = $_GET['page'];} else {$page = 0;};
                $offset = $paging * $page;
                if ($page >= 0) {
                # get list of recipe thumbnail details
                $select_recipes = "SELECT * FROM recipe_thumbnails limit $offset, $paging";
                $array = $dbh->query($select_recipes);

                # get number of recipes
                $get_all_recipes = "SELECT recipe_id FROM recipes";
                $all_array = $dbh->query($get_all_recipes);
                $total_recipes = $all_array->rowCount();

                if ($array->rowCount() == 0) {
                  echo 'Nenalezen žádný recept... :-(';
                  } else {
                    $result = $array->fetchAll();
                    foreach($result as $row)
                    {
                      echo '<a href="pridat-recept.php">
                      
                            <div class="thumbnail">
                            <h3>';
                    echo      $row['recipe_name'];
                    echo      '</h3>';
                    if ($row['file_name'] != null) {
                      echo      '<img src="pics/';
                      echo      $row['file_name'];
                      echo      '" alt="chybí obrázek" height="150px" width="150px" id="food_pic">';
                    } else echo '<img src="common/pics/no_picture_cz.png" alt="chybí obrázek" height="150px" width="150px" id="food_pic">';
                    echo        '<p>Od uživatele: <i>';
                    echo      $row['username'];
                    echo  '</i></p>
                        </div></a>
                    ';
                    }
                  }
                } else {echo 'Bohužel nastala chyba...';}
              }
              catch (PDOException $exception)
              {
              $error_db = true;
            }
          ?>
 
        </div> <!-- .recipes -->
      </div> <!-- .content -->
    </div> <!-- .container-fluid -->
      <div class="text-center" id = "bottom-navigation">
        <nav aria-label="Page navigation">
          <ul class="pagination">
            <li>
              <a href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>
            <?php
              # create pagination
              for ($i=0; $i<$total_recipes/$paging; $i++) {
                echo '<li><a href="http://localhost/jdemevarit/recepty.php?page=' . $i . '">' . ($i+1) . '</a></li>';
              }
              ?>
            <li>
              <a href="#" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li>
          </ul>
        </nav>
    </div>
    
  </body>
</html>