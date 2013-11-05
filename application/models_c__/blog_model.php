<?php

	
	
  class Blog_model extends CI_Model{
       
	   var $id;
	   var $site_id;
	   var $title;
	   var $description;
	  
	   
       function __construct()
	   {
		  parent::__construct();
          $this->load->helper('date');
		  $this->load->library('email');
		  $this->load->library('session');
		  
		  if( isset($_SESSION['site_id']) )
		  $this->site_id = $_SESSION['site_id'];
       }
	   
	   
	   function insert_blog($site_id,$user_id,$title,$description,$date_create)
	   {
		   $status = "Published";
		   $blog_page_id = $this->create_blog_page();
		   if($blog_page_id != 0)
		   {
		   		$data = array(
		   			"site_id" =>  $site_id,
					"page_id" =>  $blog_page_id,
					"user_id" =>  $user_id,
					"title" => $title,
					"description" => $description,
					"date_created" => $date_create,
					"date_modified" => $date_create,
					"blog_status" => $status
			   );
			   // print_r($data);
			   $r = $this->db->insert('blogs', $data); 
			   $blog_id = $this->db->insert_id();
			   if($r == 1)
			   {
				   return  $blog_id;
			   }
			  
		   }
		   return false;
	   }
	   
	   function create_blog_page()
	   {
		    $page_title = "Blog";
		    $site_id = $this->site_id;
		    $page_show_title = "No";
			$page_seo_url = "";
			$page_code = $site_id.":".$page_title;
			$page_ishomepage = "No";     
			$page_create_date = date('Y-m-d h:i:s');
			$page_modified_date = date('Y-m-d h:i:s'); 
			$page_access = "Other";
			$page_status = "Published";
			$page_header = "Default";
			$private_page = "";
			$private = "";
			$users_string = "";
			$header_background = 'Default';		
			$page_keywords = "";
			$page_desc = "";
			$page_background = "Default";
			$page_start_date = "";
			$page_end_date = "";
			$page_type = "blog";
			//$menu_id = $this->input->post("menu_id");
			
			$this->db->query("INSERT INTO pages
			(site_id, 
			page_title,
			page_show_title, 
			page_default, 
			page_seo_url, 
			page_code,
			page_type, 
			page_ishomepage, 
			page_header, 
			header_background, 
			page_keywords, 
			page_desc, 
			page_background, 
			page_start_date, 
			page_end_date, 
			page_create_date, 
			page_modified_date, 
			page_access, 
			page_status,
			page_privacy
			) 
			
			VALUES(
			".$this->db->escape($site_id).",
			".$this->db->escape($page_title).", 
			".$this->db->escape($page_show_title).", 
			'Not Default',  
			".$this->db->escape($page_seo_url).", 
			".$this->db->escape($page_code).", 
			".$this->db->escape($page_type).",
			".$this->db->escape($page_ishomepage).",
			".$this->db->escape($page_header).", 
			".$this->db->escape($header_background).", 
			".$this->db->escape($page_keywords).",
			".$this->db->escape($page_desc).", 
			".$this->db->escape($page_background).", 
			".$this->db->escape($page_start_date).",
			".$this->db->escape($page_end_date).", 
			".$this->db->escape($page_create_date).", 
			".$this->db->escape($page_modified_date).",
			".$this->db->escape($page_access).", 
			".$this->db->escape($page_status).", 
			".$this->db->escape($private)." 
			)");
		
			$blog_page_id = $this->db->insert_id();
			
			/*	get main menu id */ 
			
			$query = "SELECT menu_id,is_main_menu,site_id 
					  FROM menus 
					  WHERE is_main_menu = 'Yes' AND site_id = '$site_id' ";
					  
			$r = $this->db->query($query);
			$row = $r->row_array();
			$menu_id = $row['menu_id'];
			
			/*	get menu item information 	*/
			$query = "SELECT *
					FROM menuitems
					JOIN menus_menuitems_xref ON menus_menuitems_xref.item_id = menuitems.item_id
					WHERE menuitems.menu_id = '$menu_id'
					HAVING max( menuitems.display_order )
					";
					  
			$r = $this->db->query($query);
			$row = $r->row_array();
			if(isset($row['display_order']))
			{
				$display_order = $row['display_order'];
			}
			else
			{
				$display_order = 0;
			}
			
			
			// initializing blog menuitem variable
			$display_order++;
			$item_name = "Blog";
			$item_published = "Yes";
			$item_status = "Active";
			$item_parent = 0;
			$item_link = "";
			$access_level = "Everyone";
			$item_target = "_self";
			//"menu_id" => $menu_id,
			$data = array(	
					
					"item_name" => $item_name,
					"item_published" => $item_published,
					"item_status" => $item_status,
					"item_parent" => $item_parent,
					"item_link" => $item_link,
					"access_level" => $access_level,
					"item_target" => $item_target,
					"display_order" => $display_order
					);
			$this->db->insert("menuitems",$data);
			$item_id = $this->db->insert_id();
			
			unset($data);
			
			$data = array(
					"menu_id" => $menu_id,
					"item_id" => $item_id
					);
			$this->db->insert("menus_menuitems_xref",$data);
			
			unset($data);
			
			$data = array(
					"page_id" => $blog_page_id,
					"item_id" => $item_id
					);
			$this->db->insert("menuitems_pages_xref",$data);
			
			return $blog_page_id;
	   }
	   
	   function update_blog($blog_id,$title,$description,$date_modify)
	   {
		   $data = array(
		   			"title" => $title,
					"description" => $description,
					"date_modified" => $date_modify
		   );
		   // print_r($data);
		   $this->db->where('id', $blog_id);
		   $r = $this->db->update('blogs', $data); 

		   if($r)
		   {
			   return  true;
		   }
		   return false;
		   
	   }
	   
	   function change_status($blog_id,$status)
	   {
		   // echo $status; die();
		   
		   if($status == "Publish")
		   {
			   $change_stat = "Published";
		   }
		   else if ($status == "Unpublish")
		   {
			   $change_stat = "Not-Published";
		   }
		   
		   $data = array(
		   			"blog_status" => $change_stat
		   );
		   // print_r($data);
		   $this->db->where('id', $blog_id);
		   $r = $this->db->update('blogs', $data); 

		   if($r)
		   {
			   return  true;
		   }
		   return false;
		   
	   }
	   
	   function check_site_blog_exist()
	   {
		   $row = array();
		   $this->db->where('site_id', $this->site_id);
		   $r = $this->db->get("blogs");
		   // echo $r->num_rows();
		   if($r->num_rows() == 1 )
			{
				$row = $r->row_array();
			}
			return $row;
	   }
	   
	   function get_blog_by_id($blog_id)
	   {
			
			$this->db->where("id",$blog_id);
			$r = $this->db->get("blogs");
			if($r->num_rows() == 1 )
			{
				$row = $r->row_array();
				return $row;
			}
			return false;	   
		   
	   }
	   
	   function get_blog_info_by_id($blog_id)
	   {
			// user_fname 	user_lname 	
			$query = "SELECT
					b.id,
					b.site_id,
					b.page_id,	
					b.user_id,
					b.title,	
					b.description, 	
					b.date_created, 	
					b.date_modified, 	
					b.blog_status,
					u.user_fname, 	
					u.user_lname
					
					FROM blogs AS b
					JOIN users AS u 
					ON u.user_id = b.user_id 
					WHERE id = '$blog_id' "; 
			$r = $this->db->query($query);
			if($r->num_rows() == 1 )
			{
				$row = $r->row_array();
				return $row;
			}
			return false;	   
		   
	   }
	   function get_blog_status($blog_id)
	   {
			$this->db->select('blog_status, id');
			$this->db->where("id",$blog_id);
			$r = $this->db->get("blogs");
			if($r->num_rows() == 1 )
			{
				$row = $r->row_array();
				return $row['blog_status'];
			}
			return false;	   
		   
	   }
	   
	   /*******		blog 		******/
	   
	   
	   
	   /*******		post 		******/

	   
	   function update_post($post_id,$title,$description,$date_modify)
	   {
		   $data = array(
		   			"title" => $title,
					"description" => $description,
					"date_modified" => $date_modify
		   );
		   // print_r($data);
		   $this->db->where('id', $post_id);
		   $r = $this->db->update('blogs_posts', $data); 

		   if($r)
		   {
			   return  true;
		   }
		   return false;
		   
	   }
	   
	   function insert_post($blog_id,$title,$description,$date_create)
	   {
		   $data = array(
		   			"blog_id" =>  $blog_id,
					"title" => $title,
					"description" => $description,
					"date_created" => $date_create,
					"date_modified" => $date_create
		   );
		   // print_r($data);
		   $r = $this->db->insert('blogs_posts', $data);
		   if($r)
		   {
			   return true;
		   }
		   return false;
		   
	   }
	   
	   function get_all_blog_post($blog_id)
	   {
		    $posts = array();
			$this->db->order_by("id", "desc"); 
			$this->db->where("blog_id",$blog_id);
			$r = $this->db->get("blogs_posts");
			if($r->num_rows() > 0 )
			{
				$posts = $r->result_array();
				return $posts;
			}
			return $posts;	   
		   
	   }
	   
	   function get_all_publish_blog_post($blog_id)
	   {
		    $posts = array();
			$this->db->order_by("id", "desc"); 
			$this->db->where("status", "publish");
			$this->db->where("blog_id",$blog_id);
			$r = $this->db->get("blogs_posts");
			if($r->num_rows() > 0 )
			{
				$posts = $r->result_array();
				return $posts;
			}
			return $posts;	   
		   
	   }
	   
	   function get_all_publish_blog_post_by_year($blog_id,$year)
	   {
		    $posts = array();
			
			$query = "SELECT * FROM blogs_posts
					WHERE status = 'publish' 
					AND blog_id = '$blog_id'
					AND YEAR(date_created) = '$year' 
					ORDER BY id DESC ";
			$r = $this->db->query($query);
			if($r->num_rows() > 0 )
			{
				$posts = $r->result_array();
				return $posts;
			}
			return $posts;	   
		   
	   }
	   
	   function get_post_by_id($post_id)
	   {
			
			$this->db->where("id",$post_id);
			$r = $this->db->get("blogs_posts");
			if($r->num_rows() == 1 )
			{
				$row = $r->row_array();
				return $row;
			}
			return false;	   
		   
	   }
	   function get_post_details_by_id($post_id)
	   {
			
			$query = "SELECT 
					p.id,
					p.title,
					p.description,
					p.date_created,
					b.description AS blog_desc,
					b.title AS blog_title,
					u.user_email,
					u.user_fname,
					u.user_lname
					 
					FROM blogs_posts AS p
					JOIN blogs AS b
					ON p.blog_id = b.id
					JOIN users AS u
					ON b.user_id = u.user_id
					WHERE p.id = '$post_id'
					";
			$r = $this->db->query($query);
			if ($r->num_rows() == 1)
			{
				$row = $r->row_array();
				return $row;
			}
			return false;	   
		   
	   }
	   
	   function delete_post($post_id)
	   {
			$this->db->where('id', $post_id);
			$r = $this->db->delete('blogs_posts'); 
			if($r)
			{
				return true;
			}
			return false;
	   }
	   
	   function blog_timeLine($blog_id)
	   {
		   $query = "SELECT DATE_FORMAT(date_created, '%Y') as year FROM blogs_posts 
					  WHERE blog_id = '$blog_id'
					  GROUP BY YEAR(date_created)
					  ORDER BY date_created DESC ";
			
			$r = $this->db->query($query);
			if ($r->num_rows() > 0)
			{
				$row = $r->result_array();
				return $row;
			}
			return false;
	   }
	   
	   /*******		post 		******/
      

		
}
?>
