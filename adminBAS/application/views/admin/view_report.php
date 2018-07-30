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
<script language="JavaScript" src="datepick/ts_picker.js"></script>
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
                            <div class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span>View Report</div>
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

 <form class="cmxform" id="edit_admin_profile_frm" method="POST" action="<?php echo SURL?>admin/manage-user/view-report/<?php echo $user_id; ?>" enctype="multipart/form-data">  
 
                       <div class="col-md-6">
                        	<div class="row form-group">
                              <label class="col-md-4">Search Report</label>
                              <div class="col-xs-4" id="todate">
                                   <div class="input-group"><input type="text" readonly style="cursor:pointer;" name="date" id="date" class="form-control" required value="<?php echo $date; ?>" /><span class="input-group-addon"><span id="targetto" onclick="create_date('todate')" class="glyphicon glyphicon-calendar" style="cursor:pointer;"></span></span>
	                        </div>
                            </div>
                             
                            </div>
                            
                      </div>
                      <input type="submit" name="submit" value="Search" class="submit btn btn-blue"  >
                     
    
</form>

            <?php 
                  
					if($report_count > 0){
                ?>
            
              <div class="table-responsive">
                <table class="table table-bordered">
               
                
                    <tr>
                      <th>#</th>
                      <th>From Time </th>
                      <th>To Time</th>
                      <th>Comment</th>
                    </tr>
                  
                  <tbody>
                    <?php 
							for($i=0;$i<count($report_arr);$i++){
					?>
                            <tr>
                                <td><?php echo ($i+1) ?></td>
                                <td><?php echo $report_arr[$i]['time_from'] ?></td>
                                <td><?php echo $report_arr[$i]['time_to']; ?> </td>
                                <td><?php echo $report_arr[$i]['comments']; ?> </td>
                            </tr>    
                   <?php			
						}//end for
					?>
                  </tbody>
                </table>
                
                <div align="right">
                	<?php //echo "Showing $start - $end of $total total results"; ?>
                	<?php echo $page_links?>
                </div>

              </div>
         </form>
         
          <?php 
					}else{
				?>
                <div class="alert alert-danger alert-dismissable" style="margin-top: 20px;">
                	<strong>No Report(s) Found</strong> </div>                	
                <?php		
					}//end if
				  ?>
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
