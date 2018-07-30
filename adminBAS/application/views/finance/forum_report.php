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
          <div class="panel">
            <div class="panel-heading">
              <div class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span>Forum Report</div>
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


                 <form class="cmxform" id="edit_admin_profile_frm" method="POST" action="<?php echo SURL?>finance/manage-financial-statistics/forum-report" enctype="multipart/form-data">     
               
           
             <div class="row form-group">
                              <label class="col-md-2 hidden-sm" style="margin-right: -106px;">From :</label>
                              <div class="col-xs-2 hidden-sm" id="fromdate">
                                   <div class="input-group"><input type="text" readonly style="cursor:pointer;" name="from_date" id="from_date" class="form-control" required value="<?php echo $from_date; ?>" /><span class="input-group-addon"><span id="targetto" onclick="create_date('fromdate')" class="glyphicon glyphicon-calendar" style="cursor:pointer;"></span></span>
	                        </div>
                            </div>
            
                              <label class="col-md-2 hidden-sm" style="margin-right: -113px;">To :</label>
                              <div class="col-xs-2 hidden-sm" id="todate">
                                   <div class="input-group"><input type="text" readonly style="cursor:pointer;" name="to_date" id="to_date" class="form-control" required value="<?php echo $to_date; ?>" /><span class="input-group-addon"><span id="targetto" onclick="create_date('todate')" class="glyphicon glyphicon-calendar" style="cursor:pointer;"></span></span>
	                        </div>
                            
                            </div>
            
         <!--<span class="hidden-sm" style="margin-left: 3px;margin-top: 8px;position: absolute; font-weight:bold;">  OR</span>-->
          
                        <div class="col-md-2 col-sm-4">
                           <select id="forum_id" name="forum_id"  class="form-control"style="width: 100%;height: 34px;margin-left: 22px;">
                           <option value="">Select Forum</option>
                                <?php
								if($forum_count >0){ 
								for($c=0; $c < $forum_count ; $c++){ ?>
										<option value="<?php echo $forum_arr[$c]['id'] ?>"><?php echo $forum_arr[$c]['forum_name']; ?></option>
								<?php } }?>
                                </select>
            
                        </div>
          
                    
            
                <div class="form-group" align="left" style="margin-left: 630px;margin-top: -1px;position: absolute;">
                        <input class="submit btn btn-blue" type="submit" name="search_sbt" id="search_sbt" value="Search" />
                </div>    
             
             </div>         
 </form>
<br>

             
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Date</th>
                      <th>Forum</th>
                      <th>Detail</th>
                      <th>Amount (PKR)</th>
                      <th>Add By</th>
                    
                    </tr>
                  </thead>
                  <tbody>
                  	<?php
				
						if($forum_report_count > 0){
							for($i=0;$i<$forum_report_count;$i++){
								
								$balance= (($balance + $forum_report_arr[$i]['add']) - $forum_report_arr[$i]['release']) ;
						       
							    $total_amount+=$forum_report_arr[$i]['amount'];
								
					?>
                            <tr>
                                <td><?php echo ($i+1);?></td>
                                <td><?php echo date('d, M Y', strtotime($forum_report_arr[$i]['dated']) );?></td>
                               
                                <td><?php echo $forum_report_arr[$i]['forum_name'];?></td>
                                <td><?php echo stripslashes($forum_report_arr[$i]['detail']);?></td>
                                <td><?php echo  number_format($forum_report_arr[$i]['amount'] ,2,".",",");?></td>
                                <td><?php echo $forum_report_arr[$i]['user_name']; ?> </td>
                                
                            </tr>
                    <?php		
							
						}//enf for
					?>
                            <tr>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td><b><b>Total Amount: <?php echo  number_format($total_amount,2,".",",") ?> PKR</b></b></td>
                              <td></td>
                            </tr>
                            
              <table width="359" border="1" style="width: 100%;height: 34px; border: rgb(194, 192, 191);">
                   <tr>
                      
                       <td width="320" align="right"><b>Grand Total </b> &nbsp;&nbsp;</td>
                       <td width="294"><b>&nbsp;&nbsp;<?php echo  number_format($grand_total_amount,2,".",",")?> (PKR)</b></td>
                     
                  </tr>
              </table>
                    <?php	
						}
						else{
					?>	
                        <tr>
	                        <th colspan="8">
                                <div class="alert alert-danger alert-dismissable">
                                No Record(s) Found </div>
                            </th>
                        </tr>
                    <?php		
						}//end if
					?>
                    
                  </tbody>
                </table>
                
                <div align="right">
                	<?php //echo "Showing $start - $end of $total total results"; ?>
                	<?php echo $page_links?>
                </div>

               
              </div>
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
