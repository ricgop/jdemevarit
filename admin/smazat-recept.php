<!DOCTYPE html>
<html lang="cs">
  <head>
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ADMIN - Správa receptů</title>

    <link rel="icon" type="image/png" href="icons/favicon.png">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <link href="css/style.css" rel="stylesheet">

    <script>
    function nazdar() {
    	alert("nazdar!");
    }
    </script>
  </head>

  <body>
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <a class="navbar-brand" href="smazat-uzivatele.php"><img alt="Brand" src="icons/main.png"></a>
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
            <li><a href="prihlaseni.php">Přihlášení</a></li>
            <li><a href="smazat-uzivatele.php">Smazat uživatele</a></li>
            <li class="active"><a href="smazat-recept.php">Smazat recept</a></li>
            <li><a href="sprava-hesel.php">Správa hesel</a></li>
            <li><a href="sprava-kategorii.php">Správa kategorií</a></li>
          </ul>
        </div>  <!-- /.navbar-collapse -->
      </div>  <!-- /.container-fluid -->
    </nav>

    <div class="container-fluid">
      <div id="content">

        <!-- user deletion -->
        <h1>ADMIN - Správa receptů</h1>
        <div id="user-container">
          <div class="col-xs-12 col-sm-8">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Smazat recept</h3>
              </div>
              <div id="user-details">
                <div class="form-group">
                  <label for="recipe">Název receptu</label>
                  <input type="text" class="form-control" id="recipe" placeholder="název receptu">
                  <button type="submit" class="btn btn-default">Hledej</button>
                </div>
                <div id="table-content">
                  <table class="table table-hover" id="listed-users">
                    <thead id="table-header">
                      <tr>
                        <th></th>
                        <th>Název kategoire</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><input type="checkbox" id="1"></td>
                        <td>Kuře na paprice</td>
                      </tr>
                      <tr>
                        <td><input type="checkbox" id="2"></td>
                        <td>Bábovka</td>
                      </tr>
                    </tbody>
                  </table>
                </div> <!-- #table-content -->
                <button type="button" class="btn btn-primary" id="login-button" onclick="nazdar();">Smazat</button>
              </div> <!-- #user-details -->
            </div> <!-- panel-heading-->

          </div> <!-- .col-sm-8 -->
        </div> <!-- #user-container -->
      </div> <!-- /.content -->
    </div> <!-- /.container-fluid -->
  </body>
</html>