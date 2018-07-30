
<?php
class mod_products extends CI_Model {
	
	function __construct(){
		
        parent::__construct();
    }

	//Get All Products
	public function get_all_products(){
		
		$this->db->dbprefix('products');
		$this->db->order_by('id DESC');
		
		$get_all_products = $this->db->get('products');

		//echo $this->db->last_query();
		$row_products['products_list_arr'] = $get_all_products->result_array();
		$row_products['products_list_count'] = $get_all_products->num_rows;
		
		
		return $row_products;
		
	}//end 
	
	
	public function get_all_categories(){
		
			
		$this->db->dbprefix('categories');
		$this->db->where('parent_id',0);
		
		$get_all_categories = $this->db->get('categories');

		//echo $this->db->last_query();
		$row_categories_arr = $get_all_categories->result_array();
		$row_categories_count = $get_all_categories->num_rows;
		$row_categories_fin_arr['categories_count']=$row_categories_count;
		
		for($i=0;$i<$row_categories_count;$i++){
			
			$row_categories_fin_arr[$i]['pid'] = $row_categories_arr[$i]['id'];
			$row_categories_fin_arr[$i]['category_name'] = $row_categories_arr[$i]['category_name'];
			
			
			//Getting lider Images Layer

			$this->db->dbprefix('categories');
			//$this->db->where('status',1);
			$this->db->where('parent_id',$row_categories_arr[$i]['id']);
		
			$get_category = $this->db->get('categories');
			
			$get_category_arr = $get_category->result_array();
			$get_category_count = $get_category->num_rows;
			
			for($j=0;$j<$get_category_count;$j++){
				
					$row_categories_fin_arr[$i]['sub_category'][$j]['cid'] = $row_categories_arr[$i]['id']."-". $get_category_arr[$j]['id'];
					$row_categories_fin_arr[$i]['sub_category'][$j]['category_name'] =$row_categories_arr[$i]['category_name']."->". $get_category_arr[$j]['category_name'];
					
					
					
			}//end for
			
		}//end for
		
		
		
	
		return $row_categories_fin_arr;
		
		
	}//end 
	

   //Product Code Generater.
	public function product_code_generator($product_code){

			$this->db->dbprefix('products');
			$this->db->select('id');
			$this->db->where('product_code', $product_code); 
			$rs_count_rec = $this->db->get('products');
		    $this->db->last_query();
			
			if($rs_count_rec->num_rows == 0) 
			{
			
			return $product_code;
			
			
			}
			
			else{
				//Add Postfix and generate concatenate.
				return  $generate_product_code = $this->mod_common->random_number_generator(7);
				
				
			}//end if
		
	}//end coupon_code_generator($coupon_code)


     
	//Get All packages Count
	public function get_all_packages_count(){
		
		$this->db->dbprefix('packages');
		return $this->db->count_all("packages");
		
	}//end get_all_packages_count

	//Get Packages Record by ID
	public function get_products($product_id){
		
		$this->db->dbprefix('products');
		$this->db->where('product_code',$product_id);
		$get_product = $this->db->get('products');

		//$this->db->last_query(); exit;
		
		$row_product['product_arr'] = $get_product->row_array();
		$row_product['product_arr_count'] = $get_product->num_rows;
		
		return $row_product;
		
	}//end get_products
	
	
	public function get_products_images($product_id){
		
		$this->db->dbprefix('products_images');
		$this->db->where('product_id',$product_id);
		
		$get_product_images = $this->db->get('products_images');

		//$this->db->last_query(); exit;
		
		$row_product_images['product_images_arr'] = $get_product_images->result_array();
		$row_product_images['product_images_arr_count'] = $get_product_images->num_rows;
		
		
		return $row_product_images;
		
	}//end get_product_images
	
	
	
	
	
	//Add New package
	public function add_new_products($data){
		
		extract($data);
		
		$product_cat=implode(',',$product_category);
		
		$created_date = date('Y-m-d G:i:s');
		$ip_address = $this->input->ip_address();
		$created_by = $this->session->userdata('admin_id');
		$product_code=$this->session->userdata('product_code');
		
		$ins_data = array(
		   'product_code' => $this->db->escape_str(trim($product_code)),
		   'product_name' => $this->db->escape_str(trim($product_name)),
		   'product_category' => $this->db->escape_str(trim($product_cat)),
		   'product_discription' => $this->db->escape_str(trim(nl2br($product_discription))),
		   'product_status' => $this->db->escape_str(trim($product_status)),
		   'product_tags' => $this->db->escape_str(trim($product_tags)),
		   'product_original_price' => $this->db->escape_str(trim($product_original_price)) ,
		   'discount_percentage' => $this->db->escape_str(trim($discount_percentage)),
		   'weight' => $this->db->escape_str(trim($weight)),
		   'dimensions' => $this->db->escape_str(trim($dimensions)),
		   'quantity_in_hand' => $this->db->escape_str(trim($quantity_in_hand)),
		   'model' => $this->db->escape_str(trim($model)),
		   'color' => $this->db->escape_str(trim($color)),
		   'package' => $this->db->escape_str(trim($package)),
		   'meta_keywords' => $this->db->escape_str(trim(nl2br($meta_keywords))),
		   'meta_discription' => $this->db->escape_str(trim(nl2br($meta_discription))) ,
		   'meta_title' => $this->db->escape_str(trim(nl2br($meta_title))),
		   'seo_url' => $this->db->escape_str(trim($seo_url)),
		   'image_title' => $this->db->escape_str(trim($image_title)),
		   'image' => $this->db->escape_str(trim($image)),
		   'image_discription' => $this->db->escape_str(trim(nl2br($image_discription))),
		   'image_status' => $this->db->escape_str(trim($image_status)) ,
		   'display_order' => $this->db->escape_str(trim($display_order)),
		   'created_by' => $this->db->escape_str(trim($created_by)),
		   'created_by_ip' => $this->db->escape_str(trim($ip_address)),
		   'created_by_date' => $this->db->escape_str(trim($created_date)),
		);

      
		//Insert the record into the database.
		$this->db->dbprefix('products');
		$ins_into_db = $this->db->insert('products', $ins_data);
		
        //Unset Product_code Session Data
	    $this->session->unset_userdata('product_code');

		if($ins_into_db) return true;

	}//end add_new_products()

