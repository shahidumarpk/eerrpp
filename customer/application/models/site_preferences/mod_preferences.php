<?php
class mod_preferences extends CI_Model {
	
	function __construct(){
		
        parent::__construct();
    }

	//Get Site Preferences
	public function get_preferences_setting($setting_name){
		
		$this->db->dbprefix('site_preferences');
		
		$this->db->where('setting_name',$setting_name);
		$get_setting = $this->db->get('site_preferences');

		//echo $this->db->last_query(); exit;
		return $get_setting->row_array();
		
	}//end get_preferences_setting

}
?>