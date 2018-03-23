<?php
require('../admin/connect.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="AlphaCare Online Hospital Management System">
    <meta name="author" content="Dhanush KT, Nishanth Bhat">
    <meta name="author" content="">
    <?php include '../admin/assets/csslink.php'; ?>
	<!-- Wizard CSS -->
    <link href="../plugins/bower_components/jquery-wizard-master/css/wizard.css" rel="stylesheet">
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>
    <section id="wrapper" class="login-register">
		<!--<div id="page-wrapper">-->
	
        <div class="paddingup" style="padding-top: 100px">
					
			<div class="row">
				
                    <div class="col-md-6 offset-md-3">
                        <div class="white-box">
                            <h3 class="box-title m-b-0">Set-up Admin Account</h3>
                            <p class="text-muted m-b-30 font-13"> Enter the details to create a new admin account to access AlphaCare</p>
                            <div id="exampleValidator" class="wizard">
                               <ul class="row wizard-steps text-center">
								   <li class="col-md-4"> <h4><span><i class="ti-user"></i></span>Username</h4></li>
									<li class="col-md-4"><h4><span><i class="ti-email"></i></span>Email ID</h4></li>
								   <li class="col-md-4"><h4><span><i class="ti-key"></i></span>Password</h4></li>
								</ul>
                                <form id="validation" class="form-horizontal">
                                    <div class="wizard-content">
                                        <div class="wizard-pane active" role="tabpanel">
                                            <div class="form-group">
                                                <label class="col-xs-3 control-label">Username</label>
                                                <div class="col-xs-5">
                                                    <input id="adminuname" type="text" class="form-control" name="username" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="wizard-pane" role="tabpanel">
                                            <div class="form-group">
                                                <label class="col-xs-3 control-label">Email address</label>
                                                <div class="col-xs-5">
                                                    <input id="adminemail" type="text" class="form-control" name="email" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="wizard-pane" role="tabpanel">
                                            <div class="form-group">
                                                <label class="col-xs-3 control-label">Password</label>
                                                <div class="col-xs-5">
                                                    <input id="adminpass" type="password" class="form-control" name="password" />
                                                </div>
												<label class="col-xs-3 control-label">Confirm Password</label>
												<div class="col-xs-5">
                                                    <input type="password" class="form-control" name="confirmpassword" />
                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
					
        </div>
			
		<!--</div>-->
    </section>
    <?php include'../admin/assets/jslink.php'; ?>
	<!-- Form Wizard JavaScript -->
    <script src="../plugins/bower_components/jquery-wizard-master/dist/jquery-wizard.min.js"></script>
    <!-- FormValidation -->
    <link rel="stylesheet" href="../plugins/bower_components/jquery-wizard-master/libs/formvalidation/formValidation.min.css">
    <!-- FormValidation plugin and the class supports validating Bootstrap form -->
    <script src="../plugins/bower_components/jquery-wizard-master/libs/formvalidation/formValidation.min.js"></script>
    <script src="../plugins/bower_components/jquery-wizard-master/libs/formvalidation/bootstrap.min.js"></script>
	
	<script src="../plugins/bower_components/sweetalert/sweetalert.min.js"></script>
    <script type="text/javascript">
    (function() {
        $('#exampleValidator').wizard({
            onInit: function() {
                $('#validation').formValidation({
                    framework: 'bootstrap',
                    fields: {
                        username: {
                            validators: {
                                notEmpty: {
                                    message: 'Username is required'
                                },
                                stringLength: {
                                    min: 6,
                                    max: 30,
                                    message: 'Username must be more than 6 and less than 30 characters long'
                                },
                                regexp: {
                                    regexp: /^[a-zA-Z0-9_\.]+$/,
                                    message: 'The username can only consist of alphabetical, number, dot and underscore'
                                }
                            }
                        },
                        email: {
                            validators: {
                                notEmpty: {
                                    message: 'Email address is required'
                                },
                                emailAddress: {
                                    message: 'The input is not a valid email address'
                                }
                            }
                        },
                        password: {
                            validators: {
                                notEmpty: {
                                    message: 'Password is required'
                                },
								stringLength: {
                                    min: 6,
                                    message: 'Password must be more than 6 characters long'
                                },
                                different: {
                                    field: 'username',
                                    message: 'Password cannot be the same as username'
                                }
                            }
                        },
						confirmpassword: {
                            validators: {
                                notEmpty: {
                                    message: 'Password is required'
                                },
                                identical: {
                                    field: 'password',
                                    message: 'Password doesnt match'
                                }
                            }
                        },
						
                    }
                });
            },
            validator: function() {
                var fv = $('#validation').data('formValidation');

                var $this = $(this);

                // Validate the container
                fv.validateContainer($this);

                var isValidStep = fv.isValidContainer($this);
                if (isValidStep === false || isValidStep === null) {
                    return false;
                }

                return true;
            },
            onFinish: function() {
				
				var username=document.getElementById('adminuname').value; 
				var email=document.getElementById('adminemail').value;
				var password=document.getElementById('adminpass').value;
	
				$.ajax({
						url: 'setup-admin-acc.php',
						type: 'POST',
						data: { uname: username,
								email: email,
							  	pass: password },
						success: function(){
							$('#validation').submit();
                			swal("Admin Account Created!", "Redirecting to login page in 4 seconds.", "success");
							window.setTimeout(function(){
									window.location.href = "../login/";
								}, 4000);
						}
					});
				
                
            }
        });
		
    })();
    </script>
	<script>
$(window).load(function() {
    
    var viewportWidth = $(window).width();
    if (viewportWidth < 750) {
            $(".paddingup").css('padding-top','0px');
    }
    
    $(window).resize(function () {
    
        if (viewportWidth < 750) {
            $(".paddingup").css('padding-top','0px');
        }
    });
});
</script>

</body>

</html>
