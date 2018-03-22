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

if(isset($_POST['CancelApt']))
{
	$gettokenno=$_POST['CancelAptVal'];
	$updateoncalcel="UPDATE appointments SET status='Canceled' WHERE ap_token='$gettokenno' ";
	$updateoncalcelresult=mysqli_query($connection,$updateoncalcel);
	if($updateoncalcelresult)
	{
		echo '<script>location.href = location</script>';
	}
}
if(isset($_POST['AttendedBtn']))
{
	$gettokenno=$_POST['CancelAptVal'];
	$updateoncalcel="UPDATE appointments SET status='Attended' WHERE ap_token='$gettokenno' ";
	$updateoncalcelresult=mysqli_query($connection,$updateoncalcel);
	if($updateoncalcelresult)
	{
		echo '<script>location.href = location</script>';
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
	<link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">
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
                        <h4 class="page-title">Wards</h4>
                    </div>
                    <!-- /.page title -->
                    <!-- .breadcrumb -->
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                       <a href="../index.php" target="_blank" class="btn btn-info pull-right m-l-20 btn-rounded btn-outline hidden-xs hidden-sm waves-effect waves-light">Home</a>
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
                                            <h4 class="modal-title">EDIT Instructions</h4>
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
				
                		<section>
                                <div class="sttabs tabs-style-bar">
                                    <nav>
                                        <ul>
                                            <li><a href="#section-bar-1" class="sticon ti-check"><span>Available</span></a></li>
                                            <li><a href="#section-bar-2" class="sticon  ti-close"><span>Occupied</span></a></li>
											<li><a href="#section-bar-3" class="sticon ti-view-list "><span>2nd floor <small>[ALL]</small></span></a></li>
                                            <li><a href="#section-bar-4" class="sticon ti-view-list"><span>3rd floor <small>[ALL]</small></span></a></li>
                                            
                                        </ul>
                                    </nav>
                                    <div class="content-wrap">
										
                                        <section id="section-bar-1">
											<h2 class="visible-xs">Available</h2> 
											<div class="row p-0">
								<?php
									$getwardquery = "SELECT * FROM wards WHERE status='0'";
									$getwardresult = mysqli_query($connection, $getwardquery);
									foreach($getwardresult as $key=>$getwardresult)
								{ ?>
                <div class="col-md-3 col-sm-3 ">
                        <div class="white-box bg-success text-white">
                            <div class="row">
                                <div class="col-md-4 col-sm-4 text-center ">
                                    <a href="#"><img src="../plugins/images/users/bed-icon.png" class="img-circle img-responsive"></a>
                                </div> 
                                <div class="col-md-8 col-sm-8">
									<h4 class="box-title m-b-0 text-white"><?php echo $getwardresult["ward_no"]; ?> </h4>
                                    <!--<h3 class="box-title m-b-0"><?php// echo $getwardresult["name"]; ?></h3>--> <small>floor: <?php echo $getwardresult["floor"]; ?></small>
                                    <p class="p-0">
									<i class="fa fa-bed"></i><?php echo ' '.$getwardresult["bed_no"].' '; ?> 
									<i class="fa fa-tasks m-l-5"></i><?php echo ' '.$getwardresult["type"]; ?> <br>
										<i class="fa fa-rupee-sign"></i><?php echo ' '.$getwardresult["rent"]; ?> <br>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                  <?php
					}
				  ?>

				</div>
											
                                        </section>
										
                                        <section id="section-bar-2">
                                            <h2 class="visible-xs">Occupied</h2> 
										
										<div class="row p-0">
								<?php
									$getwardquery = "SELECT * FROM wards WHERE status='1'";
									$getwardresult = mysqli_query($connection, $getwardquery);
									foreach($getwardresult as $key=>$getwardresult)
								{ ?>
											<?php $wardid=$getwardresult['ward_id'];
										$getpid=mysqli_query($connection,"SELECT p_id from patients WHERE (ward_id='$wardid') AND (dod is NULL)"); $fetchpid=mysqli_fetch_assoc($getpid); ?>
                <div class="col-md-3 col-sm-3 " >
                        <div class="white-box bg-danger text-white">
                            <div class="row">
                                <div class="col-md-4 col-sm-4 text-center ">
                                    <a data-toggle="tooltip" data-original-title="View Patient Info" href="edit-patient-profile.php?id=<?php echo $fetchpid['p_id']; ?>"><img src="../plugins/images/users/bed-icon.png" class="img-circle img-responsive"></a>
                                </div> 
                                <div class="col-md-8 col-sm-8">
									<h4 class="box-title m-b-0 text-white"><?php echo $getwardresult["ward_no"]; ?> </h4>
                                    <!--<h3 class="box-title m-b-0"><?php// echo $getwardresult["name"]; ?></h3>--> <small>floor: <?php echo $getwardresult["floor"]; ?></small>
                                    <p class="p-0">
									<i class="fa fa-bed"></i><?php echo ' '.$getwardresult["bed_no"].' '; ?> 
									<i class="fa fa-tasks m-l-5"></i><?php echo ' '.$getwardresult["type"]; ?> <br>
										<i class="fa fa-rupee-sign"></i><?php echo ' '.$getwardresult["rent"]; ?> <br>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div> 
                  <?php
					}
				  ?>

				</div>
											
										</section>
										
										
										
                                        <section id="section-bar-3">
                                            
									<h2 class="visible-xs">2nd floor <small>[ALL]</small></h2> 
										
										<div class="row p-0">
								<?php
									$getwardquery = "SELECT * FROM wards WHERE floor='2'";
									$getwardresult = mysqli_query($connection, $getwardquery);
									foreach($getwardresult as $key=>$getwardresult)
								{ ?>
											<?php $wardid2=$getwardresult['ward_id'];
										$getpid2=mysqli_query($connection,"SELECT p_id from patients WHERE (ward_id='$wardid2') AND (dod is NULL)"); $fetchpid2=mysqli_fetch_assoc($getpid2); ?>
                <div class="col-md-3 col-sm-3 ">
                        <div class="white-box <?php if($getwardresult['status']=='0'){ echo 'bg-success'; } else { echo 'bg-danger'; } ?> text-white">
                            <div class="row">
                                <div class="col-md-4 col-sm-4 text-center ">
                                    <a <?php if($getwardresult['status']=='1'){ echo' data-toggle="tooltip" data-original-title="View Patient Info" '; } ?> href="<?php if($getwardresult['status']=='1'){ echo "edit-patient-profile.php?id=".$fetchpid2['p_id']; } else { echo "#"; } ?>"><img src="../plugins/images/users/bed-icon.png" class="img-circle img-responsive"></a>
                                </div> 
                                <div class="col-md-8 col-sm-8">
									<h4 class="box-title m-b-0 text-white"><?php echo $getwardresult["ward_no"]; ?> </h4>
                                    <!--<h3 class="box-title m-b-0"><?php// echo $getwardresult["name"]; ?></h3>--> <small>floor: <?php echo $getwardresult["floor"]; ?></small>
                                    <p class="p-0">
									<i class="fa fa-bed"></i><?php echo ' '.$getwardresult["bed_no"].' '; ?> 
									<i class="fa fa-tasks m-l-5"></i><?php echo ' '.$getwardresult["type"]; ?> <br>
										<i class="fa fa-rupee-sign"></i><?php echo ' '.$getwardresult["rent"]; ?> <br>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                  <?php
					}
				  ?>

				</div>
									
									</section>
										
                                        <section id="section-bar-4">
                                            <h2 class="visible-xs">3rd floor <small>[ALL]</small></h2> 
										
										<div class="row p-0">
								<?php
									$getwardquery = "SELECT * FROM wards WHERE floor='3'";
									$getwardresult = mysqli_query($connection, $getwardquery);
									foreach($getwardresult as $key=>$getwardresult)
								{ ?>
											<?php $wardid3=$getwardresult['ward_id'];
										$getpid3=mysqli_query($connection,"SELECT p_id from patients WHERE (ward_id='$wardid3') AND (dod is NULL)"); $fetchpid3=mysqli_fetch_assoc($getpid3); ?>
                <div class="col-md-3 col-sm-3 ">
                        <div class="white-box <?php if($getwardresult['status']=='0'){ echo 'bg-success'; } else { echo 'bg-danger'; } ?> text-white">
                            <div class="row">
                                <div class="col-md-4 col-sm-4 text-center ">
                                    <a <?php if($getwardresult['status']=='1'){ echo' data-toggle="tooltip" data-original-title="View Patient Info" '; } ?> href="<?php if($getwardresult['status']=='1'){ echo "edit-patient-profile.php?id=".$fetchpid3['p_id']; } else { echo "#"; } ?>"><img src="../plugins/images/users/bed-icon.png" class="img-circle img-responsive"></a>
                                </div> 
                                <div class="col-md-8 col-sm-8">
									<h4 class="box-title m-b-0 text-white"><?php echo $getwardresult["ward_no"]; ?> </h4>
                                    <!--<h3 class="box-title m-b-0"><?php// echo $getwardresult["name"]; ?></h3>--> <small>floor: <?php echo $getwardresult["floor"]; ?></small>
                                    <p class="p-0">
									<i class="fa fa-bed"></i><?php echo ' '.$getwardresult["bed_no"].' '; ?> 
									<i class="fa fa-tasks m-l-5"></i><?php echo ' '.$getwardresult["type"]; ?> <br>
										<i class="fa fa-rupee-sign"></i><?php echo ' '.$getwardresult["rent"]; ?> <br>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                  <?php
					}
				  ?>

				</div>
	
										</section>
                                        
                                    </div>
                                    <!-- /content -->
                                </div>
                                <!-- /tabs -->
                            </section>
				
				
				


                <!--/row -->

                <!--DNS End-->
             
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
	<script src="../plugins/js/cbpFWTabs.js"></script>
    <script type="text/javascript">
    (function() {

        [].slice.call(document.querySelectorAll('.sttabs')).forEach(function(el) {
            new CBPFWTabs(el);
        });

    })();
    </script>
	
    
    <!--    function(){
            swal("Deleted!", "User has been deleted.", "success");
            window.location.replace("view-doctors.php");     -->
</body>

</html>
<script>
$(document).ready(function() {
  $('.deleteDoctor').click(function(){
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
			  url: 'delete.php?id='+id,
			  type: 'DELETE',
			  data: {id:id},
			  success: function(){
				swal("Deleted!", "User has been deleted.", "success");
				window.location.replace("view-doctors.php");
          }
        });   
            } else {     
                swal("Cancelled", "User data is safe :)", "error");   
            }
      });
  });

});
	
</script>
