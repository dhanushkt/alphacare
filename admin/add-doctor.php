<?php
include '../login/accesscontroladmin.php';
$ausername=$_SESSION['ausername'];
require('connect.php');
if (isset($_POST['docsubmit']))
	{
		// real eacape sting is used to prevent sql injection hacking
		$fname=mysqli_real_escape_string($connection,$_POST['fname']);
		$lname=mysqli_real_escape_string($connection,$_POST['lname']);
		$username= mysqli_real_escape_string($connection,$_POST['username']);
		$email=mysqli_real_escape_string($connection,$_POST['email']);
		$gender=mysqli_real_escape_string($connection,$_POST['gender']);
		$qualification=mysqli_real_escape_string($connection,$_POST['qualif']);
		$specialist=mysqli_real_escape_string($connection,$_POST['special']);
		$phone=$_POST['phone'];
		$password= md5($_POST['password']);
		$repassword= md5($_POST['retypepassword']);
		//sqll query
		//double quotes outside so we can use single quotes inside
		if($password == $repassword) 
		{
			
			$usersql="SELECT * FROM `doctors` WHERE username='$username'";
			$checkuser=mysqli_query($connection, $usersql);
			$countu=mysqli_num_rows($checkuser);
			$emailsql="SELECT * FROM `doctors` WHERE email='$email'";
			$checkemail=mysqli_query($connection, $emailsql);
			$counte=mysqli_num_rows($checkemail);
			if($counte==1 || $countu==1)
			{
				$fmsg = "username/email alredy exists";
			}
			else
			{
			
				$query="INSERT INTO `doctors`(fname, lname, username, email, gender, qualification, specialist, phone, password) VALUES ('$fname','$lname','$username','$email','$gender','$qualification','$specialist',$phone,'$password')";
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
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="AlphaCare Online Hospital Management System">
    <meta name="author" content="Dhanush KT, Nishanth Bhat">
    <!--csslink.php includes fevicon and title-->
    <?php include 'assets/csslink.php'; ?>
<!-- username check js start -->
<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#usernameLoading').hide();
		$('#username').keyup(function(){
		  $('#usernameLoading').show();
	      $.post("check-docusername.php", {
	        username: $('#username').val()
	      }, function(response){
	        $('#usernameResult').fadeOut();
	        setTimeout("finishAjax('usernameResult', '"+escape(response)+"')", 500);
	      });
	    	return false;
		});
	});

	function finishAjax(id, response) {
	  $('#usernameLoading').hide();
	  $('#'+id).html(unescape(response));
	  $('#'+id).fadeIn();
	} //finishAjax
</script>
<!-- username check js end -->
</head>

<body class="fix-sidebar">
    <!--header.php includes preloader, top navigarion, logo, user dropdown-->
    <!--div id wrapper in header.php-->
    <!--left-sidebar.php includes mobile search bar, user profile, menu-->
    <?php include 'assets/header.php';
		include 'assets/left-sidebar.php';
		include 'assets/breadcrumbs.php';
	?>
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Add Doctor</h4>
                    </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <a href="../index.html" target="_blank" class="btn btn-info pull-right m-l-20 btn-rounded btn-outline hidden-xs hidden-sm waves-effect waves-light">Home</a>
                        <?php echo breadcrumbs(); ?>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
				
				<!--- imported add-doctors---->
				<!--Script to copy the input from fname to username-->
				<script>
					function copyTextValue() {
					var text1 = document.getElementById("fname").value;
					document.getElementById("username").value = text1;
					}
				</script>
				
				<div class="row">
				<div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title m-b-0">Doctors Information</h3>
                            <form data-toggle="validator" method="post">
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
                              
                         		<div class="row">
                                	<div class="col-md-6">
                                       <div class="form-group">
                                        	 <label class="control-label">First Name</label>
											<div class="col-sm-12 p-l-0">
												<div class="input-group">
													<div class="input-group-addon">Dr.</div>
													<input type="text" name="fname" class="form-control" id="fname" placeholder="Enter your first name" required>
													<!--onKeyUp="copyTextValue();"-->
												</div>
											</div>
                                         </div>
                                    </div>
                                    <!--/span-->
									 <div class="col-md-6">
										  <div class="form-group">
											   <label class="control-label">Last Name</label>
											   <input type="text" name="lname" id="lastName" class="form-control" placeholder="Enter your last name" required>
											   <!--<span class="help-block"> This field has error. </span>-->
										   </div>
									 </div>
                                    <!--/span-->
                                 </div>
                               
                                <div class="form-group">
                                    <label for="inputName1" class="control-label">Username</label>
                                    <input type="text" class="form-control" autocomplete="off" id="username" name="username" placeholder="Username is used to login" required>
                                    <!-- username check start -->
										<div>
										<span id="usernameLoading"><img src="../plugins/images/busy.gif" alt="Ajax Indicator" height="15" width="15" /></span>
										<span id="usernameResult" style="color: #E40003"></span>
										</div>
				                     <!-- username check end -->
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail" class="control-label">Email</label>
                                    <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Email" data-error="This email address is invalid" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-12 p-l-0">Gender</label>
                                    <div class="col-sm-12 p-l-0">
                                        <select class="form-control" name="gender" required>
                                            <option>Select Gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label  for="special">Speciality</span>
                                    </label>
                                    
                                        <input type="text" id="special" name="special" class="form-control" placeholder="e.g. Dentist" value="<?php if(isset($specialist) & !empty($specialist)){ echo $specialist; }?>" required>
                          
                                </div>
                                <div class="form-group">
                                    <label>Qualification</label>
                                    
                                        <input type="text" id="qualif" name="qualif" class="form-control" placeholder="e.g. MBBS" value="<?php if(isset($qualification) & !empty($qualification)){ echo $qualification; }?>" >
                                    
                                </div>
                                <div class="form-group">
                                    <label for="example-phone">Phone</span>
                                    </label>
                                    
                                        <input type="text" required id="example-phone" name="phone" class="form-control" placeholder="enter your phone number">
                                    
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword" class="control-label">Password</label>
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <input type="password" name="password" data-toggle="validator" data-minlength="6" class="form-control" id="inputPassword" placeholder="Password" required>
                                            <span class="help-block">Minimum of 6 characters</span> </div>
                                        <div class="form-group col-sm-6">
                                            <input type="password" name="retypepassword" class="form-control" id="inputPasswordConfirm" data-match="#inputPassword" data-match-error="Passwords don't match" placeholder="Confirm" required>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                <!--<div class="form-group">
                                    <div class="checkbox">
                                        <input type="checkbox" id="terms" data-error="Before you wreck yourself" required>
                                        <label for="terms"> Check yourself </label>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>-->
                                <div class="form-group">
                                    <button type="submit" name="docsubmit" class="btn btn-info">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
				</div>
				<!---End of impoted--->
                <!-- .right-sidebar -->
                <!--DNS Removed Service Panel-->
                <!-- /.right-sidebar -->
            </div>
            <!-- /.container-fluid -->
            <!--footer.php contains footer-->
            <?php include'assets/footer.php'; ?>
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!--jslink has all the JQuery links-->
    <?php include'assets/jslink.php'; ?>
</body>

</html>
