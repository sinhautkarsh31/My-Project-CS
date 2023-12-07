<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {

        if ($_SESSION['role'] == 'Admin') {
            include "../DB_connection.php";
            include "data/teacher.php";
            include "data/subject.php";
            include "data/grade.php";
            $teachers = getAllTeachers($conn);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Teachers</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <?php
        include "inc/navbar.php";
        if ($teachers != 0) {

     ?>
     <div class="container mt-5">
        <a href="teacher-add.php"
           class="btn btn-dark">Add New Teacher</a>

            <form action="teacher-search.php" 
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

            <form action="teacher-sort.php" method="get" class="mt-3 n-table">
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
                    <th scope="col">Subject</th>
                    <th scope="col">Grade</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 0; foreach ($teachers as $teacher ) { 
                        $i++;  ?>
                    <tr>
                    <th scope="row"><?=$i?></th>
                    <td><?=$teacher['teacher_id']?></td>
                    <td><?=$teacher['fname']?></td>
                    <td><?=$teacher['lname']?></td>
                    <td><?=$teacher['username']?></td>
                    <td>
                        <?php
                            $s ='';
                            $subjects = str_split(trim($teacher['subjects']));
                            foreach ($subjects as $subject) {
                                $s_temp = getSubjectById($subject, $conn);
                                if ($s_temp != 0) 
                                    $s .= $s_temp['subject_code'].', ';
                            }
                            echo $s;
                        ?>
                    </td>
                    <td>
                    <?php
                            $g ='';
                            $grades = str_split(trim($teacher['grades']));
                            foreach ($grades as $grade) {
                                $g_temp = getGradeById($grade, $conn);
                                if ($g_temp != 0) 
                                    $g .= $g_temp['grade_code'].'-' 
                                       .$g_temp['grade'].', ';
                            }
                            echo $g;
                        ?>
                    </td>
                    <td>
                        <a href="teacher-edit.php?teacher_id=<?=$teacher['teacher_id']?>"
                           class="btn btn-warning">Edit</a>
                           <a href="teacher-delete.php?teacher_id=<?=$teacher['teacher_id']?>"
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
            </div>
           <?php } ?>
     </div>  

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#navLinks li:nth-child(2) a").addClass('active');
        });
    </script>

</body>
</html>
<?php 
    }else{
        header("Location: ../login.php");
        exit;
    } 
    

}else{
    header("Location: ../login.php");
    exit;
} 

?>