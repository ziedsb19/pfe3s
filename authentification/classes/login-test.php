<?php 

    if(isset($_POST['se connecter'])) 
    {
        $email = $_POST['email'];
        $password = $_POST['mot de passe'];

        $result = $user->login($email, $password);

        if($result != null) 
        {
            $_SESSION['userLoggedIn'] = $result;
            header("Location: index.php");
        }else
        {
            echo "<script>console.log('Fail')</script>";
        }

    }


?>