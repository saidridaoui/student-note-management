<?php
session_start();

$id = $_COOKIE['auth'];
setcookie('auth', $id, time() + (60*60*2), '/'); // for 2 hours
setcookie('type', 'admin', time() + (60*60*24), '/'); // for 1 day

/*
$select = mysql_query("SELECT * FROM admin WHERE ID='$id'");
while($data = mysql_fetch_array($select)){
        $id = $data['ID'];
        $fname = $data['FIRST_NAME'];
        $lname = $data['LAST_NAME'];
        $username = $data['USERNAME'];
        $email = $data['EMAIL'];
        $phone = $data['PHONE'];
}
    
$_SESSION['id'] = $id;
$_SESSION['fname'] = $fname;
$_SESSION['lname'] = $lname;
$_SESSION['username'] = $username;
$_SESSION['email'] = $email;
$_SESSION['phone'] = $phone;
$_SESSION['type'] = 'admin';
*/
?>