		<?php if(isset($_REQUEST['update_profile'])) {$update_profile = $_REQUEST['update_profile'];}else{$update_profile='';}
		
		?>


		<div class="row wrapper border-bottom white-bg page-heading">
					<div class="col-lg-10">
						
						<?php if(isset($get_seller_user_data)){
							if(empty($get_seller_user_data[0]['seller_paypal_address']) && empty($get_seller_user_data[0]['seller_card_details'])){
								echo '<h2>Add Payment Method</h2>';
							}else{
								echo "<h2>Payment Methods</h2>";
							}
						}else{ 
							echo '<h2>Edit Payment Method</h2>';
						}?>                  
					</div>
                	<div class="col-lg-2">
                	 <h2><?php 
		                    if ($update_profile != 'edit' || $update_profile == '') {
		                        echo '<a class="btn btn-info" href="'.base_url().'SellerDashboard/UpdateSellerPayment?update_profile=edit">Add Method</a>';
		                    }
		                ?></h2>
                	</div>
       </div>
		<div class="wrapper wrapper-content animated fadeInRight">
					<div class="row">
						<div class="col-lg-12">
							<?php if(isset($suc_msg)){ ?>
							   <div class="alert alert-danger"> <?= $suc_msg ?> </div>
							<?php } ?>
							<div class="ibox float-e-margins">
								

								<?php if($update_profile == 'edit'){ ?>
								<div class="ibox-content">
										<?php echo '<form action="'.base_url().'SellerDashboard/UpdateSellerPayment" method="post" class="form-horizontal" enctype="multipart/form-data">';
										?> 									
										<h5>Account Details</h5>

										<div class="form-group"><label class="col-sm-2 control-label">Paypal Address</label>
											<div class="col-sm-10"><input type="email" class="form-control paypal_details" name="paypal_address" placeholder="paypal@gmail.com" value="<?php if(isset($get_seller_user_data[0]['seller_paypal_address'])){echo $get_seller_user_data[0]['seller_paypal_address'];} ?>" > <span class="help-block m-b-none">Add Payapal address.</span>
                                    		</div>
                                		</div>
										
										<div class="hr-line-dashed"></div>
										<?php 
											if(isset($get_seller_user_data[0]['seller_card_details']) && !empty($get_seller_user_data[0]['seller_card_details'])){
												$unserial_val_ex = explode(", ",$get_seller_user_data[0]['seller_card_details']);
												$unserial_date_ex = explode("-",$unserial_val_ex[0]);
												//echo '<pre>'; print_r($unserial_date_ex); echo '</pre>';
											}
										?>
									<div class="card_details">
										<div class="form-group"><label class="col-sm-2 control-label">Card Number</label>
											<div class="col-sm-10">
												<input type="number" maxlength="16" class="form-control" name="card_number" placeholder="4242424242424242" value="<?php if(isset($unserial_val_ex[0])){echo $unserial_val_ex[0];} ?>" >
                                    		</div>
                                		</div>
										<div class="form-group"><label class="col-sm-2 control-label">Card Holder Name</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" name="card_holdername" placeholder="Card Holder Name" value="<?php if(isset($unserial_val_ex[1])){echo $unserial_val_ex[1];} ?>" >
											</div>
										</div>
										<div class="form-group"><label class="col-sm-2 control-label">Card Name</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" name="card_name" placeholder="Visa" value="<?php if(isset($unserial_val_ex[2])){echo $unserial_val_ex[2];} ?>" >
											</div>
										</div>
										<div class="form-group"><label class="col-sm-2 control-label">Expires On</label>
											<div class="col-sm-10"> 
													<select id="selectMonth" name="selectMonth" style="width:auto;" class="form-control selectWidth" >
														<?php for ($i = 1; $i <= 12; $i++){ ?>
														<option <?php 
															   	if(isset($unserial_date_ex[0])){
																	if($unserial_date_ex[0] == $i){
																		echo 'selected="selected"';
																	}
															   	} ?>
															><?php echo $i; ?></option>
														<?php } ?>
													</select>
													<select id="selectYear" name="selectYear" style="width:auto;" class="form-control selectWidth" >
														<?php for ($i = 2018; $i <= 2050; $i++){ ?>
														<option <?php 
															   	if(isset($unserial_date_ex[1])){
																	if($unserial_date_ex[1] == $i){
																		echo 'selected="selected"';
																	}
															   	} ?>
															><?php echo $i; ?></option>
														<?php } ?>
													</select>
                                    		</div>
                                		</div>
										<div class="form-group"><label class="col-sm-2 control-label">Security Code / CVV</label>
											<div class="col-sm-10">
												<input type="password" class="form-control" name="card_cvv" placeholder="123" value="<?php if(isset($unserial_val_ex[4])){echo $unserial_val_ex[4];} ?>" >
											</div>
										</div>
									</div>	
                                
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
										
										<input type="hidden" name="seller_id" value="<?php echo $get_seller_user_data[0]['seller_id']; ?>">
                                        <button class="btn btn-primary" type="submit">Save changes</button>
                                    </div>
                                </div>
                            </form>

                            <?php }else{ ?>
                            	

                            	<?php if(!empty($get_seller_user_data[0]['seller_paypal_address']) || !empty($get_seller_user_data[0]['seller_card_details'])){ ?>
								<div class="ibox-title">
	                                <h1><strong>Profile: </strong><?php if($get_seller_user_data[0]['seller_full_name']){echo $get_seller_user_data[0]['seller_full_name'];}?></h1>
	                            </div>
	                            <div>
	                            <div class="ibox-content ">
	                            <?php } ?>


	                            
	                                <h3>
		                                <?php 
											if(!empty($get_seller_user_data[0]['seller_paypal_address']) && empty($get_seller_user_data[0]['seller_card_details'])){
												echo '<span style="display:block;font-weight:bold;">Paypal Address</span>';
												echo $get_seller_user_data[0]['seller_paypal_address'].'<br/><br/>';
												echo '<a class="btn btn-info" href="'.base_url().'SellerDashboard/UpdateSellerPayment?update=delete_paypal&seller_id='.$get_seller_user_data[0]['seller_id'].'">Remove</a>';
											}elseif(!empty($get_seller_user_data[0]['seller_card_details']) && empty($get_seller_user_data[0]['seller_paypal_address'])){
												$explde_data = explode(", ",$get_seller_user_data[0]['seller_card_details']);
												echo '<span style="display:block;font-weight:bold;">Card Details</span>';
												echo substr_replace($explde_data[0],"xxxx-xxxx-xxxx-",0,12).'<br/>';
												echo $explde_data[1].'<br/>';
												echo $explde_data[2].'<br/>';
												echo $explde_data[3].'<br/>';
												echo $explde_data[4].'<br/>';
												echo '<a class="btn btn-info" href="'.base_url().'SellerDashboard/UpdateSellerPayment?update=delete_card&seller_id='.$get_seller_user_data[0]['seller_id'].'">Remove</a>';
											}elseif( (!empty($get_seller_user_data[0]['seller_paypal_address'])) && (!empty($get_seller_user_data[0]['seller_card_details'])) ){
												echo '<span style="display:block;font-weight:bold;">Paypal Address</span>';
												echo $get_seller_user_data[0]['seller_paypal_address'].'<br/><br/><a class="btn btn-info" href="'.base_url().'SellerDashboard/UpdateSellerPayment?update=delete_paypal&seller_id='.$get_seller_user_data[0]['seller_id'].'">Remove</a><br/><br/><hr/>';
												$explde_data = explode(", ",$get_seller_user_data[0]['seller_card_details']);
												echo '<span style="display:block;font-weight:bold;">Card Details</span>';
												echo substr_replace($explde_data[0],"xxxx-xxxx-xxxx-",0,12).'<br/>';
												echo $explde_data[1].'<br/>';
												echo $explde_data[2].'<br/>';
												echo $explde_data[3].'<br/>';
												echo $explde_data[4].'<br/><br/>';
												echo '<a class="btn btn-info" href="'.base_url().'SellerDashboard/UpdateSellerPayment?update=delete_card&seller_id='.$get_seller_user_data[0]['seller_id'].'">Remove</a>';
											} 
										?>
								
									</h3>
	                            </div>
	                        <?php } ?>


                        </div>
                    </div>
                </div>
            </div>
        </div>

