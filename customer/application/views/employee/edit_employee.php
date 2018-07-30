<?php 
$session_post_data = $this->session->userdata('add-user-data');
?>
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
        <div class="col-md-12">
          <div class="panel">
            <div class="panel-heading">
              <div class="panel-title"> <span class="glyphicon glyphicon-book"></span> Edit Employee</div>
            </div>
            <div class="panel-body alerts-panel">
              <form class="cmxform" id="add_new_user_frm" method="POST" action="<?php echo SURL?>employee/manage-employee/edit-employee-process" enctype="multipart/form-data">
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
                        <input id="first_name" name="first_name" type="text" class="form-control" placeholder="Enter First Name" value="<?php echo $employee_arr['first_name']; ?>" required/>
                      </div>
                      <div class="form-group">
                        <label for="last_name">Last Name*</label>
                        <input id="last_name" name="last_name" type="text" class="form-control" placeholder="Enter Last Name" value="<?php echo $employee_arr['last_name']; ?>" required/>
                      </div>
                      <div class="form-group">
                        <label for="username">Username</label>
                        <input id="username" name="username" type="text" class="form-control" placeholder="Enter Username" value="<?php echo $employee_arr['username']; ?>" required  readonly/>
	                      <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> Username will be used to login into the CMS Panel.</span>
                      </div>
                      
                      <div class="form-group">
                        <label for="password">Password</label>
                        <input id="password" name="password" type="password" class="form-control" placeholder="Enter Password" value=""  />
                      </div>

                      <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input id="confirm_password" name="confirm_password" type="password" class="form-control" placeholder="Confirm Password" value=""  />
                      </div>
                      
                      <div class="form-group">
                        <label for="email_address">Email Address</label>
                        <input id="email_address" name="email_address" type="text" class="form-control" placeholder="Enter Email Address" value="<?php echo $employee_arr['email_address']; ?>"/>
                      </div>
                      
                      
                    <div class="form-group">
                        <label for="last_name">Phone Number</label>
                        <input id="phone" name="phone" type="text" class="form-control" placeholder="Enter Phone Number" value="<?php echo $employee_arr['phone']; ?>" required/>
                    </div>  
                    
                    
                    <div class="row form-group">
                        <div class="col-md-5">
                        	<div class="form-group">
                      <label for="upload">Upload Profile Image</label>
                      <input type="file" id="prof_image" name="prof_image">
                        <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> 
	                        - Allowed Extensions: jpg, jpeg, gif, tiff, png <br>
                        </span>
                        <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> 
							- Max Upload Size: 2MB
                        </span>
                    </div>
                        </div>
                        <?php 
							if($employee_arr['profile_image'] !=''){
						?>
                        <div class="col-md-5">
                            <img src="<?php echo SURL.'assets/customer_files/'.$employee_arr['id'].'/'.stripslashes($employee_arr['profile_image'])?>">
                        </div>
                        <?php }//end if?>
                      </div>
                    
                    
                     </div>
                  
                    <div class="form-group" align="right" style="margin-right:17px">
                        <input type="hidden" name="employee_id" value="<?php echo $employee_id;?>">
                        <input class="submit btn btn-blue" type="submit" name="edit_new_employee_sbt" id="edit_new_employee_sbt" value="Edit Employee" />
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
<link href="<?php echo CSS ;?>select2.css" rel="stylesheet"/>
<script src="<?php echo JS ; ?>select2.js"></script>
 <script>
$(document).ready(function() { $("#country_name").select2(); $("#state_name").select2(); $("#city_name").select2(); });
</script>
    <script type="text/javascript">
      jQuery(document).ready(function() {
			// validate signup form on keyup and submit
			$("#add_new_user_frm").validate({
				
					rules: {
					first_name : 'required',
					last_name : 'required',
					account_type: "required",
					username: {
						required: true,
						minlength: 5,
						maxlength: 20
					},
					email_address: {
						required: false,
						email: true
					},
					admin_role_id: {
						required: true,
					}			
				},
					messages: {
					first_name: "This field is required.",
					last_name : "This field is required.",
					account_type: "Please select the account type.",
					username: {
						required: "This field is required.",
						minlength: "Username must consist of at least 5 characters",
						maxlength: "Username cannot me more than 20 characters"
					},
					password: {
						required: "Password cannot be empty.",
						minlength: "Password must be at least 6 characters long"
					},
					confirm_password: {
						required: "Confirm Password cannot be empty.",
						equalTo: "New Password must match with confirm password"
					},				
					email_address: "Enter your valid email address",
					admin_role_id : "Please select Administrative Role"
					
				}
				
			});
    });
	
	//Get Radio Values
	function change_account(radiovalue){
		
	if(radiovalue == 'Personal'){
		document.getElementById('personaldata').style.display = '';
		document.getElementById('businessdata').style.display = 'none';
		
	}else if(radiovalue == 'Business'){
	
		document.getElementById('personaldata').style.display = 'none';
		document.getElementById('businessdata').style.display = '';
	
	}
	
	
}


function get_states(country_id){
 document.getElementById('state_response').innerHTML = "<img class='loading' src='<?php echo IMG ; ?>select2-spinner.gif' alt='loading...' />";
 var request_url = "<?php echo SURL ; ?>customers/manage-customers/get_states_list/"+country_id;
 jQuery.post(
  request_url, {flag : true}, function(responseText){
  
  var split_response = responseText.split('|'); 	  
 
  jQuery("#state_response").html(split_response[0]);
  
  jQuery("#city_response").html(split_response[1]);	
   $("#city_name").select2(); 
 
  }, "html"
 );
}//end check_nic_exist
   </script>

</body>
</html>
