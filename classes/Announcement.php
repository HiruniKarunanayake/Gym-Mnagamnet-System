<?php
/**
 * Description of Announcement
 * 
 * Author: Bumindu Hettiarachchi
 */

namespace classes;

use PDO;
use PDOException;

class Announcement {
    private $announcementId;
    private $message;
    private $date;
    
    public function __construct($announcementId, $message, $date) {
        $this->announcementId = $announcementId;
        $this->message = $message;
        $this->date = $date;
    }
    
    public function getAnnouncementId() {
        return $this->announcementId;
    }

    public function getMessage() {
        return $this->message;
    }

    public function getDate() {
        return $this->date;
    }

    public function setAnnouncementId($announcementId) {
        $this->announcementId = $announcementId;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function sendAnnouncement($con) {
        $query = "INSERT INTO announcements (message, date) VALUES (?,?)";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $this->message);
        $pstmt->bindValue(2, $this->date);
        
        $pstmt->execute();
        return $pstmt->rowCount() > 0;
    }
    
    public static function manageAnnouncement($con) {
        $announcements = [];
        try {
            $query = "SELECT * FROM announcements";
            $pstmt = $con->prepare($query);
            $pstmt->execute();

            $resultSet = $pstmt->fetchAll(PDO::FETCH_OBJ);
            if (!empty($resultSet)) {
                foreach ($resultSet as $row) {
                    $announcement = new Announcement($row->id, $row->message, $row->date);
                    $announcements[] = $announcement;
                }
            }
        } catch (PDOException $exc) {
            die("Error in User class getCustomer: " . $exc->getMessage());
        }
        return $announcements;
    }
    
    public static function removeAnnouncement($con,$announcementId){
        $query="DELETE FROM announcements WHERE id=?";
        $pstmt= $con->prepare($query);
        $pstmt->bindValue(1, $announcementId);
        $pstmt->execute();
        
        return $pstmt->rowCount() > 0;
        
        
    }
    
        public static function getAnnouncementCount($con) {
        try {
            $query ="SELECT * FROM announcements";
            $pstmt = $con->prepare($query);
            $pstmt->execute();
            $rowCount = $pstmt->rowCount();

            return $rowCount;
        } catch (PDOException $exc) {
            die("Error in Product class getAnnouncementCount: " . $exc->getMessage());
        }
    }
}
