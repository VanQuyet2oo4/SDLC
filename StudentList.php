<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        caption {
            font-size: 1.2em;
            margin-bottom: 10px;
        }

        button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        /* CSS để loại bỏ gạch chân của các liên kết */
        a {
            text-decoration: none; /* Loại bỏ gạch chân */
        }

        /* Thêm CSS cho phần nút Login và Log out */
        .login-button, .logout-button {
            float: right; /* Đưa nút về phía phải */
            margin-top: 20px; /* Để nút Login cách trên một khoảng */
            margin-right: 10px; /* Để nút Login cách phải một khoảng */
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login-button:hover, .logout-button:hover {
            background-color: #0056b3;
        }

        /* CSS cho hộp thoại xác nhận */
        .confirm-box {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            z-index: 9999;
            text-align: center; /* căn giữa nội dung */
        }

        .confirm-box h2 {
            margin-top: 0;
        }

        .confirm-box button {
            display: inline-block; /* Hiển thị nút trên cùng một dòng */
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .confirm-box button:hover {
            background-color: #0056b3;
        }.confirm-box button:first-child {
            margin-right: auto; /* Đẩy nút "Yes" về bên trái */
        }

        .confirm-box button:last-child {
            margin-left: auto; /* Đẩy nút "No" về bên phải */
        }
    </style>
</head>
<body>
    <!-- PHP code for database connection -->
    <?php
    include "db_conn.php";

    // Kiểm tra nếu có yêu cầu xóa
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'delete') {
        $studentId = $_POST['student_id'];
        // Thực hiện xóa sinh viên từ cơ sở dữ liệu
        $sql = "DELETE FROM students WHERE Rollno = $studentId";
        mysqli_query($conn, $sql);
        exit(); // Dừng việc xử lý để tránh tải lại trang
    }

    // Kiểm tra nếu có yêu cầu chỉnh sửa
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'edit') {
        // Thực hiện các bước cần thiết để chỉnh sửa sinh viên
        exit(); // Dừng việc xử lý để tránh tải lại trang
    }

    $sql = "select * from students";
    $result = mysqli_query($conn,$sql);
    ?>

   <!-- HTML code for logout button -->
<button class="logout-button" onclick="showConfirmBox()">Log out</button>

<!-- HTML code for confirm box -->
<div class="confirm-box" id="confirmBox">
    <h2>Do you want to log out?</h2>
    <button id="confirmYes" onclick="logout()">Yes</button>
    <button id="confirmNo" onclick="closeConfirmBox()">No</button>
</div>

<!-- JavaScript code -->
<script>
    // Function to show confirm box for logout
    function showConfirmBox() {
        var confirmBox = document.getElementById("confirmBox");
        confirmBox.style.display = "block";
    }

    // Function to close confirm box
    function closeConfirmBox() {
        var confirmBox = document.getElementById("confirmBox");
        confirmBox.style.display = "none";
    }

    // Function to logout
    function logout() {
        window.location.href = "login.php";
    }
</script>

    <!-- HTML code for student list table -->
    <table align="center" border="1px" cellpadding="0" cellspacing="0">
        <caption align="center">Student List</caption>
        <tr>
            <th>Rollno</th>
            <th>Student Fullname</th>
            <th>Address</th>
            <th>Email</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>

        <!-- PHP code for fetching student data -->
        <?php
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {        
        ?>
        <tr id="student_<?php echo $row['Rollno']; ?>">
            <td><?php echo $row['Rollno']; ?></td>
            <td><?php echo $row['Sname']; ?></td>
            <td><?php echo $row['Address']; ?></td>
            <td><?php echo $row['Email']; ?></td>
            <!-- Edit and Delete buttons with onclick events -->
            <td><a href="#" class="edit" onclick="editStudent(<?php echo $row['Rollno']; ?>)">Edit</a></td>
            <td><a href="#" class="delete" onclick="deleteStudent(<?php echo $row['Rollno']; ?>)">Delete</a></td>
        </tr>
        <?php
        }
        ?>
    </table>

    <!-- HTML code for Add button -->
    <form method="post" action="AddingStudent.php">
        <button type="submit" class="add-button">Add</button>
    </form>

    <!-- PHP code to update student data -->
    <?php
    // Check if data is sent via POST method
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve data sent from client-side
        $studentId = $_POST['student_id'];
        $sname = $_POST['sname'];
        $address = $_POST['address'];
        $email = $_POST['email'];// Prepare SQL statement to update student data
        $sql = "UPDATE students SET Sname='$sname', Address='$address', Email='$email' WHERE Rollno=$studentId";

        // Execute SQL statement
        if (mysqli_query($conn, $sql)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }
    ?>

    <!-- JavaScript code -->
    <script>
        // Function to show confirm box
        function showConfirmBox() {
            var confirmBox = document.getElementById("confirmBox");
            confirmBox.style.display = "block";
        }

        // Function to edit student
        function editStudent(studentId) {
            var row = document.getElementById('student_' + studentId);
            var cells = row.getElementsByTagName('td');
            
            // Enable editing for each cell
            for (var i = 1; i < cells.length - 2; i++) {
                var text = cells[i].innerText;
                cells[i].innerHTML = '<input type="text" value="' + text + '">';
            }

            // Replace Edit button with Save button
            var editLink = cells[cells.length - 2].getElementsByTagName('a')[0];
            editLink.innerHTML = 'Save';
            editLink.onclick = function() { saveChanges(studentId); };
        }

        // Function to save changes
        function saveChanges(studentId) {
            var row = document.getElementById('student_' + studentId);
            var cells = row.getElementsByTagName('td');

            // Gather updated data
            var updatedData = {};
            updatedData['Rollno'] = cells[0].innerText;
            updatedData['Sname'] = cells[1].getElementsByTagName('input')[0].value;
            updatedData['Address'] = cells[2].getElementsByTagName('input')[0].value;
            updatedData['Email'] = cells[3].getElementsByTagName('input')[0].value;

            // Send data to server using AJAX
            var xhr = new XMLHttpRequest();
            xhr.open("POST", window.location.href, true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    console.log(xhr.responseText);
                    // Optionally, you can update UI based on the response
                }
            };
            xhr.send("student_id=" + studentId + "&sname=" + updatedData['Sname'] + "&address=" + updatedData['Address'] + "&email=" + updatedData['Email']);

            // Restore original UI
            for (var i = 1; i < cells.length - 2; i++) {
                var input = cells[i].getElementsByTagName('input')[0];
                var text = input.value;
                cells[i].innerHTML = text;
            }

            // Replace Save button with Edit buttonvar editLink = cells[cells.length - 2].getElementsByTagName('a')[0];
            editLink.innerHTML = 'Edit';
            editLink.onclick = function() { editStudent(studentId); };
        }
 // Function to delete student
 function deleteStudent(studentId) {
            if (confirm("Are you sure you want to delete this student?")) {
                // Gửi yêu cầu xóa thông qua Ajax
                var xhr = new XMLHttpRequest();
                xhr.open("POST", window.location.href, true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                        // Xóa hàng tương ứng từ bảng HTML
                        var row = document.getElementById('student_' + studentId);
                        row.parentNode.removeChild(row);
                    }
                };
                xhr.send("action=delete&student_id=" + studentId);
            }
        }


    </script>
</body>
</html>