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
              <div class="panel-title"> <span class="glyphicon glyphicon-book"></span> Edit Admin User</div>
              <ul class="nav panel-tabs">
                <li class="active"><a href="#user_prof_contents" data-toggle="tab">Edit User Profile</a></li>
                <li class=""><a href="#upload_user_docs" data-toggle="tab">Upload Documents</a></li>
              </ul>
              
            </div>
            <div class="panel-body alerts-panel">
            
              
                <div class="tab-content border-none padding-none">
                  <div id="user_prof_contents" class="tab-pane active">
                  
                  <form class="cmxform" id="add_new_user_frm" method="POST" action="<?php echo SURL?>admin/manage-user/edit-user-process" enctype="multipart/form-data">
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
										<option value="<?php echo $branches_arr[$c]['id'] ?>" <?php if($admin_user_data['branch_id']==$branches_arr[$c]['id']){ ?> selected <?php }  ?>><?php echo $branches_arr[$c]['branch_name'];?></option>
								<?php }} ?>
                          </select>
                        </div>
                    </div>
                    
                      <div class="form-group">
                        <label for="first_name">First Name*</label>
                        <input id="first_name" name="first_name" type="text" class="form-control" placeholder="Enter First Name" value="<?php echo stripslashes($admin_user_data['first_name']) ?>" required/>
                      </div>
                      <div class="form-group">
                        <label for="last_name">Last Name*</label>
                        <input id="last_name" name="last_name" type="text" class="form-control" placeholder="Enter Last Name" value="<?php echo stripslashes($admin_user_data['last_name']) ?>" required/>
                      </div>
                      
                        <div class="form-group">
                        <label for="last_name">Father Name</label>
                        <input id="father_name" name="father_name" type="text" class="form-control" placeholder="Enter Father Name" value="<?php echo $admin_user_data['father_name'] ?>" required/>
                       </div>  
                      
                      
                      <div class="form-group">
                        <label for="display_name">Display Name*</label>
                        <input id="display_name" name="display_name" type="text" class="form-control" placeholder="Enter user Display Name" value="<?php echo stripslashes($admin_user_data['display_name']) ?>" required/>
                      </div>

                      <div class="form-group">
                        <label for="username">Username</label>
                        <input id="username" name="username" type="text" class="form-control" placeholder="Enter Username" value="<?php echo stripslashes($admin_user_data['username']) ?>" readonly required />
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
                        <input id="email_address" name="email_address" type="text" class="form-control" placeholder="Enter Email Address" value="<?php echo stripslashes($admin_user_data['email_address']) ?>"/>
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
							if($admin_user_data['profile_image'] !=''){
						?>
                        <div class="col-md-5">
                            <img src="<?php echo USER_FOLDER.'/'.$admin_user_data['id'].'/'.stripslashes($admin_user_data['profile_image'])?>">
                        </div>
                        <?php }//end if?>
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
                        
                        <?php 
							if($admin_user_data['avatar_image'] !=''){
						?>
                        <div class="col-md-5">
                            <img src="<?php echo USER_FOLDER.'/'.$admin_user_data['id'].'/'.stripslashes($admin_user_data['avatar_image'])?>">
                        </div>
                        <?php }//end if?>
                      </div>
                      
                       <div class="form-group">
                        <label for="last_name">Zip Code</label>
                        <input id="zip" name="zip" type="text" class="form-control" placeholder="Enter ZIP Code" value="<?php echo $admin_user_data['zip'] ?>" required/>
                      </div> 
                    <div class="form-group">
                        <label for="last_name">Phone Number</label>
                        <input id="phone" name="phone" type="text" class="form-control" placeholder="Enter Phone Number" value="<?php echo $admin_user_data['phone'] ?>" required/>
                      </div>  
                      <div class="form-group">
                        <label for="last_name">Address</label>
                        <input id="address" name="address" type="text" class="form-control" placeholder="Enter Your Address" 
                        value="<?php echo $admin_user_data['address'] ?>" required/>
                      </div>
                      
                      <div class="form-group">
                        <label for="last_name">Bank Name</label>
                        <input id="bank_name" name="bank_name" type="text" class="form-control" placeholder="Bank Name" 
                        value="<?php echo $admin_user_data['bank_name'] ?>" required/>
                      </div>
                       <div class="form-group">
                        <label for="last_name">Branch Code</label>
                        <input id="branch_code" name="branch_code" type="text" class="form-control" placeholder="Branch Code" 
                        value="<?php echo $admin_user_data['bank_name'] ?>" required/>
                      </div>
                       <div class="form-group">
                        <label for="last_name">Account #</label>
                        <input id="account_no" name="account_no" type="text" class="form-control" placeholder="Account #" 
                        value="<?php echo $admin_user_data['account#'] ?>" required/>
                      </div>
                       <div class="form-group">
                        <label for="last_name">IBN #</label>
                        <input id="ibn_no" name="ibn_no" type="text" class="form-control" placeholder="IBN #" 
                        value="<?php echo $admin_user_data['ibn#'] ?>" required/>
                      </div>
                   
                        <div class="form-group">
                        <label for="last_name">Emergency Phone Number</label>
                        <input id="emergency_phone" name="emergency_phone" type="text" class="form-control" placeholder="Enter Emergency Phone Number" value="<?php echo $admin_user_data['emergency_phone'] ?>" />
                      </div> 
                        
                    <div class="row form-group">
                        <div class="col-md-5">
                          <label for="standard-list1">Country</label>
                            <select style="width:100%;" id="country_name" name="country_name" onChange="get_states(this.value)" required >
								<option value="0">Select Country</option>
                            	<?php 
									for($i=0;$i<$countries_result_count;$i++){
								?>
                            			<option value="<?php echo $countries_result_arr[$i]['iso']?>" <?php if($countries_result_arr[$i]['iso'] == $admin_user_data['country_name']){ ?> selected  <?php  } ?>><?php echo $countries_result_arr[$i]['country_name']?></option>    
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
                            <?php if($admin_user_data['country_name']=='US' or $admin_user_data['country_name']=='CA') {  ?>
                          <select  style="width:100%" id="state_name" name="state_name" required >
								<option value="">Select State</option>
                            	<?php 
									for($i=0;$i<$states_result_count;$i++){
								?>
                            			<option value="<?php echo $states_result_arr[$i]['state_name'];?>" <?php if($states_result_arr[$i]['state_name'] == $admin_user_data['state_name']){ ?> selected <?php } ?>><?php echo $states_result_arr[$i]['state_name']?></option>     
                                <?php		
									}//end for
								?>
                            
                        </select>
                         <?php  } else {  ?> 
                          
                             <input id="state_name" name="state_name" type="text" class="form-control" placeholder="" value="<?php echo $admin_user_data['state_name'] ; ?>" required/>  <?php  }  ?>
                          </span>  
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-5">
                          <label for="standard-list1">City</label>
                            <span id="city_response">
                            	<select style="width:100%;" id="city_name" name="city_name" >
									<?php 
									for($i=0;$i<$cities_result_count;$i++){
								?>
                            			<option value="<?php echo $cities_result_arr[$i]['name'];?>" <?php if($cities_result_arr[$i]['name'] == $admin_user_data['city_name']){ ?> selected <?php } ?>><?php echo $cities_result_arr[$i]['name']?></option>    
                                <?php		
									}//end for
								?>
                        		</select>
                        	</span>
                        </div>
                    </div>
                    
                     <div class="form-group">
                        <label for="last_name">Salary</label>
                        <input id="salary" name="salary" type="text" class="form-control" placeholder="Enter salary" value="<?php echo $admin_user_data['salary'] ?>"" required/>
                   </div>  
                   
                   
                     <div class="form-group">
                        <label for="last_name">NIC</label>
                        <input id="nic" name="nic" type="text" class="form-control" placeholder="Enter NIC number" value="<?php echo $admin_user_data['nic'] ?>"" required/>
                   </div>  
                    
                   
                   
                    <div class="row form-group">
                          <label class="col-md-2">Date of Birth</label>
                          <div class="col-xs-3" id="date_of_birth">
                               <div class="input-group"><input type="text"  style="cursor:pointer;" name="dob" id="dob" value="<?php echo  date("m/d/Y", strtotime($admin_user_data['dob']));?>" class="form-control" required /><span class="input-group-addon"><span id="targetto" onclick="create_date('date_of_birth')" class="glyphicon glyphicon-calendar" style="cursor:pointer;"></span></span>
                        </div>
                        </div>  
                    </div>
                    
                     
                    <div class="row form-group">
                      <label class="col-md-2">Join Date</label>
                          <div class="col-xs-3" id="joindate">
                               <div class="input-group"><input type="text"  style="cursor:pointer;" name="join_date" id="join_date" value="<?php echo date("m/d/Y", strtotime($admin_user_data['join_date']));?>" class="form-control" required /><span class="input-group-addon"><span id="targetto" onclick="create_date('joindate')" class="glyphicon glyphicon-calendar" style="cursor:pointer;"></span></span>
                        </div>
                        </div>
                    </div>
                     
                 
           
                <div class="row form-group">
                              <label class="col-md-2">Start Time</label>
                              <div id="starttime" class=" col-md-9 input-append">
                                <input data-format="hh:mm:ss" type="text" name="start_time" class="my-control" value="<?php echo date('g:i:s ', strtotime($admin_user_data['start_time']));?>" ></input>
                                <span class="add-on">
                                  <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                  </i>
                                </span>
                     </div>
     
                 </div>
                   <div class="clearfix">&nbsp;</div>
                   <div class="row form-group">
                          <label class="col-md-2">Last Increament</label>
                          <div class="col-xs-3" id="increament">
                               <div class="input-group"><input type="text"  style="cursor:pointer;" name="last_increament" id="last_increament" value="<?php echo date("m/d/Y", strtotime($admin_user_data['last_increament']));?>" class="form-control" required /><span class="input-group-addon"><span id="targetto" onclick="create_date('increament')" class="glyphicon glyphicon-calendar" style="cursor:pointer;"></span></span>
                        </div>
                        </div>
                          
                  </div>
                  
                  
                    <div class="form-group">
                        <label for="last_name">Designation</label>
                        <input id="designation" name="designation" type="text" class="form-control" placeholder="Enter Designation" value="<?php echo $admin_user_data['designation'] ?>" required/>
                   </div>  
                   
                   
                   
                 <div class="form-group">
                    <label for="last_name">IP</label>
                    <input id="ip" name="ip" type="text" class="form-control" placeholder="Enter IP Address" 
                    value="<?php echo $admin_user_data['ip'] ?>" required/>
                 </div>
                  
                  <div class="form-group">
                    <label for="last_name">PC No</label>
                    <input id="pc_no" name="pc_no" type="text" class="form-control" placeholder="Enter PC number" 
                    value="<?php echo $admin_user_data['pc_no'] ?>" required/>
                  </div>
                  
                  
                   <div class="form-group">
                    <label for="last_name">Desk No</label>
                    <input id="desk_no" name="desk_no" type="text" class="form-control" placeholder="Enter Desk Number" 
                    value="<?php echo $admin_user_data['desk_no'] ?>" required/>
                  </div>
                   
                                          
                      <div class="row form-group">
                        <div class="col-md-5">
                          <label for="standard-list1">Administrative Role*</label>
                            <select class="form-control" id="admin_role_id" name="admin_role_id" required>
								<option value="">Select Admin Role</option>

                            	<?php 
									for($i=0;$i<$admin_roles_count;$i++){
								?>
                            			<option value="<?php echo $admin_roles_arr[$i]['id']?>" <?php echo ($admin_user_data['admin_role_id'] == $admin_roles_arr[$i]['id']) ? 'selected' : ''?> ><?php echo $admin_roles_arr[$i]['role_title']?></option>    
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
                            <option value="1" <?php echo ($admin_user_data['status'] == 1) ? 'selected' : ''?> >Active</option>
                            <option value="0" <?php echo ($admin_user_data['status'] == 0) ? 'selected' : ''?>>InActive</option>
                        </select>
                        </div>
                    
                    <div class="form-group" align="right" style="margin-right:17px">
                        <input class="submit btn btn-blue" type="submit" name="upd_user_sbt" id="upd_user_sbt" value="Update User" />
                        <input type="hidden" name="admin_id" id="admin_id" value="<?php echo $admin_user_data['id'] ?>" readonly />
                        
                     
                    </div>
                </div>
                
             </form>    
            </div>
            
                   <div id="upload_user_docs" class="tab-pane">
                   <form class="cmxform" id="add_new_user_frm" method="POST" action="<?php echo SURL?>admin/manage-user/upload-docs-process" enctype="multipart/form-data">
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
                        <input class="submit btn btn-blue" type="submit" name="upd_user_docs_sbt" id="upd_user_docs_sbt" value="Update User" />
                        <input type="hidden" name="user_id" id="user_id" value="<?php echo $admin_user_data['id'] ?>" readonly />
                    </div>
                     </form>
                </div>  
                </div>          
          </div>
        </div>
      </div>
      <div class="row" style="min-height:250px;">&nbsp;</div>
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
	
	
	        var rowNum = 0;
function addRow(frm) {
	rowNum ++;
	var row = '<div id="rowNum'+rowNum+'"><div class="form-group"><label for="first_name">Title*</label><input id="title" name="title[]" type="text" class="form-control" placeholder="Enter Document Name" value="" required/></div><div class="form-group"><label for="upload">Upload Doc </label><input type="file" id="upload_doc" name="upload_doc[]"><span class="help-block margin-top-sm"><i class="fa fa-bell"></i>- Allowed Extensions: jpg,jpeg,gif,tiff,png,doc,docx,xls,xlsx,pdf <br></span><span class="help-block margin-top-sm"><i class="fa fa-bell"></i>- Max Upload Size: 2MB</span></div><div class="form-group"><label for="page_short_desc">Short Description</label><textarea class="form-control" id="short_desc" name="short_desc[]" rows="3"><?php echo $session_post_data['page_short_desc'] ?></textarea></div><input type="button" class="btn btn-danger" value="Remove" onclick="removeRow('+rowNum+');" style="margin-left:15px;"><div class="clearfix">&nbsp;</div><div class="clearfix">&nbsp;</div></div></div>';
	jQuery('#itemRows').append(row);
}

function removeRow(rnum) {
	jQuery('#rowNum'+rnum).remove();
}
	
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
					required: false,
					minlength: 5
				},
				confirm_password: {
					required: false,
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
					minlength: "Password must be at least 5 characters long"
				},
				confirm_password: {
					equalTo: "New Password must match with confirm password"
				},				
				email_address: "Enter your valid email address",
				admin_role_id : "Please select Administrative Role"
            }
        });
    
    });
    </script>
<link href="<?php echo CSS ;?>select2.css" rel="stylesheet"/>
<script src="<?php echo JS ; ?>select2.js"></script>

<script type="text/javascript">
  $(function() {
    $('#starttime').datetimepicker({
      pickDate: false
    });
  });
</script>
<script src="<?php echo SURL; ?>assets/js/chosen.jquery.js" type="text/javascript"></script>
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
</body>
</html>
