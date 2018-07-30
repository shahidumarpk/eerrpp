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
              <div class="panel-title"> <span class="glyphicon glyphicon-book"></span>Edit Project</div>
            </div>
            <div class="panel-body alerts-panel">
              <form class="cmxform" id="edit_admin_profile_frm" method="POST" action="<?php echo SURL?>projects/manage_projects/edit_project_process" enctype="multipart/form-data">
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
										<option value="<?php echo $branches_arr[$c]['id'] ?>" <?php if($project_detail_arr['branch_id']==$branches_arr[$c]['id']){ ?> selected <?php }  ?>><?php echo $branches_arr[$c]['branch_name'];?></option>
								<?php }} ?>
                          </select>
                        </div>
                    </div>
                   
                   <div class="row form-group">
                        <div class="col-md-5">
                          <label for="standard-list1">Customer Name</label>
                           <select id="e1" name="customer_id" style="width:100%;">
                                <?php 
								for($c=0; $c < $customers_list_count ; $c++){ ?>
										<option value="<?php echo $customers_list_arr[$c]['id'] ?>" <?php if($customers_list_arr[$c]['id']==$project_detail_arr['customer_id']) {  ?> selected <?php  }  ?>><?php echo $customers_list_arr[$c]['first_name'].' '.$customers_list_arr[$c]['last_name'] ; ?></option>
								<?php } ?>
                                </select>
                        </div>
                        
                        
                         <div class="col-md-5">
                          <label for="standard-list1">Forum Name</label>
                           <select id="forum_id" name="forum_id" style="width:100%;">
                           <option value="0">None</option>
                                <?php 
								if($forums_list_count>0){
								for($c=0; $c < $forums_list_count ; $c++){ ?>
										<option value="<?php echo $forums_list_arr[$c]['id'] ?>" <?php if($project_detail_arr['forum_id']==$forums_list_arr[$c]['id']) { ?> selected <?php  }  ?>><?php echo $forums_list_arr[$c]['forum_name']; ?></option>
								<?php }} ?>
                          </select>
                        </div>
                        
                    </div>
                    
                    
                      <div class="form-group">
                        <label for="project_id">Project ID*</label>
                        <input id="project_id" name="project_id" type="text" class="form-control"  value="<?php echo $project_detail_arr['project_id']; ?>" required/>
                      </div>
                      
                      
                       <div class="form-group">
                        <label for="project_subject">Project Title*</label>
                        <input id="project_subject" name="project_subject" type="text" class="form-control"  value="<?php echo $project_detail_arr['project_title']; ?>" required/>
                      </div>
                      
                      
                       <div class="row">
                    <div class="col-md-6">  
                      <div class="form-group">
                        <label for="project_amount">Project Amount*</label>
                        <input id="project_amount" name="project_amount" type="text" class="form-control"  value="<?php echo $project_detail_arr['project_amount']; ?>" required/>
                      </div>
                    </div>
                    <div class="col-md-6">    
                      <div class="form-group">
                        <label for="project_amount">Received Amount*</label>
                        <input id="received_amount" name="received_amount" type="text" class="form-control"  value="<?php echo $project_detail_arr['received_amount']; ?>" required/>
                      </div>
                      </div>
                   </div>   
                      
                      
                      
                       <div class="col-md-6">
                        	<div class="row form-group">
                              <label class="col-md-4">Start Date</label>
                              <div class="col-xs-5" id="todate">
                              
          <div class="input-group"><input type="text"   readonly="readonly"  style="cursor:pointer;" 
          name="start_date" id="start_date" class="form-control"  
          value="<?php echo date("m/d/Y", strtotime($project_detail_arr['start_date']));?>"/>
          <span class="input-group-addon"><span id="targetto" onclick="create_date('todate')" 
          class="glyphicon glyphicon-calendar" style="cursor:pointer;"></span></span>
	                        </div>
                            </div>
                             
                            </div>
                      </div>
                      
                      
                    <div class="col-md-6">
                        	<div class="row form-group">
                              <label class="col-md-4 text-right">End Date</label>
                              <div class="col-xs-5">
                                <div class="input-group" id="fromdate">
                            	<input type="text"  readonly="readonly" style="cursor:pointer;" name="end_date" id="end_date" class="form-control" required value="<?php echo date("m/d/Y", strtotime($project_detail_arr['end_date']));?>"   /><span class="input-group-addon"><span id="target" onclick="create_date('fromdate')" class="glyphicon glyphicon-calendar" style="cursor:pointer;"></span></span>
	                        </div>
                            </div>
                              
                             
                            </div>
                    </div>
                      
                      
                      
                      <div class="form-group">
                      <label for="project_detail">Project Details*</label>
       <textarea class="form-control" id="project_detail" name="project_detail" rows="10"><?php echo stripcslashes(strip_tags($project_detail_arr['project_detail'])); ?></textarea>
                     
                     </div>
                     
                     
                     <div class="form-group">
                        <label for="live_url">Live URL</label>
                        <input id="live_url" name="live_url" type="text" class="form-control"  value="<?php echo stripcslashes(strip_tags($project_detail_arr['live_url'])); ?>" placeholder="http://www.google.com" />
                      </div>
                      
                       <div class="form-group">
                        <label for="local_url">Local URL</label>
                        <input id="local_url" name="local_url" type="text" class="form-control"  value="<?php echo stripcslashes(strip_tags($project_detail_arr['local_url'])); ?>" placeholder="http://www.google.com" />
                      </div>
                      
                         <div class="form-group">
                        <label for="design_url">Design URL</label>
                        <input id="design_url" name="design_url" type="text" class="form-control"  value="<?php echo stripcslashes(strip_tags($project_detail_arr['design_url'])); ?>"  placeholder="http://www.google.com"/>
                      </div>
                      
                      
                        <div class="form-group">
                        <label for="prototype_url">Prototype URL</label>
                        <input id="prototype_url" name="prototype_url" type="text" class="form-control"  value="<?php echo stripcslashes(strip_tags($project_detail_arr['prototype_url'])); ?>"  placeholder="http://www.google.com"/>
                      </div>
                      
                     
                    <div class="form-group">
                      <label for="project_assign">Project Assign*</label>
                    </div>
            <?php $project_assign_arr = explode(',',$project_detail_arr['project_assign']); ?>          
          <select name="project_assign[]" id="project_assign" data-placeholder="Choose a name..." class="chosen-select" multiple style="width:350px;" tabindex="4">
            <option value=""></option>
            <?php 
			for($i=0; $i<$users_list_count; $i++) {
		
			?>
            <option value="<?php echo $users_list_arr[$i]['id'] ?>" <?php if(in_array($users_list_arr[$i]['id'],$project_assign_arr)){ ?> selected <?php  } ?>  ><?php echo $users_list_arr[$i]['first_name']." ".$users_list_arr[$i]['last_name']; ?></option>
            <?php } ?>
            
          </select>
                 <br>
