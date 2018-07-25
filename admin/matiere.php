<?php
include("../include/db.php");
if(!isset($_COOKIE['auth'])){
    header("location: /vpn_ssl_app/signin.php");
}else{
  include("../include/admin.php");
}

$error = '';
$success = '';

if(isset($_POST['add'])){
  $prof = htmlentities(trim($_POST['prof']));
  $matiere = htmlentities(trim($_POST['matiere']));
  $annee = htmlentities(trim($_POST['annee']));

  $test = mysql_query("SELECT * FROM matiere WHERE MATIERE='$matiere'");
  $testrow = mysql_num_rows($test);
  if($testrow){
    $error = ' matiere deja existe.';
  }else{
    mysql_query("INSERT INTO matiere VALUES (null,$prof,'$matiere',$annee)");
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
  <link rel="stylesheet" href="/vpn_ssl_app/static/css/dataTables.bootstrap.min.css">
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
        <li class="active"><a href="#">Matieres</a></li>
        <li><a href="etudiant.php">Etudiants</a></li>
        <li><a href="note.php">Notes</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#"><span class="glyphicon glyphicon-user"></span> <?php echo $_COOKIE['name']; ?></a></li>
        <li><a href="/vpn_ssl_app/logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
  
<div class="container">
  <h3>Liste des matiere</h3>
  <br>
  <?php
  if(isset($_POST['add'])){
    if($error){
      echo '<div class="alert alert-danger" id="alert">';
      echo '<a href="#" class="close" data-dismiss="alert" aria-label="close" id="close">&times;</a>';
      echo '<strong>Operation failed !</strong> '.$error;
      echo '</div>';
    }elseif ($success) {
      echo '<div class="alert alert-success" id="alert">';
      echo '<a href="#" class="close" data-dismiss="alert" aria-label="close" id="close">&times;</a>';
      echo '<strong>Operation success !</strong> matiere ajoutee';
      echo '</div>';
    }
  }
  ?>

<div class="row">
  <div class="col-md-6">
    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">
      <span class="glyphicon glyphicon-plus-sign"></span> 
      ajouter une matiere
    </button>
  </div>
</div>
<br>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Ajouter une matiere</h4>
      </div>
      <div class="modal-body">
        <form id="contact-form" class="form-group form-light mt-20 center-block" role="form" method="post">
        <div class="form-group">
        <label for="prof">Professeur <font color="darkred">*</font></label>
          <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
            <select name="prof" id="prof" class="form-control" required="">
              <?php
                $sql = mysql_query("SELECT * FROM prof");
                while ($row = mysql_fetch_array($sql)) {
                  echo '<option value="'.$row['ID'].'">';
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
            <input type="text" name="matiere" id="matiere" class="form-control" placeholder=" matiere" maxlength="25" required="">
          </div>
        </div>
        <div class="form-group">
          <label for="annee">Annee <font color="darkred">*</font></label>
          <select name="annee" id="annee" class="form-control" required="" style="width: 50%;">
            <option value="1">1ere annee</option>
            <option value="2">2eme annee</option>
            <option value="3">3eme annee</option>
          </select>
        </div>
        <hr>
        <button type="button" class="btn btn-default" data-dismiss="modal">cancel</button>
        <button type="submit" name="add" class="btn btn-primary" style="float: right;">ajouter</button><p><br/></p>
        </form>
      </div>
    </div>

  </div>
</div>

  <br>
  <table class="table table-striped" id="mydata">
    <thead>
      <tr id="none">
        <td>#</td>
        <td>Matiere</td>
        <td>Professeur</td>
        <td>Annee</td>
        <td>Actions</td>
      </tr>
    </thead>
    <tbody id="mat">
      <?php
      $query = mysql_query("SELECT * FROM matiere");
      while ($data=mysql_fetch_array($query)) {
        echo "<tr>";
        echo "<td>".$data['ID']."</td>";
        echo "<td>".$data['MATIERE']."</td>";
        echo "<td>";
          $prof_id = $data['PROF'];
          $sql = mysql_query("SELECT * FROM prof WHERE ID = $prof_id");
          while ($row = mysql_fetch_array($sql)) {
            echo $row['NAME'];
          }
        echo "</td>";
        echo "<td>";
          if ($data['ANNEE'] == 1) {
            echo "1ere annee";
          }elseif($data['ANNEE'] == 2){
            echo "2eme annee";
          }elseif($data['ANNEE'] == 3){
            echo "3eme annee (Licence)";
          }
        echo "</td>";
        echo "<td>";
        echo "<a class='btn btn-info' style='margin: 0 5px;' href='editmat.php?id=".$data['ID']."' ><span class='glyphicon glyphicon-edit'></span> modifier</button></a>";
        echo "<a class='btn btn-danger' style='margin: 0 5px;' href='deletemat.php?id=".$data['ID']."' ><span class='glyphicon glyphicon-trash'></span> supprimer</button>";
        echo "</td>";
        echo "</tr>";
      }
      ?>
    </tbody>
  </table>
  <div style="height: 100px;"></div>
</div>
<script src="/vpn_ssl_app/static/js/jquery.js"></script>
<script src="/vpn_ssl_app/static/js/jquery.dataTables.min.js"></script>
<script src="/vpn_ssl_app/static/js/dataTables.bootstrap.min.js"></script>
<script>
  $('#mydata').dataTable();
</script>
</body>
</html>