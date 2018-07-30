<?php 
$session_post_data = $this->session->userdata('add-page-data');

					
	
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

<link rel="stylesheet" href="<?php echo SURL; ?>assets/css/chosen.css">
<style type="text/css">
.timepicker .btn{color: rgb(95, 92, 92); margin-left: -5px;}
.btn:hover {
  color: #333;
  background-image: -webkit-linear-gradient(top, rgba(255, 255, 255, 0.13) 1%, rgba(255, 255, 255, 0.13) 100%);
  background-image: linear-gradient(to bottom, rgba(255, 255, 255, 0.13) 1%, rgba(255, 255, 255, 0.13) 100%); }

</style>
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
          
        </div>
      </div>
       
      <div class="row">
        <div class="col-md-12" style="min-height:900px;">
          <div class="panel">
            <div class="panel-heading">
              <div class="panel-title"> <span class="glyphicon glyphicon-book"></span> Edit Attendance  </div>
              
            </div>
            <div class="panel-body alerts-panel">
                <div class="tab-content border-none padding-none">
                    
               <form class="cmxform" id="add_new_user_frm" method="POST" action="<?php echo SURL?>attendance/manage-attendance/edit-attendance-process" enctype="multipart/form-data"> 
                    
                 
                    <div class="row form-group">
                        <div class="col-md-5">
                            <select id="user_id" name="user_id" style="width:100%;"  required placeholder="Select User">
                         
                                <?php
								
								$selected = '';
							if($users_count >0){ 
								for($c=1; $c <=$users_count;   $c++){
									
								$selected = ($attendance_data_arr['emp_code'] == $users_arr[$c]['id']  ) ? 'selected = "selected"':'';
									
									 ?>
                                
                                
                                
                                
                                
										<option <?php echo $selected;?> value="<?php echo $users_arr[$c]['id'] ?>"><?php echo $users_arr[$c]['first_name']." ".$users_arr[$c]['last_name'];?></option>
								<?php }} ?>
                          </select>  
                        </div>
                    </div>
                <div class="clearfix">&nbsp;</div>
                 <div class="row">
                 <div class="col-md-4">
                    <div class="row form-group">
                              <label class="col-md-2">Date</label>
                              <div class="col-xs-4" id="todate">
                                   <div class="input-group"><input type="text" readonly style="cursor:pointer;" name="date" id="date" class="my-control" 
                                    value="<?php 
		   echo  date('m/d/Y',strtotime($attendance_data_arr['attend_date']));?>"  required /><span class="input-group-addon"><span id="targetto" onclick="create_date('todate')" class="glyphicon glyphicon-calendar" style="cursor:pointer;"></span></span>
	                        </div>
                            </div>
                             
                            </div>
                           
                </div>
                 <div  class="col-md-4">
                <div class="row form-group">
                              <label class="col-md-2">InTime</label>
                              <div id="intime" class=" col-md-10 input-append">
                                <input data-format="hh:mm:ss" type="text" name="intime" class="my-control" value="<?php  echo  date("g:i:s", strtotime($attendance_data_arr['time_in'])) ?>" required ></input>
                                <span class="add-on">
                                  <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                  </i>
                                </span>
                     </div>
                 </div>   
                     
                  </div>
                 <div  class="col-md-4">
                 <div class="row form-group">
                              <label class="col-md-3">OutTime</label>
                              <div id="outtime" class="col-md-9 input-append">
                                <input data-format="hh:mm:ss" type="text" name="outtime" class="my-control"  value="<?php   date("g:i:s", strtotime($attendance_data_arr['time_out'])) ?>" ></input>
                                <span class="add-on">
                                  <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                  </i>
                                </span>
                     </div>
                             
                     </div>
                 </div> 
                 
                  </div>
                  
              <div class="clearfix">&nbsp;</div>
                  
                   <div class="row form-group">
                        <div class="col-md-5">
                          <label for="standard-list1">Status</label>
                            <select class="form-control" id="status" name="status">
                            <option value="P" <?php echo ($attendance_data_arr['astatus'] == 'P') ? 'selected' : ''?> >Present</option>
                            <option value="A" <?php echo ($attendance_data_arr['astatus'] == 'A') ? 'selected' : ''?>>Absent</option>
                            <option value="L" <?php echo ($attendance_data_arr['astatus'] == 'L') ? 'selected' : ''?>>leave</option>
                        
                        </select>
                        </div>
                    </div>
                  
                  
                  <div class="form-group" align="right" style="margin-right:17px">
                    	<input class="submit btn btn-blue" type="submit" name="upd_attendance" id="upd_attendance" value="Update Attendance"  title="Click to Update Attendance" />
                     <input type="hidden" value="<?php echo $attendance_data_arr['id'] ?>" name="page_id" readonly />
                    </div>
                    
              </form>
                    
                </div>
				
            
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
$(document).ready(function() { $("#user_id").select2(); });
</script>
<script type="text/javascript">
  $(function() {
    $('#intime').datetimepicker({
      pickDate: false
    });
  });
</script>
<script type="text/javascript">
  $(function() {
    $('#outtime').datetimepicker({
      pickDate: false
    });
  });
</script>
<script src="<?php echo SURL; ?>assets/js/chosen.jquery.js" type="text/javascript"></script>

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
				user_id: {
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
				user_id : "Please select user"
				
            }
        });

    });
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


</body>
</html>
