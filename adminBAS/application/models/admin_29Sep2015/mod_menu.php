<?php
class mod_menu extends CI_Model {
	
	function __construct(){
		
        parent::__construct();
    }

// Get all Categories
public function get_all_parentid(){
		
		
		$this->db->dbprefix('admin_menu');
		$this->db->select('id,parent_id,menu_title');
		$this->db->order_by('id DESC');
		$this->db->where('parent_id',0);
		$get_items_types = $this->db->get('admin_menu');
	
		print_r($get_items_types);
		$row_items_types['items_result'] = $get_items_types->result_array();
		$row_items_types['items_count'] = $get_items_types->num_rows;
		
		return $row_items_types;		
		
	}
	//Get All CMS pages.
	public function get_all_menu(){
		
		$this->db->dbprefix('admin_menu');
		
		$this->db->order_by('id DESC');
		$get_menu = $this->db->get('admin_menu');

	/*<!--echo $this->db->last_query();
	exit-->;*/
		$row_menu['menu_all_arr'] = $get_menu->result_array();
		$row_menu['menu_all_count'] = $get_menu->num_rows;
		return $row_menu;
		
	}//end get_all_menu

	//Get menu Record
	public function get_menu($menu_id){
		
		$this->db->dbprefix('admin_menu');
		$this->db->where('id',$menu_id);
		$get_menus = $this->db->get('admin_menu');
		
		//echo $this->db->last_query();
		$row_menu['menu1_all_arr'] = $get_menus->row_array();
		
		$row_menu['menu1_all_count'] = $get_menus->num_rows;
	
		return $row_menu;
		
	}//end get_menu record
	
	
	
	
	//Add New Page
	public function add_new_menu($data){
		
		extract($data);
		
		
		

          
		$ins_data = array(
		   'menu_title' => $this->db->escape_str(trim($menu_title)),
		   'parent_id' => $this->db->escape_str(trim(nl2br($parent_id))),
		   'show_in_nav' => $this->db->escape_str(trim($show_in_nav)),
		   'set_as_default' => $this->db->escape_str(trim($set_as_default)),
		   'icon_class_name' => $this->db->escape_str(trim($icon_class_name)),
		   'url_link' => $this->db->escape_str(trim($url_link)),
		   'display_order' => $this->db->escape_str(trim($display_order)),
		   'status' => $this->db->escape_str(trim($status)),
		);

		
		//Insert the record into the database.
		$this->db->dbprefix('admin_menu');
		$ins_into_db = $this->db->insert('admin_menu', $ins_data);
		//echo $this->db->last_query();
		
		if($ins_into_db) return true;

	}//end add_new_page()
	
	//Edit Page
	public function edit_new_menu($data){
		
		extract($data);
	
		
		

		$upd_data = array(
			  'menu_title' => $this->db->escape_str(trim($menu_title)),
		   'parent_id' => $this->db->escape_str(trim(nl2br($parent_id))),
		   'show_in_nav' => $this->db->escape_str(trim($show_in_nav)),
		   'set_as_default' => $this->db->escape_str(trim($set_as_default)),
		   'icon_class_name' => $this->db->escape_str(trim($icon_class_name)),
		   'url_link' => $this->db->escape_str(trim($url_link)),
		   'display_order' => $this->db->escape_str(trim($display_order)),
		   'status' => $this->db->escape_str(trim($status)),
		);

		//Update the record into the database.
		$this->db->dbprefix('admin_menu');
		$this->db->where('id',$page_id);
		
		$upd_into_db = $this->db->update('admin_menu', $upd_data);
		//echo $this->db->last_query(); exit;
		
		if($upd_into_db) return true;

	}//end edit_new_page()

	//Delete Page
	public function delete_menu($page_id){
		
		//Delete the record from the database.
		$this->db->dbprefix('admin_menu');
		$this->db->where('id',$page_id);
		$del_into_db = $this->db->delete('admin_menu');
		//$this->db->last_query();
		
		if($del_into_db) return true;

	}//end delete_page()

}
?>