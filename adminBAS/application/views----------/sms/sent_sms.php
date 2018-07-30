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
        <div class="col-md-12" style="min-height:1200px;">
          <div class="panel">
            <div class="panel-heading">
              <div class="panel-title"> <span class="glyphicon glyphicon-book"></span>Sent New SMS</div>
            </div>
            <div class="panel-body alerts-panel">
              <form class="cmxform" id="edit_admin_profile_frm" method="POST" action="<?php echo SURL?>sms/manage-sms/sent-sms-process" enctype="multipart/form-data">
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
                    
                   <div class="row">
                   <?php if($ALLOW_broadcast_to_branches==1){ ?>  
                   <div class="col-md-2">
                 
                        
                          <label for="standard-list1">BroadCast To Branch</label>
                           <select id="e1" name="branch_id" style="width:100%;" >
                           <option value="">Select Branch</option>
                                <?php 
								for($c=0; $c < $branches_count ; $c++){ ?>
									<option value="<?php echo $branches_arr[$c]['id'] ?>"><?php echo $branches_arr[$c]['branch_name']; ?></option>
								<?php } ?>
                                </select>
                  
                   </div>        
                   <?php } ?>
                   <?php if($ALLOW_broadcast_to_branches==1){ ?>  
                   <div class="col-md-2" style="margin-top: 27px; margin-left: 82px;"> 
                    OR
                   </div>
                   <?php } ?>
                    <div class="col-md-6">
                    <div class="row form-group">
                    <div class="col-md-4">
                          <label for="standard-list1">Select User</label>
                          
                         <select name="user_name[]" id="user_name" data-placeholder="Choose a name..." class="chosen-select" multiple style="" tabindex="4">
            <option value=""></option>
            <?php  for($i=0; $i<$admin_user_count; $i++) {
				 if($admin_user_arr[$i]['id']!=$this->session->userdata('admin_id')){
				
				?>
            
            <option value="<?php echo $admin_user_arr[$i]['id'] ?>"><?php echo $admin_user_arr[$i]['first_name']." ".$admin_user_arr[$i]['last_name']." (".$admin_user_arr[$i]['short_name'].")"; ?></option>
            
            <?php }} ?>
          </select>   
	                     </div>
                         </div>
                   </div>
                   
                   </div>
                       
                     
                      <div class="form-group">
                        <label for="subject">Subject*</label>
                        <input id="subject" name="subject" type="text" class="form-control"  value="" required/>
                      </div>
                      
                      
                      <div class="form-group">
                      <label for="message">Message*</label>
                      <textarea class="form-control" id="message" name="message" rows="8"></textarea>
                    </div>
                    
                                                  
                  </div>
                  
                  <input type="hidden" name="message_id" value="<?php echo  $message_id; ?>" >
                  
                    <div class="form-group" align="right" style="margin-right:17px">
                        <input class="submit btn btn-blue" type="submit" name="send_sms" id="send_sms" value="Send SMS" title="Click to Send SMS" />
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

    <script type="text/javascript">
      jQuery(document).ready(function() {
    
      // validate signup form on keyup and submit
        $("#edit_admin_profile_frm").validate({
            rules: {
				subject : 'required',
				message : 'required',
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
                subject: "This field is required.",
				message : "This field is required.",
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
