<?php
require_once('admin/connect.php');
if(isset($_POST) & !empty($_POST))
{
	$givendate = mysqli_real_escape_string($connection, $_POST['username']);
	$todaysdate = date("Y-m-d");
	//$sql = "SELECT * FROM `admin` WHERE username='$username'";
	//$result = mysqli_query($connection, $sql);
	//$count = mysqli_num_rows($result);
	if($givendate < $todaysdate)
	{
		echo "Invalid Appointment Date!";
	}
	//else
	//{
	//	echo "Username available";
	//}
}
?>