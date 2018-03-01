<?php
include '../login/accesscontroldoc.php';
require('connect.php');
if(isset($_SESSION['dusername']))
{
	$ausername=$_SESSION['dusername'];
}
else if(isset($_SESSION['ausername']))
{
	$ausername=$_SESSION['ausername'];
}

if (isset($_POST['psubmit']))
	{
		 //real eacape sting is used to prevent sql injection hacking
		$fname=mysqli_real_escape_string($connection,$_POST['fname']);
		$lname=mysqli_real_escape_string($connection,$_POST['lname']);
		$date=$_POST['dob'];
		$myDateTime = DateTime::createFromFormat('d-m-Y', $date);
		$dob = $myDateTime->format('Y-m-d');
		$email=mysqli_real_escape_string($connection,$_POST['email']);
		$gender=mysqli_real_escape_string($connection,$_POST['gender']);
		$al1=mysqli_real_escape_string($connection,$_POST['al1']);
		$al2=mysqli_real_escape_string($connection,$_POST['al2']);
		$state=mysqli_real_escape_string($connection,$_POST['state']);
		$city=mysqli_real_escape_string($connection,$_POST['city']);
		$pc=mysqli_real_escape_string($connection,$_POST['pc']);
		$phone=mysqli_real_escape_string($connection,$_POST['phone']);
		$doj= mysqli_real_escape_string($connection,$_POST['doj']);
		$myDateTime1 = DateTime::createFromFormat('d-m-Y', $doj);
		$dojc = $myDateTime1->format('Y-m-d');
		//sqll query
		//double quotes outside so we can use single quotes inside
			
			$emailsql="SELECT * FROM `patients` WHERE email='$email'";
			$checkemail=mysqli_query($connection, $emailsql);
			$counte=mysqli_num_rows($checkemail);
			if($counte==1)
			{
				$fmsg = "email alredy exists";
			}
			else
			{
			
				$query="INSERT INTO `patients`(fname, lname, dob, gender, phone, email, al1, al2, state, city, pc, doj) VALUES ('$fname','$lname','$dob','$gender','$phone','$email','$al1','$al2','$state','$city','$pc','$dojc')";
				$result = mysqli_query($connection, $query); 
				//takes two arguments 
				if($result)
				{
					$smsg = "Patient registered successfully.";
					$check=$_POST['doe'];
					if(!$check=="")
					{
						$query1="SELECT p_id FROM patients WHERE (fname='$fname' AND dob='$dob')";
						$result1=mysqli_query($connection, $query1);
						$row = mysqli_fetch_assoc($result1);
						$id=$row["p_id"];
						$disease=mysqli_real_escape_string($connection,$_POST['disease']);
						$bg=mysqli_real_escape_string($connection,$_POST['bg']);
						$bp=mysqli_real_escape_string($connection,$_POST['bp']);
						$sugar=mysqli_real_escape_string($connection,$_POST['sugar']);
						$temp=mysqli_real_escape_string($connection,$_POST['temp']);
						$height=mysqli_real_escape_string($connection,$_POST['height']);
						$weight=mysqli_real_escape_string($connection,$_POST['weight']);
						$date1=mysqli_real_escape_string($connection,$_POST['doe']);
						$myDateTime2 = DateTime::createFromFormat('d-m-Y', $date1);
						$doe = $myDateTime2->format('Y-m-d');
		
						$insertmed="INSERT INTO `medical_info`(p_id, disease, bgroup, bp, sugar, temp, height, weight, date) VALUES ('$id','$disease','$bg','$bp','$sugar','$temp','$height','$weight','$doe')";
						$result2 = mysqli_query($connection, $insertmed); 
						if($result2)
						{
							$smsg1="Medical info added";
						}
						else
						{
							$fmsg="Error adding medical info";
						}
					}
					else
					{
						$fmsg1="Medical info not added!";
					}
					
				}
				else
				{
		
					$fmsg = "User Registration Failed".mysqli_error($connection);
				}
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
    <!-- Date picker plugins css -->
    <link href="../plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
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
                        <h4 class="page-title">Add Patient</h4>
                    </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <a href="../index.html" target="_blank" class="btn btn-info pull-right m-l-20 btn-rounded btn-outline hidden-xs hidden-sm waves-effect waves-light">Home</a>
                        <?php echo breadcrumbs(); ?>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
				
				<!--- imported add-doctors---->
				<!--.row-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">Enter Patient Details</div>
                            <div class="panel-wrapper collapse in" aria-expanded="true">
                                <div class="panel-body">
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
                                   <?php if(isset($smsg1)) { ?>
										<div class="alert alert-success alert-dismissable">
											<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
											 <?php echo $smsg1; ?>
										</div> 
								<?php }?>
                                    <?php if(isset($fmsg1)) { ?>
									<div class="alert alert-danger alert-dismissable">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
										 <?php echo $fmsg1; ?>
									</div> 
					            <?php }?> 
                                    <form method="post" data-toggle="validator">
                                        <div class="form-body">
                                            <h3 class="box-title">Personal Info</h3>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">First Name</label>
                                                        <input type="text" id="firstName" name="fname" class="form-control" placeholder="Enter first name" required>
                                                         </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Last Name</label>
                                                        <input type="text" id="lastName" name="lname" class="form-control" placeholder="Enter last name">
                                                         </div>
                                                </div>
                                                <!--/span-->
                                            </div>
                                            <!--/row-->
                                            <div class="row">
                                                <!--/span-->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Gender</label>
                                                        <div class="radio-list">
                                                            <label class="radio-inline p-0">
                                                                <div class="radio radio-info">
                                                                    <input type="radio" name="gender" id="radio1" value="male">
                                                                    <label for="radio1">Male</label>
                                                                </div>
                                                            </label>
                                                            <label class="radio-inline">
                                                                <div class="radio radio-info">
                                                                    <input type="radio" name="gender" id="radio2" value="female">
                                                                    <label for="radio2">Female</label>
                                                                </div>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <!--/span-->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Date of Birth</label>
                                                        <div class="input-group">
															<div class="input-group-addon"><i class="icon-calender"></i></div>
															<input data-date-format="dd-mm-yyyy" data-mask="99-99-9999" type="text" class="form-control" id="datepicker" name="dob" placeholder="dd-mm-yyyy" required>
														</div>
                                                   		<!--<span class="font-13 text-muted">dd-mm-yyyy</span>-->
                                                    </div>
                                                </div>
                                                <!--/span-->
                                            </div>
                                            <!--/row-->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Phone</label>
                                                        <input type="tel" id="firstName" name="phone" class="form-control" placeholder="Enter phone no.">
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Email</label>
                                                        <input type="email" name="email" id="lastName" class="form-control" placeholder="Enter email address" data-error="email address is invalid">
                                                        <div class="help-block with-errors"></div>
                                                         </div>
                                                         
                                                </div>
                                                <!--/span-->
                                            </div>
                                            <!--/row-->
                                            <h3 class="box-title m-t-40">Address</h3>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12 ">
                                                    <div class="form-group">
                                                        <label>Address line 1</label>
                                                        <input name="al1" type="text" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 ">
                                                    <div class="form-group">
                                                        <label>Address line 2</label>
                                                        <input type="text" name="al2" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                
                                                <!--/span-->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>State</label>
                                                        <select class="form-control" name="state" required>
														<option value="" selected disabled hidden>Select State</option>
                                                        <?php include 'assets/states.php'; ?>
														</select>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>City</label>
                                                        <input name="city" type="text" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/row-->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Zip Code</label>
                                                        <input name="pc" required data-minlength="6" data-error="Invalid zip code" type="number" class="form-control">
                                                        <div class="help-block with-errors"></div> 
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                
                                                <!--/span-->
                                            </div>
                                            <h3 class="box-title m-t-40">Admit Info</h3>
                                            <hr>
                                            <div class="row">
                                            <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Date of Joining</label>
                                                        <div class="input-group">
															<div class="input-group-addon"><i class="icon-calender"></i></div>
															<input data-date-format="dd-mm-yyyy" data-mask="99-99-9999" type="text" class="form-control" id="datepicker-autoclose1" name="doj" placeholder="dd-mm-yyyy" required>
														</div>
                                                   		<!--<span class="font-13 text-muted">dd-mm-yyyy</span>-->
                                                    </div>
                                                </div>
											</div>
                                            
                                            <h3 class="box-title m-t-40">Medical Info</h3>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Disease</label>
                                                        <input type="text" name="disease" class="form-control">
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Blood Group</label>
                                                        <select class="form-control" name="bg">
															<option>Select Blood group</option>
															<option value="A +'ve">A +'ve</option>
															<option value="A -'ve">A -'ve</option>
															<option value="B +'ve">B +'ve</option>
															<option value="B -'ve">B -'ve</option>
															<option value="AB +'ve">AB +'ve</option>
															<option value="AB -'ve">AB -'ve</option>
															<option value="O +'ve">O +'ve</option>
															<option value="O -'ve">O -'ve</option>
														</select>
                                                        
                                                    </div>
                                                </div>
                                                <!--/span-->
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Blood Preasure</label>
                                                        <input name="bp" type="text" class="form-control" data-mask="999/99">
                                                        <span class="font-13 text-muted">in mm Hg</span>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Sugar</label>
                                                        <input type="text" name="sugar" class="form-control">
                                                        <span class="font-13 text-muted">in mg/dl</span>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Height</label>
                                                        <input type="text" name="height" class="form-control">
                                                         <span class="font-13 text-muted">in cm</span>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Weight</label>
                                                        <input type="number" name="weight" class="form-control">
                                                        <span class="font-13 text-muted">in kg</span>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Temperature</label>
                                                        <input type="text" name="temp" class="form-control">
                                                        <span class="font-13 text-muted">in °F</span>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label></label>
                                                        <label>Date of entry</label>
                                                        <div class="input-group">
															<div class="input-group-addon"><i class="icon-calender"></i></div>
															<input data-date-format="dd-mm-yyyy" data-mask="99-99-9999" type="text" class="form-control" id="datepicker-autoclose" name="doe" placeholder="dd-mm-yyyy">
														</div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                            </div>
                                            
                                        </div>
                                        <div class="form-actions">
                                            <button type="submit" name="psubmit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                                            <button type="button" class="btn btn-default">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--./row-->
				
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
    <!-- Date Picker Plugin JavaScript -->
    <script src="../plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="../plugins/js/mask.js"></script>
    <script>
		jQuery('.mydatepicker, #datepicker').datepicker();
    jQuery('#datepicker-autoclose').datepicker({
        autoclose: true,
        todayHighlight: true
    });
	</script>
	<script>
		jQuery('.mydatepicker, #datepicker').datepicker();
    jQuery('#datepicker-autoclose1').datepicker({
        autoclose: true,
        todayHighlight: true
    });
	</script>
</body>

</html>
