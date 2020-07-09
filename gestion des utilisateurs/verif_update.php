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

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  //$id = mysqli_real_escape_string($db, $_POST['id']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
    array_push($errors, "The two passwords do not match");}
  if (empty($id)) {array_push($errors, "id is required");}

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE id='$id' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
 

  // Finally, delete user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database
   
    $query = "UPDATE users SET username=$username, email=$email, password =$password WHERE id='$id' ";
  	if (mysqli_query($db, $query)) {
          echo "record updated successfuly";
      }
      else {
          echo"error updating record ".mysqli_error($db);
      }
  	//$_SESSION['username'] = $username;
  	//$_SESSION['success'] = "user has been successfuly updated";
      //header('location: ../iot/template/production/users.php');
      //echo "success";
  }
}
?>