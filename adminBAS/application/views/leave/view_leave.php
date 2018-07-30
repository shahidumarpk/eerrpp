<?php // echo "<pre>";print_r($this->session->all_userdata());exit; ?>
<?php // echo "<pre>";print_r($leaves);exit; ?>
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

        <link rel="stylesheet" href="docsupport/style.css">
        <link rel="stylesheet" href="<?php echo SURL; ?>assets/css/chosen.css">
        
        <link rel="stylesheet" href="<?php echo VENDOR; ?>plugins/datepicker/css/bootstrap-datetimepicker.css">
        <link rel="stylesheet" href="<?php echo VENDOR; ?>plugins/datepicker/JS/bootstrap-datetimepicker.js">
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/i18n/jquery-ui-i18n.js">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.css">
        
        <link rel="stylesheet" href="<?php echo VENDOR; ?>plugins/datatables/css/datatables.css">
        
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
            <section id="content"> <?php echo $INC_breadcrum ?>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12" style="min-height:1300px;">
                            <div class="panel">
                                <div class="panel-heading">

<?php
?>
                                    <div class="panel-title"> <span class="glyphicon glyphicon-book"></span> 
                                    <?php // echo 'ADD'.$title.' '.'Entry'; ?>
                                    <?php echo 'View Leave' ?>
                                    </div>
                                </div>
    <div class="panel-body alerts-panel" >

    <div class="tab-content border-none padding-none">
        <div id="cms_main_contents" class="tab-pane active">
<?php
if ($this->session->flashdata('err_message')) {
    ?>
    <div class="alert alert-danger"><?php echo $this->session->flashdata('err_message'); ?></div>
        <?php
        }//end if($this->session->flashdata('err_message'))

        if ($this->session->flashdata('ok_message')) {
            ?>
            <div class="alert alert-success alert-dismissable"><?php echo $this->session->flashdata('ok_message'); ?></div>
            <?php
        }//if($this->session->flashdata('ok_message'))
        ?>
            


            <div class="table-responsive">
            
            <table class="table table-striped table-bordered table-hover" id="view_leaves" style="padding:15px;">
                    <thead>
                      <tr>
                        <th class="hidden-xs">#</th>
                        <th class="hidden-xs">User Name</th>
                        <th class="hidden-xs">Leave Type</th>
                        <th class="hidden-xs">From Date</th>
                        <th class="hidden-xs">To Date</th>
                        <th class="hidden-xs">Status</th>
                        
                        <!--<th class="hidden-xs ">Description</th>-->
                      </tr>
                    </thead>                                  
            <tbody>
                        <?php foreach($leaves as $leave => $val){ 

                            ?>
                
            
                        <tr>
            <span id="getstatus<?php echo $val['id']; ?>"  hidden="true"><?php echo $val['status']; ?></span>
            <span id="disapprove<?php echo $val['id']; ?>"  hidden="true"><?php echo $val['disapprove_reason']; ?></span>
            
            <span id="admin_id<?php echo $val['id']; ?>"  hidden="true"><?php echo $val['user_id']; ?></span>
            
                            <td id="id<?php echo $val['id']; ?>"><?php echo $val['id']; ?></td>
                        <td>
                            <a href="javascript:void(0)" id="<?php echo $val['id']; ?>" class="leave_modal">
                                <span id="name<?php echo $val['id']; ?>"><?php echo $val['user_name']; ?></span>
                            </a>
                        </td>
                            
                            <td>
                            <a href="javascript:void(0)" id="<?php echo $val['id']; ?>" class="leave_modal">
                                <span style="font-weight:bold">
                            <?php
                                if($val['leave_type'] == 'c'){
                                    echo "Casual";
                                }else if($val['leave_type'] == 's'){
                                    echo "Sick";
                                }else if ($val['leave_type'] == 'a'){
                                    echo "Annual";
                                }                            
                            ?></span></a>
                            </td>
                        
                        <td id="from_date<?php echo $val['id']; ?>"><?php echo date("d-m-Y", strtotime($val['from_date'])); ?></td>
                        <td>
                            <span id="to_date<?php echo $val['id']; ?>"><?php echo date("d-m-Y", strtotime($val['to_date'])); ?> </span>
                            <span id="description<?php echo $val['id'] ?>" hidden>
                                <?php echo $val['description'] ?>
                            </span>
                            <span id="ddays<?php echo $val['id'] ?>" hidden>
                                <?php echo $val['days'] ?>
                            </span>
                        </td>   
                        
                        <!--application status-->
                        <td>
                            
                            <?php if($val['status'] == 1){ ?>                            
                                <span id="status<?php echo $val['id']; ?>" class="label btn-success">Inprogress</span>                                
                            <?php }else if($val['status'] == 2){ ?>
                                <span id="status<?php echo $val['id']; ?>" class="label btn-info">Approved</span>   
                            <?php }else{ ?>
                                <span id="status<?php echo $val['id']; ?>" class="label btn-danger">Rejected</span>   
                            <?php } ?>                            
                        </td>
                        
                    </tr>
                     <?php } ?>
                    
                    </tbody>
                  </table>
                
                 </div>  
                
        </div>
              
</div>

                        </div>
                    </div>            
                </div>
            </div>
        </div>
                    
                    
                    
                    
    </div>
</section>
            
            
            
<!-- End: Content --> 

        </div>
        
        
        
    
        
