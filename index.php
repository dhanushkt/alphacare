<?php 
require('login/connect.php');

$getdocinfo="SELECT doc_id,fname,lname,specialist FROM doctors";
$getdocinforesult=mysqli_query($connection,$getdocinfo);

if(isset($_POST['apointsubmit']))
{
	$apname=mysqli_real_escape_string($connection,$_POST['apointname']);
	$apemail=mysqli_real_escape_string($connection,$_POST['apointemail']);
	if($apname=="" && $apemail=="")
	{
		$fmsg='Please fill out all the fields to submit appointment';
	}
	else
	{	
		$gettokenid="SELECT ap_token FROM appointments";
		$gettokenidresult=mysqli_query($connection,$gettokenid);
		$gettokenidfetch=mysqli_fetch_assoc($gettokenidresult);
		do{
			$generatetoken=random_int(105687,996523);
		}
		while($gettokenidfetch['ap_token']==$generatetoken);

		$aptoken=$generatetoken;

		$apsex=mysqli_real_escape_string($connection,$_POST['apointsex']);
		$appno=mysqli_real_escape_string($connection,$_POST['apointpno']);
		$getdob=$_POST['apointdob'];
		//$myDateTime = DateTime::createFromFormat('d-m-Y', $getdob);
		//$apdob = $myDateTime->format('Y-m-d');
		$getdoa=$_POST['apointdoa'];
		//$myDateTimea = DateTime::createFromFormat('d-m-Y', $getdoa);
		//$apdoa = $myDateTimea->format('Y-m-d');
		$apdoc=mysqli_real_escape_string($connection,$_POST['apointdoc']);
		$apstatus='In Process';

		$apinputquery="INSERT INTO `appointments` (ap_token,name,sex,aemail,phno,dob,doa,doc_id,status) VALUES ('$aptoken','$apname','$apsex','$apemail','$appno','$getdob','$getdoa','$apdoc','$apstatus')";
		$apinputresult=mysqli_query($connection,$apinputquery);
		if($apinputresult)
		{
			$smsg="Appointment created, ";
			//mailing function starts
			$link="http://localhost/ohms/check-appointment.php?id=$aptoken";
			$link2="http://localhost/ohms/check-appointment.php";
				
			$to_Email       = $apemail; // Replace with recipient email address
			$subject        = 'Your Appointment'; //Subject line for emails

			$host           = "smtp.gmail.com"; // Your SMTP server. For example, smtp.mail.yahoo.com
			$username       = "alphacare.ohms@gmail.com"; //For example, your.email@yahoo.com
			$password       = "dnspnb@12007"; // Your password
			$SMTPSecure     = "tls"; // For example, ssl
			$port           = 587; // For example, 465

			//proceed with PHP email.
			include("login/php/PHPMailerAutoload.php"); //you have to upload class files "class.phpmailer.php" and "class.smtp.php"

			$mail = new PHPMailer();
		$mail->SMTPOptions=array('ssl'=>array('verify_peer'=>false,'verify_peer_name'=>false,'allow_self_signed'=>true));

			$mail->IsSMTP();
			$mail->SMTPAuth = true;

			$mail->Host = $host;
			$mail->Username = $username;
			$mail->Password = $password;
			$mail->SMTPSecure = $SMTPSecure;
			$mail->Port = $port;


			$mail->setFrom($username);
			$mail->addReplyTo($apemail);

			$mail->AddAddress($to_Email);
			$mail->Subject = $subject;

			$mail->Body = '<div width="100%" style="background: #f8f8f8; padding: 0px 0px; font-family:arial; line-height:28px; height:100%;  width: 100%; color: #514d6a;">
		  <div style="max-width: 700px; padding:50px 0;  margin: 0px auto; font-size: 14px">
			<table border="0" cellpadding="0" cellspacing="0" style="width: 100%; margin-bottom: 20px">
			  <tbody>
				<tr>
				  <td style="vertical-align: top; padding-bottom:30px;" align="center"><a href="http://infinityx.000webhostapp.com/login/" target="_blank"><img src="https://i.imgur.com/zKKdcP7.png" alt="AlphaCare" style="border:none"><br/>
					<img src="https://i.imgur.com/ZA1Wwui.png" style="border:none"></a> </td>
				</tr>
			  </tbody>
			</table>
			<div style="padding: 40px; background: #fff;">
			  <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
				<tbody>
				  <tr>
					<td style="border-bottom:1px solid #f6f6f6;"><h1 style="font-size:14px; font-family:arial; margin:0px; font-weight:bold;">Dear Sir/Madam,</h1>
					  <p style="margin-top:0px; color:#bbbbbb;">We have recived your appointment request.</p></td>
				  </tr>
				  <tr>
					<td style="padding:10px 0 30px 0;"><p>Your appointment confirmation is in process. Your token number is: <b>'.$aptoken.'</b> . </p> <p>We will update your appointment timing as soon as possible, To check the status of your appointment click: </p>
					  <center>
						<a href="'.$link.'" style="display: inline-block; padding: 11px 30px; margin: 20px 0px 30px; font-size: 15px; color: #fff; background: #00c0c8; border-radius: 60px; text-decoration:none;">Check Appointment Status</a>
					  </center>
					  <b>- Thank You (AlphaCare team)</b> </td>
				  </tr>
				  <tr>
					<td  style="border-top:1px solid #f6f6f6; padding-top:20px; color:#777">If the button above does not work, click <a href="'.$link2.'">here</a> and enter your token number. If you continue to have problems or for any enquiries, please feel free to contact us at 0824-2429729 </td>
				  </tr>
				</tbody>
			  </table>
			</div>
			<div style="text-align: center; font-size: 12px; color: #b2b2b5; margin-top: 20px">
			  <p> AlphaCare Online Hospital Management System © 2018 <br>
			  </p>
			</div>
		  </div>
		</div>';

			$mail->WordWrap = 200;
			$mail->IsHTML(true);

			if(!$mail->send()) 
			{
				$fmsg="E-mail not sent";
			} else 
			{
				$smsg.="please check your Email for token number";
			}
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <!-- this is landing page make my alpha care-->
   <!-- seccond comment by dns-->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Site Title -->
    <title>AlphaCare</title>
    <!-- Meta Description Tag -->
    <meta name="description" content="AlphaCare Online Hospital Management System">
    <meta name="author" content="Dhanush KT, Nishanth Bhat">
    <!-- Favicon Icon -->
    <link rel="icon" type="image/x-icon" href="plugins/images/favicon.png" />
    <!-- Font Awesoeme Stylesheet CSS -->
    <link rel="stylesheet" href="landerpage/font-awesome/css/font-awesome.min.css" />
    <!-- Google web Font -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600">
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
     <link rel="stylesheet" href="landerpage/css/layerslider.css">
    <style>#map {
  height: 500px;
  width: 100%;
 }
	.map-responsive{
    overflow:hidden;
    padding-bottom:56.25%;
    position:relative;
    height:0;
}
.map-responsive iframe{
    left:0;
    top:0;
    height:100%;
    width:100%;
    position:absolute;
}</style>
	
<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#usernameLoading').hide();
		$('#appointment-date').change(function(){
		  $('#usernameLoading').show();
	      $.post("check-apointdate.php", {
	        username: $('#appointment-date').val()
	      }, function(response){
	        $('#usernameResult').fadeOut();
	        setTimeout("finishAjax('usernameResult', '"+escape(response)+"')", 200);
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
</head>
<body>
    <!-- Start Header Section -->
    <header id="header-3">
		<?php if(isset($smsg)) { ?>
		<div class="theme-quote theme-quote-colored theme-quote-success alert" role="alert"><strong> <?php echo $smsg; ?> </strong> <button onClick="window.location='index.php';" type="button" calss="close" data-dismiss="alert" style="float: right" >X</button> </div>  <?php } ?>
		<?php if(isset($fmsg)) { ?>
		<div class="theme-quote theme-quote-colored theme-quote-danger alert" role="alert"><strong> <?php echo $fmsg; ?> </strong> <button onClick="window.location='index.php';" type="button" calss="close" data-dismiss="alert" style="float: right" >X</button> </div> <?php } ?>
						
        <div class="layer-stretch hdr-center">
            <div class="row align-items-center">
                <div class="col-md-5 hidden-xs">
                    <div class="hdr-center-account text-left p-0">
                        <a class="font-14 mr-4"></a>
                        <a class="font-14"></a>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="hdr-center-logo text-center">
                        <a href="index.php" class="d-inline-block"><img src="landerpage/images/ac.png" alt=""></a>
                    </div>
                </div>
				 <div class="col-md-5 hidden-xs">
                    <div class="hdr-center-account text-right p-0">
                        <a class="font-14 mr-4" href="login/"><i class="fa fa-sign-in"></i>Login</a>
                        <a class="font-14"></a>
                    </div>
                </div>
               <!-- <div class="col-md-5 hidden-xs">
                    <div class="pull-right">
                        <ul class="social-list social-list-bordered">
							<li><a class="font-14 mr-4"><i class="fa fa-sign-in"></i>Login</a></li>
                      <li>  <a class="font-14"><i class="fa fa-user-o"></i>Register</a></li>
                        <li>
                                <a href="#" id="hdr-facebook" class="fa fa-facebook rounded"></a>
                                <span><i class="fa fa-sign-in"></i>Login</span>
                            </li>
                            <li>
                                <a href="#" id="hdr-twitter" class="fa fa-twitter rounded"></a>
                                <span class="mdl-tooltip mdl-tooltip--bottom" data-mdl-for="hdr-twitter">Twitter</span>
                            </li>
                           
                        </ul>			
                    </div>
                </div>-->
            </div>
        </div>
        <div class="hdr-center-menu">
            <div class="hdr layer-stretch">
                <div class="row align-items-center justify-content-end">
                    <!-- Start Menu Section -->
					<div class="image">
							<img src="landerpage/images/logo-bwhite1.png" alt="image" style="width:60px; height:60px">
					</div>
                    <ul class="col menu text-left">
                         
							<li >
                                <a id="menu-home" href="#slider1">Home </a>

                            </li>
                            <li class="menu-megamenu-li">
                                <a id="service" href="#service1">Services</a>

                            </li>
                            <li>
                                <a id="menu-service" href="#about">About Us</a>

                            </li>
                            <li class="menu-megamenu-li">
                                <a id="menu-doctor" href="#contact">Contact Us</a>

                            </li>
                            <li>
                                <a id="menu-blog" href="#locate" >Locate Us
                                </a>

                            </li>
                            <li class="menu-megamenu-li">
                                <a id="service2" href="check-appointment.php" >Check Appointment</a>
                            </li>
							<li>
                                <a id="menu-login" href="login/" >Login
                                </a>
                            </li>
                        <li class="mobile-menu-close"><i class="fa fa-times"></i></li>
                    </ul><!-- End Menu Section -->
                    <div class="col col-md-auto d-none d-sm-block d-md-block d-lg-block d-xl-block">
                        <button class="mdl-button mdl-button--colored mdl-button--raised mdl-js-button mdl-js-ripple-effect hdr-apointment"><i class="fa fa-calendar m-0 color-white"></i> Make An Appointment</button>
                    </div>
                   <!-- <div class="col-2 col-md-auto col-lg-auto">
                        <div class="mdl-button mdl-js-button mdl-button--fab hdr-search">
                            <i class="fa fa-search fa-2x color-white"></i>
                        </div>
                    </div>-->
                    <div id="menu-bar" class="col-2 col-md-auto"><a><i class="fa fa-bars color-white"></i></a></div>
                </div>
                <div class="search-banner animated fadeInUp">
                    <input type="text" placeholder="Search your Query ...">
                </div>
            </div>
        </div>
    </header><!-- End Header -->
    <!-- Start Slider Section -->

    <div id="slider1" class="slider-1">
        <div class="flexslider slider-wrapper">
            <ul class="slides">
                <li>
                    <div class="slider-info">
                        <h1 class="animated fadeInDown">JAYASHREE NURSING HOME</h1>
                    </div>
                    <div class="slider-backgroung-image" style="background-image: url(landerpage/uploads/bg1.jpg);"></div>
                    <!-- Make an Appointment  Button -->

                </li>

            </ul>
        </div>
	</div>
      <!--  End Slider Section-->

<!-- Start Service Section -->
   <section id="service1">
    <div id="hm-service" class="layer-stretch">
        <div class="layer-wrapper">
            <div class="layer-ttl">
                <h3>What We Do</h3>
            </div>
            <div class="layer-container">
                <div class="feature-block feature-block-dark">
                    <div class="feature-icon"><i class="fa fa-phone"></i></div>
                    <span>Emergency Departments</span>
                    <p class="paragraph-small paragraph-white">Department of emergency and medical at Jayashree Hospital swing into action to provide prompt, swift & best possible care for each and every patient in case of emergency.</p>
                </div>
                <div class="feature-block feature-block-dark">
                    <div class="feature-icon"><i class="fa fa-calendar"></i></div>
                    <span>24 hour Service</span>
                    <p class="paragraph-small paragraph-white">we are equipped with professional expertise round the clock to handle all type of medical, surgical, trauma and accident emergencies.</p>
				</div><div class="feature-block feature-block-dark">
                    <div class="feature-icon"><i class="fa fa-shopping-bag"></i></div>
                    <span>Pharmacies and drug stores</span>
                    <p class="paragraph-small paragraph-white">Our in-house pharmacy provides seamless 24hrs care to our patients..</p>
                </div>
                
                <center>
                <div class="feature-block feature-block-dark">
                    <div class="feature-icon"><i class="fa fa-stethoscope"></i></div>
                    <span>Primary health care</span>
                    <p class="paragraph-small paragraph-white">Our sevices include out patient medical treatment, Medical follow-ups after discharge from hospital, Health screening and education, In house Pharmaceutical services, And 1 st of its kind exclusive <b>pain management services</b></p>
                </div>
                </center>
            </div>
        </div>
    </div>
    </section><!-- End Service Section -->
    <!-- Start About Section -->
    <section id="about">
    <div id="hm-about" class="parallax-background parallax-background-1">
        <div class="layer-stretch">
            <div class="layer-wrapper">
                <div class="layer-ttl layer-ttl-white">
                    <h3>Who We Are</h3>
                </div>
                <div class="row">
                    <div class="col-md-7">
                        <div class="hm-about-block">
                            <div class="tbl-cell hm-about-icon"><i class="fa fa-user-md"></i></div>
                            <div class="tbl-cell hm-about-number">
                                <span class="counter">54</span>
                                <p>Doctor(s)</p>
                            </div>
                        </div>
                        <div class="hm-about-block">
                            <div class="tbl-cell hm-about-icon"><i class="fa fa-ambulance"></i></div>
                            <div class="tbl-cell hm-about-number">
                                <span class="counter">130</span>
                                <p>Room(s)</p>
                            </div>
                        </div>
                        <div class="hm-about-block">
                            <div class="tbl-cell hm-about-icon"><i class="fa fa-calendar"></i></div>
                            <div class="tbl-cell hm-about-number">
                                <span class="counter">51</span>
                                <p>Year of Experience(s)</p>
                            </div>
                        </div>
                        <div class="hm-about-block">
                            <div class="tbl-cell hm-about-icon"><i class="fa fa-clock-o"></i></div>
                            <div class="tbl-cell hm-about-number">
                                <span class="counter">168</span>
                                <p>Opening Hours per Week</p>
                            </div>
                        </div>
                        <div class="hm-about-paragraph">
                            <p class="paragraph-medium paragraph-white">
                                <span class="theme-dropcap color-white">O</span>ne of the leading gynaecologists of the city, <b>Dr. Mano Rama Rao</b> (Jayashree Nursing Home) in Hampankatta has established the clinic and has gained a loyal clientele over the past few years and is also frequently visited by several celebrities, aspiring models and other honourable clients and international patients as well. They also plan on expanding their business further and providing services to several more patients owing to its success over the past few years. The efficiency, dedication, precision and compassion offered at the clinic ensure that the patient's well-being, comfort and needs are kept of top priority. The clinic is equipped with latest types of equipment and boasts highly advanced surgical instruments that help in undergoing meticulous surgeries or procedures. Locating the healthcare centre is easy as it is <b>K S Rao Road</b>, Hampankatta..
                            </p>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <img class="img-thumbnail" src="landerpage/uploads/bg2.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
		</div></section><!-- End About Section -->
        <!-- Start Feature Section -->
        <section id="contact">
    <div class="page-ttl">
        <div class="layer-stretch">
            <div class="page-ttl-container">
                <h1>Contact Us</h1>
                <p><a href="#">Home</a> &#8594; <span>Contact Us</span></p>
            </div>
        </div>
    </div><!-- End Page Title Section -->
    <!-- Start Contact Detail Section -->
    <div id="contact-page" class="layer-stretch">
        <div class="layer-wrapper">
            <div class="row text-center">
                <div class="col-md-6 col-lg-3 contact-info-block">
                    <div class="contact-info-inner">
                        <i class="fa fa-plus-square-o"></i>
                        <span>APPOINTMENT</span>
                        <p class="paragraph-medium paragraph-black">0824-2429729</p>
                        <p>appointment@yourdomain.com </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 contact-info-block">
                    <div class="contact-info-inner">
                        <i class="fa fa-phone"></i>
                        <span>Call Us</span>
                        <p class="paragraph-medium paragraph-black">0824-2429729</p>
                        <p>0824-2440263</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 contact-info-block">
                    <div class="contact-info-inner">
                        <i class="fa fa-envelope"></i>
                        <span>Email Us</span>
                        <p class="paragraph-medium paragraph-black">alphacare.ohms@gmail.com</p>
                        <p>jnhjp1964@gmail.com</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 contact-info-block">
                    <div class="contact-info-inner">
                        <i class="fa fa-map-marker"></i>
                        <span>Location</span>
                        <p class="paragraph-medium paragraph-black" style="font-size: 15.2px;">K S Rao Road, Hampankatta, </p>
						<p>Mangalore,Karnataka,575003.</p>
                        <p class="paragraph-medium paragraph-black"></p>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Contact Detail Section -->
    <!-- Start Request Form Section -->
    <div id="contact-form" class="layer-stretch">
        <div class="layer-wrapper">
            <div class="layer-ttl"><h3>Make a Request</h3></div>
            <div class="contact-form row text-center">
                <div class="col-md-4">
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input-icon">
                        <i class="fa fa-user-o"></i>
                        <input id="contact-name" class="mdl-textfield__input" type="text" pattern="[A-Z,a-z, ]*">
                        <label class="mdl-textfield__label" for="contact-name">Your Name</label>
                        <span class="mdl-textfield__error">Please Enter Valid Name!</span>
                    </div>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input-icon">
                        <i class="fa fa-envelope-o"></i>
                        <input class="mdl-textfield__input" type="text" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" id="contact-email">
                        <label class="mdl-textfield__label" for="contact-email">Your Email</label>
                        <span class="mdl-textfield__error">Please Enter Valid Email!</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input-icon">
                        <i class="fa fa-phone"></i>
                        <input class="mdl-textfield__input" type="text" pattern="[0-9]*" id="contact-mobile">
                        <label class="mdl-textfield__label" for="contact-mobile">Your Mobile Number</label>
                        <span class="mdl-textfield__error">Please Enter Valid Mobile Number!</span>
                    </div>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input-icon">
                        <i class="fa fa-rocket"></i>
                        <input class="mdl-textfield__input" type="text" id="contact-subject">
                        <label class="mdl-textfield__label" for="contact-subject">Your Subject</label>
                        <span class="mdl-textfield__error">Please Enter Subject Related to Your Query!</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input-icon">
                        <i class="fa fa-paper-plane"></i>
                        <textarea class="mdl-textfield__input" id="contact-message"></textarea>
                        <label class="mdl-textfield__label" for="contact-message">Your Request</label>
                        <span class="mdl-textfield__error">Please Enter Your Query!</span>
                    </div>
                </div>
                <div class="col-md-12 contact-error">

                </div>
                <div class="col-md-12">
                    <div class="form-submit">
                        <button class="mdl-button mdl-js-button mdl-button--colored mdl-js-ripple-effect mdl-button--raised button button-primary contact-submit">Submit your Query</button>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Request Form Section -->
    <!-- Start Google Map Section -->
    <section id="locate">
		<div class="map-responsive">
    <p><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3889.55156092947!2d74.84058681442266!3d12.872215090921188!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ba35a4ef3933627%3A0x4d9551c24243bd80!2sJayashree+Nursing+Home!5e0!3m2!1sen!2sin!4v1518450988670" width="1340" height="600" frameborder="0" style="border:0" allowfullscreen></iframe></p></div></section>
   <!-- End Google Map Section -->
    </section>
    <!-- Start Emergency Section -->
    <div id="emergency">
        <div class="layer-stretch">
            <div class="layer-wrapper">
                <div class="layer-ttl">
                    <h3>On Emergency</h3>
                </div>
                <div class="layer-container">
                    <div class="paragraph-medium paragraph-black">
                        At Jayashree , emergency physicians are highly educated and are assisted by well trained nurses to meet demanding challenges.
                    </div>
                    <div class="emergency-number">Call : 0824-2440263 / 2429729</div>
                </div>
            </div>
        </div>
			</div><!-- End Emergency Section -->
    <!-- Start Make an Appointment Modal -->
    <div id="appointment" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h5 class="modal-title">Make An Appointment</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
					<form method="post">
						
                    <div class="row">
						
                        <div class="col-md-6">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input-icon">
                                <i class="fa fa-user-o"></i>
                                <input class="mdl-textfield__input" type="text" pattern="[A-Z,a-z, ]*" id="appointment-name" name="apointname">
                                <label class="mdl-textfield__label" for="appointment-name">Name</label>
                                <span class="mdl-textfield__error">Please Enter Valid Name!</span>
                            </div>
                        </div>
						<div class="col-md-6">
                            <div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label form-input-icon">
                                <i class="fa fa-user-o"></i>
                                <select class="mdl-selectfield__select" name="apointsex" id="appointment-sex">
                                    <option value="" hidden>&nbsp;</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                   
                                </select>
                                <label class="mdl-selectfield__label" for="appointment-sex">Choose Sex</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input-icon">
                                <i class="fa fa-envelope-o"></i>
                                <input name="apointemail" class="mdl-textfield__input" type="text" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" id="appointment-email">
                                <label class="mdl-textfield__label" for="appointment-email">Email</label>
                                <span class="mdl-textfield__error">Please Enter Valid Email!</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input-icon">
                                <i class="fa fa-phone"></i>
                                <input name="apointpno" class="mdl-textfield__input" type="text" pattern="[0-9]*" id="appointment-mobile">
                                <label class="mdl-textfield__label" for="appointment-mobile">Mobile Number</label>
                                <span class="mdl-textfield__error">Please Enter Valid Mobile Number!</span>
                            </div>
                        </div>
						<div class="col-md-6">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input-icon">
                                <i class="fa fa-calendar-o"></i>
                                <input name="apointdob" class="mdl-textfield__input" type="text" id="appointment-dob" onfocus="(this.type='date')" onblur="(this.type='text')">
                                <label class="mdl-textfield__label" for="appointment-dob">Date of birth</label>
                                <span class="mdl-textfield__error">Please Enter Valid Date Number!</span>
                            </div>
                        </div>
                        
                        
                        <div class="col-md-6">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input-icon">
                                <i class="fa fa-calendar-o"></i>
                                <input name="apointdoa" class="mdl-textfield__input" type="text" id="appointment-date" onfocus="(this.type='date')" onblur="(this.type='text')">
                                <label class="mdl-textfield__label" for="appointment-date">Date of appointment</label>
								<span id="usernameLoading"><img src="plugins/images/busy.gif" alt="Ajax Indicator" height="15" width="15" /></span>
								<span id="usernameResult" style="color: #E40003"></span>
                            </div>
							
                        </div>
						<div class="col-md-12">
                            <div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label form-input-icon">
                                <i class="fa fa-user-md"></i>
                                <select name="apointdoc" class="mdl-selectfield__select" id="appointment-doctor">
                                    <option value="" hidden>&nbsp;</option>
									<?php 
									while($getdocfetch=mysqli_fetch_assoc($getdocinforesult))
									{
									?>
                                    <option value="<?php echo $getdocfetch['doc_id'] ?>"><?php echo $getdocfetch['fname'].' '.$getdocfetch['lname'].' , '.$getdocfetch['specialist']; ?></option>
                                    <?php } ?>
                                </select>
                                <label class="mdl-selectfield__label" for="appointment-doctor">Choose Doctor</label>
                            </div>
                        </div>
						
                    </div>
					<div class="text-center pt-4 form-submit">
						 <button name="apointsubmit" type="submit" class="mdl-button mdl-js-button mdl-button--colored mdl-js-ripple-effect mdl-button--raised button button-primary button-lg ">Submit</button> </a>
                    </div>
				</form>
                    
                </div>
            </div>
        </div>
    </div><!-- End Make an Appointment Modal -->
    <!-- Start Login Modal -->
    <div id="loginpopup" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h5 class="modal-title">Login Now</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body text-center">
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input-icon">
                        <i class="fa fa-envelope-o"></i>
                        <input class="mdl-textfield__input" type="text" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" id="loginpopup-email">
                        <label class="mdl-textfield__label" for="loginpopup-email">Email <em> *</em></label>
                        <span class="mdl-textfield__error">Please Enter Valid Email!</span>
                    </div>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input-icon">
                        <i class="fa fa-key"></i>
                        <input class="mdl-textfield__input" type="password" id="loginpopup-password">
                        <label class="mdl-textfield__label" for="loginpopup-password">Password <em> *</em></label>
                        <span class="mdl-textfield__error">Please Enter Valid Password!</span>
                        <div class="forgot-pass">Forgot Password?</div>
                    </div>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input-icon form-bot-check">
                        <i class="fa fa-question"></i>
                        <input class="mdl-textfield__input" type="number" id="loginpopup-bot">
                        <label class="mdl-textfield__label" for="loginpopup-bot">What is 7 plus 1 = <em>* </em></label>
                        <span class="mdl-textfield__error">Please Enter Correct Value!</span>
                    </div>
                    <div class="form-submit">
                        <button class="mdl-button mdl-js-button mdl-js-ripple-effect button button-primary">Login Now</button>
                    </div>
                    <div class="or-using">Or Using</div>
                    <div class="social-login">
                        <a href="#" class="social-facebook"><i class="fa fa-facebook"></i>Facebook</a>
                        <a href="#" class="social-google"><i class="fa fa-google"></i>Google</a>
                    </div>
                    <div class="login-link">
                        <span class="paragraph-small">Don't have an account?</span>
                        <a href="#" class="">Register as New User</a>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Login Modal -->
    <!-- Start Register Modal -->
    <div id="registerpopup" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h5 class="modal-title">Register as New User</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body text-center">
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input-icon">
                        <i class="fa fa-user-o"></i>
                        <input class="mdl-textfield__input" type="text" pattern="[A-Z,a-z, ]*" id="registerpopup-name">
                        <label class="mdl-textfield__label" for="registerpopup-name">Name <em> *</em></label>
                        <span class="mdl-textfield__error">Please Enter Valid Name!</span>
                    </div>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input-icon">
                        <i class="fa fa-envelope-o"></i>
                        <input class="mdl-textfield__input" type="text" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" id="registerpopup-email">
                        <label class="mdl-textfield__label" for="registerpopup-email">Email <em> *</em></label>
                        <span class="mdl-textfield__error">Please Enter Valid Email!</span>
                    </div>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input-icon">
                        <i class="fa fa-key"></i>
                        <input class="mdl-textfield__input" type="password" id="registerpopup-password">
                        <label class="mdl-textfield__label" for="registerpopup-password">Password <em> *</em></label>
                        <span class="mdl-textfield__error">Please Enter Valid Password(Min 6 Character)!</span>
                    </div>
                    <div class="login-condition">By clicking Creat Account you agree to our <a href="#">terms &#38; condition</a></div>
                    <div class="form-submit">
                        <button class="mdl-button mdl-js-button mdl-js-ripple-effect button button-primary">Create Account</button>
                    </div>
                    <div class="or-using">Or Using</div>
                    <div class="social-login">
                        <a href="#" class="social-facebook"><i class="fa fa-facebook"></i>Facebook</a>
                        <a href="#" class="social-google"><i class="fa fa-google"></i>Google</a>
                    </div>
                    <div class="login-link">
                        <span class="paragraph-small">Already have an account?</span>
                        <a href="#" class="">Login Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Register Modal -->

    <!-- Start Doctor Section -->

    <!-- Start Blog Section -->

    <!-- Start Testimonial Section -->

    <!-- Start Login Modal -->
    <div id="loginpopup1" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h5 class="modal-title">Login Now</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body text-center">
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input-icon">
                        <i class="fa fa-envelope-o"></i>
                        <input class="mdl-textfield__input" type="text" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" id="loginpopup-email1">
                        <label class="mdl-textfield__label" for="loginpopup-email">Email <em> *</em></label>
                        <span class="mdl-textfield__error">Please Enter Valid Email!</span>
                    </div>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input-icon">
                        <i class="fa fa-key"></i>
                        <input class="mdl-textfield__input" type="password" id="loginpopup-password1">
                        <label class="mdl-textfield__label" for="loginpopup-password">Password <em> *</em></label>
                        <span class="mdl-textfield__error">Please Enter Valid Password!</span>
                        <div class="forgot-pass">Forgot Password?</div>
                    </div>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input-icon form-bot-check">
                        <i class="fa fa-question"></i>
                        <input class="mdl-textfield__input" type="number" id="loginpopup-bot1">
                        <label class="mdl-textfield__label" for="loginpopup-bot">What is 7 plus 1 = <em>* </em></label>
                        <span class="mdl-textfield__error">Please Enter Correct Value!</span>
                    </div>
                    <div class="form-submit">
                        <button class="mdl-button mdl-js-button mdl-js-ripple-effect button button-primary">Login Now</button>
                    </div>
                    <div class="or-using">Or Using</div>
                    <div class="social-login">
                        <a href="#" class="social-facebook"><i class="fa fa-facebook"></i>Facebook</a>
                        <a href="#" class="social-google"><i class="fa fa-google"></i>Google</a>
                    </div>
                    <div class="login-link">
                        <span class="paragraph-small">Don't have an account?</span>
                        <a href="#" class="">Register as New User</a>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Login Modal -->
    <!-- Start Register Modal -->
    <div id="registerpopup2" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h5 class="modal-title">Register as New User</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body text-center">
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input-icon">
                        <i class="fa fa-user-o"></i>
                        <input class="mdl-textfield__input" type="text" pattern="[A-Z,a-z, ]*" id="registerpopup-name2">
                        <label class="mdl-textfield__label" for="registerpopup-name">Name <em> *</em></label>
                        <span class="mdl-textfield__error">Please Enter Valid Name!</span>
                    </div>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input-icon">
                        <i class="fa fa-envelope-o"></i>
                        <input class="mdl-textfield__input" type="text" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" id="registerpopup-email2">
                        <label class="mdl-textfield__label" for="registerpopup-email">Email <em> *</em></label>
                        <span class="mdl-textfield__error">Please Enter Valid Email!</span>
                    </div>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input-icon">
                        <i class="fa fa-key"></i>
                        <input class="mdl-textfield__input" type="password" id="registerpopup-password1">
                        <label class="mdl-textfield__label" for="registerpopup-password">Password <em> *</em></label>
                        <span class="mdl-textfield__error">Please Enter Valid Password(Min 6 Character)!</span>
                    </div>
                    <div class="login-condition">By clicking Creat Account you agree to our <a href="#">terms &#38; condition</a></div>
                    <div class="form-submit">
                        <button class="mdl-button mdl-js-button mdl-js-ripple-effect button button-primary">Create Account</button>
                    </div>
                    <div class="or-using">Or Using</div>
                    <div class="social-login">
                        <a href="#" class="social-facebook"><i class="fa fa-facebook"></i>Facebook</a>
                        <a href="#" class="social-google"><i class="fa fa-google"></i>Google</a>
                    </div>
                    <div class="login-link">
                        <span class="paragraph-small">Already have an account?</span>
                        <a href="#" class="">Login Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Register Modal -->
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
                <div class="col-md-6 footer-block">
                    <div class="footer-ttl"><p>Basic Info</p></div>
                    <div class="footer-container footer-a">
                        <div class="tbl">
                            <div class="tbl-row">
                                <div class="tbl-cell"><i class="fa fa-map-marker"></i></div>
                                <div class="tbl-cell">
                                    <p class="paragraph-medium paragraph-white">
                                        Jayashree Hopital<br />
                                        KS Rao, Hampankatta<br />
                                        Mangaluru, INDIA 575-003.
                                    </p>
                                </div>
                            </div>
                            <div class="tbl-row">
                                <div class="tbl-cell"><i class="fa fa-phone"></i></div>
                                <div class="tbl-cell">
                                    <p class="paragraph-medium paragraph-white">0824-24262523</p>
                                </div>
                            </div>
                            <div class="tbl-row">
                                <div class="tbl-cell"><i class="fa fa-envelope"></i></div>
                                <div class="tbl-cell">
                                    <p class="paragraph-medium paragraph-white">jayashreehospital.com</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 footer-block">
                    <div class="footer-ttl"><p>Quick Links</p></div>
                    <div class="footer-container footer-b">
                        <div class="tbl">
                            <div class="tbl-row">

                                <ul class="tbl-cell">
                                    <li><a href="login/">Login</a></li>
                                    <li><a href="check-appointment.php">My Appointment</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-md-4 footer-block">
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
                    </div>-->
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
    <!-- begin layerslider script-->
    <script src="landerpage/js/greensock.js"></script>
    <script src="landerpage/js/layerslider.transitions.js"></script>
    <script src="landerpage/js/layerslider.kreaturamedia.jquery.js"></script>
 <script>
$(function() {
  // Smooth Scrolling
  $('a[href*="#"]:not([href="#"])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html, body').animate({
          scrollTop: target.offset().top
        }, 1000);
        return false;
      }
    }
  });
});
</script>

<script>
$('.menu a').on('click', function(){
  if (window.matchMedia('(max-width: 1007px)').matches) {
		$(".menu").css('display','none');
    $('body').css('overflow','visible');
		}
        //
    });
</script>
	
	
	
    <script type="text/javascript">

        // Running the code when the document is ready
        $(document).ready(function(){

            // Calling LayerSlider on the target element
            $('#layerslider2').layerSlider({

                autoStart: true,
				pauseOnHover: true,
				navPrevNext: false,
				navButtons: true,
				thumbnailNavigation: false,
			    autoPlayVideos: false,
				firstLayer: 1,
				skin: 'borderlesslight',
				skinsPath: 'landerpage/layerslider/skins/'

				// Please make sure that you didn't forget to add a comma to the line endings
				// except the last line!
            });
        });

    </script>
    <!-- end layerslider script-->
    <!--Custom JavaScript for Klinik Template-->
    <script src="landerpage/js/custom.js"></script>
     <script>function initMap() {
  var uluru = {lat: 12.8722015, lng: 74.8427185};
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom:15,
    center: uluru
  });
  var marker = new google.maps.Marker({
    position: uluru,
    map: map
  });
}
</script>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-93901876-1', 'auto');
        ga('send', 'pageview');
    </script>

</body>
</html>
