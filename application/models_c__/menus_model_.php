<?php
class Menus_Model extends CI_Model{
	//Constructor for this model
	function Menus_Model(){
		parent::__construct(); 
		$this->load->database();        
	}
	
	//returns all menus records belonging to site_id
	//used in pagesController(functions: create_page, )
	function getAllMenus($site_id){
		return $this->db->query("SELECT * FROM menus WHERE site_id=".$this->db->escape($site_id)." AND menu_status NOT IN('Deleted') ORDER BY menu_id ASC");
	}
	
	//updates menus record in DB
	function updateMenu(){
	    
        $id = $this->input->post("id");
		$strName = $this->input->post("txtName");
		$strPosition = $this->input->post("rdoPosition");
        $strPublished = $this->input->post("rdoPublished");
		
		if($strPublished == "Schedule")
        {
			$dateStart = date('Y-m-d h:i:s', strtotime($this->input->post("startDate")));        
			$dateEnd = date('Y-m-d h:i:s', strtotime($this->input->post("endDate")));
		}else
        {
			$dateStart = "";        
			$dateEnd = "";
		}
		$strPages = $this->input->post("rdoPages");
		$strRights = $this->input->post("rdoRights");
		$intNumItems = $this->input->post("numItems");
		
		$this->db->query("UPDATE menus SET menu_name=".$this->db->escape($strName).", menu_position=".$this->db->escape($strPosition).", menu_published=".$this->db->escape($strPublished).", menu_start=".$this->db->escape($dateStart).", menu_end=".$this->db->escape($dateEnd).", menu_pages=".$this->db->escape($strPages).", menu_access=".$this->db->escape($strRights)." WHERE menu_id=".$id);
		
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
			$this->db->query("DELETE FROM menus_pages_xref WHERE menu_id=".$id);
		}
		
		if($strRights=='Other'){
			 $this->db->query("DELETE FROM menus_roles_xref WHERE menu_id=".$id);
			 $arrRoles = $this->input->post("lstRoles");
			 for($i=0; $i<sizeof($arrRoles);$i++){
				$this->db->query("INSERT INTO menus_roles_xref(menu_id, role_id) VALUES(".$this->db->escape($id).", ".$this->db->escape($arrRoles[$i]).")");
			}            
		}
		else
        {
			$this->db->query("DELETE FROM menus_roles_xref WHERE menu_id=".$id);
		}
		
		if($intNumItems>0)
        {
			$this->db->query("DELETE FROM menuitems_pages_xref WHERE item_id IN(SELECT item_id FROM menus_menuitems_xref WHERE menu_id=".$this->db->escape($id).")");
			
			$this->db->query("DELETE FROM menuitems WHERE item_id IN(SELECT item_id FROM menus_menuitems_xref WHERE menu_id=".$this->db->escape($id).")");
			
			$this->db->query("DELETE FROM menus_menuitems_xref WHERE menu_id=".$this->db->escape($id));
				
			for( $i=1; $i<=$intNumItems; $i++ )
            {
				if(isset($_POST['txtItemName'.$i]) && isset($_POST['lstItemPage'.$i]) && isset($_POST['rdoItemPublished'.$i]))
                {
					if($_POST['txtItemName'.$i]!='' && $_POST['lstItemPage'.$i]!='0' && $_POST['rdoItemPublished'.$i]!='')
                    {
                        $strItemName = $_POST['txtItemName'.$i];
                        $strItemPage = $_POST['lstItemPage'.$i];
                        $strPublished = $_POST['rdoItemPublished'.$i];    
                        
                        $this->db->query("INSERT INTO menuitems(item_name, item_published, item_status) VALUES(".$this->db->escape($strItemName).",  ".$this->db->escape($strPublished).", 'Active')");
                        
                        $intItemId = $this->db->insert_id();
                        $this->db->query("INSERT INTO menus_menuitems_xref(menu_id, item_id) VALUES(".$this->db->escape($id).", ".$this->db->escape($intItemId).")");
                        
                        $this->db->query("INSERT INTO menuitems_pages_xref(item_id, page_id) VALUES(".$this->db->escape($intItemId).", ".$this->db->escape($strItemPage).")");    
                    }
                }//end if
			}//end for           
		}
		else{
			$this->db->query("DELETE FROM menuitems_pages_xref WHERE item_id IN(SELECT item_id FROM menus_menuitems_xref WHERE menu_id=".$this->db->escape($id).")");
			
			$this->db->query("DELETE FROM menuitems WHERE item_id IN(SELECT item_id FROM menus_menuitems_xref WHERE menu_id=".$this->db->escape($id).")");
			
			$this->db->query("DELETE FROM menus_menuitems_xref WHERE menu_id=".$this->db->escape($id));
		}//end else   
        
