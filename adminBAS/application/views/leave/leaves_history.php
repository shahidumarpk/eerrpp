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
        <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
        <link rel="stylesheet" href="docsupport/style.css">
        <link rel="stylesheet" href="<?php echo SURL; ?>assets/css/chosen.css">
        <link rel="stylesheet" href="<?php echo VENDOR; ?>plugins/datatables/css/datatables.min.css">
        
        <link rel="stylesheet" href="<?php echo VENDOR; ?>plugins/datepicker/css/bootstrap-datetimepicker.css">
        <link rel="stylesheet" href="<?php echo VENDOR; ?>plugins/datepicker/JS/bootstrap-datetimepicker.js">
        
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/i18n/jquery-ui-i18n.js">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.css">
        

        

        <link href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css">
        

        <!--<script src="https://cdn.datatables.net/1.10.11/js/dataTables.bootstrap.min.js"></script>-->
        

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
            
<span id="display_name"><?php // echo $this->session->userdata('display_name'); ?></span>

            <div class="table-responsive">
            
            <table class="table table-striped table-bordered table-hover" id="manage_leaves_m" style="padding:15px;">
                    <thead>
                      <tr>
                        <th class="hidden-xs">#</th>
                        <th class="hidden-xs">User Name</th>
                        <th class="hidden-xs">Leave Type</th>
                        <th class="hidden-xs">From Date</th>
                        <th class="hidden-xs">To Date</th>
                        <th class="hidden-xs">Days</th>
                        <th class="hidden-xs">Status</th>
                      </tr>
                    </thead>                                  
            <tbody>
                        <?php foreach($leaves as $leave => $val){ 

                            ?>
                
            
                        <tr>
            <span id="getstatus<?php echo $val['id']; ?>"  hidden="true"><?php echo $val['status']; ?></span>
            <span id="disapprove<?php echo $val['id']; ?>"  hidden="true"><?php echo $val['disapprove_reason']; ?></span>
                            <td id="<?php echo $val['id']; ?>"><?php echo $val['id']; ?></td>
                        <td>                            
                                <span id="name<?php echo $val['id']; ?>"><?php echo $val['user_name']; ?></span>                            
                        </td>
                            
                            <td>
                            <!--<a href="javascript:void(0)" id="type<?php // echo $val['id']; ?>" class="">-->
                                <span id="type<?php echo $val['id']; ?>" style="font-weight:bold">
                            <?php
                            if($val['leave_type'] == 'c'){
                                echo "Casual";
                            }else if($val['leave_type'] == 's'){
                                echo "Sick";
                            }else if ($val['leave_type'] == 'a'){
                                echo "Annual";
                            }
                            
                            ?></span>
                                <!--</a>-->
                            </td>
                        
                            <td id="from_date<?php echo $val['id']; ?>"><?php echo date("d-m-Y", strtotime($val['from_date'])); ?></td>
                        <td>
                            <span id="to_date<?php echo $val['id']; ?>"><?php echo date("d-m-Y", strtotime($val['to_date'])); ?> </span>
                            <span id="description<?php echo $val['id'] ?>" hidden>
                                <?php echo $val['description'] ?>
                            </span>
                        </td>   
                        <td><?php echo $val['days'] ?></td>
                        
                        
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
        <h4 class="modal-title">My Leave</h4>
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
        <footer> <?php echo $INC_footer; ?> </footer>
        <!-- End: Footer --> 
<?php echo $INC_header_script_footer; ?>
        
        <style>
    
    #manage_leaves_m_length,
    #manage_leaves_m_filter{
       
    }
        </style>
