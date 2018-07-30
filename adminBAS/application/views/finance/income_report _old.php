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
              <div class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span>Income Report </div>
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
                
           <form class="cmxform" id="edit_admin_profile_frm" method="POST" action="<?php echo SURL?>finance/manage-financial_statistics/income_report" enctype="multipart/form-data">     
               
           
             <div class="row form-group">
                              <label class="col-md-2" style="margin-right: -106px;">From :</label>
                              <div class="col-xs-2" id="fromdate">
                                   <div class="input-group"><input type="text" readonly="readonly" style="cursor:pointer;" name="from_date" id="from_date" class="form-control" required /><span class="input-group-addon"><span id="targetto" onclick="create_date('fromdate')" class="glyphicon glyphicon-calendar" style="cursor:pointer;"></span></span>
	                        </div>
                            </div>
            
                              <label class="col-md-2" style="margin-right: -113px;">To :</label>
                              <div class="col-xs-2" id="todate">
                                   <div class="input-group"><input type="text" readonly="readonly" style="cursor:pointer;" name="to_date" id="to_date" class="form-control" required /><span class="input-group-addon"><span id="targetto" onclick="create_date('todate')" class="glyphicon glyphicon-calendar" style="cursor:pointer;"></span></span>
	                        </div>
                            </div>
            
                <div class="form-group" align="right" style="margin-right:451px">
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
                      <th>Income</th>
                    
                      <th>Balance (USD)</th>
                    
                    </tr>
                  </thead>
                  <tbody>
                            <tr>
                                <td></td>
                                <td><b>Carry Forward</b></td>
                                <td></td>
                                <td><b><?php echo  $projects_report['gincome'];?></b></td>
                              
                                <td><b><?php echo $balance= $projects_report['gincome']-$projects_report['gexpenses'] ;?></b> </td>
                              
                    </tr>
                           
                           
              <?php if($projects_report_count >0){ 
						
					    for($i=0; $i<$projects_report_count; $i++){	 
						
						
							$balance= (($balance + $projects_report_data[$i]['income'])) ;
						
						  ?> 
                          
                           <tr>
                                <td><?php echo ($i+1);?></td>
                                <td><?php echo date('F j, Y', strtotime($projects_report_data[$i]['dated']));?></td>
                             <td><?php echo  $projects_report_data[$i]['description']; ?></td>
                                <td><?php echo  $projects_report_data[$i]['income']; ?></td>
                               
                                <td><?php echo  $balance; ?></td>
                              
                           </tr>
                       
                       <?php
					   
						    }//End for
					   
					    }//End if ?>
                    
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
