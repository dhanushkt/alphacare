<?php 
require('../admin/connect.php');
if(isset($_POST['uname']) && isset($_POST['email']) && isset($_POST['pass']))
{
	$uname=$_POST['uname'];
	$email=$_POST['email'];
	$passwd=md5($_POST['pass']);
	$insertquery="INSERT INTO `admin` (username,email,password) VALUES ('$uname','$email','$passwd')";
	$insertresult=mysqli_query($connection,$insertquery);
}

?>