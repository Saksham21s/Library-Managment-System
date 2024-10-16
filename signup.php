<?php 
session_start();
include('includes/config.php');
error_reporting(0);
if(isset($_POST['signup']))
{
    // Code for student ID
    $count_my_page = ("studentid.txt");
    $hits = file($count_my_page);
    $hits[0]++;
    $fp = fopen($count_my_page , "w");
    fputs($fp , "$hits[0]");
    fclose($fp); 
    $StudentId = $hits[0];   
    $fname = $_POST['fullanme'];
    $mobileno = $_POST['mobileno'];
    $email = $_POST['email']; 
    $password = md5($_POST['password']); 
    $status = 1;
    
    $sql = "INSERT INTO tblstudents(StudentId, FullName, MobileNumber, EmailId, Password, Status) VALUES(:StudentId, :fname, :mobileno, :email, :password, :status)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':StudentId', $StudentId, PDO::PARAM_STR);
    $query->bindParam(':fname', $fname, PDO::PARAM_STR);
    $query->bindParam(':mobileno', $mobileno, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->bindParam(':status', $status, PDO::PARAM_STR);
    $query->execute();
    
    $lastInsertId = $dbh->lastInsertId();
    if($lastInsertId) {
        echo '<script>alert("Your Registration was successful and your student ID is ' . $StudentId . '")</script>';
    } else {
        echo "<script>alert('Something went wrong. Please try again');</script>";
    }
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Online Library Management System | Student Signup</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    
    <style>
        body {
            background-color: #f0f0f0;
            margin: 0;
            font-family: 'Open Sans', sans-serif;
        }

        .content-wrapper {
            background: url("./assets/img/lib3.jpg");
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            margin-top: 2px;
            min-height: calc(100vh - 70px);
            padding-top: 70px;
            box-sizing: border-box;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px; /* Set the maximum width of the form */
            text-align: center;
            position: relative;
        }

        /* Arrow icon for the form */
        .form-icon {
            width: 40px; /* Adjust size as needed */
            height: 40px; /* Adjust size as needed */
            background: url('https://img.icons8.com/?size=100&id=114461&format=png&color=000000') no-repeat center;
            background-size: contain;
            position: absolute;
            top: -20px; /* Position the icon above the form */
            left: calc(50% - 20px); /* Center the icon */
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            font-size: 14px;
            outline: none;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
        }

        .btn {
            padding: 10px 20px;
            border-radius: 30px;
            border: none;
            background: linear-gradient(145deg, #6a11cb, #2575fc);
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease-in-out;
            width: 100%;
        }

        .btn:hover {
            background: linear-gradient(145deg, #2575fc, #6a11cb);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        .help-block {
            font-size: 12px;
            margin-top: 5px;
        }

        .form-container a {
            color: #007bff;
            text-decoration: none;
        }

        .form-container a:hover {
            text-decoration: underline;
        }
    </style>
    
    <script type="text/javascript">
        function valid() {
            if (document.signup.password.value != document.signup.confirmpassword.value) {
                alert("Password and Confirm Password Field do not match!!");
                document.signup.confirmpassword.focus();
                return false;
            }
            return true;
        }
    </script>
    
    <script>
        function checkAvailability() {
            $("#loaderIcon").show();
            jQuery.ajax({
                url: "check_availability.php",
                data: 'emailid=' + $("#emailid").val(),
                type: "POST",
                success: function(data) {
                    $("#user-availability-status").html(data);
                    $("#loaderIcon").hide();
                },
                error: function() {}
            });
        }
    </script>    
</head>
<body>
    <!------MENU SECTION START-->
    <?php include('includes/header.php');?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="form-container">
            <div class="form-icon"></div>
            <div style="color:red;font-family:italic; font-size:22px;"> User Signup Form </div>
            <form name="signup" method="post" onSubmit="return valid();">
                <div class="form-group">
                    <label>Enter Full Name</label>
                    <input class="form-control" type="text" name="fullanme" autocomplete="off" required />
                </div>
                <div class="form-group">
                    <label>Mobile Number:</label>
                    <input class="form-control" type="text" name="mobileno" maxlength="10" autocomplete="off" required />
                </div>
                <div class="form-group">
                    <label>Enter Email</label>
                    <input class="form-control" type="email" name="email" id="emailid" onBlur="checkAvailability()" autocomplete="off" required />
                    <span id="user-availability-status" style="font-size:12px;"></span> 
                </div>
                <div class="form-group">
                    <label>Enter Password</label>
                    <input class="form-control" type="password" name="password" autocomplete="off" required />
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input class="form-control" type="password" name="confirmpassword" autocomplete="off" required />
                </div>
                <button type="submit" name="signup" class="btn">Register Now</button>
            </form>
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/custom.js"></script>
</body>
</html>
