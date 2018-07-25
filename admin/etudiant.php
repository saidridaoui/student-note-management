<?php
include("../include/db.php");
if(!isset($_COOKIE['auth'])){
    header("location: /vpn_ssl_app/signin.php");
}else{
  include("../include/admin.php");
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
        <li><a href="matiere.php">Matieres</a></li>
        <li class="active"><a href="#">Etudiants</a></li>
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
  <h3>Liste des etudiants</h3>
  <br>
  <?php
  if(isset($_POST['btnImport'])){
    if(!empty($_FILES["excelFile"]["tmp_name"])){
      $fileName = explode(".",$_FILES["excelFile"]["name"]);
      if($fileName[1]=="csv"){
        echo "Processing !!!";
        mysql_query("delete from etudiant");

        $file = $_FILES["excelFile"]["tmp_name"];
        $openFile = fopen($file, "r");
        $line = 0;
        while($dataFile = fgetcsv($openFile,3000,",")){
          if($line>0){
            $id = $dataFile[0];
            $name = $dataFile[1];
            $annee = $dataFile[2];
            mysql_query("insert into etudiant values($id,'$name',$annee)");
          }
          $line++;
        }
      }else{
        echo "You must choose a csv file to import !!!";
      }
    }else{
      echo "You must choose a file !!!";
    }
  }
  ?>
  <div class="row">
    <form method="post" class="row" enctype="multipart/form-data">
    <div class="col-md-4">
      <input type="file" name="excelFile" class="form-control col-md-4" />
    </div>
      <input type="submit" name="btnImport" value="Import Data from Excel file" class="btn btn-default col-md-2">
    </form>
  </div><br>
  <div class="row">
    <form method="post" class="row" action="excel.php">
      <input type="submit" name="btnExport" value="Export Data to Excel file" class="btn btn-default">
    </form>
  </div>
  <br>
  <table class="table table-striped" id="mydata">
    <thead>
      <tr>
        <td>#</td>
        <td>Nom</td>
        <td>Annee</td>
      </tr>
    </thead>
    <tbody>
      <?php
      $query = mysql_query("SELECT * FROM etudiant");
      while ($data=mysql_fetch_array($query)) {
        echo "<tr>";
        echo "<td>".$data['ID']."</td>";
        echo "<td>".$data['NAME']."</td>";
        echo "<td>";
          if ($data['ANNEE'] == 1) {
            echo "1ere annee<br>";
          }elseif($data['ANNEE'] == 2){
            echo "2eme annee<br>";
          }elseif($data['ANNEE'] == 3){
            echo "3eme annee (Licence)";
          }
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