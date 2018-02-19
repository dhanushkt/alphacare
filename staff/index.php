<?php
include '../login/accesscontrolstaff.php';
if(isset($_SESSION['susername']))
{
	$ausername=$_SESSION['susername'];
}
else if(isset($_SESSION['ausername']))
{
	$ausername=$_SESSION['ausername'];
}
?>
<html>
	<body>
		<h1> WELCOME <?php echo $ausername; ?> </h1>
		<a href="logout.php">logout</a>
	</body>
</html>