<?php
include("../include/db.php");
if(!isset($_COOKIE['auth'])){
    header("location: /vpn_ssl_app/signin.php");
}else{
  include("../include/admin.php");
}

$error = '';
$success = 0;

if(isset($_POST['edit'])){
  $id = htmlentities(trim($_POST['id']));
  $prof = htmlentities(trim($_POST['prof']));
  $matiere = htmlentities(trim($_POST['matiere']));
  $annee = htmlentities(trim($_POST['annee']));

  $test = mysql_query("SELECT * FROM matiere WHERE MATIERE='$matiere' and ID!=$id");
  $testrow = mysql_num_rows($test);
  if($testrow){
    $error = ' matiere deja existe.';
  }else{
    mysql_query("UPDATE matiere SET PROF=$prof, MATIERE='$matiere', ANNEE=$annee WHERE ID = $id");
    $success = 1;
  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>GI Dept</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="/vpn_ssl_app/static/img/fav.png" type="image/x-icon">
  <link rel="stylesheet" href="/vpn_ssl_app/static/css/bootstrap.min.css">
  <script src="/vpn_ssl_app/static/js/jquery.min.js"></script>
  <script src="/vpn_ssl_app/static/js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="./">GI DEPT</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="./">Accueil</a></li>
        <li><a href="professors.php">Professeurs</a></li>
        <li class="active"><a href="matiere.php">Matieres</a></li>
        <li><a href="etudiant.php">Etudiants</a></li>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#"><span class="glyphicon glyphicon-user"></span> <?php echo $_COOKIE['name']; ?></a></li>
        <li><a href="/vpn_ssl_app/logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
  
<div class="container">
  <h3 class="text-center">Modifier une matiere</h3>
  <br>
  <?php


  $mat_id = $_REQUEST['id'];
  $query = mysql_query("SELECT * FROM matiere WHERE ID = $mat_id");
  while ($data = mysql_fetch_array($query)) {
    $id = $data['ID'];
    $prof_id = $data['PROF'];
    $matiere = $data['MATIERE'];
    $annee = $data['ANNEE'];
  }


  if(isset($_POST['edit'])){
    if($error){
      echo '<div class="row">';
      echo '<div class="col-md-3"></div>';
      echo '<div class="alert alert-danger col-md-6" id="alert">';
      echo '<a href="#" class="close" data-dismiss="alert" aria-label="close" id="close">&times;</a>';
      echo '<strong>Operation failed !</strong> '.$error;
      echo '</div>';
      echo '</div>';
    }elseif ($success) {
      echo '<div class="row">';
      echo '<div class="col-md-3"></div>';
      echo '<div class="alert alert-success col-md-6" id="alert">';
      echo '<a href="#" class="close" data-dismiss="alert" aria-label="close" id="close">&times;</a>';
      echo '<strong>Matiere modifiée !</strong> cliquez <a href="matiere.php">ici</a> pour voir toutes les matieres.';
      echo '</div>';
      echo '</div>';
    }
  }
  ?>
        <div class="col-md-3"></div>
        <form id="contact-form" class="form-group col-md-6" role="form" method="post">
        <input type="text" name="id" style="display: none;" value="<?php echo $id; ?>">
        <div class="form-group">
          <label for="prof">Professeur <font color="darkred">*</font></label>
          <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
            <select name="prof" id="prof" class="form-control" required="">
              <?php
                $sql = mysql_query("SELECT * FROM prof");
                while ($row = mysql_fetch_array($sql)) {
                  if($row['ID'] == $prof_id){
                    echo '<option value="'.$row['ID'].'" selected>';
                  }else{
                    echo '<option value="'.$row['ID'].'">';
                  }
                  echo $row['NAME'];
                  echo '</option>';
                }
              ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="matiere">Matiere <font color="darkred">*</font></label>
          <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-book"></span></span>
            <input type="text" name="matiere" id="matiere" class="form-control" value="<?php echo $matiere; ?>" maxlength="25" required="">
          </div>
        </div>
        <div class="form-group">
          <label for="annee">Annee <font color="darkred">*</font></label>
          <select name="annee" id="annee" class="form-control" required="" style="width: 50%;">
          <?php
            if($annee == 1){
              echo "<option value='1' selected>1ere annee</option>";
            }else{
              echo "<option value='1'>1ere annee</option>";
            }
            if($annee == 2){
              echo "<option value='2' selected>2eme annee</option>";
            }else{
              echo "<option value='2'>2eme annee</option>";
            }
            if($annee == 3){
              echo "<option value='3' selected>3eme annee</option>";
            }else{
              echo "<option value='3'>3eme annee</option>";
            }
          ?>
          </select>
        </div>
        <a href="matiere.php" class="btn btn-default">annuler</a>
        <button type="submit" name="edit" class="btn btn-primary" style="float: right;">modifier</button><p><br/></p>
        </form>

</div>

</body>
</html>