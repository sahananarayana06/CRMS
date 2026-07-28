<?php
session_start();
error_reporting(0);
include ('includes/dbconnection.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';
require '../PHPMailer-master/src/Exception.php';

if (!isset($_SESSION['crmsuid']) || strlen($_SESSION['crmsuid']) == 0) {
  header('location:logout.php');
  exit();
} else {
    if(isset($_POST['submit'])) {
        $uid = $_SESSION['crmsuid'];
        $polsta = $_POST['policestation'];
        $pdata = explode(",", $polsta);
        $psid = $pdata[0];
        $psname = $pdata[1];
        $complaintType = $_POST['complainttype'];
        $details = $_POST['details'];
        $connum = $_POST['connum'];
        $address = $_POST['address'];
        $complaintNo = mt_rand(100000000, 999999999);

        $sql = "insert into tblcomplaint(ComplaintNo,UserID,PoliceStationId,PoliceStation,ComplaintType,ComplaintDetails,ContactNumber,Address) values(:complaintNo,:uid,:psid,:psname,:complaintType,:details,:connum,:address)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':complaintNo',$complaintNo,PDO::PARAM_STR);
        $query->bindParam(':uid',$uid,PDO::PARAM_STR);
        $query->bindParam(':psid',$psid,PDO::PARAM_STR);
        $query->bindParam(':psname',$psname,PDO::PARAM_STR);
        $query->bindParam(':complaintType',$complaintType,PDO::PARAM_STR);
        $query->bindParam(':details',$details,PDO::PARAM_STR);
        $query->bindParam(':connum',$connum,PDO::PARAM_STR);
        $query->bindParam(':address',$address,PDO::PARAM_STR);
        $query->execute();
        $LastInsertId = $dbh->lastInsertId();

        if ($LastInsertId > 0) {
            $msg = "Complaint submitted successfully. It will be reviewed by police soon.";
            try {
                $userEmail = '';
                $userName = '';
                $sqlUser = "SELECT FullName, Email FROM tbluser WHERE ID=:uid";
                $queryUser = $dbh->prepare($sqlUser);
                $queryUser->bindParam(':uid', $uid, PDO::PARAM_STR);
                $queryUser->execute();
                $resultUser = $queryUser->fetch(PDO::FETCH_OBJ);
                if ($resultUser) {
                    $userEmail = $resultUser->Email;
                    $userName = $resultUser->FullName;
                }
                if (!empty($userEmail)) {
                    $mail = new PHPMailer(true);
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
                    $mail->setFrom('crmssystem5@gmail.com', 'Crime Management System');
                    $mail->addAddress($userEmail, $userName);
                    $mail->isHTML(true);
                    $mail->Subject = 'Complaint Received';
                    $mail->Body = "<h3>Your complaint has been submitted</h3><p>Complaint Number: <b>$complaintNo</b></p><p>We will review it and update you when the police take action.</p>";
                    $mail->send();
                }
            } catch (Exception $e) {
                // If email fails, keep the complaint submission successful.
            }
        } else {
            $error = "Something went wrong. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html class="fixed">
	<head>
		<title>Crime Record Management System | Complaint Form</title>
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
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
			<?php include_once('includes/header.php');?>
			<div class="inner-wrapper">
				<?php include_once('includes/sidebar.php');?>
				<section role="main" class="content-body">
					<header class="page-header">
						<h2>Complaint Form</h2>
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li><a href="dashboard.php"><i class="fa fa-home"></i></a></li>
								<li><span>Add</span></li>
								<li><span>Complaint</span></li>
							</ol>
							<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
						</div>
					</header>
					<div class="row">
						<div class="col-md-12">
							<?php if(isset($msg)){ ?>
								<div class="alert alert-success"><?php echo $msg;?></div>
							<?php } ?>
							<?php if(isset($error)){ ?>
								<div class="alert alert-danger"><?php echo $error;?></div>
							<?php } ?>
							<form class="form-horizontal" method="post">
								<section class="panel">
									<header class="panel-heading"><h2 class="panel-title">Submit Complaint</h2></header>
									<div class="panel-body">
										<div class="form-group">
											<label class="col-sm-3 control-label">Police Station <span class="required">*</span></label>
											<div class="col-sm-9">
												<select class="form-control" name="policestation" required>
													<option value="">Select Police Station</option>
<?php 
$sql2 = "SELECT * from tblpolicestation";
$query2 = $dbh -> prepare($sql2);
$query2->execute();
$result2=$query2->fetchAll(PDO::FETCH_OBJ);
foreach($result2 as $row)
{ ?>
<option value="<?php echo htmlentities($row->id.','.$row->PoliceStationName);?>"><?php echo htmlentities($row->PoliceStationName);?>-(<?php echo htmlentities($row->PoliceStationCode);?>)</option>
<?php } ?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Complaint Type <span class="required">*</span></label>
											<div class="col-sm-9">
												<select class="form-control" name="complainttype" required>
													<option value="">Choose Complaint Type</option>
<?php 
$sql3 = "SELECT * from tblcategory";
$query3 = $dbh -> prepare($sql3);
$query3->execute();
$result3=$query3->fetchAll(PDO::FETCH_OBJ);
foreach($result3 as $row)
{ ?>
<option value="<?php echo htmlentities($row->CategoryName);?>"><?php echo htmlentities($row->CategoryName);?></option>
<?php } ?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Complaint Details <span class="required">*</span></label>
											<div class="col-sm-9">
												<textarea class="form-control" name="details" required></textarea>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Contact Number <span class="required">*</span></label>
											<div class="col-sm-9">
												<input type="text" class="form-control" name="connum" maxlength="10" pattern="[0-9]+" required>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Address <span class="required">*</span></label>
											<div class="col-sm-9">
												<textarea class="form-control" name="address" required></textarea>
											</div>
										</div>
									</div>
									<footer class="panel-footer">
										<div class="row">
											<div class="col-sm-9 col-sm-offset-3">
												<button class="btn btn-sm btn-primary" type="submit" name="submit">Submit</button>
											</div>
										</div>
									</footer>
								</section>
							</form>
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
		<script src="../assets/vendor/jquery-validation/jquery.validate.js"></script>
		<script src="../assets/javascripts/theme.js"></script>
		<script src="../assets/javascripts/theme.custom.js"></script>
		<script src="../assets/javascripts/theme.init.js"></script>
		<script src="../assets/javascripts/forms/examples.validation.js"></script>
	</body>
</html>