	//Edit products
	public function edit_product($data){
		
		extract($data);
		
		$product_cat=implode(',',$product_category);
		
		$last_modified_date = date('Y-m-d G:i:s');
		$last_modified_ip = $this->input->ip_address();
		$last_modified_by = $this->session->userdata('admin_id');

		$upd_data = array(
		   'product_name' => $this->db->escape_str(trim($product_name)),
		   'product_category' => $this->db->escape_str(trim($product_cat)),
		   'product_discription' => $this->db->escape_str(trim(nl2br($product_discription))),
		   'product_status' => $this->db->escape_str(trim($product_status)),
		   'product_tags' => $this->db->escape_str(trim($product_tags)),
		   'product_original_price' => $this->db->escape_str(trim($product_original_price)) ,
		   'discount_percentage' => $this->db->escape_str(trim($discount_percentage)),
		   'weight' => $this->db->escape_str(trim($weight)),
		   'dimensions' => $this->db->escape_str(trim($dimensions)),
		   'quantity_in_hand' => $this->db->escape_str(trim($quantity_in_hand)),
		   'model' => $this->db->escape_str(trim($model)),
		   'color' => $this->db->escape_str(trim($color)),
		   'package' => $this->db->escape_str(trim($package)),
		   'meta_keywords' => $this->db->escape_str(trim(nl2br($meta_keywords))),
		   'meta_discription' => $this->db->escape_str(trim(nl2br($meta_discription))) ,
		   'meta_title' => $this->db->escape_str(trim($meta_title)),
		   'seo_url' => $this->db->escape_str(trim($seo_url)),
		   'image_title' => $this->db->escape_str(trim($image_title)),
		   'image' => $this->db->escape_str(trim($image)),
		   'image_discription' => $this->db->escape_str(trim(nl2br($image_discription))),
		   'image_status' => $this->db->escape_str(trim($image_status)) ,
		   'display_order' => $this->db->escape_str(trim($display_order)),
		   'last_modified_by' => $this->db->escape_str(trim($last_modified_by)),
		   'last_modified_date' => $this->db->escape_str(trim($last_modified_date)),
		   'last_modified_ip' => $this->db->escape_str(trim($last_modified_ip))

		);

		//Insert the record into the database.
		$this->db->dbprefix('products');
		$this->db->where('product_code',$product_id);
		$upd_into_db = $this->db->update('products', $upd_data);
		//echo $this->db->last_query(); exit;
		
		
			if($upd_into_db) return true;
			
		
		
	}//end edit_product()

	//Delete products
	public function delete_products($product_id){
		
		
		//Delete the record from the database.
		$this->db->dbprefix('products');
		$this->db->where('product_code',$product_id);
		$del_into_db = $this->db->delete('products');
		//$this->db->last_query();
		
		//Delete Product Images
		$this->db->dbprefix('products_images');
		$this->db->where('product_id',$product_id);
		
		$get_into_db = $this->db->get('products_images');
		$row_images= $get_into_db->result_array();
	    $row_count=$get_into_db->num_rows;
		
		$path='../assets/products/files';
		
		//Delete Existing Image
	
		for($i=0; $i<$row_count; $i++){
			
	      if(file_exists($path.'/'. $row_images[$i][name])){
			  
			   $file_name= $row_images[$i][name];
			    unlink($path.'/'.$file_name);
			    unlink($path.'/thumbnail/'.$file_name);
			
		     }//end if
	   }
		
		
		$this->db->dbprefix('products_images');
		$this->db->where('product_id',$product_id);
		$del_into_db = $this->db->delete('products_images');
		
		
		if($del_into_db) return true;

	}//end delete_products()
	
	//Delete products Images
	public function delete_products_images($image_id){
		
		$this->db->dbprefix('products_images');
		$this->db->where('id',$image_id);
		$get_into_db = $this->db->get('products_images');
		$row_product= $get_into_db->row_array();
		
		$file_name=$row_product['name'];
		
	
		$path='../assets/products/files';
		
		//Delete Existing Image
		if(file_exists($path.'/'.$file_name)){
			
			unlink($path.'/'.$file_name);
			unlink($path.'/thumbnail/'.$file_name);
			
		}//end if
		
		
		//Delete the record from the database.
		$this->db->dbprefix('products_images');
		$this->db->where('id',$image_id);
		$del_into_db = $this->db->delete('products_images');
		//$this->db->last_query();
		
		
		if($del_into_db) return true;

	}//end delete_products()
	
}
?>