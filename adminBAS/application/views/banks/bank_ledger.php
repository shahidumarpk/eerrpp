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
   <!------------------------------------------ Email Protion   --------------->
<div id="email" style="display:block;">

<?php $email_data .="<h3  style='text-align:center;'>Bank Ledger</h3>
 
                <table align='center' class='table table-bordered' style='font-size:12px;' width='100%'>
                  <thead style='background: #B1D6F6;color: #000;text-align: left;vertical-align: bottom;'>
				  <tr>
                      <th colspan='4' align='left' >From Date:  ".date('d, M Y', strtotime($from_date))."&nbsp;&nbsp;&nbsp;&nbsp; To Date:  ". date('d, M Y', strtotime($to_date))."</th>
                      <th colspan='2'>Date:".date('d, M Y', strtotime(date("d-m-Y")))."</th>
                    </tr>
                    <tr>
                      <th width='17'>&nbsp;</th>
                      <th width='88'>&nbsp;</th>
                      <th width='235'>&nbsp;</th>
                      <th width='73'>&nbsp;</th>
                      <th width='89'>&nbsp;</th>
                      <th width='56'>&nbsp;</th>
                    </tr>
					<tr>
                      <th>#</th>
                      <th>Date</th>
                      <th>Detail</th>
                      <th>Receivable</th>
                      <th>Paid </th>
                      <th>Balance </th>
                    
                    </tr>
                  </thead>
                  <tbody>
                            <tr style='border-left: 1px solid #cbcbcb;border-width: 0 0 0 1px;margin: 0;overflow: visible;padding: .5em 1em; background-color: #f2f2f2;'>
                                <td></td>
                                <td><b>Carry Forward</b></td>
                                <td>-</td>
                                <td><b>";
							 if($projects_report['total_cashin']!=""){ $email_data.= number_format($projects_report['total_cashin'],2,'.',',') ;}else{ echo "0";}
							
							$email_data.="</b></td>
                                <td><b>";
								
								if($projects_report['total_cashout']!="") { $email_data.=  number_format($projects_report['total_cashout'],2,".",",");}else{echo "0";};
								
								$email_data.="</b></td>
                                <td><b>".number_format($balance_email= $projects_report['total_cashin'] - $projects_report['total_cashout']);"</b> </td>
                              
                    </tr>";
                       
              if($projects_report_count >0){ 
						
						
					    for($i=0; $i<$projects_report_count; $i++){	 
						
						
						if ($projects_report_data[$i]['payment_confirm_status']==1) { 
						
							$balance= (($balance + $projects_report_data[$i]['cash_in']) - $projects_report_data[$i]['cash_out']) ;
						    $totalin_email+=$projects_report_data[$i]['cash_in'];
							$totalout_email+=$projects_report_data[$i]['cash_out'];
						}
							//$balance= (($balance + $projects_report_data[$i]['cash_in']) - $projects_report_data[$i]['cash_out']) ;
						   // $totalin_email+=$projects_report_data[$i]['cash_in'];
							//$totalout_email+=$projects_report_data[$i]['cash_out'];
						
                       if ($projects_report_data[$i]['payment_confirm_status']==1) {   
                         
                        $email_data.= "<tr style='background-color: #f2f2f2; font-size:11px;'>
                                <td>".($i+1)."</td>
                                <td>".date('d, M Y', strtotime($projects_report_data[$i]['created_date']))."</td>
                                <td>".$projects_report_data[$i]['description']."</td>
                                <td>".number_format($projects_report_data[$i]['cash_in'],2,".",",")."</td>
                                <td>".number_format($projects_report_data[$i]['cash_out'],2,".",",")."</td>
                                <td>".number_format($balance,2,".",",")."</td>
                              
                           </tr>";
                       
                       }
                       
                       }//End for 
                       
                           $email_data.="<tr style='background-color: #B1D6F6; font-size:11px;'>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><b>Total :".number_format($totalin_email,2,".",",")."</b></td>
                                <td><b>Total :".number_format($totalout_email,2,".",",")."</b></td>
                                <td></td>
                              
                           </tr>";
					   
					  }//End if
                    
                 $email_data.=" </tbody>
                </table>";

?>
</div>


