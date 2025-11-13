<?php

namespace classes;

use PDO;
use PDOException;

class Customer {

    private $userId;
    private $fullName;
    private $username;
    private $password;
    private $gender;
    private $registrationDate;
    private $services;
    private $amount;
    private $paidDate;
    private $paidYear;
    private $plan;
    private $address;
    private $contact;
    private $status;
    private $attendanceCount;
    private $initialWeight;
    private $currentWeight;
    private $initialBodyType;
    private $currentBodyType;
    private $progressDate;
    private $reminder;

    function __construct($userId, $fullName, $username, $password, $gender, $registrationDate, $services, $amount, $paidDate, $paidYear, $plan, $address, $contact, $status, $attendanceCount, $initialWeight, $currentWeight, $initialBodyType, $currentBodyType, $progressDate, $reminder) {
        $this->userId = $userId;
        $this->fullName = $fullName;
        $this->username = $username;
        $this->password = $password;
        $this->gender = $gender;
        $this->registrationDate = $registrationDate;
        $this->services = $services;
        $this->amount = $amount;
        $this->paidDate = $paidDate;
        $this->paidYear = $paidYear;
        $this->plan = $plan;
        $this->address = $address;
        $this->contact = $contact;
        $this->status = $status;
        $this->attendanceCount = $attendanceCount;
        $this->initialWeight = $initialWeight;
        $this->currentWeight = $currentWeight;
        $this->initialBodyType = $initialBodyType;
        $this->currentBodyType = $currentBodyType;
        $this->progressDate = $progressDate;
        $this->reminder = $reminder;
    }

    function getUserId() {
        return $this->userId;
    }

    function getFullName() {
        return $this->fullName;
    }

    function getUsername() {
        return $this->username;
    }

    function getPassword() {
        return $this->password;
    }

    function getGender() {
        return $this->gender;
    }

    function getRegistrationDate() {
        return $this->registrationDate;
    }

    function getServices() {
        return $this->services;
    }

    function getAmount() {
        return $this->amount;
    }

    function getPaidDate() {
        return $this->paidDate;
    }

    function getPaidYear() {
        return $this->paidYear;
    }

    function getPlan() {
        return $this->plan;
    }

    function getAddress() {
        return $this->address;
    }

    function getContact() {
        return $this->contact;
    }

    function getStatus() {
        return $this->status;
    }

    function getAttendanceCount() {
        return $this->attendanceCount;
    }

    function getInitialWeight() {
        return $this->initialWeight;
    }

    function getCurrentWeight() {
        return $this->currentWeight;
    }

    function getInitialBodyType() {
        return $this->initialBodyType;
    }

    function getCurrentBodyType() {
        return $this->currentBodyType;
    }

    function getProgressDate() {
        return $this->progressDate;
    }

