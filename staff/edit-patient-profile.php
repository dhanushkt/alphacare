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

if(!isset($_GET['id']))
{
	echo '<script> window.location="view-patients.php"; </script>';
}
$id = $_GET['id'];
date_default_timezone_set('Asia/Kolkata');

$query="SELECT fname, lname, dob, email, gender, phone, address, city, state, pc, rel_name, rel_phno, doj, dod, wards.ward_no, wards.bed_no, wards.type, wards.rent, wards.ward_id FROM patients INNER JOIN wards ON patients.ward_id = wards.ward_id WHERE p_id='$id'";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);

$fetchmediinfo="SELECT * FROM medical_info WHERE p_id='$id' ORDER BY date DESC";
$fetchresult=mysqli_query($connection, $fetchmediinfo);
$fetchrow = mysqli_fetch_assoc($fetchresult);
$checkcount = mysqli_num_rows($fetchresult);
if($checkcount>=1)
{
	
	//calculate temprature percentage min:97F max:105F
	if($fetchrow['temp']<='97')
	{
		$tempper="10%";
	}
	elseif($fetchrow['temp']>'97' && $fetchrow['temp']<='105')
	{
		$tempper=(($fetchrow['temp']-97)/(105-97))*100;
	}
	elseif($fetchrow['temp']> '105')
	{
		$tempper="100%";
	}

	//calculate sugar percentage min:72 max:140
	$sugarper=(($fetchrow['sugar']-72)/(140-72))*100;

	//calculate bloodpreasure percentage min:70/40 max: 180/100
	$bp_value = $fetchrow['bp'];
	$bp = explode("/",$bp_value);

	$upper_bp = $bp[0];
	$lower_bp = $bp[1];

	$bpper_upper=(($upper_bp-70)/(180-70))*100;
	$bpper_lower=(($lower_bp-40)/(100-40))*100;
	$avgbpval=($bpper_upper+$bpper_lower)/2;
	
}


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
		$addr=mysqli_real_escape_string($connection,$_POST['addr']);
		$state=mysqli_real_escape_string($connection,$_POST['state']);
		$city=mysqli_real_escape_string($connection,$_POST['city']);
		$pc=mysqli_real_escape_string($connection,$_POST['pc']);
		$relname=mysqli_real_escape_string($connection,$_POST['relname']);
		$relphno=mysqli_real_escape_string($connection,$_POST['relphno']);
		$phone=mysqli_real_escape_string($connection,$_POST['phone']);

		$updatequery="UPDATE patients SET fname='$fname', lname='$lname', dob='$dob', gender='$gender', phone='$phone', email='$email', address='$addr', state='$state', city='$city', pc='$pc', rel_name='$relname', rel_phno='$relphno' WHERE p_id='$id'";
		$updatequeryresult=mysqli_query($connection, $updatequery);
		if($updatequeryresult)
		{
			$queryupdate="SELECT fname, lname, dob, email, gender, phone, address, city, state, pc, rel_name, rel_phno, doj, dod, wards.ward_no, wards.bed_no, wards.type, wards.rent, wards.ward_id FROM patients INNER JOIN wards ON patients.ward_id = wards.ward_id WHERE p_id='$id'";
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
		$fetchmediinfo="SELECT * FROM medical_info WHERE p_id='$id' ORDER BY date DESC";
		$fetchresult=mysqli_query($connection, $fetchmediinfo);
		$fetchrow = mysqli_fetch_assoc($fetchresult);
		$checkcount = mysqli_num_rows($fetchresult);
		if($checkcount>=1)
		{
			//calculate temprature percentage min:97F max:105F
			if($fetchrow['temp']<='97')
			{
				$tempper="10%";
			}
			elseif($fetchrow['temp']>'97' && $fetchrow['temp']<='105')
			{
				$tempper=(($fetchrow['temp']-97)/(105-97))*100;
			}
			elseif($fetchrow['temp']> '105')
			{
				$tempper="100%";
			}

			//calculate sugar percentage min:72 max:140
			$sugarper=(($fetchrow['sugar']-72)/(140-72))*100;

			//calculate bloodpreasure percentage min:70/40 max: 180/100
			$bp_value = $fetchrow['bp'];
			$bp = explode("/",$bp_value);

			$upper_bp = $bp[0];
			$lower_bp = $bp[1];

			$bpper_upper=(($upper_bp-70)/(180-70))*100;
			$bpper_lower=(($lower_bp-40)/(100-40))*100;
			$avgbpval=($bpper_upper+$bpper_lower)/2;

		}
	}
	else
	{
		$fmsg="Error adding medical info";
	}
}

