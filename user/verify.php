<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';
require '../PHPMailer-master/src/Exception.php';

try {
    $check = $dbh->prepare("SHOW COLUMNS FROM tbluser LIKE 'OTPCode'");
    $check->execute();
    if($check->rowCount() == 0) {
        $dbh->exec("ALTER TABLE tbluser ADD COLUMN OTPCode varchar(10) DEFAULT NULL, ADD COLUMN OTPExpires datetime DEFAULT NULL");
    }
} catch (Exception $e) {
    // Ignore if schema update cannot be run automatically
}

$message = '';
$successMessage = '';
$email = isset($_GET['email']) ? trim($_GET['email']) : '';

if(isset($_POST['verify'])) {
    $email = trim($_POST['email']);
    $otp = trim($_POST['otp']);

    if(empty($email) || empty($otp)) {
        $message = 'Please enter both email and OTP.';
    } else {
        $sql = "SELECT ID, is_verified, OTPCode, OTPExpires FROM tbluser WHERE Email=:email";
        $query = $dbh->prepare($sql);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);

        if($query->rowCount() > 0) {
            if($result->is_verified == 1) {
                $message = 'Your account is already verified. You can login now.';
            } elseif($result->OTPCode !== $otp) {
                $message = 'Invalid OTP. Please check the code sent to your email.';
            } elseif(!empty($result->OTPExpires) && strtotime($result->OTPExpires) < time()) {
                $message = 'Your OTP has expired. Please resend and use the new code.';
            } else {
                $update = "UPDATE tbluser SET is_verified=1, OTPCode=NULL, OTPExpires=NULL WHERE ID=:id";
                $updateQuery = $dbh->prepare($update);
                $updateQuery->bindParam(':id', $result->ID, PDO::PARAM_INT);
                $updateQuery->execute();
                echo "<script>alert('Verification successful. You can now login.');</script>";
                echo "<script>window.location.href ='signin.php?msg=verified';</script>";
                exit;
            }
        } else {
            $message = 'This email is not registered.';
        }
    }
}

if(isset($_POST['resend'])) {
    $email = trim($_POST['email']);

    if(empty($email)) {
        $message = 'Please enter your registered email to resend OTP.';
    } else {
        $sql = "SELECT ID, is_verified FROM tbluser WHERE Email=:email";
        $query = $dbh->prepare($sql);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);

        if($query->rowCount() > 0) {
            if($result->is_verified == 1) {
                $message = 'Your account is already verified. Please login.';
            } else {
                $otp = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
                $otpExpires = date('Y-m-d H:i:s', strtotime('+15 minutes'));
                $update = "UPDATE tbluser SET OTPCode=:otp, OTPExpires=:otpExpires WHERE ID=:id";
                $updateQuery = $dbh->prepare($update);
                $updateQuery->bindParam(':otp', $otp, PDO::PARAM_STR);
                $updateQuery->bindParam(':otpExpires', $otpExpires, PDO::PARAM_STR);
                $updateQuery->bindParam(':id', $result->ID, PDO::PARAM_INT);
                $updateQuery->execute();

                try {
                    $mail = new PHPMailer(true);
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'crmssystem5@gmail.com'; 
                    $mail->Password = 'ezcu eooc ipar rbos';    
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
                        <p>Enter it on the verification page.</p>
                    ";
                    $mail->send();
                    $successMessage = 'A new OTP has been sent to your email.';
                } catch (Exception $e) {
                    $message = 'Unable to resend OTP. Please try again later.';
                }
            }
        } else {
            $message = 'This email is not registered.';
        }
    }
}
?>
<!doctype html>
<html class="fixed">
<head>
<title>Verify Account | Crime Record Management System</title>
<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.css" />
<link rel="stylesheet" href="../assets/vendor/font-awesome/css/font-awesome.css" />
<link rel="stylesheet" href="../assets/vendor/magnific-popup/magnific-popup.css" />
<link rel="stylesheet" href="../assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
<link rel="stylesheet" href="../assets/stylesheets/theme.css" />
<link rel="stylesheet" href="../assets/stylesheets/skins/default.css" />
<link rel="stylesheet" href="../assets/stylesheets/theme-custom.css">
</head>
<body>
    <a href="../index.php" class="logo pull-left"><h2 style="padding-top: 30px;padding-left: 30px;color: blue"><i class="fa fa-home"></i></h2></a>
    <section class="body-sign">
        <div class="center-sign">
            <a href="verify.php" class="logo pull-left">
                <strong style="font-size: 18px">Crime Record Management System</strong>
            </a>
            <hr />
            <div class="panel panel-sign">
                <div class="panel-title-sign mt-xl text-right">
                    <h2 class="title text-uppercase text-bold m-none"><i class="fa fa-key mr-xs"></i> Verify Account</h2>
                </div>
                <div class="panel-body">
                    <?php if($message): ?>
                        <div class="alert alert-danger"><?php echo htmlentities($message); ?></div>
                    <?php endif; ?>
                    <?php if($successMessage): ?>
                        <div class="alert alert-success"><?php echo htmlentities($successMessage); ?></div>
                    <?php endif; ?>
                    <form method="post">
                        <div class="form-group mb-md">
                            <label>Email</label>
                            <input type="email" class="form-control input-md" placeholder="Registered Email" name="email" required="true" value="<?php echo htmlentities($email); ?>">
                        </div>
                        <div class="form-group mb-md">
                            <label>OTP Code</label>
                            <input type="text" class="form-control input-md" placeholder="Enter OTP" name="otp" maxlength="6" pattern="\d{6}">
                        </div>
                        <div class="row">
                            <div class="col-sm-4 text-left">
                                <button type="submit" class="btn btn-primary hidden-xs" name="verify">Verify OTP</button>
                            </div>
                            <div class="col-sm-4 text-right">
                                <button type="submit" class="btn btn-default hidden-xs" name="resend">Resend OTP</button>
                            </div>
                        </div>
                        <span class="mt-lg mb-lg line-thru text-center text-uppercase"><span>or</span></span>
                        <p class="text-center">Already verified? <a href="signin.php">Sign in</a></p>
                    </form>
                </div>
            </div>
        </div>
    </section>
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
