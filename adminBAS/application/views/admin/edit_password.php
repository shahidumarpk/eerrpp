<!DOCTYPE html>
<html>
<head>

<!-- Meta, title, CSS, favicons, etc. -->
<meta charset="utf-8">
<title><?php echo $meta_title ?></title>
<meta name="keywords" content="<?php echo $meta_keywords ?>" />
<meta name="description" content="<?php echo $meta_description ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php echo $INC_header_script_top; ?>
</head>

<body>
<!-- Start: Header -->
<header class="navbar navbar-fixed-top"> <?php echo $INC_top_header; ?> </header>
<!-- End: Header --> 
<!-- Start: Main -->
<div id="main"> 
  <!-- Start: Sidebar --> 
  <?php echo $INC_left_nav_panel; ?> 
  <!-- End: Sidebar --> 
  <!-- Start: Content -->
  <section id="content"> <?php echo $INC_breadcrum?>
    <div class="container">
      <div class="row">
        <div class="col-md-12" style=" min-height:1300px;">
          <div class="panel">
            <div class="panel-heading">
              <div class="panel-title"> <span class="glyphicon glyphicon-book"></span> Edit User Password</div>
            </div>
            <div class="panel-body alerts-panel">
              <form class="cmxform" id="edit_admin_pass_frm" method="POST" action="<?php echo SURL?>admin/manage-user/edit-password-process">
                <div class="tab-content border-none padding-none">
                  <div id="cms_main_contents" class="tab-pane active">
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
                      <div class="form-group">
                        <label for="new_password">New Password*</label>
                        <input id="new_password" name="new_password" type="password" class="form-control" placeholder="Enter New Password" value="" required/>
                      </div>
                      <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input id="confirm_password" name="confirm_password" type="password" class="form-control" placeholder="Re-enter Your new Password" value="<?php echo stripslashes($admin_profile_data['admin_profile_arr']['username']) ?>" required />
                      </div>
                      
                  </div>
                  
                    <div class="form-group" align="right" style="margin-right:17px">
                        <input class="submit btn btn-blue" type="submit" name="upd_password_sbt" id="upd_password_sbt" value="Update Password" />
                    </div>
                </div>
                
              </form>
            </div>            
          </div>
        </div>
      </div>
    </div>
     <div class="row" style="min-height:250px;">&nbsp;</div>
  </section>
  <!-- End: Content --> 
  
</div>
<!-- End: Main --> 
<!-- Start: Footer -->
<footer> <?php echo $INC_footer;?> </footer>
<!-- End: Footer --> 
<?php echo $INC_header_script_footer;?>
    <script type="text/javascript">
      jQuery(document).ready(function() {
    
      // validate signup form on keyup and submit
        $("#edit_admin_pass_frm").validate({
            rules: {
				new_password: {
					required: true,
					minlength: 5
				},
				confirm_password: {
					required: true,
					equalTo: "#new_password"
				},

            },
            messages: {
				password: {
					required: "Password cannot be empty.",
					minlength: "Your password must be at least 5 characters long"
				},
				confirm_password: {
					required: "Confirm Password cannot be empty.",
					equalTo: "Your new password must match with confirm password"
				}
            }
        });
    
    });
    </script>

</body>
</html>