//add medicines info
if(isset($_POST['addmedinfo']))
{
	//$getdocidquery="SELECT doc_id FROM doctors WHERE username='$ausername'";
	//$getdocidresult=mysqli_query($connection,$getdocidquery);
	//$getdocidfetch=mysqli_fetch_assoc($getdocidresult);
	$medipid=$id;
	$medidocid=mysqli_real_escape_string($connection,$_POST['presc']);
	$mediname=mysqli_real_escape_string($connection,$_POST['medname']);
	$medibrand=mysqli_real_escape_string($connection,$_POST['medbrand']);
	$medidesc=mysqli_real_escape_string($connection,$_POST['meddesc']);
	$medidose=mysqli_real_escape_string($connection,$_POST['meddose']);
	$medistatus=mysqli_real_escape_string($connection,$_POST['medstatus']);
	//planned add prescribed from date and to date 
	
	$mediinfoinsertquery="INSERT INTO `medicines`(p_id, doc_id, name, brand, description, dose, status) VALUES ('$medipid','$medidocid','$mediname','$medibrand','$medidesc','$medidose','$medistatus')";
	$mediinforesult=mysqli_query($connection,$mediinfoinsertquery);
	if($mediinforesult)
	{
		$smsg="Medicine Prescribed!";
	}
	else
	{
		$fmsg="error".mysqli_error($connection);
	}
	
	
}

