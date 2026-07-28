<?php
session_start();
error_reporting(0);

include('includes/dbconnection.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';
require '../PHPMailer-master/src/Exception.php';

if (strlen($_SESSION['crmsuid'] == 0)) {

    header('location:logout.php');

} else {

    $uid = $_SESSION['crmsuid'];

    $checkSql = "SELECT COUNT(*)
                 FROM tblcomplaint
                 WHERE UserID=:uid
                 AND Status='Approved'";

    $checkQuery = $dbh->prepare($checkSql);

    $checkQuery->bindParam(':uid', $uid, PDO::PARAM_STR);

    $checkQuery->execute();

    $approvedComplaints = $checkQuery->fetchColumn();

    if ($approvedComplaints == 0) {

        echo "<script>
                alert('You can only apply for FIR after one of your complaints is accepted by police.');
              </script>";

        echo "<script>
                window.location.href='complaint-form.php';
              </script>";

        exit;
    }

    if (isset($_POST['submit'])) {

        $uid = $_SESSION['crmsuid'];

        $polsta = $_POST['policestation'];

        $pdata = explode(",", $polsta);

        $psid = $pdata[0];
        $psname = $pdata[1];

        $crimetype = $_POST['crimetype'];
        $nofaccused = $_POST['nofaccused'];
        $name = $_POST['name'];
        $parentage = $_POST['parentage'];
        $connum = $_POST['connum'];
        $adress = $_POST['adress'];
        $relaccused = $_POST['relaccused'];
        $purpose = $_POST['purpose'];

        $firno = mt_rand(100000000, 999999999);

        $sql = "INSERT INTO tblfir
                (
                    FIRNo,
                    UserID,
                    PoliceStationId,
                    PoliceStation,
                    CrimeType,
                    NameAccused,
                    NameApplicants,
                    ParentageApplicant,
                    ContactNumber,
                    Address,
                    RelationAccused,
                    PurposeofFIR
                )
                VALUES
                (
                    :firno,
                    :uid,
                    :psid,
                    :polsta,
                    :crimetype,
                    :nofaccused,
                    :name,
                    :parentage,
                    :connum,
                    :adress,
                    :relaccused,
                    :purpose
                )";

        $query = $dbh->prepare($sql);

        $query->bindParam(':firno', $firno, PDO::PARAM_STR);
        $query->bindParam(':uid', $uid, PDO::PARAM_STR);
        $query->bindParam(':psid', $psid, PDO::PARAM_STR);
        $query->bindParam(':polsta', $psname, PDO::PARAM_STR);
        $query->bindParam(':crimetype', $crimetype, PDO::PARAM_STR);
        $query->bindParam(':nofaccused', $nofaccused, PDO::PARAM_STR);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':parentage', $parentage, PDO::PARAM_STR);
        $query->bindParam(':connum', $connum, PDO::PARAM_STR);
        $query->bindParam(':adress', $adress, PDO::PARAM_STR);
        $query->bindParam(':relaccused', $relaccused, PDO::PARAM_STR);
        $query->bindParam(':purpose', $purpose, PDO::PARAM_STR);

        $query->execute();

        $LastInsertId = $dbh->lastInsertId();

        if ($LastInsertId > 0) {

            $mail = new PHPMailer(true);

            try {

                $mail->isSMTP();

                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;

                $mail->Username = 'crmssystem5@gmail.com';
                $mail->Password = 'ezcu eooc ipar rbos';

                $mail->SMTPSecure = 'tls';
                $mail->SMTPAutoTLS = true;
                $mail->Port = 587;

                $mail->CharSet = 'UTF-8';

                $mail->SMTPOptions = [
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true,
                    ],
                ];

                $mail->setFrom(
                    'crmssystem5@gmail.com',
                    'Crime Management System'
                );

                // Fetch user email from DB

                $userEmail = "";

                $sqlUser = "SELECT Email
                            FROM tbluser
                            WHERE ID=:uid";

                $queryUser = $dbh->prepare($sqlUser);

                $queryUser->bindParam(':uid', $uid, PDO::PARAM_STR);

                $queryUser->execute();

                $resultUser = $queryUser->fetch(PDO::FETCH_OBJ);

                if ($resultUser) {

                    $userEmail = $resultUser->Email;
                }

                if (!empty($userEmail)) {

                    $mail->addAddress($userEmail);

                    $mail->isHTML(true);

                    $mail->Subject = 'FIR Registered Successfully';

                    $mail->Body = "
                        <h3>FIR Submitted Successfully</h3>

                        <p>
                            Your FIR Number:
                            <b>$firno</b>
                        </p>

                        <p>
                            We will contact you soon.
                        </p>
                    ";

                    $mail->send();
                }

            } catch (Exception $e) {

                // If email sending fails,
                // still keep FIR submission successful.
            }

        } else {

            echo '<script>
                    alert("Something Went Wrong. Please try again")
                  </script>';
        }
    }
}
?>

