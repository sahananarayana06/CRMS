<?php
session_start();
include('includes/dbconnection.php');
if (strlen($_SESSION['crmsaid']==0)) {
  header('location:logout.php');
  } else{

$search_station = isset($_POST['search']) ? $_POST['search'] : '';
$search_by = isset($_POST['search_by']) ? $_POST['search_by'] : 'name';

$sql = "SELECT * FROM tblpolicestation WHERE 1=1";
$params = array();

if($search_station) {
    if($search_by == 'name') {
        $sql .= " AND PoliceStationName LIKE :search";
    } elseif($search_by == 'code') {
        $sql .= " AND PoliceStationCode LIKE :search";
    }
}
$sql .= " ORDER BY PoliceStationName";

$query = $dbh->prepare($sql);
if($search_station) {
    $search_param = "%{$search_station}%";
    $query->bindParam(':search', $search_param, PDO::PARAM_STR);
}
$query->execute();
$police_stations = $query->fetchAll(PDO::FETCH_OBJ);

// Get statistics
$total_stations = $query->rowCount();

?>
<!doctype html>
<html class="fixed">
	<head>
		<title>Crime Record Management System | Search Police Station</title>
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
						<h2>Search Police Station</h2>
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li><a href="dashboard.php"><i class="fa fa-home"></i></a></li>
								<li><span>Search</span></li>
								<li><span>Police Station</span></li>
							</ol>
							<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
						</div>
					</header>

					<div class="row">
						<div class="col-md-12">
							<section class="panel">
								<header class="panel-heading">
									<h2 class="panel-title">Search Police Station</h2>
								</header>
								<div class="panel-body">
									<form method="POST" class="form-inline mb-md">
										<div class="form-group">
											<label for="search_by">Search By:</label>
											<select name="search_by" id="search_by" class="form-control">
												<option value="name" <?php echo ($search_by == 'name') ? 'selected' : ''; ?>>Station Name</option>
												<option value="code" <?php echo ($search_by == 'code') ? 'selected' : ''; ?>>Station Code</option>
											</select>
										</div>
										<div class="form-group">
											<label for="search">Search:</label>
											<input type="text" name="search" id="search" class="form-control" placeholder="Enter search term..." value="<?php echo htmlentities($search_station); ?>">
										</div>
										<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
										<a href="search-police-station.php" class="btn btn-default">Reset</a>
									</form>
									
									<table class="table table-bordered table-striped">
										<thead>
											<tr>
												<th class="text-center">#</th>
												<th>Station Name</th>
												<th>Station Code</th>
												<th>Posting Date</th>
												<th class="text-center">Total Police</th>
												<th class="text-center">Total FIRs</th>
												<th class="text-center">Action</th>
											</tr>
										</thead>
										<tbody>
											<?php 
											$cnt = 1;
											if($query->rowCount() > 0) {
												foreach($police_stations as $ps) {
													// Get total police count
													$police_sql = "SELECT COUNT(*) as total FROM tblpolice WHERE PoliceStationId = :ps_id";
													$police_query = $dbh->prepare($police_sql);
													$police_query->bindParam(':ps_id', $ps->id, PDO::PARAM_STR);
													$police_query->execute();
													$police_count = $police_query->fetch(PDO::FETCH_OBJ);
													
													// Get total FIR count
													$fir_sql = "SELECT COUNT(*) as total FROM tblfir WHERE PoliceStationId = :ps_id";
													$fir_query = $dbh->prepare($fir_sql);
													$fir_query->bindParam(':ps_id', $ps->id, PDO::PARAM_STR);
													$fir_query->execute();
													$fir_count = $fir_query->fetch(PDO::FETCH_OBJ);
											?>
											<tr>
												<td class="text-center"><?php echo $cnt; ?></td>
												<td><?php echo htmlentities($ps->PoliceStationName); ?></td>
												<td><?php echo htmlentities($ps->PoliceStationCode); ?></td>
												<td><?php echo htmlentities($ps->PostingDate); ?></td>
												<td class="text-center">
													<span class="badge badge-primary"><?php echo $police_count->total; ?></span>
												</td>
												<td class="text-center">
													<span class="badge badge-info"><?php echo $fir_count->total; ?></span>
												</td>
												<td class="text-center">
													<a href="view-police-station.php?id=<?php echo $ps->id; ?>" class="btn btn-primary btn-xs">View Details</a>
												</td>
											</tr>
											<?php $cnt++; }} else { ?>
											<tr>
												<th colspan="7" style="text-align:center; color:red;">No police stations found</th>
											</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
							</section>
						</div>
					</div>
				</section>
			</div>
		</section>

		<script src="../assets/vendor/jquery/jquery.js"></script>
		<script src="../assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="../assets/vendor/bootstrap/js/bootstrap.js"></script>
		<script src="../assets/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="../assets/vendor/magnific-popup/magnific-popup.js"></script>
		<script src="../assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
		<script src="../assets/vendor/select2/select2.js"></script>
		<script src="../assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
		<script src="../assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
		<script src="../assets/javascripts/theme.js"></script>
		<script src="../assets/javascripts/theme.custom.js"></script>
		<script src="../assets/javascripts/theme.init.js"></script>
	</body>
</html>
<?php } ?>