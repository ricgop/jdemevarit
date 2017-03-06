<?php 
  session_start();
  # see if there was a problem when working with db
  $error_db = false;

  #draw recipe thumbnails
  try {
  #set-up db connection
  $dbh = new PDO('mysql:host=127.0.0.1;dbname=jdemevarit','jdeme.varit','Jdemevarit123');

  # get recipe details
  if(isset($_GET['recipeID'])){
	  # get recipe details
	  $recipe_details_query = "SELECT * FROM recipe_details where recipe_id =" . ($_GET['recipeID']);
	  $recipe_details = $dbh->query($recipe_details_query)->fetchAll();
	  # insert recipe details into variables
	  $recipe_name = $recipe_details[0]['recipe_name'];
	  $recipe_photo = $recipe_details[0]['file_name'];
	  $limitation1 = $recipe_details[0]['limitation_1'];
	  $limitation2 = $recipe_details[0]['limitation_2'];
	  $limitation3 = $recipe_details[0]['limitation_3'];
	  $limitation4 = $recipe_details[0]['limitation_4'];
	  $limitation5 = $recipe_details[0]['limitation_5'];
	  $limitation6 = $recipe_details[0]['limitation_6'];

  # if recipeID isn't set - throw error
  } else $error_db = true;

  }
  catch (PDOException $exception)
  {
     $error_db = true;
  }

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
        $.get("common/logout.php");
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
            <li><a href="recepty.php">Recepty</a></li>
            <?php if(!isset($_SESSION['login_username'])) {echo '<li><a href="registrace.php">Registrace</a></li>';} ?>
            <?php if(!isset($_SESSION['login_username'])) {echo '<li><a href="prihlaseni.php">Přihlášení</a></li>';} ?>
            <?php if(isset($_SESSION['login_username'])) {echo '<li><a href="pridat-recept.php">Přidat recept</a></li>';} ?>
            <?php if(isset($_SESSION['login_username'])) {echo '<li><a href="me-recepty.php">Mé recepty</a></li>';} ?>
            <li class="active"><a href="">Detail receptu</a></li>
          </ul> <!-- .nav navbar-nav -->
            
            <!-- search bar -->
            <form class="navbar-form navbar-left" method="post">
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
        	<!-- error message if there are problems with db -->
        	<?php if($error_db == true) {echo '<br><div class="alert alert-danger"><strong>Nastala chyba</strong> - zkuste se prosím vrátit později...</div>';}

	        	if ($error_db == false) {
	        		# recipe name
		        	echo'<h1>' . $recipe_name .'</h1>';

		        	# recipe photo
		        	if ($recipe_photo) {
		        	echo      '<img src="pics/';
                    echo      $recipe_photo;
                    echo      '" alt="chybí obrázek" height="150px" width="150px" id="food_pic">';
                    } else echo '<img src="common/pics/no_picture_cz.png" alt="chybí obrázek" height="150px" width="150px" id="food_pic">';

                    # recipe limitations
                    if ($limitation1 == 1 && $limitation2 == 1 && $limitation3 == 1 && $limitation4 == 1 && $limitation5 == 1 && $limitation6 == 1) {
	                    echo '<p>Vhodné pro:</p>';
	                    if ($limitation1 == 1) echo '<span class="label label-success">Onemocnění žlučníku</span>';
	                    if ($limitation2 == 1) echo '<span class="label label-success">Onemocnění jater</span>';
	                    if ($limitation3 == 1) echo '<span class="label label-success">Alergie na pyl</span>';
	                    if ($limitation4 == 1) echo '<span class="label label-success">Alergie na ořechy</span>';
	                    if ($limitation5 == 1) echo '<span class="label label-success">Alergie na laktózu</span>';
	                    if ($limitation6 == 1) echo '<span class="label label-success">Celiakie</span>';
                	} else echo '<p>Tento recept není vhodný pro osoby se zdravotním omezenim.</p>';
	        	}

 			?>
        </div> <!-- .recipes -->
      </div> <!-- .content -->
    </div> <!-- .container-fluid -->
    
  </body>
</html>