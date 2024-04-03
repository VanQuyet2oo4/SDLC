<?php
include "db_conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['student_id'])) {
    $studentId = $_POST['student_id'];

    // Prepare SQL statement to delete student
    $sql = "DELETE FROM students WHERE Rollno=$studentId";

    // Execute SQL statement
    if (mysqli_query($conn, $sql)) {
        echo "Student deleted successfully";
    } else {
        echo "Error deleting student: " . mysqli_error($conn);
    }
}
?>
