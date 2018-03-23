<?php
include '../login/accesscontrolstaff.php';
require('connect.php');
if(isset($_SESSION['susername']))
{
	$ausername=$_SESSION['susername'];
}
elseif(isset($_SESSION['ausername']))
{
	$ausername=$_SESSION['ausername'];
}

$getpinfoquery="SELECT p_id,fname,lname,wards.ward_no,wards.floor FROM patients INNER JOIN wards ON patients.ward_id=wards.ward_id WHERE dod IS NULL";
$getpinforesult=mysqli_query($connection,$getpinfoquery);

date_default_timezone_set('Asia/Kolkata');

if(isset($_POST['addvisitor']))
{
	$vname=mysqli_real_escape_string($connection,$_POST['vname']);
	$vsex=mysqli_real_escape_string($connection,$_POST['gender']);
	$pid=$_POST['patient'];
	if($_POST['datetime']=='now')
	{
		$vdate=date('Y-m-d');
		$vtime=date('H:i', time());
	}
	elseif($_POST['datetime']=='custom')
	{
		$date=$_POST['dov'];
		$myDateTime = DateTime::createFromFormat('d-m-Y', $date);
		$vdate = $myDateTime->format('Y-m-d');
		$vtime = $_POST['time'];
	}
	$insertvquery="INSERT INTO `visitors` (vname,vsex,p_id,vdate,vtime) VALUES ('$vname','$vsex','$pid','$vdate','$vtime')";
	$insertvresult=mysqli_query($connection,$insertvquery);
	if($insertvresult)
	{
		$smsg="Visitor Added";
	}
	else
	{
		$fmsg="Error";	
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
                        <div class="panel panel-info">
                            <div class="panel-heading">Visitors Details</div>
                            <div class="panel-wrapper collapse in" aria-expanded="true">
                                <div class="panel-body">
                                    <form method="post" data-toggle="validator">
                                        <div class="form-body">
                                            
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Name</label>
                                                        <input type="text" id="Name" name="vname" class="form-control" placeholder="Enter the visitors name" required value=""required>
                                                         </div>
                                                </div>
                                                <!--/span-->
                                                
                                                <!--/span-->
                                            </div>
                                            <!--/row-->
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Sex</label>
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
                                            </div>
                                            <!--/row-->
                                            <div class="row">
                                                <div class="col-md-12">
                                                   <div class="form-group">
                                    <label class="col-sm-12 p-l-0">Patient</label>
                                    <div class="col-sm-12 p-l-0">
                                        <select class="form-control" name="patient">
                                            <option disabled hidden selected>Select Patient</option>
											<?php while ($getpinfo=mysqli_fetch_assoc($getpinforesult)) {  ?>
                                            <option value="<?php echo $getpinfo['p_id']; ?>"><?php echo $getpinfo['fname'].' '.$getpinfo['lname'].' , '.$getpinfo['ward_no']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                                </div>
                                                <!--/span-->
                                            </div><br>
											 <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Date and time of visiting</label>
                                                        <div class="radio-list">
                                                            <label class="radio-inline p-0">
                                                                <div class="radio radio-info">
                                                                    <input checked onClick="document.getElementById('datepicker-autoclose1').disabled = true; document.getElementById('inputtime').disabled = true;" type="radio" name="datetime" id="radio3" value="now">
                                                                    <label for="radio3">Now</label>
                                                                </div>
                                                            </label>
                                                            <label class="radio-inline">
                                                                <div class="radio radio-info">
                                                                    <input onClick="document.getElementById('datepicker-autoclose1').disabled = false; document.getElementById('inputtime').disabled = false;" type="radio" name="datetime" id="radio4" value="custom">
                                                                    <label for="radio4">Custom</label>
                                                                </div>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
											<div class="row">
                                               <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Date of Visiting</label>
                                                        <div class="input-group">
															<div class="input-group-addon"><i class="icon-calender"></i></div>
															<input disabled data-date-format="dd-mm-yyyy" data-mask="99-99-9999" type="text" class="form-control" id="datepicker-autoclose1" name="dov" placeholder="dd-mm-yyyy" required>
														</div>
                                                   		<!--<span class="font-13 text-muted">dd-mm-yyyy</span>-->
                                                    </div>
                                                </div>
												<div class="col-md-6">
													<div class="form-group">
                                        <label class="control-label" for="inputdose">Time</label>
                                        <input disabled type="time" class="form-control" id="inputtime" name="time" placeholder="" required>
                                             </div>
												</div>
											</div>
                                            <!--/row-->
                                        </div>
                                        <div class="form-actions">
                                            <button type="submit" name="addvisitor" class="btn btn-success"> <i class="fa fa-check"></i>Submit</button>
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
