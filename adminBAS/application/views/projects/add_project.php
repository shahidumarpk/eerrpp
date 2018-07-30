<!DOCTYPE html>
<html>
<head>

<!-- Meta, title, CSS, favicons, etc. -->
<meta charset="utf-8">
<title><?php echo $meta_title ?></title>
<meta name="keywords" content="<?php echo $meta_keywords ?>" />
<meta name="description" content="<?php echo $meta_description ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

 <link rel="stylesheet" href="docsupport/style.css">
 <link rel="stylesheet" href="<?php echo SURL; ?>assets/css/chosen.css">
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
              <div class="panel-title"> <span class="glyphicon glyphicon-book"></span> Add New Project</div>
            </div>
            <div class="panel-body alerts-panel">
              <form class="cmxform" id="edit_admin_profile_frm" method="POST" action="<?php echo SURL?>projects/manage_projects/add_project_process" enctype="multipart/form-data">
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
                           <select id="branch" name="branch_id" style="width:100%;" required>
                           <option value="">Select Branch Name</option>
                                <?php
								if($branches_count>0){ 
								for($c=0; $c < $branches_count ; $c++){ ?>
										<option value="<?php echo $branches_arr[$c]['id'] ?>"><?php echo $branches_arr[$c]['branch_name'];?></option>
								<?php }} ?>
                          </select>
                        </div>
                    </div>  
                    
                    <div class="row form-group">
                        <div class="col-md-5">
                          <label for="standard-list1">Customer Name</label>
                           <select id="e1" name="customer_id" style="width:100%;">
                                <?php
								if($customers_list_count>0){ 
								for($c=0; $c < $customers_list_count ; $c++){ ?>
										<option value="<?php echo $customers_list_arr[$c]['id'] ?>"><?php echo $customers_list_arr[$c]['first_name'].' '.$customers_list_arr[$c]['last_name'] ; ?></option>
								<?php }} ?>
                          </select>
                        </div>
                        
                        
                         <div class="col-md-5">
                          <label for="standard-list1">Forum Name</label>
                           <select id="forum_id" name="forum_id" style="width:100%;">
                           <option value="0">None</option>
                                <?php 
								if($forums_list_count>0){
								for($c=0; $c < $forums_list_count ; $c++){ ?>
										<option value="<?php echo $forums_list_arr[$c]['id'] ?>"><?php echo $forums_list_arr[$c]['forum_name']; ?></option>
								<?php }} ?>
                          </select>
                        </div>
                        
                    </div>
                    
                    
                      
                      <div class="form-group">
                        <label for="project_id">Project ID*</label>
                        <input id="project_id" name="project_id" type="text" class="form-control"  value="" required/>
       </div>
                      
                      
                       <div class="form-group">
                        <label for="project_subject">Project Title*</label>
                        <input id="project_subject" name="project_subject" type="text" class="form-control"  value="" required/>
                      </div>
                      
                    <div class="row">
                    <div class="col-md-6">  
                      <div class="form-group">
                        <label for="project_amount">Project Amount*</label>
                        <input id="project_amount" name="project_amount" type="text" class="form-control"  value="" required/>
                      </div>
                    </div>
                    <div class="col-md-6">    
                      <div class="form-group">
                        <label for="project_amount">Received Amount*</label>
                        <input id="received_amount" name="received_amount" type="text" class="form-control"  value="" required/>
                      </div>
                      </div>
                   </div>   
                      
                      <div class="col-md-6">
                        	<div class="row form-group">
                              <label class="col-md-4">Start Date</label>
                              <div class="col-xs-4" id="todate">
                                   <div class="input-group"><input type="text" readonly style="cursor:pointer;" name="start_date" id="start_date" class="form-control" required />
                                   <span class="input-group-addon"><span id="targetto" onclick="create_date('todate')" class="glyphicon glyphicon-calendar" style="cursor:pointer;"></span></span>
	                        </div>
                            </div>
                             
                            </div>
                      </div>
                      
                      
            <div class="col-md-6">
                    <div class="row form-group">
                      <label class="col-md-4 text-right">End Date</label>
                      <div class="col-xs-4">
                        <div class="input-group" id="fromdate">
                        <input type="text" readonly style="cursor:pointer;" name="end_date" id="end_date" class="form-control" required /><span class="input-group-addon"><span id="target" onclick="create_date('fromdate')" class="glyphicon glyphicon-calendar" style="cursor:pointer;"></span></span>
                    </div>
                    </div>
                      
                     
                    </div>
            </div>
                      
                       
                      
                      <div class="form-group">
                      <label for="project_detail">Project Details*</label>
                      <textarea class="form-control" id="project_detail" name="project_detail" rows="10" ></textarea>
                      </div>
                    
                    
                     <div class="form-group">
                        <label for="live_url">Live URL</label>
                        <input id="live_url" name="live_url" type="text" class="form-control"  value="" placeholder="http://www.liveurl.com" />
                      </div>
                      
                       <div class="form-group">
                        <label for="local_url">Local URL</label>
                        <input id="local_url" name="local_url" type="text" class="form-control"  value="" placeholder="http://www.localurl.com"/>
                      </div>
                      
                      
                        <div class="form-group">
                        <label for="design_url">Design URL</label>
                        <input id="design_url" name="design_url" type="text" class="form-control"  value="" placeholder="http://www.design.com" />
                      </div>
                      
                      
                      <div class="form-group">
                        <label for="prototype_url">Prototype URL</label>
                        <input id="prototype_url" name="prototype_url" type="text" class="form-control"  value="" placeholder="http://www.prototype.com" />
                      </div>
                    
                  <div class="row form-group">
                        <div class="col-md-5">
                          <label for="standard-list1">Default Users</label>
                           <select id="default_users" name="default_users" class="form-control" onChange="get_users_ajax(this.value)">
                           <option value="">Select Default Users</option>
                                <?php 
								if(count($project_defauls_user_arr)>0){
								for($c=0; $c < count($project_defauls_user_arr) ; $c++){ ?>
										<option value="<?php echo $project_defauls_user_arr[$c]['setting_value'] ?>"><?php echo $project_defauls_user_arr[$c]['setting_name']; ?></option>
								<?php }} ?>
                          </select>
                      
                   </div>
                   </div>
                   
                    <span id="ajax_response">
                    </span>
                    <div class="clearfix" style="margin-top: 26px;"></div>
                   
                    <div class="form-group">
                      <label for="project_assign">Project Assign*</label>
                    </div>
                      
          <select name="project_assign[]" id="project_assign" data-placeholder="Choose a name..." class="chosen-select" multiple style="width:350px;" tabindex="4">
            <option value=""></option>
            
            <?php  for($i=0; $i<$users_list_count; $i++) {?>
            
            <option value="<?php echo $users_list_arr[$i]['id'] ?>"><?php echo $users_list_arr[$i]['first_name']." ".$users_list_arr[$i]['last_name']; ?></option>
            
            <?php } ?>
          </select>
                 <br>
