<?php
session_start();
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['alogin']) == 0) {   
    header('location:index.php');
} else { 

    if(isset($_POST['add'])) {
        $bookname = $_POST['bookname'];
        $category = $_POST['category'];
        $author = $_POST['author'];
        $isbn = $_POST['isbn'];
        $price = $_POST['price'];
        $copies = $_POST['copies'];

        $sql = "INSERT INTO tblbooks(BookName, CatId, AuthorId, ISBNNumber, BookPrice, Copies) VALUES(:bookname, :category, :author, :isbn, :price, :copies)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':bookname', $bookname, PDO::PARAM_STR);
        $query->bindParam(':category', $category, PDO::PARAM_STR);
        $query->bindParam(':author', $author, PDO::PARAM_STR);
        $query->bindParam(':isbn', $isbn, PDO::PARAM_STR);
        $query->bindParam(':price', $price, PDO::PARAM_STR);
        $query->bindParam(':copies', $copies, PDO::PARAM_STR);
        $query->execute();

        $lastInsertId = $dbh->lastInsertId();
        if($lastInsertId) {
            $_SESSION['msg'] = "Book Listed successfully";
            header('location:manage-books.php');
        } else {
            $_SESSION['error'] = "Something went wrong. Please try again";
            header('location:manage-books.php');
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Online Library Management System | Add Book</title>
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
            background: linear-gradient(to right, #ced4da;); /* Gradient background */
            font-family: 'Open Sans', sans-serif;
            color: #333;
        }

        .header-line {
            margin: 20px 0;
            color:  #343a40;
            text-align: center;
            font-size: 28px;
            text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.3);
        }

        .panel {
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            background-color: rgba(255, 255, 255, 0.9);
        }

        .panel-heading {
            background-color: #343a40;
            color: white;
            text-align: center;
            font-size: 24px;
            border-radius: 15px 15px 0 0;
            padding: 15px 0;
        }

        .form-control {
            border-radius: 10px;
            border: 1px solid #ced4da;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: #007bff; /* Bootstrap primary color */
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .btn-info {
            background-color: #ced4da;
            border-color: #007bff;
            border-radius: 10px;
            transition: background-color 0.3s, transform 0.3s;
        }

        .btn-info:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        .errorWrap,
        .succWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            border-radius: 5px;
            color: #fff;
            font-weight: bold;
            transition: transform 0.3s;
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

<body>
    <!-- MENU SECTION START-->
    <?php include('includes/header.php');?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">Add Book</h4>
                </div>
            </div>
            <?php if ($_SESSION['error']) { ?>
                <div class="errorWrap"><strong>ERROR</strong>: <?php echo htmlentities($_SESSION['error']); unset($_SESSION['error']); ?></div>
            <?php } else if ($_SESSION['msg']) { ?>
                <div class="succWrap"><strong>SUCCESS</strong>: <?php echo htmlentities($_SESSION['msg']); unset($_SESSION['msg']); ?></div>
            <?php } ?>
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <div class="panel panel-info">
                        <div class="panel-heading">Book Info</div>
                        <div class="panel-body">
                            <form role="form" method="post">
                                <div class="form-group">
                                    <label>Book Name<span style="color:red;">*</span></label>
                                    <input class="form-control" type="text" name="bookname" autocomplete="off" required />
                                </div>
                                <div class="form-group">
                                    <label>Category<span style="color:red;">*</span></label>
                                    <select class="form-control" name="category" required="required">
                                        <option value="">Select Category</option>
                                        <?php 
                                        $status = 1;
                                        $sql = "SELECT * FROM tblcategory WHERE Status = :status";
                                        $query = $dbh->prepare($sql);
                                        $query->bindParam(':status', $status, PDO::PARAM_STR);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        if($query->rowCount() > 0) {
                                            foreach($results as $result) { ?>  
                                                <option value="<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->CategoryName);?></option>
                                        <?php }} ?> 
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Publication<span style="color:red;">*</span></label>
                                    <select class="form-control" name="author" required="required">
                                        <option value="">Select Publication</option>
                                        <?php 
                                        $sql = "SELECT * FROM tblauthors";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        if($query->rowCount() > 0) {
                                            foreach($results as $result) { ?>  
                                                <option value="<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->AuthorName);?></option>
                                        <?php }} ?> 
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>ISBN Number<span style="color:red;">*</span></label>
                                    <input class="form-control" type="text" name="isbn" required="required" autocomplete="off" />
                                    <p class="help-block">An ISBN is an International Standard Book Number. ISBN must be unique.</p>
                                </div>
                                <div class="form-group">
                                    <label>No of Copies<span style="color:red;">*</span></label>
                                    <input class="form-control" type="text" name="copies" autocomplete="off" required="required" />
                                </div>
                                <div class="form-group">
                                    <label>Price<span style="color:red;">*</span></label>
                                    <input class="form-control" type="text" name="price" autocomplete="off" required="required" />
                                </div>
                                <button type="submit" name="add" class="btn btn-info">Add</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>
