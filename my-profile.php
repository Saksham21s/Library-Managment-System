<?php 
session_start();
include('includes/config.php');
error_reporting(0);
if(strlen($_SESSION['login'])==0) {   
    header('location:index.php');
} else { 
    if(isset($_POST['update'])) {    
        $sid = $_SESSION['stdid'];  
        $fname = $_POST['fullanme'];
        $mobileno = $_POST['mobileno'];

        $sql = "UPDATE tblstudents SET FullName=:fname, MobileNumber=:mobileno WHERE StudentId=:sid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':sid', $sid, PDO::PARAM_STR);
        $query->bindParam(':fname', $fname, PDO::PARAM_STR);
        $query->bindParam(':mobileno', $mobileno, PDO::PARAM_STR);
        $query->execute();

        echo '<script>alert("Your profile has been updated")</script>';
    }
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Online Library Management System | My Profile</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' /> 

    <style>
        body {
            background-color: #f0f4f8;
            font-family: 'Open Sans', sans-serif;
            margin: 0;
            padding: 0;
            transition: background-color 0.3s;
        }
        .content-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .panel {
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
            width: 90%;
            max-width: 500px;
            margin: auto;
        }
        .panel-heading {
            background-color: #007bff;
            color: #ffffff;
            padding: 15px;
            border-radius: 10px 10px 0 0;
            text-align: center;
            font-size: 24px;
        }
        .panel-body {
            padding: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .form-row > div {
            width: 48%;
        }
        .form-control {
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s;
        }
        .form-control:focus {
            border-color: #007bff;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            border-radius: 5px;
            display: block;
            margin: 20px auto 0;
        }
        .status-active {
            color: green;
            font-weight: bold;
        }
        .status-blocked {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <?php include('includes/header.php');?>
    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">My Profile</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9 col-md-offset-1">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           My Profile
                        </div>
                        <div class="panel-body">
                            <form name="signup" method="post">
                                <?php 
                                $sid = $_SESSION['stdid'];
                                $sql = "SELECT StudentId, FullName, EmailId, MobileNumber, RegDate, UpdationDate, Status FROM tblstudents WHERE StudentId=:sid";
                                $query = $dbh->prepare($sql);
                                $query->bindParam(':sid', $sid, PDO::PARAM_STR);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                if ($query->rowCount() > 0) {
                                    foreach ($results as $result) { 
                                ?>  
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Student ID:</label>
                                        <p><?php echo htmlentities($result->StudentId); ?></p>
                                    </div>
                                    <div class="form-group">
                                        <label>Reg Date:</label>
                                        <p><?php echo htmlentities($result->RegDate); ?></p>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Last Updation Date:</label>
                                        <p><?php echo htmlentities($result->UpdationDate ? $result->UpdationDate : "N/A"); ?></p>
                                    </div>
                                    <div class="form-group">
                                        <label>Profile Status:</label>
                                        <?php if ($result->Status == 1) { ?>
                                            <span class="status-active">Active</span>
                                        <?php } else { ?>
                                            <span class="status-blocked">Blocked</span>
                                        <?php } ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Enter Full Name</label>
                                    <input class="form-control" type="text" name="fullanme" value="<?php echo htmlentities($result->FullName); ?>" autocomplete="off" required />
                                </div>

                                <div class="form-group">
                                    <label>Mobile Number:</label>
                                    <input class="form-control" type="text" name="mobileno" maxlength="10" value="<?php echo htmlentities($result->MobileNumber); ?>" autocomplete="off" required />
                                </div>
                                                
                                <div class="form-group">
                                    <label>Enter Email</label>
                                    <input class="form-control" type="email" name="email" id="emailid" value="<?php echo htmlentities($result->EmailId); ?>" autocomplete="off" required readonly />
                                </div>
                                <?php }} ?>
                              
                                <button type="submit" name="update" class="btn btn-primary" id="submit">Update Now</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>
