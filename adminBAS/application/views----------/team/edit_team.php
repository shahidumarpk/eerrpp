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

<link rel="stylesheet" href="docsupport/style.css">
<link rel="stylesheet" href="<?php echo SURL; ?>assets/css/chosen.css">

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
        <div class="col-md-12" style="min-height:1100px;">
          <div class="panel">
            <div class="panel-heading">
              <div class="panel-title"> <span class="glyphicon glyphicon-book"></span>Edit Team</div>
            </div>
            <div class="panel-body alerts-panel">
              <form class="cmxform" id="add_new_user_frm" method="POST" action="<?php echo SURL?>team/manage-team/edit-team-process" enctype="multipart/form-data">
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
                        <label for="team_title">Team Title*</label>
                        <input id="team_title" name="team_title" type="text" class="form-control" value="<?php echo $team_arr['team_title'] ?>" required/>
                      </div>
                      
                       <div class="row form-group">
                        <div class="col-md-5">
                          <label for="standard-list1">Team Head </label>
                           <select id="team_head" name="team_head" style="width:100%;" required>
                           <option value="">Select team head Name</option>
                                <?php
								if($admin_user_list_count>0){ 
								for($c=0; $c < $admin_user_list_count ; $c++){ ?>
										<option value="<?php echo $admin_user_list[$c]['id'] ?>" <?php if($team_arr['team_head']== $admin_user_list[$c]['id']){ ?> selected<?php } ?>><?php echo $admin_user_list[$c]['first_name']." ".$admin_user_list[$c]['last_name'];?></option>
								<?php }} ?>
                          </select>
                        </div>
                    </div>
                        
                      
                    
                    <div class="row form-group">
                        <div class="col-md-5">
                          <label for="standard-list1">Branch Name</label>
                           <select id="e1" name="branch_id" style="width:100%;" required>
                           <option value="">Select Branch Name</option>
                                <?php
								if($branches_count>0){ 
								for($c=0; $c < $branches_count ; $c++){ ?>
										<option value="<?php echo $branches_arr[$c]['id'] ?>" <?php if($team_arr['branch_id']== $branches_arr[$c]['id']){ ?> selected<?php } ?>><?php echo $branches_arr[$c]['branch_name'];?></option>
								<?php }} ?>
                          </select>
                        </div>
                    </div><br>

                    
                    
                      <div class="form-group">
                      <label for="project_assign">Team Members</label>
                      </div>
                     <?php $team_members_arr = explode(',',$team_arr['team_members']); ?>   
                       
                      <select name="team_members[]" id="team_members" data-placeholder="Choose a name..." class="chosen-select" multiple style="width:350px;" tabindex="4">
                        <option value=""></option>
                        
                        <?php  for($i=0; $i<$admin_user_list_count; $i++) {?>
                        
                        <option value="<?php echo $admin_user_list[$i]['id'] ?>" <?php if(in_array($admin_user_list[$i]['id'],$team_members_arr)){ ?> selected <?php  } ?>><?php echo $admin_user_list[$i]['first_name']." ".$admin_user_list[$i]['last_name']; ?></option>
                        
                        <?php } ?>
                      </select>
                 <br>
				 <br>
                 
                      <div class="row form-group">
                        <div class="col-md-5">
                          <label for="standard-list1">Status</label>
                            <select class="form-control" id="status" name="status">
                            <option value="1" <?php if($team_arr['status']==1){ ?> selected<?php } ?> >Active</option>
                            <option value="0" <?php if($team_arr['status']==0){ ?> selected<?php } ?>>InActive</option>
                        </select>
                        </div>
                    </div>
                                          
                  </div>
                  
                    <div class="form-group" align="right" style="margin-right:17px">
                        <input type="hidden" name="team_id" value="<?php echo $team_id; ?>" >
                        <input class="submit btn btn-blue" type="submit" name="edit_team_sbt" id="edit_team_sbt" value="Edit Team" />
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
<script src="<?php echo SURL; ?>assets/js/chosen.jquery.js" type="text/javascript"></script>
<script type="text/javascript">
    var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
</script>
  


<link href="<?php echo CSS ;?>select2.css" rel="stylesheet"/>
<script src="<?php echo JS ; ?>select2.js"></script>


  
<script>
$(document).ready(function() { $("#e1").select2(); });
</script>

<script>
$(document).ready(function() { $("#team_head").select2(); });
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
