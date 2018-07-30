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
          <div class="panel">
            <div class="panel-heading">
            
             <div class="row">
                        <div class="col-md-10">
                            <div class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span>Add Report</div>
                        </div>
                        <div class="col-md-2" align="right">
                        <?php 
                                        if($ALLOW_pages_add== 1){ 
					    ?>
                          <a href="<?php echo SURL?>finance/manage-financial-statistics/add-forum"><span class="glyphicons glyphicons-circle_plus"></span> Add New</a>                        <?php  }  ?>
                        </div>
                    </div>      
                    
             
            </div>
            <div class="panel-body">
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

          <form name="search" action="<?php echo base_url(). 'admin/manage-user/add-report-process' ?>" method="post">
            
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                    
                      <th>From Time </th>
                      <th>To Time</th>
                      <th>Comment</th>
                    </tr>
                  </thead>
                  <tbody>
                  
<?php
  $sr=1;
  $todaydate = date('Y-m-d');
for($i=0; $i<=23; $i++){
	$getItView = $sr++;
$hourdate = date('Y-m-d').' '.$i.':00:00';

	//$date = '19:24:15 06/13/2013'; 
$GetDate = date('Y-m-d h:i:s a', strtotime($hourdate));
$beforedate = date('h', strtotime($hourdate));
$minus1hour = $beforedate-1;

for($s=1; $s<10; $s++){
	if ($minus1hour==$s) {
		$minus1hour = '0'.$minus1hour;
	} else if ($minus1hour==0) {
		$minus1hour = '12';
	}
}



 $timestamp = strtotime(date('h:i:s a', strtotime($hourdate))) + 60*60;

$time = date('h:i:s a', $timestamp);



$gettime = date('Y-m-d').' '. $fromdate.':00';
//$getRecord = mysql_query("select * from tbl_report where fk_uid='2' and report_from = '".date('Y-m-d h:i:s a', strtotime($GetDate))."'");
//$rows=mysql_fetch_assoc($getRecord);
	
  ?>
  
                            <tr>
                                
                                <td><input type="hidden" name="time_from[]" value="<?php echo date('Y-m-d h:i:s a', strtotime($GetDate)); ?>" /><?php echo date('h:i:s a', strtotime($GetDate)); ?></td>
                                <td><input type="hidden" name="time_to[]" value="<?php echo date('Y-m-d') .' '.$time; ?>" /> <?php echo $time; ?></td>
                                 <td><textarea name="comments[]" cols="80" rows="4" ><?php echo $report_arr[$i]['comments']; ?></textarea></td> <input type="hidden" name="recordfor" value="<?php echo $getItView; ?>" /><input type="hidden" name="action" value="record" />
                               
                            </tr>    
                <?php } ?>  
                    
                  </tbody>
                </table>
                
                <div align="right">
                	<?php //echo "Showing $start - $end of $total total results"; ?>
                	<?php echo $page_links?>
                </div>
<input type="hidden" name="recordfor" value="<?php echo $getItView; ?>" /><input type="hidden" name="action" value="record" /><input type="submit" value="Update"  />
               
              </div>
         </form>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
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

</body>
</html>
