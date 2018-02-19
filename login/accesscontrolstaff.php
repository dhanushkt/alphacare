<?php
include_once 'connect.php';
session_start();
if(!(isset($_SESSION['susername'])||isset($_SESSION['ausername'])))
{
	echo'<script> window.location="403.php";</script>';
}
?>