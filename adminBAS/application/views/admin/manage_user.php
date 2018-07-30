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
          <div class="row">
            <div class="col-md-12">
              <div class="panel panel-visible">
                <div class="panel-heading">
                
                <div class="row">
                        <div class="col-md-10">
                            <div class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span> Manage Users</div>
                        </div>
                        <div class="col-md-2" align="right">
                        <?php 
                               if($ALLOW_pages_add== 1){ 
					    ?>
                          <a href="<?php echo SURL?>admin/manage-user/add-new-user"><span class="glyphicons glyphicons-circle_plus"></span> Add New</a>                        <?php  }  ?>
                        </div>
                   </div> 
                 
                </div>
                
                
               <form class="cmxform" id="edit_admin_profile_frm" method="POST" action="<?php echo SURL?>admin/manage-user" enctype="multipart/form-data"> 
              
                
               <div class="row">
               	<div class="col-md-12">
                	<div class="row">
               
                    <div class="col-md-2 col-sm-4">
                       <select id="search_status" name="search_status" style="width:100%; margin:10px 0 0 5px; " >
                       <option value="">Search By Status</option>
                       <option value="1" <?php if($status==1){ ?> selected <?php  }?>>Active</option>
                       <option value="0" <?php if($status==0){ ?> selected <?php  }?> >InActive</option>
                       
                      
                      </select>
                    </div>
                      
                    <div class="col-md-1 col-sm-1"> 
                        <div style="font-weight:bold; margin-top:18px;text-align: center;">OR</div>
                    </div>
                             
                   
                 	<div class="col-md-2 col-sm-4">
                           <select id="branch_id" name="branch_id" style="width:100%; margin:10px 0 0 5px; " >
                            <option value="" selected>Search By Branch</option>
                                <?php
								if($branches_count>0){ 
								for($c=0; $c < $branches_count ; $c++){ ?>
										<option value="<?php echo $branches_arr[$c]['id'] ?>"  <?php
										  if($branches_arr[$c]['id']!=0){
										 if($branch_id==$branches_arr[$c]['id']){ ?> selected <?php  }} ?>><?php echo $branches_arr[$c]['branch_name'];?></option>
								<?php }} ?>
                          </select>
                    </div>
                 	
                <div class="col-md-1 col-sm-1"> 
                        	<div style="font-weight:bold; margin-top:18px;text-align: center;">OR</div>
                </div>
                  
                 <div class="col-md-2">
                          
				   <select id="role_id" name="role_id" style="width:100%; margin:10px 0 0 5px; " >
                            <option value="" selected>Search By Role</option>
                                <?php
								if($admin_roles_result_count>0){ 
								for($c=0; $c < $admin_roles_result_count ; $c++){ ?>
							  <option value="<?php echo $admin_roles_result[$c]['id'] ?>" <?php if($role_id==$admin_roles_result[$c]['id']){ ?> selected <?php  }?> ><?php echo $admin_roles_result[$c]['role_title'];?></option>
								<?php }} ?>
                          </select>
                        
                  </div>
                           
                        <div class="col-md-1">
                        <div class="form-group" style="margin-top:6px;">
                        <input class="submit btn btn-blue" type="submit" name="search_sbt" id="search_sbt" value="Search" style="margin-top: 5px;"  />
                        </div>
                                          
                        </div>
                 </div>
                        
                </div>
                
               </div>
            
              </form>
              
              
              
                <div class="panel-body padding-bottom-none">
                <div id="suc_message" style="display:none" class="alert alert-success alert-dismissable">Your message has been sent...!</div>

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
					
					if($admin_user_list_count > 0){
                ?>
                
                  <table class="table table-striped table-bordered table-hover" id="manage_cms_pages">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th class="hidden-xs">Display Name</th>
                        <th class="hidden-xs">Username</th>
                        <th class="hidden-xs hidden-sm">Admin Role</th>
                        <th class="hidden-xs hidden-sm" >Last SignIn Date</th>
                        <th class="hidden-xs">Branch Name</th>
                        <th class="hidden-xs hidden-sm">Rating</th>
                        <th class="hidden-xs hidden-sm" >Options</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
					
					 for($i=0;$i<$admin_user_list_count;$i++){
					
					?>
                            <tr>
                                <td><span class="xedit"><?php echo ($i+1);?></span></td>
                                <td class="hidden-xs">
                                <a class="anchor_style" href="<?php echo base_url()?>admin/manage-user/user-detail/<?php echo $admin_user_list[$i]['id'] ?>" ><?php echo  stripcslashes(strip_tags($admin_user_list[$i]['display_name']));?></a><br>
                               <?php echo ($admin_user_list[$i]['status'] == 1) ? '<span class="label btn-success">Active</span>' : '<span class="label btn-danger">InActive</span>' ?>
							   <?php if($admin_user_list[$i]['is_important']==1){?><span class="label btn-red">Star</span><?php } ?>
                               <?php  if($admin_user_list[$i]['is_awarded']==1){ ?><span class="label btn-success">Awarded</span>  <?php  } ?>
                                </td>
                                
                                <td class="hidden-xs"><?php echo stripcslashes($admin_user_list[$i]['username']);?></td>
                                
                                <td class="hidden-xs hidden-sm"><?php echo stripcslashes($admin_user_list[$i]['role_title']) ;?></td>
                                <td class="hidden-xs hidden-sm"><?php echo date('d, M Y', strtotime($admin_user_list[$i]['last_signin_date'])) ;?></td>
                            
                                <td class="hidden-xs"><?php echo stripcslashes($admin_user_list[$i]['branch_name']);?></td>
					
                               <td class="hidden-xs hidden-sm"><b><?php echo round($admin_user_list[$i]['average_rating'],2); ?></b> </td>   
                              
                      
                               <td class="hidden-xs text-center">
                                <?php 
                            
							        if($ALLOW_user_view_attendance == 1){ 
								?>
                                        <a href="<?php echo SURL?>attendance/manage-attendance/user-report/<?php echo $admin_user_list[$i]['id'];?>" type='button' class='btn btn-info btn-gradient' title='View Attendance'> <span class='glyphicons glyphicons-eye_open'></span> </a>                                
                                <?php	
									}//end if
									
									if($ALLOW_user_edit == 1){ 
								?>
                                	<a href="<?php echo SURL?>admin/manage-user/edit-user/<?php echo $admin_user_list[$i]['id']?>" type='button' class='btn btn-info btn-gradient'> <span class='glyphicons glyphicons-edit'></span> </a>
                                <?php	
									}//end if
                                if($ALLOW_user_delete == 1){ 
                                 ?>
                                 
                                <a href="<?php echo SURL ?>admin/manage-user/delete-user/<?php echo $admin_user_list[$i]['id']?>" type='button' class='btn btn-danger btn-gradient' onClick="return confirm('Are you sure you want to delete?')"> <span class='glyphicons glyphicons-remove'></span> </a>
                                
                                   <?php	
									}//end if 
									?>
                                    
                                   <a href='' onClick='openModel("<?php echo $admin_user_list[$i]['id'] ?>")' id='emailTom' data-toggle='modal' data-target='#mailmodal' type='button' class='btn btn-info btn-gradient' title='Send Message'> <span class='glyphicons glyphicons-envelope'></span> </a>
                                    
                                 </td>
                              
                            </tr>
                    <?php			
						}//end for
					?>
                    </tbody>
                  </table>
                  
                  <?php 
					}else{
				?>
                <div class="alert alert-danger alert-dismissable">
                	<strong>No User(s) Found</strong> </div>                	
                <?php		
					}//end if
				  ?>
                </div>
                
                 
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="row" style="min-height:250px;">&nbsp;</div>
    </div>
  </section>
  <!-- End: Content --> 
  
