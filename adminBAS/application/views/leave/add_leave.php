<?php
$session_post_data = $this->session->userdata('add-page-data');

$get_type_text = $type;

if ($get_type_text == 'tardy') {
    $title = " TARDY PAYROLL";
} else if ($get_type_text == 'incentive') {
    $title = " INCENTIVE PAYROLL";
} else {
    $title = " FINE PAYROLL";
}
?>
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
                                    <?php echo 'Apply Leave' ?>
                                    </div>
                                </div>
<div class="panel-body alerts-panel">
<form class="cmxform" id="apply_leave_process" method="POST" action="<?php echo SURL ?>leave/leave/apply_leave_process" enctype="multipart/form-data">
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

        <div class="row">
            <div class="col-md-6">

                <div class="row form-group">
                    <div class="col-md-4" style="">
                        <label for="standard-list1">Select type</label>

    <select name="leave_type" id="type" data-placeholder="Choose a Type" class="chosen-select"  style="width: 100%;">
       <option value="s">Sick Leave</option>
        <option value="c">Casual Leave</option>
        <option value="a">Annual Leave</option>
    </select>   
        </div>
    </div>
</div>

</div>

    <div class="row form-group">

    <div class="row">
        <div class="col-md-6">
            <label class="col-md-4">Date From</label>
        </div>

    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="col-xs-6">
                <div class="input-group">
                    <input type="text" style="cursor:pointer;" name="from_date" data-provide="datepicker" id="from_date" class="form-control" required />
                    <span class="input-group-addon">
                        <span id="from_date" class="glyphicon glyphicon-calendar" style="cursor:pointer;"></span></span>
                </div>
            </div>
        </div>
    </div>
        
        <div class="row">
            <div class="col-md-6">
                <label class="col-md-4">Date To</label>
            </div>
            
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="col-xs-6" id="todate">
                    
                    <div class="input-group">
                        <input type="text" style="cursor:pointer;" name="to_date" id="to_date" class="form-control datepicker" required />
                        <span class="input-group-addon">
                            <span id="targetto" class="glyphicon glyphicon-calendar" style="cursor:pointer;"></span>                                
                        </span>
                    </div>
                    <!--days counts-->
        <div class="form-group">
            <input type="text" name="ddays" id="ddays" readonly="" value='' class="form-control">
        </div>                        
                    
            </div>

        </div>
    </div>
        

        

    </div>    

    <div class="form-group">
        <label for="title">Description</label>
        <textarea class="form-control"  name="description"  id="description" rows="3" ></textarea>
    </div>

    
                       
</div>



<div class="form-group" align="right" style="margin-right:17px">
    <input class="submit btn btn-blue" type="submit" name="Ap_Leave" id="Add_Leave" value=" Apply Leave" title="Click to Apply Leave" />
</div>
                            </div>

                        </form>
                    </div>            
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End: Content --> 

        </div>
        <!-- End: Main --> 
        <!-- Start: Footer -->
        <footer> <?php echo $INC_footer; ?> </footer>
        <!-- End: Footer --> 
<?php echo $INC_header_script_footer; ?>
        <script src="<?php echo SURL; ?>assets/js/chosen.jquery.js" type="text/javascript"></script>
        <script type="text/javascript">
             
            $("#from_date").datepicker({
                onSelect: function (dateText) {

                                                                getDatesDifference2();
                                                            }
            });
            $("#to_date").datepicker({
               onSelect: function (dateText) {

                                                            getDatesDifference2();

                                                        }
            });
            
            
            var config = {
            '.chosen-select'           : {},
                    '.chosen-select-deselect'  : {allow_single_deselect:true},
                    '.chosen-select-no-single' : {disable_search_threshold:10},
                    '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                    '.chosen-select-width'     : {width:"95%"}
            }
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }
        </script>


        <link href="<?php echo CSS; ?>select2.css" rel="stylesheet"/>
        <script src="<?php echo JS; ?>select2.js"></script>       

        
        
        <script type="text/javascript">
            
            jQuery(document).ready(function() {

            // validate signup form on keyup and submit
            $("#apply_leave_process").validate({
                rules: {
                    from_date : 'required',
                    to_date : 'required',
                    description: 'required',
                },
            });                        
        });
        
        
            function getDatesDifference2() {
                var dAlloc;
            var dateAllocation = dAlloc= $('#from_date').val();
            var dateReleased = $('#to_date').val();

            dateAllocation = dateAllocation.split("/");
            dateReleased = dateReleased.split("/");
            var d1;
            var d2;
            var weekcount = 0;
            var days = 0;
            var v1 = dateAllocation[0] + ',' + dateAllocation[1] + ',' + dateAllocation[2];
            var v2 = dateReleased[0] + ',' + dateReleased[1] + ',' + dateReleased[2];
            // 
            var t=0; var dd=0; 
         
            if (v1 != "" && v2 != "") {
                d1 = new Date(v1).getTime();
                d2 = new Date(v2).getTime();

                t = (parseInt(d2) - parseInt(d1));

                dd = 60 * 60 * 24;

                days = ((t / (60 * 60 * 24)) / 1000)+1;
                var tdays = days;
                
            }

            if (isNaN(days)) {
                days = 0;
            }
            if (isNaN(tdays)) {
                tdays = 0;
            }
            

//            $("#bookingperiod").html(parseInt(weekcount) + " Weeks, " + days + " Days");
            $("#ddays").val(days);

        }//
        
        </script>
           


    </body>
</html>