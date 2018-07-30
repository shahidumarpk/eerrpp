<?php
class mod_team extends CI_Model {
	
	function __construct(){
		
        parent::__construct();
    }

	
	//Get All Teams
	public function get_all_teams(){
		
		$this->db->dbprefix('teams');
		$get_all_teams = $this->db->get('teams');

		//echo $this->db->last_query();
		$row_all_teams ['all_teams_arr'] = $get_all_teams ->result_array();
		$row_all_teams ['all_teams_count'] = $get_all_teams ->num_rows;
		
		for($i=0; $i<$row_all_teams ['all_teams_count']; $i++){
			
			
			$team_head_id= $row_all_teams ['all_teams_arr'][$i]['team_head'];
			$branch_id= $row_all_teams ['all_teams_arr'][$i]['branch_id'];
			
			$this->db->dbprefix('admin');
			$this->db->where('id', $team_head_id);
			$get_admin = $this->db->get('admin');
			$row_admin= $get_admin ->row_array();
			$row_all_teams ['all_teams_arr'][$i]['head_name']= $row_admin['first_name']." ".$row_admin['last_name'];
			$row_all_teams ['all_teams_arr'][$i]['head_id']= $row_admin['id'];
			
			$this->db->dbprefix('branches');
			$this->db->where('id', $branch_id);
			$get_branch = $this->db->get('branches');
			$row_branch = $get_branch ->row_array();
			$row_all_teams ['all_teams_arr'][$i]['branch_name']= $row_branch['branch_name'];
			
			$team_arr = explode(',',$row_all_teams ['all_teams_arr'][$i]['team_members']);
			
			for($j=0; $j<count($team_arr); $j++){
				
				$this->db->dbprefix('admin');
				$this->db->where('id', $team_arr[$j]);
				$get_team= $this->db->get('admin');
				$row_team= $get_team ->row_array();
				
				$row_all_teams ['all_teams_arr'][$i]['team'][$j]= $row_team['first_name']." ".$row_team['last_name'];
				
				
			}
			
			
			
		}
		
		/*echo "<pre>";
		print_r($row_all_teams ['all_teams_arr']);
		exit;*/
		return $row_all_teams ;
		
	}//end get_all_teams 
	
	
		
	//Get Admin Profile Record
	public function get_team($team_id){
		
		$this->db->dbprefix('teams');
		$this->db->where('id',$team_id);
		$get_team= $this->db->get('teams');

		//echo $this->db->last_query();
		$row_team['team_arr'] = $get_team->row_array();
		$row_team['team_count'] = $get_team->num_rows;
		return $row_team;
		
	}//end get_team
	
	
	//Add new Team
	public function add_team($data){
		
		extract($data);
		
		$created_date = date('Y-m-d G:i:s');
		$created_by_ip = $this->input->ip_address();
		$created_by = $this->session->userdata('admin_id');
		
		$team_members=implode(',',$team_members);

		$ins_data = array(
		   'team_title' => $this->db->escape_str(trim($team_title)),
		   'team_head' => $this->db->escape_str(trim($team_head)),
		   'branch_id' => $this->db->escape_str(trim($branch_id)),
		   'team_members' => $this->db->escape_str(trim($team_members)),
		   'status' => $this->db->escape_str(trim($status)),
		   'created_by' => $this->db->escape_str(trim($created_by)),
		   'created_date' => $this->db->escape_str(trim($created_date)),
		   'created_by_ip' => $this->db->escape_str(trim($created_by_ip))
		);		

		//Inserting the record into the database.
		$this->db->dbprefix('teams');
		$ins_into_db = $this->db->insert('teams', $ins_data);
		
		return true;
	
		
	}//end add_team
	
	
	

	//Edit Team
	public function edit_team($data){
		
		extract($data);
		
	
		$last_modified_date = date('Y-m-d G:i:s');
		$last_modified_ip = $this->input->ip_address();
		$last_modified_by = $this->session->userdata('admin_id');
		
		$team_members=implode(',',$team_members);
		
		$upd_data = array(
		   'team_title' => $this->db->escape_str(trim($team_title)),
		   'team_head' => $this->db->escape_str(trim($team_head)),
		   'branch_id' => $this->db->escape_str(trim($branch_id)),
		   'team_members' => $this->db->escape_str(trim($team_members)),
		   'status' => $this->db->escape_str(trim($status)),
		   'last_modified_by' => $this->db->escape_str(trim($last_modified_by)),
		   'last_modified_date' => $this->db->escape_str(trim($last_modified_date)),
		   'last_modified_ip' => $this->db->escape_str(trim($last_modified_ip))
		);		

		//Updating the record into the database.
		$this->db->dbprefix('teams');
		$this->db->where('id',$team_id);
		$upd_into_db = $this->db->update('teams', $upd_data);
		
		if($upd_into_db)
			return true;
		
	}//end edit_team
	
	
	
