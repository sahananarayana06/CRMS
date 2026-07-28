<?php
session_start();
include('includes/dbconnection.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';
require '../PHPMailer-master/src/Exception.php';

if (strlen($_SESSION['crmspid']==0)) {
  header('location:logout.php');
} else {
    if(isset($_GET['cid'])) {
        $cid = $_GET['cid'];
        $sql = "SELECT tblcomplaint.*, tbluser.Email, tbluser.FullName FROM tblcomplaint JOIN tbluser ON tblcomplaint.UserID = tbluser.ID WHERE tblcomplaint.ID = :cid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':cid',$cid,PDO::PARAM_STR);
        $query->execute();
        $complaint = $query->fetch(PDO::FETCH_OBJ);
    }

    if(isset($_POST['submit'])) {
        $cid = $_GET['cid'];
        $status = $_POST['status'];
        $remark = $_POST['remark'];

        $sql = "UPDATE tblcomplaint SET Status=:status, Remark=:remark WHERE ID=:cid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':status',$status,PDO::PARAM_STR);
        $query->bindParam(':remark',$remark,PDO::PARAM_STR);
        $query->bindParam(':cid',$cid,PDO::PARAM_STR);
        $query->execute();

        if($status == 'Approved' && !empty($complaint->Email)) {
            try {
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
                $mail->addAddress($complaint->Email, $complaint->FullName);
                $mail->isHTML(true);
                $mail->Subject = 'Your Complaint Has Been Accepted';
                $mail->Body = "<h3>Your complaint has been accepted</h3><p>Complaint Number: <b>{$complaint->ComplaintNo}</b></p><p>You may now apply for FIR via the FIR form.</p>";
                $mail->send();
            } catch (Exception $e) {
                // Keep processing even if email fails.
            }
        }

        echo "<script>alert('Complaint action updated successfully');</script>";
        echo "<script>window.location.href='new-complaint.php'</script>";
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Take Action on Complaint</title>
<link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.css" />
</head>
<body>
<div class="container">
<h2>Take Action on Complaint</h2>
<br>
<?php if(isset($complaint)) { ?>
<div class="panel panel-default">
  <div class="panel-heading">Complaint Details</div>
  <div class="panel-body">
    <p><strong>Complaint No:</strong> <?php echo htmlentities($complaint->ComplaintNo);?></p>
    <p><strong>Type:</strong> <?php echo htmlentities($complaint->ComplaintType);?></p>
    <p><strong>User:</strong> <?php echo htmlentities($complaint->FullName);?></p>
    <p><strong>Details:</strong> <?php echo htmlentities($complaint->ComplaintDetails);?></p>
    <p><strong>Contact:</strong> <?php echo htmlentities($complaint->ContactNumber);?></p>
    <p><strong>Address:</strong> <?php echo htmlentities($complaint->Address);?></p>
  </div>
</div>
<form method="post">
<div class="form-group">
<label>Action</label>
<select name="status" class="form-control" required>
<option value="">Select</option>
<option value="Approved">Accept</option>
<option value="Rejected">Reject</option>
</select>
</div>
<div class="form-group">
<label>Remark</label>
<textarea name="remark" class="form-control" rows="4" placeholder="Enter remark"></textarea>
</div>
<br>
<button type="submit" name="submit" class="btn btn-success">Submit</button>
</form>
<?php } else { ?>
<div class="alert alert-danger">Complaint not found.</div>
<?php } ?>
</div>
</body>
</html>