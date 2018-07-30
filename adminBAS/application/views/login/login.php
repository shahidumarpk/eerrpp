<!DOCTYPE html>
<html>
<head>

<!-- Meta, title, CSS, favicons, etc. -->
<meta charset="utf-8">
<title><?php echo $meta_title ?></title>
<meta name="keywords" content="<?php echo $meta_keywords ?>" />
<meta name="description" content="<?php echo $meta_description ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php echo $INC_header_script_top ?>
</head>

<body class="screenlock-page">
<div id="main">
  <div class="container">
    <div class="row">
      <div id="page-logo"> <img src="<?php echo IMG?>logo-login.png" class="img-responsive" alt="logo"> </div>
    </div>
    <div class="row">
      <div class="panel" style="min-height:364px;">
        <div class="panel-heading">
          <div class="panel-title"> <span class="glyphicon glyphicon-lock"></span> Login
          
        
          
           </div>
        </div>
        <?php
			if($this->session->flashdata('err_message')){
		?>
        <div class="alert alert-danger"><?php echo $this->session->flashdata('err_message'); ?></div>
        <?php
			}//end if($this->session->flashdata('err_message'))
			
			if($this->session->flashdata('ok_message')){
		?>
        <div class="alert alert-success alert-dismissable"><?php echo $this->session->flashdata('ok_message'); ?></div>
        <?php 
				}//if($this->session->flashdata('ok_message'))
		?>
        <form class="cmxform" id="adm_loginfrm" name="adm_loginfrm" method="post" action="<?php echo base_url() ?>login/login/login_process" enctype="multipart/form-data">
          <div class="panel-body" style="margin-bottom:0">
            <div class="form-group margin-right-sm">
              <div class="row">
                <div class="col-md-12">
                  <div class="input-group margin-bottom"> <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span> </span>
                    <input class="form-control" type="text" name="username" id="username" placeholder="Enter your Username">
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="input-group margin-bottom"> <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span> </span>
                    <input type="password" name="password" id="password" class="form-control product" autocomplete="off" placeholder="Enter your Password">
                  </div>
                </div>
                <?php if($show_captcha){ ?>
                <div class="col-md-12"> <?php echo $captcha_image?> </div>
                <div class="col-md-12">
                  <div class="input-group margin-bottom"> <span class="input-group-addon"><span class="glyphicon glyphicon-qrcode"></span> </span>
                    <input type="text" name="captcha_code" id="captcha_code" class="form-control product" autocomplete="off" placeholder="Type the Security Code">
                  </div>
                </div>
                 <?php }else{
					 ?>
                     <div class="col-md-12">
                      <span class="label btn-success pull-right">Registered IP</span>
                       <div class="alert alert-success alert-dismissable">Initiating VIP Protocol . .. <br>
You are trusted resource no captcha for you :) <br>  Have a good day!
</div>
                       
				
                 </div>	 
				 <?php }
					  ?>
              </div>
            </div>
            <!--<div class="login-alert">
              <div class="alert alert-warning">Please read our <b>Terms of Use</b> before logging in.</div>
            </div>--> 
          </div>
          <div class="panel-footer"> <span class="panel-title-sm pull-left" style="padding-top: 7px;"><a href="javascript:;" id="forgot_pass_link"> Forgot Your Password?</a></span>
            <div class="form-group margin-bottom-none">
              <input class="btn btn-primary pull-right" type="submit" value="Unlock" />
              <div class="clearfix"></div>
            </div>
          </div>
        </form>
        <!-- START: Forgot Password Form -->
        <div id="fgotpass_panel" style="display:none">
          <form class="cmxform" id="adm_fgotpass_frm" name="adm_fgotpass_frm" method="post" action="<?php echo base_url() ?>login/login/forgot_password_process" enctype="multipart/form-data">
            <div class="panel-body" style="margin-bottom:0">
              <div class="form-group margin-right-sm">
                <div class="row">
                  <div class="col-md-12">
                    <div class="input-group margin-bottom"> <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span> </span>
                      <input class="form-control" type="text" name="email_address" id="email_address" placeholder="Enter your Email Address">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="panel-footer"> <span class="panel-title-sm pull-left" style="padding-top: 7px;">&nbsp;</span>
              <div class="form-group margin-bottom-none">
                <input class="btn btn-primary pull-right" type="submit" value="Get Password" />
                <div class="clearfix"></div>
              </div>
            </div>
          </form>
        </div>
        <!-- END: Forgot Password Form --> 
      </div>
      
     <!-- <a href="https://play.google.com/store/apps/details?id=bir.home.adminerp" target="_blank" > <div align="center" style="margin-top:30px;"><img src="<?php echo IMG?>erp-comingsoon-login.png" class="img-responsive"></div></a> -->
      
    </div>
  </div>
</div>
<?php echo $INC_header_script_footer; ?> 
<script type="text/javascript">
      jQuery(document).ready(function() {
    
      // validate signup form on keyup and submit
        $("#adm_loginfrm").validate({
            rules: {
                username: "required",
                password: "required",
                
            },
            messages: {
                username: "Enter your Username.",
                password: "Enter your Password.",
            }
        });
		
		//Forgot Password
		$("#forgot_pass_link").click(function() {
			$("#fgotpass_panel").toggle('slow');
		});
		
		$("#adm_fgotpass_frm").validate({

            rules: {
				email_address: {
					required: true,
					email: true
				},
            },
            messages: {
                email_address: "Enter your valid email address.",
            }
        });
    
    });
    </script>
</body>
</html>