	//Delete Team
	public function delete_team($team_id){
		
		if($team_id != 1){
			
		
			//Delete the record from the database.
			$this->db->dbprefix('teams');
			$this->db->where('id',$team_id);
			$del_into_db = $this->db->delete('teams');
			if($del_into_db) return true;
			//echo $this->db->last_query();

		}//end if($team_id != 1)
		
	}//end delete_team
	
	
	//Get My Team
	public function get_my_team(){
		
		$this->db->dbprefix('teams');
		$get_all_teams = $this->db->get('teams');

		//echo $this->db->last_query();
		$row_all_teams['all_teams_arr'] = $get_all_teams ->result_array();
		$row_all_teams['all_teams_count'] = $get_all_teams ->num_rows;
		
		$counter = 0 ; 	
		$h = 0 ;
		
		for($k=0;$k<$row_all_teams['all_teams_count'];$k++){
			
			$user_id=$this->session->userdata('admin_id');
			
			$team_head =$row_all_teams ['all_teams_arr'][$k]['team_head'];
			
			if($team_head == $user_id){
				
					$row_my_teams['all_teams_filter'][$h]['id'] = $row_all_teams['all_teams_arr'][$k]['id'] ;
					$row_my_teams['all_teams_filter'][$h]['team_head'] = $row_all_teams['all_teams_arr'][$k]['team_head'] ;
					$row_my_teams['all_teams_filter'][$h]['branch_id'] = $row_all_teams['all_teams_arr'][$k]['branch_id'] ;
					$row_my_teams['all_teams_filter'][$h]['team_title'] = $row_all_teams['all_teams_arr'][$k]['team_title'] ;
					
					for($i=0; $i<$row_all_teams ['all_teams_count']; $i++){
			
			
							$team_head_id= $row_all_teams['all_teams_arr'][$k]['team_head'];
							$branch_id= $row_all_teams['all_teams_arr'][$k]['branch_id'];
							
							$this->db->dbprefix('admin');
							$this->db->where('id', $team_head_id);
							$get_admin = $this->db->get('admin');
							$row_admin= $get_admin ->row_array();
							
							$row_my_teams['all_teams_filter'][$h]['head_name'] = $row_admin['first_name']." ".$row_admin['last_name'];
							
							$row_my_teams['all_teams_filter'][$h]['head_id'] = $row_admin['id'];
							
							$this->db->dbprefix('branches');
							$this->db->where('id', $branch_id);
							$get_branch = $this->db->get('branches');
							$row_branch = $get_branch ->row_array();
							
							$row_my_teams['all_teams_filter'][$h]['branch_name']= $row_branch['branch_name'];
							
							//echo $row_my_teams['all_teams_filter'][$h]['team_members'];
							
							$team_arr = explode(',',$row_all_teams['all_teams_arr'][$k]['team_members']);
							
							
							for($j=0; $j<count($team_arr); $j++){
								
								$this->db->dbprefix('admin');
								$this->db->where('id', $team_arr[$j]);
								$get_team= $this->db->get('admin');
								$row_team= $get_team ->row_array();
								
								$row_my_teams['all_teams_filter'][$h]['team'][$j]= $row_team['first_name']." ".$row_team['last_name'];
								$row_my_teams['all_teams_filter'][$h]['team_id'][$j]= $row_team['id'];
								
							}
						}
		
					$h++;
					$counter  = $counter + 1 ;   
				
			}else{
			
			
			
			
		
				$explode_arr = explode(',',$row_all_teams ['all_teams_arr'][$k]['team_members']);
				
				if(in_array($user_id,$explode_arr))
				
				{
					
				//	$row_projects['projects_filter'] = $row_projects['projects_arr'][$k] ; 
								
					$row_my_teams['all_teams_filter'][$h]['id'] = $row_all_teams['all_teams_arr'][$k]['id'] ;
					$row_my_teams['all_teams_filter'][$h]['team_head'] = $row_all_teams['all_teams_arr'][$k]['team_head'] ;
					$row_my_teams['all_teams_filter'][$h]['branch_id'] = $row_all_teams['all_teams_arr'][$k]['branch_id'] ;
					$row_my_teams['all_teams_filter'][$h]['team_title'] = $row_all_teams['all_teams_arr'][$k]['team_title'] ;
					
					for($i=0; $i<$row_all_teams ['all_teams_count']; $i++){
			
			
							$team_head_id= $row_all_teams['all_teams_arr'][$k]['team_head'];
							$branch_id= $row_all_teams['all_teams_arr'][$k]['branch_id'];
							
							$this->db->dbprefix('admin');
							$this->db->where('id', $team_head_id);
							$get_admin = $this->db->get('admin');
							$row_admin= $get_admin ->row_array();
							
							$row_my_teams['all_teams_filter'][$h]['head_name'] = $row_admin['first_name']." ".$row_admin['last_name'];
							
							$row_my_teams['all_teams_filter'][$h]['head_id'] = $row_admin['id'];
							
							$this->db->dbprefix('branches');
							$this->db->where('id', $branch_id);
							$get_branch = $this->db->get('branches');
							$row_branch = $get_branch ->row_array();
							
							$row_my_teams['all_teams_filter'][$h]['branch_name']= $row_branch['branch_name'];
							
							//echo $row_my_teams['all_teams_filter'][$h]['team_members'];
							
							$team_arr = explode(',',$row_all_teams['all_teams_arr'][$k]['team_members']);
							
							
							for($j=0; $j<count($team_arr); $j++){
								
								$this->db->dbprefix('admin');
								$this->db->where('id', $team_arr[$j]);
								$get_team= $this->db->get('admin');
								$row_team= $get_team ->row_array();
								
								$row_my_teams['all_teams_filter'][$h]['team'][$j]= $row_team['first_name']." ".$row_team['last_name'];
								$row_my_teams['all_teams_filter'][$h]['team_id'][$j]= $row_team['id'];
								
							}
						}
		
					$h++;
					$counter  = $counter + 1 ;   
					
				//echo "<pre>"; print_r($row_projects['projects_filter']); exit; 	
				}
				
			}//End if user Team head
			
		}//End for loop
			
			
		$row_my_teams['all_teams_count'] = $counter ;
	
		//echo "<pre>"; print_r($row_my_teams['all_teams_filter']); exit; 	
		return $row_my_teams ;
		
	}//end get_my_teams 
	
	
	
}
?>