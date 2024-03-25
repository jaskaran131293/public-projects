
     <!--REGISTER-SECTION-START-->

        <div class="register-section">
            <div class="container">
                <div class="row form-margin">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-border-left form-inner-padding">
					<div class="form-section-register">
					<div class="form-section-register-inner">
					<div class="form-haeding-text"><h1>Register </h1></div> 
						<?php if ($this->session->flashdata('success_msg')) { ?>
							<div class="alert alert-danger"> <?= $this->session->flashdata('success_msg') ?> </div>
						<?php } ?>
						  <form action="<?php echo base_url(); ?>register"  class="seller_register" id="seller_register" method="post">
							<div class="form-group row">
							  <label for="inputEmail3" class="col-sm-3 col-form-label">Full name*</label>
							  <div class="col-sm-9">
								<input type="text" name="full_name" class="form-control" id="full_name" placeholder="" >
							  </div>
							</div>
							<div class="form-group row">
							  <label for="inputEmail3" class="col-sm-3 col-form-label">Email address*</label>
							  <div class="col-sm-9">
								<input type="email"   name="email"  class="form-control" id="email" placeholder=""  >
							  </div>
							</div>
							<div class="form-group row">
							  <label for="inputEmail3" class="col-sm-3 col-form-label">Password*</label>
							  <div class="col-sm-9">
								<input type="password" name="password"  class="form-control" id="password" placeholder=""  >
							  </div>
							</div>
							<div class="form-group row">
							  <label for="inputEmail3" class="col-sm-3 col-form-label">phone number</label>
							  <div class="col-sm-9">
								<input type="number"  name="phone_number"   class="form-control" id="phone_number" placeholder="">
							  </div>
							</div>
							<div class="form-group row">
							  <label for="inputEmail3" class="col-sm-3 col-form-label">Country*</label>
							  <div class="col-sm-9">
								<input type="text" name="country" class="form-control" id="country" placeholder=""  >
							  </div>
							</div>
							<div class="form-group row">
							<label for="inputEmail3" class="col-sm-3 col-form-label"></label>
							  <div class="col-sm-9">
								<input type="hidden" name="register_seller" value="register_seller" class="form-control" id="register_seller" />
								<button type="submit" class="btn btn-primary">Sign Up</button>
							  </div>
							</div>
						  </form>
							 </div>
					   </div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-inner-padding">
					 <div class="form-section-login">
					<div class="form-haeding-text"><h1>Log in </h1></div>
						<?php 	 
						 if ($this->session->flashdata('suc_msg')) { ?>
							<div class="alert alert-danger"> <?= $this->session->flashdata('suc_msg') ?> </div>
						<?php } ?>
					   <form action="<?php echo base_url(); ?>login"  class="seller_login" id="seller_login" method="post">
							<div class="form-group row">
							  <label for="inputEmail3" class="col-sm-3 col-form-label">Login</label>
							  <div class="col-sm-9">
								<input type="email" name="email" class="form-control" id="inputEmail3" placeholder="">
							  </div>
							</div>
							<div class="form-group row">
							  <label for="inputEmail3" class="col-sm-3 col-form-label">Password</label>
							  <div class="col-sm-9">
								<input type="password" name="password" class="form-control" id="inputEmail3" placeholder="">
							  </div>
							</div>
							<div class="form-group row">
							<label for="inputEmail3" class="col-sm-3 col-form-label"></label>
							  <div class="col-sm-9">
								<input type="hidden" name="login_seller" value="login_seller" class="form-control" id="login_seller" />
								<button type="submit" class="btn btn-primary">Sign In</button>
							  </div>
							</div>
						  </form>
					  </div>
					</div>
                </div>
            </div>
        </div>
   
