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

<body <?php if(isset($expense_id) && $expense_id !=""){ ?> onLoad="PrintPreview()"  <?php } ?>>
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
              <div class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span>Expense Report </div>
             <span style="margin-left: 780px;"></span>
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
                
           <form class="cmxform" id="edit_admin_profile_frm" method="POST" action="<?php echo SURL?>finance/manage-financial_statistics/expense_report" enctype="multipart/form-data">     
               
           
             <div class="row form-group">
                              <label class="col-md-2 hidden-sm" style="margin-right: -106px;">From :</label>
                              <div class="col-xs-2 hidden-sm" id="fromdate">
                                   <div class="input-group"><input type="text" readonly style="cursor:pointer;" name="from_date" id="from_date" class="form-control" required value="<?php echo $from_date; ?>" /><span class="input-group-addon"><span id="targetto" onclick="create_date('fromdate')" class="glyphicon glyphicon-calendar" style="cursor:pointer;"></span></span>
	                        </div>
                            </div>
            
                              <label class="col-md-2 hidden-sm" style="margin-right: -113px;">To :</label>
                              <div class="col-xs-2 hidden-sm" id="todate">
                                   <div class="input-group"><input type="text" readonly style="cursor:pointer;" name="to_date" id="to_date" class="form-control" required  value="<?php echo $to_date; ?>"/><span class="input-group-addon"><span id="targetto" onclick="create_date('todate')" class="glyphicon glyphicon-calendar" style="cursor:pointer;"></span></span>
	                        </div>
                            </div>
                       
                       <!-- <span class="hidden-sm" style="margin-top: 10px;position: absolute; font-weight:bold;">  OR</span>-->
          
                        <div class="col-md-2 col-sm-4">
                           <select id="branch_id" name="branch_id" class="form-control" style="width: 123%;height: 34px;margin-left: 20px;">
                           <option value="">Search by Branch</option>
                                <?php
								if($branches_count>0){ 
								for($c=0; $c < $branches_count ; $c++){ ?>
										<option value="<?php echo $branches_arr[$c]['id'] ?>" <?php 
										if($branches_arr[$c]['id']!=0){
										if($branch_id==$branches_arr[$c]['id']){ ?> selected <?php  }} ?>><?php echo $branches_arr[$c]['branch_name'];?></option>
								<?php }} ?>
                          </select>
            
                        </div>      
            
                <div class="form-group" align="right" style="margin-right:252px">
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
                      <th>Expense (PKR)</th>
                       <th>Branch Name</th>
                      <th>Options</th>
                   
                    </tr>
                  </thead>
                  <tbody>
                        
                           
              <?php if($expense_report_count >0){ 
						
						
					    for($i=0; $i<$expense_report_count; $i++){	 
						      
							  $total_expenses+= $expense_report_data[$i]['expense'];
						  ?> 
                          
                           <tr>
                                <td><?php echo ($i+1);?></td>
                                <td><?php echo date('d, M Y', strtotime($expense_report_data[$i]['dated']));?></td>
                                <td><?php echo  $expense_report_data[$i]['description']; ?></td>
                                <td><?php echo  number_format($expense_report_data[$i]['expense'],2,".",",") ?></td>
                                <td><?php echo $expense_report_data[$i]['branch_name'];?></td>
                                <td class="hidden-xs text-center">
                              <form action="<?php echo base_url()?>finance/manage-financial-statistics/expense-report" method="post" >  
                           <button type="submit" value="Print" class="btn btn-info btn-gradient" title="Print"><span class="glyphicons glyphicons-print"></span></button>                             <input type="hidden" name="expense_id" value="<?php echo $expense_report_data[$i]['id'] ?>" >
                              </form>
                                <?php 
                                    if($ALLOW_user_edit == 1){ 
								?>
                                        <a href="<?php echo base_url()?>finance/manage-financial-statistics/edit-expense/<?php echo $expense_report_data[$i]['id'] ?>" type="button" class="btn btn-info btn-gradient" title="Edit Expense"> <span class="glyphicons glyphicons-edit"></span></a>                                
                                <?php	
									}//end if
									
									if($ALLOW_user_delete == 1){ 
								?>
                                	<a href="<?php echo base_url()?>finance/manage-financial-statistics/delete-expense/<?php echo $expense_report_data[$i]['id'] ?>" onClick="return confirm('Are you sure you want to delete?')" type="button" class="btn btn-danger btn-gradient" title="Delete Expense"> <span class="glyphicons glyphicons-remove"></span> </a>
                                <?php	
									}//end if

                                 ?></td>
                              
                           </tr>
                       
                       <?php
					   
						    }//End for
					   
					  ?>
                        
                        <tr>
                                <td></td>
                                <td></td>
                                <td><b>Page Total:</b></td>
                                <td><b><?php echo  number_format($total_expenses,2,".",",")?> (PKR)</b></td>
                                <td></td>
                                <td></td>
                              
                      </tr>
                    
				 
				  <table width="359" border="1" style="width: 100%;height: 34px; border: rgb(194, 192, 191);">
                   <tr>
                       <td width="721" align="right"><b>Grand Total</b> &nbsp;&nbsp;</td>
                       <td width="339"><b>&nbsp;&nbsp;<?php echo   number_format($grand_total,2,".",",") ?> (PKR)</b></td>
                  </tr>
                 </table>
				 
				 
				 <?php } else{
					?>	
                        <tr>
	                        <th colspan="8">
                                <div class="alert alert-danger alert-dismissable">
                                No Record(s) Found </div>
                            </th>
                        </tr>
                    <?php		
						}//end if($admin_user_list_count > 0)
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


