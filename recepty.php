<?php 
  session_start();
  $_SESSION['last_action'] = time();

  # see if there was a problem when working with db
  $error_db = false;
  # max. recipes shown on a single page
  $paging = 8;
  # count number of filters applied
  $limitation_count = 0;

  # initial filter settings
  if(count($_POST)==0) {
    if (!isset($_SESSION['login_username'])) {
      if (isset($_SESSION['limitation1'])) {
        if (($_SESSION['limitation1']) == 1) {$limitation1 = 1;} 
      else {$limitation1 = 0; $_SESSION['limitation1'] = 0;};} 
      else {$limitation1 = 0; $_SESSION['limitation1'] = 0;};
    if (isset($_SESSION['limitation2'])) {
      if (($_SESSION['limitation2']) == 1) {$limitation2 = 1;} 
      else {$limitation2 = 0; $_SESSION['limitation2'] = 0;};} 
      else {$limitation2 = 0; $_SESSION['limitation2'] = 0;};
    if (isset($_SESSION['limitation3'])) {
      if (($_SESSION['limitation3']) == 1) {$limitation3 = 1;} 
      else {$limitation3 = 0; $_SESSION['limitation3'] = 0;};} 
      else {$limitation3 = 0; $_SESSION['limitation3'] = 0;};
    if (isset($_SESSION['limitation4'])) {
      if (($_SESSION['limitation4']) == 1) {$limitation4 = 1;} 
      else {$limitation4 = 0; $_SESSION['limitation4'] = 0;};} 
      else {$limitation4 = 0; $_SESSION['limitation4'] = 0;};
    if (isset($_SESSION['limitation5'])) {
      if (($_SESSION['limitation5']) == 1) {$limitation5 = 1;} 
      else {$limitation5 = 0; $_SESSION['limitation5'] = 0;};} 
      else {$limitation5 = 0; $_SESSION['limitation5'] = 0;};
    if (isset($_SESSION['limitation6'])) {
      if (($_SESSION['limitation6']) == 1) {$limitation6 = 1;} 
      else {$limitation6 = 0; $_SESSION['limitation6'] = 0;};} 
      else {$limitation6 = 0; $_SESSION['limitation6'] = 0;};

    } else {
    # if user is logged in
      $limitation1 = $_SESSION['limitation1'];
      $limitation2 = $_SESSION['limitation2'];
      $limitation3 = $_SESSION['limitation3'];
      $limitation4 = $_SESSION['limitation4'];
      $limitation5 = $_SESSION['limitation5'];
      $limitation6 = $_SESSION['limitation6'];
    }
  }

  # change filter settings - if user changed them
  if(count($_POST)>0) {

    if (isset($_POST['limitation1'])) {
      $_SESSION['limitation1'] = 1;
      $limitation1 = 1;
    } else {
      $_SESSION['limitation1'] = 0;
      $limitation1 = 0;
    }

    if (isset($_POST['limitation2'])) {
      $_SESSION['limitation2'] = 1;
      $limitation2 = 1;
    } else {
      $_SESSION['limitation2'] = 0;
      $limitation2 = 0;
    }

    if (isset($_POST['limitation3'])) {
      $_SESSION['limitation3'] = 1;
      $limitation3 = 1;
    } else {
      $_SESSION['limitation3'] = 0;
      $limitation3 = 0;
    }

    if (isset($_POST['limitation4'])) {
      $_SESSION['limitation4'] = 1;
      $limitation4 = 1;
    } else {
      $_SESSION['limitation4'] = 0;
      $limitation4 = 0;
    }

    if (isset($_POST['limitation5'])) {
      $_SESSION['limitation5'] = 1;
      $limitation5 = 1;
    } else {
      $_SESSION['limitation5'] = 0;
      $limitation5 = 0;
    }

    if (isset($_POST['limitation6'])) {
      $_SESSION['limitation6'] = 1;
      $limitation6 = 1;
    } else {
      $_SESSION['limitation6'] = 0;
      $limitation6 = 0;
    }
  }

  #prepare filter variables
  $filter_submit_string = '';
  # prepare string to append to url
  $filter_string = '';
  $filter_set = false;
  # get filter values and store them to variable fx
  if ((isset($_GET['f1'])) || (isset($_GET['f2'])) || (isset($_GET['f3'])) || (isset($_GET['f4'])) || (isset($_GET['f5'])) || (isset($_GET['f6']))) {
    $filter_set = true;
    if (isset($_GET['f1'])) $f1=($_GET['f1']);
    if (isset($_GET['f2'])) $f2=($_GET['f2']);
    if (isset($_GET['f3'])) $f3=($_GET['f3']);
    if (isset($_GET['f4'])) $f4=($_GET['f4']);
    if (isset($_GET['f5'])) $f5=($_GET['f5']);
    if (isset($_GET['f6'])) $f6=($_GET['f6']);

    for ($url_lim = 1; $url_lim < 7; $url_lim++){
      if(isset(${"f$url_lim"})) {
        $filter_string .= '&f' . $url_lim . '=' . ${"f$url_lim"};
      }
    }
  }

    if ($limitation1 == 1 || $limitation2 == 1 || $limitation3 == 1 || $limitation4 == 1 || $limitation5 == 1 || $limitation6 == 1) {
    if ($limitation1 == 1) ++$limitation_count;
    if ($limitation2 == 1) ++$limitation_count;
    if ($limitation3 == 1) ++$limitation_count;
    if ($limitation4 == 1) ++$limitation_count;
    if ($limitation5 == 1) ++$limitation_count;
    if ($limitation6 == 1) ++$limitation_count;
  }

  # check if search was performed
  if (isset($_POST['find']) && ($_POST['find']) != "") {
    include 'common/translate.php';
    $search_text = $_POST['find'];
    $translated_text = strtr($search_text, $prevodni_tabulka);
    echo '<br>hledam ' . $search_text . ' tedy prelozeno: ' . $translated_text;
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
          <a class="navbar-brand" href="recepty.php?page=1"><img alt="Brand" src="images/main.png"></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="top-navbar">
          <ul class="nav navbar-nav">
            <li class="active"><a href="recepty.php?page=1">Recepty</a></li>
            <?php if(!isset($_SESSION['login_username'])) {echo '<li><a href="registrace.php">Registrace</a></li>';} ?>
            <?php if(!isset($_SESSION['login_username'])) {echo '<li><a href="prihlaseni.php">Přihlášení</a></li>';} ?>
            <?php if(isset($_SESSION['login_username'])) {echo '<li><a href="pridat-recept.php">Přidat recept</a></li>';} ?>
            <?php if(isset($_SESSION['login_username'])) {echo '<li><a href="me-recepty.php">Mé recepty</a></li>';} ?>
          </ul> <!-- .nav navbar-nav -->
            
            <!-- search bar -->
            <form class="navbar-form navbar-left" method="POST" action="http://localhost/jdemevarit/recepty.php?page=1">
            <ul class="nav navbar-nav">
              <li class="dropdown">
                <button type="button" class="btn btn-primary  dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="filter">Zdravotní omezení <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                  <li><label><input type="checkbox" name="limitation1" <?php if($limitation1 == 1) {echo 'checked="checked"';} ?>> Onemocnění žlučníku</label></li>
                  <li><label><input type="checkbox" name="limitation2" <?php if($limitation2 == 1) {echo 'checked="checked"';} ?>>  Onemocnění jater</label></li>
                  <li><label><input type="checkbox" name="limitation3" <?php if($limitation3 == 1) {echo 'checked="checked"';} ?>>  Alergie na pyl</label></li>
                  <li><label><input type="checkbox" name="limitation4" <?php if($limitation4 == 1) {echo 'checked="checked"';} ?>>  Alergie na ořechy</label></li>
                  <li><label><input type="checkbox" name="limitation5" <?php if($limitation5 == 1) {echo 'checked="checked"';} ?>>  Alergie na laktózu</label></li>
                  <li><label><input type="checkbox" name="limitation6" <?php if($limitation6 == 1) {echo 'checked="checked"';} ?>>  Celiakie</label></li>
                  <button class="btn btn-primary" id="limitation-button">Filtrovat</button>
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
                echo '<li><a href="common/logout.php" id="logout"><u>Odhlásit</u></a></li>';
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
          <?php if($error_db == true) {echo '<div class="alert alert-danger"><strong>Nastala chyba</strong> - zkuste se prosím vrátit později...</div>';}?>

          <!-- draw recipe thumbnails -->
          <?php
              try {
                #set-up db connection
                $dbh = new PDO('mysql:host=127.0.0.1;dbname=jdemevarit','jdeme.varit','Jdemevarit123');

                # variable to set page number if parameter page is empty
                if(isset($_GET['page'])) {$page = $_GET['page'];} else {$page = 1;};
                $offset = $paging * ($page - 1);
                if ($page >= 1) {
                # get list of recipe thumbnail details
                if ($limitation_count == 0 && !isset($translated_text)) {
                  $select_recipes = "SELECT * FROM recipe_thumbnails limit $offset, $paging";
                  $array = $dbh->query($select_recipes);
                } else {
                  # some of the limitations are checked
                  $limitation_set = 0;
                  $limitation_query = 'WHERE ';
                  for ($lim = 1; $lim < 7; $lim++) {
                    # check if limitations are set - if so then update query
                    if (${"limitation$lim"} == 1) {
                      if ($limitation_set == 0) {
                        $limitation_query .= 'limitation_' . $lim . '=1';
                        $limitation_set = 1;
                      } else {
                        # query was already updated
                        $limitation_query .= ' AND ' . 'limitation_' . $lim . '=1';
                      }
                    };
                  }
                  #create filtered query
                  if ($limitation_count == 0 && isset($translated_text)) {
                    $search_query = ' WHERE recipe_name like "%' . $translated_text . '%"';
                    $select_recipes = "SELECT * FROM recipe_thumbnails_filtered " . $search_query . " limit $offset, $paging";
                  } else {
                    if (isset($transted_text)){
                    $search_query = ' AND recipe_name like "%' . $translated_text . '%"';
                    $select_recipes = "SELECT * FROM recipe_thumbnails_filtered " . $limitation_query . $search_query . " limit $offset, $paging";} else {
                    $select_recipes = "SELECT * FROM recipe_thumbnails_filtered " . $limitation_query . " limit $offset, $paging";
                    }
                  }
                  $array = $dbh->query($select_recipes);
                }

                # get number of recipes
                $get_all_recipes = "SELECT recipe_id FROM recipes";
                $all_array = $dbh->query($get_all_recipes);
                $total_recipes = $all_array->rowCount();

                # create recipe bricks
                if ($array->rowCount() == 0) {
                  echo 'Nenalezen žádný recept... :-(';
                  } else {
                    $result = $array->fetchAll();
                    foreach($result as $row)
                    {
                      echo '<a href="recept.php?recipeID=' . $row['recipe_id'] . '&' . 'page=' . $page . $filter_string;
                      echo'">
                      
                            <div class="thumbnail">
                            <div style="height: 50px">
                              <h3>';
                    echo        $row['recipe_name'];
                    echo      '</h3>
                            </div>';                           
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
          <ul class="pagination" id="paging">
            <li>

              <a href="<?php if ($page > 1) {echo'http://localhost/jdemevarit/recepty.php?page=' . ($page - 1);}?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>
            <?php
              # create pagination
              if(isset($total_recipes)) {
                # total ammount of pages is less than 11 pages - no special formating with ...
                if ($total_recipes/$paging <= 10) {
                  for ($i=1; $i < ($total_recipes/$paging + 1); $i++) {
                    # highlight active page
                    if($page != ($i)) {
                      echo '<li><a href="http://localhost/jdemevarit/recepty.php?page=' . ($i) . '">' . $i . '</a></li>';
                    } else {
                      echo '<li><a href="http://localhost/jdemevarit/recepty.php?page=' . ($i) . '" id="active_page"><u><b>' . $i . '</b></u></a></li>';
                    }
                  }
                } else {
                  # if we are close to beginning or end of the total
                  # first 3 paginations
                  if (($page < 4) || ($page >= ($total_recipes/$paging - 3))) {
                    for ($i=1; $i < 5; $i++) {
                      # highlight active page
                      if($page != ($i)) {
                        echo '<li><a href="http://localhost/jdemevarit/recepty.php?page=' . ($i) . '">' . $i . '</a></li>';
                      } else {
                        echo '<li><a href="http://localhost/jdemevarit/recepty.php?page=' . ($i) . '" id="active_page"><u><b>' . $i . '</b></u></a></li>';
                      }
                    }
                    echo '<li><a>...</a></li>';
                    for ($i=($total_recipes/$paging - 3); $i < ($total_recipes/$paging +1); $i++) {
                      # highlight active page
                      if($page != ($i)) {
                        echo '<li><a href="http://localhost/jdemevarit/recepty.php?page=' . ($i) . '">' . $i . '</a></li>';
                      } else {
                        echo '<li><a href="http://localhost/jdemevarit/recepty.php?page=' . ($i) . '" id="active_page"><u><b>' . $i . '</b></u></a></li>';
                      }
                    }
                  } else {
                      for ($i=$page - 4; $i <= $page +1; $i++) {
                      # highlight active page
                      if($page != ($i)) {
                        echo '<li><a href="http://localhost/jdemevarit/recepty.php?page=' . ($i) . '">' . $i . '</a></li>';
                      } else {
                        echo '<li><a href="http://localhost/jdemevarit/recepty.php?page=' . ($i) . '" id="active_page"><u><b>' . $i . '</b></u></a></li>';
                      }
                    }
                    for ($i=($page+2); $i < ($page+5); $i++) {
                      # highlight active page
                      if($page != ($i)) {
                        echo '<li><a href="http://localhost/jdemevarit/recepty.php?page=' . ($i) . '">' . $i . '</a></li>';
                      } else {
                        echo '<li><a href="http://localhost/jdemevarit/recepty.php?page=' . ($i) . '" id="active_page"><u><b>' . $i . '</b></u></a></li>';
                      }
                    }
                  }
                }
              }
              ?>
            <li>
              <a href="<?php if ($page < ($total_recipes/$paging)) {echo'http://localhost/jdemevarit/recepty.php?page=' . ($page + 1);}?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li>
          </ul>
        </nav>
    </div>
    <div class = "navbar navbar-default navbar-bottom" id="warning">
      <div class = "container">
        <p class = "navbar-header"><i><u>Upozornění:</u> recepty na stránkách www.jdemevarit.cz jsou vkládány registrovanými uživateli. Z toho důvodu provozovatel v žádném případě neodpovídá za správnost a aktuálnost zveřejněných receptů.</i></p>
      </div>
    </div>
    
  </body>
</html>