<!DOCTYPE html>
<html class="fixed">

<head>

    <title>
        Crime Record Management System | FIR Form
    </title>

    <!-- Web Fonts -->

    <link
        href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light"
        rel="stylesheet"
        type="text/css"
    >

    <!-- Vendor CSS -->

    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.css" />

    <link rel="stylesheet" href="../assets/vendor/font-awesome/css/font-awesome.css" />

    <link rel="stylesheet" href="../assets/vendor/magnific-popup/magnific-popup.css" />

    <link rel="stylesheet" href="../assets/vendor/bootstrap-datepicker/css/datepicker3.css" />

    <link rel="stylesheet" href="../assets/stylesheets/theme.css" />

    <link rel="stylesheet" href="../assets/stylesheets/skins/default.css" />

    <link rel="stylesheet" href="../assets/stylesheets/theme-custom.css">

    <script src="../assets/vendor/modernizr/modernizr.js"></script>

</head>

<body>

<section class="body">

    <!-- Header -->

    <?php include_once('includes/header.php'); ?>

    <div class="inner-wrapper">

        <!-- Sidebar -->

        <?php include_once('includes/sidebar.php'); ?>

        <section role="main" class="content-body">

            <header class="page-header">

                <h2>FIR Form</h2>

                <div class="right-wrapper pull-right">

                    <ol class="breadcrumbs">

                        <li>
                            <a href="dashboard.php">
                                <i class="fa fa-home"></i>
                            </a>
                        </li>

                        <li>
                            <span>Add</span>
                        </li>

                        <li>
                            <span>FIR Form</span>
                        </li>

                    </ol>

                    <a
                        class="sidebar-right-toggle"
                        data-open="sidebar-right"
                    >
                        <i class="fa fa-chevron-left"></i>
                    </a>

                </div>

            </header>

            <!-- Page Start -->

            <div class="row">

                <div class="col-md-12">

                    <form class="form-horizontal" method="post">

                        <section class="panel">

                            <header class="panel-heading">

                                <h2 class="panel-title">
                                    FIR Form
                                </h2>

                            </header>

                            <div class="panel-body">

                                <div class="validation-message">
                                    <ul></ul>
                                </div>

                                <!-- Police Station -->

                                <div class="form-group">

                                    <label class="col-sm-3 control-label">
                                        Police Station
                                        <span class="required">*</span>
                                    </label>

                                    <div class="col-sm-9">

                                        <select
                                            class="form-control"
                                            name="policestation"
                                            required="true"
                                        >

                                            <option value="">
                                                Select Police Station
                                            </option>

                                            <?php

                                            $sql2 = "SELECT * FROM tblpolicestation";

                                            $query2 = $dbh->prepare($sql2);

                                            $query2->execute();

                                            $result2 = $query2->fetchAll(PDO::FETCH_OBJ);

                                            foreach ($result2 as $row) {

                                            ?>

                                                <option value="<?php echo htmlentities($row->id . ',' . $row->PoliceStationName); ?>">

                                                    <?php echo htmlentities($row->PoliceStationName); ?>

                                                    -
                                                    (
                                                    <?php echo htmlentities($row->PoliceStationCode); ?>
                                                    )

                                                </option>

                                            <?php } ?>

                                        </select>

                                    </div>

                                </div>

                                <!-- Crime Type -->

                                <div class="form-group">

                                    <label class="col-sm-3 control-label">
                                        Crime Type
                                        <span class="required">*</span>
                                    </label>

                                    <div class="col-sm-9">

                                        <select
                                            class="form-control"
                                            name="crimetype"
                                            required="true"
                                        >

                                            <option value="">
                                                Choose Crime Type
                                            </option>

                                            <?php

                                            $sql2 = "SELECT * FROM tblcategory";

                                            $query2 = $dbh->prepare($sql2);

                                            $query2->execute();

                                            $result2 = $query2->fetchAll(PDO::FETCH_OBJ);

                                            foreach ($result2 as $row) {

                                            ?>

                                                <option value="<?php echo htmlentities($row->CategoryName); ?>">

                                                    <?php echo htmlentities($row->CategoryName); ?>

                                                </option>

                                            <?php } ?>

                                        </select>

                                    </div>

                                </div>

                                <!-- Name of Accused -->

                                <div class="form-group">

                                    <label class="col-sm-3 control-label">
                                        Name of Accused
                                        <span class="required">*</span>
                                    </label>

                                    <div class="col-sm-9">

                                        <input
                                            type="text"
                                            class="form-control"
                                            name="nofaccused"
                                            required="true"
                                        >

                                    </div>

                                </div>

                                <!-- Applicant Details -->

                                <p
                                    style="
                                        font-size:18px;
                                        color:red;
                                        padding-left:10px;
                                    "
                                >
                                    Applicant's Detail (Victim)
                                </p>

                                <!-- Name -->

                                <div class="form-group">

                                    <label class="col-sm-3 control-label">
                                        Name
                                        <span class="required">*</span>
                                    </label>

                                    <div class="col-sm-9">

                                        <input
                                            type="text"
                                            class="form-control"
                                            name="name"
                                            required="true"
                                        >

                                    </div>

                                </div>

                                <!-- Parentage -->

                                <div class="form-group">

                                    <label class="col-sm-3 control-label">
                                        Parentage
                                        <span class="required">*</span>
                                    </label>

                                    <div class="col-sm-9">

                                        <input
                                            type="text"
                                            class="form-control"
                                            name="parentage"
                                            required="true"
                                        >

                                    </div>

                                </div>

                                <!-- Contact Number -->

                                <div class="form-group">

                                    <label class="col-sm-3 control-label">
                                        Contact Number
                                        <span class="required">*</span>
                                    </label>

                                    <div class="col-sm-9">

                                        <input
                                            type="text"
                                            class="form-control"
                                            name="connum"
                                            maxlength="10"
                                            pattern="[0-9]+"
                                            required="true"
                                        >

                                    </div>

                                </div>

                                <!-- Address -->

                                <div class="form-group">

                                    <label class="col-sm-3 control-label">
                                        Address
                                        <span class="required">*</span>
                                    </label>

                                    <div class="col-sm-9">

                                        <textarea
                                            class="form-control"
                                            name="adress"
                                            required="true"
                                        ></textarea>

                                    </div>

                                </div>

                                <!-- Relation with accused -->

                                <div class="form-group">

                                    <label class="col-sm-3 control-label">
                                        Relation with accused person
                                        <span class="required">*</span>
                                    </label>

                                    <div class="col-sm-9">

                                        <input
                                            type="text"
                                            class="form-control"
                                            name="relaccused"
                                            required="true"
                                        >

                                    </div>

                                </div>

                                <!-- Purpose -->

                                <div class="form-group">

                                    <label class="col-sm-3 control-label">
                                        Purpose of applying copy of FIR
                                        <span class="required">*</span>
                                    </label>

                                    <div class="col-sm-9">

                                        <input
                                            type="text"
                                            class="form-control"
                                            name="purpose"
                                            required="true"
                                        >

                                    </div>

                                </div>

                            </div>

                            <footer class="panel-footer">

                                <div class="row">

                                    <div class="col-sm-9 col-sm-offset-3">

                                        <button
                                            class="btn btn-sm btn-primary login-submit-cs"
                                            type="submit"
                                            name="submit"
                                        >
                                            Submit
                                        </button>

                                    </div>

                                </div>

                            </footer>

                        </section>

                    </form>

                </div>

            </div>

            <!-- Page End -->

        </section>

    </div>

</section>

<!-- Vendor -->

<script src="../assets/vendor/jquery/jquery.js"></script>

<script src="../assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>

<script src="../assets/vendor/bootstrap/js/bootstrap.js"></script>

<script src="../assets/vendor/nanoscroller/nanoscroller.js"></script>

<script src="../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<script src="../assets/vendor/magnific-popup/magnific-popup.js"></script>

<script src="../assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>

<script src="../assets/vendor/jquery-validation/jquery.validate.js"></script>

<script src="../assets/javascripts/theme.js"></script>

<script src="../assets/javascripts/theme.custom.js"></script>

<script src="../assets/javascripts/theme.init.js"></script>

<script src="../assets/javascripts/forms/examples.validation.js"></script>

</body>
</html>