<br>
                     <div class="row form-group">
                        <div class="col-md-5">
                          <label for="standard-list1">Status</label>
                            <select class="form-control" id="status" name="status">
                            <option value="0" <?php if($project_detail_arr['status']==0){  ?> selected <?php }?>>New</option>
                            <option value="1" <?php if($project_detail_arr['status']==1){  ?> selected <?php }?> >InProgress</option>
                            
                            <?php if($project_detail_arr['status']==3){ ?>
                            <option value="3" <?php if($project_detail_arr['status']==3){  ?> selected <?php }?> >Closed</option>
                            <?php  }  ?>
                                                     </select>
                        </div>
                    </div> 
                    
                      <div class="row form-group">
                        <div class="col-md-5">
                          <label for="standard-list1">Is Awarded</label>
                            <select class="form-control" id="is_awarded" name="is_awarded" required>
                            <option value="1" <?php if($project_detail_arr['is_awarded']==1){  ?> selected <?php }?>>Yes</option>
                             <option value="0" <?php if($project_detail_arr['is_awarded']==0){  ?> selected <?php }?>>No</option>
                        </select>
                        </div>
                    </div> 
                    
                    
                      <div class="form-group">
                        <label for="project_label">Project Label</label>
                        <input id="project_label" name="project_label" type="text" class="form-control"  value="<?php echo stripcslashes(strip_tags($project_detail_arr['project_label'])); ?>" />
                      </div>
                      
                      
                       <div class="form-group">
                        <label for="project_rating">Project Rating</label>
                        <input id="project_rating" name="project_rating" type="text" class="form-control"  value="<?php echo stripcslashes(strip_tags($project_detail_arr['project_rating'])); ?>" />
                      </div>
                    
                     <div class="form-group">
                      <label for="project_detail">Project Feedback</label>
       <textarea class="form-control" id="project_feedback" name="project_feedback" rows="5"><?php echo stripcslashes(strip_tags($project_detail_arr['feedback'])); ?></textarea>
                     
                     </div>
                     
                    
                    
                    
                     <div class="form-group">
                        <label for="page_title">Attachments </label><br>
                        
                        <?php  
						for($i=0; $i<$project_attachments_count; $i++){ 
						if($project_attachments_arr[$i]['attachment_name'] != ""){
				 	     $ext = pathinfo($project_attachments_arr[$i]['attachment_name'], PATHINFO_EXTENSION) ;
						
						if($ext==jpg){
						?>
                        <img src="<?php  echo MURL."assets/project_attachments/".$project_detail_arr['id']."/".$project_attachments_arr[$i]['attachment_name'] ?>" width="80" height="90" />

						<?php  } else{ 
						
						echo "<strong>".$project_attachments_arr[$i]['attachment_name']."</strong>";
							
							
							}?>
							
						<a href="<?php echo base_url().'projects/manage-projects/delete_project_attachment/'.$project_detail_arr['id'].'/'.$project_attachments_arr[$i]['id'] ?>" onClick="return confirm('Are you sure you want to delete?')" ><span class="btn btn-danger" >Delete</span></a>  	
						
					<?php	}
					} // End $project_attachments_arr[$i]['attachment_name']
						?>
                        
