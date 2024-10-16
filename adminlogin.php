<?php
session_start();
error_reporting(0);
include('includes/config.php');
if ($_SESSION['alogin'] != '') {
    $_SESSION['alogin'] = '';
}
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $sql = "SELECT UserName, Password FROM admin WHERE UserName=:username and Password=:password";
    $query = $dbh->prepare($sql);
    $query->bindParam(':username', $username, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    if ($query->rowCount() > 0) {
        $_SESSION['alogin'] = $_POST['username'];
        echo "<script type='text/javascript'> document.location ='admin/dashboard.php'; </script>";
    } else {
        echo "<script>alert('Invalid Details');</script>";
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
    <title>Online Library Management System | Admin Login</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

    <style>
        body {
            background-color: #f0f0f0;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .content-wrapper {
            background: url("./assets/img/lib2.jpg");
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
            background: #ffffff;
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            width: 350px;
            text-align: center;
            animation: float 3s infinite alternate;
            position: relative;
        }

        .form-icon {
            width: 80px;
            height: 80px;
            background: url('https://img.icons8.com/?size=100&id=114461&format=png&color=000000') no-repeat center;
            background-size: contain;
            position: absolute;
            top: -40px;
            left: calc(50% - 40px);
            border-radius: 50%;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
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

        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
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
            flex: 1;
            margin: 0 5px;
        }

        .btn.signup {
            color: white;
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

        @keyframes float {
            0% {
                transform: translateY(0);
            }

            100% {
                transform: translateY(-10px);
            }
        }
    </style>
</head>

<body>
    <!------MENU SECTION START-->
    <?php include('includes/header.php'); ?>

    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="form-container">
            <div style="color:red;font-family:italic; font-size:22px;"> Admin Login Form </div>
            <div class="form-icon"></div>
            <form role="form" method="post">
                <div class="form-group">
                    <label>Enter Username</label>
                    <input class="form-control" type="text" name="username" required autocomplete="off" />
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input class="form-control" type="password" name="password" required autocomplete="off" />
                </div>
                <div class="button-container">
                    <button type="submit" name="login" class="btn">LOGIN</button>
                </div>
            </form>
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/custom.js"></script>
</body>

</html>