<br>


                     <div class="row form-group">
                        <div class="col-md-5">
                          <label for="standard-list1">Status</label>
                            <select class="form-control" id="status" name="status">
                            <option value="0" selected >New</option>
                            <option value="1" >InProgress</option>
                             <option value="2">Cancel</option>
                            <option value="3" >Closed</option>
                        </select>
                        </div>
                    </div> 
                    
                    
                     <div class="row form-group">
                        <div class="col-md-5">
                          <label for="standard-list1">Is Awarded</label>
                            <select class="form-control" id="is_awarded" name="is_awarded" required>
                            <option value="" selected >Select</option>
                            <option value="1" >Yes</option>
                             <option value="0">No</option>
                        </select>
                        </div>
                    </div> 
                    
                    
                      <div class="form-group">
                        <label for="project_label">Project Label</label>
                        <input id="project_label" name="project_label" type="text" class="form-control"  value="<?php echo stripcslashes(strip_tags($project_detail_arr['project_label'])); ?>" />
                      </div>
                    
                     <div class="form-group">
                       <label for="page_title">Attachments </label>
						 <input type="file" id="attachments" name="attachments[]">
                         <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> 
                                - Allowed Extensions:   jpg, jpeg, gif, tiff, png, doc, zip, rar, pdf, docx, odt, xlsx, csv, pptx
                            </span>
                            <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> 
                                Max Upload Size: 15MB;
                            </span>
                         
                     </div>
                   
                    <div id="item"></div> 
                    <div><button type="button" class="btn btn-blue" onClick="add_layer_html(this.form);">Add More</button></div>
                      
                    
                    <div class="clearfix" style="  padding-bottom: 31px;"></div>
                    
                    <div class="form-group">
                        <label for="milestones">Milestone 1</label>
                        <input id="milestones" name="milestones[]" type="text" class="form-control"  value="" placeholder="Enter Milestone 1" />
                    </div>  
                    
                    <div id="milestone_item"></div> 
                    <div><button type="button" class="btn btn-blue" onClick="add_layer_html_milestone(this.form);">Add More</button></div>
                      
                      
                                                  
                </div>
                  
                    <div class="form-group" align="right" style="margin-right:17px">
                        <input class="submit btn btn-blue" type="submit" name="submit" id="submit" value="Add New Project" />
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
$(document).ready(function() { $("#branch").select2(); });
</script>
<script>
$(document).ready(function() { $("#e1").select2(); });
</script>
<script>
$(document).ready(function() { $("#forum_id").select2(); });
</script>


