<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 class categories_model extends CI_Model{
 
     var $site_id;
     var $site_name;
     var $cat_id;
     var $cat_name;
     
    function __construct()
    {
       // Call the Model constructor  
        parent::__construct();
        $this->site_id = '';
        $this->cat_id = '';
        $this->site_name = '';
        $this->cat_name = '';
    }
 
function getCategory($cat_id='',$site_id=''){
    $data = array();
  //  echo '>>>>>>>>>>>'; exit();
    $options = array('cat_id' =>intval($cat_id),'site_id' =>intval($site_id));
    $Q = $this->db->get_where('ec_category',$options,1);
   // $Q = $this->db->get('ec_category');
   // $Q = $this->db->where($options,1);
    if ($Q->num_rows() > 0){
      $data = $Q->row_array();
    }
 
    $Q->free_result();
    
    return $data;
    
    
 }
 
 function getAllCategories_shop($site_id=''){
    $data = array();
    
	/* commented for showing category on front by this line of code no category is showing*/
	//$options = array('delete =' =>'0' , 'site_id = ' =>$site_id , 'parentid !=' => '0');

	$options = array('delete =' =>'0' , 'site_id = ' =>$site_id, 'status = ' =>'Active');
	
	$Q = $this->db->get_where('ec_category',$options);
    // $Q = $this->db->get('ec_category'); 
     if ($Q->num_rows() > 0){
       foreach ($Q->result_array() as $row){
         $data[] = $row;
       }
    }
    $Q->free_result();
    return $data;
 }
 
  function getAllCategories($site_id=''){
    $data = array();
    $options = array('delete =' =>'0' , 'site_id = ' =>$site_id  );
    $Q = $this->db->get_where('ec_category',$options);
    // $Q = $this->db->get('ec_category'); 
     if ($Q->num_rows() > 0){
       foreach ($Q->result_array() as $row){
         $data[] = $row;
       }
    }
    $Q->free_result();	
    return $data;
 }
 
 
 function getSubCategories($catcat_id){
// this runs when $cat['parentid'] < 1 in controllers/welcom.php
// Which means 0 and they are main/top categories.
//e.g. 7 and 8 have parent cat_id 0
     $data = array();
     $this->db->select('cat_id,cat_name,shortdesc');
     $this->db->where('parentid', id_clean($catcat_id));
     // When $catcat_id is 7, which has 0 for parent cat_id, and looking for items where parentid is this 7 $catcat_id
     $this->db->where('status', 'active');
     $this->db->orderby('cat_name','asc');
     $Q = $this->db->get('ec_category'); // this will gives series of items such as 1 shoes, 2 shirts, 3 pants etc.
     if ($Q->num_rows() > 0){// if there are items then
       foreach ($Q->result_array() as $row){//each item as an array to $row
            $sql = "select thumbnail as src
                    from products
                    where category_cat_id=".id_clean($row['cat_id'])."
                    and status='active'
                    order by rand() limit 1";
 
            $Q2 = $this->db->query($sql);
        // then run a quary. select one thumbnail randumly from products where category_cat_id is $row['cat_id']
        // e.g shirts has 2 for $row['cat_id']
 
            if($Q2->num_rows() > 0){
                    $thumb = $Q2->row_array();
                $THUMB = $thumb['src']; // the result src which is result thumbnail is $THUMB
            }else{
                $THUMB = '';// otherwise none in $THUMB
            }
 
            $Q2->free_result();
            $data[] = array(
                'cat_id' => $row['cat_id'],
                'cat_name' => $row['cat_name'],
                'shortdesc' => $row['shortdesc'],
                'thumbnail' => $THUMB
            );
        }
    }
    $Q->free_result(); 
 
    return $data;
 
 }
 
 function getCategoriesNav(){
     $data = array();
     $this->db->select('cat_id,cat_name,parentid');
     $this->db->where('status', 'active');
     $this->db->orderby('parentid','asc');
     $this->db->orderby('cat_name','asc');
     $this->db->groupby('parentid,cat_id');
     $Q = $this->db->get('ec_category');
     if ($Q->num_rows() > 0){
       foreach ($Q->result() as $row){
    // see the output $navlist at http://127.0.0.1/codeigniter_shopping/test1/cat/7
            if ($row->parentid > 0){
                $data[0][$row->parentid]['children'][$row->cat_id] = $row->cat_name;
                // [0]=>array([7]=>array([children]=>array([4]=dresses)))
                // [0][8][children][5]=toys
            }else{
                $data[0][$row->cat_id]['cat_name'] = $row->cat_name;
                // e.g. [0]=>array([7]=>array([cat_name]=clothes))
                // e.g. [0][8][cat_name]=fun
            }
        }
    }
    $Q->free_result();
    return $data;
 }
 
 function getCatNav($parentid){
     $data = array();
     $this->db->where('status', 'active');
     $this->db->where('parentid', $parentid);
     $this->db->orderby('cat_name','asc');
     $Q = $this->db->get('ec_category');
     if ($Q->num_rows() > 0){
       foreach ($Q->result_array() as $row){
                $data[$row['cat_id']] = $row['cat_name'];
            }
        }
    $Q->free_result();
    return $data;
 }
 
 function getCategoriesDropDown($site_id=''){
     $data = array();
     $this->db->select('cat_id,cat_name');
     //$this->db->where('parentid !=',0);
	 $this->db->where('status =','Active');
     $this->db->where('site_id',$site_id);
     $this->db->where('delete ','0'); 
     $Q = $this->db->get('ec_category');
     if ($Q->num_rows() > 0){
       foreach ($Q->result_array() as $row){
         $data[$row['cat_id']] = $row['cat_name'];
       }
    }
    $Q->free_result();
    return $data;
 }
 
 function getTopCategories($site_id=''){
     $data[0] = 'root';
     $this->db->where('parentid',0);
     $this->db->where('status ','Active');
     $this->db->where('site_id ',$site_id);
     $this->db->where('delete ','0');
     $Q = $this->db->get('ec_category');
     if ($Q->num_rows() > 0){
       foreach ($Q->result_array() as $row){
         $data[$row['cat_id']] = $row['cat_name'];
       }
    }
    $Q->free_result();
    return $data;
 } 
 
  function getSiteNameById($site_id){
        $data = array();
        $raw_name = '';
        $site_name = '';
        $this->db->select('site_name');
        $options = array('site_id' =>intval($site_id));
        $Q = $this->db->get_where('sites',$options,1);
        $data = $Q->result_array();
        if(isset($data[0]['site_name'])){
		$raw_name = $data[0]['site_name'];
		}
        $site_name = str_replace(' ','_',strtolower(trim($raw_name))); 
        return $site_name;
 }
   function addCategory ($site_id = ''){
       
		 	
			$this->site_id = $site_id;
        	$this->load->library('upload');
            $config = array();
            $config_resize = array(); 
            $data = array(); 
           // $base_path_server =  getcwd();
           // $base_path_server =  realpath(getcwd());
           // $mk_rd_dir = $base_path_server.'/media/ecommerce/full_img/';
           // $mk_rd_dir = $_SERVER['DOCUMENT_ROOT'].'/gws/media/ecommerce/thumb';
          //  mkdir($mk_rd_dir , 0777, true);
          //  echo  $mk_rd_dir;
           $site_name =  $this->getSiteNameById($this->site_id);
           $this->site_name = $site_name;
           $cat_name = str_replace(' ','_',strtolower(trim($this->input->post('cat_name')))); 
           $this->cat_name =  $cat_name;
          //echo $this->cat_name;exit;
		   $root_dir = $_SERVER['DOCUMENT_ROOT']; 
           //$ecommecre = $root_dir.'/media/ecommerce';
		   $ecommecre = $root_dir.'/media/ckeditor_uploads/'.$_SESSION['user_info']['user_login'].'_'.$_SESSION['user_info']['user_id'].'/ecommerce/';
		   
           $ecommecre_site =  $ecommecre.'/'.$this->site_id;
           $category_path =  $ecommecre_site.'/'.$this->cat_name;		   
          // $category_path =  $ecommecre.'/'.$cat_name;
 
         //  echo $category_path.'<br>';
          if(!is_dir($ecommecre))
           {
				if(!is_dir($ecommecre)) 
				{
					mkdir($ecommecre , 0777, true); 
					//  echo  'Here ='.$category_path.'<br>';   
				}
				else if(!is_dir($ecommecre_site)) 
				{
					mkdir($ecommecre_site , 0777, true); 
				}
				else if(!is_dir($category_path))
				{
					mkdir($category_path , 0777, true);  
				}   
           }
          if(!is_dir($ecommecre_site))
           {
               if(!is_dir($ecommecre_site)) 
                {
                  mkdir($ecommecre_site , 0777, true); 
                }
                else if(!is_dir($category_path))
                {
                    mkdir($category_path , 0777, true);   
                }
                
           }
          if(!is_dir($category_path))
           { 
             mkdir($category_path , 0777, true);  
           }
     if($this->input->post('image_rd') == 'Yes'){    
        // echo  $category_path; exit ();
            $img = str_replace(' ','_',$this->input->post('image_name'));
            $config['file_name'] = $img; 
            $config['upload_path'] = './media/ckeditor_uploads/'.$_SESSION['user_info']['user_login'].'_'.$_SESSION['user_info']['user_id'].'/ecommerce/'.$this->site_id.'/'.$this->cat_name;
          //  $config['upload_path'] = './media/uploads/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size']    = '100000';
           
            
            $files =  'cat_image';
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
                    //Image Resizing
                   // $retrive_img['file_name']
                   //$img_dir = $_SERVER['DOCUMENT_ROOT'];
                   //echo  $img_dir.'%%%%%%%%%%%%';   
                   // $config['source_image'] = $this->upload->upload_path.$return_valu['file_name'];
                  // echo $return_valu['full_path'].'>>>>>>>>>>>>'; exit();
                   
                    
                    $config_resize['source_image'] = $return_valu['full_path'];
                    $config_resize['new_image'] = './media/ckeditor_uploads/'.$_SESSION['user_info']['user_login'].'_'.$_SESSION['user_info']['user_id'].'/ecommerce/'.$this->site_id.'/'.$this->cat_name;
                   // $config_resize['new_image'] = './media/uploads/';
                   // $config_resize['maintain_ratio'] = false;
                    $config_resize['maintain_ratio'] = TRUE;
                    $config_resize['create_thumb'] = TRUE;
                  //  $config_resize['thumb_marker'] = true;
                    $config_resize['width'] = 100;
                    $config_resize['height'] = 75;
             
                    $this->load->library('image_lib', $config_resize);
                    $resize_img = $this->image_lib->resize();
                   
				   $file_name = str_replace(' ','_',$_FILES['cat_image']['name']);
				   $fix_array = explode(".",$file_name);
				   $img_name = $fix_array[0];
				   $img_ext = $fix_array[1];
				   $fix_array[0] = $fix_array[0]."_thumb";
				   $thumb_name = implode(".",$fix_array);
				  
                    //  $return_data = array('upload_data' => $this->upload->data());  
                         $data = array(
                            'cat_name' => $this->input->post('cat_name'),
                            'site_id' => $this->site_id,
                            'shortdesc' =>  $this->input->post('short_desc'),
                            'longdesc' => $this->input->post('long_desc'),
                            'image' =>  str_replace(' ','_',$_FILES['cat_image']['name']),
                            'thumb' =>  $thumb_name,
                            'status' =>  $this->input->post('status'),
							'is_default' =>  $this->input->post('is_default'),
                            'parentid' => intval($this->input->post('parentid')),
                            'member_id' => intval($this->input->post('members'))
                     
                        );
                   // return $retrive_img;
                }
                else
                {
                    $error = array('error' => $this->upload->display_errors());
                     //return $error;
                     return false;
                }
         }else
         {
             
              $data = array(
                            'cat_name' => $this->input->post('cat_name'),
                            'site_id' => $this->site_id,
                            'shortdesc' =>  $this->input->post('short_desc'),
                            'longdesc' => $this->input->post('long_desc'),
                            'status' =>  $this->input->post('status'),
                            'parentid' => intval($this->input->post('parentid')),
                            'member_id' => intval($this->input->post('members'))
                     
                        );
         }  
       /* echo "<pre>";
		print_r($data);
		exit;*/
        $this->db->insert('ec_category', $data); 
        return true;
     } 
   
    function updateCategory($cat_id='',$site_id='' ){
	/*echo "<pre>";
	print_r($_REQUEST['cat_name']);exit;*/
	
       $this->site_id = $site_id = $_SESSION['site_id'];
	   
      if($this->input->post('cat_name'))
      {
					//echo "<pre>"; print_r($_REQUEST['cat_image']); exit;
			$this->load->library('upload');
			$config = array();
			$config_resize = array(); 
			$data = array(); 
			
		     $cat_name = $this->input->post('cat_name'); 
			 $cat_name = str_replace(' ','_',strtolower(trim($this->input->post('cat_name')))); 
			$root_dir = $_SERVER['DOCUMENT_ROOT']; 
			 $ecommecre = $root_dir.'/media/ckeditor_uploads/'.$_SESSION['user_info']['user_login'].'_'.$_SESSION['user_info']['user_id'].'/ecommerce/';
			$ecommecre_site =  $ecommecre.'/'.$site_id;
			$category_path =  $ecommecre_site.'/'.$cat_name;
			// $category_path =  $ecommecre.'/'.$cat_name;
			if(! is_dir($ecommecre))
			{
				mkdir($ecommecre , 0777, true); 
				//echo  'Here ='.$category_path.'<br>';   
			}
			else if(! is_dir($ecommecre_site))
			{
				mkdir($ecommecre_site , 0777, true); 
				// echo  'Here ='.$category_path.'<br>';   
			}
			else if(! is_dir($category_path))
			{
				// echo  'Here ='.$category_path.'<br>';
				mkdir($category_path , 0777, true);   
			}
			$data = array(
						'cat_name' =>  $this->input->post('cat_name'),
						'shortdesc' =>  $this->input->post('short_desc'),
						'longdesc' =>  $this->input->post('long_desc'),
						'status' =>  $this->input->post('status'),
						'is_default' =>  $this->input->post('is_default'),
						'parentid' =>  intval($this->input->post('parentid')),
						'member_id' => intval($this->input->post('members'))
		             );
		   $this->db->where('cat_id', intval($this->input->post('id')));
	       $this->db->where('site_id',$this->site_id);
	       $this->db->update('ec_category', $data);  

        //  echo  $category_path; exit ();
            $img = str_replace(' ','_',$_FILES['cat_image']['name']);
            $config['file_name'] = $img; 
            $config['upload_path'] = './media/ckeditor_uploads/'.$_SESSION['user_info']['user_login'].'_'.$_SESSION['user_info']['user_id'].'/ecommerce/'.$this->site_id.'/'.$cat_name;
          //  $config['upload_path'] = './media/uploads/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size']    = '10000';
           
            
            $files =  'cat_image';
            $this->upload->initialize($config); 
            $retrive_img = $this->upload->do_upload($files);
            if($retrive_img)
            {
               //$error = array('error_img' => $this->upload->data()); 
               $return_valu =  $this->upload->data(); 
                //Image Resizing
               // $retrive_img['file_name']
               //$img_dir = $_SERVER['DOCUMENT_ROOT'];
               //echo  $img_dir.'%%%%%%%%%%%%';   
               // $config['source_image'] = $this->upload->upload_path.$return_valu['file_name'];
              // echo $return_valu['full_path'].'>>>>>>>>>>>>'; exit();
               
                
                $config_resize['source_image'] = $return_valu['full_path'];               
				$config_resize['new_image'] = './media/ckeditor_uploads/'.$_SESSION['user_info']['user_login'].'_'.$_SESSION['user_info']['user_id'].'/ecommerce/'.$this->site_id.'/'.$cat_name;
               // $config_resize['new_image'] = './media/uploads/';
               // $config_resize['maintain_ratio'] = false;
                $config_resize['maintain_ratio'] = TRUE;
                $config_resize['create_thumb'] = TRUE;
              //  $config_resize['thumb_marker'] = true;
                $config_resize['width'] = 100;
                $config_resize['height'] = 75;
         
                $this->load->library('image_lib', $config_resize);
                $resize_img = $this->image_lib->resize();
             	//echo str_replace(' ','_',$_FILES['cat_image']['name']);exit;
                //  $return_data = array('upload_data' => $this->upload->data());  
                     $data = array(
                        'cat_name' => $this->input->post('cat_name'),
                      //  'site_id' => $site_id,
                        'shortdesc' =>  $this->input->post('short_desc'),
                        'longdesc' => $this->input->post('long_desc'),
                        'image' =>  str_replace(' ','_',$_FILES['cat_image']['name']),
                        'thumb' =>  'thumb_'.str_replace(' ','_',$_FILES['cat_image']['name']),
                        'status' =>  $this->input->post('status'),
                        'parentid' => intval($this->input->post('parentid')),
                        'member_id' => intval($this->input->post('members'))
                 
                    );
                
  
               // return true;
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
						'cat_name' =>  $this->input->post('cat_name'),
						'shortdesc' =>  $this->input->post('short_desc'),
						'longdesc' =>  $this->input->post('long_desc'),
						'status' =>  $this->input->post('status'),
						'parentid' =>  intval($this->input->post('parentid')),
						'member_id' => intval($this->input->post('members'))
		             );   
          
     }
	 
	//print_r($_REQUEST);exit;
	$this->db->where('cat_id', intval($_REQUEST['id']));
	$this->db->update('ec_category', $data);
 }
      
