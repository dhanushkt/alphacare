<?php
include '../login/accesscontroladmin.php';
require('connect.php');
$ausername=$_SESSION['ausername'];

$id = $_GET['id'];
$getapointquery="SELECT *,doctors.fname,doctors.lname,doctors.specialist FROM appointments INNER JOIN doctors ON appointments.doc_id = doctors.doc_id WHERE ap_token='$id'";
$getapointresult = mysqli_query($connection, $getapointquery);
$apointrow = mysqli_fetch_assoc($getapointresult);

if (isset($_POST['apupdate']))
	{
		$apointstatus=mysqli_real_escape_string($connection,$_POST['apstatus']);
		if($apointstatus=='Scheduled')
		{
			$apointtime=mysqli_real_escape_string($connection,$_POST['aptime']);
			$updatequery="UPDATE appointments SET status='$apointstatus', time='$apointtime' WHERE ap_token='$id'";
			$updateresult=mysqli_query($connection,$updatequery);
			if($updateresult)
			{
				$smsg="MEDICAL INFORMATION UPDATED";
				echo'<script>window.history.go(-2);</script>';
			}
			else
			{
				$fmsg=mysqli_error($connection);
			}
		}
		elseif($apointstatus=='Cancelled, Doctor unavailable')
		{
			$updatequery="UPDATE appointments SET status='$apointstatus', time=NULL WHERE ap_token='$id'";
			$updateresult=mysqli_query($connection,$updatequery);
			if($updateresult)
			{
				$smsg="MEDICAL INFORMATION UPDATED";
				echo'<script>window.history.go(-2);</script>';
			}
			else
			{
				$fmsg=mysqli_error($connection);
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
                        <h4 class="page-title">Edit Medical Details</h4>
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
                            <div class="panel-heading">Process Appointment</div>
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
                                   
                                    <form method="post" data-toggle="validator">
                                        <div class="form-body">
                                            <h3 class="box-title">Appointment Information</h3>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Name</label>
                                                        <input readonly type="text" id="Name" name="mname" class="form-control" required value="<?php echo $apointrow["name"]; ?>">
                                                     </div>
                                                </div>
												<div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Gender</label>
                                                        <input readonly type="text" id="brand" class="form-control" value="<?php echo $apointrow["sex"]; ?>">
                                                     </div>
                                                </div>
												
                                                <!--/span-->
                                                
                                                <!--/span-->
                                            </div>
                                            <!--/row-->
                                           
                                            <!--/row-->
                                            
											<div class="row">
												<div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Phone No</label>
                                                        <input readonly type="tel" id="description" name="mdescrip" class="form-control" placeholder="" value="<?php echo $apointrow["phno"]; ?>">
                                                    </div>
                                                </div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label" for="inputdose">Date of birth</label>
														<input type="text" class="form-control" id="inputdose" readonly value="<?php $dateb=$apointrow['dob'];
														$myDateTime = DateTime::createFromFormat('Y-m-d', $dateb);
														$dobc = $myDateTime->format('d-m-Y');  echo $dobc; ?>">
													 </div>
												</div>
											</div>
											
											<div class="row">
												<div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Email</label>
                                                        <input readonly type="email" id="brand" class="form-control" value="<?php echo $apointrow["aemail"]; ?>">
                                                     </div>
                                                </div>
                                                
                                                <!--/span-->
                                            </div>
											<div class="row">
												
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label" for="inputdose">Date of appointment</label>
														<input type="text" class="form-control" id="inputdose" readonly value="<?php $datea=$apointrow['doa'];
														$myDateTime = DateTime::createFromFormat('Y-m-d', $datea);
														$doac = $myDateTime->format('d-m-Y');  echo $doac; ?>">
													 </div>
												</div>
												<div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Doctor</label>
                                                        <input readonly type="tel" id="description" name="mdescrip" class="form-control" placeholder="" value="<?php echo 'Dr. '.$apointrow['fname'].' '.$apointrow['lname'].' , '.$apointrow['specialist']; ?>">
                                                    </div>
                                                </div>
											</div>
											<div class="row">
												<div class="col-md-6">
												   <div class="form-group">
													<label class="control-label">Appointment Status</label>
													<div class="radio-list">
														<label class="radio-inline p-0">
															<div class="radio radio-info">
																<input onClick="document.getElementById('time').disabled = false;" type="radio" name="apstatus" id="radio1" value="Scheduled" checked>
																<label for="radio1">Scheduled</label>
															</div>
														</label>
														<label class="radio-inline">
															<div class="radio radio-info">
																<input onClick="document.getElementById('time').disabled = true;" type="radio" name="apstatus" id="radio2" value="Cancelled, Doctor unavailable">
																<label for="radio2">Cancelled</label>
															</div>
														</label>
													</div>
												 </div>
												</div>
												<div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Pick a time of appointment</label>
                                                        <input required type="time" data-date-format="hh:mm:ss" id="time" class="form-control clockpicker"  name="aptime">
                                                     </div>
                                                </div>
											</div>
                                            <!--/row-->
                                        </div>
                                        <div class="form-actions">
                                            <button type="submit" name="apupdate" class="btn btn-success"> <i class="fa fa-check"></i> Update</button>
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
