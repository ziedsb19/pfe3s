<?php
session_start();

// initializing variables
$username = "";
$email    = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'user');
// Check connection
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
  }
 

if(!empty($_POST)){
extract($_POST);
$valid = true;
 
if (isset($_POST['modification'])){
    $username = htmlentities(trim($username));
    $email = htmlentities(trim($email));
    
 
if(empty($username)){
    $valid = false;
    $username = "Il faut mettre un nom";
}


 
if(empty($email)){
$valid = false;
$email = "Il faut mettre un mail";
 
}
if ($valid){
//$password = md5($password);//encrypt the password before saving in the database

$DB="UPDATE user SET username = $username, email = $email, password = $password, WHERE id = $id";
 
$_SESSION['username'] = $username;
$_SESSION['email'] = $email;
$_SESSION['password'] = $password;
if (mysqli_query($db, $DB)) {
    echo "record updated successfuly";
}
else {
    echo"error updating record ".mysqli_error($db);
}
 
//header('Location:  profil.php');
exit;
}
}
}
?>