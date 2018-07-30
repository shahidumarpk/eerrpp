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
          <div class="panel">
            <div class="panel-heading">
              <div class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span>Expected Income</div>
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


                 <form class="cmxform" id="edit_admin_profile_frm" method="POST" action="<?php echo SURL?>finance/manage-financial_statistics" enctype="multipart/form-data">     
               
           
             <div class="row form-group ">
                              <label class="col-md-2 col-sm-3 hidden-sm " style="margin-right: -106px;">From :</label>
                              <div class="col-xs-2 hidden-sm" id="fromdate">
                                   <div class="input-group"><input type="text" readonly style="cursor:pointer;" name="from_date" id="from_date" class="form-control" required value="<?php echo $from_date; ?>" /><span class="input-group-addon"><span id="targetto" onclick="create_date('fromdate')" class="glyphicon glyphicon-calendar" style="cursor:pointer;"></span></span>
	                        </div>
                            </div>
            
                              <label class="col-md-2 hidden-sm " style="margin-right: -113px;">To :</label>
                              <div class="col-xs-2 hidden-sm" id="todate">
                                   <div class="input-group"><input type="text" readonly style="cursor:pointer;" name="to_date" id="to_date" class="form-control" required value="<?php echo $to_date; ?>" /><span class="input-group-addon"><span id="targetto" onclick="create_date('todate')" class="glyphicon glyphicon-calendar" style="cursor:pointer;"></span></span>
	                        </div>
                            
                            </div>
            
       <!--  <span class="hidden-sm" style="margin-left: 3px;margin-top: 8px;position: absolute; font-weight:bold;">  OR</span>-->
         
                     <div class="col-md-2 col-sm-5" style="width: 259px;">
                           <select id="project_id" name="project_id" style="width:100%;" >
                           <option value="">All Project</option>
                                <?php
								if($projects_all_count >0){ 
								for($c=0; $c < $projects_all_count ; $c++){ ?>
										<option value="<?php echo $projects_arr[$c]['id'] ?>"><?php echo $projects_arr[$c]['project_title']; ?></option>
								<?php } }?>
                          </select>
                        </div>
             
                        
        <!--  <span style="margin-left: 22px;margin-top: 10px;position: absolute; font-weight:bold;">  OR</span>-->
          
                        <div class="col-md-2 col-sm-3">
                           <select id="branch_id" name="branch_id" style="width:100%;" >
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
                        
            
                <div class="form-group col-sm-1" align="left" style="margin-left: 51px;">
                        <input class="submit btn btn-blue" type="submit" name="search_sbt" id="search_sbt" value="Search" />
                </div>    
             
             </div>         
 </form>
<br>

             
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th width="17">#</th>
                      <th width="120">Project Title</th>
                      <th width="68">End Date</th>
                      <th width="97">Project Amount</th>
                      <th width="106">Received Amount</th>
                      <th width="104">Remaining Amount</th>
                    
                    </tr>
                  </thead>
                  <tbody>
                  	<?php
				        $page_total="";
						$total_remain_amount="";
						$total_received_amount=""; 
						if($projects_list_count > 0){
							for($i=0;$i<$projects_list_count;$i++){
								
								$page_total+=$projects_list_result[$i]['project_amount'];
								
								$remain_amount=$projects_list_result[$i]['project_amount'] - $projects_list_result[$i]['received_amount'];
								
								$total_received_amount+=$projects_list_result[$i]['received_amount'];
								$total_remain_amount+=$remain_amount;
					?>
                            <tr>
                                <td><?php echo ($i+1);?></td>
                                <td><a class="anchor_style" href="<?php echo base_url()?>projects/manage-projects/project-detail/<?php echo $projects_list_result[$i]['id'] ?>" target="_blank" ><?php echo $projects_list_result[$i]['project_title'];?></a>
                                
                               <?php if($projects_list_result[$i]['is_important']==1){?><span class="label btn-red">Star</span><?php } ?>
                               <?php 
					                if($ALLOW_user_project_label == 1 && $projects_list_result[$i]['project_label'] !=""  ){ 
					           ?>
                                      <br><br><span class="label btn-orange2 "><?php echo $projects_list_result[$i]['project_label']; ?></span>
                                      
                              <?php  } ?> 
                                
                                </td>
                               
                                <td><?php echo date('d, M Y', strtotime($projects_list_result[$i]['end_date']) );?></td>
                                <td><?php echo  number_format($projects_list_result[$i]['project_amount'],2,".",",");?> </td>
                                <td><?php echo  number_format($projects_list_result[$i]['received_amount'],2,".",",");?> </td>
                                <td><?php echo  number_format($remain_amount,2,".",",");?> </td>
                                
                            </tr>
                    <?php		
							
						}//enf for
					?>
                            <tr>
                          
                              <td></td>
                              <td></td>
                              <td></td>
                              <td><b><?php echo number_format($page_total,2,".",","); ?></b></td>
                               <td><b><?php echo number_format($total_received_amount,2,".",","); ?></b></td>
                                <td><b><?php echo number_format($total_remain_amount,2,".",","); ?></b></td>
                            </tr>
                            
              <table width="359" border="1" style="width: 100%;height: 34px; border: rgb(194, 192, 191);">
                   <tr>
                       <td width="766" align="right"><b>Grand Total</b> &nbsp;&nbsp;</td>
                       <td width="294"><b>&nbsp;&nbsp;<?php echo number_format($grand_total,2,".",","); ?></b></td>
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
<link href="<?php echo CSS ;?>select2.css" rel="stylesheet"/>
<script src="<?php echo JS ; ?>select2.js"></script>
<script>
$(document).ready(function() { $("#project_id").select2(); });
</script>

<script>
$(document).ready(function() { $("#branch_id").select2(); });
</script>

</body>
</html>