<script type="text/javascript">
      jQuery(document).ready(function() {
    
      // validate signup form on keyup and submit
        $("#edit_admin_profile_frm").validate({
            rules: {
				first_name : 'required',
				last_name : 'required',
				
                project_detail: "required",
				username: {
					required: true,
					minlength: 5,
					 maxlength: 20
				},
				email_address: {
					required: false,
					email: true
				},
				live_url: {
					required: false,
					url: true
				},
				local_url: {
					required: false,
					url: true
				},
				design_url: {
					required: false,
					url: true
				},
				prototype_url: {
					required: false,
					url: true
				},
				prof_image: {
					required: false,
					extension: "jpg|jpeg|gif|tiff|png"
				}				
				
            },
            messages: {
                project_detail: "This field is required.",
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
    
<script type='text/javascript'>
        var rowNum = 0;
function add_layer_html(frm) {
 rowNum ++;
 var row = '<div id="rowNum'+rowNum+'"><div class="form-group"><label for="page_title">Attachments </label><input type="file" id="attachments" name="attachments[]"></div><input type="button" class="btn btn-danger" value="Remove" onclick="removeRow('+rowNum+');" style="margin-left:15px;"><div class="clearfix">&nbsp;</div><div class="clearfix">&nbsp;</div></div></div>';
 jQuery('#item').append(row);
}

function removeRow(rnum) {
 jQuery('#rowNum'+rnum).remove();
}

</script> 

   


<script type='text/javascript'>
        var rowNum = 1;
		
function add_layer_html_milestone(frm) {
 rowNum ++;
 var row = '<div id="rowNum'+rowNum+'"><div class="form-group"><label for="milestones">Milestone '+rowNum+' </label><input id="milestones" name="milestones[]" type="text" class="form-control"  value="" placeholder="Enter Milestone '+rowNum+'" /></div><input type="button" class="btn btn-danger" value="Remove" onclick="removeRow('+rowNum+');" style="margin-left:15px;"><div class="clearfix">&nbsp;</div><div class="clearfix">&nbsp;</div></div></div>';
 jQuery('#milestone_item').append(row);
}

function removeRow(rnum) {
 jQuery('#rowNum'+rnum).remove();
 
 
}

</script> 

<script>

function get_users_ajax(ids){
 //document.getElementById('state_response').innerHTML = "<img class='loading' src='<?php echo IMG ; ?>select2-spinner.gif' alt='loading...' />";
 var request_url = "<?php echo SURL ; ?>projects/manage-projects/get-users-ajax?ids="+ids;
 jQuery.post(
  request_url, {flag : true}, function(responseText){
  
 
  jQuery("#ajax_response").html('<input  name="names" type="text" readonly class="form-control"  value="'+responseText+'" />');
  
 
  }, "html"
 );
}//end check_nic_exist


</script>   
    

</body>
</html>