<br>
<br>   
                      </div>
                    
<br>


                     <div class="form-group">
                      <label for="project_detail">Add New Attachments</label>
                     
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
                     
                     
                     <?php if($project_milestones_count >0){
						 
						 $sr=0;
						 for($i=0; $i<$project_milestones_count; $i++){
						 $sr++;
						  ?>
                    
                    <div class="form-group">
                        <label for="milestones">Milestone <?php echo $sr; ?></label>
                        <input id="milestones" name="milestones[]" type="text" class="form-control"  value="<?php echo $project_milestones_arr[$i]['milestone_name']; ?>"  />
                     <input id="milestone_id" name="milestones_id[]" type="hidden" class="form-control"  value="<?php echo $project_milestones_arr[$i]['id']; ?>"  />
                        
                    </div> 
                    
                   <?php  } }else{ ?> 
                   
                   
                    <div class="form-group">
                        <label for="milestones">Milestone </label>
                        <input id="milestones" name="new_milestones[]" type="text" class="form-control"  value=""  />
                    </div> 
                   
                   
                   
                   <?php  } ?>
                    
                    <div id="milestone_item"></div> 
                    <div><button type="button" class="btn btn-blue" onClick="add_layer_html_milestone(this.form);">Add More</button></div>
                      
                                                  
                  </div>
                  <input type="hidden" name="id" value="<?php echo $project_id ?>" >
                    <div class="form-group" align="right" style="margin-right:17px">
                        <input class="submit btn btn-blue" type="submit" name="update" id="update" value="Update" />
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
$(document).ready(function() { $("#branch").select2(); });
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
 var row = '<div id="rowNum'+rowNum+'"><div class="form-group"><label for="milestones">Milestone</label><input id="milestones" name="new_milestones[]" type="text" class="form-control"  value="" placeholder="Enter Milestone" /></div><input type="button" class="btn btn-danger" value="Remove" onclick="removeRow('+rowNum+');" style="margin-left:15px;"><div class="clearfix">&nbsp;</div><div class="clearfix">&nbsp;</div></div></div>';
 jQuery('#milestone_item').append(row);
}

function removeRow(rnum) {
 jQuery('#rowNum'+rnum).remove();
 
 
}

</script>    
    

</body>
</html>
