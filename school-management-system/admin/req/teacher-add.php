<?php
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {


        if (isset($_POST['fname'])&&
            isset($_POST['lname'])&&
            isset($_POST['pass'])&&
            isset($_POST['username'])&&
            isset($_POST['address'])  &&
            isset($_POST['employee_number'])  &&
            isset($_POST['phone_number'])  &&
            isset($_POST['qualification'])  &&
            isset($_POST['email'])  &&
            isset($_POST['gender'])  &&
            isset($_POST['dob'])  &&
            isset($_POST['section'])  &&
            isset($_POST['subjects'])  &&
            isset($_POST['grades'])) {

            include '../../DB_connection.php';
            include "../data/teacher.php";
            
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $pass = $_POST['pass'];
            $uname = $_POST['username'];

            $address = $_POST['address'];
            $employee_number = $_POST['employee_number'];
            $phone_number = $_POST['phone_number'];
            $qualification = $_POST['qualification'];
            $email = $_POST['email'];
            $gender = $_POST['gender'];
            $dob = $_POST['dob'];
            
            $grades = "";
            foreach($_POST['grades'] as $grade) {
                $grades .=$grade;
            } 


            $subjects = "";
            foreach($_POST['subjects'] as $subject) {
                $subjects .=$subject;
            } 

            $sections = "";
            foreach($_POST['section'] as $section) {
                $sections .=$section;
            }



            $data = 'uname='.$uname.'&fname='.$fname.'&lname='.$lname;

            if (empty($fname)) {
                $em  = "First name is required";
                header("Location: ../teacher-add.php?error=$em&$data");
                exit; 
            } elseif (empty($lname)) {
                $em  = "Last name is required";
                header("Location: ../teacher-add.php?error=$em&$data");
                exit; 
            } elseif (empty($uname)) {
                $em  = "Username is required";
                header("Location: ../teacher-add.php?error=$em&$data");
                exit; 
            } elseif (!unameIsUnique($uname, $conn)) {
                $em  = "Username is taken! Try another";
                header("Location: ../teacher-add.php?error=$em&$data");
                exit; 
            }  elseif (empty($pass)) {
                $em  = "Password is required";
                header("Location: ../teacher-add.php?error=$em&$data");
                exit; 
            }  elseif (empty($address)) {
                $em  = "Address is required";
                header("Location: ../teacher-add.php?error=$em&$data");
                exit; 
            }  elseif (empty($employee_number)) {
                $em  = "Employee number is required";
                header("Location: ../teacher-add.php?error=$em&$data");
                exit; 
            }  elseif (empty($phone_number)) {
                $em  = "Phone Number is required";
                header("Location: ../teacher-add.php?error=$em&$data");
                exit; 
            }  elseif (empty($qualification)) {
                $em  = "Qualification is required";
                header("Location: ../teacher-add.php?error=$em&$data");
                exit; 
            }  elseif (empty($email)) {
                $em  = "Email is required";
                header("Location: ../teacher-add.php?error=$em&$data");
                exit; 
            }  elseif (empty($gender)) {
                $em  = "Gender is required";
                header("Location: ../teacher-add.php?error=$em&$data");
                exit; 
            }  elseif (empty($dob)) {
                $em  = "Date of Birth is required";
                header("Location: ../teacher-add.php?error=$em&$data");
                exit; 
            }elseif (empty($pass)) {
                $em  = "Passsword is required";
                header("Location: ../teacher-add.php?error=$em&$data");
                exit; 
            }else {
                // hashing the password
                $pass = password_hash($pass, PASSWORD_DEFAULT);
                $sql  = "INSERT INTO 
                         teachers(username, password, fname, lname, subjects, grades, section, address, employee_number, dob, phone_number, qualification, gender, email)
                         VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)"; 
                $stmt = $conn->prepare($sql);
                $stmt->execute([$uname, $pass, $fname, $lname, $subjects, $grades, $section, $address, $employee_number, $dob, $phone_number, $qualification, $gender, $email]);

                $sm = "New teacher registered successfully";
                header("Location: ../teacher-add.php?success=$sm");
                exit;
            }
            

    }else {
            $em = "An error occurred";
            header("Location: ../teacher-add.php?error=$em");
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
