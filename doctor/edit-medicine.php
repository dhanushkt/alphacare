<?php
include '../login/accesscontroldoc.php';
require('connect.php');
if(isset($_SESSION['dusername']))
{
	$ausername=$_SESSION['dusername'];
}
elseif(isset($_SESSION['ausername']))
{
	$ausername=$_SESSION['ausername'];
}
$id = $_GET['id'];
$getmedquery="SELECT *,doctors.fname,doctors.lname FROM medicines JOIN doctors ON medicines.doc_id=doctors.doc_id WHERE med_id='$id'";
$getmedresult = mysqli_query($connection, $getmedquery);
$medrow = mysqli_fetch_assoc($getmedresult);

if (isset($_POST['medupdate']))
	{
		 //real eacape sting is used to prevent sql injection hacking
		$mname=mysqli_real_escape_string($connection,$_POST['mname']);
		$mbrand=mysqli_real_escape_string($connection,$_POST['mbrand']);
		$mdescrip=mysqli_real_escape_string($connection,$_POST['mdescrip']);
		$mdose=mysqli_real_escape_string($connection,$_POST['mdose']);
		$medstatus=mysqli_real_escape_string($connection,$_POST['medstatus']);
	
		$updatequery="UPDATE medicines SET name='$mname', brand='$mbrand', description='$mdescrip', dose='$mdose', status='$medstatus' WHERE med_id='$id'";
        $updateresult=mysqli_query($connection,$updatequery);
		
		if($updateresult)
		{
				$smsg="MEDICAL INFORMATION UPDATED";
			echo'<script>window.history.go(-2);</script>';
		}
	else{
		$fmsg=mysqli_error($connection);
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
                            <div class="panel-heading">Update Medical Details</div>
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
                                            <h3 class="box-title">Medical Info</h3>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Name</label>
                                                        <input type="text" id="Name" name="mname" class="form-control" placeholder="" required value="<?php echo $medrow["name"]; ?>">
                                                         </div>
                                                </div>
                                                <!--/span-->
                                                
                                                <!--/span-->
                                            </div>
                                            <!--/row-->
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Brand</label>
                                                        <input type="text" id="brand" name="mbrand" class="form-control" placeholder="" value="<?php echo $medrow["brand"]; ?>">
                                                         </div>
                                                </div>
                                            </div>
                                            <!--/row-->
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Description</label>
                                                        <input type="text" id="description" name="mdescrip" class="form-control" placeholder="" value="<?php echo $medrow["description"]; ?>">
                                                    </div>
                                                </div>
                                                <!--/span-->
                                            </div>
											<div class="row">
												<div class="col-md-6">
                                            <div class="form-group">
                                        <label class="control-label" for="inputdose">Dose</label>
                                        <input type="text" class="form-control" id="inputdose" name="mdose" placeholder="" data-mask="9-9-9" required="" value="<?php echo $medrow["dose"]; ?>">
                                             </div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
													<label class="control-label">Prescribed By</label>
                                                        <input disabled type="text" id="brand" name="mbrand" class="form-control" placeholder="" value="<?php echo 'Dr. '.$medrow["fname"].' '.$medrow["lname"]; ?>">
                                                      </div>
												</div>
											</div>
                                       <div class="form-group">
										<label class="control-label">Status</label>
										<div class="radio-list">
											<label class="radio-inline p-0">
												<div class="radio radio-info">
													<input type="radio" name="medstatus" id="radio1" value="ongoing" <?php if($medrow["status"]=="ongoing"){echo 'checked';}?>>
													<label for="radio1">Ongoing</label>
												</div>
											</label>
											<label class="radio-inline">
												<div class="radio radio-info">
													<input type="radio" name="medstatus" id="radio2" value="stopped"
														   <?php if($medrow["status"]=="stopped"){echo 'checked';}?>>
													<label for="radio2">Stopped</label>
												</div>
											</label>
										</div>
                                     </div>
                                            <!--/row-->
                                        </div>
                                        <div class="form-actions">
                                            <button type="submit" name="medupdate" class="btn btn-success"> <i class="fa fa-check"></i> Update</button>
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
