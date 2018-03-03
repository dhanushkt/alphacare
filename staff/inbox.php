<?php
include '../login/accesscontrolstaff.php';
require('connect.php');
if(isset($_SESSION['susername']))
{
	$ausername=$_SESSION['susername'];
}
else if(isset($_SESSION['ausername']))
{
	$ausername=$_SESSION['ausername'];
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
                        <h4 class="page-title">Inbox</h4>
                    </div>
                    <!-- /.page title -->
                    <!-- .breadcrumb -->
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                       <a href="../index.html" target="_blank" class="btn btn-info pull-right m-l-20 btn-rounded btn-outline hidden-xs hidden-sm waves-effect waves-light">Home</a>
                       <?php echo breadcrumbs(); ?>
                    </div>
                    <!-- /.breadcrumb -->
                </div>
                <!--DNS added Dashboard content-->
                <!--row -->
                <div class="row">
                    <!-- Left sidebar -->
                    <div class="col-md-12">
                        <div class="white-box">
                            <!-- row -->
                            <div class="row">
                                <div class="col-lg-2 col-md-3  col-sm-12 col-xs-12 inbox-panel">
                                    <div> <a href="compose-message.php" class="btn btn-custom btn-block waves-effect waves-light">Compose</a>
                                        <div class="list-group mail-list m-t-20">
											<a href="inbox.php" class="list-group-item active">Inbox <span class="label label-rouded label-success pull-right"><?php echo $countunread; ?></span></a>
										
											<a href="sent-messages.php" class="list-group-item">Sent Messages</a> 
										</div>
                                        
                                    </div>
                                </div>
                                <div class="col-lg-10 col-md-9 col-sm-12 col-xs-12 mail_listing">
                                    <div class="inbox-center table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                     <th width="30">
                                                        <div class="checkbox m-t-0 m-b-0 ">
                                                            <!--<input id="checkbox0" type="checkbox" class="checkbox-toggle" value="check all">
                                                            <label for="checkbox0"></label>-->
                                                        </div>
                                                    </th> 
                                                    <th colspan="4">
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-primary dropdown-toggle waves-effect waves-light m-r-5" data-toggle="dropdown" aria-expanded="false"> Filter <b class="caret"></b> </button>
                                                            <ul class="dropdown-menu" role="menu">
                                                                <li><a href="#fakelink">Read</a></li>
                                                                <li><a href="#fakelink">Unread</a></li>
                                                                <li class="divider"></li>
                                                                <li><a href="#fakelink">Separated link</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="btn-group">
                                                            <button type="button" onClick="window.location.reload()" class="btn btn-default waves-effect waves-light" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-refresh"></i> </button>
                                                        </div>
														<div class="btn-group">
                                                            <button type="button" class="btn btn-default waves-effect waves-light" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-trash-o"></i> </button>
                                                        </div>
                                                    </th>
                                                    <th class="hidden-xs" width="100">
                                                        <div class="btn-group pull-right">
                                                            <button type="button" class="btn btn-default waves-effect"><i class="fa fa-chevron-left"></i></button>
                                                            <button type="button" class="btn btn-default waves-effect"><i class="fa fa-chevron-right"></i></button>
                                                        </div>
                                                    </th>
                                                </tr>
                                            </thead>
											
                                            <tbody>
												<?php 
											$fetchmsg="SELECT * FROM messages WHERE to_name='$ausername' ORDER BY msg_id DESC";
											$fetchresult=mysqli_query($connection, $fetchmsg);
											while($fetchrow=mysqli_fetch_assoc($fetchresult))
											{
											?>
                                                <tr class="<?php if($fetchrow['user_read']==0){ echo 'unread'; } ?> " onclick="window.location='view-message.php?id=<?php echo $fetchrow["msg_id"] ?>';">
													
												<?php
												$fetchdocusername=$fetchrow['from_name'];
												$docfullname="SELECT fname,lname from doctors WHERE username='$fetchdocusername'";
												$docfullnameresult=mysqli_query($connection,$docfullname);
												$getdocfullname=mysqli_fetch_assoc($docfullnameresult);
												?>
                                                    <td>
                                                        <div class="checkbox m-t-0 m-b-0">
                                                            <input type="checkbox">
                                                            <label for="checkbox0"></label>
                                                        </div>
                                                    </td>
													<td class="hidden-xs"><i class="fa fa-circle-thin"></i></td>
													<td><a href="#">Dr. <?php echo $getdocfullname['fname'].' '.$getdocfullname['lname']; ?></a></td>
                                                    <td class="max-texts"><a href="#"><span class="label label-info m-r-10">Subject :</span><?php echo $fetchrow["msg_subject"]; ?></a></td>
                                                    <td class="hidden-xs"><i class="fa <?php if($fetchrow['user_read']==0){ echo 'fa-envelope';} else { echo 'fa-envelope-o'; } ?>"></i></td>
                                                    <td class="text-right"> <?php $date=$fetchrow['timestamp']; echo date('h:i a M d', strtotime($date)); ?> </td>
                                                </tr>
												<?php } ?>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- <div class="row">
                                        <div class="col-xs-7 m-t-20"> Showing 1 - 15 of 200 </div>
                                        <div class="col-xs-5 m-t-20">
                                            <div class="btn-group pull-right">
                                                <button type="button" class="btn btn-default waves-effect"><i class="fa fa-chevron-left"></i></button>
                                                <button type="button" class="btn btn-default waves-effect"><i class="fa fa-chevron-right"></i></button>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                            <!-- /.row -->
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
