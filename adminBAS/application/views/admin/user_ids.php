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
                            <div class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span> Users IDS</div>
                        </div>
                        
                   </div> 
                 
                </div>
                
              
              
                <div class="panel-body padding-bottom-none">
               
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
                
                  <table class="table table-striped table-bordered table-hover" id="manage_all_users">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th class="hidden-xs">User Name</th>
                        <th class="hidden-xs hidden-sm" >User ID</th>
                        <th class="hidden-xs hidden-sm" >IP</th>
                        <th class="hidden-xs hidden-sm" >PC No</th>
                        <th class="hidden-xs hidden-sm" >Desk No</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
					
					 for($i=0;$i<$admin_user_list_count;$i++){
					
					?>
                            <tr>
                                <td><span class="xedit"><?php echo ($i+1);?></span></td>
                                <td class="hidden-xs">
                                <a class="anchor_style" href="<?php echo base_url()?>admin/manage-user/user-detail/<?php echo $admin_user_list[$i]['id'] ?>" ><?php echo  stripcslashes(strip_tags($admin_user_list[$i]['first_name']." ".$admin_user_list[$i]['last_name']));?></a><br>
                                
                                </td>
                                
                             
                                <td class="hidden-xs"><?php echo stripcslashes($admin_user_list[$i]['id']);?></td>
                                <td class="hidden-xs"><?php echo stripcslashes($admin_user_list[$i]['ip']);?></td>
                                <td class="hidden-xs"><?php echo stripcslashes($admin_user_list[$i]['pc_no']);?></td>
                                <td class="hidden-xs"><?php echo stripcslashes($admin_user_list[$i]['desk_no']);?></td>
					
                             
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
		"aoColumnDefs": [{ 'bSortable': false, 'aTargets': [] }],
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
