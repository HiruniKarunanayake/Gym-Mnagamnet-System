<?php

namespace classes;

use PDO;
use PDOException;

class Admin {
    private $userId;
    private $username;
    private $password;
    private $name;

    function __construct($userId, $username, $password, $name) {
        $this->userId = $userId;
        $this->username = $username;
        $this->password = $password;
        $this->name = $name;
    }

    function getUserId() {
        return $this->userId;
    }

    function getUsername() {
        return $this->username;
    }

    function getPassword() {
        return $this->password;
    }

    function getName() {
        return $this->name;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    function setUsername($username) {
        $this->username = $username;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setName($name) {
        $this->name = $name;
    }

    public function authenticate($con) {
        $query = "SELECT * FROM admin WHERE username = ? AND password=MD5(?)";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $this->username);
        $pstmt->bindValue(2, $this->password);
        $pstmt->execute();
        
        $resultSet = $pstmt->fetch(PDO::FETCH_OBJ);

        if (!empty($resultSet)) {
            $this->userId = $resultSet->user_id;
            $this->name = $resultSet->name;
            return true;
            
        }

        return false;
    }
}
?>
