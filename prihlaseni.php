<!DOCTYPE html>
<html lang="cs">
  <head>
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8">
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
            <li><a href="recepty.html">Recepty</a></li>
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
          <form>
            <div id="login-container">
              <div class="col-xs-12 col-sm-4">
                <div class="form-group">
                  <label for="nickName">Email/přezdívka</label><span class="star"> *</span>
                  <input class="form-control" id="nickName" type="text" placeholder="např. jan.novak@email.cz">
                </div>
                <div class="form-group">
                  <label for="password">Heslo</label><span class="star"> *</span>
                  <input class="form-control" id="password" type="password" placeholder="heslo">
                </div>
                <span class="info">Pole označená </span><span class="star"> *</span><span class="info"> jsou povinná</span>
                <p></p>
                <div>
                  <button type="button" class="btn btn-primary" id="login-button" onclick="nazdar();">Přihlásit</button>
                </div>
              </div> <!-- .col-sm-4 -->
            </div> <!-- #login-container -->
          </form>
        </div> <!-- /.recipes -->
      </div> <!-- /.content -->
    </div> <!-- /.container-fluid -->

  </body>
</html>