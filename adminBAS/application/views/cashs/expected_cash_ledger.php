<!DOCTYPE html>
<html>
<head>

<!-- Meta, title, CSS, favicons, etc. -->
<meta charset="utf-8">
<title><?php echo $meta_title ?></title>
<meta name="keywords" content="<?php echo $meta_keywords ?>" />
<meta name="description" content="<?php echo $meta_description ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style type="text/css">

  
 </style>
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
            <div class="row">
                        <div class="col-md-10">
                           <div class="panel-title hidden-xs"> <span class="glyphicon glyphicon-list"></span>Cash Ledger <code class="btn-danger">Expected</code></div>
                        </div>
                        <div class="col-md-2" align="right">
                        <button class="submit btn btn-blue" onclick="printPage('printable');">Print</button>
                       
                        
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
                
           <form class="cmxform" id="edit_admin_profile_frm" method="POST" action="<?php echo SURL?>cashs/manage-cashs/expected-cash-ledger" enctype="multipart/form-data">     
               
           
             <div class="row form-group">
                              <label class="col-md-2" style="margin-right: -106px;">From :</label>
                              <div class="col-xs-2" id="fromdate">
                                   <div class="input-group"><input type="text" readonly style="cursor:pointer;" name="from_date" id="from_date" class="form-control" required  value="<?php if($from_date==""){ echo  date('m/d/Y'); }else{ echo $from_date; }?>"/><span class="input-group-addon"><span id="targetto" onclick="create_date('fromdate')" class="glyphicon glyphicon-calendar" style="cursor:pointer;"></span></span>
	                        </div>
                            </div>
            
                              <label class="col-md-2" style="margin-right: -113px;">To :</label>
                              <div class="col-xs-2" id="todate">
                                   <div class="input-group"><input type="text" readonly style="cursor:pointer;" name="to_date" id="to_date" class="form-control" required value="<?php if($to_date==""){ echo  date('m/d/Y',strtotime('+1 day', strtotime(date('m/d/Y'))));}else{ echo $to_date; }?>" /><span class="input-group-addon"><span id="targetto" onclick="create_date('todate')" class="glyphicon glyphicon-calendar" style="cursor:pointer;"></span></span>
	                        </div>
                            </div>
                            
            
                <span style="margin-top: 10px;position: absolute; font-weight:bold;">  OR</span>
          
                        <div class="col-md-2">
                           <select id="cash_id" name="cash_id" class="form-control" style="width: 139%%;height: 34px;margin-left: 20px;">
                           <option value="">Search by Petty Cash</option>
                                <?php
								if($cashs_count>0){ 
								for($c=0; $c < $cashs_count ; $c++){ ?>
										<option value="<?php echo $cashs_arr[$c]['id'] ?>" <?php 
										if($cashs_arr[$c]['id']!=0){
										if($cash_id==$cashs_arr[$c]['id']){ ?> selected <?php } } ?>><?php echo $cashs_arr[$c]['title'];?></option>
								<?php }} ?>
                          </select>
            
                        </div>     
            
                <div class="form-group" align="right" style="margin-right:240px">
                        <input class="submit btn btn-blue" type="submit" name="search_sbt" id="search_sbt" value="Search" />
                </div>   
             
             </div>         
 </form>
