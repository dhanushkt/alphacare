<?php
require('connect.php');
if(isset($_POST['id']) && isset($_POST['totalamt']))
{
	$id=$_POST['id'];
	$totamt=$_POST['totalamt'];
	$updatequery="UPDATE ip_bills SET total_amt='$totamt' WHERE bill_id='$id'";
	$updateresult=mysqli_query($connection,$updatequery);
}
?>