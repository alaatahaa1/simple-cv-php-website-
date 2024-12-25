<?php

class Cvdb
{
    private $conn;

    public function __construct()
    {
        $this->conn = new PDO('mysql:host=localhost;dbname=cvcreatdb1', 'root', '');
    }

    public function insertUser($username, $hashed_password, $fullname ,$email)
    {
        $stmt = $this->conn->prepare("INSERT INTO users (username, password, fullname,email) VALUES (?, ?, ?,?)");
        $stmt->execute([$username, $hashed_password, $fullname,$email]);
    }
    
    public function userExists($username)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->rowCount() > 0;
    }

    public function getHashedPassword($username)
    {
        $stmt = $this->conn->prepare("SELECT password FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $row = $stmt->fetch();
        if ($row) {
            return $row['password'];
        } else {
            return null;
        }
    }

    /*public function insertCV($name, $email, $phone, $address, $summary, $education, $experience) {
        $stmt = $this->conn->prepare("INSERT INTO cvs (name, email, phone, address, summary, education, experience) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $email);
        $stmt->bindParam(3, $phone);
        $stmt->bindParam(4, $address);
        $stmt->bindParam(5, $summary);
        $stmt->bindParam(6, $education);
        $stmt->bindParam(7, $experience);
       
        $stmt->execute();
    
        return $stmt;
    }
    */
    
}
