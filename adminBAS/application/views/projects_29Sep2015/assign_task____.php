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
<style>
		.droppable {
			border: #ccc 1px solid;
			border-radius: 8px;
			background: #eee;
			color: #666;
			padding: 20px;
			margin: 10px;
			clear: both;
			text-align: center;
		}

		.droppable.hover {
			background: #ddd;
		}

		.uploadList {
			margin: 0;
			padding: 0;
			list-style: none;
		}

		.uploadItem {
			overflow: hidden;
			border-bottom: #BCBCBC 1px solid;
			margin: 0 20px;
			padding: 3px;
		}

		.uploadItem span {
			overflow: hidden;
			width: 150px;
			float: left;
			display: block;
		}

		a.addInputRow,
		a.delInputRow,
		.uploadItem a {
			display: inline-block;
			background: url(Demos/add.png) no-repeat;
			height: 16px;
			width: 16px;
			text-indent: -999px;
		}

		.uploadItem a {
			float: left;
			display: block;
			padding-left: 20px;
			background-image: url(<?php echo SURL?>assets/img/delete.png);
		}

		a.delInputRow {
			background-image: url(img/delete.png);
		}

		.progress {
			margin: 5px 0;
			height: 15px;
			border-radius: 3px;
			background: #545A74;
		}
</style>

<style type="text/css">
.btn{color: rgb(95, 92, 92);}
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
        <div class="col-md-12" style="min-height:1280px;">
          <div class="panel">
            <div class="panel-heading">
              <div class="panel-title"> <span class="glyphicon glyphicon-book"></span>Assign Task</div>
            </div>
            <div class="panel-body alerts-panel">
              <form class="cmxform" id="edit_admin_profile_frm" method="POST" action="<?php echo SURL?>projects/manage-projects/assign-task-process" enctype="multipart/form-data">
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
                    
                     <?php if(!isset($project_id)) { ?>
                     
                     <div class="row form-group">
                        <div class="col-md-5">
                          <label for="standard-list1">projects</label>
                            <select style="width:100%;" id="project_id" name="project_id" onChange="get_team(this.value)" required >
								<option value="0">Select Project</option>
                            	<?php 
									for($i=0;$i<$projects_count;$i++){
								?>
                            			<option value="<?php echo $projects_arr[$i]['id']?>"><?php echo $projects_arr[$i]['project_title']?></option>    
                                <?php		
									}//end for
								?>
                            
                        </select>
                        </div>
                    </div>
                    
                      
                      <?php  }  ?>
                      
                      
                      
                      <?php  if(isset($project_id)){ ?>
						  
						<div class="row form-group" id="projectteam">
                        <div class="col-md-5">
                          <label for="standard-list1">Team</label>
                          <span id="state_response">
                         <select name="task_assign[]" id="user_id" data-placeholder="Choose a name..." class="chosen-select" multiple style="width:350px;" tabindex="4">
          <?php  for($i=0; $i<count($team_arr); $i++) {?>
            
            <option value="<?php echo $team_arr[$i]['id'] ?>"><?php echo $team_arr[$i]['name']; ?></option>
            
            <?php } ?>
            
          </select> </span>  
                        </div>
                    </div>  
						  
					<?php	} ?>
                      
                      
                      <div class="row form-group" id="project_team">
                        <div class="col-md-5">
                          <label for="standard-list1">Team</label>
                          <span id="state_response">
                         <select name="task_assign[]" id="user_id" data-placeholder="Choose a name..." class="chosen-select" multiple style="width:350px;" tabindex="4">
         
          </select> </span>  
                        </div>
                    </div>
                      
                      
                       <div class="row form-group">
                        <div class="col-md-5">
                          <label for="standard-list1">MileStone</label>
                            <select class="form-control" id="milestone" name="milestone">
                           <?php
							   
							   for($i=1; $i<=5; $i++){ 
							   
							    ?> 
                                 
                            <option value="<?php echo $i; ?>"><?php echo $i;?></option>
                            
                            
                          <?php  } ?>  
                        </select>
                        </div>
                       </div> 
                      
                       <div class="form-group">
                        <label for="title">Title*</label>
                        <input id="title" name="title" type="text" class="form-control"  value="" required/>
                      </div>
                      
                   
                      
                      <div class="col-md-6">
                        	<div class="row form-group">
                              <label class="col-md-4">Start Date</label>
                              <div class="col-xs-6" id="todate">
                                   <div class="input-group"><input type="text" readonly style="cursor:pointer;" name="start_date" id="start_date" class="form-control" required /><span class="input-group-addon"><span id="targetto" onclick="create_date_time('todate')" class="glyphicon glyphicon-calendar" style="cursor:pointer;"></span></span>
	                        </div>
                            </div>
                             
                            </div>
                      </div>
                      
                      
                    <div class="col-md-6">
                        	<div class="row form-group">
                              <label class="col-md-4 text-right">End Date</label>
                              <div class="col-xs-6">
                                <div class="input-group" id="fromdate">
                            	<input type="text" readonly style="cursor:pointer;" name="end_date" id="end_date" class="form-control" required /><span class="input-group-addon"><span id="target" onclick="create_date_time('fromdate')" class="glyphicon glyphicon-calendar" style="cursor:pointer;"></span></span>
	                        </div>
                            </div>
                              
                             
                            </div>
                    </div>
                      
                      
                      <div class="form-group">
                      <label for="description">Description</label>
                      <textarea class="form-control" id="description" name="description" rows="10" ></textarea>
                      </div>
                    

                    
                     <div class="form-group">
                       <label for="page_title">Attachments </label>
                        <div class="formRow">
                            <input type="file" id="attachments" name="attachments[]" multiple><br>
                        </div>
                       
                           <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> 
                                - Allowed Extensions:   jpg, jpeg, gif, tiff, png, doc, zip, rar, pdf, docx, odt, xlsx, csv
                            </span>
                            <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> 
                                Max Upload Size: 15MB;
                            </span>
                         
                  </div>
                   
                    <div id="item"></div> 
                    <div><button type="button" class="btn btn-blue" onClick="add_layer_html(this.form);">Add More</button></div>
                      
                      
                      
                      
                                                  
                </div>
                   
                     <?php if(isset($project_id)) { ?>  
                     <input type="hidden" name="project_id" value="<?php echo $project_id; ?>" >
                     <?php  } ?>
                    <div class="form-group" align="right" style="margin-right:17px">
                        <input class="submit btn btn-blue" type="submit" name="assing_task_sbt" id="assing_task_sbt" value="Assign Task" title="Click to Assign Task" />
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
$(document).ready(function() { $("#project_id").select2(); $("#user_id").select2(); $("#city_name").select2(); $("#branch").select2(); });
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
	
