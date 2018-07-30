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
<header class="navbar navbar-fixed-top"><?php echo $INC_top_header; ?> </header>
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
              <div class="panel-title"> <span class="glyphicon glyphicon-book"></span> Edit Customer </div>
               <ul class="nav panel-tabs">
                <li class="active"><a href="#user_prof_contents" data-toggle="tab">Edit Customer Profile</a></li>
                <li class=""><a href="#upload_user_docs" data-toggle="tab">Upload Documents</a></li>
              </ul>
            </div>
            <div class="panel-body alerts-panel">
                <div class="tab-content border-none padding-none">
                  <div id="user_prof_contents" class="tab-pane active">
                    <form class="cmxform" id="add_new_user_frm" method="POST" action="<?php echo SURL?>customers/manage-customers/edit-customer-process" enctype="multipart/form-data">
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
                        <input id="first_name" name="first_name" type="text" class="form-control" placeholder="Enter First Name" value="<?php echo stripslashes($customer_user_data['first_name']) ?>" required/>
                      </div>
                      <div class="form-group">
                        <label for="last_name">Last Name*</label>
                        <input id="last_name" name="last_name" type="text" class="form-control" placeholder="Enter Last Name" value="<?php echo stripslashes($customer_user_data['last_name']) ?>" required/>
                      </div>
                     <div class="form-group">
                        <label for="username">Username</label>
                        <input id="username" name="username" type="text" class="form-control" placeholder="Enter Username" value="<?php echo stripslashes($customer_user_data['username']) ?>" readonly required />
	                      <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> Username will be used to login into the CMS Panel.</span>
                      </div>
                      
                      <div class="form-group">
                        <label for="password">Password</label>
                        <input id="password" name="password" type="password" class="form-control" placeholder="Enter Password" value="" />
                      </div>

                      <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input id="confirm_password" name="confirm_password" type="password" class="form-control" placeholder="Confirm Password" value="" />
                      </div>
                      
                      <div class="form-group">
                        <label for="email_address">Email Address</label>
                        <input id="email_address" name="email_address" type="text" class="form-control" placeholder="Enter Email Address" value="<?php echo stripslashes($customer_user_data['email_address']) ?>"/>
                      </div>
                       	 <div class="form-group">
                        <label for="last_name">Phone Number</label>
                        <input id="phone" name="phone" type="text" class="form-control" placeholder="Enter Phone Number" value="<?php echo $customer_user_data['phone'] ; ?>" required/>
                      </div>  
                      
                       
                     <div class="form-group">
                        <label for="yahoo_id">Yahoo</label>
                        <input id="yahoo_id" name="yahoo_id" type="text" class="form-control" placeholder="Enter Yahoo ID" value="<?php echo $customer_user_data['yahoo_id'] ?>" />
                    </div>  
                    
                     <div class="form-group">
                        <label for="msn_id">MSN</label>
                        <input id="msn_id" name="msn_id" type="text" class="form-control" placeholder="Enter MSN ID" value="<?php echo $customer_user_data['msn_id'] ?>" />
                    </div>  
                     <div class="form-group">
                        <label for="skype_id">Skype</label>
                        <input id="skype_id" name="skype_id" type="text" class="form-control" placeholder="Enter Skype ID" value="<?php echo $customer_user_data['skype_id'] ?>" />
                    </div>  
                    
                     <div class="form-group">
                        <label for="gtalk_id">Gtalk</label>
                        <input id="gtalk_id" name="gtalk_id" type="text" class="form-control" placeholder="Enter Gtalk ID" value="<?php echo $customer_user_data['gtalk_id'] ?>" />
                    </div>    
                     
                    <div class="row form-group">
                        <div class="col-md-5">
                          <label for="standard-list1">Country</label>
                            <select class="form-control" id="country_name" name="country_name" onChange="get_states(this.value)" required >
								<option value="">Select Country</option>
                            	<?php 
									for($i=0;$i<$countries_result_count;$i++){
								?>
                            			<option value="<?php echo $countries_result_arr[$i]['iso'];?>" <?php if($countries_result_arr[$i]['iso'] == $customer_user_data['country_name']){ ?> selected <?php } ?>><?php echo $countries_result_arr[$i]['country_name']?></option>    
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
                          <?php if($customer_user_data['country_name']=='US' or $customer_user_data['country_name']=='CA') {  ?>
                          <select class="form-control" id="state_name" name="state_name" required >
								<option value="">Select State</option>
                            	<?php 
									for($i=0;$i<$states_result_count;$i++){
								?>
                            			<option value="<?php echo $states_result_arr[$i]['state_name'];?>" <?php if($states_result_arr[$i]['state_name'] == $customer_user_data['state_name']){ ?> selected <?php } ?>><?php echo $states_result_arr[$i]['state_name']?></option>     
                                <?php		
									}//end for
								?>
                            
                        </select>
                         <?php  } else {  ?> 
                          
                             <input id="state_name" name="state_name" type="text" class="form-control" placeholder="Enter Phone Number" value="<?php echo $customer_user_data['state_name'] ; ?>" required/>  <?php  }  ?>
                          </span>  
                        </div>
                    </div>
                    
                    <div class="row form-group">
                        <div class="col-md-5">
                          <label for="standard-list1">City</label>
                            <span id="city_response">
                            	<select class="form-control" id="city_name" name="city_name" required>
									<?php 
									for($i=0;$i<$cities_result_count;$i++){
								?>
                            			<option value="<?php echo $cities_result_arr[$i]['name'];?>" <?php if($cities_result_arr[$i]['name'] == $customer_user_data['city_name']){ ?> selected <?php } ?>><?php echo $cities_result_arr[$i]['name']?></option>    
                                <?php		
									}//end for
								?>
                        		</select>
                        	</span>
                        </div>
                    </div>
                    
                    <div class="row form-group">
                        <div class="col-md-5">
                          <label for="standard-list1">Important Note </label>
                            <span id="city_response">
                            	 <textarea class="form-control" id="imp_note" rows="3" name="imp_note" required><?php echo stripslashes($customer_user_data['imp_note']) ?></textarea>
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
                        <?php 
							if($customer_user_data['profile_image'] !=''){
						?>
                        <div class="col-md-5">
                            <img src="<?php echo CUSTOMER_FOLDER.'/'.$customer_user_data['id'].'/'.stripslashes($customer_user_data['profile_image'])?>">
                        </div>
                        <?php }//end if?>
                      </div>
                     <div class="row form-group">
                        <div class="col-md-5">
                          <label for="standard-list1">Account Verify By Email :</label>
                          <input id="is_verify_email" name="is_verify_email" type="checkbox" value="1" <?php echo ($customer_user_data['is_verify_email'] == 1) ? 'checked' : '' ?>  /> 
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-5">
                          <label for="standard-list1">Account Type :</label>
                           <input id="account_type" name="account_type" type="radio" value="Personal" <?php if($customer_user_data['account_type'] == 'Personal'){ ?> checked="checked"  <?php  } ?> onClick="change_account(this.value)" /> Personal &nbsp;&nbsp;<input id="account_type" name="account_type" type="radio" value="Business" <?php if($customer_user_data['account_type'] == 'Business'){ ?> checked="checked"  <?php  } ?> onClick="change_account(this.value)" /> Business 							
                        </div>
                    </div>
                    
                    
                    
                    <div id="personaldata" <?php echo ($customer_user_data['account_type'] == 'Personal') ? '' : 'style="display:none;"'?>>
                    	 <div class="form-group">
                        <label for="email_address">Technical Person Name</label>
                        <input id="p_tech_name" name="p_tech_name" type="text" class="form-control" placeholder="Technical Person Name" value="<?php echo $customer_user_data['tech_name'] ?>"/>
                      </div>  
                         
                         <div class="form-group">
                        <label for="email_address">Technical Person Phone</label>
                        <input id="p_tech_phone" name="p_tech_phone" type="text" class="form-control" placeholder="Technical Person Phone" value="<?php echo $customer_user_data['tech_phone'] ?>"/>
                      </div>
                    </div>
                    
                    <div id="businessdata" <?php echo ($customer_user_data['account_type'] == 'Business') ? '' : 'style="display:none;"'?>>
                    	 <div class="form-group">
                        <label for="Company Name">Company Name</label>
                        <input id="comp_name" name="comp_name" type="text" class="form-control" placeholder="Company Name" value="<?php echo $customer_user_data['comp_name'] ?>"/>
                      </div>  
                         
                         <div class="form-group">
                        <label for="Company Phone">Company Phone</label>
                        <input id="comp_phone" name="comp_phone" type="text" class="form-control" placeholder="Company Phone" value="<?php echo $customer_user_data['comp_phone'] ?>"/>
                      </div>
                      
                       <div class="form-group">
                        <label for="Company Website">Company Website</label>
                        <input id="comp_website" name="comp_website" type="text" class="form-control" placeholder="Company Website" value="<?php echo $customer_user_data['comp_website'] ?>"/>
                      </div>  
                         
                         <div class="form-group">
                        <label for="email_address">Company Address</label>
                        <input id="comp_add" name="comp_add" type="text" class="form-control" placeholder="Company Address" value="<?php echo $customer_user_data['comp_add'] ?>"/>
                      </div>
                    	
                         
                       <div class="form-group">
                        <label for="email_address">Technical Person Name</label>
                        <input id="c_tech_name" name="c_tech_name" type="text" class="form-control" placeholder="Technical Person Name" value="<?php echo $customer_user_data['tech_name'] ?>"/>
                      </div>  
                         
                         <div class="form-group">
                        <label for="email_address">Technical Person Phone</label>
                        <input id="c_tech_phone" name="c_tech_phone" type="text" class="form-control" placeholder="Technical Person Phone" value="<?php echo $customer_user_data['tech_phone'] ?>"/>
                      </div>
                    </div> 
                      
                   <div class="row form-group">
                        <div class="col-md-5">
                          <label for="standard-list1">Status</label>
                            <select class="form-control" id="status" name="status">
                            <option value="1" <?php echo ($customer_user_data['status'] == 1) ? 'selected' : ''?> >Active</option>
                            <option value="0" <?php echo ($customer_user_data['status'] == 0) ? 'selected' : ''?>>InActive</option>
                        </select>
                        </div>
                    </div>
                         <div class="form-group" align="right" style="margin-right:17px">
                        <input class="submit btn btn-blue" type="submit" name="upd_customer_sbt" id="upd_customer_sbt" value="Update Customer" />
                        <input type="hidden" name="customer_id" id="customer_id" value="<?php echo $customer_user_data['id'] ?>" readonly />
                    </div> 
                    </form>                  
                  </div>
                  <div id="upload_user_docs" class="tab-pane">
                   <form class="cmxform" id="add_new_user_frm" method="POST" action="<?php echo SURL?>customers/manage-customers/upload-docs-process" enctype="multipart/form-data">
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
                        <label for="first_name">Title*</label>
                        <input id="title" name="title[]" type="text" class="form-control" placeholder="Enter Document Name" value="" required/>
                      </div>
                   <div class="form-group">
                       <label for="upload">Upload Doc </label>
                      <input type="file" id="upload_doc0" name="upload_doc[]">
                        <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> 
	                        - Allowed Extensions: jpg,jpeg,gif,tiff,png,doc,docx,xls,xlsx,pdf <br>
                        </span>
                        <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> 
							- Max Upload Size: 2MB
                        </span>
                   </div>
                   <div class="form-group">
                        <label for="page_short_desc">Short Description</label>
                       <textarea class="form-control" id="short_desc" name="short_desc[]" rows="3"><?php echo $session_post_data['page_short_desc'] ?></textarea>
                   </div>
                   <div id="itemRows"></div> 
                    <div><button type="button" class="btn btn-blue" onClick="addRow(this.form);">Upload More </button></div>
                    
                    <div class="clearfix">&nbsp;</div>
                    <div class="form-group" align="right" style="margin-right:17px">
                        <input class="submit btn btn-blue" type="submit" name="upd_customer_docs_sbt" id="upd_customer_docs_sbt" value="Update Customer" />
                        <input type="hidden" name="customer_id" id="customer_id" value="<?php echo $customer_user_data['id'] ?>" readonly />
                    </div>
                     </form>
                </div>
                  
                </div>
                
              
            </div>            
          </div>
        </div>
      </div>
      <div class="row" style="min-height:250px;">&nbsp;</div>
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
        $("#add_new_user_frm").validate({
            rules: {
				first_name : 'required',
				last_name : 'required',
              username: {
					required: true,
					minlength: 5,
					maxlength: 20
				},
				password: {
					required: false,
					minlength: 6
				},
				confirm_password: {
					required: false,
					equalTo: "#password"
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
					minlength: "Username must consist of at least 5 characters",
					maxlength: "Username cannot me more than 20 characters"
				},
				password: {
					minlength: "Password must be at least 6 characters long"
				},
				confirm_password: {
					equalTo: "New Password must match with confirm password"
				},				
				email_address: "Enter your valid email address",
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
	
    </script>
<script type='text/javascript'>
        var rowNum = 0;
function addRow(frm) {
	rowNum ++;
	var row = '<div id="rowNum'+rowNum+'"><div class="form-group"><label for="first_name">Title*</label><input id="title" name="title[]" type="text" class="form-control" placeholder="Enter Document Name" value="" required/></div><div class="form-group"><label for="upload">Upload Doc </label><input type="file" id="upload_doc" name="upload_doc[]"><span class="help-block margin-top-sm"><i class="fa fa-bell"></i>- Allowed Extensions: jpg,jpeg,gif,tiff,png,doc,docx,xls,xlsx,pdf <br></span><span class="help-block margin-top-sm"><i class="fa fa-bell"></i>- Max Upload Size: 2MB</span></div><div class="form-group"><label for="page_short_desc">Short Description</label><textarea class="form-control" id="short_desc" name="short_desc[]" rows="3"><?php echo $session_post_data['page_short_desc'] ?></textarea></div><input type="button" class="btn btn-danger" value="Remove" onclick="removeRow('+rowNum+');" style="margin-left:15px;"><div class="clearfix">&nbsp;</div><div class="clearfix">&nbsp;</div></div></div>';
	jQuery('#itemRows').append(row);
}

function removeRow(rnum) {
	jQuery('#rowNum'+rnum).remove();
}


function get_states(country_id){
	
 //var ajax_loader = "<img class='loading' src='"+base_url+"application/views/assets/images/ajax-loader.gif' alt='loading...' />";
 var request_url = "<?php echo SURL ; ?>customers/manage-customers/get_states_list/"+country_id;
 jQuery.post(
  request_url, {flag : true}, function(responseText){
  
  var split_response = responseText.split('|'); 	  
 
  jQuery("#state_response").html(split_response[0]);
  
  jQuery("#city_response").html(split_response[1]);	
 
  }, "html"
 );
}//end check_nic_exist

function get_cities(state_id){
 //var ajax_loader = "<img class='loading' src='"+base_url+"application/views/assets/images/ajax-loader.gif' alt='loading...' />";
 var request_url = "<?php echo SURL ; ?>customers/manage-customers/get_cities_list/"+state_id;
 jQuery.post(
  request_url, {flag : true}, function(responseText){
//alert(responseText); return false ;	  
  jQuery('#city_response').html(responseText);
  }, "html"
 );
}//end check_nic_exist


</script>
</body>
</html>
