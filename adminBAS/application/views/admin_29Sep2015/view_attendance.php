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
                          <a href="<?php echo SURL?>advertisements/manage-advertisements/add-advertisement"><span class="glyphicons glyphicons-circle_plus"></span> Add New</a>                        <?php  }  ?>
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
					
					if(count($attendance_arr) > 0){
                ?>
                
                  <table width="100%" height="121" class="table table-striped table-bordered table-hover" id="manage_slider_images">
                    <thead>
                      <tr>
                        <th width="41">#</th>
                        <th width="220">Date</th>
                        <th width="125" class="hidden-xs">Status</th>
                        <th width="124" class="hidden-xs hidden-sm">InTime</th> 
                        <th width="125" class="hidden-xs">OutTime</th>
                        <th width="124" class="hidden-xs hidden-sm">Per Day Salary</th> 
                        <th width="90" class="hidden-xs hidden-sm">Reason</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
					
				
					
		    $month = date('m');
			$year = date('Y');
		    $last_day_of_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
			$sdate = $year.'-'.$month.'-01';
			$edate = $year.'-'.$month.'-'.$last_day_of_month;
			$sr=0;
			
			for($i=1;$i<=$last_day_of_month;$i++){
		
		        $sr++;
				if($i < 10){
					$day = '0'.$i;
				}else{
					$day = $i;
				}
					$show_date = $year.'-'.$month.'-'.$day;	
					
				     
					?>
                            <tr>
                                <td><span class="xedit"><?php echo $sr; ?></span></td>
                                <td class="hidden-xs"><?php echo $show_date; ?></td>
                                <td class="hidden-xs hidden-sm"><?php
								if($attendance_arr[$i]['astatus']!=""){ 
								if($attendance_arr[$i]['astatus'] == "P")echo "Present";
								if($attendance_arr[$i]['astatus'] == "A")echo "Absent";
								if($attendance_arr[$i]['astatus'] == "L")echo "Leave";
								}else{echo "-";}
								
								?></td>
                               
                                <td class="hidden-xs"><?php if($attendance_arr[$i]['time_in']!=""){echo date("g:i a", strtotime($attendance_arr[$i]['time_in']));}else{ echo "-"; }?></td>
                                <td class="hidden-xs hidden-sm"><?php if($attendance_arr[$i]['time_in']!=""){echo date("g:i a", strtotime($attendance_arr[$i]['time_out']));}else echo "-"; ?></td>
                                <td class="hidden-xs hidden-sm"><?php echo $attendance_arr[$i]['per_day_salary']; ?></td>
                                <td class="hidden-xs hidden-sm"><?php echo $attendance_arr[$i]['reason']; ?></td>
                               
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
<script type="application/javascript">
	$('#manage_slider_images').dataTable({
		"aoColumnDefs": [{ 'bSortable': false, 'aTargets': [ -1,-4,-5,-6 ] }],
		"aaSorting": [],
		"oLanguage": { "oPaginate": {"sPrevious": "", "sNext": ""} },
		"iDisplayLength": 35,
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