    function getReminder() {
        return $this->reminder;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    function setFullName($fullName) {
        $this->fullName = $fullName;
    }

    function setUsername($username) {
        $this->username = $username;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setGender($gender) {
        $this->gender = $gender;
    }

    function setRegistrationDate($registrationDate) {
        $this->registrationDate = $registrationDate;
    }

    function setServices($services) {
        $this->services = $services;
    }

    function setAmount($amount) {
        $this->amount = $amount;
    }

    function setPaidDate($paidDate) {
        $this->paidDate = $paidDate;
    }

    function setPaidYear($paidYear) {
        $this->paidYear = $paidYear;
    }

    function setPlan($plan) {
        $this->plan = $plan;
    }

    function setAddress($address) {
        $this->address = $address;
    }

    function setContact($contact) {
        $this->contact = $contact;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setAttendanceCount($attendanceCount) {
        $this->attendanceCount = $attendanceCount;
    }

    function setInitialWeight($initialWeight) {
        $this->initialWeight = $initialWeight;
    }

    function setCurrentWeight($currentWeight) {
        $this->currentWeight = $currentWeight;
    }

    function setInitialBodyType($initialBodyType) {
        $this->initialBodyType = $initialBodyType;
    }

    function setCurrentBodyType($currentBodyType) {
        $this->currentBodyType = $currentBodyType;
    }

    function setProgressDate($progressDate) {
        $this->progressDate = $progressDate;
    }

    function setReminder($reminder) {
        $this->reminder = $reminder;
    }

    public function authenticate($con) {
        $query = "SELECT * FROM members WHERE username = ? AND password=MD5(?)";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $this->username);
        $pstmt->bindValue(2, $this->password);
        $pstmt->execute();

        $resultSet = $pstmt->fetch(PDO::FETCH_OBJ);

        if (!empty($resultSet)) {
            $this->userId = $resultSet->user_id;
            $this->fullName = $resultSet->fullname;
            $this->status = $resultSet->status;
            return true;
        }
        return false;
    }

    public function register($con) {
        $query = "INSERT INTO members (fullname, username, password, gender, dor, services, amount, plan, address, contact, status) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $this->fullName);
        $pstmt->bindValue(2, $this->username);
        $pstmt->bindValue(3, $this->password);
        $pstmt->bindValue(4, $this->gender);
        $pstmt->bindValue(5, $this->registrationDate);
        $pstmt->bindValue(6, $this->services);
        $pstmt->bindValue(7, $this->amount);
        $pstmt->bindValue(8, $this->plan);
        $pstmt->bindValue(9, $this->address);
        $pstmt->bindValue(10, $this->contact);
        $pstmt->bindValue(11, $this->status);

        $pstmt->execute();

        return $pstmt->rowCount() > 0;
    }

    public static function getCustomerByUserId($con, $userId) {
        $query = "SELECT * FROM members WHERE user_id=?";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $userId);
        $pstmt->execute();

        $resultSet = $pstmt->fetch(PDO::FETCH_OBJ);

        if (!empty($resultSet)) {
            return new Customer(
                    $resultSet->user_id, $resultSet->fullname, $resultSet->username, $resultSet->password, $resultSet->gender, $resultSet->dor, $resultSet->services, $resultSet->amount, $resultSet->paid_date, $resultSet->p_year, $resultSet->plan, $resultSet->address, $resultSet->contact, $resultSet->status, $resultSet->attendance_count, $resultSet->ini_weight, $resultSet->curr_weight, $resultSet->ini_bodytype, $resultSet->curr_bodytype, $resultSet->progress_date, $resultSet->reminder
            );
        }
        return null;
    }

    public static function getCustomerCount($con) {
        try {
            $query = "SELECT * FROM members";
            $pstmt = $con->prepare($query);
            $pstmt->execute();
            $rowCount = $pstmt->rowCount();

            return $rowCount;
        } catch (PDOException $exc) {
            die("Error in Product class getCustomerCount: " . $exc->getMessage());
        }
    }

    public static function getAllCustomers($con) {
        $customers = [];
        try {
            $query = "SELECT * FROM members";
            $pstmt = $con->prepare($query);
            $pstmt->execute();

            $resultSet = $pstmt->fetchAll(PDO::FETCH_OBJ);
            if (!empty($resultSet)) {
                foreach ($resultSet as $row) {
                    $customer = new Customer($row->user_id, $row->fullname, $row->username, $row->password, $row->gender, $row->dor, $row->services, $row->amount, $row->paid_date, $row->p_year, $row->plan, $row->address, $row->contact, $row->status, $row->attendance_count, $row->ini_weight, $row->curr_weight, $row->ini_bodytype, $row->curr_bodytype, $row->progress_date, $row->reminder);
                    $customers[] = $customer;
                }
            }
        } catch (PDOException $exc) {
            die("Error in Todo Class getAllCustomers: " . $exc->getMessage());
        }
        return $customers;
    }

    public static function removeCustomerById($con, $userId) {
        $query = "DELETE FROM members where user_id=?";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $userId);

        try {
            $pstmt->execute();
            return $pstmt->rowCount() > 0;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage(); // Handle PDOException if needed
            return false;
        }
    }

