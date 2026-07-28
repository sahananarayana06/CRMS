<?php 
session_start();
//error_reporting(0);
include('includes/dbconnection.php');

// Ensure OTP columns exist for new verification flow
try {
    $check = $dbh->prepare("SHOW COLUMNS FROM tbluser LIKE 'OTPCode'");
    $check->execute();
    if($check->rowCount() == 0) {
        $dbh->exec("ALTER TABLE tbluser ADD COLUMN OTPCode varchar(10) DEFAULT NULL, ADD COLUMN OTPExpires datetime DEFAULT NULL");
    }
} catch (Exception $e) {
    // Ignore if schema update cannot be run automatically
}

// ✅ EMAIL LIBRARY ADDED
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';
require '../PHPMailer-master/src/Exception.php';

if(isset($_POST['submit']))
  {
    $fname=$_POST['fname'];
    $mobno=$_POST['mobno'];
    $email=$_POST['email'];
   
    $password=md5($_POST['password']);

    $ret="select Email from tbluser where Email=:email";
    $query= $dbh -> prepare($ret);
    $query-> bindParam(':email', $email, PDO::PARAM_STR);
    $query-> execute();
    $results = $query -> fetchAll(PDO::FETCH_OBJ);

if($query -> rowCount() == 0)
{
$otp = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
$otpExpires = date('Y-m-d H:i:s', strtotime('+15 minutes'));
$sql="Insert Into tbluser(FullName,MobileNumber,Email,Password,is_verified,OTPCode,OTPExpires)
Values(:fname,:mobno,:email,:password,0,:otp,:otpExpires)";
$query = $dbh->prepare($sql);
$query->bindParam(':fname',$fname,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->bindParam(':mobno',$mobno,PDO::PARAM_INT);
$query->bindParam(':password',$password,PDO::PARAM_STR);
$query->bindParam(':otp',$otp,PDO::PARAM_STR);
$query->bindParam(':otpExpires',$otpExpires,PDO::PARAM_STR);
$query->execute();

$lastInsertId = $dbh->lastInsertId();

if($lastInsertId)
{

    // ✅ EMAIL VERIFICATION CODE START

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'crmssystem5@gmail.com'; // change
        $mail->Password = 'ezcu eooc ipar rbos';    // change
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('crmssystem5@gmail.com', 'Crime Management System');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Your Verification OTP';
        $mail->Body = "
            <h3>Your verification code</h3>
            <p>Your OTP is: <strong>$otp</strong></p>
            <p>This code expires in 15 minutes.</p>
            <p>Enter it on the verification page below:</p>
            <a href='http://localhost/Crime-Record-Management-System-PHP/crimerms/user/verify.php?email=".urlencode($email)."'>Verify Account</a>
        ";

        $mail->send();

    } catch (Exception $e) {
        // optional
    }

    // ✅ EMAIL CODE END

    echo "<script>window.location.href ='verify.php?email=".urlencode($email)."';</script>";

} else{
echo "<script>alert('Something went wrong.Please try again');</script>";
echo "<script>window.location.href ='signup.php'</script>";
}

} else {
echo "<script>alert('Email-id already exist. Please try again');</script>";
}
}
?>
<!doctype html>
<html class="fixed">
	<head>
<title>Sign Up | Crime Record Management System</title>

		<!-- Web Fonts  -->
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.css" />
		<link rel="stylesheet" href="../assets/vendor/font-awesome/css/font-awesome.css" />
		<link rel="stylesheet" href="../assets/vendor/magnific-popup/magnific-popup.css" />
		<link rel="stylesheet" href="../assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
		<link rel="stylesheet" href="../assets/stylesheets/theme.css" />
		<link rel="stylesheet" href="../assets/stylesheets/skins/default.css" />
		<link rel="stylesheet" href="../assets/stylesheets/theme-custom.css">
		<link rel="stylesheet" href="../assets/stylesheets/theme-custom.css?v=2">
		<script src="../assets/vendor/modernizr/modernizr.js"></script>
		<script type="text/javascript">
			// For Email availabilty
function checkAvailability() {
$("#loaderIcon").css('display','block');
jQuery.ajax({
url: "check_availability.php",
data:'emailid='+$("#email").val(),
type: "POST",
success:function(data){
$("#user-availability-status").html(data);
$("#loaderIcon").css('display','none');
},
error:function (){}
});
}
		</script>

	</head>
	<body>
<a href="../index.php" class="logo pull-left"><h2 style="padding-top: 30px;padding-left: 30px;color: blue"><i class="fa fa-home"></i></h2></a>
		<section class="body-sign">
			<div class="center-sign">
				<a href="signup.php" class="logo pull-left">
					<strong style="font-size: 18px">Crime Record Management System</strong>
				</a>
<hr />
				<div class="panel panel-sign">
					<div class="panel-title-sign mt-xl text-right">
						<h2 class="title text-uppercase text-bold m-none"><i class="fa fa-user mr-xs"></i> Sign Up</h2>
					</div>
					<div class="panel-body">
						<form method="post">
							<div class="form-group mb-md">
								<label>Full Name</label>
								<input id="fname" type="text" class="form-control input-md" placeholder="Full Name" name="fname" required="true">
							</div>

							<div class="form-group mb-md">
								<label>E-mail Address</label>
								<input id="email" type="email" class="form-control input-md" placeholder="Email" name="email" required="true" onBlur="return checkAvailability()">
								  <span id="user-availability-status"></span>
							</div>

	<div class="form-group mb-md">
								<label>Mobile Number</label>
						<input id="mobno" type="text" class="form-control input-md" placeholder="Mobile" name="mobno" maxlength="10" pattern="[0-9]+" required="true">
							</div>


	<div class="form-group mb-md">
								<label>Password</label>
					<input id="password" type="password" class="form-control input-md" placeholder="Password" name="password" required="true">
							</div>


			

							<div class="row">
								
								<div class="col-sm-4 text-left">
									<button type="submit" class="btn btn-primary hidden-xs" id="submit" name="submit">Sign Up</button>
									
								</div>
							</div>

							<span class="mt-lg mb-lg line-thru text-center text-uppercase">
								<span>or</span>
							</span>

						
							<p class="text-center">Already have an account? <a href="signin.php">Sign In!</a>

						</form>
					</div>
				</div>
			</div>
		</section>
		<!-- end: page -->

		<!-- Vendor -->
		<script src="../assets/vendor/jquery/jquery.js"></script>
		<script src="../assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="../assets/vendor/bootstrap/js/bootstrap.js"></script>
		<script src="../assets/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="../assets/vendor/magnific-popup/magnific-popup.js"></script>
		<script src="../assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
		<script src="../assets/javascripts/theme.js"></script>
		<script src="../assets/javascripts/theme.custom.js"></script>
		<script src="../assets/javascripts/theme.init.js"></script>

	</body>
</html>