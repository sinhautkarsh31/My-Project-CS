<?php

//All Students
function getAllStudents($conn){
    $sql = "SELECT * FROM students";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() >= 1) {
        $students = $stmt->fetchAll();
        return $students;
    }else {
        return 0;
    }
}

// DELETE 
function removeStudent($id, $conn){
    $sql = "DELETE FROM students
            WHERE student_id=?";

    $stmt = $conn->prepare($sql);
    $re   = $stmt->execute([$id]);


    if ($re) {
        return 1;
    }else {
        return 0;
    }
}

//Get Student by ID
function getStudentById($id, $conn){
    $sql = "SELECT * FROM students
            WHERE student_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);

    if ($stmt->rowCount() == 1) {
        $student = $stmt->fetch();
        return $student;
    }else {
        return 0;
    }
}

//Check if username is unique
function unameIsUnique($uname, $conn, $student_id=0){
    $sql = "SELECT username, student_id FROM students
            WHERE username=?";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$uname]);

    if ($student_id == 0) {
        if ($stmt->rowCount() >= 1) {
            return 0;
        }else {
            return 1;
        }
    }else {
        if ($stmt->rowCount() >= 1) {
            $student = $stmt->fetch();
            if ($student['student_id'] == $student_id) {
                return 1;
            }else return 0;
        }else {
            return 1;
        }
    }
    
}

//Search
function searchStudents($key, $conn){
    $key = "%{$key}%";
    $sql = "SELECT * FROM students
            WHERE student_id LIKE?
            OR fname LIKE ?
            OR lname LIKE ?
            OR username LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$key, $key, $key, $key]);

    if ($stmt->rowCount() == 1) {
        $students = $stmt->fetchAll();
        return $students;
    }else {
        return 0;
    }
}

//Sorting
//Sorting
function sortStudents($conn, $column){
    //Validate the column and order parameters
    $valid_columns = array("student_id", "fname", "lname", "username");

    if (!in_array($column, $valid_columns)){
        return 0; //Invalid input
    }
    //Prepare the SQL query with the column and order parameters
    $sql = "SELECT * FROM students ORDER BY $column";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$column, $column, $column, $column]);

    if ($stmt->rowCount() > 0) {
        $students = $stmt->fetchAll();
        return $students; 
    }else {
        return 0; 
    }
}


?>