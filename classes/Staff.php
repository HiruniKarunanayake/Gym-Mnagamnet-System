<?php

namespace classes;

use PDO;
use PDOException;

/**
 * Description of Staff
 *
 * @author bbumi
 */
class Staff {

    private $userId;
    private $username;
    private $password;
    private $email;
    private $fullName;
    private $address;
    private $designation;
    private $gender;
    private $contact;

    function __construct($userId, $username, $password, $email, $fullName, $address, $designation, $gender, $contact) {
        $this->userId = $userId;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->fullName = $fullName;
        $this->address = $address;
        $this->designation = $designation;
        $this->gender = $gender;
        $this->contact = $contact;
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

    function getEmail() {
        return $this->email;
    }

    function getFullName() {
        return $this->fullName;
    }

    function getAddress() {
        return $this->address;
    }

    function getDesignation() {
        return $this->designation;
    }

    function getGender() {
        return $this->gender;
    }

    function getContact() {
        return $this->contact;
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

    function setEmail($email) {
        $this->email = $email;
    }

    function setFullName($fullName) {
        $this->fullName = $fullName;
    }

    function setAddress($address) {
        $this->address = $address;
    }

    function setDesignation($designation) {
        $this->designation = $designation;
    }

    function setGender($gender) {
        $this->gender = $gender;
    }

    function setContact($contact) {
        $this->contact = $contact;
    }

    public function authenticate($con) {
        $query = "SELECT * FROM staffs WHERE username = ? AND password=MD5(?)";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $this->username);
        $pstmt->bindValue(2, $this->password);
        $pstmt->execute();

        $resultSet = $pstmt->fetch(PDO::FETCH_OBJ);

        if (!empty($resultSet)) {
            $this->userId = $resultSet->user_id;
            $this->fullName = $resultSet->fullname;
            $this->designation = $resultSet->designation;
            return true;
        }
        return false;
    }

    public function register($con) {
        $query = "INSERT INTO staffs (fullname, username, password, email,address,designation,gender,contact)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $this->fullName);
        $pstmt->bindValue(2, $this->username);
        $pstmt->bindValue(3, $this->password);
        $pstmt->bindValue(4, $this->email);
        $pstmt->bindValue(5, $this->address);
        $pstmt->bindValue(6, $this->designation);
        $pstmt->bindValue(7, $this->gender);
        $pstmt->bindValue(8, $this->contact);

        $pstmt->execute();
        return $pstmt->rowCount() > 0;
    }

    public static function getStaffCount($con) {
        try {
            $query = "SELECT * FROM staffs";
            $pstmt = $con->prepare($query);
            $pstmt->execute();
            $rowCount = $pstmt->rowCount();

            return $rowCount;
        } catch (PDOException $exc) {
            die("Error in Product class getstaffCount: " . $exc->getMessage());
        }
    }

    public static function getTrainerCount($con) {
        try {
            $query = "SELECT * FROM staffs WHERE designation='Trainer' ";
            $pstmt = $con->prepare($query);
            $pstmt->execute();
            $rowCount = $pstmt->rowCount();

            return $rowCount;
        } catch (PDOException $exc) {
            die("Error in Product class getTrainerCount: " . $exc->getMessage());
        }
    }

    public static function getAllStaffMembers($con) {
        $staff = [];
        try {
            $query = "SELECT * FROM staffs";
            $pstmt = $con->prepare($query);
            $pstmt->execute();

            $resultSet = $pstmt->fetchAll(PDO::FETCH_OBJ);
            if (!empty($resultSet)) {
                foreach ($resultSet as $row) {
                    $staffMember = new Staff($row->user_id, $row->username, $row->password, $row->email, $row->fullname, $row->address, $row->designation, $row->gender, $row->contact);
                    $staff[] = $staffMember;
                }
            }
        } catch (PDOException $exc) {
            die("Error in Todo Class getAllStaffMembers: " . $exc->getMessage());
        }
        return $staff;
    }

    public static function getStaffByUserId($con, $userId) {
        $query = "SELECT * FROM staffs WHERE user_id=?";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $userId);
        $pstmt->execute();

        $resultSet = $pstmt->fetch(PDO::FETCH_OBJ);

        if (!empty($resultSet)) {
            return new Staff($resultSet->user_id, $resultSet->username, $resultSet->password, $resultSet->email, $resultSet->fullname, $resultSet->address, $resultSet->designation, $resultSet->gender, $resultSet->contact);
        }
        return null;
    }

    public function updateStaffMember($con, $userId) {
        try {
            $query = "UPDATE staffs SET fullname=?, username=?, gender=?, contact=?,  address=?, designation=? WHERE user_id=?";

            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $this->fullName);
            $pstmt->bindValue(2, $this->username);
            $pstmt->bindValue(3, $this->gender);
            $pstmt->bindValue(4, $this->contact);
            $pstmt->bindValue(5, $this->address);
            $pstmt->bindValue(6, $this->designation);
            $pstmt->bindValue(7, $userId);

            $pstmt->execute();
            return $pstmt->rowCount() > 0;
        } catch (PDOException $exc) {
            die("Error in User class updateStaffMember: " . $exc->getMessage());
        }
    }

    public static function removeStaffMemberById($con, $userId) {
        $query = "DELETE FROM staffs where user_id=?";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $userId);

        try {
            $pstmt->execute();
            return $pstmt->rowCount() > 0;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

}
