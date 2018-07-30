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
                           <div class="panel-title hidden-xs"> <span class="glyphicon glyphicon-picture"></span>View Attendance</div>
                        </div>
                        <div class="col-md-2" align="right">
                        <?php 
                                        if($ALLOW_pages_add== 1){ 
					    ?>
                          <a href="<?php echo SURL?>attendance/manage-attendance/upload"><span class="glyphicons glyphicons-circle_plus"></span> Add New</a>                        <?php  }  ?>
                        </div>
                    </div>      
                    
                  
                </div>
                
                
                
                <form class="cmxform" id="user_report_frm" method="GET" action="<?php echo SURL?>attendance/manage-attendance/user_report/" enctype="multipart/form-data">     
               
               
                <div class="row">
              
              
              <div class="col-md-4 col-sm-4">
                     <br>
                    
                   
                          
                            <label class="col-md-4 hidden-sm">Select User</label>
                            
                          <div class="col-md-8" >
                          
            <select id="user_id" name="user_id" style="width:100%;"  required placeholder="Select User">
                       
                                <?php
							
								$selected = '';
							if($users_count>0){ 
								for($c=0; $c <$users_count ; $c++){
									
								$selected = ($report_user_id == $users_arr[$c]['id']  ) ? 'selected = "selected"':'';
									
									 ?>
                                
                                
                                
                                
                                
										<option <?php echo $selected;?> value="<?php echo $users_arr[$c]['id'] ?>"><?php echo $users_arr[$c]['first_name']." ".$users_arr[$c]['last_name'];?></option>
								<?php }} ?>
                          </select>  
          </div>
	                   
                         
                         
                    </div>
                    
                    
                    
                    		<div class="col-md-4 col-sm-4">
                            <br>

                            
                      <label class="col-md-2 hidden-sm">Month:</label>
                              <div class="col-xs-10 hidden-sm" id="fromdate">
                                   <div class="input-group"><input placeholder="Month Filter" type="text" readonly style="cursor:pointer;" name="search_date" id="search_date" class="form-control" required value="<?php echo $search_date; ?>" /><span class="input-group-addon"><span id="targetto" onclick="create_date_monthsonly('fromdate')" class="glyphicon glyphicon-calendar" style="cursor:pointer;"></span></span>
	                        </div>
              </div>
              
              
              
                            </div>
                    
                    
                    
                    
                    
                    
                    
                     <div class="col-md-2" style="">
                      <br>
                        <input class="submit btn btn-blue" type="submit" name="search_sbt" id="search_sbt" value="Search" />
                     </div>
                    
                    
                    </div>
                       
           
                      
 </form>
 
 
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
					
					if($attendance_count > 0){
                ?>
                
                  <table width="100%" height="121" class="table table-striped table-bordered table-hover" id="manage_user_report">
                    <thead>
                      <tr>
                        <th width="10">#</th>
                        <th width="20">Date</th>
                        <th width="15" class="hidden-xs">Time In</th> 
                     
                        <th width="20" class="hidden-xs">Status</th>
                           <th width="15" class="hidden-xs">Break Out</th>
                       <th width="15" class="hidden-xs">Break In</th>
                        <th width="15" class="hidden-xs">Time Out</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
					
				
					
							for($i=0;$i<$attendance_count;$i++){
								
								
					?>
                            <tr>
                               <td><span class="xedit"><?php echo ($i+1) ?></span></td>
                          <td class="hidden-xs "><?php if($attendance_arr[$i]['attend_date'] !=""){echo date('d, M Y', strtotime($attendance_arr[$i]['attend_date']));}else{echo "-";} ?></td>    
                                <td class="hidden-xs"><?php if($attendance_arr[$i]['time_in'] !="" and $attendance_arr[$i]['time_in'] !="00:00:00"){ echo date("g:i a", strtotime($attendance_arr[$i]['time_in']));}else{echo "-";} ?></td>
                        
             
                                <td class="hidden-xs ">
								
							
                            <?php 
								
			if(($attendance_arr[$i]['astatus']=="P")){
								
								echo "<span class='label btn-green '>Present</span>";
										
								// Display is Tardy
										if($attendance_arr[$i]['is_tardy'] === "1" ){
												echo "&nbsp;<span class='label btn-warning '>Tardy</span>";
												
												
										}
								}
									
				if($attendance_arr[$i]['astatus']=="L"){echo "<span class='label btn-blue '>Leave</span>";}
				if($attendance_arr[$i]['astatus']=="A"){echo "<span class='label btn-red '>Absent</span>";}
								
								
								?>
                                	
                                    
                                    <br>
                                     <?php  echo $attendance_arr[$i]['timein_status'];?>
								
							</td>
                                <td class="hidden-xs"><?php if($attendance_arr[$i]['break_out'] !="" and $attendance_arr[$i]['break_out'] !="00:00:00"){ echo date("g:i a", strtotime($attendance_arr[$i]['break_out']));}else{echo "-";} ?></td>
                                
                                <td class="hidden-xs"><?php if($attendance_arr[$i]['break_in'] !="" and $attendance_arr[$i]['break_in'] !="00:00:00"){ echo date("g:i a", strtotime($attendance_arr[$i]['break_in']));}else{echo "-";} ?></td>
                                
                                  <td class="hidden-xs"><?php if($attendance_arr[$i]['time_out'] !="" and $attendance_arr[$i]['time_out'] !="00:00:00"){ echo date("g:i a", strtotime($attendance_arr[$i]['time_out']));}else{echo "-";} ?></td>
                                 
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
                	<strong>No Attendance Found</strong> </div>                	
                <?php		
					}//end if($slider_images_count > 0)
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
<!-- End: Main --> 
<!-- Start: Footer -->
<footer> <?php echo $INC_footer;?> </footer>
<!-- End: Footer --> 
<?php echo $INC_header_script_footer;?>
 
 <link href="<?php echo CSS ;?>select2.css" rel="stylesheet"/>
<script src="<?php echo JS ; ?>select2.js"></script>

<script type="text/javascript">
  
  </script>
<script type="application/javascript">
	$('#manage_user_report').dataTable({
		"aoColumnDefs": [{ 'bSortable': false, 'aTargets': [ -1,-6 ] }],
		"aaSorting": [],
		"oLanguage": { "oPaginate": {"sPrevious": "", "sNext": ""} },
		"iDisplayLength": 100,
		"bPaginate": true,
		"bLengthChange": true,
		"bFilter": true,
		"aLengthMenu": [[25, 50, 75,100], [25, 50, 75,100]],
		"sDom": 'T<"panel-menu dt-panelmenu"lfr><"clearfix">tip',
		"oTableTools": {
			"sSwfPath": "<?php echo VENDOR ?>plugins/datatables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf"
		}
		
	});	

	
	
$(document).ready(function() { $("#user_id").select2(); });
</script>
</script>
</body>
</html>






















