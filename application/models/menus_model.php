<?php
class Menus_Model extends CI_Model{
	//Constructor for this model
	function Menus_Model(){
		parent::__construct(); 
		$this->load->database();
		$this->load->Model('customers_model');
	}
	
	//returns all menus records belonging to site_id
	//used in pagesController(functions: create_page, )
	function getAllMenus($site_id){
		return $this->db->query("SELECT * FROM menus WHERE site_id=".$this->db->escape($site_id)." AND menu_status NOT IN('Deleted') ORDER BY menu_id ASC");
	}
	
	//updates menus record in DB
	function updateMenu()
	{	
		//echo "<pre>"; print_r($_POST);exit;
		$id = $this->input->post("id");
		$strName = $this->input->post("txtName");
		$strPosition = $this->input->post("rdoPosition");
		$strPublished = $this->input->post("rdoPublished");		
		$strPages = $this->input->post("rdoPages");
		$strRights = $this->input->post("rdoRights");
		$intNumItems = $this->input->post("numItems");
        $parent_primary_color = $this->input->post("prim_color"); 
        $parent_txt_xolor = $this->input->post("prim_txt");
		
		if($strPublished == "Schedule")
		{
			$dateStart = date('Y-m-d h:i:s', strtotime($this->input->post("startDate")));        
			$dateEnd = date('Y-m-d h:i:s', strtotime($this->input->post("endDate")));
		}else
		{
			$dateStart = "";        
			$dateEnd = "";
		}
		
		//Update Menu Attribute Info
		$this->db->query("UPDATE menus SET menu_name=".$this->db->escape($strName).", menu_position=".$this->db->escape($strPosition).", menu_published=".$this->db->escape($strPublished).", menu_start=".$this->db->escape($dateStart).", menu_end=".$this->db->escape($dateEnd).", menu_pages=".$this->db->escape($strPages).", menu_access=".$this->db->escape($strRights).", menu_txt_color=".$this->db->escape($parent_txt_xolor).", menu_primary_color=".$this->db->escape($parent_primary_color)." WHERE menu_id=".$id);
		
		if($strPages=='Other')
		{
			 $this->db->query("DELETE FROM menus_pages_xref WHERE menu_id=".$id);
			 $arrPages = $this->input->post("lstPages");
			 for($i=0; $i<sizeof($arrPages);$i++)
			 {
				$this->db->query("INSERT INTO menus_pages_xref(menu_id, page_id) VALUES(".$this->db->escape($id).", ".$this->db->escape($arrPages[$i]).")");
			}            
		}
		else
		{
			//Delteting menu Refeerence from Page menu Link Ref
			$this->db->query("DELETE FROM menus_pages_xref WHERE menu_id=".$id);
		}	
		
		if($strRights=='Other'){
			
			$site_id = $this->input->post('site_id');
			//$menu_id = $this->input->post('menu_id');			
			$group_id = $this->input->post('group_access');
			$role_id = $this->input->post("role_id");
			for($i=0; $i<sizeof($group_id);$i++)
			{
				$qry_delete_if_exist = "DELETE FROM access_levels_menu_groups_xref 
										WHERE menu_id=".$id."
										AND group_id=".$this->db->escape($group_id[$i])." 									
										AND site_id=".$this->db->escape($site_id);
			}			
			$this->db->query($qry_delete_if_exist);
			for($i=0; $i<sizeof($group_id);$i++)
			{
				$this->db->query("INSERT INTO   access_levels_menu_groups_xref(menu_id, group_id, site_id) VALUES(".$this->db->escape($id).", ".$this->db->escape($group_id[$i]).", ".$this->db->escape($site_id).")");
			}			
		}	
		else
		{
			//Delteting menu Refeerence from ROLE menu Link Ref
			$this->db->query("DELETE FROM menus_roles_xref WHERE menu_id=".$id);
		}
		
		if($intNumItems>0)
		{
			$this->db->query("DELETE FROM menuitems_pages_xref  WHERE  menu_id=".$id);			
			$this->db->query("DELETE FROM menuitems  WHERE   menu_id=".$id);			
			$this->db->query("DELETE FROM menus_menuitems_xref WHERE menu_id=".$this->db->escape($id));
			
			for( $i=0; $i<$intNumItems; $i++ )
			{
				
				$j					= $i+1;	
				$rdoItemPublished	= '';
				$lstItemPage 		= '';
				$txtItemName		= '';
				$strCustomLink 		= '';
				//$lstItemPage 		= $_POST['lstItemPage'][$i];
				$txtItemName 		= $_POST['txtItemName'][$i];
				$menuTarget			= $_POST['menuTarget'][$i];
				//$strCustomLink 		= $_POST['_lstItemPage'.$j];
				if(!empty($_POST['rdoItemPublished'.$j]))
				{
					$rdoItemPublished 	= $_POST['rdoItemPublished'.$j];
				}			
				if(!empty($_POST['lstItemPage'][$i]))
				{
					$lstItemPage 		= $_POST['lstItemPage'][$i];
				}	
				if(!empty($_POST['_lstItemPage'.$j]))
				{
					$strCustomLink 		= $_POST['_lstItemPage'.$j];
				}			
				
				// this is for replace " to ' 
                    $txtItemName = str_replace('"',' ',$txtItemName);
                
                // end 
                    $this->db->query('INSERT INTO menuitems(item_name, item_published, item_status, item_link, item_target, display_order) VALUES("'.$txtItemName.'",  "'.$rdoItemPublished.'", "Active","'.$strCustomLink.'","'.$menuTarget.'","'.$i.'")');	
				//$this->db->query("INSERT INTO menuitems(item_name, item_published, item_status, item_link, item_target, display_order) VALUES('".$txtItemName."',  '".$rdoItemPublished."', 'Active','".$strCustomLink."','".$menuTarget."','".$i."')");
				
				$intItemId = $this->db->insert_id();				
				$this->db->query("INSERT INTO menus_menuitems_xref(menu_id, item_id) VALUES(".$this->db->escape($id).", ".$this->db->escape($intItemId).")");
				
				$this->db->query("INSERT INTO menuitems_pages_xref(item_id, page_id) VALUES(".$this->db->escape($intItemId).", ".$this->db->escape($lstItemPage).")");
					
			}
	
		}
		else
		{
			
			//$this->db->query("DELETE FROM menuitems_pages_xref  WHERE EXISTS (SELECT item_id FROM menus_menuitems_xref  WHERE menus_menuitems_xref.menu_id =".$this->db->escape($id)." AND menuitems_pages_xref.item_id = menus_menuitems_xref.item_id)");			
			//$this->db->query("DELETE FROM menuitems  WHERE EXISTS (SELECT item_id FROM menus_menuitems_xref  WHERE menus_menuitems_xref.menu_id=".$this->db->escape($id)." AND menuitems.item_id = menus_menuitems_xref.item_id)");	
			$this->db->query("DELETE FROM menuitems_pages_xref  WHERE  menu_id=".$id);			
			$this->db->query("DELETE FROM menuitems  WHERE   menu_id=".$id);		
			$this->db->query("DELETE FROM menus_menuitems_xref WHERE menu_id=".$this->db->escape($id));
			
			/*$this->db->query("DELETE FROM menuitems_pages_xref WHERE item_id IN(SELECT item_id FROM menus_menuitems_xref WHERE menu_id=".$this->db->escape($id).")");			
			$this->db->query("DELETE FROM menuitems WHERE item_id IN(SELECT item_id FROM menus_menuitems_xref WHERE menu_id=".$this->db->escape($id).")");			
			$this->db->query("DELETE FROM menus_menuitems_xref WHERE menu_id=".$this->db->escape($id));*/
			
		}//end else   
		//exit;
		return true;  
		 
	}
	
	function updateMainMenu()
	{
		
		//echo "<pre>";print_r($_REQUEST);exit;
		
		$id = $this->input->post("id");	 
		$intNumItems = $this->input->post("numItems");		 
		if($intNumItems>0)
		{
						
			$this->db->query("DELETE FROM menuitems_pages_xref  WHERE  menu_id=".$this->db->escape($id));			
			$this->db->query("DELETE FROM menuitems  WHERE   menu_id=".$this->db->escape($id));			
			$this->db->query("DELETE FROM menus_menuitems_xref WHERE menu_id=".$this->db->escape($id));	
			for( $i=0; $i<$intNumItems; $i++ )
			{
				
				$j					= $i+1;	
				$rdoItemPublished	= '';
				$lstItemPage 		= '';
				$txtItemName		= '';
				$strCustomLink 		= '';
				//$lstItemPage 		= $_POST['lstItemPage'][$i];
				$txtItemName 		= $_POST['txtItemName'][$i];
				$menuTarget			= $_POST['menuTarget'][$i];
				//$strCustomLink 		= $_POST['_lstItemPage'.$j];
				if(!empty($_POST['rdoItemPublished'.$j]))
				{
					$rdoItemPublished 	= $_POST['rdoItemPublished'.$j];
				}			
				if(!empty($_POST['lstItemPage'][$i]))
				{
					$lstItemPage 		= $_POST['lstItemPage'][$i];
				}	
				if(!empty($_POST['_lstItemPage'.$j]))
				{
					$strCustomLink 		= $_POST['_lstItemPage'.$j];
				}			
				
					
				$this->db->query("INSERT INTO menuitems(item_name, item_published, item_status, item_link, item_target, display_order) VALUES('".$txtItemName."',  '".$rdoItemPublished."', 'Active','".$strCustomLink."','".$menuTarget."','".$i."')");
				
				$intItemId = $this->db->insert_id();				
				$this->db->query("INSERT INTO menus_menuitems_xref(menu_id, item_id) VALUES(".$this->db->escape($id).", ".$this->db->escape($intItemId).")");
				
				$this->db->query("INSERT INTO menuitems_pages_xref(item_id, page_id) VALUES(".$this->db->escape($intItemId).", ".$this->db->escape($lstItemPage).")");
					
			}
		}   
		//exit;     
		return true;
	}
	
	//gets menus information from db
	function menuInfo($id){
		return $result = $this->db->query("SELECT * FROM menus WHERE menu_id=".$this->db->escape($id)." AND menu_status='Active' ORDER BY menu_id");        
	}
	
	//gets menu item information from db
	function menuItemsInfo($id){
		//return $result = $this->db->query("SELECT * FROM menuitems mni JOIN menus_menuitems_xref mmx ON mmx.item_id=mni.item_id JOIN menus mnu ON mnu.menu_id=mmx.menu_id  WHERE mnu.menu_id=".$id." ORDER BY mni.item_id");
		return $result = $this->db->query("SELECT * FROM menuitems mni JOIN menus_menuitems_xref mmx ON mmx.item_id=mni.item_id JOIN menus mnu ON mnu.menu_id=mmx.menu_id  WHERE mnu.menu_id=".$id." ORDER BY mni.display_order ASC ");
	}
	
