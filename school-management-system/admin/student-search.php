<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {

        if ($_SESSION['role'] == 'Admin') {
            if (isset($_POST['searchKey'])) {
            
            $search_key = $_POST['searchKey'];
            include "../DB_connection.php";
            include "data/student.php";
            include "data/grade.php";
            $students = searchStudents($search_key, $conn);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Search Students</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <?php
        include "inc/navbar.php";
        if ($students != 0) {

     ?>
     <div class="container mt-5">
        <a href="student-add.php"
           class="btn btn-dark">Add New Student</a>

           <form action="student-search.php" 
                  class="mt-3 n-table"
                  method="post">
                <div class="input-group mb-3">
                            <input type="text" 
                                class="form-control"
                                name="searchKey"
                                placeholder="Search...">
                            <button class="btn btn-primary">
                            <i class="fas fa-search" 
                               aria-hidden="true"></i>
                        </button>
                </div>
            </form>

           <form action="student-sort.php" method="get" class="mt-3 n-table">
                <div class="input-group mb-3">
                    <select class="form-select" name="sort">
                    <option value="id">ID</option>
                    <option value="first_name">First Name</option>
                    option value="last_name">Last Name</option>
                    <option value="username">Username</option>
                    <option value="subject">Subject</option>
                    <option value="grade">Grade</option>
                    </select>
                    <button class="btn btn-primary">
                    <i class="fas fa-sort-amount-down-alt"  aria-hidden="true"></i>
                    </button>
                </div>
            </form>


           <?php if (isset($_GET['error'])) { ?>
                <div class="alert alert-danger mt-3 n-table" 
                     role="alert">
                <?=$_GET['error']?>
                </div>
            <?php } ?>

            <?php if (isset($_GET['success'])) { ?>
                <div class="alert alert-info mt-3 n-table" 
                     role="alert">
                <?=$_GET['success']?>
                </div>
            <?php } ?>

           <div class="table-responsive">
           <table class="table table-bordered mt-3 n-table">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">ID</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Username</th>
                    <th scope="col">Grade</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 0; foreach ($students as $student ) { 
                        $i++;  ?>
                    <tr>
                    <th scope="row"><?=$i?></th>
                    <td><?=$student['student_id']?></td>
                    <td><?=$student['fname']?></td>
                    <td><?=$student['lname']?></td>
                    <td><?=$student['username']?></td>
                    <td>
                    <?php
                            $grade = $student['grade'];
                            $g_temp = getGradeById($grade, $conn);
                            if ($g_temp != 0) {

                                echo $g_temp['grade_code'].'-' 
                                       .$g_temp['grade'];
                            }
                        ?>
                    </td>
                    <td>
                        <a href="student-edit.php?student_id=<?=$student['student_id']?>"
                           class="btn btn-warning">Edit</a>
                           <a href="student-delete.php?student_id=<?=$student['student_id']?>"
                           class="btn btn-danger">Delete</a>
                    </td>
                    </tr>
                    <?php } ?>
                </tbody>
                </table>
           </div>
           <?php }else{ ?>
            <div class="alert alert-info .w-450 m-5" 
                 role="alert">
                Empty!
                <a href="student.php"
                   class="btn btn-dark">Go Back</a>
            </div>
           <?php } ?>
     </div>  

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#navLinks li:nth-child(3) a").addClass('active');
        });
    </script>

</body>
</html>
<?php 
}else{
    header("Location: student.php");
    exit;
} 
    }else{
        header("Location: ../login.php");
        exit;
    } 
    

}else{
    header("Location: ../login.php");
    exit;
} 

?>