<?php
require_once('connect.php');
if(isset($_POST) & !empty($_POST))
{
	$username = mysqli_real_escape_string($connection, $_POST['username']);
	$sql = "SELECT * FROM `admin` WHERE username='$username'";
	$result = mysqli_query($connection, $sql);
	$count = mysqli_num_rows($result);
	if($count == 1)
	{
		echo "Username already taken";
	}
	//else
	//{
	//	echo "Username available";
	//}
}
?>