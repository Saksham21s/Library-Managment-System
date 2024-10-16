<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {   
    header('location:index.php');
} else { 
    if (isset($_POST['create'])) {
        $category = $_POST['category'];
        $status = $_POST['status'];

        // Check if the category already exists
        $sql = "SELECT * FROM tblcategory WHERE CategoryName=:CategoryName";
        $query = $dbh->prepare($sql);
        $query->bindParam(':CategoryName', $category, PDO::PARAM_STR);
        $query->execute();
        
        if ($query->rowCount() > 0) {
            $_SESSION['msg'] = "This category is already added";
            header('location:manage-categories.php');
        } else {
            // Insert the new category
            $sql = "INSERT INTO tblcategory(CategoryName, Status) VALUES(:category, :status)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':category', $category, PDO::PARAM_STR);
            $query->bindParam(':status', $status, PDO::PARAM_STR);
            $query->execute();
            $lastInsertId = $dbh->lastInsertId();

            if ($lastInsertId) {
                $_SESSION['msg'] = "Category listed successfully";
                header('location:manage-categories.php');
            } else {
                $_SESSION['error'] = "Something went wrong. Please try again";
                header('location:manage-categories.php');
            }
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
    <title>Online Library Management System | Add Categories</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <style>
        body {
            background-color: #f8f9fa; /* Light background for better contrast */
            font-family: 'Open Sans', sans-serif;
        }
        .header-line {
            margin: 20px 0;
            font-size: 24px; /* Increased font size for emphasis */
            color: #343a40; /* Dark grey */
            font-weight: bold;
            text-align: center;
        }
        .panel {
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* Subtle shadow */
            margin-top: 20px;
        }
        .panel-heading {
            background-color: #007bff; /* Bootstrap primary color */
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
            transition: background-color 0.3s, transform 0.2s; /* Added transition effect */
        }
        .btn-info:hover {
            background-color: #0056b3; /* Darker shade */
            transform: scale(1.05); /* Slightly scale up on hover */
        }
    </style>
</head>
<body>
    <!-- MENU SECTION START-->
    <?php include('includes/header.php'); ?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">Add Category</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Category Info
                        </div>
                        <div class="panel-body">
                            <form role="form" method="post">
                                <div class="form-group">
                                    <label>Category Name</label>
                                    <input class="form-control" type="text" name="category" autocomplete="off" required />
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="status" value="1" checked="checked"> Active
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="status" value="0"> Inactive
                                        </label>
                                    </div>
                                </div>
                                <button type="submit" name="create" class="btn btn-info">Create</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE LOADING TIME -->
    <!-- CORE JQUERY -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>
