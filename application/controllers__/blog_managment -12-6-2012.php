<?php
session_start();


class Blog_managment extends CI_Controller {
	
	var $site_id = 0;
	var $user_id = 0;
	
	function __construct()
	{
		  parent::__construct();
          $this->load->helper('date');
		  $this->load->library('email');
		  $this->load->library('Template');
		  $this->template->set_template('gws');
		  $this->load->library('session');
		  $this->load->model("blog_model");
		  $this->load->model("post_comment_model");
		  
		  //  echo "<pre>";		print_r($_SESSION);		echo "</pre>";
		  if( isset($_SESSION['site_id']) )
		  $this->site_id = $_SESSION['site_id'];
		  
		  if( isset($_SESSION['user_info']) )
		  $this->user_id = $_SESSION['user_info']['user_id'];
		  
		  $this->checkLogin();
		  
	}
	function checkLogin()
	{
		//checks if session user_info is set
		if(!$_SESSION['user_info']['user_id'] && $_SESSION['user_info']['user_id'] == NULL)
		{
			//go to login controller
			redirect("UsersController/login/sitelogin");
		}
		else
		{
			//ok, let go
			return true;
		}
	}
		
	function create_blog()
	{
		$this->breadcrumb->clear();
       	$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Create Your Blog' );
			
		$site_id = $this->site_id;
		$data['site_id'] = $site_id;
		
		$this->template->write_view('content', 'blog/back/new_blog_form', $data);

		$this->template->render(); 
		
	}
	function add_blog()
	{
		
		$title = $this->input->post("title");
		$description = $this->input->post("description");
		$date = date("Y-m-d H:i:s");
		
		$blog_id = $this->blog_model->insert_blog($this->site_id,$this->user_id,$title,$description,$date);
		
		if($blog_id)
		{
			redirect("blog_managment/blog/".$blog_id);
		}
		else
		{
			$msg = "Blog not added Successfully";
			$this->session->set_flashdata('rspBlogAdd', $msg);
			
			redirect("blog_managment/create_blog/");
			
		}
		
		
	}
	
	function blog($blog_id)
	{
		
		$blogLink = current_url();
		$this->session->set_userdata("blog_link", $blogLink);
		
		$this->breadcrumb->clear();
       	$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Your Blog' );
		
		$blog = $this->blog_model->get_blog_by_id($blog_id);
		$data['blog'] = $blog;
		
		$posts = $this->blog_model->get_all_blog_post($blog_id);
		$data['posts'] = $posts;
		
		
		$this->template->write_view('content', 'blog/back/blog', $data);
		$this->template->render(); 
	}
	
	function change_status($blog_id,$status)
	{
		$r = $this->blog_model->change_status($blog_id,$status);
		
		if($r)
		{
			$msg = "Blog status have been changed to ".$status;
			
		}
		else
		{
			$msg = "Blog status have not been changed to ".$status;
		}
		
		$this->session->set_flashdata('rspBlog', $msg);
		
		redirect("blog_managment/blog/".$blog_id);
	}
	
	function edit_blog()
	{
		
		
		$blog_id = $this->input->post("blog_id");
		$title = $this->input->post("title");
		$description = $this->input->post("description");
		$date = date("Y-m-d H:i:s");
		
		$r = $this->blog_model->update_blog($blog_id,$title,$description,$date);
		
		if($r)
		{
			$msg = "Blog updated Successfully";
			
		}
		else
		{
			$msg = "Blog not updated Successfully";
		}
		
		$this->session->set_flashdata('rspBlog', $msg);
		
		redirect("blog_managment/blog/".$blog_id);
		
		
	}
	
	
	/**********		POST 		************/ 
	function create_post()
	{
		
		$this->breadcrumb->clear();
       	$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Blog', $this->session->userdata("blog_link") ); 
		$this->breadcrumb->add_crumb('Create Post' );
		
		$data['blog_id'] = $this->uri->segment(3);
		
		
		$this->template->write_view('content', 'blog/back/new_post_form', $data);
		$this->template->render(); 
	}
	
	function add_post()
	{
		
		$title = $this->input->post("title");
		$description = $this->input->post("description");
		$blog_id = $this->input->post("blog_id");
		$date = date("Y-m-d H:i:s");
		
		$r = $this->blog_model->insert_post($blog_id,$title,$description,$date);
		
		if($r)
		{
			$msg = "Post added successfully";
			$this->session->set_flashdata('rspBlog', $msg);
			redirect("blog_managment/blog/".$blog_id);
		}
		else
		{
			$msg = "Post added successfully";
			$this->session->set_flashdata('rspBlog', $msg);
			redirect("blog_managment/blog/".$blog_id);
		}
	}
	
	function post_detail($post_id)
	{
		
		$this->breadcrumb->clear();
       	$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Blog', $this->session->userdata("blog_link") ); 
		$this->breadcrumb->add_crumb('Post' );
		
			   
	    $post = $this->blog_model->get_post_by_id($post_id);
		
		if($post)
		{
			$data['post'] = $post;
			$this->template->write_view('content', 'blog/back/post_detail', $data);
		}
		else
		{
			$this->template->write_view('content', 'blog/back/post_detail');
		}
		$this->template->render();
		
	}
	
	function post_edit($post_id)
	{
		
		$this->breadcrumb->clear();
       	$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Blog', $this->session->userdata("blog_link") ); 
		$this->breadcrumb->add_crumb('Post Edit' );
		
			   
	    $post = $this->blog_model->get_post_by_id($post_id);
		
		if($post)
		{
			$data['post'] = $post;
			$this->template->write_view('content', 'blog/back/post_edit', $data);
		}
		else
		{
			$this->template->write_view('content', 'blog/back/post_edit');
		}
		$this->template->render();
	}
	