<div id="printarea" style="margin-left: 251px;margin-top: -33px; display:none; "><!--  Start Print Priview --------->
 <?php
 
    $expense_id;
	
    $query=mysql_query("select * from inno_projects_account where id='$expense_id' ") ;
		  
	$row=mysql_fetch_assoc($query);	
  
 ?> 
 <table width="100%" border="0" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; border:#000 1px solid;">
  <tr>
    <td colspan="2" bgcolor="#CCCCCC" style="font-size:14px; font-weight:bold;">Purchase vouchar</td>
  </tr>
  <tr>
    <td colspan="2" align="right"><input type="button" value="Print" onClick="window.print() "></td>
  </tr>
  <tr>
    <td width="19%"><strong>Vouchar Date :</strong></td>
    <td width="81%"><?php echo  date('j F, Y');  ?></td>
  </tr>
  <tr>
    <td width="19%"><strong>Date :</strong></td>
    <td width="81%"><?php echo  date('j F, Y', strtotime($row['dated']))  ?></td>
  </tr>
  <tr>
    <td width="19%"><strong>Amount (PKR) :</strong></td>
    <td width="81%"><?php echo number_format($row['expense'],2,".",",");  ?></td>
  </tr>
  <tr>
    <td colspan="2"><strong>Details</strong></td>
  </tr>
  <tr>
    <td colspan="2"><?php echo $row['description'];  ?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">Director Signature : ___________________</td>
  </tr>
   <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
   <tr>
    <td colspan="2">&nbsp;</td>
  </tr> 
	 
</table>

</div><!--  End Print Priview --------->


<!-- End: Main --> 
<!-- Start: Footer -->
<footer> <?php echo $INC_footer;?> </footer>
<!-- End: Footer --> 
<?php echo $INC_header_script_footer;?>

<script type="text/javascript">
/*--This JavaScript method for Print command--*/
    function PrintDoc() {
        var toPrint = document.getElementById('printarea');
        var popupWin = window.open('', '_blank', 'width=600,height=700,location=no,left=200px');
        popupWin.document.open();
        popupWin.document.write('<html><title>::Preview::</title><link rel="stylesheet" type="text/css" href="print.css" /></head><body onload="window.print()">')
        popupWin.document.write(toPrint.innerHTML);
        popupWin.document.write('</html>');
        popupWin.document.close();
    }
/*--This JavaScript method for Print Preview command--*/
    function PrintPreview() {
        var toPrint = document.getElementById('printarea');
        var popupWin = window.open('', '_blank', 'width=600,height=400,location=no,left=200px');
        popupWin.document.open();
        popupWin.document.write('<html><title>::Print Preview::</title><link rel="stylesheet" type="text/css" href="Print.css" media="screen"/></head><body">')
        popupWin.document.write(toPrint.innerHTML);
        popupWin.document.write('</html>');
        popupWin.document.close();
    }
</script>

</body>
</html>
