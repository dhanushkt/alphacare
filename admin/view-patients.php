<?php
include '../login/accesscontroladmin.php';
require('connect.php');
$ausername=$_SESSION['ausername'];

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
                        <h4 class="page-title">Patients</h4>
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
               <!--row -->
				<section>
                    <div class="sttabs tabs-style-bar">
						<nav>
							<ul>
								<li><a href="#section-bar-1" class="sticon ti-check"><span>Admitted</span></a></li>
								<li><a href="#section-bar-2" class="sticon  ti-close"><span>Discharged</span></a></li>
							</ul>
						</nav>
						<div class="content-wrap">
							<section id="section-bar-1">
							<div class="row">
                <?php
					$query = "SELECT p_id, fname, lname, dob, email, gender, phone, doj, wards.ward_no, wards.type, wards.bed_no FROM patients INNER JOIN wards ON patients.ward_id = wards.ward_id WHERE dod is NULL ";
					$result = mysqli_query($connection, $query);
					foreach($result as $key=>$result)
				{ ?>
                <div class="col-md-4 col-sm-4">
                        <div class="white-box">
                            <div class="row">
                                <div class="col-md-4 col-sm-4 text-center">
                                    <a href="contact-detail.html"><?php if($result["gender"]=='male'){ ?> <img src="../plugins/images/users/male-patient.png" class="img-circle img-responsive"><?php } else { ?><img src="../plugins/images/users/female-patient.png" class="img-circle img-responsive"> <?php } ?>  </a>
                                </div>
                                <div class="col-md-8 col-sm-8">
                                    <h3 class="box-title m-b-0"><?php echo $result["fname"]." ".$result["lname"]; ?></h3> <small>Age: <?php echo date_diff(date_create($result["dob"]), date_create('today'))->y; ?></small>
                                    <p class="p-0">
										<?php if(!$result["email"]=='') { ?><a href="mailto:<?php echo $result["email"]; ?>"><font size="-1"><?php echo $result["email"]; ?> </font></a><?php } else { ?><i class="fa fa-times"></i>no email address<?php } ?> <br>
										<i class="fa fa-phone"></i><?php echo " ".$result["phone"]; ?> <br>
										<i class="fa fa-hospital-o"></i><?php $date=$result['doj'];
											$myDateTime = DateTime::createFromFormat('Y-m-d', $date);
											$dojc = $myDateTime->format('d-m-Y');  echo " ".$dojc; ?>
										<i class="fa fa-bed m-l-5"></i><?php if(($result['type']=='General') || ($result['type']=='Semi')) { echo ' '.$result['ward_no'].' ( '.$result['bed_no'].' ) '; } else { echo ' '.$result['ward_no']; } ?>
                                    </p>
									<div class="m-t-5">
											<a href="edit-patient-profile.php?id=<?php echo $result["p_id"]; ?>" class="fcbtn btn btn-info">More Info</a>
											<!--<a href="#" class="fcbtn btn btn-danger model_img deleteDoctor" data-id="<?php // echo $result["doc_id"]; ?>" id="deleteDoc">Delete</a>-->
									</div>
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
				<div class="row">
                <?php
					$query = "SELECT p_id, fname, lname, dob, email, gender, phone, doj, wards.ward_no, wards.type, wards.bed_no FROM patients INNER JOIN wards ON patients.ward_id = wards.ward_id WHERE dod IS NOT NULL ";
					$result = mysqli_query($connection, $query);
					foreach($result as $key=>$result)
				{ ?>
                <div class="col-md-4 col-sm-4">
                        <div class="white-box">
                            <div class="row">
                                <div class="col-md-4 col-sm-4 text-center">
                                    <a href="contact-detail.html"><?php if($result["gender"]=='male'){ ?> <img src="../plugins/images/users/male-patient.png" class="img-circle img-responsive"><?php } else { ?><img src="../plugins/images/users/female-patient.png" class="img-circle img-responsive"> <?php } ?>  </a>
                                </div>
                                <div class="col-md-8 col-sm-8">
                                    <h3 class="box-title m-b-0"><?php echo $result["fname"]." ".$result["lname"]; ?></h3> <small>Age: <?php echo date_diff(date_create($result["dob"]), date_create('today'))->y; ?></small>
                                    <p class="p-0">
										<?php if(!$result["email"]=='') { ?><a href="mailto:<?php echo $result["email"]; ?>"><font size="-1"><?php echo $result["email"]; ?> </font></a><?php } else { ?><i class="fa fa-times"></i>no email address<?php } ?> <br>
										<i class="fa fa-phone"></i><?php echo " ".$result["phone"]; ?> <br>
										<i class="fa fa-hospital-o"></i><?php $date=$result['doj'];
											$myDateTime = DateTime::createFromFormat('Y-m-d', $date);
											$dojc = $myDateTime->format('d-m-Y');  echo " ".$dojc; ?>
										<i class="fa fa-bed m-l-5"></i><?php if(($result['type']=='General') || ($result['type']=='Semi')) { echo ' '.$result['ward_no'].' ( '.$result['bed_no'].' ) '; } else { echo ' '.$result['ward_no']; } ?>
                                    </p>
									<div class="m-t-5">
											<a href="edit-patient-profile.php?id=<?php echo $result["p_id"]; ?>" class="fcbtn btn btn-info">More Info</a>
											<!--<a href="#" class="fcbtn btn btn-danger model_img deleteDoctor" data-id="<?php // echo $result["doc_id"]; ?>" id="deleteDoc">Delete</a>-->
									</div>
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
					</div>
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
