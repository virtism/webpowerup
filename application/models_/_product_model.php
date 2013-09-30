<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 class product_model extends CI_Model{
 
	 var $cat_name;
	 var $site_name;
	 var $upload_path;
	 var $site_id;
	 var $product_id;
	 	 
	function __construct()
	{
	   // Call the Model constructor  
		parent::__construct();
		
		$this->load->model('categories_model');
		$this->cat_name = '';
		$this->site_name = '';
		$this->upload_path = '';
		$this->site_id = '';
		$this->product_id = '';
	}
 
   function count_posts($catid)
   {
	   $this->db->where('category_id', intval($catid));
	   return $this->db->count_all_results('ec_products');
	   
   }
   
   function get_user_group_id ($id=0)
	{
		//echo $id.'>>>>>>>>>>>>>';
			$rows = array();
			$gruop_id = 0;
			$this->db->select('membershipid,group_code');
			$this->db->where('customer_id',intval($id));
			$query = $this->db->get('ec_customers');
			//$query = $this->db->get_where('user_packages_xref', array('user_id' => intval($id)));  
			 if ($query->num_rows() > 0){
			   foreach ($query->result_array() as $row ){
				 // echo '%%%%%'.$row['membershipid'].'%%%';
				   if($row['membershipid'] != 0 || $row['membershipid'] != 'N/A' ){
						$gruop_id = $row['membershipid'];
				   }
				}
			 } 
			 
		 // echo $gruop_id.': >>>>>>>>>>>>>>>> '; exit();
		  return $gruop_id; 
	}
   
   function getProductsByCategory($catid='', $limit = NULL, $offset = NULL)
   {
	  
	  // this is used in function cat($id) in the shop frontend
	  // When a product is clicked this will be used.
	  // If not $cat['parentid'] < 1
	  // $catid is given in URI, the third element
	 // echo "--------------------".$sitid;
		$data = array();
		if($catid!='' || $catid!=0)
		{
			 $this->db->where('category_id', intval($catid));
			 $this->db->where('del_stats', '0');
			 $this->db->where('publish', 'Yes');
			 $this->db->order_by('product','asc');
			 $this->db->limit($limit, $offset);
			 $Q = $this->db->get('ec_products');
			 if ($Q->num_rows() > 0){
			   foreach ($Q->result_array() as $row)
			   {
				   /*echo "<pre>";
				   print_r($row);
				   exit;*/
				   if($row['permission'] == 'Other')
				   {
						if(isset($_SESSION['login_info']) && isset ($_SESSION['login_info']['customer_id']))
						{	
							$group_id = $this->get_user_group_id($_SESSION['login_info']['customer_id']);							
							$groups = explode(",",$row['group']);
							
							if (in_array($group_id,$groups))
							{
								//$names['sit_name'] = $this->getSiteNameById($site_id);		
								//$product = $this->getProduct($row['box_product']);
								//$names['cat_name'] = str_replace(' ','_',strtolower(trim($this->getCategory($product['category_id'],$site_id))));
								//$data[] = array_merge($product, $row,$names);
								$data[] = $row;						
							}
						}   
				   }
				   else if($row['permission'] == 'Registered')
				   {
						if(isset ($_SESSION['login_info']) && isset ($_SESSION['login_info']['customer_id']) )
						{
							if($_SESSION['user_info']['user_id'])
							{
								//$names['sit_name'] = $this->getSiteNameById($site_id);		
								//$product = $this->getProduct($row['box_product']);
								//$names['cat_name'] = str_replace(' ','_',strtolower(trim($this->getCategory($product['category_id'],$site_id))));
								//$data[] = array_merge($product, $row,$names);
								$data[] = $row;						
							}
						}  

				   }
				   else if($row['permission'] == 'Everyone')
				   {
						//$names['sit_name'] = $this->getSiteNameById($site_id);		
						//$product = $this->getProduct($row['box_product']);
						//$names['cat_name'] = str_replace(' ','_',strtolower(trim($this->getCategory($product['category_id'],$site_id))));
						//$data[] = array_merge($product, $row,$names);			
						$data[] = $row;
				   }
			   }
			 }
			 $Q->free_result();
		}
		//echo "<pre>"; print_r($data);exit;
		return $data;
}
   
   function getProduct($id=''){
		// getting info of single product.
		$data = array();
		$options = array('product_id' => intval($id));
		$Q = $this->db->get_where('ec_products',$options,1);
		if ($Q->num_rows() > 0){
			$data = $Q->row_array();
		}
		$Q->free_result();
		return $data;
	}
	
   function getProduct_digital($id=''){
		// getting info of single product.
		$data = array();
		$options = array('product_id' => intval($id));
	   $Q = $this->db->get_where('ec_products_attributes_download',$options,1); 

		if ($Q->num_rows() > 0){  
			$data = $Q->row_array();
		}
		$Q->free_result();
		return $data;
	}
   function getProduct_attribute($id=''){
		// getting info of single product.
		$data = array();
		//$options = array('product_id' => intval($id));
		// $Q = $this->db->get_where('ec_products_attributes',$options,1);
		$this->db->where('product_id',intval($id)); 
		$Q = $this->db->get('ec_products_attributes');

		if ($Q->num_rows() > 0){
			foreach ($Q->result_array() as $row){ 
			$data[] = $row;
			}
		}
		$Q->free_result(); 
		return $data;
	}
	
 
	function getAllProducts($site_id= 0){
		$this->site_id = $site_id;
		// getting all the products of the same categroy.
		$data = array();
		 $Q = $this->db->query('SELECT P.*, C.cat_name AS CatName FROM ec_products AS P LEFT JOIN ec_category AS C ON C.cat_id = P.category_id WHERE P.del_stats = 0 AND  C.site_id='.$this->site_id.'');
		if ($Q->num_rows() > 0){
			foreach ($Q->result_array() as $row){
			$data[] = $row;
		   }
		}
		$Q->free_result();
		return $data;
 }
 
	 function getProductsDropdown($site_id= 0)
	{            $this->site_id = $site_id; 
				 $data = array();
				 $data[0] = 'Select Product';
				 //$this->db->select('role_id,role_name');
				 //$this->db->where('delete ','0'); 
				 //$this->db->order_by('role_id','asc'); 
				 $Q = $this->db->query('SELECT P.*, C.cat_name AS CatName FROM ec_products AS P LEFT JOIN ec_category AS C ON C.cat_id = P.category_id WHERE P.del_stats = 0 AND  C.site_id='.$this->site_id.'');
				 //$Q = $this->db->get('roles');
				 if ($Q->num_rows() > 0){
				   foreach ($Q->result_array() as $row){
					 $data[$row['product_id']] = $row['product'];
				   }
				}
				$Q->free_result();
				return $data;
		
		
		
		
	}
/* Not used any more
 * This was used to get featured products. Need to replace featured_name_here to a featured name.
	function getProducts(){
		$data = array();
		$Q = $this->db->query('SELECT P.*, C.Name AS CatName
		FROM omc_product AS P
		LEFT JOIN omc_category AS C ON C.id = P.category_id
		WHERE featured = "featured_name_here"');
		return $Q;
 }
 */
 

 
	  function getProductsByGroup($limit,$group,$skip){
	   // page 99
	   // for the shop fron-end controller function product($id)
		 $data = array();
		 if ($limit == 0){
			$limit=3;
		 }
		 $this->db->select('id,name,shortdesc,thumbnail');
		 $this->db->where('grouping', db_clean($group,16));
		 $this->db->where('status', 'active');
		 $this->db->where('id !=', id_clean($skip));
		 $this->db->orderby('name','asc');
		 $this->db->limit($limit);
		 $Q = $this->db->get('omc_product');
		 if ($Q->num_rows() > 0){
		   foreach ($Q->result_array() as $row){
			 $data[] = $row;
		   }
		}
		$Q->free_result();
		return $data;
	 }
 
	  function getGallery($id){
 
	   $data = array();
 
		 $Q = $this->db->query('SELECT P.*, C.Name AS CatName
				   FROM omc_product AS P
				   LEFT JOIN omc_category C
				   ON C.id = P.category_id
				   WHERE C.Name = "Galleri ' . $id . '"
				   AND p.status = "active"
				   ');
 
		 if ($Q->num_rows() > 0){
		   foreach ($Q->result_array() as $row){
			 $data[] = $row;
		   }
		  }
 
		$Q->free_result();
 
		return $data;
	 }
 
	 function getMainFeature(){
		 $data = array();
		 $this->db->select("id,name,shortdesc,image");
		 $this->db->where('featured','true');
		 $this->db->where('status', 'active');
		 $this->db->order_by('name','random');
 
		 $Q = $this->db->get('omc_product');
		 if ($Q->num_rows() > 0){
		   foreach ($Q->result_array() as $row){
			 $data[] = $row;
		   }
		}
		$Q->free_result();
		return $data;
	 }
 
	 function getFrontFeature($feature){
		 $data = array();
		 $this->db->where('featured',$feature);
		 $this->db->where('status', 'active');
		 $this->db->LIMIT(9);
		 $this->db->order_by('name','random');
		 $Q = $this->db->get('omc_product');
		 if ($Q->num_rows() > 0){
			foreach ($Q->result_array() as $row){
			$data[] = $row;
		   }
		}
		$Q->free_result();
		return $data;
	 }
 
	 function getFeatureProducts($catname){
		 $data = array();
		 $Q = $this->db->query("SELECT P.*, C.Name AS CatName
					   FROM omc_product AS P
					   LEFT JOIN omc_category AS C
					   ON C.id = P.category_id
					   WHERE C.Name = '$catname'
					   AND p.status = 'active'
					   ORDER BY RAND()
					   ");
		 if ($Q->num_rows() > 0){
		   foreach ($Q->result_array() as $row){
			 $data[] = $row;
		   }
		}
		$Q->free_result();
		return $data;
	 }
 
	 function getFrontbottom(){
		 $data = array();
		 $Q = $this->db->query("SELECT P.*, C.Name AS CatName
					   FROM omc_product AS P
					   LEFT JOIN omc_category AS C
					   ON C.id = P.category_id
					   WHERE C.Name = 'Front bottom'
					   AND p.status = 'active''
					   ORDER BY RAND()
					   ");
		 if ($Q->num_rows() > 0){
			foreach ($Q->result_array() as $row){
			$data[] = $row;
		   }
		}
		$Q->free_result();
		return $data; 
 
	 }
 
	function getRandomProducts($limit,$skip){
		// when you want to select three random products, use this.
		$data = array();
		$temp = array();
		if ($limit == 0){
			$limit=3; // change this number
		}
		$this->db->select("id,name,thumbnail,category_id");
		$this->db->where('id !=', id_clean($skip));
		$this->db->where('status','active');
		$this->db->orderby("category_id","asc");
		$this->db->limit(100);
		$Q = $this->db->get('omc_product');
		if ($Q->num_rows() > 0){
			foreach ($Q->result_array() as $row){
				$temp[$row['category_id']] = array(
					"id" => $row['id'],
					"name" => $row['name'],
					"thumbnail" => $row['thumbnail']
				);
			}
		}
 
		shuffle($temp);
		if (count($temp)){
			for ($i=1;$i<=$limit; $i++){
				$data[] = array_shift($temp);
			}
		}
		$Q->free_result();
		return $data;
	}
 
	function search($term){
		$data = array();
		$this->db->select('id,name,shortdesc,thumbnail');
		$this->db->where("(name LIKE '%$term%' OR shortdesc LIKE '%$term%' OR longdesc LIKE '%$term%') AND status='active'");
		$this->db->orderby('name','asc');
		$this->db->limit(50);
		$Q = $this->db->get('omc_product');
		if ($Q->num_rows() > 0){
		   foreach ($Q->result_array() as $row){
			 $data[] = $row;
		   }
		}
		$Q->free_result();
		return $data;
	}
 
 // ############ method to add product ############//
	 function addProduct($site_id='', $img_ary = array(), $attribute_ary = array()){
	 			
			/*echo "<pre>";
				   print_r($_REQUEST);
				   exit;*/
			$this->load->library('upload');
			$this->site_id = $site_id;  
			$group_access = $this->input->post('group_access');
			if(isset($group_access)&&!empty($group_access))
			{
				$comma_separated_groups = implode(",", $group_access);
			}
			else
			{
				$comma_separated_groups = '0';
			}			
			$config = array();
			$config_resize = array(); 
			$data = array(); 
			$cat_data = array(); 		  
			$cat_id = trim($this->input->post('parentid'));
			$this->site_name =  $this->categories_model->getSiteNameById(intval($this->site_id));
			$cat_data =  $this->categories_model->getCategory(intval($cat_id),intval($this->site_id));
			$cat = str_replace(' ','_',strtolower(trim($cat_data['cat_name']))); 
			$this->cat_name = $cat;
			$root_dir = $_SERVER['DOCUMENT_ROOT']; 
			$ecommecre = $root_dir.'/media/ecommerce';
			$ecommecre_site =  $ecommecre.'/'.$this->site_name;
			$category_path =  $ecommecre_site.'/'.$this->cat_name;
			$product_path_full =  $category_path.'/full_size';
			$product_path_thumb =  $category_path.'/thumb';
	
		  if(!is_dir($product_path_full))
		   {
			  if(!is_dir($product_path_full)) 
			   {
				 mkdir($product_path_full , 0777, true); 
			   //  echo  'Here ='.$category_path.'<br>';   
			   }
			  
			 else if(!is_dir($product_path_thumb)) 
				{
				  mkdir($product_path_thumb , 0777, true); 
				}
		   }
			if(!is_dir($product_path_thumb))
		   {
			  mkdir($product_path_thumb , 0777, true);  
		   }		  
		
		if($this->input->post('image_rd') == 'Yes')
		{  
					$img = $this->input->post('product_name').'_'.rand();
					$config['file_name'] = $img; 
					$config['upload_path'] = './media/ecommerce/'.$this->site_name.'/'.$this->cat_name.'/full_size/';
				  //  $config['upload_path'] = './media/uploads/';
					$config['allowed_types'] = 'gif|jpg|png|ico';
					$config['max_size']    = '1000';
					$config['max_width']  = '1024';
					$config['max_height']  = '768';
					
					$files =  'product_image';
					$this->upload->initialize($config); 
					$retrive_img = $this->upload->do_upload($files);
					if($retrive_img)
					{
					   //$error = array('error_img' => $this->upload->data()); 
					   $return_valu =  $this->upload->data(); 

						$config_resize['source_image'] = $return_valu['full_path'];
						$config_resize['new_image'] = './media/ecommerce/'.$this->site_name.'/'.$this->cat_name.'/thumb/';
					   // $config_resize['new_image'] = './media/uploads/';
					   // $config_resize['maintain_ratio'] = false;
					   // $config_resize['create_thumb'] = TRUE;
						$config_resize['maintain_ratio'] = true;
						$config_resize['width'] = 125;
						$config_resize['height'] = 116;
				 
						$this->load->library('image_lib', $config_resize);
						$resize_img = $this->image_lib->resize();
					   
						//  $return_data = array('upload_data' => $this->upload->data());  
						$data = array(
						'product' => $this->input->post('product_name'),
						'short_desc' =>  $this->input->post('short_desc'),
						'full_desc' => $this->input->post('full_desc'), 
						
						'thumbnail' =>  $return_valu['file_name'],
						'image' =>  $return_valu['file_name'], 
						
						'meta_title' => $this->input->post('title_tag'), 
						'meta_keywords' => $this->input->post('meta_key'), 
						'meta_description' => $this->input->post('meta_desc'),
						 
						'list_price' => $this->input->post('price'),         
						'free_tax' => $this->input->post('taxable_rd'),         
						'tax' => $this->input->post('price_tax').$this->input->post('tax_param'),         
						'category_id' =>  intval($this->input->post('parentid')), 
						
						'permission' => $this->input->post('access_permision'),
						'access_level' => $this->input->post('options_acess_level'),
						'product_type' => $this->input->post('digital_pro'),
						
						'qty_in_stock' => $this->input->post('qty_in_stock'),
						'low_avail_limit' => $this->input->post('low_avail_limit'),
						'min_amount' => $this->input->post('min_order_qty'),
						'return_time' => $this->input->post('pd_return_time'),
						
						'weight_lbs' => $this->input->post('weight_lbs'),
						'free_shipping' => $this->input->post('free_shipping'),
						'shipping_freight' => $this->input->post('shipping_freight'),
						'use_dimensions' => $this->input->post('us_dimensions_for_shipping'),
						'box_length' => $this->input->post('box_length'),
						'box_width' => $this->input->post('box_width'),
						'box_height' => $this->input->post('box_height'),
						'separate_box' => $this->input->post('separate_box'),
						'items_per_box' => $this->input->post('items_per_box'),
						
						'length' => $this->input->post('length'),
						'width' => $this->input->post('width'),
						'height' => $this->input->post('height'),
						'weight' => $this->input->post('weight'),
						
						'sku' => $this->input->post('sku_allow'),
						'group' => $comma_separated_groups,
						'add_date' => 'NOW()',
						
						'publish' =>  $this->input->post('publish') 
						 );  
						
					   // return $retrive_img;
					}
					else
					{
					   $error = array('error' => $this->upload->display_errors());
						 //return $error;
						 return false;
					}
		}
		else
		{
				$data = array(
						'product' => $this->input->post('product_name'),
						'short_desc' =>  $this->input->post('short_desc'),
						'full_desc' => $this->input->post('full_desc'), 
						
						'meta_title' => $this->input->post('title_tag'), 
						'meta_keywords' => $this->input->post('meta_key'), 
						'meta_description' => $this->input->post('meta_desc'),
						 
						'list_price' => $this->input->post('price'),         
						'free_tax' => $this->input->post('taxable_rd'),         
						'tax' => $this->input->post('price_tax').$this->input->post('tax_param'),         
						'category_id' =>  intval($this->input->post('parentid')), 
						
						'permission' => $this->input->post('access_permision'),
						'access_level' => $this->input->post('options_acess_level'),
						'product_type' => $this->input->post('digital_pro'),
						
						'qty_in_stock' => $this->input->post('qty_in_stock'),
						'low_avail_limit' => $this->input->post('low_avail_limit'),
						'min_amount' => $this->input->post('min_order_qty'),
						'return_time' => $this->input->post('pd_return_time'),
						
						'weight_lbs' => $this->input->post('weight_lbs'),
						'free_shipping' => $this->input->post('free_shipping'),
						'shipping_freight' => $this->input->post('shipping_freight'),
						'use_dimensions' => $this->input->post('us_dimensions_for_shipping'),
						'box_length' => $this->input->post('box_length'),
						'box_width' => $this->input->post('box_width'),
						'box_height' => $this->input->post('box_height'),
						'separate_box' => $this->input->post('separate_box'),
						'items_per_box' => $this->input->post('items_per_box'),
						
						'length' => $this->input->post('length'),
						'width' => $this->input->post('width'),
						'height' => $this->input->post('height'),
						'weight' => $this->input->post('weight'),
						
						'sku' => $this->input->post('sku_allow'),
						'group' => $comma_separated_groups,
						'add_date' => 'NOW()',
						
						'publish' =>  $this->input->post('publish') 
						 );   
			
			
		}    
		
		$this->db->insert('ec_products', $data);
		$product_id = $this->db->insert_id(); 
		$this->product_id   =  $product_id; 
		if ($this->input->post('digital_pro') == 'Digital')
		{  
					$file_upload = $this->input->post('product_name').'_'.rand();
					$config['file_name'] = $file_upload;   
					$config['upload_path'] = './media/ecommerce/downloadproducts';
					//$config['upload_path'] = './media/ecommerce/'.$this->site_name.'/'.$this->cat_name.'/'; 					
					$config['allowed_types'] = 'zip|rar|exe|msi|jar|sql|pdf|tgz|csv|gzip|iso|png|jpg|doc';
					$config['max_size']    = '0'; 
					$filess =  'digital_product';
					$this->upload->initialize($config); 
					$retrive_result = $this->upload->do_upload($filess);
					$file_url = trim($this->input->post('digital_download_url'));
					if($retrive_result || !empty($file_url))
					{
						 $return =  $this->upload->data();
						 $data = array(
							'product_id' => intval($this->product_id),
							'products_attributes_filename' =>  $return['file_name'],
							'products_attributes_url' => $this->input->post('digital_download_url'),
							'products_attributes_max_download' =>  $this->input->post('digital_max_download'),
							'products_attributes_expire' =>  $this->input->post('digital_download_expire')
							 );  
						 $this->db->insert('ec_products_attributes_download', $data);
					}
					else{
						$error = array('error' => $this->upload->display_errors());
					    
						//echo $error.'>>>>>>>>>>>>>';
					   //  return $error;
						 return false;
						
					}
		}	
		if(! empty($attribute_ary))
		 {
			 for ($i=1; $i<= count($attribute_ary); $i++)
			 {
				 if ($attribute_ary[$i]['title'] && $attribute_ary[$i]['desc'] != '' || $attribute_ary[$i]['title'] && $attribute_ary[$i]['desc'] != NULL)
				 {
					  $data = array(
						 //  'products_attributes_id' => intval($product_id),
							'product_id' => intval($this->product_id),
							'attribute_title' =>  trim($attribute_ary[$i]['title']),
							'attribute_values' => trim($attribute_ary[$i]['desc'])
							 ); 
						
						 $this->db->insert('ec_products_attributes', $data);
					 
				 }
				 
			 }
			
		 }

		if(! empty($img_ary))
		 {  
			 for ($i=1; $i<= count($img_ary); $i++)
			 {

				 if ($img_ary[$i]['title'] != '' || $img_ary[$i]['title']  != NULL)
				 {
 
					 $img = $this->input->post('product_name').'_galary_'.rand();
						$config['file_name'] = $img; 
						$config['upload_path'] = './media/ecommerce/'.$this->site_name.'/'.$this->cat_name.'/full_size/';
					  //  $config['upload_path'] = './media/uploads/';
						$config['allowed_types'] = 'gif|jpg|png';
						$config['max_size']    = '1000';
						$config['max_width']  = '1024';
						$config['max_height']  = '768';
						
					   //  $imges = $_FILES['image1'];
					   // $files =  'product_image';
					   // $files =  'image1[name]['.$i.'][image]';
						//$files =  $_FILES['image1']['name'][$i]['image'];
					   // $files =  $imges['name'][$i]['image']; 
						
						$field_name = "galaryImg_".$i;
						
						$this->upload->initialize($config); 
						$retrive_img = $this->upload->do_upload($field_name);
						
						//$retrive_img = $this->upload->data();
					   // echo $retrive_img."retrive_img  .........." ;
						echo $this->upload->display_errors();
					   // exit(); 
						
						if($retrive_img)
						 {
							   //$error = array('error_img' => $this->upload->data()); 
							   $return_valu =  $this->upload->data(); 

								$config_resize['source_image'] = $return_valu['full_path'];
								$config_resize['new_image'] = './media/ecommerce/'.$this->site_name.'/'.$this->cat_name.'/thumb/';
							   // $config_resize['new_image'] = './media/uploads/';
							   // $config_resize['maintain_ratio'] = false;
							   // $config_resize['create_thumb'] = TRUE;
								$config_resize['maintain_ratio'] = true;
								$config_resize['width'] = 125;
								$config_resize['height'] = 116;
						 
								$this->load->library('image_lib', $config_resize);
								$resize_img = $this->image_lib->resize(); 
								
								$data_gal = array(
								 //  'products_attributes_id' => intval($product_id),
									'product_id' => intval($this->product_id),
									'image' => $return_valu['file_name'] ,
									'title' => trim($img_ary[$i]['title']),
									'description' => trim($img_ary[$i]['desc'])
									 ); 
								
								 $this->db->insert('ec_products_images', $data_gal);
						  }
				 }
				 
			 }
			  
			
		 }
		 
		
	   //return true; 
		return $product_id;    
	 }
 
  function updateProduct($site_id=''){
	  
			  
			$this->load->library('upload');
			$this->site_id = $site_id;  
			$group_access = $this->input->post('group_access');
			if(isset($group_access)&&!empty($group_access))
			{
				$comma_separated_groups = implode(",", $group_access);
			}
			else
			{
				$comma_separated_groups = '0';
			}			
			$config = array();
			$config_resize = array(); 
			$data = array(); 
			$cat_data = array(); 		  
			$cat_id = trim($this->input->post('parentid'));
			//echo $cat_id.'cat_id';
			$this->site_name =  $this->categories_model->getSiteNameById(intval($this->site_id));
			$cat_data =  $this->categories_model->getCategory(intval($cat_id),intval($this->site_id));
			// print_r($cat_data);
			$cat = str_replace(' ','_',strtolower(trim($cat_data['cat_name']))); 
			$this->cat_name = $cat;
			$root_dir = $_SERVER['DOCUMENT_ROOT']; 
			$ecommecre = $root_dir.'/gws/media/ecommerce';
			$ecommecre_site =  $ecommecre.'/'.$this->site_name;
			$category_path =  $ecommecre_site.'/'.$this->cat_name;
			$product_path_full =  $category_path.'/full_size';
			$product_path_thumb =  $category_path.'/thumb';
		   
		  if(!is_dir($product_path_full))
		   {
			  if(!is_dir($product_path_full)) 
			   {
				 mkdir($product_path_full , 0777); 
			   //  echo  'Here ='.$category_path.'<br>';   
			   }
			  
			 else if(!is_dir($product_path_thumb)) 
				{
				  mkdir($product_path_thumb , 0777); 
				}
		   }
			if(!is_dir($product_path_thumb))
		   {
			  mkdir($product_path_thumb , 0777);  
		   }
		  
		  //  echo $this->cat_name.'>>>';
		  //  echo $this->site_id.'>>>';
		  // echo $this->site_name.'>>>';
			
		if($this->input->post('image_rd') == 'Yes')
		{  
					$img = $this->input->post('product_name').'_'.rand();
					$config['file_name'] = $img; 
					$config['upload_path'] = './media/ecommerce/'.$this->site_name.'/'.$this->cat_name.'/full_size/';
				  //  $config['upload_path'] = './media/uploads/';
					$config['allowed_types'] = 'gif|jpg|png';
					$config['max_size']    = '1000';
					$config['max_width']  = '1024';
					$config['max_height']  = '768';
					
					$files =  'product_image';
					$this->upload->initialize($config); 
					$retrive_img = $this->upload->do_upload($files);
					
					//$retrive_img = $this->upload->data();
				   // echo $retrive_img."retrive_img  .........." ;
				   // echo $this->upload->display_errors();
				   // exit(); 
					
					if($retrive_img)
					{
					   //$error = array('error_img' => $this->upload->data()); 
					    $return_valu =  $this->upload->data(); 
						$config_resize['source_image'] = $return_valu['full_path'];
						$config_resize['new_image'] = './media/ecommerce/'.$this->site_name.'/'.$this->cat_name.'/thumb/';
					   // $config_resize['new_image'] = './media/uploads/';
					   // $config_resize['maintain_ratio'] = false;
					   // $config_resize['create_thumb'] = TRUE;
						$config_resize['maintain_ratio'] = true;
						$config_resize['width'] = 125;
						$config_resize['height'] = 116;
				 
						$this->load->library('image_lib', $config_resize);
						$resize_img = $this->image_lib->resize();
					   
						//  $return_data = array('upload_data' => $this->upload->data());  
						$data = array(
						'product' => $this->input->post('product_name'),
						'short_desc' =>  $this->input->post('short_desc'),
						'full_desc' => $this->input->post('full_desc'), 
						
						'thumbnail' =>  $return_valu['file_name'],
						'image' =>  $return_valu['file_name'], 
						
						'meta_title' => $this->input->post('title_tag'), 
						'meta_keywords' => $this->input->post('meta_key'), 
						'meta_description' => $this->input->post('meta_desc'),
						 
						'list_price' => $this->input->post('price'),         
						'free_tax' => $this->input->post('taxable_rd'),         
						'tax' => $this->input->post('price_tax').$this->input->post('tax_param'),         
						'category_id' =>  intval($this->input->post('parentid')), 
						
						'permission' => $this->input->post('access_permision'),
						'access_level' => $this->input->post('options_acess_level'),
						'product_type' => $this->input->post('digital_pro'),
						
						'qty_in_stock' => $this->input->post('qty_in_stock'),
						'low_avail_limit' => $this->input->post('low_avail_limit'),
						'min_amount' => $this->input->post('min_order_qty'),
						'return_time' => $this->input->post('pd_return_time'),
						
						'weight_lbs' => $this->input->post('weight_lbs'),
						'free_shipping' => $this->input->post('free_shipping'),
						'shipping_freight' => $this->input->post('shipping_freight'),
						'use_dimensions' => $this->input->post('us_dimensions_for_shipping'),
						'box_length' => $this->input->post('box_length'),
						'box_width' => $this->input->post('box_width'),
						'box_height' => $this->input->post('box_height'),
						'separate_box' => $this->input->post('separate_box'),
						'items_per_box' => $this->input->post('items_per_box'),
						
						'length' => $this->input->post('length'),
						'width' => $this->input->post('width'),
						'height' => $this->input->post('height'),
						'weight' => $this->input->post('weight'),
						
						'sku' => $this->input->post('sku_allow'),
						'group' => $comma_separated_groups,
						'add_date' => 'NOW()',
						
						'publish' =>  $this->input->post('publish') 
						 );  
						
					   // return $retrive_img;
					}
					else
					{
					   $error = array('error' => $this->upload->display_errors());
						 //return $error;
						 return false;
					}
		}
		else
		{
				$data = array(
						'product' => $this->input->post('product_name'),
						'short_desc' =>  $this->input->post('short_desc'),
						'full_desc' => $this->input->post('full_desc'), 
						'meta_title' => $this->input->post('title_tag'), 
						'meta_keywords' => $this->input->post('meta_key'), 
						'meta_description' => $this->input->post('meta_desc'),
						'list_price' => $this->input->post('price'),         
						'free_tax' => $this->input->post('taxable_rd'),         
						'tax' => $this->input->post('price_tax').$this->input->post('tax_param'),         
						'category_id' =>  intval($this->input->post('parentid')), 
						'permission' => $this->input->post('access_permision'),
						'access_level' => $this->input->post('options_acess_level'),
						'product_type' => $this->input->post('digital_pro'),
						'qty_in_stock' => $this->input->post('qty_in_stock'),
						'low_avail_limit' => $this->input->post('low_avail_limit'),
						'min_amount' => $this->input->post('min_order_qty'),
						'return_time' => $this->input->post('pd_return_time'),
						'weight_lbs' => $this->input->post('weight_lbs'),
						'free_shipping' => $this->input->post('free_shipping'),
						'shipping_freight' => $this->input->post('shipping_freight'),
						'use_dimensions' => $this->input->post('us_dimensions_for_shipping'),
						'box_length' => $this->input->post('box_length'),
						'box_width' => $this->input->post('box_width'),
						'box_height' => $this->input->post('box_height'),
						'separate_box' => $this->input->post('separate_box'),
						'items_per_box' => $this->input->post('items_per_box'),
						'length' => $this->input->post('length'),
						'width' => $this->input->post('width'),
						'height' => $this->input->post('height'),
						'weight' => $this->input->post('weight'),
						'sku' => $this->input->post('sku_allow'),
						'group' => $comma_separated_groups,
						'add_date' => 'NOW()',
						'publish' =>  $this->input->post('publish') 
						 );   
		}    
				$this->product_id = trim($this->input->post('product_id'));
				$this->db->where('product_id', $this->product_id);
				$this->db->update('ec_products', $data); 
				$attribute_ary  = $this->input->post('attribute_id');
				$attribute  = $this->input->post('attribute');
		if(! empty($attribute_ary))
		 {
			 for ($i=0; $i< count($attribute_ary); $i++)
			 {
					  $data = array(
							'attribute_title' =>  trim($attribute[$i]['title']),
							'attribute_values' => trim($attribute[$i]['desc'])
							 ); 
						 $this->db->where('product_id', trim($this->product_id));
						 $this->db->where('attribute_id', trim($attribute_ary[$i]['desc']));
			 }
		 }
			   return true;  
}
 
	 function getFeaturedProducts($feature){
		$data = array();
		$this->db->from('omc_product');
		$this->db->where('other_feature', $feature);
		$this->db->where('status', 'active');
		$this->db->limit(1);
		$this->db->order_by("id", "random");
		$Q = $this->db->get();
		if ($Q->num_rows() > 0){
		   foreach ($Q->result_array() as $row){
			 $data[] = $row;
		   }
		}
		$Q->free_result();
		return $data;
	 }
 
	 function _uploadFile(){
		$data = array(
			'name' => db_clean($_POST['name']),
			'shortdesc' => db_clean($_POST['shortdesc']),
			'longdesc' => db_clean($_POST['longdesc'],5000),
			'status' => db_clean($_POST['status'],8),
			'class' => db_clean($_POST['class'],30),
			'grouping' => db_clean($_POST['grouping'],16),
			'category_id' => id_clean($_POST['category_id']),
			'featured' => db_clean($_POST['featured'],20),
			'price' => db_clean($_POST['price'],16),
			'other_feature' => db_clean($_POST['other_feature'],20)
		);
		$catname = array();
		$category_id = $data['category_id'];
		$catname = $this->MCats->getCategoryNamebyProduct($category_id);
		foreach ($catname as $key => $name){
			$foldername = createdirname($name);
			}
		if ($_FILES){
			$config['upload_path'] = './assets/images/'.$foldername.'/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = '200';
			$config['remove_spaces'] = true;
			$config['overwrite'] = true;
			$config['max_width']  = '0';
			$config['max_height']  = '0';
			// Here we are loading CI's file uploading class
			$this->load->library('upload', $config);
			if (strlen($_FILES['image']['name'])){
				if(!$this->upload->do_upload('image')){
					$this->upload->display_errors();
					 exit("unable to open file ($foldername). The folder does not exist. You need to create a category first.");
				}
				$image = $this->upload->data();
				if ($image['file_name']){
					$data['image'] = "assets/images/".$foldername."/".$image['file_name'];
				}
			}
			$config['upload_path'] = './assets/images/'.$foldername.'/thumbnails/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = '200';
			$config['remove_spaces'] = true;
			$config['overwrite'] = true;
			$config['max_width']  = '0';
			$config['max_height']  = '0';
			//initialize otherwise thumb will take the first one
			$this->upload->initialize($config);
			if (strlen($_FILES['thumbnail']['name'])){
				if(!$this->upload->do_upload('thumbnail')){
					$this->upload->display_errors();
					exit("unable to open a thumbnail folder in the folder ($foldername). You need to contact Admin.");
				}
				$thumb = $this->upload->data();
				if ($thumb['file_name']){
					$data['thumbnail'] = "assets/images/".$foldername."/thumbnails/".$thumb['file_name'];
				}
			}
		}
		return $data;
	 }
 
	 function deleteProduct_soft($id){
		// $data = array('status' => 'inactive');
		   $data = array('del_stats' => '1');
			$this->db->where('product_id', intval($id));
			$this->db->update('ec_products', $data);
	 }
	 function deleteProduct_hard($id){
		// $data = array('status' => 'inactive');
		$this->db->where('product_id', intval($id));
		$this->db->delete('ec_products');
	 }
 
	 function changeProductStatus($id){
		// getting status of page
		$productinfo = array();
		$productinfo = $this->getProduct($id);
		$status = $productinfo['publish'];
		if($status =='Yes'){
			$data = array('publish' => 'No');
			$this->db->where('product_id', intval($id));
			$this->db->update('ec_products', $data);
		}else{
			$data = array('publish' => 'Yes');
			$this->db->where('product_id', intval($id));
			$this->db->update('ec_products', $data);
		}
	 }
 
	  function batchUpdate(){
		if (count($this->input->post('p_id'))){
				$data = array('category_id' => id_clean($this->input->post('category_id')),
							'grouping' => db_clean($this->input->post('grouping'))
							);
				$idlist = implode(",",array_values($this->input->post('p_id')));
				$where = "id in ($idlist)";
				$this->db->where($where);
				$this->db->update('omc_product',$data);
				$this->session->set_flashdata('message', 'Products updated');
		}else{
				$this->session->set_flashdata('message', 'Nothing to update!');
		}
 
	  }
 
	 function exportCsv(){
		$this->load->dbutil();
		$Q = $this->db->query("select * from ec_products");
		return $this->dbutil->csv_from_result($Q,",","\n");
	 }
 
	 function importCsv(){
		$config['upload_path'] = './csv/';
		$config['allowed_types'] = 'csv';
		$config['max_size'] = '2000';
		$config['remove_spaces'] = true;
		$config['overwrite'] = true;
		// Here we are loaind CI's File Uploading class
		$this->load->library('upload', $config);
		$this->load->library('CSVReader');
		if(!$this->upload->do_upload('csvfile')){
			$this->upload->display_errors();
			exit();
		}
		$csv = $this->upload->data();
		$path = $csv['full_path'];
		return $this->csvreader->parseFile($path);
	 }
 
	 function csv2db(){
		unset($_POST['submit']);
		unset($_POST['csvgo']);
		foreach ($_POST as $line => $data){
			if (isset($data['id'])){
				$this->db->where('id',$data['id']);
				unset($data['id']);
				$this->db->update('ec_product',$data);
			}else{
				$this->db->insert('ec_product',$data);
			}
		}
	 }
 
	 function reassignProducts(){
		$data = array('category_id' => $this->input->post('categories'));
		$idlist = implode(",",array_keys($this->session->userdata('orphans')));
		$where = "id in ($idlist)";
		$this->db->where($where);
		$this->db->update('omc_product',$data);
	 }
 
	 function getAssignedColors($id){
		// not using anymore
		$data = array();
		$this->db->select('color_id');
		$this->db->where('product_id',id_clean($id));
		$Q = $this->db->get('omc_product_colors');
		if ($Q->num_rows() > 0){
		 /**
		  * products_colors table have product_id and color_id
		  * This will select color_id. where product_id=$id.
		  * e.g. product id = 7 may have color_id 2, 3, 4.
		  */
 
		   foreach ($Q->result_array() as $row){
			 $data[] = $row['color_id'];
		   }
		}
		$Q->free_result();
		return $data;
	 }
 
	 function getAssignedSizes($id){
		// not using anymore
	  /**
	   * products_sizes table has product_id and size_id fields
	   * This will be the same as getAssignedColors() function above
	   * It will returns size_id where product_id is $id
	   * e.g product id=7 may have size_id 2,3,4 etc
	   */
		$data = array();
		$this->db->select('size_id');
		$this->db->where('product_id',id_clean($id));
		$Q = $this->db->get('omc_product_sizes');
		if ($Q->num_rows() > 0){
		   foreach ($Q->result_array() as $row){
			 $data[] = $row['size_id'];
		   }
		}
		$Q->free_result();
		return $data;
	 }
 
}// 
 
?>