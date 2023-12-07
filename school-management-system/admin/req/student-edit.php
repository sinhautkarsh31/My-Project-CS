<?php
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {


        if (isset($_POST['fname'])&&
            isset($_POST['lname'])&&
            isset($_POST['username'])){

            include '../../DB_connection.php';
            include "../data/student.php";
            
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $uname = $_POST['username'];

            $student_id = $_POST['student_id'];

            $data = 'student_id='.$student_id;
        

            if (empty($fname)) {
                $em  = "First name is required";
                header("Location: ../student-edit.php?error=$em&$data");
                exit; 
            } elseif (empty($lname)) {
                $em  = "Last name is required";
                header("Location: ../student-edit.php?error=$em&$data");
                exit; 
            } elseif (empty($uname)) {
                $em  = "Username is required";
                header("Location: ../student-edit.php?error=$em&$data");
                exit; 
            } elseif (!unameIsUnique($uname, $conn, $student_id)) {
                $em  = "Username is taken! Try another";
                header("Location: ../student-edit.php?error=$em&$data");
                exit; 
            } else {
                $sql  = "UPDATE students SET
                        username=?, fname=?, lname=?
                        WHERE student_id=?"; 
                $stmt = $conn->prepare($sql);
                $stmt->execute([$uname, $fname, $lname, $student_id]);
                $sm = "successfully updated!";
                header("Location: ../student-edit.php?success=$sm&$data");
                exit;
            }
            

    }else {
            $em = "An error occurred";
            header("Location: ../student.php?error=$em");
            exit;
    }

    } else { // close the if statement
        header("Location: ../../logout.php");
        exit;
    }

} else {
    header("Location: ../../logout.php");
    exit;
}
?>