<br>
                         

              <div class="table-responsive">
              
              <div class="alert alert-warning" role="alert">
      <strong>Alert..!</strong> Once the payment approved then, you can't undo this action.
    </div>
              
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Date</th>
                      <th>Detail</th>
                      <th>Payment Proof</th>
                      <th>Cash In (PKR)</th>
                      <th>Cash Out (PKR)</th>
                      <th>Balance (PKR)</th>
                      <th>Approve</th>
                    
                    </tr>
                  </thead>
                  <tbody>
                            <tr>
                                <td></td>
                                <td><b>Carry Forward</b></td>
                                <td>-</td>
                                <td>-</td>
                                <td><b><?php if($projects_report['total_cashin']!="") { echo number_format($projects_report['total_cashin'],2,".",","); } else{ echo "0";}?></b></td>
                                <td><b><?php if($projects_report['total_cashout']!="") { echo number_format($projects_report['total_cashout'],2,".",",");}else{echo "0";};?></b></td>
                                <td><b><?php  $balance= $projects_report['total_cashin']-$projects_report['total_cashout']; echo number_format($balance,2,".",",");?></b> </td>
                              <td></td>
                    </tr>
                           
                           
              <?php if($projects_report_count >0){ 
						
						
						
					    for($i=0; $i<$projects_report_count; $i++){	 
						
					    	if ($projects_report_data[$i]['payment_confirm_status']==0) {
							$balance= (($balance + $projects_report_data[$i]['cash_in']) - $projects_report_data[$i]['cash_out']) ;
						    $total_income+=$projects_report_data[$i]['cash_in'];
							$total_expense+=$projects_report_data[$i]['cash_out'];
					    	}
						  ?> 
                          <?php if ($projects_report_data[$i]['payment_confirm_status']==0) { ?>
                           <tr>
                                <td><?php echo ($i+1);?></td>
                                <td><?php echo date('F j, Y', strtotime($projects_report_data[$i]['created_date']));?></td>
                                <td><?php echo  $projects_report_data[$i]['description']; ?></td>
                               <td><a href="<?php  echo MURL."assets/payment_proof/".$projects_report_data[$i]['payment_proof']?>"  data-toggle="lightbox" data-gallery="multiimages" data-title="Payment Proof"><img style="width:160px;" src="<?php  echo MURL."assets/payment_proof/".$projects_report_data[$i]['payment_proof']?>"  data-holder-rendered="false"  ></a></td>
                                <td><?php echo  number_format($projects_report_data[$i]['cash_in'],2,".",",") ?></td>
                                <td><?php echo  number_format($projects_report_data[$i]['cash_out'],2,".",",") ?></td>
                                <td><?php echo  number_format($balance,2,".",",")?></td>
                              <td><a title="Approve Payment" class="btn btn-success btn-sm" href="<?php echo SURL?>cashs/manage-cashs/approve-ledger-payment/<?php echo $projects_report_data[$i]['id']; ?>" role="button">Approve Payment</a></td>
                           </tr>
                       <?php } ?>
                       <?php }//End for ?>
                       
                       
                       
                           <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><b>Total CashIn: <?php echo  number_format($total_income,2,".",",")  ?></b></td>
                                <td><b>Total CashOut: <?php echo number_format($total_expense,2,".",",") ?></b></td>
                                <td></td>
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

<!------------------------------------------ Print Protion   --------------->
<div id="printable" style="display:none;">
 <h3  style="text-align:center;">Cash Ledger </h3>
 
                <table class="table table-bordered">
                  <thead>
                    <tr bgcolor="#CCCCCC">
                      <th colspan="2" align="left">From Date: <?php echo $from_date; ?></th>
                      <th colspan="2" align="center">To Date: <?php echo $to_date; ?></th>
                      <th colspan="2">Date: <?php echo date('F j, Y', strtotime(date("d-m-Y")));?></th>
                    </tr>
                    <tr>
                      <th width="17">&nbsp;</th>
                      <th width="132">&nbsp;</th>
                      <th width="48">&nbsp;</th>
                      <th width="122">&nbsp;</th>
                      <th width="110">&nbsp;</th>
                      <th width="105">&nbsp;</th>
                    </tr>
                    <tr bgcolor="#CCCCCC">
                      <th>#</th>
                      <th>Date</th>
                      <th>Detail</th>
                      <th>Cash In (PKR)</th>
                      <th>Cash Out (PKR)</th>
                      <th>Balance (PKR)</th>
                    
                    </tr>
                  </thead>
                  <tbody>
                            <tr >
                                <td></td>
                                <td><b>Carry Forward</b></td>
                                <td>-</td>
                                <td><b><?php if($projects_report['total_cashin']!="") { echo number_format($projects_report['total_cashin'],2,".",","); } else{ echo "0";}?></b></td>
                                <td><b><?php if($projects_report['total_cashout']!="") { echo number_format($projects_report['total_cashout'],2,".",",");}else{echo "0";};?></b></td>
                                <td><b><?php  $balance= $projects_report['total_cashin']-$projects_report['total_cashout']; echo number_format($balance,2,".",",");?></b> </td>
                              
                    </tr>
                           
                           
              <?php if($projects_report_count >0){ 
						
						
					    for($i=0; $i<$projects_report_count; $i++){	 
						
						
							$balance= (($balance + $projects_report_data[$i]['cash_in']) - $projects_report_data[$i]['cash_out']) ;
						    $totalin+=$projects_report_data[$i]['cash_in'];
							$totalout+=$projects_report_data[$i]['cash_out'];
						  ?> 
                          
                           <tr>
                                <td><?php echo ($i+1);?></td>
                                <td><?php echo date('F j, Y', strtotime($projects_report_data[$i]['created_date']));?></td>
                                <td><?php echo  $projects_report_data[$i]['description']; ?></td>
                                <td><?php echo  number_format($projects_report_data[$i]['cash_in'],2,".",",") ?></td>
                                <td><?php echo  number_format($projects_report_data[$i]['cash_out'],2,".",",") ?></td>
                                <td><?php echo  number_format($balance,2,".",",")?></td>
                              
                           </tr>
                       
                       <?php }//End for ?>
                       
                       
                       
                           <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><b>Total : <?php echo  number_format($totalin,2,".",",")  ?></b></td>
                                <td><b>Total : <?php echo number_format($totalout,2,".",",") ?></b></td>
                                <td></td>
                              
                           </tr>
					   
					  <?php  }//End if ?>
                    
                  </tbody>
                </table>

</div>
<!------------------------------------------ End Print Protion   --------------->


<!-- End: Main --> 
<!-- Start: Footer -->
<footer> <?php echo $INC_footer;?> </footer>
<!-- End: Footer --> 
<?php echo $INC_header_script_footer;?>



<script>
function printPage(id) {
    var html="<html>";
    html+= document.getElementById(id).innerHTML;
    html+="</html>";
    var printWin = window.open('','','left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status =0');
    printWin.document.write(html);
    printWin.document.close();
    printWin.focus();
    printWin.print();
    printWin.close();
}


</script>
<script src="<?php echo JS?>ekko-lightbox.js"></script>
     <script type="text/javascript">
            $(document).ready(function ($) {
                // delegate calls to data-toggle="lightbox"
                $(document).delegate('*[data-toggle="lightbox"]:not([data-gallery="navigateTo"])', 'click', function(event) {
                    event.preventDefault();
                    return $(this).ekkoLightbox({
                        onShown: function() {
                            if (window.console) {
                                return console.log('Checking our the events huh?');
                            }
                        },
						onNavigate: function(direction, itemIndex) {
                            if (window.console) {
                                return console.log('Navigating '+direction+'. Current item: '+itemIndex);
                            }
						}
                    });
                });

                //Programatically call
                $('#open-image').click(function (e) {
                    e.preventDefault();
                    $(this).ekkoLightbox();
                });
                

				// navigateTo
                $(document).delegate('*[data-gallery="navigateTo"]', 'click', function(event) {
                    event.preventDefault();
                    return $(this).ekkoLightbox({
                        onShown: function() {

							var a = this.modal_content.find('.modal-footer a');
							if(a.length > 0) {

								a.click(function(e) {

									e.preventDefault();
									this.navigateTo(2);

								}.bind(this));

							}

                        }
                    });
                });


            });
        </script>
</body>
</html>