<!-- Modal -->
<div id="myModaal" class="modal" role="dialog">
  <div class="modal-dialog">

      
      
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Application</h4>
      </div>
      <div class="modal-body">
        <p>Leave Type</p>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>  
        
        
        <!-- End: Main --> 
        <!-- Start: Footer -->
        
        <!-- End: Footer --> 
<?php echo $INC_header_script_footer; ?>
     <footer> <?php echo $INC_footer; ?> </footer>   
<script src="<?php echo VENDOR; ?>plugins/datatables/js/jquery.dataTables.js"></script>


<script>
    $(document).ready(function() {
        $('#view_leaves').dataTable({
            "pagingType": "full_numbers",
            "iDisplayLength": 20,
            "order": [[ 0, "desc" ]],
            "sDom": 'T<"panel-menu dt-panelmenu"lfr><"clearfix">tip',
        });
    }); 
    $("body").on("click", ".leave_modal", function(){
        
       var id = $(this).attr("id");
//console.log(id);
       var type = $("#"+id).html();
//       console.log(type);
       var display_name = $("#display_name").html();
//       console.log(display_name);
       var from_date = $("#from_date"+id).html();
       var to_date = $("#to_date"+id).html();
       var ddays = $("#ddays"+id).html();
       var description = $("#description"+id).html();
       var name = $("#name"+id).html();
       var status = $("#status"+id).html();
       var admin_id = $("#admin_id"+id).html();
       if(status == 'Rejected'){
           status = '<div class="col-md-6"><span class="label btn-danger">Rejectedd</span></div>';
       }else if(status == "Approved"){
           status = '<div class="col-md-6"><span class="label btn-info">Approved</span></div>';
       }else if(status == 'Inprogress'){
           status = '<div class="col-md-6"><span class="label btn-success">Inprgress</span></div>';
       }
       console.log(status);
       var disapprove_reason = $("#disapprove"+id).html();
//       console.log(disapprove);
       
       var getstatus = $("#getstatus"+id).html();
//       console.log(getstatus);
       var disapprove;
       if(getstatus == 1){
           getstatus = "";
           disapprove = "";
       }else if(getstatus == 2){
           getstatus = "<div class='row'><div class='col-md-4'><h3>Application Status</h3></div><div class='col-md-8'><p>Your application is approved by HR department.</p></div></div>";
           disapprove = "";
       }else if(getstatus == 3){
           getstatus = "";
           disapprove = "<div class='row'><div class='col-md-4'><h3>Application Status</h3></div><div class='col-md-8'><p>Your application is Reject by HR department.</p></div></div>";
           disapprove += "<div class='row'><div class='col-md-4'><h3>Reasons:</h3></div><div class='col-md-8'><p>"+disapprove_reason+"</p></div></div>";
       }
//       console.log(getstatus);alert("hello getstatus");
       console.log(type +"--"+from_date+"--"+to_date+"--"+ description);
       var html = "<span hidden id='myid'>"+id+"</span><div class='row'> <div class='col-md-12 text-center'><h3>Niku Solution Pvt Ltd.</h3><h4>Leave Application</h4></div> </div>";
        html += "<div class='row'><div class='col-md-6 leave-style'><p><b>Leave Type</b></p></div><div class='col-md-6 leave-style'><p>" + type + "</p></div><div class='col-md-6 leave-style'><p><b>User Name</b></p></div><div class='col-md-6 leave-style'><p>"+name+"   <b><a href='<?php echo base_url()."leave/leave/leave_history/"?>"+admin_id+"' target='_blank' id='history' -style='color:#3fa9f5'>(History)</a></b></p>   </div>" +"<div class='col-md-6 leave-style'><p><b>From</b></p></div><div class='col-md-6 leave-style'><p>"+from_date+"</p></div><div class='col-md-6 leave-style'><p><b>To</b></p></div><div class='col-md-6 leave-style'><p>"+to_date+"</p></div>       <div class='col-md-6 leave-style'><p><b>Days</b></p></div><div class='col-md-6 leave-style'><p>"+ddays+"</p></div>          <div class='col-md-6 leave-style'><p><b>Description</b></p></div><div class='col-md-6 leave-style'><p>"+description+"</p></div>  "+status+"    </div>          <hr style='border:1px solid black'>";
        
        html += ""+getstatus+disapprove+"";
                
        html += "<div class='row'  id='reason' hidden ><div class='row'> <div class='col-md-3 col-md-offset-1'>Reject Reason:</div><div class='col-md-6'><textarea id='disapprove'></textarea></div>      </div>";
        html += "<div class='row'><div class='col-md-6'></div><button type='button' class='btn btn-primary'>Submit</button></div></div>";
        html += "<div class='row' id='approved' hidden><div class='col-md-6'></div><div class='col-md-6' style='margin-top:20px;'>Approved By "+ display_name +" HR</div><div class='col-md-6'></div><div class='col-md-6' style='margin-top:20px;'>Date: "+ new Date(); +"</div> </div>";
       $(".modal-body").html(html);
       $("#myModaal").modal("show");
       
    });    
</script>
<style>
    .leave-style{
        margin-bottom: 6px;
    }
</style>
<script>
    function showreason(){        
        var b = true;
        if(b == true){
            $("#reason").removeAttr("hidden");
            var b = false;
        }else{
            $("#reason").attr("hidden");
            b == true;
        }
//        $("#reason").attr("display", "block");
    }
 
</script>
    </body>
</html>