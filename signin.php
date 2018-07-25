<?php
include("include/db.php");
if(isset($_COOKIE['auth'])){
    $type_person = $_COOKIE['type'];
    if($type_person == 'admin')
        header("location: admin/index.php");
    else
        header("location: prof/index.php");
}

$fail = 1;
$succes = 0;

if(isset($_POST['submit'])){
  $username = htmlentities(trim($_POST['username']));
  $password = htmlentities(trim($_POST['password']));
  $type = htmlentities(trim($_POST['type']));

  if($username == 'hassouni' && $password == 'hassouni' && $type == 'admin'){
    $succes = 1;
    setcookie('auth', $username, time() + (60*60*2), '/'); // for 2 hours
    setcookie('name', $username, time() + (60*60*2), '/'); // for 2 hours
    setcookie('type', 'admin', time() + (60*60*24), '/'); // for 1 day
  }elseif($type == 'prof'){
    $succes = 1;
    setcookie('auth', $username, time() + (60*60*2), '/'); // for 2 hours
    setcookie('name', $username, time() + (60*60*2), '/'); // for 2 hours
    setcookie('type', 'prof', time() + (60*60*24), '/'); // for 1 day
  }
  if($succes){
    $fail = 0;
    session_start();
    $_SESSION['username'] = $username;
    header("location: ".$type."/index.php");
  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>GI Dept</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="static/img/fav.png" type="image/x-icon">
  <link rel="stylesheet" href="static/css/bootstrap.min.css">
  <script src="static/js/jquery.min.js"></script>
  <script src="static/js/bootstrap.min.js"></script>
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
        <li><a href="./">Home</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="active"><a href="signin.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
      </ul>
    </div>
  </div>
</nav>
  
<div class="container">
  <h3 class="text-center">LOGIN</h3>
  <br><br>
  <?php
  if(isset($_POST['submit'])){
    if($fail){
      echo '<div class="alert alert-danger" id="alert">';
      echo '<a href="#" class="close" data-dismiss="alert" aria-label="close" id="close">&times;</a>';
      echo '<strong>Access denied !</strong> check your username, password or account type.';
      echo '</div>';
    }
  }
  ?>
  <div class="row">
    <div class="col-md-3"></div>
    <form id="contact-form" class="form-group form-light mt-20 col-md-6 center-block" role="form" method="post">
      <div class="form-group">
      <label for="username">Nom d'utilisateur <font color="darkred">*</font></label>
        <div class="input-group">
          <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
          <input type="text" name="username" id="username" class="form-control" placeholder="Your username" maxlength="25" required="" autofocus>
        </div>
      </div>
      <div class="form-group">
      <label for="password">Mot de passe <font color="darkred">*</font></label>
        <div class="input-group">
          <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
          <input type="password" name="password" id="password" class="form-control" placeholder="Your password" maxlength="16" required="">
        </div>
      </div>
      <div class="form-group">
        <label for="type">Type <font color="darkred">*</font></label>
        <select name="type" id="type" class="form-control" required="" style="width: 50%;">
          <option value="admin">Admin</option>
          <option value="prof">Professeur</option>
        </select>
      </div>
      <button type="submit" name="submit" class="btn btn-primary" style="float: right;">login</button><p><br/></p>
      </form>
    </div>
</div>

</body>
</html>