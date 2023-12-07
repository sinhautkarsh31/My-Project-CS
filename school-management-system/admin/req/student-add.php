<?php
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {


        if (isset($_POST['fname'])&&
            isset($_POST['lname'])&&
            isset($_POST['pass'])&&
            isset($_POST['username'])) {

            include '../../DB_connection.php';
            include "../data/student.php";
            // include "../data/teacher.php";
            
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $pass = $_POST['pass'];
            $uname = $_POST['username'];
            
            $grades = "";
            foreach($_POST['grades'] as $grade) {
                $grades .=$grade;
            } 


            $data = 'uname='.$uname.'&fname='.$fname.'&lname='.$lname;

            if (empty($fname)) {
                $em  = "First name is required";
                header("Location: ../student-add.php?error=$em&$data");
                exit; 
            } elseif (empty($lname)) {
                $em  = "Last name is required";
                header("Location: ../student-add.php?error=$em&$data");
                exit; 
            } elseif (empty($uname)) {
                $em  = "Username is required";
                header("Location: ../student-add.php?error=$em&$data");
                exit; 
            } elseif (!unameIsUnique($uname, $conn)) {
                $em  = "Username is taken! Try another";
                header("Location: ../student-add.php?error=$em&$data");
                exit; 
            }  elseif (empty($pass)) {
                $em  = "Password is required";
                header("Location: ../student-add.php?error=$em&$data");
                exit; 
            }else {
                // hashing the password
                $pass = password_hash($pass, PASSWORD_DEFAULT);
                $sql  = "INSERT INTO 
                         students(username, password, fname, lname, grade)
                         VALUES(?,?,?,?,?)"; 
                $stmt = $conn->prepare($sql);
                $stmt->execute([$uname, $pass, $fname, $lname, $grade]);

                $sm = "New student registered successfully";
                header("Location: ../student-add.php?success=$sm");
                exit;
            }
            

    }else {
            $em = "An error occurred";
            header("Location: ../student-add.php?error=$em");
            exit;
    }

    } else { 
        header("Location: ../../logout.php");
        exit;
    }

} else {
    header("Location: ../../logout.php");
    exit;
}
?>
