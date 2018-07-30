<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_Projects extends CI_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->model('common/mod_common');
		$this->load->model('projects/mod_projects');
		$this->load->model('customers/mod_customer');
		$this->load->library('BreadcrumbComponent');
		$this->load->model('site_preferences/mod_preferences');
		$this->load->model('employee/mod_employee');
	}

	public function index(){
		
		//Login Check
		$this->mod_customer->verify_is_customer_login();
	
		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 1;
		$data['PLUGIN_datepicker'] = 0;
		$data['PLUGIN_gcal'] = 0;
		$data['PLUGIN_form_validation'] = 1;
		$data['PLUGIN_gallery'] = 0;
		$data['PLUGIN_ckeditor'] = 0;
		$data['PLUGIN_floatchart'] = 0;
		
		//Common Includes
		$data['meta_title'] = DEFAULT_TITLE;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;
		
		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;
		

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Manage Projects', base_url().'coupons/manage-coupons');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		$projects_arr = $this->mod_projects->get_projects();
		$data['projects_arr'] = $projects_arr['projects_arr'];
		$data['projects_count'] = $projects_arr['projects_count'];
		
		//GET Projects Protfolio
		$projects_portfolio_arr = $this->mod_projects->get_projects_portfolio();
		$data['projects_portfolio_arr'] = $projects_portfolio_arr['projects_portfolio_arr'];
		$data['projects_portfolio_count'] = $projects_portfolio_arr['projects_portfolio_count'];
		
		/*echo "<pre>";
		print_r($data['projects_portfolio_count']);
		exit;*/
		
		$this->load->view('projects/manage_projects',$data);
			
	}//end index()
	
	
	//project Detail
	public function project_detail($project_id){
		
		//Login Check
		$this->mod_customer->verify_is_customer_login();
				
		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 1;
		$data['PLUGIN_datepicker'] = 1;
		$data['PLUGIN_gcal'] = 0;
		$data['PLUGIN_form_validation'] = 1;
		$data['PLUGIN_gallery'] = 0;
		$data['PLUGIN_ckeditor'] = 0;
		$data['PLUGIN_floatchart'] = 0;
		$data['PLUGIN_autolinker'] = 1;
		
		
		//Common Includes
		$data['meta_title'] = DEFAULT_TITLE;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Manage Project', base_url().'projects/manage-projects');
		$this->breadcrumbcomponent->add('Project Detail', base_url().'coupons/manage-coupons/add-coupons');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		//Update messages Record
		 $this->mod_projects->update_project_messages_count($project_id);
		
		
		//Get project Messsaes
		$project_details = $this->mod_projects->get_project_messages($project_id);
		$data['project_messages_arr'] = $project_details['project_messages_result'];
		$data['project_messages_count'] = $project_details['project_messages_count'];
		
		//get messages attachments array
		$project_messages_attachments = $this->mod_projects->get_message_attachments($project_id);
		$data['project_message_attachment_arr'] = $project_messages_attachments;
		
		$data['user_name'] = $project_details['user_name'];
		
		//$data['project_id'] =$project_id;
		//////////////////////////////////////////////////////
		
		
		$project_details = $this->mod_projects->get_project_tasks($project_id);
		$data['total_task'] = $project_details['total_task'];
		$data['open_task'] = $project_details['open_task'];
		$data['hold_task'] = $project_details['hold_task'];
		$data['closed_task'] = $project_details['closed_task'];
		
		$data['project_task_arr'] = $project_details['project_task_result'];
		
		$project_details = $this->mod_projects->project_detail($project_id);
		$data['project_details_arr'] = $project_details['project_details_result'];
	
		//Check if Project Exist
		if($project_details['error']){
			
			  $this->session->set_flashdata('err_message', ' Opps...! Project not found...!');
			
			  redirect(base_url().'projects/manage_projects');
			
		}
	
		
		$data['project_attachments_arr']= $project_details['project_attachments'];
		$data['project_attachments_count']= $project_details['project_attachments_count'];
		
		$data['project_assign_team'] = $project_details['project_assign_team'];
		$data['role'] = $project_details['role'];
		
		$data['project_id'] =$project_id;
		
		//////////////////////////////////////////////////
		/*$project_details = $this->mod_projects->project_detail($project_id);
		
		$data['project_details_arr'] = $project_details['project_details_result'];
		$data['project_id'] =$project_id;
		
		//Check if Project Exist
		if($project_details['error']){
			
			  $this->session->set_flashdata('err_message', '- Opps...! Project not found...!');
			
			  redirect(base_url().'projects/manage_projects');
			
		}*/
		
		//Get project_milestones
		$get_project_milestones= $this->mod_projects->get_project_milestones($project_id);
		$data['project_milestones_arr'] = $get_project_milestones['project_milestones_arr'];
		$data['project_milestones_count'] = $get_project_milestones['project_milestones_count'];
	
		$this->load->view('projects/project_detail',$data);
		
	}//End Inbox
	

	
	//project_workspace
