<?php 
session_start();
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
            <form class="navbar-form navbar-left">
            <ul class="nav navbar-nav">
              <li class="dropdown">
                <button type="button" class="btn btn-primary  dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="filter">Zdravotní omezení <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                  <li><label><input type="checkbox"> Onemocnění žlučníku</label></li>
                  <li><label><input type="checkbox"> Onemocnění jater</label></li>
                  <li><label><input type="checkbox"> Alergie na pyl</label></li>
                  <li><label><input type="checkbox"> Alergie na ořechy</label></li>
                  <li><label><input type="checkbox"> Alergie na laktózu</label></li>
                  <li><label><input type="checkbox"> Celiakie</label></li>
                </ul> <!-- .dropdown menu -->
              </li> <!-- .dropdown -->
            </ul> <!-- .nav navbar-nav -->
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Hledat recept">
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

          <!-- draw recipe thumbnails -->
          <?php
              try {
                #set-up db connection
                $dbh = new PDO('mysql:host=127.0.0.1;dbname=jdemevarit','jdeme.varit','Jdemevarit123');
                $insert_users_table = "SELECT * FROM recipe_thumbnails";
                $result = $dbh->query($insert_users_table)->fetchAll();
                foreach($result as $row)
                {
                  echo '
                    <div class="row">
                      <div class="col-xs-6 col-md3">
                        <div class="thumbnail">
                          <h3>';
                  echo      $row['recipe_name'];
                  echo      '</h3>
                            <p>Od uživatele: <i>';
                  echo      $row['username'];
                  echo  '</i></p></div>
                      </div>
                    </div>
                  ';
                }
              }
              catch (PDOException $exception)
              {
              $error_db = true;
            }
          ?>
 
        </div> <!-- .recipes -->
      </div> <!-- .content -->
      <div class="text-center">
        <nav aria-label="Page navigation">
          <ul class="pagination">
            <li>
              <a href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>
            <li><a href="#">1</a></li> 
            <li><a href="#">2</a></li> 
            <li>
              <a href="#" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li>
          </ul>
        </nav>
    </div>
    </div> <!-- .container-fluid -->

  </body>
</html>