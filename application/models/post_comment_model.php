<?php


 class Post_comment_model extends CI_Model{
	 
	 function __construct()
	{
		parent::__construct();
		$this->load->helper('date');
		$this->load->library('email');
		$this->load->library('session');
		
		
	}
	
	function save_comment_user_info($user_id = 0,$email = "",$name = "")
	{
		
		if ($user_id != 0)
		{
			$query = "SELECT 
					  c.customer_fname,
					  c.customer_lname,
					  c.customer_email
					  FROM ec_customers AS c
					  WHERE customer_id = '$user_id'
					  ";
			$r = $this->db->query($query);
			$row = $r->row_array();
			$email = $row['customer_email'];
			$name = $row['customer_fname']." ".$row['customer_lname'];
		}
		
		$query = "SELECT 
				email,id
				FROM posts_comments_users
				WHERE email = '$email'
				";
		$r = $this->db->query($query);
		$n = $r->num_rows();
		if( $n == 0)
		{ 
			$data = array(
						"email" => $email,
						"name" => $name
						);
			$this->db->insert("posts_comments_users",$data);
			$comment_user_id = $this->db->insert_id();
			return $comment_user_id;
		}
		else
		{
			$row = $r->row_array();
			$id = $row['id'];
			return $id;
		}
					
	}
	
	function insert_comment($user_id,$post_id,$message,$date,$status,$email = "",$name = "")
	{
		
		
		if ($user_id != 0 )
		{
			$comment_user_id = $this->save_comment_user_info($user_id);			 
		}
		else
		{
			$comment_user_id = $this->save_comment_user_info($user_id,$email,$name);
		}
		
		
		if( !$this->user_banned($email,$post_id) )
		{
			$data = array(
					
					"user_id" => $comment_user_id,
					"post_id" => $post_id,
					"message" => $message,
					"date_created" => $date,
					"status" => $status
					);
					
			$r = $this->db->insert("posts_comments",$data);
			if($r)
			{
				$this->email_to_site_admin($comment_user_id,$post_id,$message);
				return 1;
			}
			
		}
		else 
		{
			return 2;
		}
		return 0;
	}
	
	
	
	function user_banned($user_email,$post_id)
	{
		$this->db->where("user_email",$user_email);
		$this->db->where("post_id",$post_id);
		$r = $this->db->get("posts_comments_blacklist");
		$n = $r->num_rows();
		if($n > 0)
		{
			return true;
		}
		return false;
	}
	
	function get_approved_comment($post_id)
	{
		
		
		$query = "SELECT 
				  c.name,
				  c.email,
				  pc.id,
				  pc.user_id,
				  pc.post_id,
				  pc.message,
				  pc.date_created,
				  pc.status
				  FROM posts_comments AS pc
				  JOIN posts_comments_users AS c
				  ON c.id = pc.user_id
				  WHERE pc.post_id = '$post_id' AND pc.status = 'approve'
				  AND c.email NOT IN (SELECT user_email FROM posts_comments_blacklist)
				  ORDER BY id DESC					
				  ";
		$r = $this->db->query($query);
		$n = $r->num_rows();
		if($n > 0)
		{
			$r = $r->result_array();
			return $r;
		}
		return false;
	}
	
	function get_all_comment($post_id)
	{
		$query = "SELECT 
				  c.name,
				  c.email,
				  pc.id,
				  pc.user_id,
				  pc.post_id,
				  pc.message,
				  pc.date_created,
				  pc.status
				  FROM posts_comments AS pc
				  JOIN posts_comments_users AS c
				  ON c.id = pc.user_id
				  WHERE pc.post_id = '$post_id' 					
				  ORDER BY id DESC
				  ";
		$r = $this->db->query($query);
		$n = $r->num_rows();
		if($n > 0)
		{
			$r = $r->result_array();
			return $r;
		}
		return false;
	}
	
	
	 
	 function change_comment_status($comment_id,$status)
	 {
		   
		   $data = array(
		   			"status" => $status
		   );
		   // print_r($data);
		   $this->db->where('id', $comment_id);
		   $r = $this->db->update('posts_comments', $data); 
		   if($r)
		   {
			   return  true;
		   }
		   return false;
	 }
	 
	 function delete_comment($comment_id)
	 {
		$this->db->where('id', $comment_id);
		$r = $this->db->delete('posts_comments'); 
		if($r)
		{
			return true;
		}
		return false;
	 }
	 
	  function update_comment($comment_id,$message)
	  {
		   $data = array(
		   			"message" => $message
		   );
		   
		   $this->db->where('id', $comment_id);
		   $r = $this->db->update('posts_comments', $data); 

		   if($r)
		   {
			   return  true;
		   }
		   return false;
		   
	  }
	  
	  function get_comment_by_id($comment_id)
	   {
			
			$query = "SELECT 
				  c.name,
				  c.email,
				  pc.id,
				  pc.user_id,
				  pc.post_id,
				  pc.message,
				  pc.date_created,
				  pc.status
				  
				  FROM posts_comments AS pc
				  JOIN posts_comments_users AS c
				  ON c.id = pc.user_id
				  WHERE pc.id = '$comment_id' 					
				  ";
			$r = $this->db->query($query);
			$n = $r->num_rows();
			if($n == 1)
			{
				$r = $r->row_array();
				return $r;
			}
			return false;	   
		   
	   }
	   
	   /*		REPLY FUNCTIONs		*/
	   function insert_reply($comment_id,$user_id,$post_id,$message,$date,$status,$email = "",$name = "")
	   {
		
		
		if ($user_id != 0 )
		{
			$comment_user_id = $this->save_comment_user_info($user_id);			 
		}
		else
		{
			$comment_user_id = $this->save_comment_user_info($user_id,$email,$name);
		}
		
		
		if( !$this->user_banned($email,$post_id) )
		{
			$data = array(
					"comment_id" => $comment_id,
					"user_id" => $comment_user_id,
					"post_id" => $post_id,
					"message" => $message,
					"date_created" => $date,
					"status" => $status
					);
					
			$r = $this->db->insert("posts_comments_reply",$data);
			if($r)
			{
				$this->email_to_site_admin($comment_user_id,$post_id,$message);
				return 1;
			}
			
		}
		else 
		{
			return 2;
		}
		return 0;
	}
	   function get_reply_of_comment($comment_id)
	   {
		   
		   $query = "SELECT 
				  c.name,
				  c.email,
				  pc.id,
				  pc.user_id,
				  pc.post_id,
				  pc.comment_id,
				  pc.message,
				  pc.date_created,
				  pc.status
				  FROM posts_comments_reply AS pc
				  JOIN posts_comments_users AS c
				  ON c.id = pc.user_id
				  WHERE pc.comment_id = '$comment_id' 
				  ORDER BY id DESC					
				  ";
			$r = $this->db->query($query);
			
			$n = $r->num_rows();
			if($n > 0)
			{
				$r = $r->result_array();
				return $r;
			}
			return false;	
	   }
	   
	   function get_approved_reply_of_comment($comment_id)
	   {
		   
		   $query = "SELECT 
				  c.name,
				  c.email,
				  pc.id,
				  pc.comment_id,
				  pc.user_id,
				  pc.post_id,
				  pc.message,
				  pc.date_created,
				  pc.status

				  FROM posts_comments_reply AS pc
				  JOIN posts_comments_users AS c
				  ON c.id = pc.user_id
				  WHERE pc.comment_id = '$comment_id'  AND pc.status = 'approve'
				  AND c.email NOT IN (SELECT user_email FROM posts_comments_blacklist)
				  ORDER BY id DESC
				  ";
			$r = $this->db->query($query);
			
			$n = $r->num_rows();
			if($n > 0)
			{
				$r = $r->result_array();
				return $r;
			}
			return false;	
	   }
	   
	   function change_reply_status($reply_id,$status)
	   {
		   
		   $data = array(
		   			"status" => $status
		   );
		   // print_r($data);
		   $this->db->where('id', $reply_id);
		   $r = $this->db->update('posts_comments_reply', $data); 
		   if($r)
		   {
			   return  true;
		   }
		   return false;
	 }
	 
	   function delete_reply($reply_id)
	   {
		$this->db->where('id', $reply_id);
		$r = $this->db->delete('posts_comments_reply'); 
		if($r)
		{
			return true;
		}
		return false;
	 }
	   
	   function ban_user($post_id,$user_email)
	   {
		   $data = array(
		   			"post_id" => $post_id,
					"user_email" => $user_email
					);
			$r = $this->db->insert("posts_comments_blacklist",$data);
			if($r)
			{
				return true;
			}
			return false;
					
	   }
	   
	   function unban_user($post_id,$user_email)
	   {
		  
			$this->db->where('post_id', $post_id);
			$this->db->where('user_email', $user_email);
			$r = $this->db->delete('posts_comments_blacklist'); 
			if($r)
			{
				return true;
			}
			return false;
					
	   }


		function get_comment_user_info($user_id)
		{
			$this->db->where('id',$user_id);
			$r = $this->db->get("posts_comments_users");
			if($r->num_rows() == 1)
			{
				$row = $r->row_array();
				return $row;
			}
			return false;
		}



		function email_to_site_admin($comment_user_id,$post_id,$message)
		{
			$this->load->library('email');
			
			// posts_comments_users
			
			$site_id = $this->get_post_site_id($post_id);
			$user_id = $this->get_user_id_by_site_id($site_id);
			$user_email = $this->get_user_email_by_id($user_id);
			
			$user = $this->get_comment_by_user_info($comment_user_id);
			$email = $user['name'];
			$name = $user['email'];
			$post_title = $this->get_post_by_id($post_id);
			$post_title = $post_title['title'];
			
			
			$config['protocol'] = 'sendmail';
			$config['mailpath'] = '/usr/sbin/sendmail';
			$config['charset'] = 'iso-8859-1';
			$config['wordwrap'] = TRUE;
			$config['mailtype'] = "html";
			
			$this->email->initialize($config);
			
			$this->email->from('support@webpowerup.com','support@webpowerup.com');
			$this->email->to($user_email);
			$this->email->subject('Webpowerup Post Comment');
			
			$post_title = substr($post_title,0,50);
			$post_title .= ( strlen($post_title) > 50 ) ? "..." : "" ;
			
			$email_msg ="<html><body>";
			$email_msg .="<img src=\" ".base_url()."css/gws_new/images/logo.png \" ";
			$email_msg .="<br>";
			$email_msg .="<br>";
			$email_msg .= "<h3>Comment On:</h3>";
			$email_msg .="Post: ".$post_title;
			$email_msg .= "<h3>Comment By:</h3>";
			$email_msg .="Name: ".$name;
			$email_msg .="<br>";
			$email_msg .="Email: ".$email;
			$email_msg .="<br>";
			$email_msg .= "<h3>Comment Description:</h3>";			
			$email_msg .= $message;
			$email_msg .="<br>";
			$email_msg .="<br>";
			$email_msg .="</body></html>";
			
			
			$this->email->message($email_msg);    
			$this->email->send();
					
		}
		
		function get_post_site_id($post_id)
		{
			
			$q = " SELECT site_id FROM blogs AS b WHERE b.id = ( SELECT blog_id FROM blogs_posts AS p WHERE p.id = '$post_id' ) ";
			$r = $this->db->query($q);
			if($r->num_rows() == 1)
			{
				$row = $r->row_array();
				$site_id = $row['site_id'];  
				return $site_id;  
			}
			return false;		
		}
		
		function get_post_by_id($post_id)
		{
			$this->db->select("title");
			$this->db->where("id",$post_id);
			$r = $this->db->get("blogs_posts");
			if($r->num_rows() == 1 )
			{
				$row = $r->row_array();
				return $row;
			}
			return false;	   
		   
		}
		
		function get_user_id_by_site_id($site_id)
		{
			//$qry = 'SELECT user_id, FROM sites WHERE site_id ='.$this->db->escape($site_id);
			
			$this->db->where('site_id', $site_id); 
			$rslt = $this->db->get("sites");
			if($rslt->num_rows()>0)
			{
				$row = $rslt->row_array();
				$user_id = $row['user_id']; 
				return $user_id;   
			}
			return false;	
		}
		
		function get_user_email_by_id($user_id)
		{
			
			$q = "SELECT user_email FROM users WHERE user_id = '$user_id' ";
			$r = $this->db->query($q);
			if($r->num_rows()>0)
			{
				$row = $r->row_array();
				$user_email = $row['user_email']; 
				return $user_email;  
			}
			return false;	
		}
		
		function get_comment_by_user_info($user_id)
		{
			$query = "SELECT 
					  *
					  FROM posts_comments_users 
					  WHERE id = '$user_id'
					  ";
			$r = $this->db->query($query);
			if($r->num_rows() > 0)
			{
				$row = $r->row_array();
				return $row;
			}
			return false;
		}

}

?>