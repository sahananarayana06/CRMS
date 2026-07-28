<?php
session_start();
error_reporting(0);
$error = "";

include('includes/dbconnection.php');
if (strlen($_SESSION['crmspid']) == 0) {
  header('location:logout.php');
  exit();
  } else{


?>
<!doctype html>
<html class="fixed">
	<head>
		<title>Crime Record Management System | FIR Between Dates Report</title>
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.css" />
		<link rel="stylesheet" href="../assets/vendor/font-awesome/css/font-awesome.css" />
		<link rel="stylesheet" href="../assets/vendor/magnific-popup/magnific-popup.css" />
		<link rel="stylesheet" href="../assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
		<link rel="stylesheet" href="../assets/stylesheets/theme.css" />
		<link rel="stylesheet" href="../assets/stylesheets/skins/default.css" />
		<link rel="stylesheet" href="../assets/stylesheets/theme-custom.css">
		<script src="../assets/vendor/modernizr/modernizr.js"></script>
		<style>
			.center-alert {
				position: fixed;
				top: 50%;
				left: 50%;
				transform: translate(-50%, -50%);
				background: #ca1515;
				color: white;
				padding: 15px 15px;   /* reduced size */
				font-size: 14px;      /* smaller text */
				border-radius: 8px;
				text-align: center;
				z-index: 9999;
				box-shadow: 0px 0px 10px rgba(0,0,0,0.3);
				width: 300px;         /* fixed width */
			}

			.center-alert button {
				margin-top: 10px;
				padding: 5px 15px;
				border: none;
				background: white;
				color: #ca1515;
				border-radius: 5px;
				cursor: pointer;
				font-weight: bold;
			}
		</style>
	</head>
	<body>

	    <?php
		if (isset($_POST['submit'])) {
			$fromdate = trim($_POST['fromdate'] ?? '');
    	    $todate = trim($_POST['todate'] ?? '');

			$today = date("Y-m-d");

			if ($fromdate > $today || $todate > $today) { 
		?>
		<div class="center-alert" id="alertBox">
			Future dates are not allowed!<br>
			<button onclick="closeAlert()">OK</button>
		</div>
		<?php
			} elseif ($fromdate > $todate) {
		?>
		<div class="center-alert" id="alertBox">
			From Date cannot be greater than To Date!<br>
			<button onclick="closeAlert()">OK</button>
		</div>
		<?php
			} else {
    		header("Location: fir-bwdates-reports-details.php?fromdate=" . urlencode($fromdate) . "&todate=" . urlencode($todate));
    		exit();
			}
		}
		?>

		<section class="body">

			<!-- start: header -->
		<?php include_once('includes/header.php');?>
			<!-- end: header -->

			<div class="inner-wrapper">
				<!-- start: sidebar -->
				<?php include_once('includes/sidebar.php');?>
				<!-- end: sidebar -->

				<section role="main" class="content-body">
					<header class="page-header">
						<h2>FIR Between Dates Report</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="dashboard.php">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>FIR</span></li>
								<li><span> Reports</span></li>
							</ol>
					
							<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
						</div>
					</header>

					<!-- start: page -->
					
					<div class="row">
						<div class="col-md-12">
							<form class="form-horizontal" method="post" name="bwdatesreport" action="">
								 
								<section class="panel">
									<header class="panel-heading">
									<h2>FIR Between Dates Report</h2>
									
									</header>
									<div class="panel-body">
										<div class="validation-message">
											<ul></ul>
										</div>

										<?php if ($error != "") { ?>
											<div style="color:red; font-weight:bold; margin-bottom:15px;">
												<?php echo $error; ?>
											</div>
										<?php } ?>
										
										<div class="form-group">
											<label class="col-sm-3 control-label">From Date: <span class="required">*</span></label>
											<div class="col-sm-9">
												 <input type="date" class="form-control" id="fromdate" name="fromdate" value="<?php echo htmlspecialchars($_POST['fromdate'] ?? ''); ?>" required='true'>
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-3 control-label">To Date: <span class="required">*</span></label>
											<div class="col-sm-9">
												 <input type="date" class="form-control" id="todate" name="todate" value="<?php echo htmlspecialchars($_POST['todate'] ?? ''); ?>" required='true'>
											</div>
										</div>
										
									</div>
									<footer class="panel-footer">
										<div class="row">
											<div class="col-sm-9 col-sm-offset-3">
												<button class="btn btn-sm btn-primary login-submit-cs" type="submit" name="submit">Submit</button>
											
											</div>
										</div>
									</footer>
								</section>
							</form>
						</div>
					
					</div>
					<!-- end: page -->
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
		<script>
			function closeAlert(){
       			document.getElementById("alertBox").style.display = "none";
			}
		</script>
	</body>
</html><?php }  ?>