function addsubMenu($cat_id)
 {
    $data = array(
        'cat_name' => db_clean($_POST['cat_name']),
        'shortdesc' =>  db_clean($_POST['short_desc']),
        'longdesc' =>  db_clean($_POST['long_desc'],5000),
        'status' =>  db_clean($_POST['status'],8),
        'parentid' => id_clean($_POST['parentid'])
    );
    $this->db->insert('ec_category', $data);
 }
 
function deleteCategory($cat_id)
{
			// $data = array('status' => 'inactive');
			$this->db->where('cat_id', intval($cat_id));
			$this->db->delete('ec_category');
}

function deleteCategory_soft($cat_id)
{
	$data = array('delete' => '1');
	$this->db->where('cat_id', intval($cat_id));
	$this->db->update('ec_category', $data);
 }
 function exportCsv($site_id)
 {
    $this->load->dbutil();
    $Q = $this->db->query("select * from ec_category where site_id =".$site_id);
    return $this->dbutil->csv_from_result($Q,",","\n");
 }
 function checkOrphans($cat_id){
    $data = array();
    $this->db->select('cat_id,cat_name');
    $this->db->where('category_cat_id',id_clean($cat_id));
    $Q = $this->db->get('omc_product');
    if ($Q->num_rows() > 0){
       foreach ($Q->result_array() as $row){
         $data[$row['cat_id']] = $row['cat_name'];
       }
    }
    $Q->free_result();
    return $data;  
 }

 function changeCatStatus($cat_id='',$site_id=''){
    // getting status of page
    $catinfo = array();
    $catinfo = $this->getCategory($cat_id,$site_id);
    $status = $catinfo['status'];
    if($status =='Active'){
        $data = array('status' => 'Inactive');
        $this->db->where('cat_id', intval($cat_id));
        $this->db->update('ec_category', $data);
    }else{
        $data = array('status' => 'Active');
        $this->db->where('cat_id', intval($cat_id));
        $this->db->update('ec_category', $data);
    }
 }
 
 function getCategoryNamebyProduct($category_cat_id){
  $this->db->select("cat_id,cat_name");
  $this->db->where('cat_id', $category_cat_id);
  $this->db->where('status', 'active');
  $sql = $this->db->get('ec_category');

if($sql->num_rows() > 0){
       foreach ($sql->result_array() as $row){
         $data[$row['cat_id']] = $row['cat_name'];
       }
    }
	
    $sql->free_result();
    print_r($data);  exit();
    return $data;  
 }
 
 function getCategoryNamebyProductID($id=0,$site_id=0){
  $this->db->select("category_id");
  $this->db->where('product_id', $id);
  $sql = $this->db->get('ec_products');
  $rows =  $sql->result_array();
  //return $rows[0]['category_id'];
   return $this->getCategory(intval($rows[0]['category_id']),intval($site_id));
 // print_r($rows[0]['category_id']);  exit();
  /*
if ($sql->num_rows() > 0){
       foreach ($sql->result_array() as $row){
         $data[$row['cat_id']] = $row['cat_name'];
       }
    }
    $sql->free_result();
    print_r($data);  exit();
    return $data;  */ 
 }  
 
}
 
?>