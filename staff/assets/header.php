<!-- Preloader -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>
    <div id="wrapper">
        <!-- Top Navigation -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header">
                <!-- Toggle icon for mobile view -->
                <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i class="ti-menu"></i></a>
                <!-- Logo -->
                <div class="top-left-part">
                    <a class="logo" href="index.html">
                        <!-- Logo icon image, you can use font-icon also -->
                        <b><img src="../plugins/images/eliteadmin-logo.png" alt="home" /></b>
                        <!-- Logo text image you can use text also -->
                        <span class="hidden-xs"><img src="../plugins/images/eliteadmin-text.png" alt="home" /></span>
                    </a>
                </div>
                <!-- /Logo -->
                <!-- Search input and Toggle icon -->
                <ul class="nav navbar-top-links navbar-left hidden-xs">
                    <li><a href="javascript:void(0)" class="open-close hidden-xs waves-effect waves-light"><i class="icon-arrow-left-circle ti-menu"></i></a></li>
                    <!--<li>
                        <form role="search" class="app-search hidden-xs">
                            <input type="text" placeholder="Search..." class="form-control">
                            <a href=""><i class="fa fa-search"></i></a>
                        </form>
                    </li>-->
                </ul>
                <!-- This is the message dropdown -->
                <ul class="nav navbar-top-links navbar-right pull-right">
					<?php $countmsgquery="SELECT * FROM messages WHERE (user_read='0') AND (to_name='$ausername')";
					$resultcountmsg=mysqli_query($connection,$countmsgquery);
					$numbercountmsg=mysqli_fetch_assoc($resultcountmsg);
					if($numbercountmsg>=1)
					{ ?>
				   <li>	<a class="waves-effect waves-light" href="inbox.php"><i class="icon-envelope"></i>
          			<div class="notify"><span class="heartbit"></span><span class="point"></span></div>
					</a> </li> <?php } ?>
                    <!---PNB --->
                    <!-- .Task dropdown -->
                    
                    <!-- /.Task dropdown -->
                    <!-- .user dropdown -->
                    <li class="dropdown">
                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"> 
							<?php
							$queryimg="SELECT gender,fname,lname FROM staffs WHERE username='$ausername'";
							$resultimg = mysqli_query($connection, $queryimg);
							$rowimg = mysqli_fetch_assoc($resultimg);
							if($rowimg["gender"]=='male'){ ?> <img src="../plugins/images/users/staff-male.png" width="36" class="img-circle"><?php } else { ?><img src="../plugins/images/users/staff-female.png" width="36" class="img-circle"> <?php } ?><b class="hidden-xs"><?php echo $rowimg['fname'].' '.$rowimg['lname']; ?></b> </a>
                        <ul class="dropdown-menu dropdown-user scale-up">
                            <li><a href="my-profile.php"><i class="ti-user"></i> My Profile</a></li>
                            <!--<li><a href="#"><i class="ti-wallet"></i> My Balance</a></li>-->
                            <li><a href="inbox.php"><i class="ti-email"></i> Inbox</a></li>
                            <li role="separator" class="divider"></li>
							<li><a href="logout.php"><i class="fa fa-power-off"></i> Logout</a></li>
                            <!--<li role="separator" class="divider"></li>-->
                           <!-- <li><a href="#"><i class="ti-settings"></i> Account Setting</a></li>-->
                        </ul>
                        <!-- /.user dropdown-user -->
                    </li>
                    <!-- /.user dropdown -->
                    <!-- /.PNB removed mega menu-->
                    <!--<li class="right-side-toggle"> <a class="waves-effect waves-light" href="javascript:void(0)"><i class="ti-settings"></i></a></li>-->
                    <!-- /.dropdown -->
                </ul>
            </div>
            <!-- /.navbar-header -->
            <!-- /.navbar-top-links -->
            <!-- /.navbar-static-side -->
        </nav>
        <!-- End Top Navigation -->