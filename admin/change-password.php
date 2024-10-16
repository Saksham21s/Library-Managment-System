<?php
session_start();
include('includes/config.php');
error_reporting(0);
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['change'])) {
        $password = md5($_POST['password']);
        $newpassword = md5($_POST['newpassword']);
        $username = $_SESSION['alogin'];
        $sql = "SELECT Password FROM admin WHERE UserName=:username AND Password=:password";
        $query = $dbh->prepare($sql);
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            $con = "UPDATE admin SET Password=:newpassword WHERE UserName=:username";
            $chngpwd1 = $dbh->prepare($con);
            $chngpwd1->bindParam(':username', $username, PDO::PARAM_STR);
            $chngpwd1->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
            $chngpwd1->execute();
            $msg = "Your Password has been successfully changed";
        } else {
            $error = "Your current password is incorrect";
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
    <title>Online Library Management System | Change Password</title>
    <!-- BOOTSTRAP CORE STYLE -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <style>
        body {
            background-color: #f4f7fa; /* Light background for better contrast */
            font-family: 'Open Sans', sans-serif;
        }

        .header-line {
            margin: 20px 0;
            font-size: 26px; /* Increased font size for emphasis */
            color: #343a40; /* Dark grey */
            font-weight: bold;
            text-align: center;
        }

        .panel {
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* More pronounced shadow */
            margin-top: 0px;
            background-color: #ffffff; /* White background for panels */
        }

        .panel-heading {
            background-color: #6c757d; /* Slightly darker grey */
            color: white;
            text-align: center;
            font-size: 22px; /* Slightly larger font */
            border-radius: 10px 10px 0 0;
        }

        .form-control {
            border-radius: 5px;
            border: 1px solid #ced4da; /* Light grey border */
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075); /* Subtle inset shadow */
        }

        .form-control:focus {
            border-color: #007bff; /* Bootstrap primary color */
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25); /* Highlight on focus */
        }

        .btn-info {
            background-color: #007bff; /* Bootstrap primary color */
            border-color: #007bff;
            border-radius: 5px;
            transition: background-color 0.3s, transform 0.2s; /* Added transform effect */
        }

        .btn-info:hover {
            background-color: #0056b3; /* Darker shade */
            transform: scale(1.05); /* Slightly scale up on hover */
        }

        .errorWrap,
        .succWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            border-radius: 5px;
            color: #fff;
            font-weight: bold;
            text-align: center; /* Center align text */
        }

        .errorWrap {
            background: #dc3545; /* Red */
        }

        .succWrap {
            background: #28a745; /* Green */
        }

        @media (max-width: 768px) {
            .col-md-6 {
                margin-bottom: 20px;
            }
        }
    </style>
</head>

<script type="text/javascript">
    function valid() {
        if (document.chngpwd.newpassword.value != document.chngpwd.confirmpassword.value) {
            alert("New Password and Confirm Password fields do not match!");
            document.chngpwd.confirmpassword.focus();
            return false;
        }
        return true;
    }
</script>

<body>
    <!-- MENU SECTION START-->
    <?php include('includes/header.php'); ?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">User Change Password</h4>
                </div>
            </div>
            <?php if ($error) { ?>
                <div class="errorWrap"><strong>ERROR</strong>: <?php echo htmlentities($error); ?></div>
            <?php } else if ($msg) { ?>
                <div class="succWrap"><strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?></div>
            <?php } ?>
            <!-- CHANGE PASSWORD PANEL START -->
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Change Password
                        </div>
                        <div class="panel-body">
                            <form role="form" method="post" onSubmit="return valid();" name="chngpwd">
                                <div class="form-group">
                                    <label>Current Password</label>
                                    <input class="form-control" type="password" name="password" autocomplete="off" required />
                                </div>
                                <div class="form-group">
                                    <label>New Password</label>
                                    <input class="form-control" type="password" name="newpassword" autocomplete="off" required />
                                </div>
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input class="form-control" type="password" name="confirmpassword" autocomplete="off" required />
                                </div>
                                <button type="submit" name="change" class="btn btn-info">Change</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- CHANGE PASSWORD PANEL END -->
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
</body>

</html>
<?php } ?>
