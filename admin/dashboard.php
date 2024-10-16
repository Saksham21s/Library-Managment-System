<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else { ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Online Library Management System | Admin Dash Board</title>
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
            background: #f3f4f6; /* Light grey background */
        }

        .header-line {
            margin-bottom: 20px;
            font-size: 24px;
            color: #4b0082; /* Indigo color */
            font-weight: bold;
        }

        .back-widget-set {
            border-radius: 15px;
            transition: transform 0.2s, box-shadow 0.2s;
            border: 2px solid transparent;
        }

        .back-widget-set:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .alert-success {
            background-color: #d4edda;
            border-color: #28a745; /* Green */
            color: #155724;
        }

        .alert-info {
            background-color: #e7f3fe;
            border-color: #2196f3; /* Blue */
            color: #0c5460;
        }

        .alert-warning {
            background-color: #fff3cd;
            border-color: #ffeeba; /* Yellow */
            color: #856404;
        }

        .alert-danger {
            background-color: #f8d7da;
            border-color: #dc3545; /* Red */
            color: #721c24;
        }

        .alert i {
            color: #4b0082; /* Indigo color */
        }

        .alert h3 {
            font-size: 30px;
            margin: 10px 0;
        }

        .alert p {
            margin-bottom: 0;
            font-weight: bold;
        }

        .carousel-inner img {
            width: 100%;
            height: auto;
            border-radius: 15px;
        }

        @media (max-width: 768px) {
            .col-md-3 {
                margin-bottom: 20px;
            }
        }
    </style>
</head>

<body>
    <!------MENU SECTION START-->
    <?php include('includes/header.php');
    include('bgwork.php'); ?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">ADMIN DASHBOARD</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="alert alert-success back-widget-set text-center">
                        <i class="fa fa-book fa-5x"></i>
                        <?php
                        $sql = "SELECT id from tblbooks ";
                        $query = $dbh->prepare($sql);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                        $listdbooks = $query->rowCount();
                        ?>
                        <h3><?php echo htmlentities($listdbooks); ?></h3>
                        <p>Books Listed</p>
                    </div>
                </div>

                <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="alert alert-info back-widget-set text-center">
                        <i class="fa fa-bars fa-5x"></i>
                        <?php
                        $sql1 = "SELECT id from tblissuedbookdetails ";
                        $query1 = $dbh->prepare($sql1);
                        $query1->execute();
                        $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                        $issuedbooks = $query1->rowCount();
                        ?>
                        <h3><?php echo htmlentities($issuedbooks); ?></h3>
                        <p>Times Book Issued</p>
                    </div>
                </div>

                <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="alert alert-warning back-widget-set text-center">
                        <i class="fa fa-recycle fa-5x"></i>
                        <?php
                        $status = 1;
                        $sql2 = "SELECT id from tblissuedbookdetails where ReturnStatus=:status";
                        $query2 = $dbh->prepare($sql2);
                        $query2->bindParam(':status', $status, PDO::PARAM_STR);
                        $query2->execute();
                        $results2 = $query2->fetchAll(PDO::FETCH_OBJ);
                        $returnedbooks = $query2->rowCount();
                        ?>
                        <h3><?php echo htmlentities($returnedbooks); ?></h3>
                        <p>Times Books Returned</p>
                    </div>
                </div>

                <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="alert alert-danger back-widget-set text-center">
                        <i class="fa fa-users fa-5x"></i>
                        <?php
                        $sql3 = "SELECT id from tblstudents ";
                        $query3 = $dbh->prepare($sql3);
                        $query3->execute();
                        $results3 = $query3->fetchAll(PDO::FETCH_OBJ);
                        $regstds = $query3->rowCount();
                        ?>
                        <h3><?php echo htmlentities($regstds); ?></h3>
                        <p>Registered Users</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="alert alert-success back-widget-set text-center">
                        <i class="fa fa-user fa-5x"></i>
                        <?php
                        $sql4 = "SELECT id from tblauthors ";
                        $query4 = $dbh->prepare($sql4);
                        $query4->execute();
                        $results4 = $query4->fetchAll(PDO::FETCH_OBJ);
                        $listdathrs = $query4->rowCount();
                        ?>
                        <h3><?php echo htmlentities($listdathrs); ?></h3>
                        <p>Publications Listed</p>
                    </div>
                </div>

                <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="alert alert-info back-widget-set text-center">
                        <i class="fa fa-file-archive-o fa-5x"></i>
                        <?php
                        $sql5 = "SELECT id from tblcategory ";
                        $query5 = $dbh->prepare($sql5);
                        $query5->execute();
                        $results5 = $query5->fetchAll(PDO::FETCH_OBJ);
                        $listdcats = $query5->rowCount();
                        ?>
                        <h3><?php echo htmlentities($listdcats); ?></h3>
                        <p>Listed Categories</p>
                    </div>
                </div>

                <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="alert alert-info back-widget-set text-center">
                        <i class="fa fa-money fa-5x"></i>
                        <?php
                        $ret = "SELECT * from tblfine WHERE 1";
                        $query = $dbh->prepare($ret);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                        $fine = 0; // Default fine
                        if ($query->rowCount() > 0) {
                            foreach ($results as $result) {
                                $fine = $result->fine;
                            }
                        }
                        ?>
                        <h3><?php echo htmlentities($fine); ?></h3>
                        <p>Current Fine Per Day</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY  -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>
</body>

</html>
<?php } ?>
