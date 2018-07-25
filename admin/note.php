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
        <li><a href="etudiant.php">Etudiants</a></li>
        <li class="active"><a href="#">Notes</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#"><span class="glyphicon glyphicon-user"></span> <?php echo $_COOKIE['name']; ?></a></li>
        <li><a href="/vpn_ssl_app/logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
  
<div class="container">
  <h3>Notes</h3>
  <br>
  <table class="table table-striped" id="mydata">
    <thead>
      <tr id="none">
        <td>#</td>
        <td>Matiere</td>
        <td>actions</td>
      </tr>
    </thead>
    <tbody id="mat">
    <?php
      $query = mysql_query("SELECT * FROM note");
      while ($data = mysql_fetch_array($query)) {
        echo "<tr>";
        echo "<td>".$data['MATIERE_ID']."</td>";
        echo "<td>".$data['FILE']."</td>";
        echo "<td>";
        echo '
        <a href="/vpn_ssl_app/notes/'.$data['FILE'].'.csv" class="btn btn-success">
            <span class="glyphicon glyphicon-download"></span>
            Download
        </a>
        ';
        echo "</td>";
      }

    ?>
    </tbody>
  </table>
</div>
</body>
</html>