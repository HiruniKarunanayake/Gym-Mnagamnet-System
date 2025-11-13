<?php

namespace classes;

use PDO;
use PDOException;

class Equipment {
    private $id;
    private $name;
    private $amount;
    private $quantity;
    private $vendor;
    private $description;
    private $address;
    private $contact;
    private $date;

    public function __construct($id, $name, $amount, $quantity, $vendor, $description, $address, $contact, $date) {
        $this->id = $id;
        $this->name = $name;
        $this->amount = $amount;
        $this->quantity = $quantity;
        $this->vendor = $vendor;
        $this->description = $description;
        $this->address = $address;
        $this->contact = $contact;
        $this->date = $date;
    }

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getAmount() {
        return $this->amount;
    }

    function getQuantity() {
        return $this->quantity;
    }

    function getVendor() {
        return $this->vendor;
    }

    function getDescription() {
        return $this->description;
    }

    function getAddress() {
        return $this->address;
    }

    function getContact() {
        return $this->contact;
    }

    function getDate() {
        return $this->date;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setAmount($amount) {
        $this->amount = $amount;
    }

    function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    function setVendor($vendor) {
        $this->vendor = $vendor;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setAddress($address) {
        $this->address = $address;
    }

    function setContact($contact) {
        $this->contact = $contact;
    }

    function setDate($date) {
        $this->date = $date;
    }

    
    public static function getAllEquipments($con) {
        $equipments = [];
        try {
            $query = "SELECT * FROM equipment"; // Corrected table name
            $stmt = $con->prepare($query);
            $stmt->execute();

            $resultSet = $stmt->fetchAll(PDO::FETCH_OBJ);
            if (!empty($resultSet)) {
                foreach ($resultSet as $row) {
                    $equipment = new Equipment(
                        $row->id,
                        $row->name,
                        $row->amount,
                        $row->quantity,
                        $row->vendor,
                        $row->description,
                        $row->address,
                        $row->contact,
                        $row->date
                    );
                    $equipments[] = $equipment;
                }
            }
        } catch (PDOException $exc) {
            throw new PDOException("Error in Equipment class getAllEquipments: " . $exc->getMessage());
        }
        return $equipments;
    }

    public static function getEquipmentById($con, $id) {
        try {
            $query = "SELECT * FROM equipment WHERE id=?";
            $stmt = $con->prepare($query);
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_OBJ);
            if ($row) {
                return new Equipment(
                    $row->id,
                    $row->name,
                    $row->amount,
                    $row->quantity,
                    $row->vendor,
                    $row->description,
                    $row->address,
                    $row->contact,
                    $row->date
                );
            }
        } catch (PDOException $exc) {
            throw new PDOException("Error in Equipment class getEquipmentById: " . $exc->getMessage());
        }
        return null; // Return null if no equipment found
    }

    public function addEquipment($con) {
        try {
            $query = "INSERT INTO equipment (name, description, amount, vendor, address, contact, date, quantity) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $con->prepare($query);
            $stmt->bindValue(1, $this->name);
            $stmt->bindValue(2, $this->description);
            $stmt->bindValue(3, $this->amount);
            $stmt->bindValue(4, $this->vendor);
            $stmt->bindValue(5, $this->address);
            $stmt->bindValue(6, $this->contact);
            $stmt->bindValue(7, $this->date);
            $stmt->bindValue(8, $this->quantity);

            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $exc) {
            throw new PDOException("Error in Equipment class addEquipment: " . $exc->getMessage());
        }
    }

    public static function removeEquipment($con, $id) {
        try {
            $query = "DELETE FROM equipment WHERE id=?";
            $stmt = $con->prepare($query);
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (PDOException $exc) {
            throw new PDOException("Error in Equipment class removeEquipment: " . $exc->getMessage());
        }
    }
    
    public function updateEquipment($con,$id) {
    try {
        $query = "UPDATE equipment SET name=?, amount=?,vendor=?, description=?, address=?, contact=?, date=?, quantity=? WHERE id=?";

        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $this->name);
        $pstmt->bindValue(2, $this->amount);
        $pstmt->bindValue(3, $this->vendor);
        $pstmt->bindValue(4, $this->description);
        $pstmt->bindValue(5, $this->address);
        $pstmt->bindValue(6, $this->contact);
        $pstmt->bindValue(7, $this->date);
        $pstmt->bindValue(8, $this->quantity);
        $pstmt->bindValue(9, $id);

        $pstmt->execute();
        return $pstmt->rowCount() > 0;
    } catch (PDOException $exc) {
        die("Error in User class updateEquipment: " . $exc->getMessage());
    }
}
        public static function getEquipmentCount($con) {
        try {
            $query = "SELECT * FROM equipment";
            $pstmt = $con->prepare($query);
            $pstmt->execute();
            $rowCount = $pstmt->rowCount();

            return $rowCount;
        } catch (PDOException $exc) {
            die("Error in Product class getEquipmentCount: " . $exc->getMessage());
        }
    }
    
    
    public static function getTotalExpense($con) {
        try {

            $query = "SELECT SUM( amount) AS total_amount FROM equipment";
            $pstmt = $con->prepare($query);
            $pstmt->execute();
            $resultSet = $pstmt->fetch(PDO::FETCH_OBJ);

            return $resultSet->total_amount;
        } catch (PDOException $exc) {
            die("Error in Product class getTotalExpense: " . $exc->getMessage());
        }
    }
}
?>
