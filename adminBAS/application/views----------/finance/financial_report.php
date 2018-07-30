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
              <div class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span>Financial Report </div>
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
                
           <form class="cmxform" id="edit_admin_profile_frm" method="POST" action="<?php echo SURL?>finance/manage-financial_statistics/financial_report" enctype="multipart/form-data">     
               
           
             <div class="row form-group">
                              <label class="col-md-2 hidden-sm" style="margin-right: -106px;">From :</label>
                              <div class="col-xs-2 hidden-sm" id="fromdate">
                                   <div class="input-group"><input type="text" readonly style="cursor:pointer;" name="from_date" id="from_date" class="form-control" required  value="<?php echo $from_date; ?>"/><span class="input-group-addon"><span id="targetto" onclick="create_date('fromdate')" class="glyphicon glyphicon-calendar" style="cursor:pointer;"></span></span>
	                        </div>
                            </div>
            
                              <label class="col-md-2 hidden-sm" style="margin-right: -113px;">To :</label>
                              <div class="col-xs-2 hidden-sm" id="todate">
                                   <div class="input-group"><input type="text" readonly style="cursor:pointer;" name="to_date" id="to_date" class="form-control" required value="<?php echo $to_date; ?>" /><span class="input-group-addon"><span id="targetto" onclick="create_date('todate')" class="glyphicon glyphicon-calendar" style="cursor:pointer;"></span></span>
	                        </div>
                            </div>
                            
                        <!-- <span class="hidden-sm" style="margin-top: 10px;position: absolute; font-weight:bold;">  OR</span>-->
          
                        <div class="col-md-2 col-sm-4">
                           <select id="branch_id" name="branch_id" class="form-control" style="width: 126%;height: 34px;margin-left: 20px;">
                           <option value="">Search by Branch</option>
                                <?php
								if($branches_count>0){ 
								for($c=0; $c < $branches_count ; $c++){ ?>
										<option value="<?php echo $branches_arr[$c]['id'] ?>" <?php 
										if($branches_arr[$c]['id']!=0){
										if($branch_id==$branches_arr[$c]['id']){ ?> selected <?php } } ?>><?php echo $branches_arr[$c]['branch_name'];?></option>
								<?php }} ?>
                          </select>
            
                        </div>     
            
                <div class="form-group" align="right" style="margin-right:258px">
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
                      <th>Detail</th>
                      <th>Income (PKR)</th>
                      <th>Expense (PKR)</th>
                      <th>Balance (PKR)</th>
                    
                    </tr>
                  </thead>
                  <tbody>
                            <tr>
                                <td></td>
                                <td><b>Carry Forward</b></td>
                                <td>-</td>
                                <td><b><?php if($projects_report['gincome']!="") { echo number_format($projects_report['gincome'],2,".",","); } else{ echo "0";}?></b></td>
                                <td><b><?php if($projects_report['gexpenses']!="") { echo number_format($projects_report['gexpenses'],2,".",",");}else{echo "0";};?></b></td>
                                <td><b><?php  $balance= $projects_report['gincome']-$projects_report['gexpenses']; echo number_format($balance,2,".",",");?></b> </td>
                              
                    </tr>
                           
                           
              <?php if($projects_report_count >0){ 
						
					    for($i=0; $i<$projects_report_count; $i++){	 
						
						
							$balance= (($balance + $projects_report_data[$i]['income']) - $projects_report_data[$i]['expense']) ;
						    $total_income+=$projects_report_data[$i]['income'];
							$total_expense+=$projects_report_data[$i]['expense'];
						  ?> 
                          
                           <tr>
                                <td><?php echo ($i+1);?></td>
                                <td><?php echo date('F j, Y', strtotime($projects_report_data[$i]['dated']));?></td>
                                <td><?php echo  $projects_report_data[$i]['description']; ?></td>
                                <td><?php echo  number_format($projects_report_data[$i]['income'],2,".",",") ?></td>
                                <td><?php echo  number_format($projects_report_data[$i]['expense'],2,".",",") ?></td>
                                <td><?php echo  number_format($balance,2,".",",")?></td>
                              
                           </tr>
                       
                       <?php }//End for ?>
                       
                       
                       
                           <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><b>Total Income: <?php echo  number_format($total_income,2,".",",")  ?></b></td>
                                <td><b>Total Expense: <?php echo number_format($total_expense,2,".",",") ?></b></td>
                                <td></td>
                              
                           </tr>
					   
					  <?php  }//End if ?>
                    
                  </tbody>
                </table>
                
               


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
