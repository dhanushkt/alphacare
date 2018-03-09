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
                        <h4 class="page-title">Appointments</h4>
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
                                            <li><a href="#section-bar-1" class="sticon ti-reload"><span>In Process</span></a></li>
                                            <li><a href="#section-bar-2" class="sticon ti-time"><span>Scheduled</span></a></li>
                                            <li><a href="#section-bar-3" class="sticon ti-check-box"><span>Attended</span></a></li>
                                            <li><a href="#section-bar-4" class="sticon ti-na"><span>Cancelled</span></a></li>
                                            
                                        </ul>
                                    </nav>
                                    <div class="content-wrap">
										
                                        <section id="section-bar-1">
											<h2 class="visible-xs">In Process</h2> 
											<div class="row p-0">
								<?php
									$getapointquery = "SELECT *,doctors.fname,doctors.lname,doctors.specialist FROM appointments INNER JOIN doctors ON appointments.doc_id = doctors.doc_id WHERE (status='In Process') AND (doctors.username='$ausername') ORDER BY doa ASC ";
									$getapointresult = mysqli_query($connection, $getapointquery);
									foreach($getapointresult as $key=>$getapointresult)
								{ ?>
                <div class="col-md-4 col-sm-4">
                        <div class="white-box">
                            <div class="row">
                                <div class="col-md-4 col-sm-4 text-center ">
                                    <a href="contact-detail.html"><img src="../plugins/images/users/token.png" class="img-circle img-responsive"></a>
                                </div> 
                                <div class="col-md-8 col-sm-8">
									<h5 class="box-title m-b-0"># <?php echo $getapointresult["ap_token"]; ?> </h5>
                                    <h3 class="box-title m-b-0"><?php echo $getapointresult["name"]; ?></h3> <!--<small><?php // echo $getapointresult["gender"]; ?></small>-->
                                    <p class="p-0">
										<!--<a href="mailto:<?php // echo $getapointresult["email"]; ?>"> <?php // echo $getapointresult["email"]; ?> </a> <br> --->
										<i class="fa fa-calendar"></i><?php $datea=$getapointresult['doa'];
										$myDateTime = DateTime::createFromFormat('Y-m-d', $datea);
										$doac = $myDateTime->format('d-m-Y');  echo ' '.$doac; ?> <br>
										<i class="fa fa-user-md"></i><?php echo ' Dr. '.$getapointresult["fname"].' '.$getapointresult["lname"]; ?> <br>
										<i class="fa fa-phone"></i><?php echo ' '.$getapointresult["phno"]; ?> <br>
										
										<a href="process-appointment.php?id=<?php echo $getapointresult["ap_token"]; ?>" class="fcbtn btn btn-info bootpopup" >Schedule/Cancel</a>
										<!--<a href="#" class="fcbtn btn btn-danger model_img deleteDoctor" data-id="<?php // echo $result["doc_id"]; ?>" id="deleteDoc">Delete</a>-->
									    
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
                                            <h2 class="visible-xs">Scheduled</h2> 
										
										<div class="row p-0">
								<?php
									$getapointquery2 = "SELECT *,doctors.fname,doctors.lname,doctors.specialist FROM appointments INNER JOIN doctors ON appointments.doc_id = doctors.doc_id WHERE (status='Scheduled') AND (doctors.username='$ausername') ORDER BY doa ASC ";
									$getapointresult = mysqli_query($connection, $getapointquery2);
									foreach($getapointresult as $key=>$getapointresult)
								{ ?>
                <div class="col-md-4 col-sm-4">
                        <div class="white-box">
                            <div class="row">
                                <div class="col-md-4 col-sm-4 text-center">
                                    <a href="contact-detail.html"><img src="../plugins/images/users/token.png" class="img-circle img-responsive"></a>
                                </div> 
                                <div class="col-md-8 col-sm-8">
									<h5 class="box-title m-b-0"># <?php echo $getapointresult["ap_token"]; ?> </h5>
                                    <h3 class="box-title m-b-0"><?php echo $getapointresult["name"]; ?></h3> <!--<small><?php // echo $getapointresult["gender"]; ?></small>-->
                                    <p class="p-0">
										<!--<a href="mailto:<?php // echo $getapointresult["email"]; ?>"> <?php // echo $getapointresult["email"]; ?> </a> <br> --->
										<i class="fa fa-calendar"></i><?php $datea=$getapointresult['doa'];
										$myDateTime = DateTime::createFromFormat('Y-m-d', $datea);
										$doac = $myDateTime->format('d-m-Y');  echo ' '.$doac.' '; ?> <i class="fa fa-clock-o"></i><?php $gettime=$getapointresult['time']; echo ' '.date('h:i a', strtotime($gettime));  ?> <br>
										<i class="fa fa-user-md"></i><?php echo ' Dr. '.$getapointresult["fname"].' '.$getapointresult["lname"]; ?> <br>
										<i class="fa fa-phone"></i><?php echo ' '.$getapointresult["phno"]; ?> <br>
		
                                    </p>
									<!--change the confirmation message-->
									<form method="post" onsubmit="return confirm('Do you really want to submit?');" class="m-b-0">
										<input type="hidden" name="CancelAptVal" value="<?php echo $getapointresult['ap_token']; ?>">
										<button type="submit" name="AttendedBtn" class="fcbtn btn btn-info" >Attended</button>
										<button type="submit" name="CancelApt" class="fcbtn btn btn-danger"><i class="fa fa-times"></i> </button> 
									</form>
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
                                            
									<h2 class="visible-xs">Attended</h2> 
										
										<div class="row p-0">
								<?php
									$getapointquery2 = "SELECT *,doctors.fname,doctors.lname,doctors.specialist FROM appointments INNER JOIN doctors ON appointments.doc_id = doctors.doc_id WHERE (status='Attended') AND (doctors.username='$ausername') ORDER BY doa ASC ";
									$getapointresult = mysqli_query($connection, $getapointquery2);
									foreach($getapointresult as $key=>$getapointresult)
								{ ?>
                <div class="col-md-4 col-sm-4">
                        <div class="white-box">
                            <div class="row">
                                <div class="col-md-4 col-sm-4 text-center">
                                    <a href="contact-detail.html"><img src="../plugins/images/users/token.png" class="img-circle img-responsive"></a>
                                </div> 
                                <div class="col-md-8 col-sm-8">
									<h5 class="box-title m-b-0"># <?php echo $getapointresult["ap_token"]; ?> </h5>
                                    <h3 class="box-title m-b-0"><?php echo $getapointresult["name"]; ?></h3> <!--<small><?php // echo $getapointresult["gender"]; ?></small>-->
                                    <p class="p-0">
										<!--<a href="mailto:<?php // echo $getapointresult["email"]; ?>"> <?php // echo $getapointresult["email"]; ?> </a> <br> --->
										<i class="fa fa-calendar"></i><?php $datea=$getapointresult['doa'];
										$myDateTime = DateTime::createFromFormat('Y-m-d', $datea);
										$doac = $myDateTime->format('d-m-Y');  echo ' '.$doac.' '; ?> <i class="fa fa-clock-o"></i><?php $gettime=$getapointresult['time']; echo ' '.date('h:i a', strtotime($gettime));  ?> <br>
										<i class="fa fa-user-md"></i><?php echo ' Dr. '.$getapointresult["fname"].' '.$getapointresult["lname"]; ?> <br>
										<i class="fa fa-phone"></i><?php echo ' '.$getapointresult["phno"]; ?> <br>
										
								
									    
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
                                            <h2 class="visible-xs">Cancelled</h2> 
										
										<div class="row p-0">
								<?php
									$getapointquery2 = "SELECT * FROM wards WHERE floor='3'";
									$getapointresult = mysqli_query($connection, $getapointquery2);
									foreach($getapointresult as $key=>$getapointresult)
								{ ?>
                		<div class="col-md-4 col-sm-4">
                       	 <div class="white-box">
                            <div class="row">
                                <!-- <div class="col-md-4 col-sm-4 text-center">
                                    <a href="contact-detail.html"><img src="../plugins/images/users/token.png" class="img-circle img-responsive"></a>
                                </div> -->  
                                <div class="col-md-8 col-sm-8">
									<h5 class="box-title m-b-0"># <?php echo $getapointresult["ap_token"]; ?> </h5>
                                    <h3 class="box-title m-b-0"><?php echo $getapointresult["name"]; ?></h3> <!--<small><?php // echo $getapointresult["gender"]; ?></small>-->
                                    <p class="p-0">
										<!--<a href="mailto:<?php // echo $getapointresult["email"]; ?>"> <?php // echo $getapointresult["email"]; ?> </a> <br> --->
										<i class="fa fa-calendar"></i><?php $datea=$getapointresult['doa'];
										$myDateTime = DateTime::createFromFormat('Y-m-d', $datea);
										$doac = $myDateTime->format('d-m-Y');  echo ' '.$doac.' '; ?> <i class="fa fa-clock-o"></i><?php $gettime=$getapointresult['time']; echo ' '.date('h:i a', strtotime($gettime)); ?> <br>
										<i class="fa fa-user-md"></i><?php echo ' Dr. '.$getapointresult["fname"].' '.$getapointresult["lname"]; ?> <br>
										<i class="fa fa-phone"></i><?php echo ' '.$getapointresult["phno"]; ?> <br>
									 	<b><?php $status_value = $getapointresult['status']; 
										 $statusvalue = str_replace('Cancelled,', '', $status_value); echo $statusvalue;  ?>  </b>
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