<script src="<?php echo VENDOR; ?>plugins/datatables/js/jquery.dataTables.js"></script>                    
<!--<script src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.js"></script>-->
<script>
    
    $(document).ready(function() {
        $('#manage_leaves_m').dataTable({
            "pagingType": "full_numbers",
             "iDisplayLength": 20,
             "order": [[ 0, "desc" ]],
             "aoColumnDefs": [{ 'bSortable': false, 'aTargets': [ -1,-4,-5 ] }],
             "sDom": 'T<"panel-menu dt-panelmenu"lfr><"clearfix">tip',
        });
    });  
    
    $("body").on("click", ".leave_modal", function(){
       var id = $(this).attr("id");

       var type = $("#type"+id).html();
       var display_name = $("#display_name").html();
//       console.log(display_name);
       var from_date = $("#from_date"+id).html();
       var to_date = $("#to_date"+id).html();
       var description = $("#description"+id).html();
       var name = $("#name"+id).html();
       var status = $("#status"+id).html();
       console.log(status);
       var disapprove_reason = $("#disapprove"+id).html();
       console.log(disapprove);
       
       
       if(status == 'Approved'){
           status = "<span class='label btn-info'>"+status+"</span>";
       }else if(status == 'Rejected'){
           status = "<span class='label btn-danger'>"+status+"</span>";
       }else{
           status = "<span class='label btn-success'>"+status+"</span>";
       }
       var getstatus = $("#getstatus"+id).html();
//       console.log(getstatus);
       var disapprove; 
      if(getstatus == 1){
            getstatus = "<div class='row'><div class='col-md-12'><h3 class='text-center'>Offical User Only</h3></div></div><div class='row' style='margin-bottom:30px;'><div class='col-md-3'></div><span id='approve_reject'><div class='col-md-3'><span class='label btn-success' onclick='showapprove();' style='cursor: pointer;'>Approved</span></div>";
            disapprove = "<div class='col-md-6'><span class='label btn-danger' onclick='showreason();' style='cursor: pointer;'>Reject</span></div></span></div>";
       }else if(getstatus == 2){
           getstatus = "<div class='row'><div class='col-md-4'><h3>Application Status</h3></div><div class='col-md-8'><p>Your application is approved by HR department.</p></div></div>";
           disapprove = "";
       }else if(getstatus == 3){
           getstatus = "";
           disapprove = "<div class='row'><div class='col-md-4'><h3>Application Status</h3></div><div class='col-md-8'><p>Your application is Reject by HR department.</p></div></div>";
           disapprove += "<div class='row'><div class='col-md-4'><h3>Reasons:</h3></div><div class='col-md-8'><p>"+disapprove_reason+"</p></div></div>";
       }
              
var showApproveButton = "<div class='container' id='showApproveButton' hidden><div class='row'><div class='col-md-12'><p>Are you sure you want to approve application?</p></div>";
    showApproveButton += "<form><div class='col-md-12'><p><input id='withpay' type='radio' name='leavetype_pay' value='1'><label for='withpay'>Withpay</label> <input id='withoutpay' type='radio' name='leavetype_pay' value='0'><label for='withoutpay'>Withoutpay</label> </p></div></form>";
    showApproveButton += "<div class='col-md-8'><button class='btn btn-info' onclick='approved();' style='width:50%;'>Approve</button></div></div></div>";
var showDisapproveButton = "<div class='container'><div class='row'  id='reason' hidden><div class='col-md-10'><textarea id='disapprove' rows='4'style='width:100%';></textarea><p class='text-right'>Application reject reasons.</p></div><div class='col-md-10'><button type='button' class='btn btn-primary' onclick='Reject();' style='width:50%;'>Reject</button></div>      </div></div>"

//       console.log(type +"--"+from_date+"--"+to_date+"--"+ description);
       var html = "<span hidden id='myid'>"+id+"</span><div class='row'> <div class='col-md-12 text-center'><h3>Niku Solution Pvt Ltd.</h3><h4>Leave Application</h4></div> </div>";
        html += "<div class='row'><div class='col-md-6 leave-style'><p><b>Leave Type</b></p></div><div class='col-md-6 leave-style'><p>" + type + "</p></div><div class='col-md-6 leave-style'><p><b>User Name</b></p></div><div class='col-md-6 leave-style'><p>"+name+"</p></div>" +"<div class='col-md-6 leave-style'><p><b>From</b></p></div><div class='col-md-6 leave-style'><p>"+from_date+"</p></div><div class='col-md-6 leave-style'><p><b>To</b></p></div><div class='col-md-6 leave-style'><p>"+to_date+"</p></div><div class='col-md-6 leave-style'><p><b>Description</b></p></div><div class='col-md-6 leave-style'><p>"+description+"</p></div>  <div class='col-md-6'>"+status+"     </div></div>          <hr style='border:1px solid black'>";
        
        html += ""+getstatus+disapprove+"";

        html += showApproveButton;        
        html += showDisapproveButton;
        
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
        $("#reason").removeAttr("hidden");
        $("#approve_reject").attr("hidden", true);
    }
    function showapprove(){
        $("#showApproveButton").removeAttr("hidden");
        $("#approve_reject").attr("hidden", true);
    }
    function approved(){
        var id = $("#myid").html();
        console.log(id);
        $("#approved").removeAttr("hidden");
        var checked = document.querySelector('input[name="leavetype_pay"]:checked').value;
        console.log(checked);
        $.ajax({
           url:'<?php echo SURL."leave/leave/leave_approved_process"; ?>',
           type:'post',
           data:{id:id, checked:checked},
        }).success(function(data){
//            console.log(data);
            window.location.reload();
        }).fail(function(){
            
        });
    }
    function Reject(){
        var id = $("#myid").html();        
        var disapprove = $("#disapprove").val();
        console.log(disapprove);
        $.ajax({
           url:'<?php echo SURL."leave/leave/leave_Reject_process"; ?>',
           type:'post',
           data:{id:id, disapprove:disapprove},
        }).success(function(result){
            console.log(result);
            window.location.reload();
        }).fail(function(){
            
        });
    }
    

</script>
    </body>
</html>