<?php
include("../include/db.php");
if(!isset($_COOKIE['auth'])){
    header("location: /vpn_ssl_app/signin.php");
}else{
  include("../include/prof.php");
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
      <a class="navbar-brand" href="#">GI DEPT</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="./">Home</a></li>
        <li class="active"><a href="#">Matiere</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#"><span class="glyphicon glyphicon-user"></span> <?php echo $_COOKIE['name']; ?></a></li>
        <li><a href="/vpn_ssl_app/logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
  
<div class="container">
  <h2 class="text-center">Matieres</h2>
  <br>
  <form method="post" action="excel.php?mat_id='.$data['ID'].' class="row" enctype="multipart/form-data">
          <input type="file" name="excelFile" class="form-control" style="width: 300px; cursor: pointer; float: left; margin: 0 5px;"/>
          <button type="submit" name="btnImport" class="btn btn-info">
            <span class="glyphicon glyphicon-upload"></span>
            Import
          </button>
        </form>
  <br>
  <table class="table table-striped" id="mydata">
    <thead>
      <tr id="none">
        <td>#</td>
        <td>Matiere</td>
        <td>Professeur</td>
        <td>Annee</td>
        <td>notes</td>
      </tr>
    </thead>
    <tbody id="mat">
      <?php
      $prof_name = $_COOKIE['name'];
      $sql = mysql_query("SELECT * FROM prof WHERE NAME LIKE '$prof_name%'");
      $data = mysql_fetch_array($sql);
      $prof_id = $data['ID'];

      $query = mysql_query("SELECT * FROM matiere WHERE PROF = $prof_id");
      while ($data=mysql_fetch_array($query)) {
        echo "<tr>";
        echo "<td>".$data['ID']."</td>";
        echo "<td>".$data['MATIERE']."</td>";
        echo "<td>";
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
        echo '
        <form method="post" class="row" action="excel.php?mat_id='.$data['ID'].'&prof_id='.$prof_id.'">
          <button type="submit" name="btnExport" class="btn btn-success">
            <span class="glyphicon glyphicon-download"></span>
            Download
          </button>
        </form>
        ';
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