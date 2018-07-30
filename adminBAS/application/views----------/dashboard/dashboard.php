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
        <div class="col-md-12" style="min-height:1200px;">
          <div id="console-btns">
          
           <?php 
			$c = 0;

			foreach($nav_panel_arr as $main_menu_index => $main_menu){
				
				if(in_array($main_menu['menu_id'],$this->session->userdata('permissions_arr'))){
					
					if($main_menu['status']  == 1){
				
					

		?>
            
              <div class="col-sm-6 col-md-3">
                <a href="<?php echo ($main_menu['url_link'] == '#') ? '#main_menu_'.$main_menu_index  : SURL.$main_menu['url_link']?>" >
                <div class="console-btn">
                  <div class="console-icon divider-right"> <span class="glyphicons <?php echo $main_menu['menu_icon_class']?>"></span> </div>
                  <div class="console-text">
                    <div class="console-title"><?php echo $main_menu['menu_title']?></div>
                    <div class="console-subtitle">View More <i class="fa fa-caret-right"></i> </div>
                  </div>
                </div>
                   </a>
              </div>
           
              
     <?php   
					}//end if($main_menu['status']  == 1)
				
				}//end if(in_array($main_menu_index,$this->session->userdata('permissions_arr')))
				
			}//end foreach
			
		?>      
           
             
            
           
              <div class="col-sm-6 col-md-3">
                <a href="javascript:void(0);" onClick="fetch_tickets();"><div class="console-btn">
                  <div class="console-icon divider-right"> <span class="glyphicons glyphicons-download"></span> </div>
                  <div class="console-text">
                    <div class="console-title">Fetch Tickets</div>
                    <div class="console-subtitle">&nbsp;</div>
                  </div>
                </div></a>
              </div>
         
            
            <?php
			
			
	
			if($project_messages_count >0){ ?>
            
            <?php  for($i=0; $i<$project_messages_count; $i++)
			 {
		    ?>
			
            
			<p><strong>Project Name: <?php echo $project_messages_arr[$i]['project_title'];  ?></strong>  : <a href="<?php echo base_url()?>projects/manage-projects/project-detail/<?php echo $project_messages_arr[$i]['project_id'] ?>" >(<?php echo $project_messages_arr[$i]['num_messages'];?>) New Messages</a></p>
            
            
            
          <?php } }  ?>
            <div class="row">
              <div class="col-sm-12" id="ticket_response">
                
              </div>
            </div>
           
          </div>
        </div>
      </div>
      
      <!--
          <hr class="short margin-top-none">
          <div class="row">
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-12"> </div>
    
            <div class="col-md-12">
            <div class="row">
                <div class="col-md-2">
                            <div class="input-group"> <span class="input-group-addon"><i class="fa fa-calendar"></i> </span>
                              <input type="text" id="datepicker" class="form-control datepicker margin-top-none" placeholder="23/9/2013">
                            </div>
                  </div>
            </div>
            <div class="clearfix"> &nbsp; </div>
              <div class="panel panel-visible">
                <div class="panel-heading">
                
                  <div class="panel-title hidden-xs"> <span class="glyphicon glyphicon-tasks"></span> Editable Data Table</div> 
                </div>
                <div class="panel-body padding-bottom-none">
                  <table class="table table-striped table-bordered table-hover" id="datatable">
                    <thead>
                      <tr>
                        <th>Editable</th>
                        <th class="hidden-xs">Creator</th>
                        <th>Labels</th>
                        <th class="visible-lg">Software license</th>
                        <th class="hidden-xs hidden-sm">Current layout engine</th>
                        <th>Cost (USD)</th>
                        <th class="text-center hidden-xs">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><span class="xedit">Try Me!</span></td>
                        <td class="hidden-xs"><span class="xedit">Henry Ford</span></td>
                        <td class="hidden-xs hidden-sm"><span class="label label-info">CSS</span></td>
                        <td class="visible-lg">GNU GPLv3</td>
                        <td>FSkit</td>
                        <td>Free</td>
                        <td class="hidden-xs text-center"><div class="btn-group">
                            <button type="button" class="btn btn-info btn-gradient"> <span class="glyphicons glyphicons-edit"></span> </button>
                            <button type="button" class="btn btn-success btn-gradient"> <span class="glyphicons glyphicons-remove"></span> </button>
                            <button type="button" class="btn btn-danger btn-gradient dropdown-toggle" data-toggle="dropdown"> <span class="glyphicons glyphicons-cogwheel"></span> </button>
                            <ul class="dropdown-menu checkbox-persist pull-right text-left" role="menu">
                              <li><a><i class="fa fa-user"></i> View Profile </a></li>
                              <li><a><i class="fa fa-envelope-o"></i> Message </a></li>
                            </ul>
                          </div></td>
                      </tr>
                      <tr>
                        <td><span class="xedit">Try Me!</span></td>
                        <td class="hidden-xs"><span class="xedit">Roger Rights</span></td>
                        <td class="hidden-xs hidden-sm"><span class="label btn-orange2 margin-right-sm">HTML</span><span class="label btn-dark">Java</span></td>
                        <td class="visible-lg">GNU GPLv3</td>
                        <td>Webkit</td>
                        <td>License</td>
                        <td class="hidden-xs text-center"><div class="btn-group">
                            <button type="button" class="btn btn-info btn-gradient"> <span class="glyphicons glyphicons-edit"></span> </button>
                            <button type="button" class="btn btn-success btn-gradient"> <span class="glyphicons glyphicons-remove"></span> </button>
                            <button type="button" class="btn btn-danger btn-gradient dropdown-toggle" data-toggle="dropdown"> <span class="glyphicons glyphicons-cogwheel"></span> </button>
                            <ul class="dropdown-menu checkbox-persist pull-right text-left" role="menu">
                              <li><a><i class="fa fa-user"></i> View Profile </a></li>
                              <li><a><i class="fa fa-envelope-o"></i> Message </a></li>
                            </ul>
                          </div></td>
                      </tr>
                      <tr>
                        <td><span class="xedit">Try Me!</span></td>
                        <td class="hidden-xs"><span class="xedit">Goblin Jones</span></td>
                        <td class="hidden-xs hidden-sm"><span class="label btn-green">PHP</span></td>
                        <td class="visible-lg">CF2</td>
                        <td>FSkit</td>
                        <td>Contract</td>
                        <td class="hidden-xs text-center"><div class="btn-group">
                            <button type="button" class="btn btn-info btn-gradient"> <span class="glyphicons glyphicons-edit"></span> </button>
                            <button type="button" class="btn btn-success btn-gradient"> <span class="glyphicons glyphicons-remove"></span> </button>
                            <button type="button" class="btn btn-danger btn-gradient dropdown-toggle" data-toggle="dropdown"> <span class="glyphicons glyphicons-cogwheel"></span> </button>
                            <ul class="dropdown-menu checkbox-persist pull-right text-left" role="menu">
                              <li><a><i class="fa fa-user"></i> View Profile </a></li>
                              <li><a><i class="fa fa-envelope-o"></i> Message </a></li>
                            </ul>
                          </div></td>
                      </tr>
                      <tr>
                        <td><span class="xedit">Try Me!</span></td>
                        <td class="hidden-xs"><span class="xedit">David Fleece</span></td>
                        <td class="hidden-xs hidden-sm"><span class="label btn-red">Python</span></td>
                        <td class="visible-lg">CC V2</td>
                        <td>Webkit</td>
                        <td>Free</td>
                        <td class="hidden-xs text-center"><div class="btn-group">
                            <button type="button" class="btn btn-info btn-gradient"> <span class="glyphicons glyphicons-edit"></span> </button>
                            <button type="button" class="btn btn-success btn-gradient"> <span class="glyphicons glyphicons-remove"></span> </button>
                            <button type="button" class="btn btn-danger btn-gradient dropdown-toggle" data-toggle="dropdown"> <span class="glyphicons glyphicons-cogwheel"></span> </button>
                            <ul class="dropdown-menu checkbox-persist pull-right text-left" role="menu">
                              <li><a><i class="fa fa-user"></i> View Profile </a></li>
                              <li><a><i class="fa fa-envelope-o"></i> Message </a></li>
                            </ul>
                          </div></td>
                      </tr>
                      <tr>
                        <td><span class="xedit">Try Me!</span></td>
                        <td class="hidden-xs"><span class="xedit">Mary Shark</span></td>
                        <td class="hidden-xs hidden-sm"><span class="label btn-blue2 margin-right-sm">Javascript</span><span class="label btn-green">PHP</span></td>
                        <td class="visible-lg">GNU GPLv3</td>
                        <td>FSkit</td>
                        <td>License</td>
                        <td class="hidden-xs text-center"><div class="btn-group">
                            <button type="button" class="btn btn-info btn-gradient"> <span class="glyphicons glyphicons-edit"></span> </button>
                            <button type="button" class="btn btn-success btn-gradient"> <span class="glyphicons glyphicons-remove"></span> </button>
                            <button type="button" class="btn btn-danger btn-gradient dropdown-toggle" data-toggle="dropdown"> <span class="glyphicons glyphicons-cogwheel"></span> </button>
                            <ul class="dropdown-menu checkbox-persist pull-right text-left" role="menu">
                              <li><a><i class="fa fa-user"></i> View Profile </a></li>
                              <li><a><i class="fa fa-envelope-o"></i> Message </a></li>
                            </ul>
                          </div></td>
                      </tr>
                      <tr>
                        <td><span class="xedit">Try Me!</span></td>
                        <td class="hidden-xs"><span class="xedit">Alexander Right</span></td>
                        <td class="hidden-xs hidden-sm"><span class="label btn-alert"> A Warm Heart</span></td>
                        <td class="visible-lg">GNU GPLv3</td>
                        <td>Webkit</td>
                        <td>Contract</td>
                        <td class="hidden-xs text-center"><div class="btn-group">
                            <button type="button" class="btn btn-info btn-gradient"> <span class="glyphicons glyphicons-edit"></span> </button>
                            <button type="button" class="btn btn-success btn-gradient"> <span class="glyphicons glyphicons-remove"></span> </button>
                            <button type="button" class="btn btn-danger btn-gradient dropdown-toggle" data-toggle="dropdown"> <span class="glyphicons glyphicons-cogwheel"></span> </button>
                            <ul class="dropdown-menu checkbox-persist pull-right text-left" role="menu">
                              <li><a><i class="fa fa-user"></i> View Profile </a></li>
                              <li><a><i class="fa fa-envelope-o"></i> Message </a></li>
                            </ul>
                          </div></td>
                      </tr>
                      <tr>
                        <td><span class="xedit">Try Me!</span></td>
                        <td class="hidden-xs"><span class="xedit">Peter Parker</span></td>
                        <td class="hidden-xs hidden-sm"><span class="label btn-blue6">NewEgg</span></td>
                        <td class="visible-lg">CC V2</td>
                        <td>FSkit</td>
                        <td>Free</td>
                        <td class="hidden-xs text-center"><div class="btn-group">
                            <button type="button" class="btn btn-info btn-gradient"> <span class="glyphicons glyphicons-edit"></span> </button>
                            <button type="button" class="btn btn-success btn-gradient"> <span class="glyphicons glyphicons-remove"></span> </button>
                            <button type="button" class="btn btn-danger btn-gradient dropdown-toggle" data-toggle="dropdown"> <span class="glyphicons glyphicons-cogwheel"></span> </button>
                            <ul class="dropdown-menu checkbox-persist pull-right text-left" role="menu">
                              <li><a><i class="fa fa-user"></i> View Profile </a></li>
                              <li><a><i class="fa fa-envelope-o"></i> Message </a></li>
                            </ul>
                          </div></td>
                      </tr>
                      <tr>
                        <td><span class="xedit">Try Me!</span></td>
                        <td class="hidden-xs"><span class="xedit">Florida Toss</span></td>
                        <td class="hidden-xs hidden-sm"><span class="label btn-dark">Skills</span></td>
                        <td class="visible-lg">CF2</td>
                        <td>Webkit</td>
                        <td>License</td>
                        <td class="hidden-xs text-center"><div class="btn-group">
                            <button type="button" class="btn btn-info btn-gradient"> <span class="glyphicons glyphicons-edit"></span> </button>
                            <button type="button" class="btn btn-success btn-gradient"> <span class="glyphicons glyphicons-remove"></span> </button>
                            <button type="button" class="btn btn-danger btn-gradient dropdown-toggle" data-toggle="dropdown"> <span class="glyphicons glyphicons-cogwheel"></span> </button>
                            <ul class="dropdown-menu checkbox-persist pull-right text-left" role="menu">
                              <li><a><i class="fa fa-user"></i> View Profile </a></li>
                              <li><a><i class="fa fa-envelope-o"></i> Message </a></li>
                            </ul>
                          </div></td>
                      </tr>
                      <tr>
                        <td><span class="xedit">Try Me!</span></td>
                        <td class="hidden-xs"><span class="xedit">Cynthia Rodes</span></td>
                        <td class="hidden-xs hidden-sm"><span class="label btn-orange margin-right-sm">HTML</span><span class="label btn-green">PHP</span></td>
                        <td class="visible-lg">CF2</td>
                        <td>FSkit</td>
                        <td>Free</td>
                        <td class="hidden-xs text-center"><div class="btn-group">
                            <button type="button" class="btn btn-info btn-gradient"> <span class="glyphicons glyphicons-edit"></span> </button>
                            <button type="button" class="btn btn-success btn-gradient"> <span class="glyphicons glyphicons-remove"></span> </button>
                            <button type="button" class="btn btn-danger btn-gradient dropdown-toggle" data-toggle="dropdown"> <span class="glyphicons glyphicons-cogwheel"></span> </button>
                            <ul class="dropdown-menu checkbox-persist pull-right text-left" role="menu">
                              <li><a><i class="fa fa-user"></i> View Profile </a></li>
                              <li><a><i class="fa fa-envelope-o"></i> Message </a></li>
                            </ul>
                          </div></td>
                      </tr>
                      <tr>
                        <td><span class="xedit">Try Me!</span></td>
                        <td class="hidden-xs"><span class="xedit">James Harvy</span></td>
                        <td class="hidden-xs hidden-sm"><span class="label btn-alert margin-right-sm">Patience</span><span class="label label-info">CSS</span></td>
                        <td class="visible-lg">CC V2</td>
                        <td>Webkit</td>
                        <td>License</td>
                        <td class="hidden-xs text-center"><div class="btn-group">
                            <button type="button" class="btn btn-info btn-gradient"> <span class="glyphicons glyphicons-edit"></span> </button>
                            <button type="button" class="btn btn-success btn-gradient"> <span class="glyphicons glyphicons-remove"></span> </button>
                            <button type="button" class="btn btn-danger btn-gradient dropdown-toggle" data-toggle="dropdown"> <span class="glyphicons glyphicons-cogwheel"></span> </button>
                            <ul class="dropdown-menu checkbox-persist pull-right text-left" role="menu">
                              <li><a><i class="fa fa-user"></i> View Profile </a></li>
                              <li><a><i class="fa fa-envelope-o"></i> Message </a></li>
                            </ul>
                          </div></td>
                      </tr>
                      <tr>
                        <td><span class="xedit">Uzbl</span></td>
                        <td class="hidden-xs"><span class="xedit">Hue Fontain</span></td>
                        <td class="hidden-xs hidden-sm"><span class="label btn-red2">Ice Cream</span></td>
                        <td class="visible-lg">GNU GPLv3</td>
                        <td>FSkit</td>
                        <td>License</td>
                        <td class="hidden-xs text-center"><div class="btn-group">
                            <button type="button" class="btn btn-info btn-gradient"> <span class="glyphicons glyphicons-edit"></span> </button>
                            <button type="button" class="btn btn-success btn-gradient"> <span class="glyphicons glyphicons-remove"></span> </button>
                            <button type="button" class="btn btn-danger btn-gradient dropdown-toggle" data-toggle="dropdown"> <span class="glyphicons glyphicons-cogwheel"></span> </button>
                            <ul class="dropdown-menu checkbox-persist pull-right text-left" role="menu">
                              <li><a><i class="fa fa-user"></i> View Profile </a></li>
                              <li><a><i class="fa fa-envelope-o"></i> Message </a></li>
                            </ul>
                          </div></td>
                      </tr>
                      <tr>
                        <td><span class="xedit">Try Me!</span></td>
                        <td class="hidden-xs"><span class="xedit">George Michaels</span></td>
                        <td class="hidden-xs hidden-sm"><span class="label btn-brown">Dedication</span></td>
                        <td class="visible-lg">GNU GPLv3</td>
                        <td>Webkit</td>
                        <td>Contract</td>
                        <td class="hidden-xs text-center"><div class="btn-group">
                            <button type="button" class="btn btn-info btn-gradient"> <span class="glyphicons glyphicons-edit"></span> </button>
                            <button type="button" class="btn btn-success btn-gradient"> <span class="glyphicons glyphicons-remove"></span> </button>
                            <button type="button" class="btn btn-danger btn-gradient dropdown-toggle" data-toggle="dropdown"> <span class="glyphicons glyphicons-cogwheel"></span> </button>
                            <ul class="dropdown-menu checkbox-persist pull-right text-left" role="menu">
                              <li><a><i class="fa fa-user"></i> View Profile </a></li>
                              <li><a><i class="fa fa-envelope-o"></i> Message </a></li>
                            </ul>
                          </div></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
    
              </div>
            </div>
    
          </div>
          
          <div class="clearfix"></div>
          <div class="row">
            <div class="col-md-12">
              <div class="panel">
                <div class="panel-heading">
                  <div class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span> Responsive Table </div>
                </div>
                <div class="panel-body">
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Table heading</th>
                          <th>Table heading</th>
                          <th>Table heading</th>
                          <th>Table heading</th>
                          <th>Table heading</th>
                          <th>Table heading</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>1</td>
                          <td>Table cell</td>
                          <td>Table cell</td>
                          <td>Table cell</td>
                          <td>Table cell</td>
                          <td>Table cell</td>
                          <td>Table cell</td>
                        </tr>
                        <tr>
                          <td>2</td>
                          <td>Table cell</td>
                          <td>Table cell</td>
                          <td>Table cell</td>
                          <td>Table cell</td>
                          <td>Table cell</td>
                          <td>Table cell</td>
                        </tr>
                        <tr>
                          <td>3</td>
                          <td>Table cell</td>
                          <td>Table cell</td>
                          <td>Table cell</td>
                          <td>Table cell</td>
                          <td>Table cell</td>
                          <td>Table cell</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
          </div>
      -->
      <div class="row" style="min-height:350px;">&nbsp;</div>
    </div>
  </section>
  <!-- End: Content --> 
  
</div>
<!-- End: Main --> 
<!-- Start: Footer -->
<footer style="margin-top: 270px;"> <?php echo $INC_footer;?> </footer>
<!-- End: Footer --> 
<?php echo $INC_header_script_footer;?>
<script language="javascript">
function fetch_tickets(){
 document.getElementById('ticket_response').innerHTML = "<img class='loading' src='<?php echo IMG ; ?>ajax-loader.gif' alt='loading...' /><br>Please wait .....";

 var request_url = "<?php echo MURL ; ?>cron_email_reader.php";
 jQuery.post(
  request_url, {flag : true}, function(responseText){
	 
  	if(responseText == '0'){
		responseText = '<div class="alert alert-info">No Ticket(s) found</div>';
  		jQuery("#ticket_response").html(responseText);  
  	}else{
  		responseText = '<div class="alert alert-success alert-dismissable">'+responseText+' Ticket(s) fetched successfully</div>';
  		jQuery("#ticket_response").html(responseText);
  	}
  }, "html"
 );
}//end check_nic_exist
</script>
</body>
</html>
