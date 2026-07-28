<?php
session_start();
include('includes/dbconnection.php');
if (strlen($_SESSION['crmspid']==0)) {
  header('location:logout.php');
} else{
?>
<!doctype html>
<html class="fixed">
	<head>
		<title>Crime Record Management System | New Complaints</title>
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.css" />
		<link rel="stylesheet" href="../assets/vendor/font-awesome/css/font-awesome.css" />
		<link rel="stylesheet" href="../assets/vendor/magnific-popup/magnific-popup.css" />
		<link rel="stylesheet" href="../assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
		<link rel="stylesheet" href="../assets/vendor/select2/select2.css" />
		<link rel="stylesheet" href="../assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />
		<link rel="stylesheet" href="../assets/stylesheets/theme.css" />
		<link rel="stylesheet" href="../assets/stylesheets/skins/default.css" />
		<link rel="stylesheet" href="../assets/stylesheets/theme-custom.css">
		<script src="../assets/vendor/modernizr/modernizr.js"></script>
	</head>
	<body>
		<section class="body">
			<?php include_once('includes/header.php');?>
			<div class="inner-wrapper">
				<?php include_once('includes/sidebar.php');?>
				<section role="main" class="content-body">
					<header class="page-header">
						<h2>New Complaints</h2>
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li><a href="dashboard.php"><i class="fa fa-home"></i></a></li>
								<li><span>New</span></li>
								<li><span>Complaints</span></li>
							</ol>
							<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
						</div>
					</header>
					<section class="panel">
						<header class="panel-heading"><h2 class="panel-title">Pending Complaints</h2></header>
						<div class="panel-body">
							<table class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>#</th>
										<th>Complaint No.</th>
										<th>Type</th>
										<th>User Name</th>
										<th>Contact</th>
										<th>Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
<?php
$psid = $_SESSION['psid'];
$sql = "SELECT tblcomplaint.ID,tblcomplaint.ComplaintNo,tblcomplaint.ComplaintType,tblcomplaint.ContactNumber,tblcomplaint.DateofComplaint,tbluser.FullName FROM tblcomplaint JOIN tbluser ON tblcomplaint.UserID=tbluser.ID WHERE tblcomplaint.Status='Pending' AND tblcomplaint.PoliceStationId=:psid";
$query = $dbh -> prepare($sql);
$query->bindParam(':psid',$psid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0) {
    foreach($results as $row) {
?>
									<tr>
										<td><?php echo $cnt;?></td>
										<td><?php echo htmlentities($row->ComplaintNo);?></td>
										<td><?php echo htmlentities($row->ComplaintType);?></td>
										<td><?php echo htmlentities($row->FullName);?></td>
										<td><?php echo htmlentities($row->ContactNumber);?></td>
										<td><?php echo htmlentities($row->DateofComplaint);?></td>
										<td><a href="take-complaint-action.php?cid=<?php echo $row->ID;?>" class="btn btn-primary btn-sm">Take Action</a></td>
									</tr>
<?php
        $cnt++;
    }
} else {
?>
									<tr><td colspan="7" class="text-center">No pending complaints found.</td></tr>
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
		<script src="../assets/javascripts/theme.js"></script>
		<script src="../assets/javascripts/theme.custom.js"></script>
		<script src="../assets/javascripts/theme.init.js"></script>
	</body>
</html>
<?php } ?>