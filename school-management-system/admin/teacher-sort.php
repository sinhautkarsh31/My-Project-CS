<?php
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {

        include '../DB_connection.php';
        include "data/teacher.php";

        
        
        // get the sorting option from the user, default to id
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'id';

        // create the SQL query based on the sorting option
        switch ($sort) {
            case 'id':
                $sql = "SELECT * FROM teachers ORDER BY teacher_id";
                break;
            case 'first_name':
                $sql = "SELECT * FROM teachers ORDER BY fname";
                break;
            case 'last_name':
                $sql = "SELECT * FROM teachers ORDER BY lname";
                break;
            case 'username':
                $sql = "SELECT * FROM teachers ORDER BY username";
                break;
            case 'subject':
                $sql = "SELECT * FROM teachers ORDER BY subjects";
                break;
            case 'grade':
                $sql = "SELECT * FROM teachers ORDER BY grades";
                break;
            default:
                $sql = "SELECT * FROM teachers ORDER BY teacher_id";
                break;
        }

        // prepare and execute the SQL query
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // fetch the results as an associative array
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // display the table to the user
        echo "<h1>Teachers</h1>";
        echo "<p>Number of teachers: " . count($results) . "</p>";

        // display the sorting options to the user
        echo "<p>Sort by: ";
        echo "<a href='teacher-sort.php?sort=id'>ID</a> | "; // add a link for sorting by id
        echo "<a href='teacher-sort.php?sort=first_name'>First Name</a> | "; // add a link for sorting by first name
        echo "<a href='teacher-sort.php?sort=last_name'>Last Name</a> | "; // add a link for sorting by last name
        echo "<a href='teacher-sort.php?sort=username'>Username</a> | "; // add a link for sorting by username
        echo "<a href='teacher-sort.php?sort=subject'>Subject</a> | "; // add a link for sorting by subject
        echo "<a href='teacher-sort.php?sort=grade'>Grade</a>"; // add a link for sorting by grade
        echo "</p>";

        // display the results as a table
        echo "<table border='1'>";
        echo "<tr>";
        echo "<th>ID</th>";
        echo "<th>First Name</th>";
        echo "<th>Last Name</th>";
        echo "<th>Username</th>";
        echo "<th>Subject</th>";
        echo "<th>Grade</th>";
        echo "</tr>";
        foreach ($results as $result) {
            echo "<tr>";
            echo "<td>" . $result['teacher_id'] . "</td>";
            echo "<td>" . $result['fname'] . "</td>";
            echo "<td>" . $result['lname'] . "</td>";
            echo "<td>" . $result['username'] . "</td>";
            echo "<td>" . $result['subjects'] . "</td>";
            echo "<td>" . $result['grades'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";

    } else {
        header("Location: ../../logout.php");
        exit;
    }

} else {
    header("Location: ../../logout.php");
    exit;
}
?>