	//checks if the page is assigned this menu OR will this menu display on this page
	function isMenuPage($menu_id, $page_id){
		$result =  $this->db->query("SELECT * FROM menus_pages_xref WHERE menu_id=".$menu_id." AND page_id=".$page_id);
		if($result->num_rows()>0){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	//checks if menu is assigned to a page and the menu items it contains are assigned a page
	function isItemPage($id, $item_id, $page_id){
		$result =  $this->db->query("SELECT * FROM menus mnu JOIN menus_menuitems_xref mmx ON mmx.menu_id=mnu.menu_id JOIN menuitems_pages_xref mpx ON mpx.item_id=mmx.item_id WHERE mnu.menu_id=".$id." AND mmx.item_id=".$item_id." AND mpx.page_id=".$page_id);
		
		if($result->num_rows()>0){
			
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	//checks if the given role is assigned to this menu
	function isMenuRole($menu_id, $role_id){
		$result =  $this->db->query("SELECT * FROM menus_roles_xref WHERE menu_id=".$menu_id." AND role_id=".$role_id);
		if($result->num_rows()>0){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	function isMenuforUser($menu_id, $user_id){
		//echo "SELECT * FROM menus_roles_xref WHERE menu_id=".$menu_id." AND role_id IN(SELECT role_id FROM user_role_xref WHERE user_id=".$this->db->escape($user_id);exit();
		$result =  $this->db->query("SELECT * FROM menus_roles_xref WHERE menu_id=".$menu_id." AND role_id IN(SELECT role_id FROM user_role_xref WHERE user_id=".$this->db->escape($user_id));
		if($result->num_rows()>0){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	//pages page assigned to the menu item with this id
	function getPage($itemId){             
	   
		
		$qry = "SELECT * FROM pages pgs JOIN menuitems_pages_xref mix ON mix.page_id=pgs.page_id JOIN menuitems mit ON mit.item_id=mix.item_id WHERE mit.item_id=".$this->db->escape($itemId);
		//echo $qry;exit;
		 
		 return $this->db->query($qry);
				
	}
	
	
	//gets all menus assigned a given position and access level
	function getMenu($position, $access){
		return $this->db->query("SELECT * FROM menus WHERE menu_position=".$this->db->escape($position)." AND menu_access=".$this->db->escape($access)." AND menu_status='Active' AND menu_published IN ('Yes', 'Schedule')");
		        
	}
	
	
	//gets all menus assigned to a page in the sidebar region of the template, irrespective of the position(left or right)
	function getAllPageMenus($site_id, $page_id, $access, $menu_pages)
	{
		//echo "site id --->".$site_id."-------page id---->".$page_id."<br>";
		
		//echo "access--->".$access." -----------     Menu pages--->".$menu_pages."<br>";  
		
		if(isset($_SESSION['customer_group_id']))
		{
			//$user_id = $_SESSION['user_info']['user_id'];
			$user_id = $_SESSION['customer_group_id'];
		}
		else
		{
			$user_id = 0;    
		}
		
		if($menu_pages == "All")
		{
			if($access == "Other")
			{
			   // echo "All -- Other <br/> ";
				/*return $this->db->query("SELECT * FROM menus mnu
									
					WHERE mnu.menu_access='Other'
					AND mnu.site_id=".$this->db->escape($site_id)."
					AND mnu.menu_status='Active'
					AND mnu.menu_pages='All' 
					
					AND mnu.menu_published IN ('Yes', 'Schedule')
					AND mnu.menu_position IN ('Left', 'Right')");        */
					
				return $this->db->query("SELECT * FROM menus mnu
					JOIN access_levels_menu_groups_xref almg ON almg.menu_id = mnu.menu_id					 
					WHERE mnu.menu_access='Other'
					AND mnu.site_id=".$this->db->escape($site_id)."
					AND mnu.menu_status='Active'
					AND mnu.menu_pages='All' 

					AND almg.group_id = ".$user_id."
					AND mnu.menu_published IN ('Yes', 'Schedule')");   
					     	
				
			} 
			else if($access == "Everyone")
			{
				//echo "else-- Other <br/>";exit;
				//echo "access--->".$access." -----------     Menu pages--->".$menu_pages."<br>";  
				
					return $this->db->query("SELECT * FROM menus mnu 
					WHERE mnu.menu_access=".$this->db->escape($access)." 
					AND mnu.site_id=".$this->db->escape($site_id)."
					AND mnu.menu_status='Active'
					AND mnu.menu_pages='All' 
					AND mnu.menu_published IN ('Yes', 'Schedule')
					AND mnu.menu_position IN ('Left', 'Right')");   
					
			} 
			else
			{
			   // echo "All -- else <br/>";
			   return $this->db->query("SELECT * FROM menus mnu
					JOIN menus_pages_xref mpx ON mpx.menu_id=mnu.menu_id
					JOIN pages pgs ON pgs.page_id=mpx.page_id                    
					WHERE pgs.page_id=".$this->db->escape($page_id)." 
					AND mnu.site_id=".$this->db->escape($site_id)."
					AND mnu.menu_access=".$this->db->escape($access)."
					AND mnu.menu_status='Active'
					AND mnu.menu_pages='Other'                   
					AND mnu.menu_published IN ('Yes', 'Schedule')");    
				 
			}   
		}
		else{
		
			if($access == "Other")
			{   
			    //echo "else-- Other <br/>";exit;
				
				return $this->db->query("SELECT * FROM menus mnu
					JOIN menus_pages_xref mpx ON mpx.menu_id=mnu.menu_id
					JOIN pages pgs ON pgs.page_id=mpx.page_id
					WHERE pgs.page_id=".$this->db->escape($page_id)." 
					AND mnu.site_id=".$this->db->escape($site_id)."
					AND mnu.menu_access='Other'
					AND mnu.menu_status='Active'
					AND mnu.menu_pages='Other' 
					AND mnu.menu_published IN ('Yes', 'Schedule')
					AND mnu.menu_position IN ('Left', 'Right')");    
			}
			//Everone but Some pages
			else if($access == "Everyone")
			{
				//echo "else-- Other <br/>";exit;
				//echo "access--->".$access." -----------     Menu pages--->".$menu_pages."<br>";  
				
					return $this->db->query("SELECT * FROM menus mnu
					JOIN menus_pages_xref mpx ON mpx.menu_id=mnu.menu_id
					JOIN pages pgs ON pgs.page_id=mpx.page_id
					WHERE pgs.page_id=".$this->db->escape($page_id)." 
					AND mnu.site_id=".$this->db->escape($site_id)."
					AND mnu.menu_access='Everyone'
					AND mnu.menu_status='Active'
					AND mnu.menu_pages='Other' 
					AND mnu.menu_published IN ('Yes', 'Schedule')
					AND mnu.menu_position IN ('Left', 'Right')"); 
					
			} 
			else
			{   
			//echo "access--->".$access." -----------     Menu pages--->".$menu_pages."<br>";  
				if($user_id != 0)
				{
				    //echo " user_id != 0 <br/>";
					
					return $this->db->query("SELECT * FROM menus mnu
					JOIN menus_pages_xref mpx ON mpx.menu_id=mnu.menu_id
					JOIN pages pgs ON pgs.page_id=mpx.page_id                    
					WHERE pgs.page_id=".$this->db->escape($page_id)." 
					AND mnu.site_id=".$this->db->escape($site_id)."
					AND mnu.menu_access=".$this->db->escape($access)."
					AND mnu.menu_status='Active'
					AND mnu.menu_pages='Other'                   
					AND mnu.menu_published IN ('Yes', 'Schedule')");    
				}
				
				else
				{
				  // echo "hereeeee";exit;
				   // echo " site_id = 0 <br/>";
					$site_id = 0;
					
					return $this->db->query("SELECT * FROM menus mnu
					JOIN menus_pages_xref mpx ON mpx.menu_id=mnu.menu_id
					JOIN pages pgs ON pgs.page_id=mpx.page_id                    
					WHERE pgs.page_id=".$this->db->escape($page_id)." 
					AND mnu.site_id=".$this->db->escape($site_id)."
					AND mnu.menu_access=".$this->db->escape($access)."
					AND mnu.menu_status='Active'
					AND mnu.menu_pages='Other'                   
					AND mnu.menu_published IN ('Yes', 'Schedule')"); 
					
					
					/*return $this->db->query("SELECT * FROM menus mnu
					WHERE menu_position IN ('Left', 'Right') AND mnu.site_id=".$this->db->escape($site_id));*/
				}
					
			}             
		}    
	}
	
	//gets all menus assigned to a page, position and access
	function getPageMenus($site_id, $page_id, $position, $access, $menu_pages){ 
	
//echo "site_id -------->".$site_id."  page_id -------->".$page_id."  access--->".$access." -----------     Menu pages--->".$menu_pages."<br>";
		if($menu_pages == "All")
		{
			if($access == "Other")
			{
				if(isset($_SESSION['customer_group_id']))
				{
					//$user_id = $_SESSION['user_info']['user_id'];
					$user_id = $_SESSION['customer_group_id'];
				}
				else
				{
					
					$user_id = 0;    
				}
				
				//echo $user_id;exit;
				
				/*return $this->db->query("SELECT * FROM menus mnu
					JOIN menus_roles_xref mrx ON mrx.menu_id=mnu.menu_id 
					JOIN roles rol ON rol.role_id=mrx.role_id 
					WHERE mnu.menu_position=".$this->db->escape($position)."
					AND mnu.menu_access='Other'
					AND mnu.site_id=".$this->db->escape($site_id)."
					AND mnu.menu_status='Active'
					AND mnu.menu_pages='All' 
					AND rol.role_id IN(SELECT role_id FROM user_role_xref WHERE user_id=".$this->db->escape($user_id).")
					AND mnu.menu_published IN ('Yes', 'Schedule')");      */  
					
				return $this->db->query("SELECT * FROM menus mnu
					JOIN access_levels_menu_groups_xref almg ON almg.menu_id = mnu.menu_id					 
					WHERE mnu.menu_position=".$this->db->escape($position)."
					AND mnu.menu_access='Other'
					AND mnu.site_id=".$this->db->escape($site_id)."
					AND mnu.menu_status='Active'
					AND mnu.menu_pages='All' 
					AND almg.group_id = ".$user_id."
					AND mnu.menu_published IN ('Yes', 'Schedule')");        	
			} 
			else
			{
				return $this->db->query("SELECT * FROM menus mnu 
					WHERE mnu.menu_position=".$this->db->escape($position)."
					AND mnu.menu_access=".$this->db->escape($access)." 
					AND mnu.site_id=".$this->db->escape($site_id)."
					AND mnu.menu_status='Active'
					AND mnu.menu_pages='All' AND mnu.menu_published IN ('Yes', 'Schedule')");    
			}   
		}
		else{
			if($access == "Other")
			{   
				if(isset($_SESSION['customer_group_id'])) 
				{
					$user_id = $_SESSION['customer_group_id'] ;
				}
				else
				{
					$user_id = 0;    
				}   
				
				return $this->db->query("SELECT * FROM menus mnu
					JOIN access_levels_menu_groups_xref almg ON almg.menu_id = mnu.menu_id
					JOIN menus_pages_xref mpx ON mpx.menu_id=mnu.menu_id
					JOIN pages pgs ON pgs.page_id=mpx.page_id
					WHERE mnu.menu_position=".$this->db->escape($position)."
					AND pgs.page_id=".$this->db->escape($page_id)." 
					AND mnu.site_id=".$this->db->escape($site_id)."
					AND mnu.menu_access='Other'
					AND mnu.menu_status='Active'
					AND mnu.menu_pages='Other' 
					AND almg.group_id = ".$user_id." 
					AND mnu.menu_published IN ('Yes', 'Schedule')");    
			} 
			else
			{                
				return $this->db->query("SELECT * FROM menus mnu
					JOIN menus_pages_xref mpx ON mpx.menu_id=mnu.menu_id
					JOIN pages pgs ON pgs.page_id=mpx.page_id                    
					WHERE mnu.menu_position=".$this->db->escape($position)."
					AND pgs.page_id=".$this->db->escape($page_id)." 
					AND mnu.site_id=".$this->db->escape($site_id)."
					AND mnu.menu_access=".$this->db->escape($access)."
					AND mnu.menu_status='Active'
					AND mnu.menu_pages='Other'                   
					AND mnu.menu_published IN ('Yes', 'Schedule')");    
			}             
		}
	     
				
	}
	
	//gets menu items assigned to a given menu
	function getMenuItem($menu_id,$access_level= ''){
	/*echo "SELECT mi.item_id, item_name, item_status, item_published, item_link  FROM menuitems mi JOIN menus_menuitems_xref mix ON mi.item_id=mix.item_id JOIN menus mn ON mn.menu_id=mix.menu_id WHERE mn.menu_id=".$this->db->escape($menu_id)." AND item_status='Active' AND item_published='Yes' ORDER BY item_id ASC";exit;
*/
	if($access_level == "Everyone" || $access_level == "" )
	{
		//echo $access_level."<br>"; 
		return $this->db->query("SELECT mi.item_id, item_name, item_status, item_published, item_link, item_target, access_level  FROM menuitems mi JOIN menus_menuitems_xref mix ON mi.item_id=mix.item_id JOIN menus mn ON mn.menu_id=mix.menu_id WHERE mn.menu_id=".$this->db->escape($menu_id)." AND item_status='Active' AND item_published='Yes' ORDER BY display_order ASC");        
	}
	//return true;
	
	}
	
	//To Check Page Menu Link and Access Level
	function is_page_allowed_for_group($page_id,$group_id)
	{
		$qry = "SELECT id FROM access_levels_pages_groups_xref WHERE page_id = '".$page_id."' AND group_id = '".$group_id."' ";
		//echo $qry;exit; 
		$result = $this->db->query($qry);
		if ($result->num_rows() > 0)
		{
			$menuItemId = $result->result_array();
			return $menuItemId[0];
		}
		return false;
	}
	
	
		//get all users against all pages of site
	function get_private_users_Pages($site_id){
		$Q =  $this->db->query("SELECT page_id,page_privacy,page_users  FROM pages WHERE site_id=".$this->db->escape($site_id)." AND page_users !='' AND page_privacy = 'Private'  AND page_status NOT IN('Deleted') ORDER BY page_id");
		$results = $Q->result_array();
		/*echo "<pre>";
		print_r($results);
		exit;*/
		return $results;
	}
	
	function check_private_page($site_id, $page_id){
		 //echo 'jflksdjflsjdfksdjflk'.$page_id; exit;
		$Q =  $this->db->query("SELECT page_users  FROM pages WHERE site_id=".$this->db->escape($site_id)." AND page_id =".$this->db->escape($page_id)." AND page_privacy = 'private'  AND page_status NOT IN('Deleted') ORDER BY page_id");
		$results = $Q->result_array();		
		return $results[0]['page_users'];
	}
	
	
	//gets all pages
	function getPages($site_id){
		return $this->db->query("SELECT page_id, page_title ,page_parent  FROM pages WHERE site_id=".$this->db->escape($site_id)." AND page_type = 'Normal' AND page_status NOT IN('Deleted') ORDER BY page_id");
	}
	
	function get_page_with_type($site_id,$type){
		return $this->db->query("SELECT page_id, page_title ,page_parent  FROM pages WHERE site_id=".$this->db->escape($site_id)." AND page_status NOT IN('Deleted') AND page_type = '$type' ORDER BY page_id");
	}
	
	function get_parent($site_id){
		$data[0] = 'None';
		$result = $this->db->query("SELECT page_id, page_title ,page_parent  FROM pages WHERE site_id=".$this->db->escape($site_id)." AND page_status NOT IN('Deleted') ORDER BY page_id");
		if ($result->num_rows() > 0)
		{
		   foreach ($result->result_array() as $row)
		   {
			 $data[$row['page_id']] = $row['page_title'];
		   }
		}
		$result->free_result();
		return $data;
	}
	
	//gets all roles
	//used in pagesController functions(create_page, )
	function getRoles(){
		return $this->db->query("SELECT role_id, role_name FROM roles ORDER BY role_id");
	}
	
   /* method : getRolesDropdown
   
	  sahil babu  */ 
	function getRolesDropdown()
	{
				 $data = array();
				 $this->db->select('id,group_name');
				 //$this->db->where('delete ','0'); 
				 $this->db->order_by('id','asc'); 
				 $Q = $this->db->get('groups');
				 if ($Q->num_rows() > 0){
				   foreach ($Q->result_array() as $row){
					 $data[$row['id']] = $row['group_name'];
				   }
				}
				$Q->free_result();
				return $data;
		
		
		
		
	}	
	//adds/creates a menu
	function addMenu()
	{       
		$site_id = $this->input->post("site_id");
		$strName = $this->input->post("txtName");
		$strPosition = $this->input->post("rdoPosition");
		$strPublished = $this->input->post("rdoPublished");
		if($strPublished=="Schedule")
		{
			$dateStart = date('Y-m-d h:i:s', strtotime($this->input->post("startDate")));        
			$dateEnd = date('Y-m-d h:i:s', strtotime($this->input->post("endDate"))); 
		}
		else
		{
			$dateStart = "";        
			$dateEnd = ""; 
		}
		$strPages = $this->input->post("rdoPages");
		$strRights = $this->input->post("rdoRights");
		$intNumItems = $this->input->post("numItems");
		$parent_menu = $this->input->post("parent_menu"); 
        $parent_primary_color = $this->input->post("prim_color"); 
        $parent_txt_xolor = $this->input->post("prim_txt"); 
		$totalMenus = $this->totalMenus($site_id);
		$menu_order = $totalMenus + 1;
		
		//Array
		$menu_sort_array = Array();
	  
		$i=1;
		$j=0;
		//$menu_sort_array = array_slice($_POST, 11);
		//echo "<pre>";
		//print_r($_POST);
		
		/***Get Input Fileds And Drop Down Values In Array In Sorted Order $menu_sort_array[]***/
		/** No Need For Sorting At Time Of Create Menu **/
	   
		/*foreach( $_POST as $key => $value )
		{
			$string = preg_replace('/(\d+)/', '',$key);
			if($string=="txtItemName" || $string=="lstItemPage" || $string=="_lstItemPage" || $string=="rdoItemPublished")
			{
				//echo  $string."---". $value."<br>";
				$menu_sort_array[$string.$i] = $value;
				$j++; 
				if($j%4==0)
				{
				  $i++;                       
				}
			}
						   
		}*/
		//echo "<pre>";
		//print_r($menu_sort_array);   
		//exit;
		
		$this->db->query("INSERT INTO menus(menu_name ,menu_position ,menu_published ,menu_status ,menu_start ,menu_end ,menu_pages ,menu_access, menu_order,menu_txt_color,menu_primary_color, site_id, parent_menu) 
		VALUES (".$this->db->escape($strName).", ".$this->db->escape($strPosition).", ".$this->db->escape($strPublished).", 'Active',
		".$this->db->escape($dateStart).", ".$this->db->escape($dateEnd).", ".$this->db->escape($strPages).",
		".$this->db->escape($strRights).", ".$this->db->escape($menu_order).", ".$this->db->escape($parent_txt_xolor).", ".$this->db->escape($parent_primary_color).", ".$this->db->escape($site_id).",
		".$this->db->escape($parent_menu).")");
		
		$intMenuId = $this->db->insert_id();
		if($strPages=='Other')
		{
			$arrPages = $this->input->post("lstPages");
			for($i=0; $i<sizeof($arrPages);$i++){
				$this->db->query("INSERT INTO menus_pages_xref(menu_id, page_id) VALUES(".$this->db->escape($intMenuId).", ".$this->db->escape($arrPages[$i]).")");
			}            
		}
		if($strRights=='Other')
		{
			$site_id = $this->input->post('site_id');
			$page_id = $this->input->post('menu_id');			
			$group_id = $this->input->post('group_access');
			$role_id = $this->input->post("role_id");
			//$qry_delete_if_exist = "DELETE FROM access_levels_pages_groups_xref 
									//WHERE menu_id=".$this->db->escape($page_id)." 									
									//AND site_id=".$this->db->escape($site_id);
									
			//$this->db->query($qry_delete_if_exist);
			for($i=0; $i<sizeof($group_id);$i++)
			{
				$this->db->query("INSERT INTO   access_levels_menu_groups_xref(menu_id, group_id, site_id) VALUES(".$this->db->escape($intMenuId).", ".$this->db->escape($group_id[$i]).", ".$this->db->escape($site_id).")");
			}    
			
			/*$arrRoles = $this->input->post("lstRoles");
			for($i=0; $i<sizeof($arrRoles);$i++){
				$this->db->query("INSERT INTO menus_roles_xref(menu_id, role_id) VALUES(".$this->db->escape($intMenuId).", ".$this->db->escape($arrRoles[$i]).")");
			}            */
		}
		if($intNumItems>0)
		{
			$k = 0;
			for($i=1; $i<=$intNumItems;$i++)
			{
				if($this->input->post("txtItemName".$i)!="" && $this->input->post("lstItemPage".$i)!="" && $this->input->post("rdoItemPublished".$i)!="" && $this->input->post("menuTarget".$i)!=""){
					$strItemName  = $this->input->post("txtItemName".$i);
					$strItemPage  = $this->input->post("lstItemPage".$i);
					$strPublished = $this->input->post("rdoItemPublished".$i);
					$strCustomLink= $this->input->post("_lstItemPage".$i);
					$menuTarget = $this->input->post("menuTarget".$i);
					
					$this->db->query("INSERT INTO menuitems(menu_id, item_name, item_published, item_status, item_link, item_target, display_order) VALUES(".$this->db->escape($intMenuId).",".$this->db->escape($strItemName).",  ".$this->db->escape($strPublished).", 'Active' , ".$this->db->escape($strCustomLink)." , ".$this->db->escape($menuTarget)." ,'$k')");
					
					$intItemId = $this->db->insert_id();
					$this->db->query("INSERT INTO menus_menuitems_xref(menu_id, item_id) VALUES(".$this->db->escape($intMenuId).", ".$this->db->escape($intItemId).")");
					
					$this->db->query("INSERT INTO menuitems_pages_xref(item_id, page_id, menu_id) VALUES(".$this->db->escape($intItemId).", ".$this->db->escape($strItemPage).", ".$this->db->escape($intMenuId).")");                    
				}
				$k++;
			}           
		}
		return true;
	}
	
	//publishes the menus given in the array
	function publishMenus($arrMenuId){
		$data = array(
			   'menu_published' => "Yes",               
			);     
		for($i=0;$i<sizeof($arrMenuId);$i++){
			$this->db->where('menu_id', $arrMenuId[$i]);
			$this->db->update('menus', $data); 
		}
		return;
	}
	
	//unpublishes menus given in the array
	function unpublishMenus($arrMenuId){
		$data = array(
			   'menu_published' => "No",               
			);     
		for($i=0;$i<sizeof($arrMenuId);$i++){
			$this->db->where('menu_id', $arrMenuId[$i]);
			$this->db->update('menus', $data); 
		}
		return;
	}
	
	//deletes menus given in the array
	function deleteMenus($arrMenuId){
		$data = array(
			   'menu_status' => "Deleted",               
			);     
		for($i=0;$i<sizeof($arrMenuId);$i++){
			$this->db->where('menu_id', $arrMenuId[$i]);
			$this->db->update('menus', $data); 
		}
		return;
	}
	
	//shows all menus from(record number) to page limit assigned to a page
	function showMenus($from, $intPageLimit, $site_id){ 
		//echo "(SELECT * FROM menus WHERE menu_status NOT IN('Deleted') AND site_id=".$this->db->escape($site_id)." AND menu_pages='All') UNION (SELECT mnu.* FROM menus mnu JOIN menus_pages_xref mpx ON mpx.menu_id=mnu.menu_id WHERE mpx.page_id='3' AND mnu.menu_status NOT IN ('Deleted')) ORDER BY menu_id DESC LIMIT ".$from.", ".$intPageLimit;exit;
		return $this->db->query("SELECT * FROM menus WHERE menu_status NOT IN('Deleted') AND site_id=".$this->db->escape($site_id)." ORDER BY menu_order ASC LIMIT ".$from.", ".$intPageLimit );
	}
	
	//returns number of menus created in a site
	function totalMenus($site_id){
		$result = $this->db->query("SELECT * FROM menus WHERE menu_status NOT IN('Deleted') AND site_id=".$this->db->escape($site_id));
		return $result->num_rows();
	}
	
	//returns number of menus created in a site
	function get_all_site_menus($site_id)
	{
		$qry_str = "SELECT * FROM menus WHERE menu_status NOT IN('Deleted') AND site_id =".$this->db->escape($site_id)."";
		$result = $this->db->query($qry_str);
		return $result->result_array();
		
	} 
	
	
	function get_group_id_by_customer_id($customer_id)
	{
		$this->db->where('customer_id', $customer_id);
		$r = $this->db->get("ec_customers_group_xref");
		if($r->num_rows() > 0)
		{
			foreach( $r->result_array() as $row )
			{ 
				$group_id = $row["group_id"];
				$data[] = $group_id;
			}
			
			return $data;
		}
		return false;
	}
	
	function  top_navigation_default ($site_id = '',$is_seo_enabled = "off")
	{
		
		$data = array();
		$menu_id_custom = 0;
		$qry = "SELECT * FROM pages pgs
		JOIN menuitems_pages_xref mpx ON pgs.page_id=mpx.page_id
		JOIN menuitems mni ON mni.item_id=mpx.item_id
		JOIN menus_menuitems_xref mmx ON mmx.item_id=mni.item_id
		JOIN menus mnu ON mnu.menu_id=mmx.menu_id  
		WHERE pgs.site_id=".$this->db->escape($site_id)." AND pgs.page_status='Published' 
		AND mnu.is_main_menu='Yes' AND mni.item_published='Yes'
		ORDER BY mni.item_id ASC";
		/*echo "<pre>";
		print_r($custom_array);
		exit;*/
		
		$Q = $this->db->query($qry); 	
		/*$s = $Q->result_array();	
		
		$custom_link = $this->db->query("SELECT mi.item_id, item_name, item_status, item_published, item_link, item_target, access_level  FROM menuitems mi JOIN menus_menuitems_xref mix ON mi.item_id=mix.item_id JOIN menus mn ON mn.menu_id=mix.menu_id WHERE mn.menu_id=".$this->db->escape($s[0]['menu_id'])." AND item_status='Active' AND item_published='Yes' ORDER BY display_order ASC");	
		$custom_array = $custom_link->result_array();
		$s[0]['menu_id'];
		echo "<pre>";
		print_r($custom_array);
		exit;*/
		///$Q =$this->db->query("SELECT * FROM pages WHERE site_id=".$this->db->escape($site_id)." AND page_status='Published' AND page_default NOT IN ('Not Default', 'Footer') ORDER BY page_id ASC");
		//echo "<pre>";
		if ($Q->num_rows() > 0)
		{
			foreach ($Q->result_array() as $row)
			{	
				
				/*echo "<pre>";
				echo $_SESSION['login_info']['customer_id'];
				print_r($row);*/			
 
				//exit;
				//Page Access System for EveryOne Registered and Particular Group
				
				if($row["page_access"] == "Everyone")
				{
					
					$data[] = $row;	
					
				}
				else if($row["page_access"] == "Registered") 
				{
					
					if(isset($_SESSION['login_info']['customer_id']))
					{
						$data[] = $row;
					}
				}
				else if($row["page_access"] == "Other")
				{
					
					//echo "<pre>";
					//echo $_SESSION['login_info']['customer_id'].'------|'.$row['page_groups'].'|----'.$row['page_users'];
					//exit;
					if(isset($_SESSION['login_info']['customer_id']) && $_SESSION['login_info']['customer_id']==$row['page_users'] && $row['page_groups']=='' && !empty($row['page_users']))
					{
						$data[] = $row;
					}					
					else if(isset($_SESSION['login_info']['customer_id']))
					{
						
						// page groups ids
						
						$page_groups = $row['page_groups'];
						$page_user = $row['page_users'];
						//echo "-"; 
						
						$page_groups_id = explode(",",$page_groups);  
						$group_id = $this->get_group_id_by_customer_id($_SESSION['login_info']['customer_id']);
						if($page_groups != "" && ( $page_user == "" || $page_user == NULL) ) // for only groups
						{

							if($group_id)
							{
								foreach($group_id as $id )
								{
									if ( in_array($id,$page_groups_id) )
									{
										$data[] = $row;
										break;
									}
								}
							}
						}
						else if ($page_groups != "" && $page_user != "") 
						{
							$page_users_id = explode(",",$page_user);
							$member_id = $_SESSION['login_info']['customer_id'];
							if ( in_array($member_id,$page_users_id) )
							{
								$data[] = $row;
							}
							
						}
						
						
					}
					
					
				}
				
				$menu_id_custom = $row['menu_id'];
				
		   }	   
		} 
		//exit;
	   // echo '<pre>';  print_r($data); echo '</pre>'; exit();
	
		$Q->free_result();
		$query_custom_link_query = $this->db->query("SELECT *
		FROM menus_menuitems_xref
		INNER JOIN menuitems ON menus_menuitems_xref.item_id=menuitems.item_id
		AND menus_menuitems_xref.menu_id=".$menu_id_custom."
		AND menuitems.item_link!=''");
		
		if ($query_custom_link_query->num_rows() > 0)
		{
			foreach ($query_custom_link_query->result_array() as $row_custom_link)
			{	
				//print_r($row_custom_link);			
				$data[] = $row_custom_link;
		   }	   
		   
		}
//		 $menu = $this->make_menu_top($data);
		//Fetching Data for Webinar Top Navigation
		//echo "<pre>";	print_r($data); echo "</pre>";
		if(count($data) > 0)
		{
			$main_menu_id = $data[0]["menu_id"];
			//echo $main_menu_id;//exit;
			
			$top_webinars = $this->get_top_webinar_items($main_menu_id);
		//	echo "<pre>";
		//	print_r($top_webinars);
		//	exit;
		}
		
		if(isset($top_webinars) )
		{
			if(count($top_webinars) > 0)
	
			{
	
				$data = array_merge($data,$top_webinars);
	
			}
		}
		
		//	echo "<pre>";	print_r($_SESSION); die();
		$user_id = 0;
		if(isset($_SESSION['login_info']['customer_id']))
		{
			$user_id = $_SESSION['login_info']['customer_id'];
		}
		 $registration_form_menu = $this->get_reg_frm_menu($site_id, $user_id, $main_menu_id);
		 
		 if(count($registration_form_menu) > 0)
		 {
			$data = array_merge($data,$registration_form_menu);
		 }
		 
		 if(count($data) > 0)
		 {
			 // echo "<pre>";	print_r($data); echo "</pre>";
			 $blog = $this->get_blog_page($site_id);
			 if($blog)
			 {
				
				
				$data = array_merge($data,$blog);
				// echo "<pre>";	print_r($blog); echo "</pre>";
			 }
		 }
		 
		 return $data; 
	}
	
	function get_blog_page($site_id)
	{
		$query = "SELECT * from blogs where site_id = '$site_id' AND blog_status = 'Published' ";
		$r = $this->db->query($query);
		if ( $r->num_rows() > 0 )
		{
			$result = $r->result_array();
			$result[0]["is_blog"] = 1;
			return $result;
		}
		return false;
	}
	
	function get_reg_frm_menu($site_id=0, $user_id=0, $main_menu_id = 0)
	{
			
			
			 
			if(isset($_SESSION['site_id']) && !isset($site_id))
			{
				$site_id  = $_SESSION['site_id'];
			}
			//echo "<pre>";	print_r($user_id); die();
			$group_id = $this->get_user_group_id ($user_id);
			//print_r($group_id);exit;
			$data = array();
			$rows = array();
			
			
			$this->db->select('form_menu_item_text,form_id,group_id,form_permissions');			
			$this->db->where('site_id',$site_id);
			$this->db->where('menu_id',$main_menu_id);
			$this->db->where('form_delete','0');
			$query = $this->db->get('registration_form');
			
			
			
			 
			if ($query->num_rows() > 0){
			
			   foreach ($query->result_array() as $row ){
				   
					
					
				   if($row['form_permissions'] == 'Level of Access'){
					   
					  
						
						if(isset($_SESSION['login_info']) && isset ($_SESSION['login_info']['customer_id']))
						{	
							$form_group =  $this->is_form_group($row['form_id'],$site_id,$_SESSION['login_info']['customer_id']);
							if($form_group)
							{
								$data[$row['form_id']]['is_regsForm'] = 1;
								$data[$row['form_id']]['title'] = $row['form_menu_item_text'];
								$data[$row['form_id']]['link'] = 'Froms/index/'.$site_id.'/'.$row['form_id']; 
							}
						}   
				   }else if($row['form_permissions'] == 'Registered Users')
				   {
						if(isset ($_SESSION['login_info']) && isset ($_SESSION['login_info']['customer_id']) )
						{
							
								$data[$row['form_id']]['is_regsForm'] = 1;
								$data[$row['form_id']]['title'] = $row['form_menu_item_text'];
								$data[$row['form_id']]['link'] = 'Froms/index/'.$site_id.'/'.$row['form_id']; 
							
						}					          
				   }
				   else if($row['form_permissions'] == 'Every One')
				   {
					   
						$data[$row['form_id']]['is_regsForm'] = 1;
						$data[$row['form_id']]['title'] = $row['form_menu_item_text'];
						$data[$row['form_id']]['link'] = 'Froms/index/'.$site_id.'/'.$row['form_id']; 	
				   }
				 
				}
			 }
			 
			
			 
			//echo "<pre>";	print_r($data); die();
			$query->free_result();
			return $data;
	}
	
	
	/* Webinar Assigned to Main Menu */
	
	function get_top_webinar_items($menu_id)
	{
		$data = array();
		$data_everyone = array();
		$data_rigistered = array();
		$data_other = array();
		
		//All Webiars For All Users
		$qry = "SELECT web.* 
				FROM 
					webinar web,webinar_menus_xref web_xref
				WHERE
					web.id = web_xref.webinar_id
				AND
					web_xref.menu_id = '".$menu_id."'
				AND
					web.webinar_access = 'Everyone'	
					
				AND 
					web.is_deleted = 0
				ORDER BY web.id ASC";
		
		$Q = $this->db->query($qry); 	
		
		
		if ($Q->num_rows() > 0)
		{
			$data_everyone = $Q->result_array();	
		}
		
		//All Webiars For Registered Users
		if(isset($_SESSION['login_info']['customer_id']))
		{
		
			$qry = "SELECT web.* 
					FROM 
						webinar web,webinar_menus_xref web_xref
					WHERE
						web.id = web_xref.webinar_id
					AND
						web_xref.menu_id = '".$menu_id."'
					AND
						web.webinar_access = 'Registered'	
					
					AND 
						web.is_deleted = 0
					ORDER BY web.id ASC";
			
			$Q = $this->db->query($qry); 	
			
			
			if ($Q->num_rows() > 0)
			{
				$data_rigistered = $Q->result_array();	
			}
		}	
		
		
		
		//All Webiars For Other/Group Based Users
		if(isset($_SESSION['customer_group_id']))
		{
//			echo $_SESSION['customer_group_id'];exit;
			
		
			$qry = "SELECT web.* 
					FROM 
						webinar web,webinar_menus_xref web_xref,access_levels_webinar_groups_xref access_level
					WHERE
						web.id = web_xref.webinar_id
					AND
						web_xref.menu_id = '".$menu_id."'
					AND
						web.webinar_access = 'Other'
					AND
						web.id = access_level.webinar_id 
					AND 
						access_level.group_id = '".$_SESSION['customer_group_id']."'	
					AND 
						web.is_deleted = 0			
					ORDER BY web.id ASC";
			
			$Q = $this->db->query($qry); 	
			
			
			if ($Q->num_rows() > 0)
			{
				$data_other = $Q->result_array();	
			}
		}	
		/*echo "<pre>";
		print_r($data_other);
		exit;*/
		//All Webinars
		$data = $data_everyone; 
		
		//All Registered
		if(count($data_rigistered) > 0)
		{
			$data = array_merge($data,$data_rigistered);
		}
		
		//All other group Based
		if(count($data_other) > 0)
		{
			$data = array_merge($data,$data_other);
		}
		return $data;
		
	}
		 
  /*	N~	*/
	function get_font_title($site_id)
	{
		$this->db->where('site_id',$site_id);
		$q = $this->db->get('menus_font');
		if ($q->num_rows() > 0)
		{
			$row = $q->row_array(); 
			$font = $row['font'];
		}
		else
		{
			$font = "default";
		}
		return $font;
		
	}
	function make_menu_top_old ($menu,$mode,$is_seo_enabled="Off",$temp_name)
	{
		if($temp_name == "vantage" )	// if template is vantage return menu array
		{
			return $menu;
		}
		
		$custom_link = $this->db->query("SELECT mi.item_id, item_name, item_status, item_published, item_link, item_target, access_level  FROM menuitems mi JOIN menus_menuitems_xref mix ON mi.item_id=mix.item_id JOIN menus mn ON mn.menu_id=mix.menu_id WHERE mn.menu_id=".$this->db->escape($menu[0]['menu_id'])." AND mi.item_link != '' AND item_status='Active' AND item_published='Yes' ORDER BY display_order ASC");
		$custom_array = $custom_link->result_array();
		
		
	    //echo "<pre>";	print_r($menu);		die();
		$out_put = '<div class="menu4">' . "\n";
		$out_put .= "\n".'<ul>' . "\n";
		$style = "";
		
		$font = $this->get_font_title($_SESSION['site_id']); 
		if($font != "default")
		{
			$style = " style=\"font-family:".$font." !important;\" ";
		}
		
		
		for ( $i = 0; $i < count ( $menu ); $i++ )
		{
			/*	blog menu fix 	*/
			if(array_key_exists("is_blog",$menu[$i]) )
			{
				$menu_id = 0;
				if( $menu[$i]["is_blog"] == 1 )	// if its a webinar menu
				{
					$strLink = base_url().index_page().'blog/index/'.$menu[$i]['site_id'].'/'.$menu[$i]['page_id'].'/'.$menu[$i]['id'];
					$link_caption = "Blog";
					$out_put .= "<li>";
					$out_put .= "<a ".$style." class=\"ui-button  ui-state-default ui-corner-all ui-button-text-icon-primary  link_style\"  href=\" ".$strLink."\">".$link_caption."</a>";
					$out_put .= "</li>";
					
					continue;
				}
				
			}
			/*	blog menu fix 	*/
			
			/*	webinar menu fix 	*/
			if(array_key_exists("is_webinar",$menu[$i]) )
			{
				$menu_id = 0;
				if( $menu[$i]["is_webinar"] == 1 )	// if its a webinar menu
				{
					
					if($is_seo_enabled == "On")
					{
						
						
						$link_caption = $menu[$i]['title'];
						if(!empty($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] == 'localhost')
						{
							$strLink = base_url().index_page().'webinar_site/index/'.$menu[$i]['site_id'].'/'.$menu[$i]['id'];
						}
						else
						{
							$strLink = 'http://'.$_SERVER['HTTP_HOST'].'/webinars/'.str_replace(' ','_', $link_caption).$this->config->item('custom_url_suffix'); 
							
						}
						
						$out_put .= "<li>";
						$out_put .= "<a ".$style." class=\"ui-button  ui-state-default ui-corner-all ui-button-text-icon-primary  link_style\"  href=\" ".$strLink."\">".$link_caption."</a>";
						$out_put .= "</li>";
						continue;
						
					
					}
					else
					{
					
					
						$strLink = base_url().index_page().'webinar_site/index/'.$menu[$i]['site_id'].'/'.$menu[$i]['id'];
						$link_caption = $menu[$i]['title'];
						$out_put .= "<li>";
						$out_put .= "<a ".$style." class=\"ui-button  ui-state-default ui-corner-all ui-button-text-icon-primary  link_style\"  href=\" ".$strLink."\">".$link_caption."</a>";
						$out_put .= "</li>";					
						continue;
					}
				}
				
			}
			/*	webinar menu fix 	*/
			/*	registeration form menu fix 	*/
			if(array_key_exists("is_regsForm",$menu[$i]) )
			{
				
				if( $menu[$i]["is_regsForm"] == 1 )	// if its a webinar menu
				{
					if($is_seo_enabled == "On")
					{
						
						$link_caption = $menu[$i]['title'];
						
						if(!empty($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] == 'localhost')
						{
							$strLink = base_url().$menu[$i]['title'];
						}
						else
						{
							$strLink = 'http://'.$_SERVER['HTTP_HOST'].'/forms/'.str_replace(' ','_', $menu[$i]['title']).$this->config->item('custom_url_suffix'); 
							
						}						
						
					}
					else
					{
						$strLink = base_url().index_page().$menu[$i]['link'];						
					
					}
					
						$out_put .= "<li>";
						$out_put .= "<a ".$style." class=\"ui-button  ui-state-default ui-corner-all ui-button-text-icon-primary  link_style\"  href=\" ".$strLink."\">".$link_caption."</a>";
						$out_put .= "</li>";
						continue;
					
				}
				
			}
			/*	registeration form menu fix 	*/
			
			if(isset($menu[$i]['item_link'])&&!empty($menu[$i]['item_link']))
			{
				
					$link_caption = '';
					if(!empty($menu[$i]['page_title']))
					{
						$link_caption = $menu[$i]['page_title'];
					}
					
	
					$check_http = strstr($menu[$i]['item_link'],"http");
	
					if(!$check_http)
	
					{
	
						$strLink = "http://".$menu[$i]['item_link'];
	
					}
	
					else
	
					{
	
						$strLink = $menu[$i]['item_link'];
	
					}
				
				
				//$out_put .= '<li ><a class="ui-button  ui-state-default ui-corner-all ui-button-text-icon-primary  link_style"  href="' . $strLink . '">'.$menu[$i]['item_name'].'</a>';					
											 
				//$out_put .= '</li>' . "\n";
			}
			else
			{
				//SEO URL Management
				
				if($is_seo_enabled == "On")
				{
					//SEO URL is Given
					
					if($menu[$i]["page_seo_url"] != "")
					{
						
						//echo "<pre>";print_r($_SERVER['HTTP_HOST']);exit;
						if(!empty($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] == 'localhost')
						{
							$strLink = base_url().'pages/'.$menu[$i]['page_seo_url'].$this->config->item('custom_url_suffix');
						}
						else
						{
							$strLink = 'http://'.$_SERVER['HTTP_HOST'].'/'.'pages/'.$menu[$i]['page_seo_url'].$this->config->item('custom_url_suffix');
						}
						
						
						$link_caption = $menu[$i]['item_name'];	
														
					}
					else
					{
						
						$strLink = base_url().'site_preview/page/'.$menu[$i]['site_id'].'/'.$menu[$i]['page_id'];
						$link_caption = $menu[$i]['item_name'];
									
					}
					
				}
				//SEO URL NOT Turned On
				else
				{
					$strLink = base_url().index_page().'site_preview/page/'.$menu[$i]['site_id'].'/'.$menu[$i]['page_id'];
					$link_caption = $menu[$i]['item_name'];			
				}
				if($mode == "edit")		// this condition never works because $mode = preview sin site_preview
				{
					$strLink = 'javascript:void(0);';
					
				}
				
			}       
				
			if( isset($menu[$i]['page_parent']) && $menu[$i]['page_parent'] == 0 )	// if this menu is a perent menu then 
			{
				
				$out_put .= "<li>";
				$out_put .= "<a ".$style." class=\"ui-button  ui-state-default ui-corner-all ui-button-text-icon-primary  link_style\"  href=\" ".$strLink."\">".$link_caption."</a>";
				
				
				$sub_menu = $this->get_childs( $menu, $menu [ $i ]['page_id'],$is_seo_enabled ,$mode,$style);	
				$out_put .= $sub_menu;
				
				
			}
			//else if(isset($menu[$i]['page_parent']) && $menu[$i]['page_parent'] != 0)	// if this menu is sub menu then 
			//{
				/*
				$sub_menu = $this->get_childs( $menu, $menu [ $i ]['page_parent'],$is_seo_enabled ,$mode);	
				//die();
				$out_put .= $sub_menu;
				*/
			//}
			//else
			//{
			//}
			
			
			$out_put .= "</li >";
		   
		}	// end for loop 
		
		
		if(isset($custom_array) && !empty($custom_array))
		{
			foreach($custom_array as $custom)
			{
				
				$link_caption = '';
				if(!empty($custom['item_link']))
				{
					$link_caption = $custom['item_name'];					
					$check_http = strstr($custom['item_link'],"http");	
					if(!$check_http)	
					{	
						$strLink = "http://".$custom['item_link'];	
					}	
					else	
					{	
						$strLink = $custom['item_link'];	
					}
					
					$out_put .= '<li ><a target="'. $custom['item_target'] .'" class="ui-button  ui-state-default ui-corner-all ui-button-text-icon-primary  link_style"  href="' . $strLink . '">'.$custom['item_name'].'</a>';					
												 
					$out_put .= '</li>' . "\n";
						//echo "<pre>"; print_r($custom['item_link']); exit;
				}
			}
	
		}
		
		
		$out_put .= '</ul>'."\n";
		$out_put .= "\n\t" . '</div>';
		
		 // $out_put . "\n\t" . '</div>';
		 
		/* echo  $out_put; 
		 exit(); */
		
		 return $out_put; 
		
	}
	function get_childs ( $menus, $parent_id ,$is_seo_enabled,$mode,$style)
	{
		//echo "hi";	die();
		//$parent_id = 2543;
		//echo "<pre>"; 	print_r( $menus); echo "</pre>"; 
		
		$site_id = $_SESSION['site_id'];
		
		$out_put =""; 
		$menus = array();
		$menu = array();
		
		
		$query = "SELECT * FROM pages AS p
		
		JOIN menuitems_pages_xref mpx ON p.page_id=mpx.page_id
		JOIN menuitems mni ON mni.item_id=mpx.item_id
		WHERE p.site_id='$site_id' AND p.page_parent = '$parent_id' AND p.page_parent != 0 AND p.page_status='Published' 
		";		 
		
		
		$r = $this->db->query($query);
		
		//echo "<pre>"; 	print_r($r->num_rows()); echo "</pre>"; 	
		$i = 1; 
		if ($r->num_rows() > 0 )
		{
			//echo $i;	$i++;
			//echo "<pre>"; 	print_r($r->result_array()); echo "</pre>"; 
			foreach ( $r->result_array() as $row )
			{
				//$menu[] = $row;
				if($row["page_access"] == "Everyone")
				{
					
					$menu[] = $row;	
					
				}
				else if($row["page_access"] == "Registered") 
				{
					
					if(isset($_SESSION['login_info']['customer_id']))
					{
						$menu[] = $row;
					}
				}
				else if($row["page_access"] == "Other")
				{
					if(isset($_SESSION['login_info']['customer_id']))
					{
						
						
						$page_groups = $row['page_groups'];
						$page_user = $row['page_users'];
						// echo $page_groups;
						
						$page_groups_id = explode(",",$page_groups);  
						
						$group_id = $this->get_group_id_by_customer_id($_SESSION['login_info']['customer_id']);
						 
						
						if($page_groups != "" && ( $page_user == "" || $page_user == NULL) ) // for only groups
						{
							if($group_id)
							{
								foreach($group_id as $id )
								{
									if ( in_array($id,$page_groups_id) )
									{
										$menu[] = $row;
										break;
									}
								}
							}
						}
						else if ($page_groups != "" && $page_user != "")  // for members
						{
							
							$page_users_id = explode(",",$page_user);
							$member_id = $_SESSION['login_info']['customer_id'];
							if ( in_array($member_id,$page_users_id) )
							{
								$menu[] = $row;
							}
							
						}
						
					}
					
				}
			}
		}
		else
		{
			return false;
		}
		//echo "<pre>"; 	print_r($menu);	die();
		/*
		foreach ($menus as $val)
		{
			
			if(array_key_exists('item_parent',$val) )
			{
				if($val['page_parent'] == $parent_id)
				{
					$menu[] = $val;
					
				}
				
			}
			
		}
		*/
		//echo "<pre>";
		//print_r($menu);
		//echo "</pre>";
		
		if(count( $menu) > 0) 
		{
			
		$out_put .= '<ul>';
		
		for ( $i = 0; $i < count ( $menu ); $i++ ) 
		{
			$out_put .= "<li>";
			
			/*	webinar menu fix 	*/
			if(array_key_exists("is_webinar",$menu[$i]) )
			{
				$menu_id = 0;
				if( $menu[$i]["is_webinar"] == 1 )	// if its a webinar menu
				{
					$strLink = base_url().index_page().'webinar_site/index/'.$menu[$i]['site_id'].'/'.$menu[$i]['id'];
					$link_caption = $menu[$i]['title'];
					
					$out_put .= "<a class=\"ui-button  ui-state-default ui-corner-all ui-button-text-icon-primary  link_style\"  href=\" ".$strLink."\">".$link_caption."</a>";
					$out_put .= "</li>";
					
					
					continue;
				}
				
			}
			/*	webinar menu fix 	*/
			/*	registeration form menu fix 	*/
			if(array_key_exists("is_regsForm",$menu[$i]) )
			{
				
				if( $menu[$i]["is_regsForm"] == 1 )	// if its a webinar menu
				{
					$strLink = base_url().index_page().$menu[$i]['link'];
					$link_caption = $menu[$i]['title'];
					
					$out_put .= "<a class=\"ui-button  ui-state-default ui-corner-all ui-button-text-icon-primary  link_style\"  href=\" ".$strLink."\">".$link_caption."</a>";
					$out_put .= "</li>";
					
					
					continue;
				}
				
			}
			/*	registeration form menu fix 	*/
			// ??????
			if(isset($menu[$i]['item_link'])&&!empty($menu[$i]['item_link']))
			{
				
					$link_caption = $menu[$i]['page_title'];
	
					$check_http = strstr($menu[$i]['item_link'],"http");
	
					if(!$check_http)
	
					{
	
						$strLink = "http://".$menu[$i]['item_link'];
	
					}
	
					else
	
					{
	
						$strLink = $menu[$i]['item_link'];
	
					}
				
				
				//$out_put .= '<li ><a class="ui-button  ui-state-default ui-corner-all ui-button-text-icon-primary  link_style"  href="' . $strLink . '">'.$menu[$i]['item_name'].'</a>';					
											 
				//$out_put .= '</li>' . "\n";
			}
			else
			{
				//SEO URL Management
				if($is_seo_enabled == "On")
				{
					//SEO URL is Given
						
					
					if($menu[$i]["page_seo_url"] != "")
					{
						
						$strLink = base_url().$menu[$i]['page_seo_url'].$this->config->item('custom_url_suffix');	
						$link_caption = $menu[$i]['page_title'];	
														
					}
					else
					{
						
						$strLink = base_url().'site_preview/page/'.$menu[$i]['site_id'].'/'.$menu[$i]['page_id'];		
						$link_caption = $menu[$i]['item_name'];
									
					}
					
				}
				//SEO URL NOT Turned On
				else
				{
					$strLink = base_url().index_page().'site_preview/page/'.$menu[$i]['site_id'].'/'.$menu[$i]['page_id'];
					$link_caption = $menu[$i]['item_name'];			
				}
				if($mode == "edit")		// this condition never works because $mode = preview sin site_preview
				{
					$strLink = 'javascript:void(0);';
					
				}
				
			}       
				
			
			$out_put .= "<a ".$style." class=\"ui-button  ui-state-default ui-corner-all ui-button-text-icon-primary  link_style\"  href=\" ".$strLink."\">".$link_caption."</a>";
				
					
			$out_put .= "</li>";
		   
		}	// end for loop 
		$out_put .= '</ul>';
		
		
		}
		
		return $out_put; 
		
		
	}
	
   
	  
	function make_menu_top_old_backup($menu,$mode,$is_seo_enabled="Off",$temp_name)
	{
	  //$is_seo_enabled="Off";		// only for testing 
	  //echo '<pre>';  print_r($menu); echo '</pre>';  
	  //  $out_put = '<div >' . "\n";
	  //die();
	  
		/*	~N 		*/
		
		//echo "<pre>"; 	print_r($menu);		die();
		
		if($temp_name == "vantage" )	// if template is vantage return menu array
		{
			return $menu;
		}
		
		/*	~N 		*/
	   
	   
	
		
		$out_put = '    <div class="menu4">' . "\n";
		$out_put .= "\n".'<ul>' . "\n";
		for ( $i = 0; $i < count ( $menu ); $i++ )
		{
			
			if( $menu[$i]['page_parent'] == 0 )	// if this menu is a perent menu then 
			{
				
			$out_put .= "<li >";
			/* for webinar 	*/
			$menu_id = 0;
			if(!isset($menu[$i]["is_webinar"]))
			{
				$menu_id = $menu[$i]['menu_id'];
			}
			/* for webinar end 	*/
			
			if(isset($menu[$i]['item_link'])&&!empty($menu[$i]['item_link']))
			{
				$link_caption = $menu[$i]['page_title'];
				
				$check_http = strstr($menu[$i]['item_link'],"http");
				if(!$check_http)
				{
					$strLink = "http://".$menu[$i]['item_link'];
				}
				else
				{
					$strLink = $menu[$i]['item_link'];
				}
				
				//$out_put .= '<li ><a class="ui-button  ui-state-default ui-corner-all ui-button-text-icon-primary  link_style"  href="' . $strLink . '">'.$menu[$i]['item_name'].'</a>';					
											 
				//$out_put .= '</li>' . "\n";
			}
			else
			{
			
				//SEO URL Management
				if($is_seo_enabled == "On")
				{
					//SEO URL is Given
						
					
					if($menu[$i]["page_seo_url"] != "")
					{
						$strLink = base_url().$menu[$i]['page_seo_url'].$this->config->item('custom_url_suffix');	
						$link_caption = $menu[$i]['page_title'];	
														
					}
					else
					{
						if(isset($menu[$i]["is_webinar"]))
						{
						//echo 
		//							index($site_id,$webinar_id)
							$strLink = base_url().index_page().'webinar_site/index/'.$menu[$i]['site_id'].'/'.$menu[$i]['id'];
							$link_caption = $menu[$i]['item_name'];
							
						}
						$strLink = base_url().'site_preview/page/'.$menu[$i]['site_id'].'/'.$menu[$i]['page_id'];		
						$link_caption = $menu[$i]['item_name'];
									
					}
					
				}
				//SEO URL NOT Turned On
				else
				{
					$strLink = base_url().index_page().'site_preview/page/'.$menu[$i]['site_id'].'/'.$menu[$i]['page_id'];
					$link_caption = $menu[$i]['item_name'];			
				}
				
				
				if($mode == "edit")		// this condition never works because $mode = preview sin site_preview
				{
					$strLink = 'javascript:void(0);';
					
					/* webinar */
					if(isset($menu[$i]["is_webinar"]))
					{
						$link_caption = $menu[$i]['title'];
					}
					else
					{
						$link_caption = $menu[$i]['page_title'];
					}			
					/* webinar end */	
				}
				
				
				
			}       
			
			
				
			$out_put .= "<a class=\"ui-button  ui-state-default ui-corner-all ui-button-text-icon-primary  link_style\"  href=\" ".$strLink."\">".$link_caption."</a>";
			
			
			} 	// if  is a parnet menu end  
			
			
			/***	get sub menus 	***/
			if ( is_array ( $menu [ $i ] ) ) 
			{	// must be by construction but let's keep the errors home
				if ( $menu [ $i ][ 'page_parent' ]  == 0 ) {//are we allowed to see this menu?
			   
					
					//$link_caption = $menu[$i]['item_name'];
	
					if($mode != "edit")
					{
						//$sub_menu = $this->get_childs( $menu, $menu [ $i ]['page_id'],$is_seo_enabled );	
						//$out_put .= $sub_menu;
						
					}
										 
					//$out_put .= '</li>' . "\n";
				}
			}
			
			else 
			{
				die ( sprintf ( 'menu nr %s must be an array', $i ) );            
			}
			
			/***	get sub menus 	***/	
				
				
			$out_put .= "</li >";
			
			
			
		   
		}	// end for loop 
		
		
		
		$out_put .= '</ul>'."\n";
		$out_put .= "\n\t" . '</div>';
		
		 // $out_put . "\n\t" . '</div>';
		 
		/* echo  $out_put; 
		 exit(); */
		
		 return $out_put; 
		
   }
   
/* menu function  by sahil babu    */    
  function make_menu_top($menu,$mode,$is_seo_enabled = "off") // this is the older function 
  {
	  //echo '<pre>';  print_r($menu); echo '</pre>';  
	  //  $out_put = '<div >' . "\n";
		$out_put = '    <div class="menu4">' . "\n";
		$out_put .= "\n".'<ul>' . "\n";
		for ( $i = 0; $i < count ( $menu ); $i++ )
		{
		  
			if(isset($menu[$i]['item_link'])&&!empty($menu[$i]['item_link']))
			{
				$check_http = strstr($menu[$i]['item_link'],"http");
				if(!$check_http)
				{
					$strLink = "http://".$menu[$i]['item_link'];
				}
				else
				{
					$strLink = $menu[$i]['item_link'];
				}
				
				$out_put .= '<li ><a class="ui-button  ui-state-default ui-corner-all ui-button-text-icon-primary  link_style"  href="' . $strLink . '">'.$menu[$i]['item_name'].'</a>';					
											 
				$out_put .= '</li>' . "\n";
			}
			else
			{
				//SEO URL Management
				if($is_seo_enabled == "On")
				{
					//SEO URL is Given
					if($menu[$i]["page_seo_url"] != "")
					{
						$strLink = base_url().$menu[$i]['page_seo_url'].$this->config->item('custom_url_suffix');										
					}
					else
					{
						$strLink = base_url().'site_preview/page/'.$menu[$i]['site_id'].'/'.$menu[$i]['page_id'];					
					}
					
				}
				//SEO URL NOT Turned On
				else
				{
					$strLink = base_url().index_page().'site_preview/page/'.$menu[$i]['site_id'].'/'.$menu[$i]['page_id'];					
				}				
				
				if($mode == "edit")
				{
					$strLink = 'javascript:void(0);';				
				}
				if ( is_array ( $menu [ $i ] ) ) {//must be by construction but let's keep the errors home
					if ( $menu [ $i ][ 'page_parent' ]  == 0 ) {//are we allowed to see this menu?
				   
						$out_put .= '<li ><a class="ui-button  ui-state-default ui-corner-all ui-button-text-icon-primary  link_style"  href="' . $strLink . '">'.$menu[$i]['item_name'].'</a>';
	
						if($mode != "edit")
						{
							$out_put .= $this->get_childs( $menu, $menu [ $i ]['page_id'],$is_seo_enabled );	
						}
											 
						$out_put .= '</li>' . "\n";

					}
				}
				else 
				{
					die ( sprintf ( 'menu nr %s must be an array', $i ) );            
				}
			}         
		   
		}
		
		$out_put .= '</ul>'."\n";
		$out_put .= "\n\t" . '</div>';
		
		 // $out_put . "\n\t" . '</div>';
		 return $out_put; 
		// echo  $out_put; 
		// exit();
		
   }   
/* menu function  by sahil babu    */
	
	function  footer_navigation ($site_id='')
	{
		
		$data = array();
		$Q =$this->db->query("SELECT * FROM pages WHERE site_id=".$this->db->escape($site_id)." AND page_status='Published' AND page_default='Footer' ORDER BY page_id ASC"); 
		if ($Q->num_rows() > 0){
			foreach ($Q->result_array() as $row){
			$data[] = $row;
		   }
		}
		$Q->free_result();
		return $data;  
	}
	
	//Default Login and Register Pages
	
	function get_register_link()
	{
			if(isset ($_SESSION['login_info']) && isset ($_SESSION['login_info']['customer_id']) ){
			
						$login_out[0]['title'] 	= 'My Account';
						$login_out[0]['link'] 	= 'MyAccount/';
						$login_out[1]['title'] 	= 'LogOut';
						$login_out[1]['link'] 	= 'MyAccount/logout';
						$login_out[2]['title'] 	= 'Help Center';
		   				$login_out[2]['link'] 	= 'Help_Center_Home/index';
				  }else
				  {
						$login_out[0]['title']	= 'LogIn';
						$login_out[0]['link'] 	= 'MyAccount/login';
						$login_out[1]['title'] 	= 'Register';
						$login_out[1]['link'] 	= 'MyAccount/register';
						$login_out[2]['title'] 	= 'Help Center';
		   				$login_out[2]['link'] 	= 'Help_Center_Home/index';
				  }
				  
				  return $login_out;
	
	}
	
	
	function  top_navigation_eshop ($site_id='', $user_id='')
	{
	   
	   $other_top_navigation = array ();
	   $help_center = array ();
	   $myshop = array ();
	   $login_out = array ();
	   $registration_form = array ();
	   $promotional_box = array ();
	   $default_cat_id = '';
	   //SEO URLs
		$is_seo_enabled = $this->config->item('seo_url');
		
		
	   if(isset($site_id) && $site_id != '')
	   {
	   		$check_default_ob = $this->db->query("SELECT is_default,cat_id From ec_category Where is_default = 'Yes' AND  site_id = ".$site_id." ORDER BY cat_id DESC");
			$check_default_array = $check_default_ob->result_array();
			if(isset($check_default_array[0]['cat_id']) && $check_default_array[0]['cat_id']!='')
			{
				$default_cat_id =  $check_default_array[0]['cat_id'];
			}
			//echo "<pre>";print_r($check_default_ob->result_array());exit;
	   }
//	   echo  $site_id;exit;
	   if($user_id == "" || $user_id ==0 )
	   {
	   		$user_id = $this->Site_Model->get_user_id_by($site_id);
	   }
	   
	   $package_id = $this->get_user_package($user_id);
	  // echo $package_id.'i am here ...';  exit;
	  // echo $user_id.'= user id ...'; exit();  
		   
			
	   /*if($package_id == '3')
		{*/
		  /* echo "hello";
		   exit();*/
		//}
			//If Seo Url On
			if($is_seo_enabled == 'On')
			{				
				
				$help_center[0]['title'] 	= 'Help Center';				
				$help_center[0]['link'] 	= 'http://'.$_SERVER['HTTP_HOST'].'/help_center/index'.$this->config->item('custom_url_suffix');	
				$ticket[0]['title'] 		= 'Support Ticket';			
				$ticket[0]['link'] 			= 'http://'.$_SERVER['HTTP_HOST'].'/manage_ticket/index'.$this->config->item('custom_url_suffix');	
				
				if($this->isShopRequired($site_id))
				{
				  //echo "here";exit;
				   $myshop[0]['title'] = 'Store';
				   $myshop[0]['link'] = 'MyShop/index/'.$site_id.'/'.$default_cat_id;
				   $myshop[1]['title'] = 'My Cart';
				   $myshop[1]['link'] = 'MyShop/mycart/'.$site_id;
					
				}	
				if(isset ($_SESSION['login_info']) && isset ($_SESSION['login_info']['customer_id']) )
				{
						$login_out[0]['title'] = 'My Account';
						//$login_out[0]['link'] = 'MyAccount/index/'.$site_id.'/'.$default_cat_id;
						$login_out[0]['link'] = 'http://'.$_SERVER['HTTP_HOST'].'/myaccount/index'.$this->config->item('custom_url_suffix'); 
						$login_out[1]['title'] = 'LogOut';
						//$login_out[1]['link'] = 'MyAccount/logout';
						$login_out[1]['link'] = 'http://'.$_SERVER['HTTP_HOST'].'/myaccount/logout'.$this->config->item('custom_url_suffix');		
						
				}
				else
				{
						$login_out[0]['title'] = 'LogIn';
						//$login_out[0]['link'] = 'MyAccount/login/'.$site_id;
						$login_out[0]['link'] = 'http://'.$_SERVER['HTTP_HOST'].'/myaccount/login'.$this->config->item('custom_url_suffix'); 
						$login_out[1]['title'] = 'Register';
						//$login_out[1]['link'] = 'MyAccount/register/'.$site_id;
						$login_out[1]['link'] = 'http://'.$_SERVER['HTTP_HOST'].'/myaccount/register'.$this->config->item('custom_url_suffix');
				}
			}
			else
			{
				
				$help_center[0]['title'] = 'Help Center';
				$help_center[0]['link'] = 'Help_Center_Home/index';		
				$ticket[0]['title'] = 'Support Ticket';
				$ticket[0]['link'] = 'ticket/index/'.$site_id; 
				
				if($this->isShopRequired($site_id))
				{
				  //echo "here";exit;
				   $myshop[0]['title'] = 'Store';
				   $myshop[0]['link'] = 'MyShop/index/'.$site_id.'/'.$default_cat_id;
				   $myshop[1]['title'] = 'My Cart';
				   $myshop[1]['link'] = 'MyShop/mycart/'.$site_id;
					
				}	
				if(isset ($_SESSION['login_info']) && isset ($_SESSION['login_info']['customer_id']) )
				{
						$login_out[0]['title'] = 'My Account';
						$login_out[0]['link'] = 'MyAccount/index/'.$site_id.'/'.$default_cat_id;
						$login_out[1]['title'] = 'LogOut';
						$login_out[1]['link'] = 'MyAccount/logout';
				}
				else
				{
						$login_out[0]['title'] = 'LogIn';
						$login_out[0]['link'] = 'MyAccount/login/'.$site_id;
						$login_out[1]['title'] = 'Register';
						$login_out[1]['link'] = 'MyAccount/register/'.$site_id;
				}	
			
			}
			   
			$registration_form = array();
			$result_one = array_merge($help_center,$myshop,$ticket);
			$result_second = array_merge($result_one,$login_out);
			//echo $site_id."--".$user_id;exit;
			$registration_form = $this->get_reg_frm_menu($site_id,$user_id);
			//echo '<pre>';   print_r($registration_form); echo '</pre>';    exit(); 
			$result = array_merge($result_second,$registration_form);
			$other_top_navigation =   $result;
			/*echo "<pre>";
			print_r($other_top_navigation);
			exit;*/
			return   $other_top_navigation;
	}	
	
	function get_user_package ($id=0)
	{
			$rows = array();
			$pakage = '';
			$this->db->select('package_id');
		   // $this->db->where('user_id',intval($id));
		   // $Q = $this->db->get('user_packages_xref');
			$query = $this->db->get_where('user_packages_xref', array('user_id' => intval($id)));  
			$packageData = $query->result_array();
			$package_id = $packageData[0]["package_id"]; 
		   // echo  $package_id.'>>>>>>>>>>';  exit();
		   return  $package_id;
			
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
	
	function isShopRequired ($site_id=0)
	{
			$rows = array();
			$this->db->select('required');
		   // $this->db->where('user_id',intval($id));
		   // $Q = $this->db->get('user_packages_xref');
			$query = $this->db->get_where('site_store_settings', array('site_id' => intval($site_id)));  
			$Data = $query->result_array();
		   // print_r($Data[0]["required"]); exit();  
			if(array_key_exists(0,$Data)){
				if ($Data[0]["required"]== 'Yes')
					{
						return true; 
					}
			}else
				{
					return false;   
				}
	}
	
	function is_form_group($form_id, $site_id, $customer_id)
	{
		//get Logged In Customer Group 
		$group_id = $this->customers_model->getCustomerGroupID($customer_id);
		$result = $this->db->query('select * from access_levels_reg_form_groups_xref where form_id='.$form_id.' and site_id='. $site_id.' and group_id = '.$group_id);
		$data = $result->result_array();
		if(count($data) > 0)
		{
			return true;
		}
		return false;				
	}
			
	
	
	function setting_exist ($sit_id=0,$menu_id=0)
	{
		//echo $id.'>>>>>>>>>>>>>';
			$rows = array();
			$scheme_id = 0;
			$this->db->select('scheme_id');
			$this->db->where('site_id',intval($menu_id));
			$this->db->where('menu_id',intval($id));
			$query = $this->db->get('menu_color');
			//$query = $this->db->get_where('user_packages_xref', array('user_id' => intval($id)));  
			 if ($query->num_rows() > 0){
			   $row = $query->result_array(); 
				 // echo '%%%%%'.$row['membershipid'].'%%%';
						$scheme_id = $row['scheme_id'];
			 } 
			 
		 // echo $gruop_id.': >>>>>>>>>>>>>>>> '; exit();
		  return $scheme_id; 
	}
	function change_color_scheme($site_id=0)
	{
		$menu_id = intval($this->input->post('cat_name')); 
		
	  if($this->setting_exist($sit_id,$menu_id))
	  { 
		  
		$data = array(
			'site_id' =>  intval($this->input->post('cat_name')),
			'menu_id' =>  intval($this->input->post('short_desc')),
			'primary_color' =>  $this->input->post('long_desc'),
			'secondary_color' =>  $this->input->post('status'),
			'tertiary_color' =>  $this->input->post('parentid'),
			'primary_txt' => $this->input->post('members'),
			'secondary_txt' => $this->input->post('members'),
			'tertiary_txt' => $this->input->post('members'),
			'default' => $this->input->post('members')
		 );  
	  }
	  else
	  {
		 $data = array(
			'site_id' =>  $this->input->post('cat_name'),
			'menu_id' =>  $this->input->post('short_desc'),
			'primary_color' =>  $this->input->post('long_desc'),
			'secondary_color' =>  $this->input->post('status'),
			'tertiary_color' =>  intval($this->input->post('parentid')),
			'primary_txt' => intval($this->input->post('members')),
			'secondary_txt' => intval($this->input->post('members')),
			'tertiary_txt' => intval($this->input->post('members')),
			'default' => intval($this->input->post('members'))
 
			 );   
		  
	  } 
	  
	  $this->db->where('cat_id', intval($this->input->post('id')));
	  $this->db->update('ec_category', $data);
		
		
	}
	
	function get_scheme_color ($site_id=0)
	{
	   //  echo '<pre>';  print_r($_POST); echo 'I am here ';  echo '</pre>'; exit();
		//echo $id.'>>>>>>>>>>>>>';
			$rows = array();
			$scheme = array();
		   // $this->db->select('scheme_id');
			$this->db->where('site_id',intval($site_id));
			//$this->db->where('menu_id',intval($id));
			$query = $this->db->get('menu_color');
			//$query = $this->db->get_where('user_packages_xref', array('user_id' => intval($id)));  
			 if ($query->num_rows() > 0){
			   $row = $query->result_array(); 
						$scheme = $row[0];
					  //  $scheme = $scheme[0];
			 } 
			 
		 // echo $gruop_id.': >>>>>>>>>>>>>>>> '; exit();
		  return $scheme; 
	}
	
	
	
	
	
	
	//move up the selected menu in the db / display
	function moveUp($site_id, $menu_order)
	{
		
		
		$new_order = $menu_order - 1; 
		
		// get above order 
		$Q = "SELECT menu_order FROM menus WHERE menu_order < ".$this->db->escape($menu_order)." AND menu_status != 'Deleted' AND site_id=".$this->db->escape($site_id)." ORDER BY menu_order DESC LIMIT 1 ";
		$r = $this->db->query($Q);
		$menu = $r->row_array();
		$above_menu_order = $menu['menu_order']; 
		
		
		$qryRecordAbove = "SELECT menu_id FROM menus WHERE menu_order=".$this->db->escape($above_menu_order)." AND site_id=".$this->db->escape($site_id);
		$rsltRecordAbove = $this->db->query($qryRecordAbove);
		$rowRecordAbove = $rsltRecordAbove->row_array();
		$above_menu_id = $rowRecordAbove['menu_id'];
		
		
		
		$qryUpdateRecord = "UPDATE menus SET menu_order=".$this->db->escape($new_order)." WHERE menu_order=".$this->db->escape($menu_order)." AND site_id=".$this->db->escape($site_id);
		
		$rsltUpdateRecord = $this->db->query($qryUpdateRecord);
		
		$qryUpdateRecordAbove = "UPDATE menus SET menu_order=".$this->db->escape($menu_order)." WHERE menu_id=".$this->db->escape($above_menu_id)." AND site_id=".$this->db->escape($site_id);
		$rsltUpdateRecordAbove = $this->db->query($qryUpdateRecordAbove);
		
		return true;    
	}
	
	//move down the selected menu in the db / display
	function moveDown($site_id, $menu_order)
	{
		 
		$new_order = $menu_order + 1;
		// get above order 
		$Q = "SELECT menu_order FROM menus WHERE menu_order > ".$this->db->escape($menu_order)." AND menu_status != 'Deleted' AND site_id=".$this->db->escape($site_id)." ORDER BY menu_order ASC LIMIT 1 ";
		$r = $this->db->query($Q);
		$menu = $r->row_array();
		$below_menu_order = $menu['menu_order']; 
		
		
		
		$qryRecordBelow = "SELECT menu_id FROM menus WHERE menu_order=".$this->db->escape($below_menu_order)." AND site_id=".$this->db->escape($site_id);
		//echo $qryRecordBelow;exit;
		$rsltRecordBelow = $this->db->query($qryRecordBelow);
		$rowRecordBelow = $rsltRecordBelow->row_array();
		$below_menu_id = $rowRecordBelow['menu_id'];
		
		$qryUpdateRecord = "UPDATE menus SET menu_order=".$this->db->escape($new_order)." WHERE menu_order=".$this->db->escape($menu_order)." AND site_id=".$this->db->escape($site_id);
		$rsltUpdateRecord = $this->db->query($qryUpdateRecord);
		
		$qryUpdateRecordBelow = "UPDATE menus SET menu_order=".$this->db->escape($menu_order)." WHERE menu_id=".$this->db->escape($below_menu_id)." AND site_id=".$this->db->escape($site_id);
		$rsltUpdateRecordBelow = $this->db->query($qryUpdateRecordBelow);
		
		return true;        
	}
	
	function getItemPageTitle($item_id)
	{
		$qry = "SELECT pgs.page_title FROM pages pgs JOIN menuitems_pages_xref ipx ON pgs.page_id=ipx.page_id WHERE ipx.item_id=".$this->db->escape($item_id);
   //  echo $qry;
	//  exit; 
		$rslt = $this->db->query($qry);
		$row = $rslt->row_array();
		if(isset($row['page_title']))
		{
			return $row['page_title'];    
		}
		return true;
		
	}
	
	function getParent_title($item_id)
	{
		$q = "SELECT  pgs.page_title, pgs.page_parent FROM pages pgs JOIN menuitems_pages_xref ipx ON pgs.page_id=ipx.page_id WHERE ipx.item_id=".$this->db->escape($item_id);
	  
		$rs = $this->db->query($q);
		$r = $rs->row_array();
		// if custom link is update and array become empty then not go in this loop
		if(!empty($r))
		{
		   $parent_id =  $r['page_parent'];
			if( $parent_id !=0 ){
				$qry = "SELECT page_title , page_id FROM pages WHERE page_id=".$this->db->escape($parent_id);
				$rslt = $this->db->query($qry);
				$row = $rslt->row_array();
				return $row;   
				
			}else
			{
				$row['page_title'] = 'None'; 
				$row['page_id'] = '0'; 
				return $row; 
			}
		}
		else
		{
				$row['page_title'] = 'None'; 
				$row['page_id'] = '0'; 
				return $row; 
		}
		
	}
	
	
	function is_main_menu($site_id, $menu_id)
	{
		$qry_is_main_menu = "SELECT menu_id FROM menus
		WHERE menu_id=".$this->db->escape($menu_id)." AND site_id=".$this->db->escape($site_id)." AND is_main_menu='Yes'";
		
		$rslt_is_main_menu = $this->db->query($qry_is_main_menu);
		
		if( $rslt_is_main_menu->num_rows() > 0 )
		{
			return true;
		}
		else
		{
			return false;
		}
	} 
	
	// 28 March - Mohsin	This function will fetch the register form links to be placed in selected menu. Either main menu, leftbar or rightbar
	function fetch_reg_frm_menu($site_id=0, $user_id=0, $menu_id=0)
	{
		$group_id = $this->get_user_group_id($user_id);
		$data = array();
		$rows = array();
		$this->db->select('form_menu_item_text,form_id,group_id,form_permissions');			
		$this->db->where('site_id',intval($site_id));
		$this->db->where('menu_id',intval($menu_id));
		$this->db->where('form_delete','0');
		$query = $this->db->get('registration_form');
		if ($query->num_rows() > 0){
		   foreach ($query->result_array() as $row ){
			   if($row['form_permissions'] == 'Level of Access'){
					if(isset($_SESSION['login_info']) && isset ($_SESSION['login_info']['customer_id']))
					{	
						$form_group =  $this->is_form_group($row['form_id'],$_SESSION['site_info'][0]['site_id'],$_SESSION['login_info']['customer_id']);
						if($form_group)
						{
								$data[$row['form_id']]['title'] = $row['form_menu_item_text'];
								$data[$row['form_id']]['link'] = 'Froms/index/'.$site_id.'/'.$row['form_id']; 										
						}
					}   
			   }else if($row['form_permissions'] == 'Registered Users')
			   {
					if(isset ($_SESSION['login_info']) && isset ($_SESSION['login_info']['customer_id']) )
					{
						if($_SESSION['user_info']['user_id'])
						{
								$data[$row['form_id']]['title'] = $row['form_menu_item_text'];
								$data[$row['form_id']]['link'] = 'Froms/index/'.$site_id.'/'.$row['form_id']; 
						}
					}					          
			   }
			   else if($row['form_permissions'] == 'Every One')
			   {
					$data[$row['form_id']]['title'] = $row['form_menu_item_text'];
					$data[$row['form_id']]['link'] = 'Froms/index/'.$site_id.'/'.$row['form_id'];  
			   }
			 
			}
		 }
		$query->free_result();
		return $data;
	}
	// 28 March - Mohsin
	
	//28 March - Mohsin 	***	This will fetcg id of main menu of current site to be used for the form links fetching ***
	function fetch_main_menu_id($site_id)
	{
		$q = "SELECT menu_id FROM menus WHERE site_id = '".$site_id."' AND is_main_menu = 'Yes' ";
		$r = mysql_query($q);
		while($row = mysql_fetch_assoc($r))
		{
			$val = $row;
		}
		return $val; 
	}	
	//28 March - Mohsin	
		// 5 April - 2012
		
					/* Make Main Menu - Florist*/    
	
  function make_menu_top_florist($menu,$mode,$is_seo_enabled="Off")
  {
	  //echo '<pre>';  print_r($menu); echo '</pre>';  exit;
	  //  $out_put = '<div >' . "\n";
		$out_put = '    <div class="menu4">' . "\n";
		$out_put .= "\n".'<ul>' . "\n";
		for ($i=0; $i<count($menu); $i++)
		{
		  
			if(isset($menu[$i]['item_link']) && !empty($menu[$i]['item_link']))
			{
				$check_http = strstr($menu[$i]['item_link'],"http");
				if(!$check_http)
				{
					$strLink = "http://".$menu[$i]['item_link'];
				}
				else
				{
					$strLink = $menu[$i]['item_link'];
				}
				
				$out_put .= '<li ><a class="ui-button  ui-state-default ui-corner-all ui-button-text-icon-primary  link_style"  href="' . $strLink . '">'.$menu[$i]['item_name'].'</a>';					
											 
				$out_put .= '</li>' . "\n";
			}
			else
			{
				//SEO URL Management
				if($is_seo_enabled == "On")
				{
					//echo "condition true";
					//exit;
					//SEO URL is Given
					if($menu[$i]["page_seo_url"] != "")
					{
						//echo "condition true";
						//exit;
						//$strLink = base_url().$menu[$i]['page_seo_url'];
						$strLink = base_url().'index.php/site_preview/page/'.$menu[$i]['site_id'].'/'.$menu[$i]['page_id'];										
					}
					else
					{
						$strLink = base_url().'index.php/site_preview/page/'.$menu[$i]['site_id'].'/'.$menu[$i]['page_id'];					
					}
					
				}
				//SEO URL NOT Turned On
				else
				{
					$strLink = base_url().index_page().'site_preview/page/'.$menu[$i]['site_id'].'/'.$menu[$i]['page_id'];					
				}
				
				
				if($mode == "edit")
				{
					$strLink = 'javascript:void(0);';				
				}
				
				if(is_array($menu[$i])) 
				{//must be by construction but let's keep the errors home
					if($menu[$i]['page_parent'] == 0 ) 
					{//are we allowed to see this menu?
				   
							$out_put .= '<li ><a class="ui-button  ui-state-default ui-corner-all ui-button-text-icon-primary  link_style"  href="'.$strLink.'">'.$menu[$i]['item_name'].'</a>';
	
						if($mode != "edit")
						{
							$out_put .= $this->get_childs_florist($menu, $menu[$i]['page_id'], $is_seo_enabled );	
						}
											 
						$out_put .= '</li>' . "\n";
					}
				}
				else 
				{
					die ( sprintf ( 'menu nr %s must be an array', $i ) );            
				}
			}         
		   
		}
		
		$out_put .= '</ul>'."\n";
		$out_put .= "\n\t" . '</div>';
		
		// $out_put . "\n\t" . '</div>';
		 return $out_put; 
		// echo  $out_put; 
		// exit();
		
   }
	
	function get_childs_florist ( $menu, $el_id, $is_seo_enabled = "Off" )
	{
		
		$has_subcats = FALSE;
		$out_put = '';
		$out_put .= "\n".'    <ul>' . "\n";
		for ($i = 0; $i < count($menu); $i++ )
		{
			 
			if(isset($menu[$i]['item_link'])&&!empty($menu[$i]['item_link']))
			{
				$check_http = strstr($menu[$i]['item_link'],"http");
				if(!$check_http)
				{
					$strLink = "http://".$menu[$i]['item_link'];
				}
				else
				{
					$strLink = $menu[$i]['item_link'];
				}
				$out_put .= '<li ><a class="ui-button  ui-state-default ui-corner-all ui-button-text-icon-primary  link_style"  href="' . $strLink . '">'.$menu[$i]['item_name'].'</a>';					
											 
				$out_put .= '</li>' . "\n";
			}
			else
			{
				//SEO URL Management
				if($is_seo_enabled == "On")
				{
					//SEO URL is Given
					if($menu[$i]["page_seo_url"] != "")
					{
						//$strLink = base_url().$menu[$i]['page_seo_url'];
						$strLink = base_url().'index.php/site_preview/page/'.$menu[$i]['site_id'].'/'.$menu[$i]['page_id'];										
					}
					else
					{
						$strLink = base_url().'index.php/site_preview/page/'.$menu[$i]['site_id'].'/'.$menu[$i]['page_id'];					
					}
					
				}
				//SEO URL NOT Turned On
				else
				{
					$strLink = base_url().index_page().'site_preview/page/'.$menu[$i]['site_id'].'/'.$menu[$i]['page_id'];					
				}
				if ($menu[$i]['page_parent'] == $el_id ) {//are we allowed to see this menu?
				$has_subcats = TRUE;                             
			   // $add_class = ( $this->get_childs ( $menu, $i ) != FALSE ) ? 'subsubl' : '';
				
				$out_put .= '<li ><a class="ui-button  ui-state-default ui-corner-all ui-button-text-icon-primary  link_style"  href="' . $strLink . '">'.$menu[$i]['item_name'].'</a>';
				$out_put .= '</li>' . "\n";
				
				}
			
			}	             
		}
		$out_put .= '    </ul>'."\n";
		return ( $has_subcats ) ? $out_put : FALSE;
	}	
	
				/* Make Main Menu - Florist*/
		
		
		
		function update_menuItem_order($item_ids)
		{
			$r = false;
			foreach ($item_ids as $key => $menuItemID ) {
				$this->db->where("item_id",$menuItemID);
				$data = array("display_order" => $key);
				$r = $this->db->update("menuitems",$data);
				
			}
			return $r;
		}
		
		function get_menu_selected_pages($menu_id)
		{
			
			
			$this->db->select("page_id");
			$this->db->where("menu_id",$menu_id);
			$r = $this->db->get("menus_pages_xref");
			
			if($r->num_rows() > 0)
			{
				foreach(  $r->result_array() as $page_ids )
				{
					$selected_pages_ids[] = $page_ids['page_id'];
				}
				return $selected_pages_ids;
			}
			return false;
		}
         function get_registartion_menue($site_id)
        {
              $this->db->select("*");
            $this->db->where("site_id",$site_id);
            $r = $this->db->get("registration_form");
            
            if($r->num_rows() > 0)
            {
                foreach(  $r->result_array() as $page_ids )
                {
                    $selected_pages_menue[] = $page_ids;
                }
                return $selected_pages_menue;
            }
            return false;
        }
	       
}
?>
