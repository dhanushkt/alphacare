<?php
include '../login/accesscontroladmin.php';
require('connect.php');
$ausername=$_SESSION['ausername'];
$id = $_GET['id'];

$query="SELECT fname, lname, dob, email, gender, phone, al1, al2, city, state, pc, doj FROM patients WHERE p_id='$id'";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);

$fetchmediinfo="SELECT * FROM medical_info WHERE p_id='$id'";
$fetchresult=mysqli_query($connection, $fetchmediinfo);
$fetchrow = mysqli_fetch_assoc($fetchresult);
//update patient profile
if(isset($_POST['updateprofile']))
{
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
		
		$updatequery="UPDATE patients SET fname='$fname', lname='$lname', dob='$dob', gender='$gender', phone='$phone', email='$email', al1='$al1', al2='$al2', state='$state', city='$city', pc='$pc' WHERE p_id='$id'";
		$updatequeryresult=mysqli_query($connection, $updatequery);
		if($updatequeryresult)
		{
			$queryupdate="SELECT fname, lname, dob, email, gender, phone, al1, al2, city, state, pc, doj FROM patients WHERE p_id='$id'";
			$resultupdate = mysqli_query($connection, $queryupdate);
			$row = mysqli_fetch_assoc($resultupdate);
			$smsg="PATIENT INFORMATION UPDATED";
			
		}
	
}
//update medical info
if(isset($_POST['updatemedic']))
{
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
		$smsg="MEDICAL INFORMATION UPDATED";
	}
	else
	{
		$fmsg="Error adding medical info";
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
      
	<link href="../plugins/bower_components/jqueryui/jquery-ui.min.css" rel="stylesheet">
	<link href="../plugins/bower_components/lobipanel/dist/css/lobipanel.min.css" rel="stylesheet">
	
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
                    <!-- .page title -->
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Patient Profile</h4>
                    </div>
                    <!-- /.page title -->
                    <!-- .breadcrumb -->
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                       <a href="../index.html" target="_blank" class="btn btn-info pull-right m-l-20 btn-rounded btn-outline hidden-xs hidden-sm waves-effect waves-light">Home</a>
                        <?php echo breadcrumbs(); ?>
                    </div>
                    <!-- /.breadcrumb -->
                </div>
                <!--DNS added Dashboard content-->
                
                 <!--DNS Added Model-->
                <div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h4 class="modal-title">Importent Instruction</h4>
                                        </div>
                                        <div class="modal-body">
                                       	 To Edit Admin information or to delete Admin account you need to login to that admin account.
										</div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                            <a href="logout.php" class="btn btn-danger waves-effect waves-light">Proceed for login</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                         <!--DNS model END-->
               
                
                <!--row -->
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
                    <div class="col-md-4 col-xs-12">
                        <div class="white-box">
                            <div class="user-bg"> <img width="100%" height="100%" alt="user" src="../plugins/images/profile-menu.png">
                                <div class="overlay-box">
                                    <div class="user-content">
                                        <a href="javascript:void(0)"><?php if($row["gender"]=='male') { ?> <img src="../plugins/images/users/doctor-male.jpg" class="thumb-lg img-circle" ><?php } else { ?> <img src="../plugins/images/users/doctor-female.jpg" class="thumb-lg img-circle" > <?php } ?> </a>
                                        <!--<h4 class="text-white"><?php //echo $row["username"]; ?></h4>
                                        <h5 class="text-white"><?php //echo $row["email"]; ?></h5>-->
                                    </div>
                                </div>
                            </div>
							<div class="user-btm-box">
                                <!-- .row -->
                                <div class="row text-center m-t-10">
                                    <div class="col-md-6 b-r"><strong>Name</strong>
                                        <p><?php echo $row["fname"]." ".$row["lname"]; ?></p>
                                    </div>
                                    <div class="col-md-6"><strong>Age</strong>
                                        <p><?php echo date_diff(date_create($row["dob"]), date_create('today'))->y; ?></p>
                                    </div>
                                </div>
                                <!-- /.row -->
                                <hr>
                                <!-- .row -->
                                <div class="row text-center m-t-10">
                                    <div class="col-md-6 b-r"><strong>Email ID</strong>
                                        <p><?php echo $row["email"]; ?> </p>
                                    </div>
                                    <div class="col-md-6"><strong>Phone</strong>
                                        <p><?php echo $row["phone"]; ?></p>
                                    </div>
                                </div>
                                <!-- /.row -->
                                <hr>
                                <!-- .row -->
                                <div class="row text-center m-t-10 ">
                                    <div class="col-md-12"><strong>Address</strong>
                                        <p><?php echo $row["al1"]." ".$row["al2"];  ?>
                                            <br/> <?php echo $row["city"]." , ".$row["state"];  ?></p>
                                    </div>
                                </div>
                                <!--<hr>-->
                                <!-- /.row -->
                                <!--<div class="col-md-4 col-sm-4 text-center">
                                    <p class="text-purple"><i class="ti-facebook"></i></p>
                                    <h1>258</h1> </div>
                                <div class="col-md-4 col-sm-4 text-center">
                                    <p class="text-blue"><i class="ti-twitter"></i></p>
                                    <h1>125</h1> </div>
                                <div class="col-md-4 col-sm-4 text-center">
                                    <p class="text-danger"><i class="ti-google"></i></p>
                                    <h1>140</h1> </div>-->
                            </div>
                          
                        </div>
                    </div>
                    <div class="col-md-8 col-xs-12">
                        <div class="white-box">
                            <ul class="nav customtab nav-tabs" role="tablist">
                                <!--<li role="presentation" class="nav-item"><a href="#home" class="nav-link " aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="fa fa-home"></i></span><span class="hidden-xs"> Activity</span></a></li>-->
                                <li role="presentation" class="nav-item"><a href="#profile" class="nav-link active" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="fa fa-user"></i></span> <span class="hidden-xs">Info</span></a></li>
                                <li role="presentation" class="nav-item"><a href="#medrep" class="nav-link" aria-controls="medrep" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs">Medical Report</span></a></li>
                                <li role="presentation" class="nav-item"><a href="#updatemedicinfo" class="nav-link" aria-controls="updatemedicinfo" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="fa fa-key"></i></span> <span class="hidden-xs">Update Medical Info</span></a></li>
								<li role="presentation" class="nav-item"><a href="#editpatientinfo" class="nav-link" aria-controls="editpatientinfo" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="fa fa-key"></i></span> <span class="hidden-xs">Edit Patient Info</span></a></li>
								<li role="presentation" class="nav-item"><a href="#removepatient" class="nav-link" aria-controls="removepatient" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="fa fa-key"></i></span> <span class="hidden-xs">Remove</span></a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="profile">
                                    <div class="row">
                                        <div class="col-md-3 col-xs-6 b-r"> <strong>Full Name</strong>
										<br>
										<p class="text-muted"><?php echo $row["fname"]." ".$row["lname"]; ?></p>
									</div>
									<div class="col-md-3 col-xs-6 b-r"> <strong>Disease</strong>
										<br>
										<p class="text-muted"><?php echo $fetchrow["disease"] ?></p>
									</div>
									<div class="col-md-3 col-xs-6 b-r"> <strong>Date of birth</strong>
										<br>
										<p class="text-muted"><?php $dateb=$row['dob'];
											$myDateTime = DateTime::createFromFormat('Y-m-d', $dateb);
											$dobc = $myDateTime->format('d-m-Y');  echo $dobc; ?></p>
									</div>
									<div class="col-md-3 col-xs-6"> <strong>Blood group</strong>
										<br>
										<p class="text-muted"><?php echo $fetchrow["bgroup"] ?></p>
									</div>
                                        
                                    </div>
                                    
                                    
                                </div>
                                
                               
                            <div class="tab-pane" id="medrep">
                             <div class="row">
								 <div class="col-md-12">
								<div class="panel1 panel panel-info">
									<div class="panel-heading">Medical Information (sorted by date)
                           			 </div>
									<div class="panel-body">
										<table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>BP (mm Hg) </th>
                                            <th>Sugar (mg/dl)</th>
                                            <th>Temprature (°F)</th>
											<th>Date</th>
                                        </tr>
                                    </thead>
									<tbody>
                              <?php
								 $medinfo="SELECT * FROM medical_info WHERE p_id='$id' ORDER BY date DESC";
								 $medinfores = mysqli_query($connection, $medinfo);
								//$medinforow = mysqli_fetch_assoc($medinfores);
								foreach($medinfores as $key=>$medinfores)
								{
                              ?>
										<tr>
                                            <th scope="row"><?php echo $key+1; ?></th>
                                            <td><?php echo $medinfores["bp"]; ?></td>
                                            <td><?php echo $medinfores["sugar"]; ?></td>
                                            <td><?php echo $medinfores["temp"]; ?></td>
											<td><?php $date=$medinfores["date"];
											$myDateTime = DateTime::createFromFormat('Y-m-d', $date);
											$datec = $myDateTime->format('d-m-Y');  echo $datec; ?></td>
                                        </tr> 
                       
									<?php } ?>
											</tbody>
										</table>
									</div>
								
								 </div>
								</div>
								</div>
                                </div>
                                
                  <div class="tab-pane" id="updatemedicinfo">
					<div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">Update Medical Info</div>
                            <div class="panel-wrapper collapse in" aria-expanded="true">
                                <div class="panel-body">
                                    <form method="post" data-toggle="validator">
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Disease</label>
                                                        <input type="text" name="disease" class="form-control" value="<?php echo $fetchrow['disease']; ?>">
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Blood Group</label>
                                                        <select class="form-control" name="bg">
															
															<option <?php if($fetchrow["bgroup"]=="A +'ve"){echo 'selected';}?> value="A +'ve">A +'ve</option>
															<option <?php if($fetchrow["bgroup"]=="A -'ve"){echo 'selected';}?> value="A -'ve">A -'ve</option>
															<option <?php if($fetchrow["bgroup"]=="B +'ve"){echo 'selected';}?> value="B +'ve">B +'ve</option>
															<option <?php if($fetchrow["bgroup"]=="B -'ve"){echo 'selected';}?> value="B -'ve">B -'ve</option>
															<option <?php if($fetchrow["bgroup"]=="AB +'ve"){echo 'selected';}?> value="AB +'ve">AB +'ve</option>
															<option <?php if($fetchrow["bgroup"]=="AB -'ve"){echo 'selected';}?> value="AB -'ve">AB -'ve</option>
															<option <?php if($fetchrow["bgroup"]=="O +'ve"){echo 'selected';}?> value="O +'ve">O +'ve</option>
															<option <?php if($fetchrow["bgroup"]=="O -'ve"){echo 'selected';}?> value="O -'ve">O -'ve</option>
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
                                                        <input type="text" name="height" class="form-control" value="<?php echo $fetchrow['height']; ?>">
                                                         <span class="font-13 text-muted">in cm</span>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Weight</label>
                                                        <input type="number" name="weight" class="form-control" value="<?php echo $fetchrow['weight']; ?>">
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
															<input data-date-format="dd-mm-yyyy" data-mask="99-99-9999" type="text" class="form-control" id="datepicker-autoclose" name="doe" placeholder="dd-mm-yyyy" required>
														</div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                            </div>
                                            
                                        </div>
                                        <div class="form-actions">
                                            <button type="submit" name="updatemedic" class="btn btn-success"> <i class="fa fa-check"></i> UPDATE</button>
                                            
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                                
			</div> <!--update medic info tab end-->
								
			<div class="tab-pane" id="editpatientinfo"><!--edit patient profile tab starts-->
			<div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">Patient Details</div>
                            <div class="panel-wrapper collapse in" aria-expanded="true">
                                <div class="panel-body">
                                    <form method="post" data-toggle="validator">
                                        <div class="form-body">
                                            <h3 class="box-title">Personal Info</h3>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">First Name</label>
                                                        <input type="text" id="firstName" name="fname" class="form-control" placeholder="Enter first name" required value="<?php echo $row['fname']; ?>">
                                                         </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Last Name</label>
                                                        <input type="text" id="lastName" name="lname" class="form-control" placeholder="Enter last name" value="<?php echo $row['lname']; ?>">
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
                                                                    <input <?php if($row["gender"]=="male"){echo 'checked';}?> type="radio" name="gender"  id="radio1" value="male">
                                                                    <label for="radio1">Male</label>
                                                                </div>
                                                            </label>
                                                            <label class="radio-inline">
                                                                <div class="radio radio-info">
                                                                    <input <?php if($row["gender"]=="female"){echo 'checked';}?> type="radio" name="gender" id="radio2" value="female">
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
															<input data-date-format="dd-mm-yyyy" data-mask="99-99-9999" type="text" class="form-control" id="datepicker" name="dob" placeholder="dd-mm-yyyy" required value="<?php $dateb=$row['dob'];
											$myDateTime = DateTime::createFromFormat('Y-m-d', $dateb);
											$dobc = $myDateTime->format('d-m-Y');  echo $dobc; ?>">
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
                                                        <input type="tel" id="firstName" name="phone" class="form-control" placeholder="Enter phone no." value="<?php echo $row['phone']; ?>" >
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Email</label>
                                                        <input type="email" name="email" id="lastName" class="form-control" placeholder="Enter email address" data-error="email address is invalid" value="<?php echo $row['email']; ?>">
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
                                                        <input name="al1" type="text" class="form-control" required value="<?php echo $row['al1']; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 ">
                                                    <div class="form-group">
                                                        <label>Address line 2</label>
                                                        <input type="text" name="al2" class="form-control" value="<?php echo $row['al2']; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                
                                                <!--/span-->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>State</label>
                                                        <select class="form-control" name="state">
														<option value="" selected disabled hidden><?php echo $row['state']; ?></option>
                                                        <?php include 'assets/states.php'; ?>
														</select>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>City</label>
                                                        <input name="city" type="text" class="form-control" required value="<?php echo $row['city']; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/row-->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Zip Code</label>
                                                        <input name="pc" required data-minlength="6" data-error="Invalid zip code" type="number" class="form-control" value="<?php echo $row['pc']; ?>">
                                                        <div class="help-block with-errors"></div> 
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                
                                                <!--/span-->
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <button type="submit" name="updateprofile" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>	
										
			</div> <!--edit patient profile tab ends-->   
			<div class="tab-pane" id="removepatient"> <!--edit patient profile tab ends--> 
				<div class="text-center">
				<a href="#" class="fcbtn btn btn-danger model_img deleteAdmin" data-id="<?php echo $id ?>" id="deleteDoc">Remove Patient Record</a>
				</div>
				
				
			</div>					
                            </div>
                        </div>
                    </div>
                </div>
              
                <!--/row -->
                
                <!--DNS End-->
                <!-- .row -->
                <!--<div class="row">
                    <div class="col-md-12">
                        <div class="white-box">
                            <h3 class="box-title">Blank Starter page</h3>
                        </div>
                    </div>
                </div>-->
                <!-- /.row -->
                <!-- .right-sidebar -->
                 <!-- Removed Service Panel DNS-->
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
	<script src="../plugins/bower_components/jqueryui/jquery-ui.min.js"></script>
	<!-- Draggable-panel -->
	<script src="../plugins/bootstrap/dist/js/bootstrap-3.3.7.min.js"></script>
	<script src="../plugins/bower_components/lobipanel/dist/js/lobipanel.min.js"></script>
    <script>
    $(function() {
        $('.panel1').lobiPanel({
            sortable: true,
            reload: false,
            editTitle: false,
			close: false,
			minimize: false,
			
        });
    });
    </script>
	
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
$(document).ready(function() {
  $('.deleteAdmin').click(function(){
    id = $(this).attr('data-id');
      swal({
          title: "Are you sure?",
          text: "You will not be able to recover this data!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Yes, delete it!",
          closeOnConfirm: false,
		  closeOnCancel: false
      },function(isConfirm)
		 {   
           if (isConfirm) {
			   $.ajax({
			  url: 'deletepatient.php?id='+id,
			  type: 'DELETE',
			  data: {id:id},
			  success: function(){
				swal("Deleted!", "Data has been deleted.", "success");
				window.location.replace("view-patients.php");
          }
        });   
            } else {     
                swal("Cancelled", "Patient information is safe :)", "error");   
            }
      });
  });

});
	
</script>
    
</body>

</html>
