<?php


namespace classes;
use PDO;
use PDOException;

/**
 * Description of Reminder
 *
 * @author bbumi
 */
class Reminder {
    private $id;
    private $name;
    private $message;
    private $status;
    private $date;
    private $userId;
    
    function __construct($id, $name, $message, $status, $date, $userId) {
        $this->id = $id;
        $this->name = $name;
        $this->message = $message;
        $this->status = $status;
        $this->date = $date;
        $this->userId = $userId;
    }

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getMessage() {
        return $this->message;
    }

    function getStatus() {
        return $this->status;
    }

    function getDate() {
        return $this->date;
    }

    function getUserId() {
        return $this->userId;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setMessage($message) {
        $this->message = $message;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setDate($date) {
        $this->date = $date;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    public static function getAllReminders($con) {
        $reminders = [];
        try {
            $query = "SELECT * FROM reminder";
            $pstmt = $con->prepare($query);
            $pstmt->execute();

            $resultSet = $pstmt->fetchAll(PDO::FETCH_OBJ);
            if (!empty($resultSet)) {
                foreach ($resultSet as $row) {
                    $reminder = new Reminder($row->id,$row->name, $row->message, $row->status,$row->date,$row->user_id);
                    $reminders[] = $reminder;
                }
            }
        } catch (PDOException $exc) {
            die("Error in User class getCustomer: " . $exc->getMessage());
        }
        return $reminders;
    }
    
        public static function getRemindercountByUserId($con, $userId) {
        $query = "SELECT reminder FROM members WHERE user_id = ?";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $userId);
        $pstmt->execute();

        $result = $pstmt->fetchAll(PDO::FETCH_OBJ);
        if (!empty($result)) {
            return $result;
        }
        return false;
    }
    
    
        public static function sendReminderByUserId($con,$userId) {
        $query = "UPDATE members SET reminder = '1' where user_id=?";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $userId);

        $pstmt->execute();
        return $pstmt->rowCount() > 0;
    }
}
