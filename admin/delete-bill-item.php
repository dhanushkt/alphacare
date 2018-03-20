<?php
require('connect.php');
if(isset($_POST['billid']))
{
	$id=$_POST['billid'];
	$deletequery="DELETE FROM bill_items WHERE item_id='$id'";
	$deleteresult=mysqli_query($connection,$deletequery);
}
?>