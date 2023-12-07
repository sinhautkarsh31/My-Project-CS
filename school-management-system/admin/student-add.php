<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {

        if ($_SESSION['role'] == 'Admin') {

            include "../DB_connection.php";
            include "data/grade.php";
            $grades = getAllGrades($conn);

            $fname = '';
            $lname = '';
            $uname = '';

            if (isset($_GET['fname'])) $fname = $_GET['fname'];
            if (isset($_GET['lname'])) $lname = $_GET['lname'];
            if (isset($_GET['uname'])) $uname = $_GET['uname'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Add Student</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <?php
        include "inc/navbar.php";

     ?>
     <div class="container mt-5">
        <a href="student.php"
           class="btn btn-dark">Go Back</a>

           <form method="post"
                 class="shadow p-3 mt-5 form-w"
                 action="req/student-add.php">
                <h3>Add New Student</h3><hr>
                <?php if (isset($_GET['error'])) { ?>
                    <div class="alert alert-danger" role="alert">
                      <?=$_GET['error']?>
                    </div>
                <?php } ?>
                <?php if (isset($_GET['success'])) { ?>
                    <div class="alert alert-success" role="alert">
                      <?=$_GET['success']?>
                    </div>
                <?php } ?>
                <div class="mb-3">
                    <label class="form-label">First name</label>
                    <input type="text" 
                           class="form-control"
                           value="<?=$fname?>"
                           name="fname">
                </div>
                <div class="mb-3">
                    <label class="form-label">Last name</label>
                    <input type="text" 
                           class="form-control"
                           value="<?=$lname?>"
                           name="lname">
                </div>
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" 
                           class="form-control"
                           value="<?=$uname?>"
                           name="username">
                </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group mb-3">
                    <input type="text" 
                           class="form-control"
                           name="pass"
                           id="passInput">
                    <button class="btn btn-secondary"
                            id="gBtn">
                            Random</button>
                </div>
                    
            </div>
                <div class="mb-3">
                    <label class="form-label">Grade</label>
                    <div class="row row-cols-5">
                        <?php foreach ($grades as $grade): ?>
                        <div class="col">
                        <input type="radio"
                               name="grades[]"
                               value="<?=$grade['grade_id']?>">
                               
                               <?=$grade['grade_code']?>-<?=$grade['grade']?>
                        </div>
                        <?php endforeach ?>
                    </div>
                    
                </div>
                
                
                <button type="submit" class="btn btn-primary">Add</button>
                </form>
     </div>  

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#navLinks li:nth-child(3) a").addClass('active');
        });

        function makePass(length) {
            var result = '';
            var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var charactersLength = characters.length;
            let counter = 0;
            while (counter < length) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
                counter += 1;
            }
            var passInput = document.getElementById('passInput')
            passInput.value = result;
        }

        var gBtn = document.getElementById('gBtn');
        gBtn.addEventListener('click', function(e){
            e.preventDefault();
            makePass(4);
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