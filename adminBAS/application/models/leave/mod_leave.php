<?php
class Mod_leave extends CI_Model {
	
	function __construct(){
		
        parent::__construct();
    }
	
	
public function apply_leave($data){
//		echo "hello";exit;
//    echo "<pre>";
//        print_r($data);exit;
    $this->db->dbprefix('leave');
    $insert = $this->db->insert('leave', $data);
//    echo $q = $this->db->last_query();
	
    }//end  apply leave
	
    public function get_leave_data($id){

//        echo "<pre>";
//                print_r($where);exit;

        $query = "SELECT * FROM inno_leave WHERE user_id = '".$id."' ORDER BY id DESC";
//        echo $query;exit;
        $result = $this->db->query($query);
//        echo $q = $this->db->last_query();exit;
//        echo "<pre>";
//        print_r($result->result_array());exit;
        return $result->result_array();
    }
    public function get_all_leave_data(){
//        $this->db->order_by("id", "desc"); 
        $data = $this->db->get("inno_leave");
//        echo $q = $this->db->last_query();exit;
        
        return $data->result_array();
    }
    public function getleavedata($id){
        $query = "SELECT * FROM inno_leave WHERE id = '".$id."'";
        $result = $this->db->query($query);
        return $result->result_array();
    }
    
    public function leave_approved_process($id, $leave_pay_status){
        $upd_data = array(
            'status' => 2,
            'action' => 1,
            'dated' => date("Y-m-d"),
            'leave_pay_status' => $leave_pay_status,
        );	
        
        //Inserting the record into the database.
        $this->db->dbprefix('leave');
        $this->db->where('id',$id);
        $ins_into_db = $this->db->update('leave', $upd_data);
            echo $q = $this->db->last_query();
            if($this->db->affected_rows() > 0){
                return 1;
            }else{
                return 0;
            }    
    }
    public function leave_disapproved_process($id, $disapprove){
        
        $upd_data = array(
            'disapprove_reason' => $disapprove,
            'status' => 3,
            'action' => 0,
            'dated' => date("Y-m-d"),
        );
        
        //Inserting the record into the database.
        $this->db->dbprefix('leave');
        $this->db->where('id',$id);
        $ins_into_db = $this->db->update('leave', $upd_data);
            echo $q = $this->db->last_query();
            if($this->db->affected_rows() > 0){
                return 1;
            }else{
                return 0;
            }    
    }
    
    public function view_leave_history($id){

//        echo "<pre>";
//                print_r($where);exit;

        $query = "SELECT * FROM inno_leave WHERE user_id = '".$id."' ORDER BY id DESC";
//        echo $query;exit;
        $result = $this->db->query($query);
//        echo $q = $this->db->last_query();exit;
//        echo "<pre>";
//        print_r($result->result_array());exit;
        return $result->result_array();
    }
    public function get_name_data($id){
        $query = "SELECT first_name, admin_role_id FROM inno_admin where id = $id";
        $result = $this->db->query($query);
//        echo $q = $this->db->last_query();exit;
        return $result->result_array();
    }
    public function where_in_db($role_id){
        
        $this->db->select('admin.id, admin.first_name,admin.first_name, inno_admin_roles.role_title ');
        $this->db->join('inno_admin_roles', 'inno_admin_roles.id = inno_admin.admin_role_id');
        $this->db->from('admin');
        $this->db->where("admin.status", '1');
        $this->db->where_in('admin.admin_role_id', $role_id);
        
        $result = $this->db->get();
//        echo $q = $this->db->last_query();
        return $result->result_array();
    }
    
	
	
}
?>