/*	public function project_workspace($project_id){
		
		//Login Check
    	$this->mod_customer->verify_is_customer_login();

		
		
		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 1;
		$data['PLUGIN_datepicker'] = 0;
		$data['PLUGIN_gcal'] = 0;
		$data['PLUGIN_form_validation'] = 1;
		$data['PLUGIN_gallery'] = 0;
		$data['PLUGIN_ckeditor'] = 0;
		$data['PLUGIN_floatchart'] = 0;
		
		//Common Includes
		$data['meta_title'] = DEFAULT_TITLE;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;
		
		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;
		
		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Manage Projects', base_url().'projects/manage-projects');
		$this->breadcrumbcomponent->add('Project workspace', base_url().'projects/manage-projects/show-all-tasks');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		$data['project_id']= $project_id;
		
		//Get Project Work space
		$get_project_workspace= $this->mod_projects->get_project_workspace($project_id);
		$data['project_workspace_arr'] = $get_project_workspace['project_workspace_arr'];
		$data['project_workspace_count'] = $get_project_workspace['project_workspace_count'];
		
		/*echo "<pre>";
		print_r($data['all_tasks_count']);
		exit;*/
		
		
		//$this->load->view('projects/project_workspace',$data);
			
	//}//end workspace*/
	
	//project_workspace_process
	public function project_workspace_process($project_id){
		
		//Login Check
		$this->mod_customer->verify_is_customer_login();

		
			$project_work_space = $this->mod_projects->project_workspace($this->input->post(), $project_id);
			
			
			
			if($project_work_space && $project_work_space['error'] == ''){
				
				$this->session->set_flashdata('ok_message', 'Project Portfolio submitted  successfully.');
				return true;
				
			}else{
				
				
					$this->session->set_flashdata('err_message', $project_work_space['error']);
					return false;
			}//end if*/
			
	}//end project_workspace_process
	
	
	 //project Assign
	public function project_assign($project_id){
		
		//Login Check
		$this->mod_customer->verify_is_customer_login();

	
		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 1;
		$data['PLUGIN_datepicker'] = 1;
		$data['PLUGIN_gcal'] = 0;
		$data['PLUGIN_form_validation'] = 1;
		$data['PLUGIN_gallery'] = 0;
		$data['PLUGIN_ckeditor'] = 0;
		$data['PLUGIN_floatchart'] = 0;
		
		//Common Includes
		$data['meta_title'] = DEFAULT_TITLE;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Project Assign', base_url().'coupons/manage-coupons/add-coupons');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		$customers_list_arr = $this->mod_employee->get_all_employees();
		$data['customers_arr'] = $customers_list_arr['customers_list_arr'];
		$data['customers_count'] = $customers_list_arr['customers_list_count'];
		
	//	$get_assign_team = $this->mod_employee->get_assign_team($project_id);
		$data['assign_team_arr'] 	= $get_assign_team;
		
		/*echo "<pre>";
		print_r($data['assign_team_arr'] );
		exit;*/
		
		
		$data['project_id'] =$project_id;
		
		
		$this->load->view('projects/assign_project',$data);
		
	}//End assign_project
	
	
	public function project_assign_process(){
		
			//Login Check
			$this->mod_customer->verify_is_customer_login();

			$assign_projects = $this->mod_projects->project_assign($this->input->post());
			
			if($assign_projects && $assign_projects['error'] == ''){
				
				$this->session->set_flashdata('ok_message', 'Project Assign successfully.');
				redirect(base_url().'projects/manage-projects/');
				
			}else{
				
				if($assign_projects['error'] != ''){
					$this->session->set_flashdata('err_message', '- '.strip_tags($add_new_user['error']));
					redirect(base_url().'projects/manage-projects/');
					
				}else{
					$this->session->set_flashdata('err_message', 'Project cannot  Assign. Something went wrong, please try again.');
					redirect(base_url().'projects/manage-projects/');
					
				}//end if
				
			}//end if
			
	}//end assign_project_process
	
	
	
	//load_more
	public function load_more($project_id){
		
		//Login Check
	   $this->mod_customer->verify_is_customer_login();

			
	   $project_arr = $this->mod_projects->load_more($project_id);
	   
	   
	  $project_messages_arr = $project_arr['project_messages_result'];
	  
	  $project_messages_count= $project_arr['project_messages_count'];
	   
	   $project_messages_attachments = $this->mod_projects->get_message_attachments($project_id);
	   $project_message_attachment_arr = $project_messages_attachments;
	
	  for($i=0; $i<$project_messages_count; $i++){ 
	  
	   $msg_id =$project_messages_arr[$i]['id'];  
	   
	   ?>
	     
	  
      <div class="asdf" > 
                        <div class="well">
                        	<div class="row" >
                                <div class="col-md-2" style="border-right:1px solid #ccc;">
                                    
                                    <strong class="coltext3"><?php echo  $project_messages_arr[$i]['user'];?><br>
                                    <?php if($project_messages_arr[$i]['avatar_image'] !=""){ ?>    
                                    <div class="thumbnail" style="width: 30%;margin-bottom: 0px;">
        <img  src="<?php echo ADMIN_SURL.'assets/user_files/'.$project_messages_arr[$i]['admin_id'].'/'.stripslashes($project_messages_arr[$i]['avatar_image'])?>">	
                                        </div>
                                        
                                      <?php  } ?>  
                                       <?php if($project_messages_arr[$i]['user_role'] !=""){ ?>                                      
                                      (<?php echo  $project_messages_arr[$i]['user_role'];?>)
                                         
                                      <?php  } ?> 
                                         </strong>
                                        
                                         <br>
                                         <br> 
                                     <div id="jRate<?php echo $project_messages_arr[$i]['id']?>" style="height:33px;width: 100%;" title="Rating(<?php echo round($project_messages_arr[$i]['admin_rating'],2);?>)"></div>		 								
                                    <div class="text-small"> </div>
                                                                                
                                        <div class="text-small"> </div>
                                 
                                    
                                </div>
                                <div class="col-md-10">
                                
                                <div class="time_date pull-right">
                 
                                        <div class="time">
                                        <i class="fa fa-clock-o"></i>
                                        <span class="c_time"><?php echo date('d M, Y , g:i a',strtotime($project_messages_arr[$i]['created_date'])); ?></span>
                                        
                                        
                                        </div>
                                        
                                        
                                        
                                    </div>
                                    
                                    
                                    <p><?php echo stripcslashes(strip_tags($project_messages_arr[$i]['message'],'<b><br><a>')) ?></p>
                                    
                                    <?php  if(count($project_message_attachment_arr[$project_messages_arr[$i]['id']]) > 0){ 
									
									for($j=0; $j<count($project_message_attachment_arr[$project_messages_arr[$i]['id']]); $j++){
									
									?>
                                    
                             <div class="col-md-2">              
                            <div class="thumbnail" style="width: 90px;height: 76px;">
                         
							<?php 
							
                             $ext = pathinfo($project_message_attachment_arr[$project_messages_arr[$i]['id']][$j], PATHINFO_EXTENSION) ;
                            
                            if($ext=='jpg' or $ext=='png') {?>
                             <a href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" style="width: 139%;margin-left: -16px;" data-toggle="lightbox" data-gallery="multiimages" data-title="<?php echo $project_attachments_arr[$i]['title'] ?>" class="col-sm-4">
                             
                             <img src="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" data-src="holder.js/100%x180" data-holder-rendered="false" style="width: 86px;height: 65px;">
                             </a>
                            <?php }elseif($ext=='zip' or $ext=='rar'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/zip.png" style="height: 69px;" ></a>
                                
                                <?php }elseif($ext=='doc' or $ext=='docx'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/docx.png" style="height: 69px;" ></a>
                              
                            <?php }elseif($ext=='xlsx' or $ext=='xls'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/excel.png" style="height: 66px;" ></a>
                              
                            <?php }elseif($ext=='pptx' or $ext=='ppt'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/pptx.png" style="height: 69px;" ></a>
                              
                            <?php }elseif($ext=='odt'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/odt.png" style="height: 66px;" ></a>
                              
                            <?php }elseif($ext=='pdf'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/pdf.png" style="height: 69px;" ></a>        
                                <?php }elseif($ext=='txt'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/text.png" style="height: 69px;" ></a>        
                                <?php }elseif($ext=='tif'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo MURL?>assets/img/tiff2.png" style="height: 66px;" ></a>       
                                <?php }elseif($ext=='csv'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/csv.png" style="height: 66px;" ></a>       
                                <?php }  ?>
                                
                                
                              
                              
                            </div>
                            </div>
                           
                         
                              
                          <?php  
						  
						   }//End for loop
						  
						  
					      }//End if ?>
                                    
                                </div>
                            </div>
                        </div>
                        
                         </div>
                         
              
            </div>
      
      
	  <?php
	  
        $msg_id = $project_messages_arr[$i]['id'];   
	  
	  } 
	  
	  ?>
	  
	    <?php if(isset($msg_id) !=""){ ?>
        
	     <div class="show_more_main" id="show_more_main<?php echo $msg_id; ?>">
                
        <span id="<?php echo $msg_id; ?>" class="show_more" title="Load more posts">Show more</span>
        <span class="loding" style="display: none;"><span class="loding_txt">Loading...</span></span>  
        
		<?php } ?>  
			
<?php	}//end load_more