$('#project_team').hide();
	
	
function get_team(project_id){
	
$('#project_team').show();	
	
 document.getElementById('state_response').innerHTML = "<img class='loading' src='<?php echo IMG ; ?>select2-spinner.gif' alt='loading...' />";
 var request_url = "<?php echo SURL ; ?>projects/manage-projects/get_team_list/"+project_id;
 jQuery.post(
  request_url, {flag : true}, function(responseText){
  
  var split_response = responseText.split('|'); 	  
 

 
  jQuery("#state_response").html(split_response);
  $("#user_id").select2();

  
 
  }, "html"
 );
}//end check_nic_exist	
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
    
<script src="<?php echo JS?>mootools.js"></script>
<script src="<?php echo JS?>Form.MultipleFileInput.js"></script>
<script src="<?php echo JS?>Form.Upload.js"></script>
<script src="<?php echo JS?>Request.File.js"></script>
<script src="<?php echo JS?>iFrameFormRequest.js"></script>
<script>
		window.addEvent('domready', function(){

			var upload = new Form.Upload('attachments', {
				dropMsg: "Drop files here",
				onComplete: function(){
					
				}
			});

			// using iFrameFormRequest from the forge to upload the files
			// in an IFrame.
			if (!upload.isModern()) {
				new iFrameFormRequest('http://192.168.1.13/projects/erp/adminBAS/projects/manage-projects/assign-task-process', {
					onComplete: function(response){
						alert('Completed uploading the files');
					}
				});
			}

		});
		
</script>
</body>
</html>