	function edit_post()
	{
		
		$post_id = $this->input->post("post_id");
		$blog_id = $this->input->post("blog_id");
		$title = $this->input->post("title");
		$description = $this->input->post("description");
		$date = date("Y-m-d H:i:s");
		
		$r = $this->blog_model->update_post($post_id,$title,$description,$date);
		
		if($r)
		{
			$msg = "Post updated Successfully";
			
		}
		else
		{
			$msg = "Post not updated Successfully";
		}		
		$this->session->set_flashdata('rspBlog', $msg);
		
		redirect("blog_managment/blog/".$blog_id);
	}
	
	function post_delete()
	{
		
		$blog_id = $this->uri->segment(3);
		$post_id = $this->uri->segment(4);
		
		$r = $this->blog_model->delete_post($post_id);
		
		if($r)
		{
			$msg = "Post deleted Successfully";
			
		}
		else
		{
			$msg = "Post not deleted Successfully";
		}		
		$this->session->set_flashdata('rspBlog', $msg);
		
		redirect("blog_managment/blog/".$blog_id);
		
	}
	
		
	/**********		POST END 		************/ 
	
	/**********		COMMENT  		************/ 
	
	function post_comment($post_id)
	{
		
		$this->breadcrumb->clear();
       	$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Blog', $this->session->userdata("blog_link") ); 
		$this->breadcrumb->add_crumb('Comments' );
		
		
		$post_id = $this->uri->segment(3);
		$data['post'] = $post_id;
		
		$comments = $this->post_comment_model->get_all_comment($post_id);
		
		$new_comments = array();
		foreach ( $comments as $comment )
		{
			
			if ( $this->post_comment_model->user_banned($comment['user_id'],$comment['post_id']) )
			{
				$comment["is_banned"] = 1; 
			}
			else
			{
				$comment["is_banned"] = 0; 
			}
			$new_comments[] = $comment;
			
		}
		// echo "<pre>"; print_r($new_comments); echo "</pre>"; 
		// echo "<pre>"; print_r($comments); echo "</pre>"; die();
		
		$data['comments'] = $new_comments;
		
		$this->template->write_view('content', 'blog/back/comments',$data);
		
		$this->template->render();
	}
	
	function comment_status($post_id,$comment_id,$status)
	{
		
		
		$r = $this->post_comment_model->change_comment_status($comment_id,$status);
		
		if($r)
		{
			$msg = "Comment status changed Successfully";
		}
		else
		{
			$msg = "Comment status not changed Successfully";
		}
				
		$this->session->set_flashdata('rspComment', $msg);
		
		redirect("blog_managment/post_comment/".$post_id);
		
	}
	
	function comment_delete($post_id,$comment_id)
	{
		
		
		$r = $this->post_comment_model->delete_comment($comment_id);
		
		if($r)
		{
			$msg = "Comment deleted Successfully";
		}
		else
		{
			$msg = "Comment not deleted Successfully";
		}
				
		$this->session->set_flashdata('rspComment', $msg);
		
		redirect("blog_managment/post_comment/".$post_id);
	}
	
	function comment_edit($comment_id)
	{
		
		$this->breadcrumb->clear();
       	$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Blog', $this->session->userdata("blog_link") ); 
		$this->breadcrumb->add_crumb('Comments' );
		
		
		
		$comment = $this->post_comment_model->get_comment_by_id($comment_id);
		$data['comment'] = $comment;
		
		$this->template->write_view('content', 'blog/back/comment_edit',$data);
		
		$this->template->render();
		
	}
	
	function edit_comment()
	{
		
		$message = $this->input->post("message");
		$comment_id = $this->input->post("comment_id");
		$post_id = $this->input->post("post_id");
		
		
		$r = $this->post_comment_model->update_comment($comment_id,$message);
		
		$this->template->write_view('content', 'blog/back/comment_edit',$data);
		
		if($r)
		{
			$msg = "Comment updated Successfully";
		}
		else
		{
			$msg = "Comment updated Successfully";
		}

		$this->session->set_flashdata('rspComment', $msg);
		
		redirect("blog_managment/post_comment/".$post_id);
		
	}
	
	function comment_detail($comment_id)
	{
		
		$this->breadcrumb->clear();
       	$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Blog', $this->session->userdata("blog_link") ); 
		$this->breadcrumb->add_crumb('Comment Detail' );
		
		
		
		$comment = $this->post_comment_model->get_comment_by_id($comment_id);
		$data['comment'] = $comment;
		
		$this->template->write_view('content', 'blog/back/comment_detail',$data);
		
		$this->template->render();
		
	}
	
	function ban_user($post_id,$user_id)
	{
		
		$r = $this->post_comment_model->ban_user($post_id,$user_id);
		if($r)
		{
			$msg = "User banned Successfully";
		}
		else
		{
			$msg = "User not banned Successfully";
		}

		$this->session->set_flashdata('rspComment', $msg);
		
		redirect("blog_managment/post_comment/".$post_id);
	}
	
	function unban_user($post_id,$user_id)
	{
		
		$r = $this->post_comment_model->unban_user($post_id,$user_id);
		if($r)
		{
			$msg = "User Unbanned Successfully";
		}
		else
		{
			$msg = "User not Unbanned Successfully";
		}

		$this->session->set_flashdata('rspComment', $msg);
		
		redirect("blog_managment/post_comment/".$post_id);
	}
	
	
}

?>