//send_message_process
	public function project_messages(){
		
		//echo $this->input->post('user_id_from');
		
		 $this->input->post('last_row_id');
		 
		$project_id= $this->input->post('project_id');
		 
		
		$this->mod_projects->project_messages($this->input->post());
		
		//$send_message_process = $this->mod_user->send_message_process($this->input->post());
		
		/*$project_arr = $this->mod_projects->get_autoload_latest_messages($this->input->post());
		
	
	    $project_messages_arr = $project_arr;
	  
	    $project_messages_count= count($project_arr);
	   
	    $project_messages_attachments = $this->mod_projects->get_message_attachments($project_id);
	    $project_message_attachment_arr = $project_messages_attachments;*/
	
		
 		/*if($project_messages_count>0){
	  
	
 		for($i=0; $i<$project_messages_count; $i++){
		
			$row_id = 'row_'.$i;
		
		 ?>

	<div class="asdf" > 
                        <div class="well">
                        	<div class="row" >
                                <div class="col-md-2" style="border-right:1px solid #ccc;">
                                    
                                    <strong class="coltext3"><?php echo  $project_messages_arr[$i]['user'];?><br>
                                    <?php if($project_messages_arr[$i]['avatar_image'] !=""){ ?>    
                                    <div class="thumbnail" style="width: 30%;margin-bottom: 0px;">
        
          <img  src="<?php echo ADMIN_SURL.'assets/user_files/'.$project_messages_arr[$i]['admin_id'].'/'.stripslashes($project_messages_arr[$i]['avatar_image'])?>">
          
                                        </div>
                                        
                                      <?php  } ?>  
                                       <?php if($project_messages_arr[$i]['user_role'] !=""){ ?>                                      
                                      (<?php echo  $project_messages_arr[$i]['user_role'];?>)
                                         
                                      <?php  } ?> 
                                         </strong>
                                        
                                         <br>
                                         <br> 
                                         
                                     <div id="jRate<?php echo $project_messages_arr[$i]['id']?>" style="height:33px;width: 100%;" title="Rating(<?php echo round($project_messages_arr[$i]['admin_rating'],2);?>)"></div>		 								
                                    <div class="text-small"> </div>
                                                                                
                                        <div class="text-small"> </div>
                                 
                                    
                                </div>
                                <div class="col-md-10">
                                
                                <div class="time_date pull-right">
                 
                                        <div class="time">
                                        <i class="fa fa-clock-o"></i>
                                        <span class="c_time"><?php echo date('d M, Y , g:i a',strtotime($project_messages_arr[$i]['created_date'])); ?></span>
                                        
                                        
                                        </div>
                                        
                                        
                                        
                                    </div>
                                
                                    <p><?php echo stripcslashes(strip_tags($project_messages_arr[$i]['message'],'<b><br><a>')) ?></p>
                                    
                                    <?php  if(count($project_message_attachment_arr[$project_messages_arr[$i]['id']]) > 0){ 
									
									for($j=0; $j<count($project_message_attachment_arr[$project_messages_arr[$i]['id']]); $j++){
									
									?>
                                    
                             <div class="col-md-2">              
                            <div class="thumbnail" style="width: 90px;height: 76px;">
                         
							<?php 
							
                             $ext = pathinfo($project_message_attachment_arr[$project_messages_arr[$i]['id']][$j], PATHINFO_EXTENSION) ;
                            
                            if($ext=='jpg' or $ext=='png') {?>
                            
                             <a href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" style="width: 116px;margin-left: -16px;" data-toggle="lightbox" data-gallery="multiimages" data-title="<?php echo $project_attachments_arr[$i]['title'] ?>" class="col-sm-4">
                             
                             
                             <img src="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" data-src="holder.js/100%x180" data-holder-rendered="false" style="width: 86px;height: 65px;">
                             </a>
                            <?php }elseif($ext=='zip' or $ext=='rar'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/zip.png" style="height: 69px;" ></a>
                                
                                <?php }elseif($ext=='doc' or $ext=='docx'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/docx.png" style="height: 69px;" ></a>
                              
                            <?php }elseif($ext=='xlsx' or $ext=='xls'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/excel.png" style="height: 66px;" ></a>
                              
                            <?php }elseif($ext=='pptx' or $ext=='ppt'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/pptx.png" style="height: 69px;" ></a>
                              
                            <?php }elseif($ext=='odt'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/odt.png" style="height: 66px;" ></a>
                              
                            <?php }elseif($ext=='pdf'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/pdf.png" style="height: 69px;" ></a>        
                                <?php }elseif($ext=='txt'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/text.png" style="height: 69px;" ></a>        
                                <?php }elseif($ext=='tif'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo MURL?>assets/img/tiff2.png" style="height: 66px;" ></a>       
                                <?php }elseif($ext=='csv'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/csv.png" style="height: 66px;" ></a>       
                                <?php }  ?>
                                
                                
                              
                              
                            </div>
                            </div>
                           
                         
                              
                          <?php  
						  
						   }//End for loop
						  
						  
					      }//End if ?>
                                    
                                </div>
                            </div>
                        </div>
                        
                         </div> 
     
     |
     
    <?php echo $project_messages_arr[0]['id'];?>
	   
		<?php
		
		
		 $msg_id =$project_messages_arr[$i]['id'];    
		  
	}//End for 
	
  }else{*/
	  
	//  echo "not";
	  
	 // }
  
	
	}//end send_message_process	
	
	
	 public function ajax_upload_message_attachments(){
		   
		
			//echo "<pre>"; print_r($data= $this->input->post());  exit;
			//$data['file']= $_FILE;
			//prining success message
		
			
			$get_record =  $this->mod_projects->ajax_upload_message_attachments($this->input->post());
			   
			//success message
			 if($get_record ){
				  
			 
			 echo json_encode(array("file_name"=>$get_record['file_name'],"file_id"=> $get_record['file_id']));
			   exit;			}else{
			//printing error for dropzone
            header('HTTP/1.1 500 Internal Server Error');
            header('Content-type: text/plain');
            echo 'ERROR FILE UPLOAD';
			exit;
			   }
		   
	   }
	   
	   
	 public function ajax_delete_itemimages() {
		
		
         $data['job_id'] = $this->input->post('job_id');
         $data['server_file_id']=$this->input->post('server_file_id');
		 $data['server_file_name']=$this->input->post('server_file_name');
            // dump($data);

        //$wheres = array('file_name' => $data['file'], 'job_id' => $data['job_id']);
        $this->mod_projects->delete_file($data );
        exit;
    }
	
	
	
	public function autoload(){
	
		$project_arr = $this->mod_projects->get_autoload_latest_messages($this->input->post());
		
	
	    $data['project_messages_arr'] = $project_arr;
	  
	    $data['project_messages_count']= count($project_arr);
	   
	    $data['project_messages_attachments'] = $this->mod_projects->get_message_attachments($project_id);
	    $data['project_message_attachment_arr'] = $project_messages_attachments;
		
		
		$data['project_id']= $this->input->post('project_id');
		
		
		$this->load->view('projects/autoload', $data);
		
		
	} //end index()	
	
	
	
		//Manage Project Task
	public function manage_project_task($project_id){
		
		
		//Login Check
		$this->mod_customer->verify_is_customer_login();

	
		//Plugin Files Permission
		$data['PLUGIN_datagrid'] = 1;
		$data['PLUGIN_datepicker'] = 1;
		$data['PLUGIN_gcal'] = 0;
		$data['PLUGIN_form_validation'] = 1;
		$data['PLUGIN_gallery'] = 0;
		$data['PLUGIN_ckeditor'] = 0;
		$data['PLUGIN_floatchart'] = 0;
		
		//Common Includes
		$data['meta_title'] = DEFAULT_TITLE;
		$data['meta_keywords'] = DEFAULT_META_KEYWORDS;
		$data['meta_description'] = DEFAULT_META_DESCRIPTION;

		$fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
		$data['nav_panel_arr'] = $fetch_nav_panel;
	

		//Bread crum
		$this->breadcrumbcomponent->add('Dashboard', base_url().'dashboard/dashboard');
		$this->breadcrumbcomponent->add('Manage Task', base_url().'coupons/manage-coupons');
		$data['breadcrum_data'] = $this->breadcrumbcomponent->output();
		
		$data['INC_header_script_top'] = $this->load->view('common/script_header',$data,true);
		$data['INC_header_script_footer'] = $this->load->view('common/script_footer',$data,true);
		$data['INC_top_header'] = $this->load->view('common/top_header','',true);
		$data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel',$data,true);
		$data['INC_footer'] = $this->load->view('common/footer','',true);
		$data['INC_breadcrum'] = $this->load->view('common/breadcrum','',true);
		
		$project_task_arr = $this->mod_projects->get_project_task($project_id);
		
		$data['assign_task_arr'] = $project_task_arr['project_task_arr'];
		$data['assign_task_count'] = $project_task_arr['project_task_count'];
		
		$data['project_id']=$project_id;
		
	/*	echo "<pre>";
		print_r( $data['assign_task_arr']);
		exit;*/
		
		
		$this->load->view('projects/manage_task',$data);
			
	}//end manage_project_task
	
	
	
	//Ajax Response Task
	public function get_status_ajax($project_id, $status){
		
		//State List List
		$get_tasks_ajax= $this->mod_projects->get_all_tasks_ajax($project_id,$status);

		$project_task_arr = $get_tasks_ajax['project_task_arr'];
		$project_task_count = $get_tasks_ajax['project_task_count'];
		
		
		if($status !=""){
			
			
		if($project_task_count > 0){	
			
		 ?>
		
		
		<table class="table table-striped table-bordered table-hover" id="manage_cms_pages">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th class="">Task Title</th>
                        <th class="">Start Date</th>
                        <th class="">End Date</th>
                        <th class="">Total Time</th>
                        <th class="">Project Name</th>
                        <th class="">Status</th>
                     
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
					
							for($i=0;$i<$project_task_count;$i++){
					?>
                            <tr>
                                <td><span class="xedit"><?php echo ($i+1) ?></span></td>
                                
                                <td class="hidden-xs "><strong><?php echo  stripcslashes(strip_tags($project_task_arr[$i]['title']));?></strong></td>
                                
                                <td class="hidden-xs "><?php echo date("d, M Y h:i:s a", strtotime($project_task_arr[$i]['start_date'])); ?></td>
                                <td class="hidden-xs "><?php echo date("d, M Y h:i:s a", strtotime($project_task_arr[$i]['end_date']));  ?></td>
                                 <td class="hidden-xs "><?php echo $project_task_arr[$i]['total_time'];  ?></td>
                                
                               <td class="hidden-xs "><strong><a class="anchor_style" href="<?php echo base_url()?>projects/manage-projects/project-detail/<?php echo $project_task_arr[$i]['project_id'] ?>" title="Click to Project Detail" target="_blank"><?php echo stripcslashes(strip_tags($project_task_arr[$i]['project_title']));  ?></a></strong></td>
                             
                                <td class="hidden-xs ">
							   <?php if($project_task_arr[$i]['status']=='0'){ echo "<span class='label btn-success'>New</span>";} 
							   if($project_task_arr[$i]['status']=='1'){ echo "<span class='label btn-success'>Start</span>";} 
							   if($project_task_arr[$i]['status']=='2'){ echo "<span class='label btn-success'>Hold</span>";} 
							   if($project_task_arr[$i]['status']=='3'){ echo "<span class='label btn-success'>Closed</span>";}
							   if($project_task_arr[$i]['status']=='4'){ echo "<span class='label btn-success'>Resume</span>";}?>
                               </td> 
                               
                              
                      
                            </tr>
                    <?php			
						}//end for
					?>
                    </tbody>
                  </table>
		
		
	
	<?php	}else{echo "<div class='alert alert-danger alert-dismissable'>
                	<strong>No Task(s) Found</strong> </div>";}
					
					
				}else{echo "<div class='alert alert-danger alert-dismissable'>
                	<strong>No Task(s) Found</strong> </div>";}
		
		
		
		echo $response_select ; 
		exit;
	}//get_task_ajax
	
	

}//end Dashboard 
