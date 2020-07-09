<?php

class users extends DB_Connection {
private $conn;
private $LoginErrorArray;

public function __construct() 
{
    $this->conn =$this->connect();
    $this->LoginErrorArray = array();
}

public function login($email, $password) 
    {   
        $password = md5($password);
        $sql ="SELECT id, username, email FROM users where email = ? and password = ? ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email, $password]);
        $user = $stmt->fetch();

        if($user == null) {
            array_push($this->LoginErrorArray, "Email ou mot de passe invalide");
        }
        return $user;
    }

    public function getloginerror()
    {

        if(!empty($this->LoginErrorArray))
        {
            $error = $this->LoginErrorArray[0];
            return "<div class='alert alert-danger' role='alert'>$error</div>";
            
        }

    }

}

?>