if(isset($_POST['discharge']))
{
	$datedod=date("d-m-Y");
	//$datedodc=new DateTime($datedod);
	//$datedoj=new DateTime($row['doj']);
	//if($datedodc<=$datedoj)
	//{
		//$fmsg="Date of discharge is before date of admit!";
	//}
	//else
//{
	$myDateTime3 = DateTime::createFromFormat('d-m-Y', $datedod);
	$dod = $myDateTime3->format('Y-m-d');
	$dischargequery="UPDATE patients SET dod='$dod' WHERE p_id='$id'";
	$dischargeresult=mysqli_query($connection,$dischargequery);
	if($dischargeresult)
	{
		$dateofjoin=$row['doj'];
		$dayscount=strtotime($dod) - strtotime($dateofjoin);
		$days=round($dayscount / (60* 60 * 24));
		$wardrent= $row['rent'] * $days;
		$insertbill="INSERT INTO `ip_bills` (p_id, ward_rent) VALUES ('$id','$wardrent')";
		$insertbillresult=mysqli_query($connection,$insertbill);
		if($insertbillresult)
		{
			$wardid=$row['ward_id'];
			$updatewardstatus=mysqli_query($connection,"UPDATE wards SET status='0' WHERE ward_id='$wardid'");
			if($updatewardstatus)
			{
				//echo "<script> window.location.replace(window.location.pathname + window.location.search + window.location.hash); </script>";
				$smsg="Patient Discharge Successfull";
				$query="SELECT fname, lname, dob, email, gender, phone, address, city, state, pc, rel_name, rel_phno, doj, dod, wards.ward_no, wards.bed_no, wards.type, wards.rent, wards.ward_id FROM patients INNER JOIN wards ON patients.ward_id = wards.ward_id WHERE p_id='$id'";
				$result = mysqli_query($connection, $query);
				$row = mysqli_fetch_assoc($result);
			}
		}
	  }
//}
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
	<!-- Popup CSS -->
    <link href="../plugins/bower_components/Magnific-Popup-master/dist/magnific-popup.css" rel="stylesheet">

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

<!--JavaScript to add a class based on screen size-->
<script>
$(window).load(function() {
    
    var viewportWidth = $(window).width();
    if (viewportWidth < 750) {
            $(".addmidclass").removeClass("addmidclass").addClass("m-t-10");
    }
    
    $(window).resize(function () {
    
        if (viewportWidth < 750) {
            $(".addmidclass").removeClass("addmidclass").addClass("m-t-10");
        }
    });
});
</script>
<script>
$(window).load(function() {
    
    var viewportWidth = $(window).width();
    if (viewportWidth < 750) {
            $(".mobileview").removeClass("mobileview").addClass("p-2");
    }
    
    $(window).resize(function () {
    
        if (viewportWidth < 750) {
            $(".mobileview").removeClass("mobileview").addClass("p-2");
        }
    });
});
</script>

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
                                        <a href="javascript:void(0)"><?php if($row["gender"]=='male') { ?> <img src="../plugins/images/users/male-patient.png" class="thumb-lg img-circle" ><?php } else { ?> <img src="../plugins/images/users/female-patient.png" class="thumb-lg img-circle" > <?php } ?> </a>
                                        <!--<h4 class="text-white"><?php //echo $row["username"]; ?></h4>
                                        <h5 class="text-white"><?php //echo $row["email"]; ?></h5>-->
                                    </div>
                                </div>
                            </div>
							<div class="user-btm-box">
                                <!-- .row -->
                                <div class="row text-center m-t-10">
                                    <div class="col-md-6 b-r"><strong>Full Name</strong>
                                        <p><?php echo $row["fname"]." ".$row["lname"]; ?></p>
                                    </div>
                                    <div class="col-md-6"><strong>Age</strong>
                                        <p><?php echo date_diff(date_create($row["dob"]), date_create('today'))->y; ?></p>
                                    </div>
                                </div>
                                <!-- /.row -->
                                <hr>
								<div class="row text-center m-t-10">
									<div class="col-md-12"><strong>Email ID</strong>
                                        <p><?php echo $row["email"]; ?> </p>
                                    </div>
								</div>
								<hr>
                                <!-- .row -->
                                <div class="row text-center m-t-10">
                                    <div class="col-md-12"><strong>Phone</strong>
                                        <p><?php echo $row["phone"]; ?></p>
                                    </div>
                                </div>
                                <!-- /.row -->
                                <hr>
								
                                <!-- .row -->
                                <div class="row text-center m-t-10 ">
                                    <div class="col-md-12"><strong>Address</strong>
                                        <p><?php echo $row["address"];  ?>
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
                        <div class="white-box mobileview">
                          <font size="2"><ul class="nav customtab nav-tabs" role="tablist">
                                <!--<li role="presentation" class="nav-item"><a href="#home" class="nav-link " aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="fa fa-home"></i></span><span class="hidden-xs"> Activity</span></a></li>-->
                                
								<li role="presentation" class="nav-item"><a href="#profile" class="nav-link active" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="fa fa-wheelchair"></i></span> <span class="hidden-xs">Info</span></a></li>
                                <li role="presentation" class="nav-item"><a href="#medrep" class="nav-link" aria-controls="medrep" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="fa fa-stethoscope"></i></span> <span class="hidden-xs">Medical Report</span></a></li>
                                <li role="presentation" class="nav-item"><a href="#updatemedicinfo" class="nav-link" aria-controls="updatemedicinfo" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="fa fa-refresh"></i></span> <span class="hidden-xs">Update Medical Info</span></a></li>
								<li role="presentation" class="nav-item"><a href="#editpatientinfo" class="nav-link" aria-controls="editpatientinfo" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="fa fa-pencil"></i></span> <span class="hidden-xs">Edit Patient Info</span></a></li>
								<li role="presentation" class="nav-item"><a href="#visitors" class="nav-link" aria-controls="visitors" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="fa fa-users"></i></span> <span class="hidden-xs">Visitors</span></a></li>
								<li role="presentation" class="nav-item"><a href="#removepatient" class="nav-link" aria-controls="removepatient" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="fa fa-user-times"></i></span> <span class="hidden-xs">Discharge</span></a></li>
							  </ul></font>
                            <div class="tab-content">
                                <div class="tab-pane active" id="profile">
                                    <div class="row">
                                        <div class="col-md-3 col-xs-6 b-r"> <strong>Ward</strong>
										<br>
										<p class="text-muted"><?php if(($row['type']=='General') || ($row['type']=='Semi')) { echo $row['ward_no'].' ( '.$row['bed_no'].' ) '.' , '.$row['type']; } else { echo $row['ward_no'].' , '.$row['type']; } ?></p>
									</div>
									<div class="col-md-3 col-xs-6 b-r"> <strong>Disease</strong>
										<br>
										<p class="text-muted"><?php echo $fetchrow["disease"];?></p>
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
										<hr>
									<div class="row">
										<div class="col-md-3 col-xs-6 b-r"> <strong>Date of Admit</strong>
										<br>
										<p class="text-muted"><?php $datej=$row['doj'];
											$myDateTime = DateTime::createFromFormat('Y-m-d', $datej);
											$dojc = $myDateTime->format('d-m-Y');  echo $dojc;?></p>
									</div>
										<div class="col-md-3 col-xs-6 b-r"> <strong>Relative Name</strong>
										<br>
										<p class="text-muted"><?php echo $row["rel_name"];?></p>
									</div>
										<div class="col-md-6 col-xs-6"> <strong>Relative Number</strong>
										<br>
										<p class="text-muted"><?php echo $row["rel_phno"];?></p>
									</div>
									</div>
										<hr>
									<!--imported medicines module from doc cpanel start-->
									<div class="panel panel-info">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body p-t-0 text-center ">
                                    <a class="btn btn-custom collapseble ">View Medicines Information</a>
									<?php if(!isset($row['dod'])) { ?>
									<a class="popup-with-form btn btn-success text-white addmidclass"  href="#test-form" >Prescribe new medicine</a>
									<?php } ?>
                                    <div class="m-t-15 collapseblebox dn">
                                       <div class="well">
										<?php if(!isset($row['dod'])){ ?>To update medicine info click on that particular row <?php } ?>
										<div class="row">
							<div class="table-responsive">
								<div class="panel1 panel panel-info">
									<div class="panel-heading p-t-10">Medicines
                           			 </div>
									<div class="panel-body">
										<table class="table table-striped color-bordered-table info-bordered-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th nowrap>Name</th>
                                            <th nowrap>Brand</th>
                                            <th nowrap>Description</th>
											<th class="text-nowrap">Dose<br>(M-A-N)</th>
											<th nowrap>Status</th>
											<th nowrap>Prescribed by</th>
											<!--<th>Actions</th>-->
                                        </tr>
                                    </thead>
									<tbody>
                              <?php
								 $mediceneinfo="SELECT med_id,name,brand,description,dose,status,doctors.fname,doctors.lname FROM medicines INNER JOIN doctors ON medicines.doc_id = doctors.doc_id WHERE p_id='$id' ORDER BY med_id DESC";
								 $mediceneresult = mysqli_query($connection, $mediceneinfo);
								 //$getdocinfoarray=mysqli_fetch_array($mediceneresult);
								//$medinforow = mysqli_fetch_assoc($mediceneresult);
								foreach($mediceneresult as $key=>$mediceneresult)
								{
									
									$getmedid=$mediceneresult['med_id'];
                              ?>
										
										<tr <?php if(!isset($row['dod'])) {  ?> onclick="window.location='edit-medicine.php?id=<?php echo $getmedid; ?>'" <?php } ?> >
                                            <th scope="row"><?php echo $key+1; ?></th>
                                            <td id="name_row<?php echo $key; ?>"><?php echo $mediceneresult["name"]; ?></td>
                                            <td><?php echo $mediceneresult["brand"]; ?></td>
                                            <td><?php echo $mediceneresult["description"]; ?></td>
											<td nowrap><?php echo $mediceneresult["dose"]; ?></td>
											<td><?php if($mediceneresult["status"]=='ongoing') { ?><div class="label label-table label-success"><?php echo $mediceneresult["status"]; ?></div><?php } else { ?><div class="label label-table label-danger"><?php echo $mediceneresult["status"]; ?></div><?php } ?></td>
											<td><?php echo 'Dr. '.$mediceneresult['fname'].' '.$mediceneresult['lname']; ?></td>
											<!--<td><a data-original-title="Edit" id="edit_button<?php // echo $key ?>" onClick="edit_row('<?php // echo $key ?>')"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
											</td>-->
                                        </tr>
										

									<?php } ?>
											</tbody>
										</table>
									</div>

								 </div>
								</div>
										</div>	
										
										</div>
                                    </div>
									
                                </div>
                                
                            </div>
                        </div>
						
							<form id="test-form" method="post" class="mfp-hide white-popup-block">
                                <h3>Enter Medicine Details</h3>
                                <fieldset style="border:0;">
                                    <div class="form-group">
                                        <label class="control-label" for="inputName">Name</label>
                                        <input type="text" class="form-control" id="inputName" name="medname" placeholder="Name of the medicine" required="">
                                    </div>
									
                                    <div class="form-group">
                                        <label class="control-label" for="inputbname">Brand</label>
                                        <input type="text" class="form-control" id="inputbname" name="medbrand" placeholder="Medicine brand name">
                                    </div>
									<div class="form-group">
                                        <label class="control-label" for="textarea">Description</label>
                                        <br>
                                        <textarea class="form-control" id="textarea" name="meddesc" placeholder="Additional details on medicine prescribed"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="inputdose">Dose</label>
                                        <input type="text" class="form-control" id="inputdose" name="meddose" placeholder="Dose Format: Morning-Afternoon-Night" data-mask="9-9-9" required="">
                                    </div>
									<div class="form-group">
                                        <label class="control-label" for="prescribedby">Prescribed By</label>
										<?php
											$selectdocs="SELECT doc_id,username,fname,lname,specialist FROM doctors";
											$resultdocs = mysqli_query($connection, $selectdocs);	
										?>
                                        <select class="form-control" required name="presc">
											<option selected hidden disabled>Select Doctor</option>
											<?php while($rowdocs = mysqli_fetch_assoc($resultdocs)) { ?>
												<option value="<?php echo $rowdocs["doc_id"] ?>"> <?php echo $rowdocs["fname"].' '.$rowdocs["lname"].' , '.$rowdocs["specialist"]; ?></option>
												<?php } ?>
										</select>
                                    </div>
									<div class="form-group">
										<label class="control-label">Status</label>
										<div class="radio-list">
											<label class="radio-inline p-0">
												<div class="radio radio-info">
													<input type="radio" name="medstatus" id="radio1" value="ongoing">
													<label for="radio1">Ongoing</label>
												</div>
											</label>
											<label class="radio-inline">
												<div class="radio radio-info">
													<input type="radio" name="medstatus" id="radio2" value="stopped">
													<label for="radio2">Stopped</label>
												</div>
											</label>
										</div>
                                     </div>
                                    
									<div class="form-action">
										<button type="submit" name="addmedinfo" class="btn btn-success"> <i class="fa fa-check"></i> Add</button> 
									</div>
                                </fieldset>
                            </form>
									<!--imported medicines module from doc cpanel end-->
										<h4 class="m-t-30">General Report</h4>
										<hr>
										<h5>Blood Pressure<span class="pull-right"><?php echo $fetchrow["bp"]; ?></span></h5>
										<div class="progress">
											<div class="progress-bar progress-bar-custom wow animated progress-animated" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $avgbpval ?>%;"> <span class="sr-only">50% Complete</span> </div>
										</div>
										<h5>Sugar<span class="pull-right"><?php echo $fetchrow["sugar"]; ?></span></h5>
										<div class="progress">
											<div class="progress-bar progress-bar-primary wow animated progress-animated" role="progressbar" aria-valuenow="<?php echo $fetchrow["sugar"]; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $sugarper ?>%;"> <span class="sr-only">50% Complete</span> </div>
										</div>
										<h5>Temprature<span class="pull-right"><?php echo $fetchrow["temp"]." °F"; ?></span></h5>
										<div class="progress">
											<div class="progress-bar progress-bar-danger wow animated progress-animated" role="progressbar" aria-valuenow="102" aria-valuemin="97" aria-valuemax="105" style="width:<?php echo $tempper ?>%;"> <span class="sr-only">50% Complete</span> </div>
										</div>
										<hr>
										<div class="row">
										<div class="col-md-3 col-xs-6 b-r"> <strong>Height</strong>
										<br>
										<p class="text-muted"><?php if(isset($fetchrow["height"])) echo $fetchrow["height"].' cm';?></p>
									</div>
										<div class="col-md-3 col-xs-6 b-r"> <strong>Weight</strong>
										<br>
										<p class="text-muted"><?php if(isset($fetchrow["weight"])) echo $fetchrow["weight"].' kg';?></p>
									</div>
										<div class="col-md-6 col-xs-6"> <strong>Medical info taken on</strong>
										<br>
										<p class="text-muted"><?php if(isset($fetchrow["date"])) {	  $datei=$fetchrow['date'];
											$myDateTime = DateTime::createFromFormat('Y-m-d', $datei);
											$doic = $myDateTime->format('d-m-Y');  echo $doic; } ?></p>
									</div>
									</div>
										<hr>
									
										<h4 class="m-t-30">ECG Report</h4>
										<hr>
										<div class="stats-row">
											<div class="stat-item">
												<h6>Pulse</h6> <b>85</b></div>
											<div class="stat-item">
												<h6>BP</h6> <b><?php echo $fetchrow["bp"]; ?></b></div>
										</div>
												<!--remove this for mobile-->
										<div style="height: 280px;">
											<div id="placeholder" class="demo-placeholder"></div>
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
                                            <th nowrap>BP (mm Hg)</th>
                                            <th nowrap>Sugar (mg/dl)</th>
                                            <th nowrap>Temprature (°F)</th>
											<th nowrap>Date</th>
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
											<td nowrap><?php $date=$medinfores["date"];
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
									<fieldset <?php if(isset($row['dod'])){ echo 'disabled'; } ?> >
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
															<option disabled selected hidden>Select Blood group</option>
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
                                                        <input type="text" pattern="[0-9]*" name="sugar" class="form-control">
                                                        <span class="font-13 text-muted">in mg/dl</span>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Height</label>
                                                        <input type="text" pattern="[0-9]*" name="height" class="form-control" value="<?php echo $fetchrow['height']; ?>">
                                                         <span class="font-13 text-muted">in cm</span>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Weight</label>
                                                        <input type="text" pattern="[0-9]*" name="weight" class="form-control" value="<?php echo $fetchrow['weight']; ?>">
                                                        <span class="font-13 text-muted">in kg</span>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Temperature</label>
                                                        <input type="text" pattern="[0-9]*" name="temp" class="form-control">
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
									</fieldset>
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
									<fieldset <?php if(isset($row['dod'])){ echo 'disabled'; } ?> >
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
											<h3 class="box-title m-t-10">Relative Info</h3>
                                            <hr>
											<div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Relative Name</label>
                                                        <input value="<?php echo $row['rel_name']; ?>" type="text" id="Relname" name="relname" class="form-control" placeholder="Enter name" required>
                                                         </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Phone No</label>
                                                        <input value="<?php echo $row['rel_phno']; ?>" required type="tel" pattern="[0-9]*" maxlength="11" id="Relphno" name="relphno" class="form-control" placeholder="Enter phone number" data-error="Invalid pone number">
														<div class="help-block with-errors"></div>
                                                         </div><div class="help-block with-errors"></div><div class="help-block with-errors"></div>
                                                </div>
                                                <!--/span-->
                                            </div>
											
                                            <h3 class="box-title m-t-10">Address</h3>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12 ">
                                                    <div class="form-group">
                                                        <label>Address </label>
														<textarea rows="3" required class="form-control" name="addr" style=" resize:none "><?php echo $row['address']; ?></textarea>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">

                                                <!--/span-->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>State</label>
                                                        <select class="form-control" name="state">
														<option value="<?php echo $row['state']; ?>" selected><?php echo $row['state']; ?></option>
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
                                                        <input name="pc" required data-minlength="6" data-error="Invalid zip code" type="text" pattern="[0-9]*" maxlength="6" class="form-control" value="<?php echo $row['pc']; ?>">
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
									</fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

			</div> <!--edit patient profile tab ends-->
								
			<div class="tab-pane" id="visitors">
			<?php 
			$getvinfoquery="SELECT * FROM visitors WHERE p_id='$id' ORDER BY v_id DESC";
			$getvinforesult=mysqli_query($connection,$getvinfoquery);

			date_default_timezone_set('Asia/Kolkata');	
			
			?>
			<div class="row">
                <div class="col-md-12">
					<div class="panel panel-info">
                            <div class="panel-heading">Visitors Log</div>
                            <div class="panel-wrapper collapse in" aria-expanded="true">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                <table id="myTable" class="table table-striped">
                                    <thead>
                                        <tr>
											<!--<th>id</th>-->
                                            <th>Name</th>
                                            <!--<th>Patient Name</th>-->
                                            <!--<th>Ward No</th>-->
                                            <th>Gender</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php if($getvinforesult) while($getvrow=mysqli_fetch_assoc($getvinforesult)) { ?>
                                        <tr>
											<!--<td><?php // echo $getvrow['v_id']; ?> </td>-->
                                            <td><?php echo $getvrow['vname']; ?> </td>
											<!--<td><a href="edit-patient-profile.php?id=<?php // echo $getvrow['p_id']; ?>"><?php //echo $getvrow['fname'].' '.$getvrow['lname']; ?></a></td>-->
                                            <!--<td><?php //echo $getvrow['ward_no']; ?></td>-->
                                            <td><?php echo $getvrow['vsex']; ?></td>
                                            <td><?php $datev=$getvrow['vdate'];
											$myDateTime = DateTime::createFromFormat('Y-m-d', $datev);
											$dovc = $myDateTime->format('d-m-Y');  echo $dovc; ?></td>
                                            <td><?php $gettime=$getvrow['vtime']; echo date('h:i a', strtotime($gettime)); ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
									
									
                                </div>
                            </div>
                        </div>
				</div>
			</div>
			
			</div>
								
								
			<div class="tab-pane" id="removepatient">
				<div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">Discharge Details</div>
                            <div class="panel-wrapper collapse in" aria-expanded="true">
                                <div class="panel-body">
									<form method="post" data-toggle="validator">
										<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label">Date of Discharge</label>
												<div class="input-group">
													<div class="input-group-addon"><i class="icon-calender"></i></div>
													<input <?php if(isset($row['dod'])){ $datedis=$row['dod'];
													$myDateTimedis = DateTime::createFromFormat('Y-m-d', $datedis);
													$dodisc = $myDateTimedis->format('d-m-Y'); echo "disabled value='$dodisc'"; } else { echo 'disabled value='.date("d-m-Y"); } ?>  data-date-format="dd-mm-yyyy" data-mask="99-99-9999" type="text" class="form-control" id="datepicker-autoclose1" name="dod" placeholder="dd-mm-yyyy" >
												</div>
												<!--<span class="font-13 text-muted">dd-mm-yyyy</span>-->
											</div>
										</div>
										<div class="col-md-6">
												<div class="form-group">
													<label class="control-label">&nbsp;</label><br>
													<button <?php if(isset($row['dod'])){ echo 'disabled'; }?> class="btn btn-info" type="submit" name="discharge">Discharge Patient</button>
												  </div>
											</div>
										
										</div>
										<?php
										if(isset($row['dod']))
										{
											$getdischargeinfo="SELECT * FROM ip_bills WHERE p_id='$id'";
											$getdischargeinfores=mysqli_query($connection,$getdischargeinfo);
											$dischargeinfo=mysqli_fetch_assoc($getdischargeinfores);
											
											$dateofjoin=$row['doj'];
											$dateofdis=$row['dod'];
											$dayscount=strtotime($dateofdis) - strtotime($dateofjoin);
											$days=round($dayscount / (60* 60 * 24));
										?>
										<div class="form-body">
                                            <h3 class="box-title">Discharge Info</h3>
                                            <hr class="m-t-0 m-b-10">
                                            <div class="row ">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Date of Admit</label>
                                                        <input disabled type="text" id="firstName" name="fname" class="form-control" placeholder="Enter first name" value="<?php echo $dojc; ?>">
                                                         </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Ward Rent / Day (in &#8377;)</label>
                                                        <input disabled type="text" id="lastName" name="lname" class="form-control" placeholder="Enter last name" value="<?php echo $row['rent']; ?>">
                                                         </div>
                                                </div>
                                                <!--/span-->
                                            </div>
											<div class="row ">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Number of days admitted</label>
                                                        <input disabled type="text" id="firstName" name="fname" class="form-control" placeholder="Enter first name"  value="<?php echo $days ?>">
                                                         </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Total Ward Rent (in &#8377;)</label>
                                                        <input disabled type="text" id="lastName" name="lname" class="form-control" value="<?php echo $dischargeinfo['ward_rent']; ?>">
                                                         </div>
                                                </div>
                                                <!--/span-->
                                            </div>
											<div class="row">
												<div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Total Amount in bill</label>
                                                        <input disabled type="text" id="lastName" name="lname" class="form-control" value="<?php if($dischargeinfo['total_amt']=='0') { echo "Generate Bill to show total amount"; } else { echo $dischargeinfo['total_amt']; } ?>">
                                                     </div>
                                                </div>
											</div>
                                        </div>
                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-offset-3 col-md-9">
															<?php if($dischargeinfo['total_amt']=='0.00') { ?>
                                                            <a target="_blank" href="ip-invoice.php?id=<?php echo $dischargeinfo['bill_id']; ?>" class="btn btn-info text-white" > <i class="fa fa-pencil"></i> Generate Bill </a>
															<?php } else { ?>
															<a target="_blank" href="ip-invoice.php?id=<?php echo $dischargeinfo['bill_id']; ?>" class="btn btn-info text-white" > <i class="fa fa-file-text-o"></i> Show Bill </a>
															<?php } ?>
                                                            <!--<button type="button" class="btn btn-default">Cancel</button>-->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6"> </div>
                                            </div>
                                        </div>
									<?php } ?>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				

				<!-- <center>
				<a href="#" class="fcbtn btn btn-danger model_img deleteAdmin addmidclass" data-id="<?php //echo $id ?>" id="deleteDoc">Remove Patient Record</a>
				</center>-->
								
				
				<div>
				
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
		jQuery('.mydatepicker, #datepicker').datepicker();
    jQuery('#datepicker-autoclose1').datepicker({
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
	
	<!-- Magnific popup JavaScript -->
    <script src="../plugins/bower_components/Magnific-Popup-master/dist/jquery.magnific-popup.min.js"></script>
    <script src="../plugins/bower_components/Magnific-Popup-master/dist/jquery.magnific-popup-init.js"></script>

	<!-- Flot Charts JavaScript -->
    <script src="../plugins/bower_components/flot/jquery.flot.js"></script>
    <script src="../plugins/bower_components/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>

	<script type="text/javascript">
    // Real Time chart


    var data = [],
        totalPoints = 200;

    function getRandomData() {

        if (data.length > 0)
            data = data.slice(1);

        // Do a random walk

        while (data.length < totalPoints) {

            var prev = data.length > 0 ? data[data.length - 1] : 50,
                y = prev + Math.random() * 10 - 5;

            if (y < 0) {
                y = 0;
            } else if (y > 100) {
                y = 100;
            }

            data.push(y);
        }

        // Zip the generated y values with the x values

        var res = [];
        for (var i = 0; i < data.length; ++i) {
            res.push([i, data[i]])
        }

        return res;
    }

    // Set up the control widget

    var updateInterval = 20;
    $("#updateInterval").val(updateInterval).change(function() {
        var v = $(this).val();
        if (v && !isNaN(+v)) {
            updateInterval = +v;
            if (updateInterval < 1) {
                updateInterval = 1;
            } else if (updateInterval > 2000) {
                updateInterval = 2000;
            }
            $(this).val("" + updateInterval);
        }
    });

    var plot = $.plot("#placeholder", [getRandomData()], {
        series: {
            shadowSize: 0 // Drawing is faster without shadows
        },
        yaxis: {
            min: 0,
            max: 200
        },
        xaxis: {
            show: false
        },
        colors: ["#01c0c8"],
        grid: {
            color: "#AFAFAF",
            hoverable: true,
            borderWidth: 0,
            backgroundColor: '#FFF'
        },
        tooltip: true,
        resize: true,
        tooltipOpts: {
            content: "Y: %y",
            defaultTheme: false
        }


    });

    function update() {

        plot.setData([getRandomData()]);

        // Since the axes don't change, we don't need to call plot.setupGrid()

        plot.draw();
        setTimeout(update, updateInterval);
    }

    update();
    </script>
	<!--script to show patient profile in left-sidebar start-->
	<script>
	$(document).ready(function() {
            $("#hidden-item").css('display','list-item');
});
</script>

</body>

</html>
