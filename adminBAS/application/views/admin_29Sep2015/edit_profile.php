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
        <div class="col-md-12" style="min-height:1300px;">
          <div class="panel">
            <div class="panel-heading">
              <div class="panel-title"> <span class="glyphicon glyphicon-book"></span> Edit User Profile</div>
            </div>
            <div class="panel-body alerts-panel">
              <form class="cmxform" id="edit_admin_profile_frm" method="POST" action="<?php echo SURL?>admin/manage-user/edit-profile-process" enctype="multipart/form-data">
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
                        <label for="first_name">First Name*</label>
                        <input id="first_name" name="first_name" type="text" class="form-control" placeholder="Type your First Name" value="<?php echo stripslashes($admin_profile_data['first_name']) ?>" required readonly/>
                      </div>
                      <div class="form-group">
                        <label for="last_name">Last Name*</label>
                        <input id="last_name" name="last_name" type="text" class="form-control" placeholder="Type your Last Name" value="<?php echo stripslashes($admin_profile_data['last_name']) ?>" required readonly/>
                      </div>

                      <div class="form-group">
                        <label for="display_name">Display Name*</label>
                        <input id="display_name" name="display_name" type="text" class="form-control" placeholder="Type your Display Name" value="<?php echo stripslashes($admin_profile_data['display_name']) ?>" required/>
                      </div>
                      <div class="form-group">
                        <label for="username">Username</label>
                        <input id="username" name="username" type="text" class="form-control" placeholder="Type Your Username"  value="<?php echo stripslashes($admin_profile_data['username']) ?>"  readonly />
	                      <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> Username will be used to login into the CMS Panel.</span>
                      </div>
                      
                      <div class="form-group">
                        <label for="email_address">Email Address</label>
                        <input id="email_address" name="email_address" type="text" class="form-control" placeholder="Type Your Email Address" value="<?php echo stripslashes($admin_profile_data['email_address']) ?>"/>
                      </div>

                    <div class="row form-group">
                        <div class="col-md-5">
                            <div class="form-group">
                            
                         <?php 
                            if($admin_profile_data['avatar_image'] !=''){
                        ?>
                      
                            <img src="<?php echo USER_FOLDER.'/'.$admin_profile_data['id'].'/'.stripslashes($admin_profile_data['avatar_image'])?>">
                   
                        <?php }//end if?><br><br><br>

                                <label for="upload">Upload Avatar Image</label>
                                <input type="file" id="avatar_image" name="avatar_image">
                                <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> 
                                    - Allowed Extensions: jpg, jpeg, gif, tiff, png <br>
                                </span>
                                <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> 
                                    - Max Upload Size: 2MB
                                </span>
                            </div>
                        </div>
                        <?php 
						
                            if($admin_profile_data['profile_image'] !=''){
                        ?>
                        <div class="col-md-4">
                            <img src="<?php echo USER_FOLDER.'/'.$admin_profile_data['id'].'/'.stripslashes($admin_profile_data['profile_image'])?>">
                        </div>
                        <?php }//end if?>
                        
                         
                    </div>                                          
                  </div>
                  
                    <div class="form-group" align="right" style="margin-right:17px">
                        <input class="submit btn btn-blue" type="submit" name="upd_profile_sbt" id="upd_profile_sbt" value="Update Profile" />
                    </div>
                </div>
                
              </form>
            </div>            
          </div>
        </div>
      </div>
    </div>
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
        $("#edit_admin_profile_frm").validate({
            rules: {
				first_name : 'required',
				last_name : 'required',
                display_name: "required",
				username: {
					required: true,
					minlength: 5,
					 maxlength: 20
				},
				email_address: {
					required: false,
					email: true
				},
				prof_image: {
					required: false,
					extension: "jpg|jpeg|gif|tiff|png"
				}				
				
            },
            messages: {
                first_name: "This field is required.",
				last_name : "This field is required.",
                display_name: "This field is required.",
				prof_image : "Please select valid image for your profile (Use: jpg, jpeg, gif, tiff, png)",
				username: {
					required: "This field is required.",
					minlength: "Your Username must consist of at least 5 characters",
					maxlength: "Your Username cannot me more than 20 characters"
				},
				email_address: "Enter your valid email address",
            }
        });
    
    });
    </script>

</body>
</html>
