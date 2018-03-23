<?php
session_start();
require('connect.php');
if (isset($_POST['username']) && isset($_POST['password']))
	{
		// real eacape sting is used to prevent sql injection hacking
		$username= mysqli_real_escape_string($connection,$_POST['username']);
		$password= md5($_POST['password']);
		//sqll query
		//double quotes outside so we can use single quotes inside
		$query="SELECT * FROM `admin` WHERE (username='$username' OR email='$username')  AND password='$password'";
		$result = mysqli_query($connection,$query);
		$row = mysqli_fetch_assoc($result);
		$count = mysqli_num_rows($result);
		if($count==1)
		{
			//session_start();
			$_SESSION['ausername'] = $row["username"];
			$_SESSION['password'] = $password;
			// alternative redirect (die() should be there)
			// echo "<script>location.href='target-page.php';</script>";
			//define('BASEPATH',TRUE);
			//<script type="text/javascript">location.href = 'newurl';</script>
			echo'<script> window.location="../admin/index.php";</script>';
			//header('Location: index.html');
			
		}
		else
		//{
		//	$fmsg="Invalid Username/Password";
		//}
		{
		$queryd="SELECT * FROM `doctors` WHERE (username='$username' OR email='$username') AND password='$password'";
		$resultd = mysqli_query($connection,$queryd);
		$rowd = mysqli_fetch_assoc($resultd);
		$countd = mysqli_num_rows($resultd);
		if($countd==1)
		{
			$_SESSION['dusername'] = $rowd["username"];
			// alternative redirect (die() should be there)
			// echo "<script>location.href='target-page.php';</script>";
			//define('BASEPATH',TRUE);
			//<script type="text/javascript">location.href = 'newurl';</script>
			echo'<script> window.location="../doctor/index.php";</script>';
			//header('Location: index.html');
			
		}
		else
		{
			$querys="SELECT * FROM `staffs` WHERE (username='$username' OR email='$username') AND password='$password'";
		$results = mysqli_query($connection,$querys);
		$rows = mysqli_fetch_assoc($results);
		$counts = mysqli_num_rows($results);
		if($counts==1)
		{
			$_SESSION['susername'] = $rows["username"];
			// alternative redirect (die() should be there)
			// echo "<script>location.href='target-page.php';</script>";
			//define('BASEPATH',TRUE);
			//<script type="text/javascript">location.href = 'newurl';</script>
			echo'<script> window.location="../staff/index.php";</script>';
			//header('Location: index.html');
			
		}
			else
		{
			$fmsg="Invalid Username/Password";
		}
			
		}
		
		
		}
		
	}



if(isset($_POST['resetemail']))
{
	
	$remail=$_POST['resetemail'];
	$query="SELECT * FROM `admin` WHERE email='$remail'";
	$query1="SELECT * FROM `doctors` WHERE email='$remail'";
	$result = mysqli_query($connection,$query);
	$result1= mysqli_query($connection,$query1);
	$count = mysqli_num_rows($result);
	$count1= mysqli_num_rows($result1);
		if($count==1||$count1==1)
		{
			$str=random_int(256321,986523);
			$mdstr=md5($str);
			$query2="INSERT INTO `reset_password` (email,tempstr) VALUES ('$remail','$mdstr') ";
			$result2 = mysqli_query($connection, $query2);
			$link="http://localhost/ohms/login/reset-password.php?id=$mdstr";
				
			$to_Email       = $remail; // Replace with recipient email address
			$subject        = 'Password Reset'; //Subject line for emails

			$host           = "smtp.gmail.com"; // Your SMTP server. For example, smtp.mail.yahoo.com
			$rusername       = "alphacare.ohms@gmail.com"; //For example, your.email@yahoo.com
			$password       = "dnspnb@12007"; // Your password
			$SMTPSecure     = "tls"; // For example, ssl
			$port           = 587; // For example, 465

    //proceed with PHP email.
    include("php/PHPMailerAutoload.php"); //you have to upload class files "class.phpmailer.php" and "class.smtp.php"
 
	$mail = new PHPMailer();
	 
	$mail->IsSMTP();
	$mail->SMTPAuth = true;
	
	$mail->Host = $host;
	$mail->Username = $rusername;
	$mail->Password = $password;
	$mail->SMTPSecure = $SMTPSecure;
	$mail->Port = $port;
	
	 
	$mail->setFrom($rusername);
	$mail->addReplyTo($remail);
	 
	$mail->AddAddress($to_Email);
	$mail->Subject = $subject;
	
	$mail->Body = '<div width="100%" style="background: #f8f8f8; padding: 0px 0px; font-family:arial; line-height:28px; height:100%;  width: 100%; color: #514d6a;">
  <div style="max-width: 700px; padding:50px 0;  margin: 0px auto; font-size: 14px">
    <table border="0" cellpadding="0" cellspacing="0" style="width: 100%; margin-bottom: 20px">
      <tbody>
        <tr>
          <td style="vertical-align: top; padding-bottom:30px;" align="center"><a href="http://infinityx.000webhostapp.com/login/" target="_blank"><img src="https://i.imgur.com/zKKdcP7.png" alt="AlphaCare" style="border:none"><br/>
            <img src="https://i.imgur.com/ZA1Wwui.png" style="border:none"></a> </td>
        </tr>
      </tbody>
    </table>
    <div style="padding: 40px; background: #fff;">
      <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
        <tbody>
          <tr>
            <td style="border-bottom:1px solid #f6f6f6;"><h1 style="font-size:14px; font-family:arial; margin:0px; font-weight:bold;">Dear Sir/Madam,</h1>
              <p style="margin-top:0px; color:#bbbbbb;">Here are your password reset instructions.</p></td>
          </tr>
          <tr>
            <td style="padding:10px 0 30px 0;"><p>A request to reset your Account password has been made. If you did not make this request, simply ignore this email. If you did make this request, please reset your password:</p>
              <center>
                <a href="'.$link.'" style="display: inline-block; padding: 11px 30px; margin: 20px 0px 30px; font-size: 15px; color: #fff; background: #00c0c8; border-radius: 60px; text-decoration:none;">Reset Password</a>
              </center>
              <b>- Thanks (AlphaCare team)</b> </td>
          </tr>
          <tr>
            <td  style="border-top:1px solid #f6f6f6; padding-top:20px; color:#777">If the button above does not work, try copying and pasting the URL into your browser. If you continue to have problems, please feel free to contact us at alphacare.ohms@gmail.com</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div style="text-align: center; font-size: 12px; color: #b2b2b5; margin-top: 20px">
      <p> AlphaCare Online Hospital Management System © 2018 <br>
      </p>
    </div>
  </div>
</div>';
	
	$mail->WordWrap = 200;
	$mail->IsHTML(true);

	if(!$mail->send()) {

		$fmsg="E-mail not sent";

	} else {
	    $smsg="e-mail sent successfully";
	}
    
}
	else
	{
		$fmsg="email address is not registered";
	}
}

	//if(isset($_SESSION['username']))
	//{
	//	$fmsg="User already logged in";
	//}
	