    public function updateCustomer($con, $userId) {
        try {
            $query = "UPDATE members SET 
            fullname = ?, 
            username = ?, 
            password = ?, 
            gender = ?, 
            dor = ?, 
            services = ?, 
            amount = ?, 
            paid_date = ?, 
            p_year = ?, 
            plan = ?, 
            address = ?, 
            contact = ?, 
            status = ?, 
            attendance_count = ?, 
            ini_weight = ?, 
            curr_weight = ?, 
            ini_bodytype = ?, 
            curr_bodytype = ?, 
            progress_date = ?, 
            reminder = ? 
            WHERE user_id = ?";

            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $this->fullName);
            $pstmt->bindValue(2, $this->username);
            $pstmt->bindValue(3, $this->password);
            $pstmt->bindValue(4, $this->gender);
            $pstmt->bindValue(5, $this->registrationDate);
            $pstmt->bindValue(6, $this->services);
            $pstmt->bindValue(7, $this->amount);
            $pstmt->bindValue(8, $this->paidDate);
            $pstmt->bindValue(9, $this->paidYear);
            $pstmt->bindValue(10, $this->plan);
            $pstmt->bindValue(11, $this->address);
            $pstmt->bindValue(12, $this->contact);
            $pstmt->bindValue(13, $this->status);
            $pstmt->bindValue(14, $this->attendanceCount);
            $pstmt->bindValue(15, $this->initialWeight);
            $pstmt->bindValue(16, $this->currentWeight);
            $pstmt->bindValue(17, $this->initialBodyType);
            $pstmt->bindValue(18, $this->currentBodyType);
            $pstmt->bindValue(19, $this->progressDate);
            $pstmt->bindValue(20, $this->reminder);
            $pstmt->bindValue(21, $userId);

            $pstmt->execute();
            return $pstmt->rowCount() > 0;
        } catch (PDOException $exc) {
            die("Error in User class updateUser: " . $exc->getMessage());
        }
    }

    public function updateCustomerPayment($con, $userId) {
        try {
            $query = "UPDATE members SET 
            fullname = ?, 
            username = ?, 
            password = ?, 
            gender = ?, 
            dor = ?, 
            services = ?, 
            amount = ?, 
            paid_date = ?, 
            p_year = ?, 
            plan = ?, 
            address = ?, 
            contact = ?, 
            status = ?, 
            attendance_count = ?, 
            ini_weight = ?, 
            curr_weight = ?, 
            ini_bodytype = ?, 
            curr_bodytype = ?, 
            progress_date = ?, 
            reminder = ? 
            WHERE user_id = ?";

            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $this->fullName);
            $pstmt->bindValue(2, $this->username);
            $pstmt->bindValue(3, $this->password);
            $pstmt->bindValue(4, $this->gender);
            $pstmt->bindValue(5, $this->registrationDate);
            $pstmt->bindValue(6, $this->services);
            $pstmt->bindValue(7, $this->amount);
            $pstmt->bindValue(8, $this->paidDate);
            $pstmt->bindValue(9, $this->paidYear);
            $pstmt->bindValue(10, $this->plan);
            $pstmt->bindValue(11, $this->address);
            $pstmt->bindValue(12, $this->contact);
            $pstmt->bindValue(13, $this->status);
            $pstmt->bindValue(14, $this->attendanceCount);
            $pstmt->bindValue(15, $this->initialWeight);
            $pstmt->bindValue(16, $this->currentWeight);
            $pstmt->bindValue(17, $this->initialBodyType);
            $pstmt->bindValue(18, $this->currentBodyType);
            $pstmt->bindValue(19, $this->progressDate);
            $pstmt->bindValue(20, $this->reminder);
            $pstmt->bindValue(21, $userId);

            $pstmt->execute();
            return $pstmt->rowCount() > 0;
        } catch (PDOException $exc) {
            die("Error in User class updateCustomerPayment: " . $exc->getMessage());
        }
    }

    public static function sendReminder($con, $userId) {
        $query = "UPDATE members SET reminder = '1' WHERE user_id=?";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $userId);

        try {
            $pstmt->execute();
            return $pstmt->rowCount() > 0;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage(); // Handle PDOException if needed
            return false;
        }
    }

    public static function getActiveCustomers($con) {
        $customers = [];
        try {
            $query = "SELECT * FROM members WHERE status = 'Active'";
            $pstmt = $con->prepare($query);
            $pstmt->execute();

            $resultSet = $pstmt->fetchAll(PDO::FETCH_OBJ);
            if (!empty($resultSet)) {
                foreach ($resultSet as $row) {
                    $customer = new Customer($row->user_id, $row->fullname, $row->username, $row->password, $row->gender, $row->dor, $row->services, $row->amount, $row->paid_date, $row->p_year, $row->plan, $row->address, $row->contact, $row->status, $row->attendance_count, $row->ini_weight, $row->curr_weight, $row->ini_bodytype, $row->curr_bodytype, $row->progress_date, $row->reminder);
                    $customers[] = $customer;
                }
            }
        } catch (PDOException $exc) {
            die("Error in Todo Class getActiveCustomers: " . $exc->getMessage());
        }
        return $customers;
    }

    public static function updateAttendance($con, $userId, $attendanceCount) {
        $query = "UPDATE members SET attendance_count = ? WHERE user_id=?";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $attendanceCount);
        $pstmt->bindValue(2, $userId);

        try {
            $pstmt->execute();
            return $pstmt->rowCount() > 0;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage(); // Handle PDOException if needed
            return false;
        }
    }

    public static function getIncomeCount($con) {
        try {

            $query = "SELECT SUM(amount) AS total_amount FROM members";
            $pstmt = $con->prepare($query);
            $pstmt->execute();
            $resultSet = $pstmt->fetch(PDO::FETCH_OBJ);

            return $resultSet->total_amount;
        } catch (PDOException $exc) {
            die("Error in Product class getIncomeCount: " . $exc->getMessage());
        }
    }
    
        public static function getActiveCustomerCount($con) {
        try {

            $query = "SELECT * FROM members WHERE status ='Active' ";
            $pstmt = $con->prepare($query);
            $pstmt->execute();
            $rowCount = $pstmt->rowCount();

            return $rowCount;
        } catch (PDOException $exc) {
            die("Error in Product class getActiveCustomerCount: " . $exc->getMessage());
        }
    }
    
    public static function searchCustomers($con,$search) {
        $customers = [];
        try {
            $query = "SELECT * FROM members WHERE fullname like '%$search%' or username like '%$search%' ";
            $pstmt = $con->prepare($query);
            $pstmt->execute();

            $resultSet = $pstmt->fetchAll(PDO::FETCH_OBJ);
            if (!empty($resultSet)) {
                foreach ($resultSet as $row) {
                    $customer = new Customer($row->user_id, $row->fullname, $row->username, $row->password, $row->gender, $row->dor, $row->services, $row->amount, $row->paid_date, $row->p_year, $row->plan, $row->address, $row->contact, $row->status, $row->attendance_count, $row->ini_weight, $row->curr_weight, $row->ini_bodytype, $row->curr_bodytype, $row->progress_date, $row->reminder);
                    $customers[] = $customer;
                }
            }
        } catch (PDOException $exc) {
            die("Error in Todo Class searchCustomers: " . $exc->getMessage());
        }
        return $customers;
    }
    
    
    public function setProgressByUserId($con,$userId){
        $query = "UPDATE members SET ini_weight=?, curr_weight=?, ini_bodytype=?, curr_bodytype=?, progress_date=? WHERE user_id=? ";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $this->initialWeight);
        $pstmt->bindValue(2, $this->currentWeight);
        $pstmt->bindValue(3, $this->initialBodyType);
        $pstmt->bindValue(4, $this->currentBodyType);
        $pstmt->bindValue(5, $this->progressDate);
        $pstmt->bindValue(6, $userId);

        try {
            $pstmt->execute();
            return $pstmt->rowCount() > 0;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage(); 
            return false;
        }
        
    }
    
    
    public static function getWeightDifferance($con,$userId) {
        try {

            $query = "SELECT SUM( curr_weight - ini_weight)AS weight_difference FROM members WHERE user_id=?";
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1,$userId);
            $pstmt->execute();
            $resultSet = $pstmt->fetch(PDO::FETCH_OBJ); 

            return $resultSet->weight_difference;
        } catch (PDOException $exc) {
            die("Error in Product class getWeightDifferance: " . $exc->getMessage());
        }
    }
    
        public static function getProgressPercentage($con,$userId) {
        try {

            $query = "SELECT SUM( (curr_weight - ini_weight) / ini_weight * 100)AS progress_percentage FROM members WHERE user_id=?";
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1,$userId);
            $pstmt->execute();
            $resultSet = $pstmt->fetch(PDO::FETCH_OBJ); 

            return $resultSet->progress_percentage;
        } catch (PDOException $exc) {
            die("Error in Product class getProgressPercentage: " . $exc->getMessage());
        }
    }
    
    

}

?>