</div>

<div class="modal fade" id="mailmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Send Message</h4>
      </div>
      <div class="modal-body">
        <form action="manage-user/send-message" enctype="multipart/form-data" method="post">
         
           <div class="form-group">
           
           
                        <label for="subject">Subject*</label>
                        <input id="subject" name="subject" type="text" class="form-control"  value="" required/>
                      </div>
                      
                      
                      <div class="form-group">
                      <label for="message">Message*</label>
                      <textarea class="form-control" id="message" name="message" rows="8"></textarea>
                    </div>
                    
                     <div class="form-group">
                       <label for="page_title">Attach File </label>
						 <input type="file" id="attachment" name="attachment">
                          <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> 
                                - Allowed Extensions: jpg,jpeg,gif,tiff,png,doc,zip,rar,docx,xlsx
                            </span>
                            <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> 
                                Max Upload Size: 5MB;
                            </span>
                         
                     </div>
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         <input type="hidden" id="userid" value="" name="user_id">
       
        <button id="submitMail" type="submit" class="btn btn-primary">Send</button>
     
      </div>
         </form>
     
    </div>
  </div>
</div>
<div id="output">Message send</div>
<!-- End: Main --> 
<!-- Start: Footer -->
<footer> <?php echo $INC_footer;?> </footer>
<!-- End: Footer --> 
<?php echo $INC_header_script_footer;?>

