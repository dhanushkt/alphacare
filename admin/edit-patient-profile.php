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
//update profile
if(isset($_POST['updateprofile']))
{
	$fname=mysqli_real_escape_string($connection,$_POST['fname']);
	$lname=mysqli_real_escape_string($connection,$_POST['lname']);
	$dob= mysqli_real_escape_string($connection,$_POST['dob']);
	$email=mysqli_real_escape_string($connection,$_POST['email']);
	$gender=mysqli_real_escape_string($connection,$_POST['gender']);
	$al1=mysqli_real_escape_string($connection,$_POST['al1']);
	$al2=mysqli_real_escape_string($connection,$_POST['special']);
	$phone=mysqli_real_escape_string($connection,$_POST['phone']);

	$uquery="UPDATE patients SET fname='$fname', lname='$lname', username='$username', email='$email', gender='$gender', al1='$al1', al2='$al2', phone='$phone' WHERE p_id='$id'";
	$uresult = mysqli_query($connection, $uquery);
	if($uresult)
	{
		$squery="SELECT fname, lname, username, email, gender, qualification, specialist, phone FROM doctors WHERE doc_id='$id'";
		$sresult = mysqli_query($connection, $squery);
		$row = mysqli_fetch_assoc($sresult);
		$smsg="Profile updated successfully!";

	}
	else
	{
		$fmsg="error!";
	}
}
//change password
if(isset($_POST['changepw']))
{
	$oldpw=md5($_POST['oldpassword']);
	if($oldpw==$row["password"])
	{
		$npw=md5($_POST['newpassword']);
		$pwquery="UPDATE doctors SET password='$npw' WHERE doc_id='$id'";
		$pwresult = mysqli_query($connection, $pwquery);
		$smsg="Password updated successfully!";
		
	}
	else
	{
		$fmsg="Wrong old password!";
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
								<li role="presentation" class="nav-item"><a href="#updatemedicinfo" class="nav-link" aria-controls="updatemedicinfo" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="fa fa-key"></i></span> <span class="hidden-xs">Edit Patient Info</span></a></li>
								<li role="presentation" class="nav-item"><a href="#updatemedicinfo" class="nav-link" aria-controls="updatemedicinfo" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="fa fa-key"></i></span> <span class="hidden-xs">Remove</span></a></li>
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
								 $medinfo="SELECT * FROM medical_info WHERE p_id='$id' ORDER BY date";
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
															<input data-date-format="dd-mm-yyyy" data-mask="99-99-9999" type="text" class="form-control" id="datepicker-autoclose" name="doe" placeholder="dd-mm-yyyy" required>
														</div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                            </div>
                                            
                                        </div>
                                        <div class="form-actions">
                                            <button type="submit" name="psubmit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                                            
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                                
			</div> <!--update medic info tab end-->
										
                               
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
    
</body>

</html>
