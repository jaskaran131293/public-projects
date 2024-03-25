<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | Data Tables</title>

    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/font-awesome.css" rel="stylesheet">

    <!-- Data Tables -->
    <link href="<?php echo base_url(); ?>assets/css/dataTables.bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/dataTables.responsive.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/dataTables.tableTools.min.css" rel="stylesheet">

    <link href="<?php echo base_url(); ?>assets/css/animate.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/d-style.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/css/datepicker3.css" rel="stylesheet">

</head>
<body>
  
    <div id="wrapper">
     <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
                            <?php 
                            if(isset($session_image) && !empty($session_image)){
                                echo '<img width="48px" alt="profile-image" class="img-circle" src="'.base_url().'uploads/'.$session_image.'" />';
                            }else{
                                echo '<img width="48px" alt="profile-image" class="img-circle" src="'.base_url().'assets/images/profile_small.jpg" />';
                            }
                            ?>
                             </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php echo $session_data; ?></strong>
                             </span> <span class="text-muted text-xs block">Seller <b class="caret"></b></span> </span> </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a href="<?php echo base_url(); ?>SellerDashboard/SellerProfile">Profile</a></li>
                           
                        </ul>
                    </div>
                    <div class="logo-element">
                        IN+
                    </div>
                </li>
               
                <li class="active">
                    <a href="#"><i class="fa fa-edit"></i> <span class="nav-label">Plan</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li class="active"><a href="<?php echo base_url(); ?>SellerDashboard">Your Plans</a></li>
                        <li class=""><a href="<?php echo base_url(); ?>SellerDashboard/AddSellerPlan">Add New Plan</a></li>
                    </ul>
                </li>
               
                <li>
						<li class=""><a href="<?php echo base_url(); ?>SellerDashboard/UpdateSellerPayment">Payment Method</a></li>
                </li>
               
             </ul>

        </div>
    </nav>

         <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <span class="m-r-sm text-muted welcome-message">Welcome  <?php echo $session_data; ?>.</span>
                </li>
               <li>
                    <a href="<?php echo base_url(); ?>SellerDashboard/logout">
                        <i class="fa fa-sign-out"></i> Log out
                    </a>
                </li>
             </ul>

        </nav>
        </div>