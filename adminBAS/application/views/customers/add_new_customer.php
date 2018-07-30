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
              <div class="panel-title"> <span class="glyphicon glyphicon-book"></span> Add New Customer</div>
            </div>
            <div class="panel-body alerts-panel">
              <form class="cmxform" id="add_new_user_frm" method="POST" action="<?php echo SURL?>customers/manage-customers/add_new_customer-process" enctype="multipart/form-data">
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
                        <input id="first_name" name="first_name" type="text" class="form-control" placeholder="Enter First Name" value="" required/>
                      </div>
                      <div class="form-group">
                        <label for="last_name">Last Name*</label>
                        <input id="last_name" name="last_name" type="text" class="form-control" placeholder="Enter Last Name" value="" required/>
                      </div>
                      <div class="form-group">
                        <label for="username">Username</label>
                        <input id="username" name="username" type="text" class="form-control" placeholder="Enter Username" value="" required />
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
                        <input id="email_address" name="email_address" type="text" class="form-control" placeholder="Enter Email Address" value=""/>
                      </div>
                      
                      
                    <div class="form-group">
                        <label for="last_name">Phone Number</label>
                        <input id="phone" name="phone" type="text" class="form-control" placeholder="Enter Phone Number" value="" required/>
                    </div>  
                    
                    
                     <div class="form-group">
                        <label for="yahoo_id">Yahoo</label>
                        <input id="yahoo_id" name="yahoo_id" type="text" class="form-control" placeholder="Enter Yahoo ID" value="" />
                    </div>  
                    
                     <div class="form-group">
                        <label for="msn_id">MSN</label>
                        <input id="msn_id" name="msn_id" type="text" class="form-control" placeholder="Enter MSN ID" value="" />
                    </div>  
                     <div class="form-group">
                        <label for="skype_id">Skype</label>
                        <input id="skype_id" name="skype_id" type="text" class="form-control" placeholder="Enter Skype ID" value="" />
                    </div>  
                    
                     <div class="form-group">
                        <label for="gtalk_id">Gtalk</label>
                        <input id="gtalk_id" name="gtalk_id" type="text" class="form-control" placeholder="Enter Gtalk ID" value="" />
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
                    
                    <div class="row form-group">
                        <div class="col-md-5">
                          <label for="standard-list1">Important Note </label>
                            <span id="city_response">
                            	 <textarea class="form-control" id="imp_note" rows="3" name="imp_note" required></textarea>
                        	</span>
                        </div>
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
                          <label for="standard-list1">Account Verify By Email :</label>
                          <input id="is_verify_email" name="is_verify_email" type="checkbox" value="1" <?php if($session_post_data['is_verify_email'] == '1'){ ?> checked="checked"  <?php  } ?>  /> 
                        </div>
                    </div>
                  	<div class="row form-group">
                        <div class="col-md-5">
                          <label for="standard-list1">Account Type :</label>
                           <input id="account_type" name="account_type" type="radio" value="Personal" <?php if($session_post_data['account_type'] == 'Personal'){ ?> checked="checked"  <?php  } ?> onClick="change_account(this.value)" /> Personal &nbsp;&nbsp;<input id="account_type" name="account_type" type="radio" value="Business" <?php if($session_post_data['account_type'] == 'Business'){ ?> checked="checked"  <?php  } ?> onClick="change_account(this.value)" /> Business 							 <!-- <select class="form-control" id="status" name="status">
                            <option value="1" < ?php echo ($session_post_data['status'] == 1) ? 'selected' : ''?>  >Active</option>
                            <option value="0" < ?php echo ($session_post_data['status'] == 0) ? 'selected' : ''?>>InActive</option>
                        </select>-->
                        </div>
                    </div>
                    
                    <div id="personaldata" style="display:none;">
                    	 <div class="form-group">
                        <label for="email_address">Technical Person Name</label>
                        <input id="p_tech_name" name="p_tech_name" type="text" class="form-control" placeholder="Technical Person Name" value="<?php echo $session_post_data['tech_name'] ?>"/>
                      </div>  
                         
                         <div class="form-group">
                        <label for="email_address">Technical Person Phone</label>
                        <input id="p_tech_phone" name="p_tech_phone" type="text" class="form-control" placeholder="Technical Person Phone" value="<?php echo $session_post_data['tech_phone'] ?>"/>
                      </div>
                    </div>
                    
                    <div id="businessdata" style="display:none;">
                    	 <div class="form-group">
                        <label for="Company Name">Company Name</label>
                        <input id="comp_name" name="comp_name" type="text" class="form-control" placeholder="Company Name" value="<?php echo $session_post_data['comp_name'] ?>"/>
                      </div>  
                         
                         <div class="form-group">
                        <label for="Company Phone">Company Phone</label>
                        <input id="comp_phone" name="comp_phone" type="text" class="form-control" placeholder="Company Phone" value="<?php echo $session_post_data['tech_phone'] ?>"/>
                      </div>
                      
                       <div class="form-group">
                        <label for="Company Website">Company Website</label>
                        <input id="comp_website" name="comp_website" type="text" class="form-control" placeholder="Company Website" value="<?php echo $session_post_data['tech_name'] ?>"/>
                      </div>  
                         
                         <div class="form-group">
                        <label for="email_address">Company Address</label>
                        <input id="comp_add" name="comp_add" type="text" class="form-control" placeholder="Company Address" value="<?php echo $session_post_data['tech_phone'] ?>"/>
                      </div>
                    	
                         
                       <div class="form-group">
                        <label for="email_address">Technical Person Name</label>
                        <input id="c_tech_name" name="c_tech_name" type="text" class="form-control" placeholder="Technical Person Name" value="<?php echo $session_post_data['tech_name'] ?>"/>
                      </div>  
                         
                         <div class="form-group">
                        <label for="email_address">Technical Person Phone</label>
                        <input id="c_tech_phone" name="c_tech_phone" type="text" class="form-control" placeholder="Technical Person Phone" value="<?php echo $session_post_data['tech_phone'] ?>"/>
                      </div>
                    </div>
                  
                     </div>
                  
                    <div class="form-group" align="right" style="margin-right:17px">
                        <input class="submit btn btn-blue" type="submit" name="add_new_customer_sbt" id="add_new_customer_sbt" value="Add New Customer" />
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
