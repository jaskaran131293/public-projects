		<div class="row wrapper border-bottom white-bg page-heading">
					<div class="col-lg-10">
						
						<?php if(isset($Get_seller_list_by_id)){
							echo '<h2>Edit Plan</h2>';
						}else{ 
							echo '<h2>Upload Plan</h2>';
						}?>                  
					</div>
                	<div class="col-lg-2">
                	</div>
       </div>
		<div class="wrapper wrapper-content animated fadeInRight">
					<div class="row">
						<div class="col-lg-12">
							<?php if(isset($error)){ ?>
							   <div class="alert alert-danger"> <?= $error ?> </div>
							<?php } ?>
							<div class="ibox float-e-margins">
								<div class="ibox-title">
									<h5>Please use the form below to upload the your plan</h5>
								</div>
								<div class="ibox-content">
										<?php 
											if(isset($Get_seller_list_by_id)){
												echo '<form action="'.base_url().'SellerDashboard/UpdateSellerData" method="post" class="form-horizontal" enctype="multipart/form-data">';
											}else{ 
												echo '<form action="'.base_url().'SellerDashboard/AddSellerData" method="post" class="form-horizontal" enctype="multipart/form-data">';
											}
										?> 
										<div class="form-group"><label class="col-sm-2 control-label">Plan Name</label>
											<div class="col-sm-10"><input type="text" class="form-control" name="seller_plan_name" id="seller_plan_name" value="<?php if(isset($Get_seller_list_by_id[0]->plan_name)){ echo $Get_seller_list_by_id[0]->plan_name; } ?>" required></div>
										</div>
										<div class="form-group"><label class="col-sm-2 control-label">Plan Summary</label>
											<div class="col-sm-10"><textarea class="form-control" name="plan_summary"  style="width:100%;" required><?php if(isset($Get_seller_list_by_id[0]->plan_summary)){ echo htmlspecialchars($Get_seller_list_by_id[0]->plan_summary); } ?></textarea></div>
										</div>
										<div class="form-group"><label class="col-sm-2 control-label">Plan Image</label>
											<div class="col-sm-10">
												<input type="file" name="plan_image" id="plan_image" <?php if(isset($Get_seller_list_by_id[0]->plan_image)){ }else{echo 'required';} ?>/>
												<?php if(isset($Get_seller_list_by_id[0]->plan_image)){ 
													echo '<img style="width: 171px; margin-top: 10px;" src="'.base_url("uploads/". $Get_seller_list_by_id[0]->plan_image).'" />';
												} ?>
											</div>
											<?php if(isset($Get_seller_list_by_id[0]->plan_image)){
												echo '<input type="hidden" value="'.$Get_seller_list_by_id[0]->plan_image.'" name="hiden_plan_image">';	
											} ?>
										</div>
										
									
										<div class="form-group">
											
											<label class="col-sm-2 control-label">Plan Details</label>
												<div class="col-sm-10 input_fields_container"> 
											<?php 
												if(isset($Get_seller_list_by_id[0]->plan_details)){
													$unserial_data = unserialize(base64_decode($Get_seller_list_by_id[0]->plan_details));
													//echo '<pre>'; print_r($unserial_data); echo '</pre>';
													$x=1;
													foreach( $unserial_data as $unserial_val ){
														$unserial_val_ex = explode(", ",$unserial_val);
														echo '<div class="form-group col-md-12 date_show" id="data_'.$x.'">
																	<div class="input-group date" style="width:25%;display: inline-table;">
																		<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
																		<input type="text" class="form-control"  name="plan_date[]" value="'.$unserial_val_ex[0].'" required>
																	</div>
																	<div class="input-group" style="width:25%;display: inline-table;">
																		<input type="text" class="form-control" name="plan_place[]" placeholder="Add Place"  value="'.$unserial_val_ex[1].'" required>
																	</div>
																	<div class="input-group" style="width:25%;display: inline-table;">
																		<input type="text" class="form-control" name="plan_website[]"  value="'.$unserial_val_ex[2].'"  placeholder="Add Website" required>
																	</div>';

																	if($x>1){
																	echo '<a href="#" class="remove_field" style="margin-left:10px;">Remove</a>';
																	};
																		
														echo '</div>													   
														';
														$x++;
													}
												}else{
													echo '<div class="form-group col-md-12 date_show" id="data_1">
																	<div class="input-group date" style="width:25%;display: inline-table;">
																		<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
																		<input type="text" class="form-control"  name="plan_date[]" required>
																	</div>
																	<div class="input-group" style="width:25%;display: inline-table;">
																		<input type="text" class="form-control" name="plan_place[]" placeholder="Add Place"  required>
																	</div>
																	<div class="input-group" style="width:25%;display: inline-table;">
																		<input type="text" class="form-control" name="plan_website[]" placeholder="Add Website" required>
																	</div>
														</div>													   
														';
												}
											?>
											</div>
										</div>
											
										<div class="form-group"><label class="col-sm-2 control-label"></label>
											<div class="col-sm-10"> 
												<div class="input-group" style="width:15%;display: inline-table;">
													<input type="button" name="Add More" value="Add More" class="btn btn-sm btn-primary add_more_button"/>
												</div>
											</div>
										</div>	
										
										
										<div class="ibox-title">
											<h5>Account Details</h5>

										</div>
										<div class="form-group"><label class="col-sm-2 control-label">Paypal Address</label>
											<div class="col-sm-10"><input type="email" class="form-control paypal_details" name="paypal_address" placeholder="paypal@gmail.com" value="<?php if(isset($Get_seller_list_by_id[0]->paypal_address)){echo $Get_seller_list_by_id[0]->paypal_address;} ?>" required> <span class="help-block m-b-none">Add Payapal address.</span>
                                    		</div>
                                		</div>
										
										<div class="hr-line-dashed"></div>
										<?php 
											if(isset($Get_seller_list_by_id[0]->card_detail)){
												$unserial_val_ex = explode(", ",$Get_seller_list_by_id[0]->card_detail);
												$unserial_date_ex = explode("-",$unserial_val_ex[3]);
												//echo '<pre>'; print_r($unserial_date_ex); echo '</pre>';
											}
										?>
									<div class="card_details">
										<div class="form-group"><label class="col-sm-2 control-label">Card Number</label>
											<div class="col-sm-10">
												<input type="number" maxlength="16" class="form-control" name="card_number" placeholder="4242424242424242" value="<?php if(isset($unserial_val_ex[0])){echo $unserial_val_ex[0];} ?>" required>
                                    		</div>
                                		</div>
										<div class="form-group"><label class="col-sm-2 control-label">Card Holder Name</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" name="card_holdername" placeholder="Card Holder Name" value="<?php if(isset($unserial_val_ex[1])){echo $unserial_val_ex[1];} ?>" required>
											</div>
										</div>
										<div class="form-group"><label class="col-sm-2 control-label">Card Name</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" name="card_name" placeholder="Visa" value="<?php if(isset($unserial_val_ex[2])){echo $unserial_val_ex[2];} ?>" required>
											</div>
										</div>
										<div class="form-group"><label class="col-sm-2 control-label">Expires On</label>
											<div class="col-sm-10"> 
													<select id="selectMonth" name="selectMonth" style="width:auto;" class="form-control selectWidth" required>
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
													<select id="selectYear" name="selectYear" style="width:auto;" class="form-control selectWidth" required>
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
												<input type="password" class="form-control" name="card_cvv" placeholder="123" value="<?php if(isset($unserial_val_ex[4])){echo $unserial_val_ex[4];} ?>" required>
											</div>
										</div>
									</div>	
                                
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
										<?php $us_data = $this->session->userdata('logged_in');
										if(isset($Get_seller_list_by_id[0]->seller_plan_id)){
											echo '<input type="hidden" name="seller_plan_id" value="'.$Get_seller_list_by_id[0]->seller_plan_id.'">';
										}
										?>
										<input type="hidden" name="seller_id" value="<?php echo $us_data->seller_id; ?>">
                                        <button class="btn btn-white" type="submit">Cancel</button>
                                        <button class="btn btn-primary" type="submit">Save changes</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    