        return true;  
		 
	}
    
    function updateMainMenu()
    {
        
        /*echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        
        exit();*/
        
        $id = $this->input->post("id"); 
        
        $intNumItems = $this->input->post("numItems");
        
        $this->db->query("DELETE FROM menuitems_pages_xref WHERE item_id IN(SELECT item_id FROM menus_menuitems_xref WHERE menu_id=".$this->db->escape($id).")");
            
        $this->db->query("DELETE FROM menuitems WHERE item_id IN(SELECT item_id FROM menus_menuitems_xref WHERE menu_id=".$this->db->escape($id).")");
        
        $this->db->query("DELETE FROM menus_menuitems_xref WHERE menu_id=".$this->db->escape($id)); 
        
        if($intNumItems>0)
        {
            for( $i=1; $i<=$intNumItems; $i++ )
            {
                if(isset($_POST['txtItemName'.$i]) && isset($_POST['lstItemPage'.$i]) && isset($_POST['rdoItemPublished'.$i]))
                {
                    if($_POST['txtItemName'.$i]!='' && $_POST['lstItemPage'.$i]!='0' && $_POST['rdoItemPublished'.$i]!='')
                    {
                        $strItemName = $_POST['txtItemName'.$i];
                        $strItemPage = $_POST['lstItemPage'.$i];
                        $strPublished = $_POST['rdoItemPublished'.$i];    
                        $parent_id = $_POST['parent_id'.$i]; 
                        
      //  [lstItemPage1] => 1127
      //  [parent_id1] => 0   
                        
                        $this->db->query("INSERT INTO menuitems(item_name, item_published, item_status) VALUES(".$this->db->escape($strItemName).",  ".$this->db->escape($strPublished).", 'Active')");
                        
                        $intItemId = $this->db->insert_id();
                        $this->db->query("INSERT INTO menus_menuitems_xref(menu_id, item_id) VALUES(".$this->db->escape($id).", ".$this->db->escape($intItemId).")");
                        
                        $this->db->query("INSERT INTO menuitems_pages_xref(item_id, page_id) VALUES(".$this->db->escape($intItemId).", ".$this->db->escape($strItemPage).")");  
                      $q = "Update pages SET page_parent =".$this->db->escape($parent_id)." WHERE  page_id= ".$this->db->escape($strItemPage);
                    $this->db->query($q); 
               //
                //exit(); 
                    }
                }//end if
            }//end for                                 
        }
        
        return true;
            
    }
	
	//gets menus information from db
	function menuInfo($id){
		return $result = $this->db->query("SELECT * FROM menus WHERE menu_id=".$this->db->escape($id)." AND menu_status='Active' ORDER BY menu_id");        
	}
	
	//gets menu item information from db
	function menuItemsInfo($id){
		return $result = $this->db->query("SELECT * FROM menuitems mni JOIN menus_menuitems_xref mmx ON mmx.item_id=mni.item_id JOIN menus mnu ON mnu.menu_id=mmx.menu_id  WHERE mnu.menu_id=".$id." ORDER BY mni.item_id");
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
		if(isset($_SESSION['user_info']))
		{
			$user_id = $_SESSION['user_info']['user_id'];
		}
		else
		{
			$user_id = 0;    
		}
		if($menu_pages == "All")
		{
			if($access == "Other")
			{
				return $this->db->query("SELECT * FROM menus mnu
					JOIN menus_roles_xref mrx ON mrx.menu_id=mnu.menu_id 
					JOIN roles rol ON rol.role_id=mrx.role_id 
					WHERE mnu.menu_access='Other'
					AND mnu.site_id=".$this->db->escape($site_id)."
					AND mnu.menu_status='Active'
					AND mnu.menu_pages='All' 
					AND rol.role_id IN(SELECT role_id FROM user_role_xref WHERE user_id=".$this->db->escape($user_id).")
					AND mnu.menu_published IN ('Yes', 'Schedule')
                    AND mnu.menu_position IN ('Left', 'Right')");        
				
			} 
			else
			{
				return $this->db->query("SELECT * FROM menus mnu 
					WHERE mnu.menu_access=".$this->db->escape($access)." 
					AND mnu.site_id=".$this->db->escape($site_id)."
					AND mnu.menu_status='Active'
					AND mnu.menu_pages='All' 
                    AND mnu.menu_published IN ('Yes', 'Schedule')
                    AND mnu.menu_position IN ('Left', 'Right')");    
			}   
		}
		else{
			if($access == "Other")
			{   
				return $this->db->query("SELECT * FROM menus mnu
					JOIN menus_pages_xref mpx ON mpx.menu_id=mnu.menu_id
					JOIN pages pgs ON pgs.page_id=mpx.page_id
					JOIN menus_roles_xref mrx ON mrx.menu_id=mnu.menu_id 
					JOIN roles rol ON rol.role_id=mrx.role_id 
					WHERE pgs.page_id=".$this->db->escape($page_id)." 
					AND mnu.site_id=".$this->db->escape($site_id)."
					AND mnu.menu_access='Other'
					AND mnu.menu_status='Active'
					AND mnu.menu_pages='Other' 
					AND rol.role_id IN(SELECT role_id FROM user_role_xref WHERE user_id=".$this->db->escape($user_id).")
					AND mnu.menu_published IN ('Yes', 'Schedule')
                    AND mnu.menu_position IN ('Left', 'Right')");    
			} 
			else
			{   
				if($user_id != 0)
				{
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
					$site_id = 0;
					return $this->db->query("SELECT * FROM menus mnu
					WHERE menu_position IN ('Left', 'Right') AND mnu.site_id=".$this->db->escape($site_id));
				}
					
			}             
		}    
	}
	
	//gets all menus assigned to a page, position and access
	function getPageMenus($site_id, $page_id, $position, $access, $menu_pages){ 
	
		if($menu_pages == "All")
		{
			if($access == "Other")
			{
				if(isset($_SESSION['user_info']))
				{
					$user_id = $_SESSION['user_info']['user_id'];
				}
				else
				{
					$user_id = 0;    
				}
				return $this->db->query("SELECT * FROM menus mnu
					JOIN menus_roles_xref mrx ON mrx.menu_id=mnu.menu_id 
					JOIN roles rol ON rol.role_id=mrx.role_id 
					WHERE mnu.menu_position=".$this->db->escape($position)."
					AND mnu.menu_access='Other'
					AND mnu.site_id=".$this->db->escape($site_id)."
					AND mnu.menu_status='Active'
					AND mnu.menu_pages='All' 
					AND rol.role_id IN(SELECT role_id FROM user_role_xref WHERE user_id=".$this->db->escape($user_id).")
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
				if(isset($_SESSION['user_info']))
				{
					$user_id = $_SESSION['user_info']['user_id'];
				}
				else
				{
					$user_id = 0;    
				}   
				
				return $this->db->query("SELECT * FROM menus mnu
					JOIN menus_pages_xref mpx ON mpx.menu_id=mnu.menu_id
					JOIN pages pgs ON pgs.page_id=mpx.page_id
					JOIN menus_roles_xref mrx ON mrx.menu_id=mnu.menu_id 
					JOIN roles rol ON rol.role_id=mrx.role_id 
					WHERE mnu.menu_position=".$this->db->escape($position)."
					AND pgs.page_id=".$this->db->escape($page_id)." 
					AND mnu.site_id=".$this->db->escape($site_id)."
					AND mnu.menu_access='Other'
					AND mnu.menu_status='Active'
					AND mnu.menu_pages='Other' 
					AND rol.role_id IN(SELECT role_id FROM user_role_xref WHERE user_id=".$this->db->escape($user_id).")
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
		/*if($menu_pages == "All")
		{
			if($access == "Other")
			{
				return $this->db->query("SELECT * FROM menus mnu
					JOIN menus_roles_xref mrx ON mrx.menu_id=mnu.menu_id 
					JOIN roles rol ON rol.role_id=mrx.role_id 
					WHERE mnu.menu_position=".$this->db->escape($position)." 
					AND mnu.site_id=".$this->db->escape($site_id)."
					AND mnu.menu_access='Other'
					AND mnu.menu_status='Active'
					AND mnu.menu_pages='All' 
					AND rol.role_id=".$this->db->escape($this->session->userdata("role_id"))." 
					AND mnu.menu_published IN ('Yes', 'Schedule')");    
			} 
			else
			{
				return $this->db->query("SELECT * FROM menus mnu 
					WHERE mnu.menu_position=".$this->db->escape($position)." 
					AND mnu.site_id=".$this->db->escape($site_id)."
					AND mnu.menu_access=".$this->db->escape($access)." 
					AND mnu.menu_status='Active'
					AND mnu.menu_pages='All' AND mnu.menu_published IN ('Yes', 'Schedule')");    
			}   
		}
		else{
			if($access == "Other")
			{
				return $this->db->query("SELECT * FROM menus mnu
					JOIN menus_pages_xref mpx ON mpx.menu_id=mnu.menu_id
					JOIN pages pgs ON pgs.page_id=mpx.page_id
					JOIN menus_roles_xref mrx ON mrx.menu_id=mnu.menu_id 
					JOIN roles rol ON rol.role_id=mrx.role_id 
					WHERE mnu.menu_position=".$this->db->escape($position)."
					AND mnu.site_id=".$this->db->escape($site_id)."
					AND pgs.page_id=".$this->db->escape($page_id)." 
					AND mnu.menu_access='Other'
					AND mnu.menu_status='Active'
					AND mnu.menu_pages='Other' 
					AND rol.role_id=".$this->db->escape($this->session->userdata("role_id"))." 
					AND mnu.menu_published IN ('Yes', 'Schedule')");    
			} 
			else
			{                
				return $this->db->query("SELECT * FROM menus mnu
					JOIN menus_pages_xref mpx ON mpx.menu_id=mnu.menu_id
					JOIN pages pgs ON pgs.page_id=mpx.page_id                    
					WHERE mnu.menu_position=".$this->db->escape($position)."
					AND mnu.site_id=".$this->db->escape($site_id)."
					AND pgs.page_id=".$this->db->escape($page_id)." 
					AND mnu.menu_access=".$this->db->escape($access)."
					AND mnu.menu_status='Active'
					AND mnu.menu_pages='Other'                   
					AND mnu.menu_published IN ('Yes', 'Schedule')");    
			}             
		}*/      
				
	}
	
	//gets menu items assigned to a given menu
	function getMenuItem($menu_id){
		return $this->db->query("SELECT mi.item_id, item_name, item_status, item_published FROM menuitems mi JOIN menus_menuitems_xref mix ON mi.item_id=mix.item_id JOIN menus mn ON mn.menu_id=mix.menu_id WHERE mn.menu_id=".$this->db->escape($menu_id)." AND item_status='Active' AND item_published='Yes' ORDER BY item_id ASC");        
	}
	
	//gets all pages
	function getPages($site_id){
		return $this->db->query("SELECT page_id, page_title ,page_parent  FROM pages WHERE site_id=".$this->db->escape($site_id)." AND page_status NOT IN('Deleted') ORDER BY page_id");
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
		
        $totalMenus = $this->totalMenus($site_id);
        $menu_order = $totalMenus + 1;
        
		$this->db->query("INSERT INTO menus(menu_name ,menu_position ,menu_published ,menu_status ,menu_start ,menu_end ,menu_pages ,menu_access, menu_order, site_id, parent_menu) 
        VALUES (".$this->db->escape($strName).", ".$this->db->escape($strPosition).", ".$this->db->escape($strPublished).", 'Active',
        ".$this->db->escape($dateStart).", ".$this->db->escape($dateEnd).", ".$this->db->escape($strPages).",
        ".$this->db->escape($strRights).", ".$this->db->escape($menu_order).", ".$this->db->escape($site_id).",
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
			$arrRoles = $this->input->post("lstRoles");
			for($i=0; $i<sizeof($arrRoles);$i++){
				$this->db->query("INSERT INTO menus_roles_xref(menu_id, role_id) VALUES(".$this->db->escape($intMenuId).", ".$this->db->escape($arrRoles[$i]).")");
			}            
		}
		if($intNumItems>0)
        {
			for($i=1; $i<=$intNumItems;$i++)
            {
				if($this->input->post("txtItemName".$i)!="" && $this->input->post("lstItemPage".$i)!="" && $this->input->post("rdoItemPublished".$i)!=""){
					$strItemName = $this->input->post("txtItemName".$i);
					$strItemPage = $this->input->post("lstItemPage".$i);
					$strPublished = $this->input->post("rdoItemPublished".$i);
					$this->db->query("INSERT INTO menuitems(item_name, item_published, item_status) VALUES(".$this->db->escape($strItemName).",  ".$this->db->escape($strPublished).", 'Active')");
					
					$intItemId = $this->db->insert_id();
					$this->db->query("INSERT INTO menus_menuitems_xref(menu_id, item_id) VALUES(".$this->db->escape($intMenuId).", ".$this->db->escape($intItemId).")");
					
					$this->db->query("INSERT INTO menuitems_pages_xref(item_id, page_id) VALUES(".$this->db->escape($intItemId).", ".$this->db->escape($strItemPage).")");                    
				}
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
		return $this->db->query("SELECT * FROM menus WHERE menu_status NOT IN('Deleted') AND site_id=".$this->db->escape($site_id)." ORDER BY menu_order ASC LIMIT ".$from.", ".$intPageLimit);
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
	
	
	
	function  top_navigation_default ($site_id = '')
	{
		
	  // $package_id = $this->get_user_package($site_id);
	  // if($package_id == '3')

		$data = array();
		
        $qry = "SELECT * FROM pages pgs
        JOIN menuitems_pages_xref mpx ON pgs.page_id=mpx.page_id
        JOIN menuitems mni ON mni.item_id=mpx.item_id
        JOIN menus_menuitems_xref mmx ON mmx.item_id=mni.item_id
        JOIN menus mnu ON mnu.menu_id=mmx.menu_id  
        WHERE pgs.site_id=".$this->db->escape($site_id)." AND pgs.page_status='Published' 
        AND mnu.is_main_menu='Yes' AND mni.item_published='Yes'
        ORDER BY mni.item_id ASC";
        
        //echo $qry;exit;
        
        $Q = $this->db->query($qry); 
		
        ///$Q =$this->db->query("SELECT * FROM pages WHERE site_id=".$this->db->escape($site_id)." AND page_status='Published' AND page_default NOT IN ('Not Default', 'Footer') ORDER BY page_id ASC");
        
        if ($Q->num_rows() > 0)
        {
			foreach ($Q->result_array() as $row)
            {
			$data[] = $row;
		   }
		}
		
       // echo '<pre>';  print_r($data); echo '</pre>'; exit();
         
        $Q->free_result();
		
        // $menu = $this->make_menu_top($data);
		//Fetching Data for Webinar Top Navigation
		if(count($data) > 0)
		{
			$main_menu_id = $data[0]["menu_id"];
			//echo $main_menu_id;//exit;
			
			$top_webinars = $this->get_top_webinar_items($main_menu_id);
		//	echo "<pre>";
		//	print_r($top_webinars);
		//	exit;
		}
		
		if(count($top_webinars) > 0)
		{
			$data = array_merge($data,$top_webinars);
		}
         return $menu; 
	}
    

/* menu function  by sahil babu    */    
    
  function make_menu_top ($menu)
  {
      //echo '<pre>';  print_r($menu); echo '</pre>';  
      //  $out_put = '<div >' . "\n";
        $out_put = '    <div class="menu4">' . "\n";
        $out_put .= "\n".'<ul>' . "\n";

        for ( $i = 0; $i < count ( $menu ); $i++ )
        {
          
            $strLink = base_url().'index.php/site_preview/page/'.$menu[$i]['site_id'].'/'.$menu[$i]['page_id'];
            if ( is_array ( $menu [ $i ] ) ) {//must be by construction but let's keep the errors home
                if ( $menu [ $i ][ 'page_parent' ]  == 0 ) {//are we allowed to see this menu?
               
                    $out_put .= '<li ><a class="ui-button  ui-state-default ui-corner-all ui-button-text-icon-primary  link_style"  href="' . $strLink . '">'.$menu[$i]['item_name'].'</a>';

                    $out_put .= $this->get_childs( $menu, $menu [ $i ]['page_id'] );
                                         
                    $out_put .= '</li>' . "\n";
                }
            }
            else {
                die ( sprintf ( 'menu nr %s must be an array', $i ) );
            }
           
        }
        
        $out_put .= '</ul>'."\n";
        $out_put .= "\n\t" . '</div>';
        
         // $out_put . "\n\t" . '</div>';
         return $out_put; 
        // echo  $out_put; 
        // exit();
        
   }
    function get_childs ( $menu, $el_id )
    {
        $has_subcats = FALSE;
        $out_put = '';
        $out_put .= "\n".'    <ul>' . "\n";
        for ( $i = 0; $i < count ( $menu ); $i++ )
        {
             $strLink = base_url().'index.php/site_preview/page/'.$menu[$i]['site_id'].'/'.$menu[$i]['page_id'];

            if (  $menu [ $i ][ 'page_parent' ] == $el_id ) {//are we allowed to see this menu?
                $has_subcats = TRUE;
                             
               // $add_class = ( $this->get_childs ( $menu, $i ) != FALSE ) ? 'subsubl' : '';
                
                $out_put .= '        <li ><a class="ui-button  ui-state-default ui-corner-all ui-button-text-icon-primary  link_style"  href="' . $strLink . '">'.$menu[$i]['item_name'].'</a>';
                $out_put .= '</li>' . "\n";
                
            }
        }
        $out_put .= '    </ul>'."\n";
        return ( $has_subcats ) ? $out_put : FALSE;
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
	
	function  top_navigation_eshop ($site_id='', $user_id='')
	{
       $other_top_navigation = array ();
       $help_center = array ();
       $myshop = array ();
       $login_out = array ();
       $registration_form = array ();
	   $promotional_box = array ();
       
	   $package_id = $this->get_user_package($user_id);
	  // echo $package_id.'i am here ...';  
	  // echo $user_id.'= user id ...'; exit();  
           $help_center[0]['title'] = 'Help Center';
           $help_center[0]['link'] = 'Help_Center_Home/index';  
            
	   if($package_id == '3')
		{
           
			
			if($this->isShopRequired($site_id))
			{
			   $myshop[0]['title'] = 'Store';
			   $myshop[0]['link'] = 'MyShop';
			   $myshop[1]['title'] = 'My Cart';
			   $myshop[1]['link'] = 'MyShop/mycart';
                if(isset ($_SESSION['login_info']) && isset ($_SESSION['login_info']['customer_id']) ){
                        $login_out[0]['title'] = 'My Account';
                        $login_out[0]['link'] = 'MyAccount/';
                        $login_out[1]['title'] = 'LogOut';
                        $login_out[1]['link'] = 'MyAccount/logout';
                  }else
                  {
                        $login_out[0]['title'] = 'LogIn';
                        $login_out[0]['link'] = 'MyAccount/login';
                        $login_out[1]['title'] = 'Register';
                        $login_out[1]['link'] = 'MyAccount/register';
                  }
               

			}
		   
		}
        
            $result_one = array_merge($help_center,$myshop);
            $result_second = array_merge($result_one,$login_out);
        
	// echo '<pre>';   print_r($result_one); echo '</pre>';    exit(); 
       
       
           $registration_form = $this->get_reg_frm_menu($site_id,$user_id);
           $result = array_merge($result_second,$registration_form);
       
           $other_top_navigation =   $result;
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
    
    function get_reg_frm_menu ($site_id=0, $user_id=0)
    {
            $group_id = $this->get_user_group_id ($user_id); 
        
            $data = array();
            $rows = array();
            $this->db->select('form_menu_item_text,form_id,group_id,form_permissions');
            
            $this->db->where('site_id',intval($site_id));
            $this->db->where('menu_id','0');
            $this->db->where('form_delete','0');
            $query = $this->db->get('registration_form');
           // $query = $this->db->get_where('registration_form', array('user_id' => intval($id)));  
            if ($query->num_rows() > 0){
               foreach ($query->result_array() as $row ){
               //   echo $row['form_id'].'<><><>'.$row['group_id'].'== '. $group_id;
               //  echo $row['form_permissions']."*************".$row['form_id'].'<><><>'.$row['group_id'].'== '. $group_id;   
               
                   if($row['form_permissions'] == 'Level of Access'){
                        if($row['group_id'] == $group_id){
                            $data[$row['form_id']]['title'] = $row['form_menu_item_text'];
                            $data[$row['form_id']]['link'] = 'Froms/index/'.$row['form_id']; 
                           // echo 'Level of Access'; exit();    
                        }     
                   }else if($row['form_permissions'] == 'Registered Users'){
                       if($_SESSION['user_info']['user_id']){
                            $data[$row['form_id']]['title'] = $row['form_menu_item_text'];
                            $data[$row['form_id']]['link'] = 'Froms/index/'.$row['form_id']; 
                            //echo 'Registered Users'; exit();    
                        }       
                   }else if($row['form_permissions'] == 'Every One'){
                        $data[$row['form_id']]['title'] = $row['form_menu_item_text'];
                        $data[$row['form_id']]['link'] = 'Froms/index/'.$row['form_id']; 
                        //echo 'Every One'; exit();    
                   }
                 
                }
             }
             
            // echo '<pre>'; print_r($data); echo '</pre>'; exit(); 
            $query->free_result();
            return $data;
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
        $new_order = $menu_order--;
        $qryRecordAbove = "SELECT menu_id FROM menus WHERE menu_order=".$this->db->escape($new_order)." AND site_id=".$this->db->escape($site_id);
        $rsltRecordAbove = $this->db->query($qryRecordAbove);
        $rowRecordAbove = $rsltRecordAbove->row_array();
        $menu_id = $rowRecordAbove['menu_id'];
        
        $qryUpdateRecord = "UPDATE menus SET menu_order=".$this->db->escape($new_order)." WHERE menu_order=".$this->db->escape($menu_order)." AND site_id=".$this->db->escape($site_id);
        $rsltUpdateRecord = $this->db->query($qryUpdateRecord);
        
        $qryUpdateRecordAbove = "UPDATE menus SET menu_order=".$this->db->escape($menu_order)." WHERE menu_id=".$this->db->escape($menu_id)." AND site_id=".$this->db->escape($site_id);
        $rsltUpdateRecordAbove = $this->db->query($qryUpdateRecordAbove);
        
        return true;    
    }
    
    //move down the selected menu in the db / display
    function moveDown($site_id, $menu_order)
    {
        $new_order = $menu_order++;
        $qryRecordBelow = "SELECT menu_id FROM menus WHERE menu_order=".$this->db->escape($new_order)." AND site_id=".$this->db->escape($site_id);
        //echo $qryRecordBelow;exit;
        $rsltRecordBelow = $this->db->query($qryRecordBelow);
        $rowRecordBelow = $rsltRecordBelow->row_array();
        $menu_id = $rowRecordBelow['menu_id'];
        
        $qryUpdateRecord = "UPDATE menus SET menu_order=".$this->db->escape($new_order)." WHERE menu_order=".$this->db->escape($menu_order)." AND site_id=".$this->db->escape($site_id);
        $rsltUpdateRecord = $this->db->query($qryUpdateRecord);
        
        $qryUpdateRecordBelow = "UPDATE menus SET menu_order=".$this->db->escape($menu_order)." WHERE menu_id=".$this->db->escape($menu_id)." AND site_id=".$this->db->escape($site_id);
        $rsltUpdateRecordBelow = $this->db->query($qryUpdateRecordBelow);
        
        return true;        
    }
    
    function getItemPageTitle($item_id)
    {
        $qry = "SELECT pgs.page_title FROM pages pgs JOIN menuitems_pages_xref ipx ON pgs.page_id=ipx.page_id WHERE ipx.item_id=".$this->db->escape($item_id);
        $rslt = $this->db->query($qry);
        $row = $rslt->row_array();
        return $row['page_title'];
    }
    
    function getParent_title($item_id)
    {
        $q = "SELECT  pgs.page_title, pgs.page_parent FROM pages pgs JOIN menuitems_pages_xref ipx ON pgs.page_id=ipx.page_id WHERE ipx.item_id=".$this->db->escape($item_id);
        $rs = $this->db->query($q);
        $r = $rs->row_array();
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
}?>
