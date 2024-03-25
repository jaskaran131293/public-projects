        
<?php if(isset($_REQUEST['update_profile'])) {$update_profile = $_REQUEST['update_profile'];}else{$update_profile='';}?>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2>Profile</h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url(); ?>SellerDashboard">Dashboard</a>
                    </li>
                    <li class="active">
                        <strong>Profile</strong>
                    </li>
                </ol>
            </div>
            <div class="col-lg-2">
            <h2><?php 
                    if ($update_profile != 'edit' || $update_profile == '') {
                        echo '<a class="btn btn-info" href="'.base_url().'SellerDashboard/SellerProfile?update_profile=edit">Edit Profile</a>';
                    }
                ?></h2>
            </div>
        </div>

        <div class="wrapper wrapper-content">
            <div class="row animated fadeInRight">
                <div class="col-md-12">
                    <div class="ibox float-e-margins">
                        <?php if ($this->session->flashdata('suc_msg')) { ?>
                            <div class="alert alert-danger"> <?= $this->session->flashdata('suc_msg') ?> </div>
                        <?php } ?>
                        <?php if(isset($error)){ ?>
                               <div class="alert alert-danger"> <?= $error ?> </div>
                            <?php } ?>
                        

                        <?php if($update_profile == 'edit'){ ?>
                            <div class="ibox-title">
                                <h5>Profile Detail</h5>
                            </div>
                            <div>
                            <form action="<?php echo base_url()?>SellerDashboard/UpdateSellerProfile" method="post" id="UpdateProfileForm" class="form-horizontal" enctype="multipart/form-data">
                                <div class="ibox-content ">
                                    <div class="form-group"><label class="col-sm-2 control-label">Name</label>
                                        <div class="col-sm-10"><input type="text" class="form-control" name="seller_full_name" id="seller_full_name" value="<?php if($get_seller_user_data[0]['seller_full_name']){echo $get_seller_user_data[0]['seller_full_name'];}?>" required></div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-2 control-label">Email</label>
                                        <div class="col-sm-10"><input type="email" class="form-control" name="seller_email" id="seller_email" value="<?php if($get_seller_user_data[0]['seller_email']){echo $get_seller_user_data[0]['seller_email'];}?>" required></div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-2 control-label">Phone</label>
                                        <div class="col-sm-10"><input type="number" class="form-control" name="seller_phone" id="seller_phone" value="<?php if($get_seller_user_data[0]['seller_phone']){echo $get_seller_user_data[0]['seller_phone'];}?>" required></div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-2 control-label">Country</label>
                                        <div class="col-sm-10"><input type="text" class="form-control" name="seller_country" id="seller_country" value="<?php if($get_seller_user_data[0]['seller_country']){echo $get_seller_user_data[0]['seller_country'];}?>" required></div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-2 control-label">Old Password</label>
                                        <div class="col-sm-10"><input type="text" class="form-control" name="seller_password" id="seller_password" value="<?php if($get_seller_user_data[0]['seller_password']){echo $get_seller_user_data[0]['seller_password'];}?>" disabled></div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-2 control-label">New Password</label>
                                        <div class="col-sm-10"><input type="text" class="form-control" name="seller_password_new" id="seller_password_new"  ></div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-2 control-label">Profile Picture</label>
                                        <div class="col-sm-10"><input type="file" class="form-control" name="seller_image_new" ></div>
                                    </div>
                                    
                                    <?php if(!empty($get_seller_user_data[0]['seller_image'])){ ?>
                                    <input type="hidden" class="form-control" name="seller_image" value="<?php echo $get_seller_user_data[0]['seller_image']; ?>"> 
                                    <div class="form-group"><label class="col-sm-2 control-label"></label>
                                        <div class="col-sm-10"><img style="width: 150px; margin-top: 10px;" alt="image" class="img-responsive" src="<?php echo base_url(); ?>uploads/<?php echo $get_seller_user_data[0]['seller_image']; ?>"></div>
                                    </div>
                                    <?php } ?>
                                    <div class="form-group row"><label class="col-sm-2 control-label"></label>
                                      <div class="col-sm-10">
                                        <input type="hidden" class="form-control" name="seller_id" value="<?php echo $get_seller_user_data[0]['seller_id']; ?>">
                                        <input type="hidden" class="form-control" name="seller_password" value="<?php echo $get_seller_user_data[0]['seller_password']; ?>">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                      </div>
                                    </div>
                                </div>
                            </form>
                        <?php }else{ ?>
                            <div class="ibox-title">
                                <h1><strong>Profile: </strong><?php if($get_seller_user_data[0]['seller_full_name']){echo $get_seller_user_data[0]['seller_full_name'];}?></h1>
                            </div>
                            <div>
                            <div class="ibox-content border-left-right">
                            <?php if($get_seller_user_data[0]['seller_image']){
                                echo '<img style="width:250px;" alt="profile-image" class="img-responsive" src="'.base_url().'uploads/'.$get_seller_user_data[0]['seller_image'].'">';
                            }else{
                                echo '<img alt="profile-image" class="img-responsive" src="'.base_url().'assets/images/profile-dummy.png">';
                            }
                            ?>
                            </div>
                            <div class="ibox-content ">
                                <h3><i class="fa fa-envelope" aria-hidden="true"></i> <?php if($get_seller_user_data[0]['seller_email']){echo $get_seller_user_data[0]['seller_email'];}?></h3>
                                <h3><i class="fa fa-phone" aria-hidden="true"></i> <?php if($get_seller_user_data[0]['seller_phone']){echo $get_seller_user_data[0]['seller_phone'];}?></h3>
                                <h3><i class="fa fa-user" aria-hidden="true"></i> <?php if($get_seller_user_data[0]['seller_status']){echo 'Status Active'; }else{ echo 'Status Inactive'; }?></h3>
                                <h3><i class="fa fa-map-marker"></i> <?php if($get_seller_user_data[0]['seller_country']){echo $get_seller_user_data[0]['seller_country'];}?></h3>
                            </div>
                        <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>