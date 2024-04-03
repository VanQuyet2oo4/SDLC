<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adding Student</title>
</head>
<body>
    <?php
    include "db_conn.php";
    // Add student
    if(isset($_POST['btnAdd'])) {
        $Rollno = $_POST['Rollno'];
        $Sname = $_POST['Sname'];
        $Address = $_POST['Address'];
        $Email = $_POST['Email'];
        
        if($Rollno=="" || $Sname=="" || $Address=="" || $Email=="") {
            echo "(*) is not empty";
        } else {
            $sql = "select Rollno from students where Rollno='$Rollno'";
            $result = mysqli_query($conn,$sql);
            if(mysqli_num_rows($result)==0) {
                $sql = "INSERT INTO students VALUES ('$Rollno', '$Sname', '$Address', '$Email')";
                mysqli_query($conn,$sql);
                header("Location: StudentList.php");
                exit();
            } else {
                echo "Existed student in list";
            }
        }
    }
    ?>

    <form method="post">
        <table align="center" border="0" cellpadding="1" cellspacing="1">
            <caption align="center"><b>Adding Student</b></caption> 
            <tr>
                <td>Rollno</td>
                <td><input type="text" name="Rollno"/>(*)</td>
            </tr>
            <tr>
                <td>Student Name</td>
                <td><input type="text" name="Sname"/>(*)</td>
            </tr>
            <tr>
                <td>Student Address</td>
                <td><input type="text" name="Address"/>(*)</td>
            </tr>
            <tr>
                <td>Student Email</td>
                <td><input type="text" name="Email"/>(*)</td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="submit" value="Add" name="btnAdd"/>
                    <button type="button" onclick="clearInputs()">Cancel</button>
                    <button type="button" onclick="goToStudentList()">Exit</button>
                </td>
            </tr>
        </table>
    </form>

    <script>
        // Function to clear input fields
        function clearInputs() {
            var inputs = document.querySelectorAll('input[type="text"]');
            inputs.forEach(function(input) {
                input.value = ''; // Clear the value of each input field
            });
        }

        // Function to redirect to StudentList page
        function goToStudentList() {
            window.location.href = "StudentList.php";
        }
    </script>
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
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        caption {
            font-size: 1.2em;
            margin-bottom: 10px;
        }

        form {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        input[type="text"], input[type="submit"], input[type="reset"], button {
            width: calc(100% - 10px);
            padding: 10px;
margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"], input[type="reset"], button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover, input[type="reset"]:hover, button:hover {
            background-color: #45a049;
        }
    </style>
</body>
</html>
