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
              <div class="panel-title"> <span class="glyphicon glyphicon-book"></span> Add New Admin User</div>
            </div>
            <div class="panel-body alerts-panel">
              <form class="cmxform" id="add_new_user_frm" method="POST" action="<?php echo SURL?>admin/manage-user/add-new-user-process" enctype="multipart/form-data">
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
                    
                    
                    <div class="row form-group">
                        <div class="col-md-5">
                          <label for="standard-list1">Branch Name</label>
                           <select id="e1" name="branch_id" style="width:100%;" required>
                           <option value="">Select Branch Name</option>
                                <?php
								if($branches_count>0){ 
								for($c=0; $c < $branches_count ; $c++){ ?>
										<option value="<?php echo $branches_arr[$c]['id'] ?>"><?php echo $branches_arr[$c]['branch_name'];?></option>
								<?php }} ?>
                          </select>
                        </div>
                    </div>
                        
                      <div class="form-group">
                        <label for="first_name">First Name*</label>
                        <input id="first_name" name="first_name" type="text" class="form-control" placeholder="Enter First Name" value="<?php echo $session_post_data['first_name'] ?>" required/>
                      </div>
                      
                      
                      <div class="form-group">
                        <label for="last_name">Last Name*</label>
                        <input id="last_name" name="last_name" type="text" class="form-control" placeholder="Enter Last Name" value="<?php echo $session_post_data['last_name'] ?>" required/>
                      </div>
                      <div class="form-group">
                        <label for="display_name">Display Name*</label>
                        <input id="display_name" name="display_name" type="text" class="form-control" placeholder="Enter user Display Name" value="<?php echo $session_post_data['display_name'] ?>" required/>
                      </div>

                      <div class="form-group">
                        <label for="username">Username</label>
                        <input id="username" name="username" type="text" class="form-control" placeholder="Enter Username" value="<?php echo $session_post_data['username'] ?>" required />
	                      <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> Username will be used to login into the CMS Panel.</span>
                      </div>
                      
                      <div class="form-group">
                        <label for="password">Password</label>
                        <input id="password" name="password" type="password" class="form-control" placeholder="Enter Password" value="" required />
                      </div>

                      <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input id="confirm_password" name="confirm_password" type="password" class="form-control" placeholder="Confirm Password" value="" required />
                      </div>
                      
                      <div class="form-group">
                        <label for="email_address">Email Address</label>
                        <input id="email_address" name="email_address" type="text" class="form-control" placeholder="Enter Email Address" value="<?php echo $session_post_data['email_address'] ?>"/>
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
                      </div>
                      
                      <div class="row form-group">
                        <div class="col-md-5">
                        	<div class="form-group">
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
                      </div>
                      
                    <div class="form-group">
                        <label for="last_name">Zip Code</label>
                        <input id="zip" name="zip" type="text" class="form-control" placeholder="Enter ZIP Code" value="<?php echo $session_post_data['zip'] ?>" required/>
                      </div> 
                     
                      <div class="form-group">
                        <label for="last_name">Phone Number</label>
                        <input id="phone" name="phone" type="text" class="form-control" placeholder="Enter Phone Number" value="<?php echo $session_post_data['phone'] ?>" required/>
                      </div> 
                      
                       <div class="form-group">
                        <label for="last_name">Emergency Phone Number</label>
                        <input id="emergency_phone" name="emergency_phone" type="text" class="form-control" placeholder="Enter Emergency Phone Number" value="<?php echo $session_post_data['emergency_phone'] ?>" />
                      </div> 
                         
                    <div class="row form-group">
                        <div class="col-md-5">
                          <label for="standard-list1">Country</label>
                            <select style="width:100%;" id="country_name" name="country_name" onChange="get_states(this.value)" required >
								<option value="0">Select Country</option>
                            	<?php 
									for($i=0;$i<$countries_result_count;$i++){
								?>
                            			<option value="<?php echo $countries_result_arr[$i]['iso']?>"><?php echo $countries_result_arr[$i]['country_name']?></option>    
                                <?php		
									}//end for
								?>
                            
                        </select>
                        </div>
                    </div>
                  	<div class="row form-group">
                        <div class="col-md-5">
                          <label for="standard-list1">State</label>
                          <span id="state_response">
                            <select style="width:100%;" id="state_name" name="state_name"  required>
								<option value="0">Select State</option>
                        	</select>
                          </span>  
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-5">
                          <label for="standard-list1">City</label>
                            <span id="city_response">
                            	<select style="width:100%;"  id="city_name" name="city_name" required>
									<option value="0">Select City</option>
                        		</select>
                        	</span>
                        </div>
                    </div>
                    
                   <div class="form-group">
                        <label for="last_name">Salary</label>
                        <input id="salary" name="salary" type="text" class="form-control" placeholder="Enter salary" value="<?php echo $session_post_data['zip'] ?>" required/>
                   </div>  
                   
                   
                     <div class="form-group">
                        <label for="last_name">NIC</label>
                        <input id="nic" name="nic" type="text" class="form-control" placeholder="00000-0000000-0" value="<?php echo $session_post_data['zip'] ?>" required/>
                   </div>  
                    
                   
                   
                    <div class="row form-group">
                          <label class="col-md-2">Date of Birth</label>
                          <div class="col-xs-3" id="date_of_birth">
                               <div class="input-group"><input type="text"  style="cursor:pointer;" name="dob" id="dob" class="form-control" required /><span class="input-group-addon"><span id="targetto" onclick="create_date('date_of_birth')" class="glyphicon glyphicon-calendar" style="cursor:pointer;"></span></span>
                        </div>
                        </div>  
                    </div>
                    
                     
                    <div class="row form-group">
                      <label class="col-md-2">Join Date</label>
                          <div class="col-xs-3" id="joindate">
                               <div class="input-group"><input type="text"  style="cursor:pointer;" name="join_date" id="join_date" class="form-control" required /><span class="input-group-addon"><span id="targetto" onclick="create_date('joindate')" class="glyphicon glyphicon-calendar" style="cursor:pointer;"></span></span>
                        </div>
                        </div>
                    </div>
                     
                      
                   <div class="row form-group">
                          <label class="col-md-2">Last Increament</label>
                          <div class="col-xs-3" id="increament">
                               <div class="input-group"><input type="text"  style="cursor:pointer;" name="last_increament" id="last_increament" class="form-control" required /><span class="input-group-addon"><span id="targetto" onclick="create_date('increament')" class="glyphicon glyphicon-calendar" style="cursor:pointer;"></span></span>
                        </div>
                        </div>
                          
                  </div>
                    
                    <div class="row form-group">
                        <div class="col-md-5">
                          <label for="standard-list1">Administrative Role*</label>
                            <select class="form-control" id="admin_role_id" name="admin_role_id" required>
								<option value="">Select Admin Role</option>

                            	<?php 
									for($i=0;$i<$admin_roles_count;$i++){
								?>
                            			<option value="<?php echo $admin_roles_arr[$i]['id']?>" <?php echo ($admin_user_data['admin_role'] == $admin_roles_arr[$i]['id']) ? 'selected' : ''?> ><?php echo $admin_roles_arr[$i]['role_title']?></option>    
                                <?php		
									}//end for
								?>
                            
                        </select>
                        </div>
                    </div>
                    
                      <div class="row form-group">
                        <div class="col-md-5">
                          <label for="standard-list1">Status</label>
                            <select class="form-control" id="status" name="status">
                            <option value="1"   >Active</option>
                            <option value="0" >InActive</option>
                        </select>
                        </div>
                    </div>
                                          
                  </div>
                  
                    <div class="form-group" align="right" style="margin-right:17px">
                        <input class="submit btn btn-blue" type="submit" name="add_new_user_sbt" id="add_new_user_sbt" value="Add New User" />
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
$(document).ready(function() { $("#e1").select2(); });
</script>

 <script>
$(document).ready(function() { $("#country_name").select2(); $("#state_name").select2(); $("#city_name").select2(); });


function get_states(country_id){
 document.getElementById('state_response').innerHTML = "<img class='loading' src='<?php echo IMG ; ?>select2-spinner.gif' alt='loading...' />";
 var request_url = "<?php echo SURL ; ?>admin/manage-user/get_states_list/"+country_id;
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

    <script type="text/javascript">
      jQuery(document).ready(function() {
    
      // validate signup form on keyup and submit
        $("#add_new_user_frm").validate({
            rules: {
				first_name : 'required',
				last_name : 'required',
                display_name: "required",
				username: {
					required: true,
					minlength: 5,
					maxlength: 20
				},
				password: {
					required: true,
					minlength: 6
				},
				confirm_password: {
					required: true,
					equalTo: "#password"
				},
				email_address: {
					required: false,
					email: true
				},
				admin_role_id: {
					required: true,
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
    </script>


</body>
</html>
