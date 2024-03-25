
     <!--REGISTER-SECTION-START-->

        <div class="register-section">
            <div class="container">
                <div class="row form-margin">
					<div class="col-lg-6  col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-12 form-inner-padding">
						<div class="form-section-login">
							<div class="form-haeding-text"><h1>Admin </h1></div>
							<?php if ($this->session->flashdata('suc_msg')) { ?>
							<div class="alert alert-danger"> <?= $this->session->flashdata('suc_msg') ?> </div>
							<?php } ?>
					   		<form action="<?php echo base_url(); ?>admin"  class="seller_login" id="seller_login" method="post">
							<div class="form-group row">
							<label for="inputEmail3" class="col-sm-3 col-form-label">Login</label>
							<div class="col-sm-9">
								<input type="text" name="username" class="form-control" id="inputEmail3" placeholder="">
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

