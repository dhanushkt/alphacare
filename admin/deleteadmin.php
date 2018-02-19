<?php
require('connect.php');
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
  if (isset($_GET['id'])) {
    $id = $_GET['id'];
		$sql="DELETE FROM admin WHERE a_id=$id";
		$result = mysqli_query($connection, $sql);
		if($result)
		{
			echo "Deleted successfully.";
			//echo '<script> window.location="logout.php"; </script>';
		}
		else
		{
			echo "Error!";
		}
  }
}
?>
