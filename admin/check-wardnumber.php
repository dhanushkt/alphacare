<?php
require_once('connect.php');
if(isset($_POST) & !empty($_POST))
{
	$wardno = mysqli_real_escape_string($connection, $_POST['wardno']);
	$sql = "SELECT * FROM `wards` WHERE ward_no='$wardno'";
	$result = mysqli_query($connection, $sql);
	$count = mysqli_num_rows($result);
	if($count == 1)
	{
		echo "Ward number alredy exist";
	}
	//else
	//{
	//	echo "Username available";
	//}
}
?>