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
        <div class="col-md-12"  style="min-height:1300px;">
        
        <?php  if($messages_count > 0){ ?>   
		<?php  	if($unread_msg_count > 0){ ?>
          <div class="row">
            <div class="col-md-12">
              <div class="panel panel-visible">
                <div class="panel-heading">
                <div class="row">
                        <div class="col-md-3 col-sm-6" align="left">
                         <div class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span>New Messages</div>  
                        </div>
                         <div class="col-md-1 hidden-sm">
                        
                        <a href="<?php echo base_url()?>messages/manage-messages/inbox" title="Click to refresh the page"><span class="glyphicon glyphicon-refresh"></span></a>
                         
                         </div>
                        
                         <div class="col-md-5 col-sm-6">
                         
                         <?php 
						 if($unread_msg_count>0){
						 
						 echo "<p>Total Messages: ".$total_messages." | Unread Messages (". $unread_msg_count.")</p>";
						 
						 }
						  ?>
                          
                         </div>
                        
                        <div class="col-md-2 hidden-sm" align="right">
                        <?php 
                             if($ALLOW_compose== 1){ 
					    ?>
                          <a href="<?php echo SURL?>messages/manage-messages/compose"><span class="glyphicons glyphicons-circle_plus"></span> Compose</a> <?php  }  ?>
                          
                          
                         </div>
                    </div>
                </div>
                
         <div class="tab-content border-none padding-none">
                      
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
					
                ?>
             
                <table class="table table-striped table-bordered table-hover" id="manage_all_inbox_messages">
                    <thead>
                      <tr>
                        <th class="hidden-xs">From</th>
                        <th class="hidden-xs">Subject</th>
                        <th class="hidden-xs">Date</th>
                        
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
               
                
             </div>  
        
         </div>
         
                
              </div>
            </div>
          </div>
    
          <?php  }else{
				?>
                <div class="alert alert-danger alert-dismissable">
                	<strong>No New Message(s) Found</strong> </div>                	
                <?php		
					}//end if($cms_pages_count > 0)
		      }
				  ?>                 
          <div class="row">
            <div class="col-md-12">
              <div class="panel panel-visible">
                <div class="panel-heading">
                <div class="row">
                        <div class="col-md-3 col-sm-6" align="left">
                          <div class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span>Read Messages</div>  
                        </div>
                         <?php 
						if($unread_msg_count==0){ ?> 
                         <div class="col-md-1 hidden-sm" align="right">
                       
                        <a href="<?php echo base_url()?>messages/manage-messages/inbox" title="Click to refresh the page"><span class="glyphicon glyphicon-refresh"></span></a>
                         
                         </div>
                        
                         <div class="col-md-5 col-sm-6">
                         <?php 
						
						 echo "<p>Total Messages: ".$total_messages." | Unread Messages (0)</p>";
						  ?>
                         </div>
                        
                         <div class="col-md-2 hidden-sm" align="right">
                        <?php 
						
                             if($ALLOW_compose== 1){ 
					    ?>
                          <a href="<?php echo SURL?>messages/manage-messages/compose"><span class="glyphicons glyphicons-circle_plus"></span> Compose</a> <?php   }  ?>
                          
                          
                         </div>
                        <?php } ?>  
                        
                        
                    </div>
                </div>
                
         <div class="tab-content border-none padding-none">
         
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
              
                  <table class="table table-striped table-bordered table-hover" id="manage_all_inbox_read_messages">
                    <thead>
                      <tr>
                        <th class="hidden-xs">From</th>
                        <th class="hidden-xs">Subject</th>
                        <th class="hidden-xs">Date</th>
                        
                      </tr>
                    </thead>
                    <tbody>
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
	$('#manage_all_inbox_messages').dataTable({
		
		"bProcessing": true,
		"bServerSide": true,
		"sServerMethod": "POST",
		"sAjaxSource": "<?php echo base_url()?>messages/manage-messages/process-inbox-grid/<?php echo $type?>",
		"aoColumnDefs": [{ 'bSortable': false, 'aTargets': [ -1,-2] }],
		"aaSorting": [],
		"iDisplayLength": 50,
		"bPaginate": true,
		"bLengthChange": true,
		"bFilter": true,
		"aLengthMenu": [[25, 50, 75,100], [25, 50, 75,100]],
		"aoColumns": [
		{ "bSearchable": true, "sWidth": "20%"  },
		{ "bSearchable": true, "sWidth": "60%"},
		{ "bSearchable": true, "sWidth": "20%" },
		
		],
		"oLanguage": {
           "sProcessing": "Searching Please Wait..."
         }
		
	}).fnSetFilteringDelay(700);	
</script>

<script type="application/javascript">
	$('#manage_all_inbox_read_messages').dataTable({
		
		"bProcessing": true,
		"bServerSide": true,
		"sServerMethod": "POST",
		"sAjaxSource": "<?php echo base_url()?>messages/manage-messages/process-inbox-read-grid",
		"aoColumnDefs": [{ 'bSortable': false, 'aTargets': [ -1,-2] }],
		"aaSorting": [],
		"iDisplayLength": 50,
		"bPaginate": true,
		"bLengthChange": true,
		"bFilter": true,
		"aLengthMenu": [[25, 50, 75,100], [25, 50, 75,100]],
		"aoColumns": [
		{ "bSearchable": true, "sWidth": "20%"  },
		{ "bSearchable": true, "sWidth": "60%"},
		{ "bSearchable": true, "sWidth": "20%" },
		
		],
		"oLanguage": {
           "sProcessing": "Searching Please Wait..."
         }
		
	}).fnSetFilteringDelay(700);	
</script>




</body>
</html>
