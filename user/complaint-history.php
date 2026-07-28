<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('includes/dbconnection.php');

// ✅ SESSION CHECK
if (!isset($_SESSION['crmsuid']) || strlen($_SESSION['crmsuid']) == 0) {
    header('location:logout.php');
    exit();
} else {

    // ✅ FIXED (removed intval)
    $uid = $_SESSION['crmsuid'];

    // ⚠️ CHECK TABLE NAME HERE (tblcomplaint OR tblcomplaints)
    $sql = "SELECT * FROM tblcomplaint WHERE UserID=:uid ORDER BY DateofComplaint DESC";

    $query = $dbh->prepare($sql);

    // ✅ FIXED (use STRING)
    $query->bindValue(':uid', $uid, PDO::PARAM_STR);

    if ($query->execute()) {
        $complaints = $query->fetchAll(PDO::FETCH_OBJ);
    } else {
        $complaints = [];
        $error = "Unable to load complaint history.";
    }
}
?>

<!DOCTYPE html>
<html class="fixed">
<head>
    <title>Crime Record Management System | Complaint History</title>

    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.css" />
<link rel="stylesheet" href="../assets/vendor/font-awesome/css/font-awesome.css" />
<link rel="stylesheet" href="../assets/vendor/magnific-popup/magnific-popup.css" />
<link rel="stylesheet" href="../assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
<link rel="stylesheet" href="../assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />

<link rel="stylesheet" href="../assets/stylesheets/theme.css" />
<link rel="stylesheet" href="../assets/stylesheets/skins/default.css" />
<link rel="stylesheet" href="../assets/stylesheets/theme-custom.css">

<script src="../assets/vendor/modernizr/modernizr.js"></script>
</head>

<body>
<section class="body">

<?php include_once('includes/header.php'); ?>
<div class="inner-wrapper">
<?php include_once('includes/sidebar.php'); ?>

<section role="main" class="content-body">

<header class="page-header">
    <h2>Complaint History</h2>
</header>

<section class="panel">
<header class="panel-heading">
    <h2 class="panel-title">Your Complaints</h2>
</header>

<div class="panel-body">

<?php if (isset($error)) { ?>
    <div class="alert alert-danger"><?php echo htmlentities($error); ?></div>
<?php } ?>

<table class="table table-bordered table-striped">
<thead>
<tr>
    <th>#</th>
    <th>Complaint No.</th>
    <th>Type</th>
    <th>Details</th>
    <th>Contact</th>
    <th>Address</th>
    <th>Police Station</th>
    <th>Date</th>
    <th>Status</th>
    <th>Remark</th>
</tr>
</thead>

<tbody>

<?php
$cnt = 1;

// ✅ CHECK RESULTS
if (!empty($complaints)) {

    foreach ($complaints as $row) {
?>
<tr>
    <td><?php echo $cnt; ?></td>
    <td><?php echo htmlentities($row->ComplaintNo); ?></td>
    <td><?php echo htmlentities($row->ComplaintType); ?></td>
    <td><?php echo htmlentities($row->ComplaintDetails); ?></td>
    <td><?php echo htmlentities($row->ContactNumber); ?></td>
    <td><?php echo htmlentities($row->Address); ?></td>
    <td><?php echo htmlentities($row->PoliceStation); ?></td>
    <td><?php echo htmlentities($row->DateofComplaint); ?></td>
    <td><?php echo htmlentities($row->Status); ?></td>
    <td><?php echo htmlentities($row->Remark); ?></td>
</tr>

<?php
        $cnt++;
    }

} else {
?>
<tr>
    <td colspan="10" class="text-center">No complaints found</td>
</tr>
<?php } ?>

</tbody>
</table>

</div>
</section>

</section>
</div>
</section>
<script src="../assets/vendor/jquery/jquery.js"></script>
<script src="../assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
<script src="../assets/vendor/bootstrap/js/bootstrap.js"></script>
<script src="../assets/vendor/nanoscroller/nanoscroller.js"></script>
<script src="../assets/vendor/magnific-popup/magnific-popup.js"></script>
<script src="../assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
<script src="../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="../assets/vendor/jquery-validation/jquery.validate.js"></script>

<script src="../assets/javascripts/theme.js"></script>
<script src="../assets/javascripts/theme.custom.js"></script>
<script src="../assets/javascripts/theme.init.js"></script>
</body>
</html>