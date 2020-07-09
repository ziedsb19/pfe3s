<?php
    class DB_Connection {
 
        private $conn;
    
        protected function connect(){
    
            $db_username = 'root';
            $db_password = '';
            $db_name     = 'user';
            $db_host     = 'localhost';
            $dsn ='mysql:host=' . $db_host . ';dbname=' . $db_name;

            //$db = mysqli_connect($db_host, $db_name)
                   //or die('could not connect to database');
         try {
            $this->conn = new PDO($dsn, $db_username, $db_password);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            return $this->conn;
            
         
         } catch (PDOException $e) {
             echo "Connection fail:" .$e->getMessage();
         }
        }
        
    }
    




















?>