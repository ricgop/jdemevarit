<!DOCTYPE html>
<html lang="cs">
  <head>
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ADMIN - Správa uživatelů</title>

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
            <li class="active"><a href="smazat-uzivatele.php">Smazat uživatele</a></li>
            <li><a href="smazat-recept.php">Smazat recept</a></li>
            <li><a href="sprava-hesel.php">Správa hesel</a></li>
            <li><a href="sprava-kategorii.php">Správa kategorií</a></li>
          </ul>
        </div>  <!-- /.navbar-collapse -->
      </div>  <!-- /.container-fluid -->
    </nav>

    <div class="container-fluid">
      <div id="content">

        <!-- user deletion -->
        <h1>ADMIN - Správa uživatelů</h1>
        <div id="user-container">
          <div class="col-xs-12 col-sm-8">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Smazat uživatele</h3>
              </div>
              <div id="user-details">
                <div class="form-group">
                  <label for="exampleInputName2">Jméno uživatele</label>
                  <input type="text" class="form-control" id="username" placeholder="uživatelské jméno">
                  <button type="submit" class="btn btn-default">Hledat</button>
                </div>
                <div id="table-content">
                  <table class="table table-hover" id="listed-users">
                    <thead id="table-header">
                      <tr>
                        <th></th>
                        <th>Uživatelské jméno</th>
                        <th>Email</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><input type="checkbox" id="1"></td>
                        <td>Doe</td>
                        <td>john@example.com</td>
                      </tr>
                      <tr>
                        <td><input type="checkbox" id="1"></td>
                        <td>Moe</td>
                        <td>mary@example.com</td>
                      </tr>
                    </tbody>
                  </table>
                </div> <!-- #table-content -->
                <button type="button" class="btn btn-primary" id="login-button" onclick="nazdar();">Smazat</button>
              </div> <!-- #user-details -->
            </div> <!-- panel-heading-->

            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Vytvořit uživatele</h3>
              </div>
              <div id="registration-details">
                <div class="form-group">
                  <label for="email">Email</label><span class="star"> *</span>
                  <input class="form-control" id="email" type="text" placeholder="např. jan.novak@email.cz">
                </div>
                <div class="form-group">
                  <label for="nickName">Přezdívka</label><span class="star"> *</span>
                  <input class="form-control" id="nickName" type="text" placeholder="např. kuchar1">
                </div>
                <div class="form-group">
                  <label for="password1">Heslo</label><span class="star"> *</span>
                  <input class="form-control" id="password1" type="password" placeholder="heslo">
                </div>
                <div class="form-group">
                <label for="password2">Heslo (pro potvrzení)</label><span class="star"> *</span>
                  <input class="form-control" id="password2" type="password" placeholder="heslo">
                </div>
                <div class="form-group">
                  <label for="phone">Telefon</label>
                  <input class="form-control" id="phone" type="text" placeholder="např. 123456789">
                </div>
                <div class="radio-inline">
                  <label><input type="radio" checked="checked" name="optradio">Běžný živatel</label>
                </div>
                <div class="radio-inline">
                  <label><input type="radio" name="optradio">Administrátor</label>
                </div>
                <p></p>
                <span class="info">Pole označená </span><span class="star"> *</span><span class="info"> jsou povinná</span>
                <p></p>
                <button type="button" class="btn btn-success" id="login-button" onclick="nazdar();">Vytvořit</button>
              </div> <!-- #registration details -->
            </div> <!-- .panel-default -->

          </div> <!-- .col-sm-8 -->
        </div> <!-- #user-container -->
      </div> <!-- /.content -->
    </div> <!-- /.container-fluid -->
  </body>
</html>