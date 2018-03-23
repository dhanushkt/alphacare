<?php
require('login/connect.php');

$showinfo=0;
if(isset($_GET['id']))
{
	$tokenno=$_GET['id'];
	$selectapoint="SELECT *,doctors.fname,doctors.lname,doctors.specialist FROM appointments INNER JOIN doctors ON appointments.doc_id = doctors.doc_id WHERE ap_token='$tokenno'";
	$selectapointresult=mysqli_query($connection,$selectapoint);
	$selectapointcount=mysqli_num_rows($selectapointresult);
	if($selectapointcount==1)
	{
		$selectapointfetch=mysqli_fetch_assoc($selectapointresult);
		$showinfo=1;
	}
	else
	{
		$fmsg="Incorrect appointment token number ! ";
	}
}

if(isset($_POST['CancelAp']))
{
	if(empty($tokenno))
	{
		$tokenno=$_POST['hiddentokenno'];
	}
	//removed time=NULL simce we need to know at what times apoint has been cancelled
	$updateapointquery="UPDATE appointments SET status='Cancelled by patient' WHERE ap_token='$tokenno'";
	$updateapointqueryresult=mysqli_query($connection,$updateapointquery);
	if($updateapointqueryresult)
	{
		$fmsg="Appointment Cancelled !";
	}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Site Title -->
    <title>AlphaCare OHMS</title>
    <!-- Meta Description Tag -->
    <meta name="description" content="AlphaCare Online Hospital Management System">
    <meta name="author" content="Dhanush KT, Nishanth Bhat">
    <!-- Favicon Icon -->
    <link rel="icon" type="image/x-icon" href="plugins/images/favicon.png" />
    <!-- Font Awesoeme Stylesheet CSS -->
    <link rel="stylesheet" href="landerpage/font-awesome/css/font-awesome.min.css" />
    <!-- Google web Font -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Montserrat:400,500">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="landerpage/css/bootstrap.min.css">
    <!-- Material Design Lite Stylesheet CSS -->
    <link rel="stylesheet" href="landerpage/css/material.min.css" />
    <!-- Material Design Select Field Stylesheet CSS -->
    <link rel="stylesheet" href="landerpage/css/mdl-selectfield.min.css">
    <!-- Owl Carousel Stylesheet CSS -->
    <link rel="stylesheet" href="landerpage/css/owl.carousel.min.css" />
    <!-- Animate Stylesheet CSS -->
    <link rel="stylesheet" href="landerpage/css/animate.min.css" />
    <!-- Magnific Popup Stylesheet CSS -->
    <link rel="stylesheet" href="landerpage/css/magnific-popup.css" />
    <!-- Flex Slider Stylesheet CSS -->
    <link rel="stylesheet" href="landerpage/css/flexslider.css" />
    <!-- Custom Main Stylesheet CSS -->
    <link rel="stylesheet" href="landerpage/css/style.css">
</head>
<body>
    <!-- Start Header -->
    <header id="header">
        <!-- Start Header Top Section -->
        
        <!-- Start Main Header Section -->
      <!-- End Main Header Section -->
    
	<div id="hdr-top-wrapper">
            <div class="layer-stretch hdr-top">
                <div class="hdr-top-block hidden-xs">
                    <div id="hdr-social">
                        <ul class="social-list social-list-sm">
                            <li><a class="width-auto font-13"><img src="plugins/images/eliteadmin-text-dark.png" alt=""></a></li>
                            <li><a href="#"  id="hdr-facebook" ></a></li>
							<li><a href="#"  id="hdr-twitter" ></a></li>
							<li><a href="#"  id="hdr-google" ></a></li>
                            <li><a href="#"  id="hdr-instagram" ></a></li>
                            <li><a href="#"  id="hdr-youtube" ></a></li>
							<li><a href="#"  id="hdr-twitter" ></a></li>
							<li><a href="#"  id="hdr-google" ></a></li>
                            <li><a href="#"  id="hdr-instagram" ></a></li>
                            <li><a href="#"  id="hdr-rss" ></a></li>
                        </ul>
                    </div>
                </div>
                <div class="hdr-top-line hidden-xs"></div>
                <div class="hdr-top-block hdr-number">
                    <div class="font-13">
                        <i class="fa fa-mobile font-20 tbl-cell"> </i> <span class="hidden-xs tbl-cell"> Enquiry Number : </span> <span class="tbl-cell">0824-24297299</span>
                    </div>
                </div>
                <div class="hdr-top-line"></div>
                <div class="hdr-top-block">
                    <div class="theme-dropdown">
                        
                       
                    </div>
                </div>
            </div>
        </div>
		<div id="hdr-wrapper">
            <div class="layer-stretch hdr">
                <div class="tbl">
                    <div class="tbl-row">
                        <!-- Start Header Logo Section -->
                        <div class="tbl-cell hdr-logo">
                            <a href="index.html"><img src="landerpage/images/fevicon1.png" alt="" style="width:60px; height:60px"></a>
                        </div><!-- End Header Logo Section -->
                        <div class="tbl-cell hdr-menu">
                            <!-- Start Menu Section -->
                            <ul class="menu">
                                <li>
                                    <a id="menu-home" href="index.php" class="mdl-button mdl-js-button mdl-js-ripple-effect">Home</a>
                                </li>
                                <li>
                                    <a id="menu-service" href="index.php#service1" class="mdl-button mdl-js-button mdl-js-ripple-effect">Services </a>
                                </li>
								 <li class="menu-megamenu-li">
                                    <a id="menu-pages" href="index.php#about" class="mdl-button mdl-js-button mdl-js-ripple-effect">About Us</a>
                                    
                                </li>
                                <li class="menu-megamenu-li">
                                    <a id="menu-doctor" href="index.php#contact" class="mdl-button mdl-js-button mdl-js-ripple-effect">Contact us </a>
                                    
                                </li>
                                <li>
                                    <a id="menu-blog" href="index.php#locate" class="mdl-button mdl-js-button mdl-js-ripple-effect">Locate Us 
                                    </a>
                                </li>
                                <li>
                                    <a id="menu-profile" href="login/" class="mdl-button mdl-js-button mdl-js-ripple-effect">Login </a>
                                </li>
                                <li class="mobile-menu-close"><i class="fa fa-times"></i></li>
                            </ul><!-- End Menu Section -->
                            <div id="menu-bar"><a><i class="fa fa-bars"></i></a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</header><!-- End Header -->
    <!-- Start Page Title Section -->
    <div class="page-ttl">
        <div class="layer-stretch">
            <div class="page-ttl-container">
                <h1>CHECK APPOINTMENT STATUS</h1>
                <p>Enter your token number to check your appointment status</p>
            </div>
        </div>
    </div><!-- End Page Title Section -->
    <!-- Start My Profile Section -->
	<?php 
	if(isset($_POST['tokensubmit']))
	{
		//modify this there are some other ways
		$tokenno=mysqli_real_escape_string($connection,$_POST['tokenno']);
		$selectapoint="SELECT *,doctors.fname,doctors.lname,doctors.specialist FROM appointments INNER JOIN doctors ON appointments.doc_id = doctors.doc_id WHERE ap_token='$tokenno'";
		$selectapointresult=mysqli_query($connection,$selectapoint);
		$selectapointcount=mysqli_num_rows($selectapointresult);
		if($selectapointcount==1)
		{
			$selectapointfetch=mysqli_fetch_assoc($selectapointresult);
			$showinfo=1;
		}
		else
		{
			$fmsg="Incorrect appointment token number ! ";
		}
		
	}
	
	?>
	
	
    <div id="profile-page" class="layer-stretch pb-0">
        <div class="layer-wrapper pb-0">
            <div class="theme-material-card text-center">
				<?php if(isset($fmsg)) { ?>
		<div class="alert alert-danger text-center" role="alert"><strong> <?php echo $fmsg; ?> </strong><button type="button" calss="close" data-dismiss="alert" style="float: right" >X</button> </div>
	<?php } ?>
				<form method="post">
                <div class="row">
                    <div class="col-md-4"><center>
						
                          </center>
                    </div> 
					<div class="col-md-4">
                       <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input-icon">
						   <i class="fa fa-ticket"></i>
                            <input class="mdl-textfield__input" value="<?php if(isset($tokenno)){ echo $tokenno; } ?>" type="text" pattern="[0-9]*" id="profile-name" name="tokenno">
                            <label class="mdl-textfield__label" for="profile-name">Token Number</label>
                            <span class="mdl-textfield__error">Please Enter Valid Token Number!</span>
                        </div>  
                    </div>
                </div>                
				<br><div>
					<button name="tokensubmit" class="mdl-button mdl-js-button mdl-js-ripple-effect button button-primary">CHECK</button>
                </div>
				</form>
            </div>  
        </div>
    </div><!-- End My Profile Section -->
    <!-- Start Emergency Section -->
	
	<?php if($showinfo==1) { ?>
	<div id="profile-page1" class="layer-stretch pt-0">
		<div class="layer-wrapper pt-0">
			<div class="theme-material-card text-center">
				<form method="post" onsubmit="return confirm('Do you really want to cancel the appointment ?');">
				<div class="row">
					<div class="col-md-6">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input-icon">
                                <i class="fa fa-user-o"></i>
                                <input value="<?php echo $selectapointfetch['name'] ?>" readonly class="mdl-textfield__input" type="text" name="name" pattern="[A-Z,a-z, ]*" id="appointment-name">
                                <label class="mdl-textfield__label" for="appointment-name">Name</label>
                                <span class="mdl-textfield__error">Please Enter Valid Name!</span>
                            </div>
                        </div>
						  <div class="col-md-6">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input-icon">
                                <i class="fa fa-user-o"></i>
                                <input value="<?php echo $selectapointfetch['sex'] ?>" readonly class="mdl-textfield__input" type="text" name="sex" pattern="[A-Z,a-z, ]*" id="appointment-sex">
                                <label class="mdl-textfield__label" for="appointment-name">Sex</label>
                                <span class="mdl-textfield__error">Please Enter Sex</span>
                            </div>
                        </div>
						<div class="col-md-6">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input-icon">
                                <i class="fa fa-envelope-o"></i>
                                <input value="<?php echo $selectapointfetch['aemail'] ?>" readonly class="mdl-textfield__input" type="text" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" id="appointment-email">
                                <label class="mdl-textfield__label" for="appointment-email">Email</label>
                                <span class="mdl-textfield__error">Please Enter Valid Email!</span>
                            </div>
                        </div>
						<div class="col-md-6">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input-icon">
                                <i class="fa fa-phone"></i>
                                <input value="<?php echo $selectapointfetch['phno'] ?>" readonly class="mdl-textfield__input" type="text" name="phno" pattern="[0-9]*" id="appointment-mobile">
                                <label class="mdl-textfield__label" for="appointment-mobile">Mobile Number</label>
                                <span class="mdl-textfield__error">Please Enter Valid Mobile Number!</span>
                            </div>
                        </div>
					   <!-- <div class="col-md-6">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input-icon">
                                <i class="fa fa-calendar-o"></i>
                                <input value="<?php// $dateb=$selectapointfetch['dob'];
								// $myDateTime = DateTime::createFromFormat('Y-m-d', $dateb);
								// $dobc = $myDateTime->format('d-m-Y');  echo $dobc; ?>" readonly class="mdl-textfield__input" type="text" id="appointment-date">
                                <label class="mdl-textfield__label" for="appointment-date">Date Of Birth</label>
                                <span class="mdl-textfield__error">Please Enter Valid Date Number!</span>
                            </div>
                        </div> -->
                        <div class="col-md-12">
							<div class="pl-3 pt-0 pb-0 theme-quote">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input-icon">
									<i class="fa fa-calendar-o"></i>
									<input value="<?php $datea=$selectapointfetch['doa'];
									$myDateTime = DateTime::createFromFormat('Y-m-d', $datea);
									$doac = $myDateTime->format('d-m-Y');  echo $doac; ?>" readonly class="mdl-textfield__input" type="text" id="appointment-date1">
									<label class="mdl-textfield__label" for="appointment-date">Date Of Appointment</label>
									<span class="mdl-textfield__error">Please Enter Valid Date Number!</span>
								</div>
							</div>
                        </div>
                        
                        <div class="col-md-12">
							<div class="pl-3 pt-0 pb-0 theme-quote">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input-icon" >
									<i class="fa fa-user-md"></i>
									<input value="<?php echo 'Dr. '.$selectapointfetch['fname'].' '.$selectapointfetch['lname'].' , '.$selectapointfetch['specialist']; ?>" readonly class="mdl-textfield__input" type="text" name="email" id="appointment-doctor">
									<label class="mdl-textfield__label" for="appointment-email">Doctor</label>
								</div>
							</div>
                        </div>
						<div class="col-md-6">
							<div class="card text-black bg-light mb-1">
							 <div class="card-header font-16">Appointment status</div>
								<div class="card-body">
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input-icon">
										<i class="fa fa-info"></i>
										<input value="<?php echo $selectapointfetch['status']; ?>" readonly class="mdl-textfield__input" type="text" name="email" id="appointment-doctor">
										<label class="mdl-textfield__label" for="appointment-email">Status of appointment</label>
									</div>
								</div>
							</div>
							
                        </div>
					 <div class="col-md-6">
						 <div class="card text-black bg-light mb-1">
							 <div class="card-header font-16">Time of appointment</div>
							 <div class="card-body">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input-icon">
									<i class="fa fa-clock-o"></i>
									<input value="<?php if($selectapointfetch['time']=='') { echo 'Not Scheduled'; } else { $gettime=$selectapointfetch['time']; echo ' '.date('h:i a', strtotime($gettime)); } ?>" readonly class="mdl-textfield__input" type="text" name="email" id="appointment-doctor">
									<label class="mdl-textfield__label" for="appointment-email">Time of appointment</label>
								</div>
							 </div>
						 </div>
                      </div>
				</div>
				<div class="text-center pt-4">
					<input type="hidden" value="<?php echo $selectapointfetch['ap_token']; ?>" name="hiddentokenno">
					<button class="mdl-button mdl-js-button mdl-button--colored mdl-js-ripple-effect mdl-button--raised button button-danger button-md" name="CancelAp">Cancel Appointment</button>
				</div>
				</form>
			</div>
		</div><br>
	</div>
	<?php } ?>
	
	<!-- End Emergency Section -->
    <!-- Start Make an Appointment Modal -->
    <!--<div id="appointment" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h5 class="modal-title">Make An Appointment</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="appointment-error"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input-icon">
                                <i class="fa fa-user-o"></i>
                                <input class="mdl-textfield__input" type="text" pattern="[A-Z,a-z, ]*" id="appointment-name">
                                <label class="mdl-textfield__label" for="appointment-name">Name</label>
                                <span class="mdl-textfield__error">Please Enter Valid Name!</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input-icon">
                                <i class="fa fa-envelope-o"></i>
                                <input class="mdl-textfield__input" type="text" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" id="appointment-email">
                                <label class="mdl-textfield__label" for="appointment-email">Email</label>
                                <span class="mdl-textfield__error">Please Enter Valid Email!</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input-icon">
                                <i class="fa fa-phone"></i>
                                <input class="mdl-textfield__input" type="text" pattern="[0-9]*" id="appointment-mobile">
                                <label class="mdl-textfield__label" for="appointment-mobile">Mobile Number</label>
                                <span class="mdl-textfield__error">Please Enter Valid Mobile Number!</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label form-input-icon">
                                <i class="fa fa-hospital-o"></i>
                                <select class="mdl-selectfield__select" id="appointment-department">
                                    <option value="">&nbsp;</option>
                                    <option value="1">Gynaecology</option>
                                    <option value="2">Orthology</option>
                                    <option value="3">Dermatologist</option>
                                    <option value="4">Anaesthesia</option>
                                    <option value="5">Ayurvedic</option>
                                </select>
                                <label class="mdl-selectfield__label" for="appointment-department">Choose Department</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label form-input-icon">
                                <i class="fa fa-user-md"></i>
                                <select class="mdl-selectfield__select" id="appointment-doctor">
                                    <option value="">&nbsp;</option>
                                    <option value="1">Dr. Daniel Barnes</option>
                                    <option value="2">Dr. Steve Soeren</option>
                                    <option value="3">Dr. Barbara Baker</option>
                                    <option value="4">Dr. Melissa Bates</option>
                                    <option value="5">Dr. Linda Adams</option>
                                </select>
                                <label class="mdl-selectfield__label" for="appointment-doctor">Choose Doctor</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input-icon">
                                <i class="fa fa-calendar-o"></i>
                                <input class="mdl-textfield__input" type="text" id="appointment-date" onfocus="(this.type='date')" onblur="(this.type='text')">
                                <label class="mdl-textfield__label" for="appointment-date">Date</label>
                                <span class="mdl-textfield__error">Please Enter Valid Date Number!</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-center pt-4">
                        <button class="mdl-button mdl-js-button mdl-button--colored mdl-js-ripple-effect mdl-button--raised button button-primary button-lg make-appointment">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>--><!-- End Make an Appointment Modal -->
    <!-- Start Login Modal -->
	<!--REMOVED-->
    <!-- End Login Modal -->
	
    <!-- Start Register Modal -->
   
    <!-- Fixed Appointment Button at Bottom -->
    <div id="appointment-button" class="animated fadeInUp">
        <button id="appointment-now" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored mdl-button--raised"><i class="fa fa-plus"></i></button>
        <div class="mdl-tooltip mdl-tooltip--top" data-mdl-for="appointment-now">Make An Appointment</div>
    </div><!-- End Fixed Appointment Button at Bottom -->
    <!-- Start Footer Section -->
    <footer id="footer">
        <div class="layer-stretch">
            <!-- Start main Footer Section -->
            <div class="row layer-wrapper">
                <div class="col-md-4 footer-block">
                    <div class="footer-ttl"><p>Basic Info</p></div>
                    <div class="footer-container footer-a">
                        <div class="tbl">
                            <div class="tbl-row">
                                <div class="tbl-cell"><i class="fa fa-map-marker"></i></div>
                                <div class="tbl-cell">
                                    <p class="paragraph-medium paragraph-white">
                                        Your office, Building Name<br />
                                        Street name, Area<br />
                                        City, Country Pin Code
                                    </p>
                                </div>
                            </div>
                            <div class="tbl-row">
                                <div class="tbl-cell"><i class="fa fa-phone"></i></div>
                                <div class="tbl-cell">
                                    <p class="paragraph-medium paragraph-white">11122333333</p>
                                </div>
                            </div>
                            <div class="tbl-row">
                                <div class="tbl-cell"><i class="fa fa-envelope"></i></div>
                                <div class="tbl-cell">
                                    <p class="paragraph-medium paragraph-white">hello@yourdomain.com</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 footer-block">
                    <div class="footer-ttl"><p>Quick Links</p></div>
                    <div class="footer-container footer-b">
                        <div class="tbl">
                            <div class="tbl-row">
                                <ul class="tbl-cell">
                                    <li><a href="event-1.html">Event Style 1</a></li>
                                    <li><a href="event-2.html">Event Style 2</a></li>
                                    <li><a href="contact.html">Contact</a></li>
                                    <li><a href="gallery.html">Gallery</a></li>
                                    <li><a href="privacy-policy.html">Privacy policy</a></li>
                                    <li><a href="terms-conditions.html">Terms condition</a></li>
                                    <li><a href="faq.html">Faq</a></li>
                                </ul>
                                <ul class="tbl-cell">
                                    <li><a href="login.html">Login</a></li>
                                    <li><a href="register.html">Register</a></li>
                                    <li><a href="forgot.html">Forgot Password</a></li>
                                    <li><a href="myappointment.html">My Appointment</a></li>
                                    <li><a href="myrequest.html">My Request</a></li>
                                    <li><a href="myprofile.html">My Profile</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 footer-block">
                    <div class="footer-ttl"><p>Newsletter</p></div>
                    <div class="footer-container footer-c">
                        <div class="footer-subscribe">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input">
                                <input class="mdl-textfield__input" type="text" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" id="subscribe-email">
                                <label class="mdl-textfield__label" for="subscribe-email">Your Email</label>
                                <span class="mdl-textfield__error">Please Enter Valid Email!</span>
                            </div>
                            <div class="footer-subscribe-button">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect button button-primary">Submit</button>
                            </div>
                        </div>
                        <ul class="social-list social-list-colored footer-social">
                            <li>
                                <a href="#" target="_blank" id="footer-facebook" class="fa fa-facebook"></a>
                                <span class="mdl-tooltip mdl-tooltip--top" data-mdl-for="footer-facebook">Facebook</span>
                            </li>
                            <li>
                                <a href="#" target="_blank" id="footer-twitter" class="fa fa-twitter"></a>
                                <span class="mdl-tooltip mdl-tooltip--top" data-mdl-for="footer-twitter">Twitter</span>
                            </li>
                            <li>
                                <a href="#" target="_blank" id="footer-google" class="fa fa-google"></a>
                                <span class="mdl-tooltip mdl-tooltip--top" data-mdl-for="footer-google">Google</span>
                            </li>
                            <li>
                                <a href="#" target="_blank" id="footer-instagram" class="fa fa-instagram"></a>
                                <span class="mdl-tooltip mdl-tooltip--top" data-mdl-for="footer-instagram">Instagram</span>
                            </li>
                            <li>
                                <a href="#" target="_blank" id="footer-youtube" class="fa fa-youtube"></a>
                                <span class="mdl-tooltip mdl-tooltip--top" data-mdl-for="footer-youtube">Youtube</span>
                            </li>
                            <li>
                                <a href="#" target="_blank" id="footer-linkedin" class="fa fa-linkedin"></a>
                                <span class="mdl-tooltip mdl-tooltip--top" data-mdl-for="footer-linkedin">Linkedin</span>
                            </li>
                            <li>
                                <a href="#" target="_blank" id="footer-flickr" class="fa fa-flickr"></a>
                                <span class="mdl-tooltip mdl-tooltip--top" data-mdl-for="footer-flickr">Flickr</span>
                            </li>
                            <li>
                                <a href="#" target="_blank" id="footer-rss" class="fa fa-rss"></a>
                                <span class="mdl-tooltip mdl-tooltip--top" data-mdl-for="footer-rss">Rss</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div><!-- End main Footer Section -->
        <!-- Start Copyright Section -->
        <div id="copyright">
            <div class="layer-stretch">
                <div class="paragraph-medium paragraph-white">2018 &copy; AlphaCare - Online Hospital Management System</div>
            </div>
        </div><!-- End of Copyright Section -->
    </footer><!-- End of Footer Section -->

    <!-- **********Included Scripts*********** -->

    <!-- Jquery Library 2.1 JavaScript-->
    <script src="landerpage/js/jquery-2.1.4.min.js"></script>
    <!-- Popper JavaScript-->
    <script src="landerpage/js/popper.min.js"></script>
    <!-- Popper JavaScript-->
    <script src="landerpage/js/popper.min.js"></script>
    <!-- Bootstrap Core JavaScript-->
    <script src="landerpage/js/bootstrap.min.js"></script>
    <!-- Material Design Lite JavaScript-->
    <script src="landerpage/js/material.min.js"></script>
    <!-- Material Select Field Script -->
    <script src="landerpage/js/mdl-selectfield.min.js"></script>
    <!-- Flexslider Plugin JavaScript-->
    <script src="landerpage/js/jquery.flexslider.min.js"></script>
    <!-- Owl Carousel Plugin JavaScript-->
    <script src="landerpage/js/owl.carousel.min.js"></script>
    <!-- Scrolltofixed Plugin JavaScript-->
    <script src="landerpage/js/jquery-scrolltofixed.min.js"></script>
    <!-- Magnific Popup Plugin JavaScript-->
    <script src="landerpage/js/jquery.magnific-popup.min.js"></script>
    <!-- WayPoint Plugin JavaScript-->
    <script src="landerpage/js/jquery.waypoints.min.js"></script>
    <!-- CounterUp Plugin JavaScript-->
    <script src="landerpage/js/jquery.counterup.js"></script>
    <!-- SmoothScroll Plugin JavaScript-->
    <script src="landerpage/js/smoothscroll.min.js"></script>
    <!--Custom JavaScript for Klinik Template-->
    <script src="landerpage/js/custom.js"></script>
</body>
</html>