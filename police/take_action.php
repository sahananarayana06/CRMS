<?php
session_start();
include('includes/dbconnection.php');

if(isset($_POST['submit']))
{
$firid=$_GET['firid'];
$status=$_POST['status'];
$remark=$_POST['remark'];

$sql="update tblfir set Status=:status, Remark=:remark where ID=:firid";
$query=$dbh->prepare($sql);

$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->bindParam(':remark',$remark,PDO::PARAM_STR);
$query->bindParam(':firid',$firid,PDO::PARAM_STR);

$query->execute();

echo "<script>alert('Action updated successfully');</script>";
echo "<script>window.location.href='new-fir.php'</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Take Action</title>
<link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.css" />
</head>

<body>

<div class="container">
<h2>Take Action on FIR</h2>
<br>

<form method="post">

<div class="form-group">
<label>Action</label>
<select name="status" class="form-control" required>
<option value="">Select</option>
<option value="Approved">Accept</option>
<option value="Cancelled">Reject</option>
</select>
</div>

<div class="form-group">
<label>Remark</label>
<textarea name="remark" class="form-control" rows="4" placeholder="Enter remark"></textarea>
</div>

<br>
<button type="submit" name="submit" class="btn btn-success">Submit</button>

</form>

</div>

</body>
</html>