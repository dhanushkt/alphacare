<?php
include '../login/accesscontroladmin.php';
$ausername=$_SESSION['ausername'];
require('connect.php');
if (isset($_POST['wardsubmit']))
	{
		// real eacape sting is used to prevent sql injection hacking
		$bednum="1";
		$wardnum=mysqli_real_escape_string($connection,$_POST['wardno']);
		$wfloor=mysqli_real_escape_string($connection,$_POST['wfloor']);
		$wtype= mysqli_real_escape_string($connection,$_POST['wtype']);
		if(isset($_POST['bedno']))
		{
			$bednum=mysqli_real_escape_string($connection,$_POST['bedno']);
		}
		$wrent=mysqli_real_escape_string($connection,$_POST['wrent']);
		
		$wardinsertquery="INSERT INTO `wards`(ward_no,bed_no,floor,type,rent) VALUES ('$wardnum','$bednum','$wfloor','$wtype','$wrent')";
		$wardinsertresult=mysqli_query($connection,$wardinsertquery);
		if($wardinsertresult)
		{
			$smsg="Ward successfully added";
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
		$('#wardnoLoading').hide();
		$('#wardno').keyup(function(){
		  $('#wardnoLoading').show();
	      $.post("check-wardnumber.php", {
	        wardno: $('#wardno').val()
	      }, function(response){
	        $('#wardnoResult').fadeOut();
	        setTimeout("finishAjax('wardnoResult', '"+escape(response)+"')", 500);
});
	    	return false;
		});
	});

	function finishAjax(id, response) {
	  $('#wardnoLoading').hide();
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
                        <h4 class="page-title">Add Ward</h4>
                    </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <a href="../index.php" target="_blank" class="btn btn-info pull-right m-l-20 btn-rounded btn-outline hidden-xs hidden-sm waves-effect waves-light">Home</a>
                        <?php echo breadcrumbs(); ?>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>

				<!--- imported add-doctors---->

				<div class="row">
				<div class="col-sm-12">
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
							<?php } ?>

                        <div class="white-box">
                            <h3 class="box-title m-b-0">Ward Information</h3>
                            <form data-toggle="validator" method="post">
                              
                         		<div class="row">
                                	<div class="col-md-6">
                                       <div class="form-group">
                                        	 <label class="control-label">Ward Number</label>
											<div class="col-sm-12 p-l-0">
												<div class="input-group">
													<input autocomplete="off" type="text" name="wardno" class="form-control" id="wardno" placeholder="Enter ward number" required>
												</div>
												<!-- wardnum check start -->
												<div>
												<span id="wardnoLoading"><img src="../plugins/images/busy.gif" alt="Ajax Indicator" height="15" width="15" /></span>
												<span id="wardnoResult" style="color: #E40003"></span>
												</div>
											 	<!-- wardnum check end -->
											</div>
                                         </div>
                                    </div>
                                    <!--/span-->
									 <div class="col-md-6">
										<div class="form-group">
											<label class="col-sm-12 p-l-0">Floor</label>
											<div class="col-sm-12 p-l-0">
												<select required class="form-control" name="wfloor">
													<option hidden disabled selected>Select Floor</option>
													<option value="2">2nd floor</option>
													<option value="3">3rd floor</option>
												</select>
											</div>
                                		</div>  
									 </div>
                                    <!--/span-->
                                 </div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-sm-12 p-l-0">Type of Ward</label>
											<div class="col-sm-12 p-l-0">
												<select required class="form-control" name="wtype">
													<option onClick="document.getElementById('bednumber').disabled = true;" hidden disabled selected>Select Type</option>
													<option onClick="document.getElementById('bednumber').disabled = true;" value="Non-TV">Non-TV</option>
													<option onClick="document.getElementById('bednumber').disabled = true;" value="TV">TV</option>
													<option onClick="document.getElementById('bednumber').disabled = true;" value="AC">AC</option>
													<option onClick="document.getElementById('bednumber').disabled = false;" value="Semi">Semi</option>
													<option onSelect="document.getElementById('bednumber').disabled = false;" value="General">General</option>
												</select>
											</div>
                                		</div>
										
									</div>
									<div class="col-md-6">
										<div class="form-group">
											   <label class="control-label">Bed Number</label>
											   <input disabled="true" type="text" name="bedno" id="bednumber" class="form-control" placeholder="Enter bed number">
										</div>
										
									</div>
								</div>

                                
                                <div class="form-group">
									<label for="inputEmail" class="control-label">Rent per Day (in ₹)</label>
									<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-inr"></i></span>
                                    <input type="number" name="wrent" class="form-control" id="wrent" placeholder="Rent" required>
									</div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="wardsubmit" class="btn btn-info">Submit</button>
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
