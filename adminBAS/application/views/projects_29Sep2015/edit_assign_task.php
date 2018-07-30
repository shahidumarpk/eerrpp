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
<style type="text/css">
.btn{color: rgb(95, 92, 92);}
.my{color: rgb(249, 247, 247);}
.btn:hover {
  color: #333;
  background-image: -webkit-linear-gradient(top, rgba(255, 255, 255, 0.13) 1%, rgba(255, 255, 255, 0.13) 100%);
  background-image: linear-gradient(to bottom, rgba(255, 255, 255, 0.13) 1%, rgba(255, 255, 255, 0.13) 100%); }

</style>
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
              <div class="panel-title"> <span class="glyphicon glyphicon-book"></span>Edit Assign Task</div>
            </div>
            <div class="panel-body alerts-panel">
              <form class="cmxform" id="edit_admin_profile_frm" method="POST" action="<?php echo SURL?>projects/manage-projects/edit-assign-task-process" enctype="multipart/form-data">
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
                    
                     <!-- <div class="row form-group" id="projectteam">
                        <div class="col-md-5">
                          <label for="standard-list1">Team</label>
                          <span id="state_response">
                         <select name="task_assign[]" id="user_id" data-placeholder="Choose a name..." class="chosen-select" multiple style="width:350px;" tabindex="4">
          <?php  for($i=0; $i<$users_list_count; $i++) {?>
            
            <option value="<?php echo $users_list_arr[$i]['id'] ?>"><?php echo $users_list_arr[$i]['first_name']." ".$users_list_arr[$i]['last_name']; ?></option>
            
            <?php } ?>
            
          </select> </span>  
                        </div>
                    </div>--->
                    
                      <div class="row form-group">
                        <div class="col-md-5">
                          <label for="standard-list1">MileStone</label>
                            <select class="form-control" id="milestone" name="milestone">
                           <?php
							   
							   for($i=1; $i<=5; $i++){ 
							   
							    ?> 
                                 
                            <option value="<?php echo $i; ?>" <?php if($assign_task_arr['milestone']== $i) { ?> selected <?php  }  ?>><?php echo $i;?></option>
                            
                            
                          <?php  } ?>  
                        </select>
                        </div>
                       </div> 
                      
                       <div class="form-group">
                        <label for="title">Title*</label>
                        <input id="title" name="title" type="text" class="form-control"  value="<?php echo $assign_task_arr['title']; ?>" required/>
                      </div>
                      
                   
                      
                      <div class="col-md-6">
                        	<div class="row form-group">
                              <label class="col-md-4">Start Date</label>
                              <div class="col-xs-6" id="todate">
                                   <div class="input-group"><input type="text"  style="cursor:pointer;" name="start_date" id="start_date" class="form-control" required value="<?php echo  date("m/d/Y  h:i:s a", strtotime($assign_task_arr['start_date'])); ?>" /><span class="input-group-addon"><span id="targetto" onclick="create_date_time('todate')" class="glyphicon glyphicon-calendar" style="cursor:pointer;"></span></span>
	                        </div>
                            </div>
                             
                            </div>
                      </div>
                      
                      
                    <div class="col-md-6">
                        	<div class="row form-group">
                              <label class="col-md-4 text-right">End Date</label>
                              <div class="col-xs-6">
                                <div class="input-group" id="fromdate">
                            	<input type="text"  style="cursor:pointer;" name="end_date" id="end_date" class="form-control" required  value="<?php echo  date("m/d/Y h:i:s a", strtotime($assign_task_arr['end_date'])); ?>"/><span class="input-group-addon"><span id="target" onclick="create_date_time('fromdate')" class="glyphicon glyphicon-calendar" style="cursor:pointer;"></span></span>
	                        </div>
                            </div>
                              
                             
                            </div>
                    </div>
                      
                      
                 
                      
                    <div class="form-group">
                      <label for="description">Description</label>
                      <textarea class="form-control" id="description" name="description" rows="10" ><?php 
					  
					  echo stripcslashes(strip_tags($assign_task_arr['description'])); ?></textarea>
                      </div>
                    

                     <div class="row form-group">
                        <div class="col-md-5">
                          <label for="standard-list1">Status</label>
                            <select class="form-control" id="status" name="status">
                            <option value="0" <?php if($assign_task_arr['status']==0){ ?> selected <?php } ?> >New</option>
                            <option value="1" <?php if($assign_task_arr['status']==1){ ?> selected <?php } ?>>Start</option>
                            <option value="2" <?php if($assign_task_arr['status']==2){ ?> selected <?php } ?>>Hold</option>
                            <option value="3" <?php if($assign_task_arr['status']==3){ ?> selected <?php } ?>>Closed</option>
                        </select>
                        </div>
                    </div> 
                    
                     <div class="form-group">
                        <label for="page_title">Attachments </label><br>
                        
                        <?php  
						for($i=0; $i<$assign_task_attachments_count; $i++){ 
						if($assign_task_attachments[$i]['attachment_name'] != ""){
				 	     $ext = pathinfo($assign_task_attachments[$i]['attachment_name'], PATHINFO_EXTENSION) ;
						
						if($ext==jpg){
						?>
                        <img src="<?php  echo MURL."assets/project_attachments/".$assign_task_arr['project_id']."/project_task/".$assign_task_attachments[$i]['attachment_name'] ?>" width="80" height="90" />

						<?php  } else{ 
						
						echo "<strong>".$assign_task_attachments[$i]['attachment_name']."</strong>";
							
							
							}?>
							
						<a href="<?php echo base_url().'projects/manage-projects/delete_assign_task_attachment/'.$assign_task_arr['id'].'/'.$assign_task_attachments[$i]['id'] ?>" onClick="return confirm('Are you sure you want to delete?')" ><span class="btn btn-danger" >Delete</span></a>  	
						
					<?php	}
					} // End $project_attachments_arr[$i]['attachment_name']
						?>
                        
<br>
<br>   
                      </div>
                    
                    
                     <div class="form-group">
                       <label for="page_title">Add New Attachment </label>
                       
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
                      
                      
                      
                      
                                                  
                </div>
                  
                  <input type="hidden" name="assign_task_id" value="<?php echo $assign_task_id; ?>" >
                   <input type="hidden" name="project_id" value="<?php echo  $assign_task_arr['project_id']; ?>" >
                    <div class="form-group" align="right" style="margin-right:17px">
                        <input class="submit btn btn-blue" type="submit" name="edit_assing_task_sbt" id="edit_assing_task_sbt" value="Edit Assign Task" title="Click to Update Assign Task" />
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
    

</body>
</html>
