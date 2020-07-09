<?php 
session_start();
$userLoggedIn = null;
if(isset($_SESSION['userLoggedIn']))
{
  $userLoggedIn =$_SESSION['userLoggedIn'];
 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">


  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <link href="css/blog-home.css" rel="stylesheet">

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <h7 style="color:white;"><?php 
   if($userLoggedIn != null){
  echo $userLoggedIn->username;}?></h7>
    <div class="container">
    
      <a class="navbar-brand" href="#">Forum</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Blog
              <span class="sr-only">(current)</span>
            </a>
          </li>

        
          <?php
          if($userLoggedIn != null)
           echo "  
           <li class='nav-item'> <a class='nav-link' href='add_post.php'>Add article</a></li>
           <li class='nav-item'> <a class='nav-link' href='login.php'>Edit profile</a></li>
           <li class='nav-item'> <a class='nav-link' href='logout.php'>Logout</a></li>
           ";
          else{
            echo " <a class='nav-link' href='login.php'>Login</a>";
          }
          ?>
           
          </li>

        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  <div class="container">

    <div class="row">

    

      <!-- Sidebar Widgets Column -->
     

    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <!-- Footer -->
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; Your Website 2019</p>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