<script type="application/javascript">
	$('#manage_all_users').dataTable({
		"aoColumnDefs": [{ 'bSortable': false, 'aTargets': [ -1,-4,-5 ] }],
		"aaSorting": [],
		"oLanguage": { "oPaginate": {"sPrevious": "", "sNext": ""} },
		"iDisplayLength": 25,
		"bPaginate": true, 
		"bLengthChange": true,
		"bFilter": true,
		"aLengthMenu": [[25, 50, 75,100], [25, 50, 75,100]],
		"sDom": 'T<"panel-menu dt-panelmenu"lfr><"clearfix">tip',
		"oTableTools": {
			"sSwfPath": "<?php echo VENDOR ?>plugins/datatables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf"
		}
		
	});	
</script>

<script>


function openModel(user_id) {
	
	alert(user_id);
	
	

		$('#userid').val('');
		
		 $('#subject').val('');
         $('#message').val('');
		
		 $('#userid').val(user_id);
		 
		
   
    $('#submitMaileeeee').click(function () {
		
		
		
		var userId = $('#userid').val();
        var subject = $('#subject').val();
        var message = $('#message').val();
		
		
		
		if(subject=="" || message==""){
			
			return false;
		}	
		
		
        $('#mailmodal').modal('hide');
        $.ajax({
                type: "POST",
                url: "manage-user/send-message",
                data: {
					userid: userId,
                    subject: subject,
                    message: message,
					 
                }
            })
            .done(function (msg) {
                $('#suc_message').show();
				
		 
		 $('#subject').val('');
         $('#message').val('');
            });

    });
};
 </script> 
<script type="application/javascript">
	$('#manage_cms_pages').dataTable({
		"aoColumnDefs": [{ 'bSortable': false, 'aTargets': [ -1,-4,-5, -7 ] }],
		"aaSorting": [],
		"oLanguage": { "oPaginate": {"sPrevious": "", "sNext": ""} },
		"iDisplayLength": 25,
		"bPaginate": true,
		"bLengthChange": true,
		"bFilter": true,
		"aLengthMenu": [[25, 50, 75,100], [25, 50, 75,100]],
		"sDom": 'T<"panel-menu dt-panelmenu"lfr><"clearfix">tip',
		"oTableTools": {
			"sSwfPath": "<?php echo VENDOR ?>plugins/datatables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf"
		}
		
	});	
</script>

<link href="<?php echo CSS ;?>select2.css" rel="stylesheet"/>
<script src="<?php echo JS ; ?>select2.js"></script>
<script>
$(document).ready(function() { $("#search_status").select2(); });
</script>
<script>
$(document).ready(function() { $("#branch_id").select2(); });
</script>

<script>
$(document).ready(function() { $("#role_id").select2(); });
</script>
</body>
</html>
