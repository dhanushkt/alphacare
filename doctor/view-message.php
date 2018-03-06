<?php
include '../login/accesscontroldoc.php';
require('connect.php');
if(isset($_SESSION['dusername']))
{
	$ausername=$_SESSION['dusername'];
}
else if(isset($_SESSION['ausername']))
{
	$ausername=$_SESSION['ausername'];
}

if(isset($_GET['id']))
{
$msgid=$_GET['id'];
$updatequery="UPDATE messages SET user_read='1' WHERE msg_id='$msgid'";
$updateresult=mysqli_query($connection,$updatequery);

$getmsg="SELECT * FROM messages WHERE msg_id='$msgid'";
$resultmsg=mysqli_query($connection,$getmsg);
$fetchmsg=mysqli_fetch_assoc($resultmsg);
	
$staffuname=$fetchmsg['from_name'];
$getstaffinfo="SELECT fname,lname,email,gender FROM staffs WHERE username='$staffuname'";
$resultstaffinfo=mysqli_query($connection,$getstaffinfo);
$fetchstaffinfo=mysqli_fetch_assoc($resultstaffinfo);
}

$getunread="SELECT * FROM messages WHERE (to_name='$ausername') AND (user_read='0')";
$getunreadresult=mysqli_query($connection,$getunread);
$countunread=mysqli_num_rows($getunreadresult);

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
	<!-- Dropzone css -->
    <link href="../plugins/bower_components/dropzone-master/dist/dropzone.css" rel="stylesheet" type="text/css" />
	<!-- wysihtml5 CSS -->
    <link rel="stylesheet" href="../plugins/bower_components/html5-editor/bootstrap-wysihtml5.css" />
	<link href="../plugins/bower_components/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
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
                        <h4 class="page-title">Compose Message</h4>
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
                <div class="row">
					
                    <!-- Left sidebar -->
                    <div class="col-md-12">
						<?php if(isset($smsg)) { ?>
									<div class="alert alert-success alert-dismissable text-uppercase font-bold">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
										 <?php echo $smsg; ?>
									</div> 
							<?php } ?>
                        <div class="white-box">
                            <div class="row">
                                <div class="col-lg-2 col-md-3  col-sm-4 col-xs-12 inbox-panel">
                                    <div> <a href="compose-message.php" class="btn btn-custom btn-block waves-effect waves-light">Compose</a>
                                        <div class="list-group mail-list m-t-20">
											<a href="inbox.php" class="list-group-item">Inbox <span class="label label-rouded label-success pull-right"><?php echo $countunread; ?></span></a>
										
											<a href="sent-messages.php" class="list-group-item">Sent Messages</a> 
										</div>
                                        
                                    </div>
                                </div>
                                <div class="col-lg-10 col-md-9 col-sm-8 col-xs-12 mail_listing">
                                    <div class="media m-b-30 p-t-20">
                                        <h4 class="font-bold m-t-0"><span class="label label-rouded label-info pull-right">Subject</span><?php echo $fetchmsg['msg_subject'] ?></h4>
                                        <hr>
                                        <a class="pull-left" href="#"> <?php if($fetchstaffinfo["gender"]=='male') { ?> <img class="media-object thumb-sm img-circle" src="../plugins/images/users/staff-male.png" alt=""><?php } else { ?> <img class="media-object thumb-sm img-circle" src="../plugins/images/users/staff-female.png" alt="">  <?php } ?></a>
                                        <div class="media-body"> <span class="media-meta pull-right"><?php $date=$fetchmsg['timestamp']; echo date('h:i a M d', strtotime($date)); ?></span>
                                            <h4 class="text-danger m-0"><?php echo $fetchstaffinfo['fname'].' '.$fetchstaffinfo['lname']; ?></h4>
                                            <small class="text-muted">From: <?php echo $fetchstaffinfo['email']; ?></small> </div>
                                    </div>
									<p><blockquote> <?php echo $fetchmsg['msg_body']; ?> </blockquote></p>
                                    <hr>
                                    <div class="b-all p-20">
                                        <p class="p-b-20">click here to <a href="replay-message.php?name=<?php echo $fetchmsg['from_name'] ?>">Reply</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--/row -->

                
                <!-- /.row -->
                
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
	<script src="../plugins/bower_components/html5-editor/wysihtml5-0.3.0.js"></script>
    <script src="../plugins/bower_components/html5-editor/bootstrap-wysihtml5.js"></script>
    <script src="../plugins/bower_components/dropzone-master/dist/dropzone.js"></script>
    <script>
    $(document).ready(function() {

        $('.textarea_editor').wysihtml5();

    });
    </script>
	<script src="../plugins/bower_components/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
    
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
