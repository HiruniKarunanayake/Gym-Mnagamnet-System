<?php

namespace classes;

use PDO;
use PDOException;

/**
 * Description of Attendance
 *
 * @author bbumi
 */
class Attendance {

    private $id;
    private $userId;
    private $currentDate;
    private $currentTime;
    private $present;

    function __construct($id, $userId, $currentDate, $currentTime, $present) {
        $this->id = $id;
        $this->userId = $userId;
        $this->currentDate = $currentDate;
        $this->currentTime = $currentTime;
        $this->present = $present;
    }

    function getId() {
        return $this->id;
    }

    function getUserId() {
        return $this->userId;
    }

    function getCurrentDate() {
        return $this->currentDate;
    }

    function getCurrentTime() {
        return $this->currentTime;
    }

    function getPresent() {
        return $this->present;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    function setCurrentDate($currentDate) {
        $this->currentDate = $currentDate;
    }

    function setCurrentTime($currentTime) {
        $this->currentTime = $currentTime;
    }

    function setPresent($present) {
        $this->present = $present;
    }

    public function getAttendance($con, $userId) {
        $query = "SELECT * FROM attendance WHERE curr_date = ? AND user_id = ?";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $this->currentDate);
        $pstmt->bindValue(2, $userId);
        $pstmt->execute();
        $row = $pstmt->fetch(PDO::FETCH_OBJ);

        if ($row) {
            return new Attendance($row->id, $row->user_id, $row->curr_date, $row->curr_time, $row->present);
        }
        return null;
    }

    public static function getAttendanceCount($con) {
        try {
            $query = "SELECT * FROM attendance";
            $pstmt = $con->prepare($query);
            $pstmt->execute();
            return $pstmt->rowCount();
        } catch (PDOException $exc) {
            die("Error in Product class getAttendanceCount: " . $exc->getMessage());
        }
    }

    public function addAttendance($con) {
        $query = "INSERT INTO attendance (user_id, curr_date,curr_time,present) VALUES (?,?,?,?)";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $this->userId);
        $pstmt->bindValue(2, $this->currentDate);
        $pstmt->bindValue(3, $this->currentTime);
        $pstmt->bindValue(4, $this->present);

        $pstmt->execute();
        return $pstmt->rowCount() > 0;
    }

    public function removeAttendance($con) {
        $query = "DELETE FROM attendance WHERE user_id=?";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $this->userId);
        $pstmt->execute();
        return $pstmt->rowCount() > 0;
    }

}

?>
