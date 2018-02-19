<?php
require('connect.php');
if (isset($_POST['username']) && isset($_POST['password']))
	{
		// real eacape sting is used to prevent sql injection hacking
		$username= mysqli_real_escape_string($connection,$_POST['username']);
		$email=mysqli_real_escape_string($connection,$_POST['email']);
		$password= md5($_POST['password']);
		$repassword= md5($_POST['retypepassword']);
		//sqll query
		//double quotes outside so we can use single quotes inside
		if($password == $repassword) 
		{
			
			$usersql="SELECT * FROM `admin` WHERE username='$username'";
			$checkuser=mysqli_query($connection, $usersql);
			$countu=mysqli_num_rows($checkuser);
			$emailsql="SELECT * FROM `admin` WHERE email='$email'";
			$checkemail=mysqli_query($connection, $emailsql);
			$counte=mysqli_num_rows($checkemail);
			if($counte==1 || $countu==1)
			{
				$fmsg .= " username/email alredy exists";
			}
			else
			{
			
				$query="INSERT INTO `admin`(username, email, password) VALUES ('$username','$email','$password')";
				$result = mysqli_query($connection, $query); 
				//takes two arguments 
				if($result)
				{
					$smsg = "User Created Successfully.";
				}
				else
				{
					$fmsg = "User Registration Failed";
				}
			}
		}
		else
		{
			$fmsg="Password Doesn't Match"; 
		}
	}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="AlphaCare Online Hospital Management System">
    <meta name="author" content="Dhanush KT, Nishanth Bhat">
    <meta name="author" content="">
    <?php include 'assets/csslink.php'; ?>
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>
    <section id="wrapper" class="login-register">
        <div class="login-box login-sidebar">
            <div class="white-box">
                <form class="form-horizontal form-material" id="loginform" method="post">
                    <a href="javascript:void(0)" class="text-center db"><img src="../plugins/images/eliteadmin-logo-dark.png" alt="Home" />
                        <br/><img src="../plugins/images/eliteadmin-text-dark.png" alt="Home" /></a>
                    <h3 class="box-title m-t-40 m-b-0">Register Now</h3><small>Create your admin account</small>
                    <div class="form-group m-t-20">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" name="username" required="" placeholder="Name">
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" name="email" required="" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" name="password" required="" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" required="" name="retypepassword" placeholder="Confirm Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="checkbox checkbox-primary p-t-0">
                                <input id="checkbox-signup" type="checkbox">
                                <label for="checkbox-signup"> I agree to all <a href="#">Terms</a></label>
                            </div>
                        </div>
                    </div>
					
					<?php if(isset($fmsg)) { ?>
						<div class="alert alert-danger alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							 <?php echo $fmsg; ?>
						</div> 
					<?php }?> 
					<?php if(isset($smsg)) { ?>
						<div class="alert alert-success alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							 <?php echo $smsg; ?>
						</div> 
					<?php }?>
					
					
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Sign Up</button>
                        </div>
                    </div>
                    <div class="form-group m-b-0">
                        <div class="col-sm-12 text-center">
                            <p>Already have an account? <a href="../login/" class="text-primary m-l-5"><b>Sign In</b></a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <?php include'assets/jslink.php'; ?>
</body>

</html>