<!------------------------------------------ End Email Protion   --------------->
  
  <section id="content"> <?php echo $INC_breadcrum?>
    <div class="container">
      <div class="row">
        <div class="col-md-12"  style="min-height:1300px;">
          <div class="panel">
            <div class="panel-heading">
              <div class="row">
                        <div class="col-md-10">
                           <div class="panel-title hidden-xs"> <span class="glyphicon glyphicon-list"></span>Bank Ledger <code class="btn-success">Approved</code> </div>
                        </div>
                        
                        <div class="col-md-1" align="right">
                         <form action="<?php echo base_url()?>banks/manage-banks/send-email-ledger" method="post" >  
                           <button type="submit" value="Email" class="btn btn-info btn-gradient" title="Send Email"><span class="glyphicons glyphicons-envelope"></span></button>                             
                           
                           <input type="hidden" name="email_record" value="<?php echo htmlentities($email_data);?>" >
                           
                         </form>
                        </div>
                        
                        <div class="col-md-1" align="right">
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
                
           <form class="cmxform" id="edit_admin_profile_frm" method="POST" action="<?php echo SURL?>banks/manage-banks/bank-ledger" enctype="multipart/form-data">     
               
           
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
                            
           
          
                        <div class="col-md-2">
                           <select id="bank_id" name="bank_id" class="form-control" style="width: 139%%;height: 34px;margin-left: 20px;">
                           <option value="0">All Banks</option>
                                <?php
								if($banks_count>0){ 
								for($c=0; $c <$banks_count ; $c++){ ?>
										<option value="<?php echo $banks_arr[$c]['id'] ?>" <?php 
										if($banks_arr[$c]['id']!=0){
										if($bank_id==$banks_arr[$c]['id']){ ?> selected <?php } } ?>><?php echo $banks_arr[$c]['acc_title'];?></option>
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
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th width="17">#</th>
                      <th width="116">Date</th>
                      <th width="126">Transaction Date</th>
                      <th width="223">Detail</th>
                      <th width="210">Payment Proof</th>
                      <th width="79">Receivalbe </th>
                      <th width="62">Paid </th>
                      <th width="62">Balance </th>
                    
                    </tr>
                  </thead>
                  <tbody>
                            <tr>
                                <td></td>
                                <td><b>Carry Forward</b></td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                
                                <td><b><?php if($projects_report['total_cashin']!="") { echo number_format($projects_report['total_cashin'],2,".",","); } else{ echo "0";}?></b></td>
                                <td><b><?php if($projects_report['total_cashout']!="") { echo number_format($projects_report['total_cashout'],2,".",",");}else{echo "0";};?></b></td>
                                <td><b><?php  $balance= $projects_report['total_cashin']-$projects_report['total_cashout']; echo number_format($balance,2,".",",");?></b> </td>
                             
                    </tr>
                           
                           
              <?php if($projects_report_count >0){ 
						
					    for($i=0; $i<$projects_report_count; $i++){	 
						
					    	if ($projects_report_data[$i]['payment_confirm_status']==1){
							$balance= (($balance + $projects_report_data[$i]['cash_in']) - $projects_report_data[$i]['cash_out']) ;
						    $total_income+=$projects_report_data[$i]['cash_in'];
							$total_expense+=$projects_report_data[$i]['cash_out'];
					    	}
						  ?> 
                          <?php if ($projects_report_data[$i]['payment_confirm_status']==1) { ?>
                           <tr>
                                <td><?php echo ($i+1);?></td>
                                <td><?php echo  date('d, M Y', strtotime($projects_report_data[$i]['created_date']));?></td>
                                 <td><?php echo  date('d, M Y', strtotime($projects_report_data[$i]['transaction_date']));?></td>
                                
                                <td><?php echo  $projects_report_data[$i]['description']; ?></td>
                                <td>
                                <?php if($projects_report_data[$i]['payment_proof'] !="" ){?>
                                <a href="<?php  echo MURL."assets/payment_proof/".$projects_report_data[$i]['payment_proof']?>"  data-toggle="lightbox" data-gallery="multiimages" data-title="Payment Proof"><img src="<?php  echo MURL."assets/payment_proof/".$projects_report_data[$i]['payment_proof']?>" width="87" height="119" style="width:160px;"  data-holder-rendered="false"></a>
                                
                                <?php }else{echo "-";} ?>
                                
                                </td>
                                <td><?php echo  number_format($projects_report_data[$i]['cash_in'],2,".",",") ?></td>
                                <td><?php echo  number_format($projects_report_data[$i]['cash_out'],2,".",",") ?></td>
                                <td><?php echo  number_format($balance,2,".",",")?></td>
                              
                           </tr>
                        <?php } ?>
                       <?php }//End for ?>
                       
                       
                       
                           <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><b>Total: <?php echo  number_format($total_income,2,".",",")  ?></b></td>
                                <td><b>Total: <?php echo number_format($total_expense,2,".",",") ?></b></td>
                                
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
<div id="printable" style="display: none;">
 <h3  style="text-align:center;">Bank Ledger </h3>
 <table class="table table-bordered" style="font-size:15px;" width="100%">
                  <thead style="background: #e0e0e0;color: #000;text-align: left;vertical-align: bottom;">
                  <tr bgcolor="#CCCCCC">
                      <th colspan="4" align="left">From Date: <?php echo $from_date; ?>&nbsp; &nbsp;&nbsp; &nbsp; To Date: <?php echo $to_date; ?></th>
                      <th colspan="2">Date: <?php echo date('d, M Y', strtotime(date("d-m-Y")));?></th>
                    </tr>
                    <tr>
                      <th width="17">&nbsp;</th>
                      <th width="105">&nbsp;</th>
                      <th width="264">&nbsp;</th>
                      <th width="61">&nbsp;</th>
                      <th width="66">&nbsp;</th>
                      <th width="57">&nbsp;</th>
                    </tr>
                    <tr>
                      <th>#</th>
                      <th>Date</th>
                      <th>Detail</th>
                      <th>Cash In </th>
                      <th>Cash Out </th>
                      <th>Balance</th>
                    
                    </tr>
                  </thead>
                  <tbody>
                            <tr style="border-left: 1px solid #cbcbcb;border-width: 0 0 0 1px;font-size: inherit;margin: 0;overflow: visible;
padding: .5em 1em; background-color: #f2f2f2;">
                                <td></td>
                                <td><b>Carry Forward</b></td>
                                <td>-</td>
                                <td><b><?php if($projects_report['total_cashin']!="") { echo number_format($projects_report['total_cashin'],2,".",","); } else{ echo "0";}?></b></td>
                                <td><b><?php if($projects_report['total_cashout']!="") { echo number_format($projects_report['total_cashout'],2,".",",");}else{echo "0";};?></b></td>
                                <td><b><?php  $balance= $projects_report['total_cashin']-$projects_report['total_cashout']; echo number_format($balance,2,".",",");?></b> </td>
                             
                    </tr>
                           
                           
              <?php if($projects_report_count >0){ 
						
					    for($i=0; $i<$projects_report_count; $i++){	
						 
						if ($projects_report_data[$i]['payment_confirm_status']==1) { 
						
							$balance= (($balance + $projects_report_data[$i]['cash_in']) - $projects_report_data[$i]['cash_out']) ;
						    $totalincome+=$projects_report_data[$i]['cash_in'];
							$totalexpense+=$projects_report_data[$i]['cash_out'];
						}
						  ?> 
                          <?php if ($projects_report_data[$i]['payment_confirm_status']==1) { ?>
                           <tr style="background-color: #f2f2f2; font-size:13px;">
                                <td><?php echo ($i+1);?></td>
                                <td><?php echo date('d, M Y', strtotime($projects_report_data[$i]['created_date']));?></td>
                                <td><?php echo  $projects_report_data[$i]['description']; ?></td>
                                <td><?php echo  number_format($projects_report_data[$i]['cash_in'],2,".",",") ?></td>
                                <td><?php echo  number_format($projects_report_data[$i]['cash_out'],2,".",",") ?></td>
                                <td><?php echo  number_format($balance,2,".",",")?></td>
                              
                           </tr>
                       
                       <?php } }//End for ?>
                       
                       
                       
                           <tr style="background-color: #e0e0e0;">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><b>Total: <?php echo  number_format($totalincome,2,".",",")  ?></b></td>
                                <td><b>Total: <?php echo number_format($totalexpense,2,".",",") ?></b></td>
                                <td>&nbsp;</td>
                               
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
</body>
</html>