?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="AlphaCare Online Hospital Management System">
    <meta name="author" content="Dhanush KT, Nishanth Bhat">
    <link rel="icon" type="image/png" sizes="16x16" href="../plugins/images/favicon.png">
    <title>AlphaCare - OHMS</title>
    <!-- Bootstrap Core CSS -->
    <link href="../plugins/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css" rel="stylesheet">
    <!-- animation CSS -->
    <link href="../plugins/css/animate.css" rel="stylesheet">
    <!-- toast CSS -->
    <link href="../plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../plugins/css/style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="../plugins/css/colors/default.css" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>
    <section id="wrapper" class="login-register ">
        <div class="login-box login-sidebar">
            <div class="white-box">
                <form class="form-horizontal form-material" id="loginform" method="post">
				
				<?php if(isset($fmsg)) { ?><div class="alert alert-danger"> <?php echo $fmsg; ?> </div> <?php }?>
				
				<?php if(isset($smsg)) { ?> <div class="alert alert-success"> <?php echo $smsg; ?> </div><?php }?>
				
                    <a href="javascript:void(0)" class="text-center db"><img src="../plugins/images/eliteadmin-logo-dark.png" alt="Home" />
                        <br/><img src="../plugins/images/eliteadmin-text-dark.png" alt="Home" /></a>
                    <div class="form-group m-t-40">
                        <div class="col-xs-12">
                            <input autofocus tabindex="1" class="form-control" type="text" name="username" required placeholder="Username or Email" value="<?php if(isset($username) & !empty($username)){ echo $username; }?>" >
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input tabindex="2" class="form-control" type="password" name="password" required="" placeholder="Password" >
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="checkbox checkbox-primary pull-left p-t-0">
                                <input id="checkbox-signup" type="checkbox">
                                <label for="checkbox-signup"> Remember me </label>
                            </div>
                            <a href="javascript:void(0)" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> Forgot password?</a> </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 m-t-10 text-center">
                            <div class="social">
                                <!--<a href="javascript:void(0)" class="btn  btn-facebook" data-toggle="tooltip" title="Login with Facebook"> <i aria-hidden="true" class="fa fa-facebook"></i> </a>
                                <a href="javascript:void(0)" class="btn btn-googleplus" data-toggle="tooltip" title="Login with Google"> <i aria-hidden="true" class="fa fa-google-plus"></i> </a>-->
								<p class="text-right" style="bottom: 0; position: fixed; ">BETA v 1.0</p>
                            </div>
                        </div>
                    </div>
                    
                   <!--- Removed Sigin up button
                    <div class="form-group m-b-0">
                        <div class="col-sm-12 text-center">
                            <p>Don't have an account? <a href="register2.html" class="text-primary m-l-5"><b>Sign Up</b></a></p>
                        </div>
                    </div> --->
                    
                </form>
               
                <form class="form-horizontal" id="recoverform" method="post">
                   <?php if(isset($fmsg)) { ?><div class="alert alert-danger"> <?php echo $fmsg; ?> </div> <?php }?>
  
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <h3>Recover Password</h3>
                            <p class="text-muted">Enter your Email and instructions will be sent to you! </p>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="email" required="" name="resetemail" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Reset</button>
                            <button class="btn btn-danger btn-lg btn-block text-uppercase waves-effect waves-light" onClick="location.reload();">Back</button>
                            
                            
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- jQuery -->
    <script src="../plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="../plugins/bootstrap/dist/js/tether.min.js"></script>
    <script src="../plugins/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../plugins/bower_components/bootstrap-extension/js/bootstrap-extension.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="../plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <!--slimscroll JavaScript -->
    <script src="../plugins/js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="../plugins/js/waves.js"></script>
    <script src="../plugins/bower_components/toast-master/js/jquery.toast.js"></script>
    <script src="../plugins/js/toastr.js"></script>    
    <!-- Custom Theme JavaScript -->
    <script src="../plugins/js/custom.min.js"></script>
    <!--Style Switcher -->
    <script src="../plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
</body>

</html>
