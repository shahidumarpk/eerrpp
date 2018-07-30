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
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-12">
              <div class="panel panel-visible">
                <div class="panel-heading">
                <div class="row">
                        <div class="col-md-4" align="left" style="margin-left: -63px;">
                           <ul class="nav panel-tabs">
                            <li class="active"><a href="#unread_messages" data-toggle="tab">Unread Messages</a></li>
                            <li class=""><a href="#read_messages" data-toggle="tab">Read Messages</a></li>
                          </ul> 
             
                        </div>
                        
                        
                         <div class="col-md-2">
                        
                        <a href="<?php echo base_url()?>messages/manage-messages/inbox" title="Click to refresh the page"><p>Refresh</p></a>
                         
                         </div>
                        
                         <div class="col-md-4">
                         
                         <?php 
						 if($unread_msg_count>0){
						 
						 echo "<p>Total Messages: ".$total_messages." | Unread Messages (". $unread_msg_count.")</p>";
						 
						 }
						  ?>
                          
                          
                         
                         </div>
                        
                        <div class="col-md-2" align="right">
                        <?php 
                             if($ALLOW_compose== 1){ 
					    ?>
                          <a href="<?php echo SURL?>messages/manage-messages/compose"><span class="glyphicons glyphicons-circle_plus"></span> Compose</a> <?php  }  ?>
                          
                          
                
                          
                          
                         </div>
                    </div>
                </div>
                
         <div class="tab-content border-none padding-none">
         
          <!----------------------- UnRead Messages portion -------------------------->
             <div id="unread_messages" class="tab-pane active">
                      
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
					
					if($unread_msg_count > 0){
                ?>
                
                  <table class="table table-striped table-bordered table-hover" id="manage_cms_pages">
                    <thead>
                      <tr>
                       <th class="hidden-xs">#</th>
                        <th class="hidden-xs">From</th>
                        <th class="hidden-xs hidden-sm">Subject</th>
                        <th class="hidden-xs hidden-sm">Date</th>
                      
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
							for($i=0;$i<$unread_msg_count;$i++){
					?>
                            <tr>
                                <td><span class="xedit"><input type="checkbox" name="id" ></span></td>
                               
                                <td class="hidden-xs hidden-sm"><a href="<?php echo base_url()?>admin/manage-user/user-detail/<?php echo $messages_arr[$i]['id'] ?>" title="Click to User Detail"><?php echo $messages_arr[$i]['display_name'] ;?></a></td>
                                <td class="hidden-xs hidden-sm">
                              <?php if($messages_arr[$i]['unread_msg']!=0) { ?> 
                              
                              <strong ><a href="<?php echo SURL?>messages/manage-messages/message-inbox-detail/<?php echo $messages_arr[$i]['message_id']?>"><?php echo stripcslashes($messages_arr[$i]['subject']) ;?>
                              
								<?php if($messages_arr[$i]['unread_msg']!=0) {?> &nbsp;(<?php echo $messages_arr[$i]['unread_msg'] ;?> New Message) <?php  } ?>
                                
                                </a></strong>
                                
                             <?php  } ?>
                                
                                </td>
                                <td class="hidden-xs hidden-sm"><?php echo date('F j, Y h:i:s a', strtotime($messages_arr[$i]['date']) );?></td>
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
                	<strong>No Message(s) Found</strong> </div>                	
                <?php		
					}//end if($cms_pages_count > 0)
				  ?>
               
             </div>  
                                              
          </div>
          
          <!----------------------- End Unread Messages portion -------------------------->
          
          <!----------------------- Read Messages portion -------------------------->
                      
             <div id="read_messages" class="tab-pane">
                        
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
					
					if($read_messages_count > 0){
                ?>
                
                  <table class="table table-striped table-bordered table-hover" id="manage_cms_pages">
                    <thead>
                      <tr>
                       <th class="hidden-xs">#</th>
                        <th class="hidden-xs">From</th>
                        <th class="hidden-xs hidden-sm">Subject</th>
                        <th class="hidden-xs hidden-sm">Date</th>
                      
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
							for($i=0;$i<$read_messages_count;$i++){
					?>
                            <tr>
                                <td><span class="xedit"><input type="checkbox" name="id" ></span></td>
                               
                                <td class="hidden-xs hidden-sm"><a href="<?php echo base_url()?>admin/manage-user/user-detail/<?php echo $read_messages_arr[$i]['id'] ?>" title="Click to User Detail"><?php echo $read_messages_arr[$i]['display_name'] ;?></a></td>
                                <td class="hidden-xs hidden-sm">
                                
                              <a href="<?php echo SURL?>messages/manage-messages/message-inbox-detail/<?php echo $read_messages_arr[$i]['message_id']?>"><?php echo stripcslashes($read_messages_arr[$i]['subject']) ;?>
                              
                                </a>
                                </td>
                                <td class="hidden-xs hidden-sm"><?php echo date('F j, Y h:i:s a', strtotime($read_messages_arr[$i]['date']) );?></td>
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
                	<strong>No Message(s) Found</strong> </div>                	
                <?php		
					}//end if($cms_pages_count > 0)
				  ?>
               
             </div>
                        
                        
           </div>
          <!-----------------------------------End Read Messages portion ------------->
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
<!-- End: Main --> 
<!-- Start: Footer -->
<footer> <?php echo $INC_footer;?> </footer>
<!-- End: Footer --> 
<?php echo $INC_header_script_footer;?>
<script type="application/javascript">
	$('#manage_cms_pages').dataTable({
		"aoColumnDefs": [{ 'bSortable': false, 'aTargets': [ -1,-2,-3] }],
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
</body>
</html>
