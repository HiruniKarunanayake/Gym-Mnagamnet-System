<?php

namespace classes;

use PDO;

require 'Customer.php';

class Todo {

    private $todoId;
    private $taskStatus;
    private $taskDescription;
    private $userId;

    function __construct($todoId, $taskStatus, $taskDescription, $userId) {
        $this->todoId = $todoId;
        $this->taskStatus = $taskStatus;
        $this->taskDescription = $taskDescription;
        $this->userId = $userId;
    }

    function getTodoId() {
        return $this->todoId;
    }

    function getTaskStatus() {
        return $this->taskStatus;
    }

    function getTaskDescription() {
        return $this->taskDescription;
    }

    function setTodoId($todoId) {
        $this->todoId = $todoId;
    }

    function setTaskStatus($taskStatus) {
        $this->taskStatus = $taskStatus;
    }

    function setTaskDescription($taskDescription) {
        $this->taskDescription = $taskDescription;
    }

    public static function getTodoByUserId($con, $userId) {
        $todoList = [];
        $query = "SELECT * FROM todo WHERE user_id = ?";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $userId);
        $pstmt->execute();

        $resultSet = $pstmt->fetchAll(PDO::FETCH_OBJ);
        if (!empty($resultSet)) {
            foreach ($resultSet as $row) {
                $todo = new Todo(
                        $row->id, $row->task_status, $row->task_desc, $row->user_id
                );
                $todoList[] = $todo;
            }
        }
        return $todoList;
    }

    public static function getTodoById($con, $id) {
        $query = "SELECT * FROM todo WHERE id = ?";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $id);
        $pstmt->execute();

        $resultSet = $pstmt->fetchAll(PDO::FETCH_OBJ);
        if (!empty($resultSet)) {
            foreach ($resultSet as $row) {
                $todo = new Todo(
                        $row->id, $row->task_status, $row->task_desc, $row->user_id
                );
            }
        }
        return $todo;
    }
    
      public static function getAllTodo($con) {
        $todos = [];
        try {
            $query = "SELECT * FROM todo";
            $pstmt = $con->prepare($query);
            $pstmt->execute();

            $resultSet = $pstmt->fetchAll(PDO::FETCH_OBJ);
            if (!empty($resultSet)) {
                foreach ($resultSet as $row) {
                    $todo = new Todo($row->id, $row->task_status, $row->task_desc,$row->user_id);
                    $todos[] = $todo;
                }
            }
        } catch (PDOException $exc) {
            die("Error in Todo Class getAllTodo: " . $exc->getMessage());
        }
        return $todos;
    }

    public function addTodo($con) {
        $query = "INSERT INTO todo (task_status, task_desc, user_id) VALUES (?, ?, ?)";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $this->taskStatus);
        $pstmt->bindValue(2, $this->taskDescription);
        $pstmt->bindValue(3, $this->userId); // Bind userId here

        try {
            $pstmt->execute();
            return $pstmt->rowCount() > 0;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage(); // Handle PDOException if needed
            return false;
        }
    }

    public function updateTodo($con, $id) {
        $query = "UPDATE todo SET task_desc=?, task_status=? where id=?";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $this->taskDescription);
        $pstmt->bindValue(2, $this->taskStatus);
        $pstmt->bindValue(3, $this->todoId);

        try {
            $pstmt->execute();
            return $pstmt->rowCount() > 0;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage(); // Handle PDOException if needed
            return false;
        }
    }

    public static function removeTodo($con, $id) {
        $query = "DELETE FROM todo where id=?";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1,$id);

        try {
            $pstmt->execute();
            return $pstmt->rowCount() > 0;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage(); // Handle PDOException if needed
            return false;
        }
    }

}
