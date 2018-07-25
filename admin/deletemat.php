<?php
include("../include/db.php");

$id = $_REQUEST['id'];

mysql_query("DELETE FROM matiere WHERE ID = $id");

header("location: matiere.php");
?>