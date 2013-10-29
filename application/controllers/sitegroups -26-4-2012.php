<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SiteGroups extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('Template');  
		
		//$this->load->view('signup');	
		$this->load->database();
		//$this->load->library('pagination');
		$this->load->Model('UsersModel');
		
		//$this->load->Model('RolesModel'); 
		//$this->load->Model('PackageModel'); 
		$this->load->Model('Groups_Model'); 
		$this->load->Model('Menus_Model');  
		$this->load->library('session'); 
		$this->load->library('Paypal_Lib');
		$this->output->cache(0);  // caches 
		$this->template->set_template('gws');  
		
		//$this->template->render($region = NULL, $buffer = FALSE, $parse = FALSE)  ;    
	}
	//checks that user has logged-in Or not
	private function checkLogin()
	{
		//checks if session user_info is set
		if(!isset($_SESSION['user_info']['user_id']) && $_SESSION['user_info']['user_id'] == NULL)
		{
			//go to login controller
			redirect("UsersController/login/sitelogin");
		}
		else
		{
			//ok, let go
			return;
		}
	}
	//end

	function index()
	{
	
	
		$link = substr(uri_string(),1);
		$group_link = base_url().$link;
		$this->session->set_userdata("group_link", $group_link); 
		
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Groups'); 
	   
		$this->checkLogin();
		
		
		
		$site_id = $_SESSION["site_id"];
		
		$userData = $this->UsersModel->get_user_by_id(); 
		$data['userData'] = $userData;
		
		$groups = $this->Groups_Model->get_all_site_gropus($site_id);
		
		//Going to fetch members count
	
		if(count($groups) > 0  )
		{
			$gp_count = 0;
			foreach($groups as $record)
			{
				//get_group_members_count('group_id')
				$groups_customer_count = $this->Groups_Model->get_group_members_count($record["id"]);
				$groups[$gp_count]["member_count"] = $groups_customer_count;
				$gp_count++;
			}
		}		
		
		if(isset($groups_customer_count))
		{
			$data['groups_customer_count'] = $groups_customer_count;
		}
		
		$data['groups_array'] = $groups;
		$this->template->write_view('content','site_groups/home',$data);
		// Render the template
		$this->template->render();

	}
	
	/*
	 This function will be used in new site/vistor sign-up group creation.
	
	*/
	function new_site_group()
	{
		
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Group', $this->session->userdata("group_link") ); 
		$this->breadcrumb->add_crumb('Create' );
		$this->checkLogin();
		
		$userData = $this->UsersModel->get_user_by_id(); 
		$data['userData'] = $userData;
		
		$permsions = $this->Groups_Model->get_all_sitegroup_permission();
		$data['permissions_array'] = $permsions;
		
		/* Get all pages 3-27-2012  */
		$data['pages'] = $this->Menus_Model->getPages($_SESSION["site_id"]);  	
		$data['allpages'] = $data['pages']->result_array();	
		/* Get all pages 3-27-2012  */
				
		$menus = $this->Menus_Model->get_all_site_menus($_SESSION["site_id"]);
		$data['menus_array'] = $menus;
		
		$query_upgradables = $this->Groups_Model->get_group_upgradable_options($_SESSION["site_id"]);
		$data['query_upgradables'] = $query_upgradables;
		
		$this->template->write_view('content','site_groups/site_new_group',$data);
		// Render the template
		$this->template->render();	
	}
	
	// Call to Model to perform CRUD operations for creation of new group.
	function do_creat_site_group($first_group=0)
	{
		$site_id = $_SESSION["site_id"];
		$created = $this->Groups_Model->insert_site_group($site_id);
		
		if($created)
		{
			if(isset($first_group) && !empty($first_group))
			{
				if($first_group=='m')
				{
					 redirect("menusController/createMenu/".$_SESSION["site_id"]);
				}
				else
				{
					redirect("pagesController/page_menu/".$_SESSION["site_id"]."/".$first_group);
				}
			}
			redirect("sitegroups/index");
		}
		else
		{
			echo "got error";
		}
	
	}
	
	// view - landing page for Admin Site Groups
	function creat_admin_group()
	{
		$this->checkLogin();
		
		$userData = $this->UsersModel->get_user_by_id(); 
		$data['userData'] = $userData;
		
		//$permsions = $this->Groups_Model->get_all_sitegroup_permission();
		//$data['permissions_array'] = $permsions;
				
		$menus = $this->Menus_Model->get_all_site_menus($_SESSION["site_id"]);
		$data['menus_array'] = $menus;
		
		$this->template->write_view('content','site_groups/admin_new_group',$data);
		// Render the template
		$this->template->render();		
	}
	
	function status_group($group_id)
	{
		if(isset($group_id))
		{
			$status['action_text'] = $this->Groups_Model->status_group($group_id);
		}	
		redirect("/sitegroups/index");
	}
	
	function edit_group($group_id)
	{
		
	  	$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Group', $this->session->userdata("group_link") ); 
		$this->breadcrumb->add_crumb('Edit' );
		
		$this->checkLogin();
		if(isset($group_id))
		{
			$data['group_id'] = $group_id;
			$data['data'] = $this->Groups_Model->get_edit_group($group_id);	
			$permsions = $this->Groups_Model->get_all_sitegroup_permission();
			$data['permissions_array'] = $permsions;
			
			/* Get all page 3-27-2012*/
			$data['pages'] = $this->Menus_Model->getPages($_SESSION["site_id"]);  	
			$data['allpages'] = $data['pages']->result_array();	
			/* Get all page 3-27-2012*/
			
			
			$query_upgradables = $this->Groups_Model->get_group_upgradable_options_of_group($group_id,$_SESSION["site_id"]);
			$allUpgradableGroup = $query_upgradables->result_array();
			
			foreach($allUpgradableGroup as $group)
			{
				//$key['id']; die();
				if ($this->Groups_Model->if_group_is_upgradable_option_of_another_group($group_id,$group['id']) )
				{
					$group["selected"] = "selected";
					//echo "<pre>";	print_r($group);	die();	
				}
				$newUpgradableOption[] = $group;
			}
			
			//echo "<pre>";	print_r($newUpgradableOption);	die();	
			$data['query_upgradables'] = $newUpgradableOption;
			//echo "<pre>";	print_r($data);	die();
			
			$menus = $this->Menus_Model->get_all_site_menus($_SESSION["site_id"]);
			$data['menus_array'] = $menus;
			$this->template->write_view('content','site_groups/site_update_group',$data);
			// Render the template
			$this->template->render();	
		}
	}
	
	function do_update_site_group()
	{
		
		/*echo "<pre>";
		print_r($_REQUEST);
		exit;*/
		$site_id = $_SESSION["site_id"];
		if(isset($_REQUEST['group_id']))
		{
			$created = $this->Groups_Model->do_update_site_group($_REQUEST['group_id'], $site_id);		
			if($created)
			{
				redirect("sitegroups/index");
			}
			else
			{
				echo "got error";
			}
		}
	}
	
	function get_paypal_id_of_store_of_site($site_id)
	{
	 
		 $this->db->where("site_id",$site_id);
		 $r = $this->db->get('site_store_settings',1);
		 
		 if ($r->num_rows() == 1){
			 
			 $row = $r->result_array(); 
			 $paypal_id = $row['paypal_id'];
			 return $paypal_id;
			 
		 }
		 return "";
	
	}
	
	function group_fields()
	{
		$group_id = $_REQUEST['group_id'];
		$fields_data = $this->Groups_Model->get_group_fields($group_id);
		$check_group_paid = $this->Groups_Model->check_group_paid($group_id);
		//numan_1333967536_biz@virtism.com
		
		$this->load->model('Shop_model');
		$site_id = $_SESSION["site_id"];
		$payPal_id =  $this->Shop_model->get_paypal_id_of_store_of_site($site_id);
		
		$extraData = array();
		//echo "<pre>";
		//print_r($check_group_paid); exit;
		$fields_count = count($fields_data);
		$output = array();
		$data  = "<table>";
		for($i=0; $i<$fields_count; $i++)
		{
			if ($fields_data[$i]['field_type'] == 'Check Boxes'){
					
			 	$data  .= "<tr><td>".$fields_data[$i]['field_title']."</td><td><input type='checkbox' name='".$fields_data[$i]['field_name']."'/></td></tr>";
			 
			 }else if($fields_data[$i]['field_type'] == 'Radio Buttons'){
					
				$data  .= "<tr><td>".$fields_data[$i]['field_title']."</td><td><input type='radio' value='yes' name='".$fields_data[$i]['field_name']."' /> | <input type='radio' value='no' name='".$fields_data[$i]['field_name']."' /></td></tr>";	
				   
			 }else if($fields_data[$i]['field_type'] == 'Single-Line Text' ) {
					
				$data  .= "<tr><td>".$fields_data[$i]['field_title']."</td><td><input type='text' name='".$fields_data[$i]['field_name']."' /></td></tr>";   
				   
			 }else if ($fields_data[$i]['field_type'] == 'Multi-Line Text'){
					
				$data  .= "<tr><td>".$fields_data[$i]['field_title']."</td><td><textarea name='".$fields_data[$i]['field_name']."' ></textarea></td></tr>";	
			 }
		}		
		$data  .= "</table>";
		
		if(count($check_group_paid)>0 && $check_group_paid[0]['payment_method'] != 'Free')
		{?>
			<div class="section" id="paypal_row">
				<div>
					<form action="<?=$this->paypal_lib->paypal_url?>" method="post" >
						<input type="hidden" name="cmd" value="_xclick">
						<input type="hidden" name="business" value="<?php echo $payPal_id; ?>">
						<input type="hidden" name="currency_code" value="USD">
						<input type="hidden" name="rm" value="2">   
						<input type="hidden" name="return" value="<?=base_url().index_page()?>group_managment/payment/">
						<input type="hidden" name="cancel_return" value="<?=base_url().index_page()?>group_managment/new_group/">
						<input type="hidden" name="notify_url" value="<?=base_url().index_page()?>paypal/ipn">      
						<input type="hidden" name="item_name" value="Charged Amount for Plan <?=$check_group_paid[0]["group_name"]?>">
						<!--  <input type="hidden" name="item_number" value="786"> -->
						<input type="hidden" name="quantity" value="1">
						<input type="hidden" name="amount" value="<?php if(isset($check_group_paid[0]["price"])){ echo $check_group_paid[0]["price"];}else if(isset($check_group_paid[0]["fixed_price"])){ echo $check_group_paid[0]["fixed_price"]; }?>">
                        
						<input type="hidden" name="item_number" value="<?=$group_id?>">
                        
						
						<?php 	
						$extraData = array(
							"site_id",
							$site_id,
							"member_id",
							$_SESSION['login_info']['customer_id'],
							"discount_value",
							$check_group_paid[0]["discount_value"]
						);
						
						$custom = implode("-",$extraData);
																								
						?>
                        
                        
                        <input type="hidden" name="custom" value="<?php echo $custom; ?>" />
                        
                        
                        <!--
                        <input type="hidden" name="on0" value="usman">
						<input type="hidden" name="os0" value="999999"> 
                        -->
                        
						<input style="width:60px;" type="image" src="http://www.paypal.com/en_US/i/btn/x-click-but01.gif" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
					</form>	
					<input type="hidden" name="paid_group" id="paid_group" value="<?=$check_group_paid[0]["price"]?>">	
				</div>
		  </div>
		<? }
		/*echo "<pre>";
		print_r($fields_data);*/
		if($fields_count>0)
		{
			echo $data;
		}
		else
		{
			echo $data = '';
		}
	}
	
	function group_fields_register()
	{
		$group_id = $_REQUEST['group_id'];
		$fields_data = $this->Groups_Model->get_group_fields($group_id);
		$check_group_paid = $this->Groups_Model->check_group_paid($group_id);
		//numan_1333967536_biz@virtism.com
		
		$this->load->model('Shop_model');
		$site_id = $_SESSION["site_id"];
		$payPal_id =  $this->Shop_model->get_paypal_id_of_store_of_site($site_id);
		
		$extraData = array();
		//echo "<pre>";
		//print_r($check_group_paid); exit;
		$fields_count = count($fields_data);
		$output = array();
		$data  = "<table>";
		for($i=0; $i<$fields_count; $i++)
		{
			if ($fields_data[$i]['field_type'] == 'Check Boxes'){
					
			 	$data  .= "<tr><td>".$fields_data[$i]['field_title']."</td><td><input type='checkbox' name='".$fields_data[$i]['field_name']."'/></td></tr>";
			 
			 }else if($fields_data[$i]['field_type'] == 'Radio Buttons'){
					
				$data  .= "<tr><td>".$fields_data[$i]['field_title']."</td><td><input type='radio' value='yes' name='".$fields_data[$i]['field_name']."' /> | <input type='radio' value='no' name='".$fields_data[$i]['field_name']."' /></td></tr>";	
				   
			 }else if($fields_data[$i]['field_type'] == 'Single-Line Text' ) {
					
				$data  .= "<tr><td>".$fields_data[$i]['field_title']."</td><td><input type='text' name='".$fields_data[$i]['field_name']."' /></td></tr>";   
				   
			 }else if ($fields_data[$i]['field_type'] == 'Multi-Line Text'){
					
				$data  .= "<tr><td>".$fields_data[$i]['field_title']."</td><td><textarea name='".$fields_data[$i]['field_name']."' ></textarea></td></tr>";	
			 }
		}		
		$data  .= "</table>";
		
		if(count($check_group_paid)>0 && $check_group_paid[0]['payment_method'] != 'Free')
		{?>
			<div class="section" id="paypal_row">
				<div>
					<form action="<?=$this->paypal_lib->paypal_url?>" method="post" id="payPalRegForm" >
						<input type="hidden" name="cmd" value="_xclick">
						<input type="hidden" name="business" value="<?php echo $payPal_id; ?>">
						<input type="hidden" name="currency_code" value="USD">
						<input type="hidden" name="rm" value="2">   
						<input type="hidden" name="return" value="<?=base_url().index_page()?>MyAccount/register/<?php echo $site_id."/paid"; ?>" >
						<input type="hidden" name="cancel_return" value="<?=base_url().index_page()?>MyAccount/register/<?php echo $site_id."/cancled"; ?>">
						<input type="hidden" name="notify_url" value="<?=base_url().index_page()?>paypal/ipn">      
						<input type="hidden" name="item_name" value="Charged Amount for Plan <?=$check_group_paid[0]["group_name"]?>">
						<!--  <input type="hidden" name="item_number" value="786"> -->
						<input type="hidden" name="quantity" value="1">
						<input type="hidden" name="amount" value="<?php if(isset($check_group_paid[0]["price"])){ echo $check_group_paid[0]["price"];}else if(isset($check_group_paid[0]["fixed_price"])){ echo $check_group_paid[0]["fixed_price"]; }?>">
                        
						<input type="hidden" name="item_number" value="<?=$group_id?>">
                        
						
						<?php
						
						
						$member_id = 0;
						
						$extraData = array(
							"site_id",
							$site_id,
							"member_id",
							$member_id,
							"discount_value",
							$check_group_paid[0]["discount_value"]
						);
						
						$custom = implode("-",$extraData);
																								
						?>
                        
                        
                        <input type="hidden" name="custom" value="<?php echo $custom; ?>" />
                        
                        
                        <!--
                        <input type="hidden" name="on0" value="usman">
						<input type="hidden" name="os0" value="999999"> 
                        -->
                        
						<input style="width:60px;" type="image" src="http://www.paypal.com/en_US/i/btn/x-click-but01.gif" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
					</form>	
					<input type="hidden" name="paid_group" id="paid_group" value="<?=$check_group_paid[0]["price"]?>">	
				</div>
		  </div>
		<? }
		/*echo "<pre>";
		print_r($fields_data);*/
		if($fields_count>0)
		{
			echo $data;
		}
		else
		{
			echo $data = '';
		}
	}
	
	
	// function to show paypal button when customer upgrades the groups
	function paypal_bottom_update($current_group_id)
	{
		$group_id = $_REQUEST['group_id'];
		$fields_data = $this->Groups_Model->get_group_fields($group_id);
		$check_group_paid = $this->Groups_Model->check_group_paid($group_id);
		//numan_1333967536_biz@virtism.com
		
		$this->load->model('Shop_model');
		$site_id = $_SESSION["site_id"];
		$payPal_id =  $this->Shop_model->get_paypal_id_of_store_of_site($site_id);
		
		$extraData = array();
		//echo "<pre>";
		//print_r($check_group_paid); exit;
		$fields_count = count($fields_data);
		$output = array();
		$data  = "<table>";
		for($i=0; $i<$fields_count; $i++)
		{
			if ($fields_data[$i]['field_type'] == 'Check Boxes'){
					
			 	$data  .= "<tr><td>".$fields_data[$i]['field_title']."</td><td><input type='checkbox' name='".$fields_data[$i]['field_name']."'/></td></tr>";
			 
			 }else if($fields_data[$i]['field_type'] == 'Radio Buttons'){
					
				$data  .= "<tr><td>".$fields_data[$i]['field_title']."</td><td><input type='radio' value='yes' name='".$fields_data[$i]['field_name']."' /> | <input type='radio' value='no' name='".$fields_data[$i]['field_name']."' /></td></tr>";	
				   
			 }else if($fields_data[$i]['field_type'] == 'Single-Line Text' ) {
					
				$data  .= "<tr><td>".$fields_data[$i]['field_title']."</td><td><input type='text' name='".$fields_data[$i]['field_name']."' /></td></tr>";   
				   
			 }else if ($fields_data[$i]['field_type'] == 'Multi-Line Text'){
					
				$data  .= "<tr><td>".$fields_data[$i]['field_title']."</td><td><textarea name='".$fields_data[$i]['field_name']."' ></textarea></td></tr>";	
			 }
		}		
		$data  .= "</table>";
		
		if(count($check_group_paid)>0 && $check_group_paid[0]['payment_method'] != 'Free')
		{?>
			<div class="section" id="paypal_row">
				<div>
					<form action="<?=$this->paypal_lib->paypal_url?>" method="post" >
						<input type="hidden" name="cmd" value="_xclick">
						<input type="hidden" name="business" value="<?php echo $payPal_id; ?>">
						<input type="hidden" name="currency_code" value="USD">
						<input type="hidden" name="rm" value="2">   
						<input type="hidden" name="return" value="<?=base_url().index_page()?>group_managment/upgrade_group_payment/">
						<input type="hidden" name="cancel_return" value="<?=base_url().index_page()?>group_managment/edit_group/<?=$current_group_id?>">
						<input type="hidden" name="notify_url" value="<?=base_url().index_page()?>paypal/ipn">      
						<input type="hidden" name="item_name" value="Charged Amount for Plan <?=$check_group_paid[0]["group_name"]?>">
						<!--  <input type="hidden" name="item_number" value="786"> -->
						<input type="hidden" name="quantity" value="1">
                        
                        
                        <?php 
						// calculate upgrade amount 
						
						//print_r();
						$group = $this->Groups_Model->get_group_by_id($current_group_id);
						
						
						$current_group_price = $group[0]['fixed_price'];
						$upgradable_group_price = $check_group_paid[0]['fixed_price'];
						
						$diffrence = $current_group_price - $upgradable_group_price;
						if($diffrence < 0)
						{
							$newPrice = $upgradable_group_price - $current_group_price;
						}
						else if($diffrence > 0)
						{
							$newPrice = $upgradable_group_price;
						}
						else
						{
							$newPrice = $upgradable_group_price;
						}
						
						
						
						//$upgradable_group_id;
						
						?>
						<input type="hidden" name="amount" value="<?=$newPrice?>">
                        
						<input type="hidden" name="item_number" value="<?=$group_id?>">
                        
						
						<?php 	
						
						//echo "<pre>";	print_r($_SESSION);	
						
						$extraData = array(
							"site_id",
							$site_id,
							"member_id",
							$_SESSION['login_info']['customer_id'],
							"currentGroup_id",
							$current_group_id,
							"discount_value",
							$check_group_paid[0]["discount_value"]
						);
						
						$custom = implode("-",$extraData);
																								
						?>
                        
                        
                        <input type="hidden" name="custom" value="<?php echo $custom; ?>" />
                        
                        
                        <!--
                        <input type="hidden" name="on0" value="usman">
						<input type="hidden" name="os0" value="999999"> 
                        -->
                        
						<input style="width:60px;" type="image" src="http://www.paypal.com/en_US/i/btn/x-click-but01.gif" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
					</form>	
					<input type="hidden" name="paid_group" id="paid_group" value="<?=$check_group_paid[0]["price"]?>">	
				</div>
		  </div>
		<? }
		/*echo "<pre>";
		print_r($fields_data);*/
		if($fields_count>0)
		{
			echo $data;
		}
		else
		{
			echo $data = '';
		}
	}
	
}
?>