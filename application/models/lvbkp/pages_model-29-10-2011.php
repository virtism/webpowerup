<?php
class Pages_Model extends CI_Model{
	//Constructor
	function Pages_Model(){
		parent::__construct();
		$this->load->database();     
	}    
	
	//this function creates five default pages of a site
	function create_default_pages($site_id)
	{
		//db fields common to all default pages
		$page_seo_url = "";
		$page_create_date = date('Y-m-d h:i:s');
		$page_modified_date = date('Y-m-d h:i:s');
		$page_status = "Published";
		$page_show_title  = "Yes";
		$page_header = "Default";
		$page_keywords = "";
		$page_desc = "";
		$page_background = "Default";
		$page_start_date = "";
		$page_end_date = "";
		$page_access = "Everyone";
		
		//db fields which differ in different pages will be set for each dafault page
		//list / array of pages to be craeted
		$page_title = array(
						"Home",
						"Company",
						"About Us",
						"Contact Us",
						"FAQ",
						"Site Map"
						);
		$page_ishomepage = "";
		
		//execute the query for number of default pages defined in above array $page_title
		for($i=0; $i<sizeof($page_title); $i++)
		{
			$page_code = $site_id."-".$page_title[$i];
			if($page_title[$i] == "Home")
			{
				$page_ishomepage = "Yes";        
			}
			else
			{
				$page_ishomepage = "No";    
			}
			//prepare the query
			$qryCreatePage = "INSERT INTO pages(site_id, page_title, page_default, page_seo_url, page_code, page_create_date, page_modified_date, 
				page_status, page_show_title, page_ishomepage, page_header, page_keywords, page_desc, page_background, page_start_date,
				page_end_date, page_access) 
				VALUES(".$this->db->escape($site_id).", ".$this->db->escape($page_title[$i]).", 'Default', ".$this->db->escape($page_seo_url).",
				".$this->db->escape($page_code).", ".$this->db->escape($page_create_date).", ".$this->db->escape($page_modified_date).",
				".$this->db->escape($page_status).", ".$this->db->escape($page_show_title).", ".$this->db->escape($page_ishomepage).",
				".$this->db->escape($page_header).", ".$this->db->escape($page_keywords).", ".$this->db->escape($page_desc).",
				".$this->db->escape($page_background).", ".$this->db->escape($page_start_date).", ".$this->db->escape($page_end_date).", 
				".$this->db->escape($page_access).")";
			//execute the query
			$this->db->query($qryCreatePage);
		}
		return;
	}
	
	function isPageItemMenu($item_id, $menu_id)
	{
		$result = $this->db->query("SELECT * FROM menus_menuitems_xref WHERE item_id=".$this->db->escape($item_id)." AND menu_id=".$this->db->escape($menu_id));    
		if($result->num_rows()>0)
		{
			return true;    
		}
		else
		{
			return false;   
		}
	}
	function isPageAlready($site_id, $page_title)
	{
		
		if(isset($_POST['page_id']))
		{
			$qry = "SELECT * FROM pages WHERE site_id=".$this->db->escape($site_id)." AND page_title=".$this->db->escape($page_title)." AND page_id NOT IN(".$this->db->escape($_POST['page_id']).")";          
		}
		else
		{
			$qry = "SELECT * FROM pages WHERE site_id=".$this->db->escape($site_id)." AND page_title=".$this->db->escape($page_title);
		}
		$result = $this->db->query($qry);  
		//echo $qry;
		//$result = $this->db->query("SELECT * FROM pages WHERE site_id=".$this->db->escape($site_id)." AND page_title=".$this->db->escape($page_title)); 
		if($result->num_rows()>0)
		{
			return TRUE;
		}  
		else
		{
			return FALSE;
		}
	}
	
	function isPageUpdateExist($site_id, $page_id, $page_title)
	{
		$result = $this->db->query("SELECT * FROM pages WHERE site_id=".$this->db->escape($site_id)." AND page_title=".$this->db->escape($page_title)." AND page_id NOT IN(".$this->db->escape($page_id).")"); 
		if($result->num_rows()>0)
		{
			return TRUE;
		}  
		else
		{
			return FALSE;
		}
	}
	
	function updatePage(){
		$page_id = $this->input->post("page_id");   
		$page_header = $this->input->post("page_header");        
		$page_background = $this->input->post("page_background");
		$page_title = $this->input->post("page_title"); 
		$page_keywords = $this->input->post("page_keywords"); 
		$page_desc = $this->input->post("page_desc");
		$page_access = $this->input->post("page_access");
		
		$page_status = $this->input->post("page_status");   
		$page_start_date = "";
		$page_end_date = "";
		if($page_status == "Schedule"){
			$page_start_date = date('Y-m-d h:i:s', strtotime($this->input->post("page_start_date")));
			$page_end_date = date('Y-m-d h:i:s', strtotime($this->input->post("page_end_date")));    
		}
		
		if($this->input->post("page_show_title") == "Yes"){
			$page_show_title ="Yes";    
		}
		else{
			$page_show_title = "No";
		}
				
		$page_modified_date = date('Y-m-d h:i:s');        
		
		if($page_header == "Other")
		{
			$this->db->query("DELETE FROM headers WHERE header_id IN(SELECT header_id FROM pages_headers_xref WHERE page_id=".$this->db->escape($page_id).")");
			$this->db->query("DELETE FROM pages_headers_xref WHERE page_id=".$this->db->escape($page_id));
			$header_image = $this->input->post("DateTime").$_FILES["header_image"]["name"];
			$this->db->query("INSERT INTO headers(header_image, header_status) VALUES(".$this->db->escape($header_image).", 'Active')"); 
			$header_id = $this->db->insert_id();
			$this->db->query("INSERT INTO pages_headers_xref(page_id, header_id) VALUES(".$this->db->escape($page_id).", ".$this->db->escape($header_id).")");                  
		} 
		else if($page_header == "Current")
		{
			$page_header = "Other";    
		}
		else if($page_header == "Default")
		{
			$this->db->query("DELETE FROM headers WHERE header_id IN(SELECT header_id FROM pages_headers_xref WHERE page_id=".$this->db->escape($page_id).")");
			$this->db->query("DELETE FROM pages_headers_xref WHERE page_id=".$this->db->escape($page_id));    
		} 
		
		if($page_header == "Slideshow")
		{
			$numHeaderImages = $this->input->post("numHeaderImages");
			for($i=1;$i<=$numHeaderImages;$i++)
			{
				
				if($_FILES["header_image_".$i]["name"]!="")
				{
					$header_image = $this->input->post("DateTime").$_FILES["header_image_".$i]["name"];
					$this->db->query("INSERT INTO headers(header_image, header_status) VALUES(".$this->db->escape($header_image).", 'Active')");
			
					$header_id = $this->db->insert_id();
					$this->db->query("INSERT INTO pages_headers_xref(header_id, page_id) VALUES(".$this->db->escape($header_id).", ".$this->db->escape($page_id).")");    
				}    
			}
				
		}
		//$background_area = "content";
		//$background_style = "stretch";
		/*if($this->input->post('background_area')!="")
		{
			 $background_area = $this->input->post('background_area');
		}
		if($this->input->post('background_style')!="")
		{
			$background_style = $this->input->post('background_style');     
		} */
		if($page_background == "Other"){
			$background_area = $this->input->post('new_background_area');
			$background_style = $this->input->post('new_background_style');
			$this->db->query("DELETE FROM backgrounds WHERE background_id IN(SELECT background_id FROM pages_backgrounds_xref WHERE page_id=".$this->db->escape($page_id).")");
			$this->db->query("DELETE FROM pages_backgrounds_xref WHERE page_id=".$this->db->escape($page_id));
			$background_image = $this->input->post("DateTime").$_FILES["background_image"]["name"];
			$this->db->query("INSERT INTO backgrounds(background_image, background_area, background_style, background_status) VALUES(".$this->db->escape($background_image).", ".$this->db->escape($background_area).", ".$this->db->escape($background_style).", 'Active')"); 
			$background_id = $this->db->insert_id();
			$this->db->query("INSERT INTO pages_backgrounds_xref(page_id, background_id) VALUES(".$this->db->escape($page_id).", ".$this->db->escape($background_id).")");                  
		} 
		else if($page_background == "Current"){
			$page_background = "Other";
			$background_area = $this->input->post('background_area');
			$background_style = $this->input->post('background_style');     
			
			$rsltBackgroundId = $this->db->query('SELECT bkg.background_id FROM pages_backgrounds_xref pbx JOIN backgrounds bkg ON pbx.background_id=bkg.background_id WHERE pbx.page_id='.$this->db->escape($page_id));
			$rowBackgroundId =  $rsltBackgroundId->row_array();
			$background_id =   $rowBackgroundId['background_id'];
			$this->db->query('UPDATE backgrounds SET background_area='.$this->db->escape($background_area).', background_style='.$this->db->escape($background_style).' WHERE background_id='.$this->db->escape($background_id));    
		}
		else if($page_background == "Default"){
			$this->db->query("DELETE FROM backgrounds WHERE background_id IN(SELECT background_id FROM pages_backgrounds_xref WHERE page_id=".$this->db->escape($page_id).")");
			$this->db->query("DELETE FROM pages_backgrounds_xref WHERE page_id=".$this->db->escape($page_id));    
		} 
		
		$this->db->query("UPDATE pages SET page_header=".$this->db->escape($page_header).", page_background=".$this->db->escape($page_background).",
		page_title=".$this->db->escape($page_title).", page_show_title=".$this->db->escape($page_show_title).", page_keywords=".$this->db->escape($page_keywords).",
		page_desc=".$this->db->escape($page_desc).", page_status=".$this->db->escape($page_status).", page_start_date=".$this->db->escape($page_start_date).",
		page_end_date=".$this->db->escape($page_end_date).", page_modified_date=".$this->db->escape($page_modified_date).",
		page_access=".$this->db->escape($page_access)." WHERE page_id=".$this->db->escape($page_id));
		
		$rsltItemId = $this->db->query("SELECT * FROM menuitems_pages_xref WHERE page_id=".$this->db->escape($page_id));
		
		$item_name = $this->input->post("item_name");
		if($rsltItemId->num_rows()>0)
		{
			
			$rowItemId = $rsltItemId->row_array();
			$item_id = $rowItemId["item_id"];
			
			$this->db->query("DELETE FROM menus_menuitems_xref WHERE item_id=".$this->db->escape($item_id));         
			//echo "<pre>";
			//print_r($this->input->post("menu_id")); exit;
			if($this->input->post("menu_id")){
				$menu_id = $this->input->post("menu_id");
				for($i=0; $i<sizeof($menu_id);$i++){
					$this->db->query("INSERT INTO menus_menuitems_xref(menu_id, item_id) VALUES(".$this->db->escape($menu_id[$i]).", ".$this->db->escape($item_id).")");
				}
			}               
		}
		else
		{   
			//echo "<pre>";
			//print_r($_POST["menu_id"]);exit();
			$this->db->query("INSERT INTO menuitems(item_name, item_published, item_status) VALUES(".$this->db->escape($item_name).", 'Yes', 'Active')");
			$item_id = $this->db->insert_id();
			
			if($this->input->post("menu_id")){
				$menu_id = $this->input->post("menu_id");
				//echo $item_id;exit();
				for($i=0; $i<sizeof($menu_id);$i++){
					//echo "INSERT INTO menus_menuitems_xref(menu_id, item_id) VALUES(".$this->db->escape($menu_id[$i]).", ".$this->db->escape($item_id).")";exit();
					$this->db->query("INSERT INTO menus_menuitems_xref(menu_id, item_id) VALUES(".$this->db->escape($menu_id[$i]).", ".$this->db->escape($item_id).")");
					
				}
			}
			
			$this->db->query("INSERT INTO menuitems_pages_xref(item_id, page_id) VALUES(".$this->db->escape($item_id).", ".$page_id.")");    
		}
		
		
		
		if($this->input->post("sameas_page_title") == "Yes")
		{            
			$this->db->query("UPDATE menuitems SET item_name=".$this->db->escape($page_title)." WHERE item_id=".$this->db->escape($item_id));        
		}
		else
		{
			$item_name = $this->input->post("item_name");
			$this->db->query("UPDATE menuitems SET item_name=".$this->db->escape($item_name)." WHERE item_id=".$this->db->escape($item_id));
		}
		
		$this->db->query("DELETE FROM pages_roles_xref WHERE page_id=".$this->db->escape($page_id));
		
		if($this->input->post("role_id")){
			$role_id = $this->input->post("role_id");
			for($i=0; $i<sizeof($role_id);$i++){
				$this->db->query("INSERT INTO pages_roles_xref(role_id, page_id) VALUES(".$this->db->escape($role_id[$i]).", ".$this->db->escape($page_id).")");
			}    
		} 
		
		$page_content = $_POST["page_content"];
		$this->db->query("UPDATE page_content SET page_content=".$this->db->escape($page_content)." WHERE page_id=".$this->db->escape($page_id)); 
		//exit();                
	}
	
	function getPageContent($page_id){ 
		return $this->db->query("SELECT * FROM page_content WHERE page_id=".$this->db->escape($page_id));
	}
	
	function get_page_content($page_id)
	{
		$qryPageContent = "SELECT * FROM page_content_controls WHERE page_id=".$this->db->escape($page_id)." ORDER BY id ASC";
		return $this->db->query($qryPageContent);
	}
	
	
	function isPageforUser($page_id, $user_id)
	{
		 //echo "SELECT * FROM pages_roles_xref WHERE page_id=".$this->db->escape($page_id)." AND role_id IN(SELECT role_id FROM user_role_xref WHERE user_id=".$this->db->escape($user_id).")";exit;
		 $result = $this->db->query("SELECT * FROM pages_roles_xref WHERE page_id=".$this->db->escape($page_id)." AND role_id IN(SELECT role_id FROM user_role_xref WHERE user_id=".$this->db->escape($user_id).")");
		 if($result->num_rows()>0){
			 return TRUE;
		 }
		 else{
			return FALSE;
		 }    
	}
	function isPageRole($page_id, $role_id){
		 $result = $this->db->query("SELECT * FROM pages_roles_xref WHERE page_id=".$this->db->escape($page_id)." AND role_id=".$this->db->escape($role_id));
		 if($result->num_rows()>0){
			 return TRUE;
		 }
		 else{
			return FALSE;
		 }
	}
	
	function pageInfo($id){
		$page_id = $id;
		return $this->db->query("SELECT * FROM pages WHERE page_id=".$this->db->escape($page_id));
	}
	
	function getHeaderInfo($id){
		$qryHeaderInfo = "SELECT * FROM headers hdr JOIN pages_headers_xref phx ON phx.header_id=hdr.header_id 
		JOIN pages pgs ON pgs.page_id=phx.page_id WHERE pgs.page_id=".$this->db->escape($id);
		return $this->db->query($qryHeaderInfo);
	}
	
	function getOtherHeaderInfo($page_id)
	{
		$qryOtherHeaderInfo = "SELECT * FROM headers hdr JOIN pages_headers_xref phx ON phx.header_id=hdr.header_id 
		JOIN pages pgs ON pgs.page_id=phx.page_id WHERE pgs.page_id=".$this->db->escape($page_id)." AND hdr.is_header='Yes'";
		return $this->db->query($qryOtherHeaderInfo);    
	}
	function getSlideshowHeaderInfo($page_id)
	{
		$qrySlideshowHeaderInfo = "SELECT * FROM headers hdr JOIN pages_headers_xref phx ON phx.header_id=hdr.header_id 
		JOIN pages pgs ON pgs.page_id=phx.page_id WHERE pgs.page_id=".$this->db->escape($page_id)." AND hdr.is_header='No'";
		return $this->db->query($qrySlideshowHeaderInfo);    
	}
	
	function deleteHeader($id)
	{
		//delete header image from server
		$qryHeaderImage = "SELECT header_image FROM headers WHERE header_id=".$this->db->escape($id);
		$rsltHeaderImage = $this->db->query($qryHeaderImage);
		$rowHeaderImage = $rsltHeaderImage->row_array();
		$header_image = './headers/'.$rowHeaderImage['header_image'];
		if(file_exists($header_image))
		{
			$action = unlink($header_image);        
		}
		
		//delete header image from db
		$this->db->query("DELETE FROM headers WHERE header_id=".$this->db->escape($id));
		$this->db->query("DELETE FROM pages_headers_xref WHERE header_id=".$this->db->escape($id));
	}
								  
	function getBackgroundInfo($id){
		$qryBackgroundInfo = "SELECT * FROM backgrounds bkg JOIN pages_backgrounds_xref pbx ON pbx.background_id=bkg.background_id 
		JOIN pages pgs ON pgs.page_id=pbx.page_id WHERE pgs.page_id=".$id;
		return $this->db->query($qryBackgroundInfo);
	}
	
	function isPageMenu($page_id, $menu_id){
		$qryPageMenu = "SELECT mnu.menu_id FROM menus mnu JOIN menus_menuitems_xref mmx ON mmx.menu_id=mnu.menu_id
		JOIN menuitems mni ON mni.item_id=mmx.item_id
		JOIN menuitems_pages_xref mpx ON mni.item_id=mpx.item_id
		JOIN pages pgs ON pgs.page_id=mpx.page_id WHERE pgs.page_id=".$page_id." AND mnu.menu_id=".$menu_id;
		//$qryPageMenu = "SELECT * FROM menus_menuitems_xref WHERE page_id=".$page_id." AND menu_id=".$menu_id;
		$rsltPageMenu = $this->db->query($qryPageMenu); 
		if($rsltPageMenu->num_rows()>0){
			return TRUE;
		}   
		else{
			return FALSE;
		}
	}
	function getPageItem($id){
		$qryPageItem = "SELECT * FROM menuitems mni JOIN menuitems_pages_xref mpx ON mpx.item_id=mni.item_id
		JOIN pages pgs ON pgs.page_id=mpx.page_id WHERE pgs.page_id=".$id;   
		return $this->db->query($qryPageItem);
	}
	
	function isHomepageExist($site_id)
	{
		$result = $this->db->query("SELECT page_id FROM pages WHERE page_ishomepage='Yes' AND site_id=".$this->db->escape($site_id));
		if($result->num_rows()>0)
		{
			return FALSE;
		}    
		else
		{
			return TRUE;
		}
	}
	//input: page info in array $arrPageInfo
	//output: NULL
	//process: Adds new page info in DB
	function addPage(){
		
		
		$site_id = $this->input->post("site_id"); 
		$page_title = $this->input->post("page_title");
		if($this->input->post("page_show_title")=='Yes')
		{
			$page_show_title = "Yes";
		}
		else
		{
			$page_show_title = "No";           
		}        
		$page_seo_url = $this->input->post("page_seo_url");
		$page_code = $site_id.":".$page_title;
		
		if($this->isHomepageExist($site_id) == FALSE)
		{
			$page_ishomepage = "No";     
		}
		else
		{
			$page_ishomepage = "Yes";    
		}
		
		$page_create_date = date('Y-m-d h:i:s');
		$page_modified_date = date('Y-m-d h:i:s'); 
		$page_access = $this->input->post("page_access");
		$page_status = $this->input->post("page_status");
		$page_header = $this->input->post("page_header");
		
		$header_background = 'Default';
		
		$page_keywords = $this->input->post("page_keywords");
		$page_desc = $this->input->post("page_desc");
		$page_background = $this->input->post("page_background");
		$page_start_date = "";
		$page_end_date = "";
		$page_content = $this->input->post("page_content");
		$menu_id = $this->input->post("menu_id");
		
		if($this->input->post("sameas_page_title")=='Yes'){
			$item_name = $page_title;    
		}
		else{
			$item_name = $this->input->post("item_name");   
		}         
		/*
		if($page_status == "Schedule"){
			  $page_start_date = date('Y-m-d h:i:s', strtotime($this->input->post("page_start_date")));
			  $page_end_date = date('Y-m-d h:i:s', strtotime($this->input->post("page_end_date"))); 
		}*/     
		
		$this->db->query("INSERT INTO pages
			(site_id, page_title, page_show_title, page_default, page_seo_url, page_code, page_ishomepage, page_header, header_background, page_keywords, page_desc, page_background, page_start_date, page_end_date, page_create_date, page_modified_date, page_access, page_status) 
			VALUES(".$this->db->escape($site_id).", ".$this->db->escape($page_title).", ".$this->db->escape($page_show_title).", 'Not Default',  
			".$this->db->escape($page_seo_url).", ".$this->db->escape($page_code).", ".$this->db->escape($page_ishomepage).",
			".$this->db->escape($page_header).", ".$this->db->escape($header_background).", ".$this->db->escape($page_keywords).",
			".$this->db->escape($page_desc).", ".$this->db->escape($page_background).", ".$this->db->escape($page_start_date).",
			".$this->db->escape($page_end_date).", ".$this->db->escape($page_create_date).", ".$this->db->escape($page_modified_date).",
			".$this->db->escape($page_access).", ".$this->db->escape($page_status).")");
		
		$page_id = $this->db->insert_id();
		/*
		$this->db->query("INSERT INTO page_content(page_id, page_content) VALUES(".$this->db->escape($page_id).", ".$this->db->escape($page_content).")");
		
		if($page_header == 'Other'){
			$header_image = $this->input->post("DateTime").$_FILES["header_image"]["name"];
			$this->db->query("INSERT INTO headers(header_image, header_status) VALUES(".$this->db->escape($header_image).", 'Active')");
			
			$header_id = $this->db->insert_id();
			$this->db->query("INSERT INTO pages_headers_xref(header_id, page_id) VALUES(".$this->db->escape($header_id).", ".$this->db->escape($page_id).")"); 
		}
		
		$numHeaderImages = $this->input->post("numHeaderImages");
		if($page_header == 'Slideshow')
		{   
			
			for($i=1;$i<=$numHeaderImages;$i++)
			{
				
				if($_FILES["header_image_".$i]["name"]!="")
				{
					$header_image = $this->input->post("DateTime").$_FILES["header_image_".$i]["name"];
					$this->db->query("INSERT INTO headers(header_image, header_status) VALUES(".$this->db->escape($header_image).", 'Active')");
			
					$header_id = $this->db->insert_id();
					$this->db->query("INSERT INTO pages_headers_xref(header_id, page_id) VALUES(".$this->db->escape($header_id).", ".$this->db->escape($page_id).")");    
				}    
			}    
		}
		
		if($page_background == 'Other'){
			$background_image = $this->input->post("DateTime").$_FILES["background_image"]["name"];
			$this->db->query("INSERT INTO backgrounds(background_image, background_status) VALUES(".$this->db->escape($background_image).", 'Active')");
			
			$background_id = $this->db->insert_id();
			$this->db->query("INSERT INTO pages_backgrounds_xref(background_id, page_id) VALUES(".$this->db->escape($background_id).", ".$this->db->escape($page_id).")"); 
		}
		
		if($page_access == 'Other'){
						
			$role_id = $this->input->post("role_id");
			for($i=0; $i<sizeof($role_id);$i++){
				$this->db->query("INSERT INTO pages_roles_xref(page_id, role_id) VALUES(".$this->db->escape($page_id).", ".$this->db->escape($role_id[$i]).")");
			}                        
		}       
		
		$this->db->query("INSERT INTO menuitems(item_name, item_published, item_status) VALUES(".$this->db->escape($item_name).", 'Yes', 'Active')");
		$item_id = $this->db->insert_id();
		
		$this->db->query("INSERT INTO menuitems_pages_xref(item_id, page_id) VALUES(".$item_id.", ".$page_id.")");
		
		
		if($this->input->post("menu_id")){
			for($i=0; $i<sizeof($menu_id);$i++){
				$this->db->query("INSERT INTO menus_menuitems_xref(menu_id, item_id) VALUES(".$this->db->escape($menu_id[$i]).", ".$this->db->escape($item_id).")");
			}
		}*/
		
		return $page_id;
	}   
	
	//addressed by save_page_menu function in pagesController
	//saves menu & access information of the page
	function save_page_access_menu_info()
	{   
		$item_name = $this->input->post("item_name");
		$page_id = $this->input->post('page_id');
		//echo "INSERT INTO menuitems(item_name, item_published, item_status) VALUES(".$this->db->escape($item_name).", 'Yes', 'Active')";exit;
		$this->db->query("INSERT INTO menuitems(item_name, item_published, item_status) VALUES(".$this->db->escape($item_name).", 'Yes', 'Active')");
		$item_id = $this->db->insert_id();
		//echo "INSERT INTO menuitems_pages_xref(item_id, page_id) VALUES(".$item_id.", ".$page_id.")";exit;
		$this->db->query("INSERT INTO menuitems_pages_xref(item_id, page_id) VALUES(".$item_id.", ".$page_id.")");
		
		if($this->input->post("menu_id"))
		{
			$menu_id = $this->input->post("menu_id");
			for($i=0; $i<sizeof($menu_id);$i++)
			{
				$this->db->query("INSERT INTO menus_menuitems_xref(menu_id, item_id) VALUES(".$this->db->escape($menu_id[$i]).", ".$this->db->escape($item_id).")");
			}
		} 
		
		$page_link = $this->input->post("page_link");
		if($page_link != 'Create')
		{
			$qryPageLink = "UPDATE pages SET page_default=".$this->db->escape($page_link)." WHERE page_id=".$this->db->escape($page_id);
			$rsltPageLink = $this->db->query($qryPageLink);    
		}
		
		$page_access = $this->input->post("page_access");
		$this->db->query("UPDATE pages SET page_access=".$this->db->escape($page_access)." WHERE page_id=".$page_id);
		
		if($page_access == 'Other')
		{
						
			$role_id = $this->input->post("role_id");
			for($i=0; $i<sizeof($role_id);$i++)
			{
				$this->db->query("INSERT INTO pages_roles_xref(page_id, role_id) VALUES(".$this->db->escape($page_id).", ".$this->db->escape($role_id[$i]).")");
			}                        
		}
	   
		return $item_id;  
	}
	
	function delete_page_menu_access_info($page_id, $item_id)
	{
		$qryDeleteItemPageXref = "DELETE FROM menuitems_pages_xref WHERE item_id=".$this->db->escape($item_id);
		$this->db->query($qryDeleteItemPageXref);
		
		$qryDeleteItemMenusXref = "DELETE FROM menus_menuitems_xref WHERE item_id=".$this->db->escape($item_id);
		$this->db->query($qryDeleteItemMenusXref);
		
		$qryDeleteItem = "DELETE FROM menuitems WHERE item_id=".$this->db->escape($item_id); 
		$this->db->query($qryDeleteItem); 
		
		$page_access = $this->get_page_access($page_id);
		if($page_access == 'Other')
		{
			$qryDeleteAccess = "DELETE FROM pages_roles_xref WHERE page_id=".$this->db->escape($page_id);
			$qryDeleteAccess = $this->db->query($qryDeleteAccess);    
		}    
		
		return;
	}
	
	function edit_page_access_menu_info($site_id, $page_id, $item_id)
	{
		$this->delete_page_menu_access_info($page_id, $item_id);
		
		$item_id = $this->save_page_access_menu_info();
		
		return $item_id;    
	}
	
	//returns page_access information
	function get_page_access($page_id)
	{
		$qry = "SELECT page_access FROM pages WHERE page_id=".$this->db->escape($page_id);
		$rslt = $this->db->query($qry);
		$row = $rslt->row_array();
		return $row['page_access'];
	}
	
	//addressed in pagesController function save_upload_page_layout_desc
	//saves page layout: page header, background and status information in DB
	function save_upload_page_layout_desc()
	{
		/*echo "<pre>";
		print_r($_POST);exit();*/
		$page_id = $this->input->post('page_id');
		$site_id = $this->input->post('site_id');
		$page_header = $this->input->post('page_header');
		$page_background = $this->input->post('page_background');
		$page_status = $this->input->post('page_status'); 
		
		if($page_header == 'Other'){
			$header_image = $this->input->post("DateTime").$_FILES["header_image"]["name"];
			$this->db->query("INSERT INTO headers(header_image, is_header, header_status) VALUES(".$this->db->escape($header_image).", 'Yes', 'Active')");
			
			$header_id = $this->db->insert_id();
			$this->db->query("INSERT INTO pages_headers_xref(header_id, page_id) VALUES(".$this->db->escape($header_id).", ".$this->db->escape($page_id).")"); 
		}
		
		$numHeaderImages = $this->input->post("numHeaderImages");
		if($page_header == 'Slideshow')
		{   
			for($i=1;$i<=$numHeaderImages;$i++)
			{
				if($_FILES["header_image_".$i]["name"]!="")
				{
					$header_image = $this->input->post("DateTime").$_FILES["header_image_".$i]["name"];
					$this->db->query("INSERT INTO headers(header_image, is_header, header_status) VALUES(".$this->db->escape($header_image).", 'No', 'Active')");
			
					$header_id = $this->db->insert_id();
					$this->db->query("INSERT INTO pages_headers_xref(header_id, page_id) VALUES(".$this->db->escape($header_id).", ".$this->db->escape($page_id).")");    
				}    
			}    
		}
		if($page_header=='Default')
		{
			$header_background = 'Default';   
		}
		else
		{
			$header_background = $this->input->post('header_background');       
		}
		
		if($page_header!='Default' && $header_background=='Other')
		{
			$header_background = $this->input->post("header_background_color");    
		}
		
		$background_area = "content";
		$background_style = "stretch";
		if($this->input->post('background_area')!="")
		{
			 $background_area = $this->input->post('background_area');
		}
		if($this->input->post('background_style')!="")
		{
			$background_style = $this->input->post('background_style');     
		}
		if($page_background == 'Other'){
			$background_image = $this->input->post("DateTime").$_FILES["background_image"]["name"];
			//$this->db->query("INSERT INTO backgrounds(background_image, background_status) VALUES(".$this->db->escape($background_image).", 'Active')");
			$this->db->query("INSERT INTO backgrounds(background_image, background_area, background_style, background_status) VALUES(".$this->db->escape($background_image).", ".$this->db->escape($background_area).", ".$this->db->escape($background_style).", 'Active')"); 
			
			$background_id = $this->db->insert_id();
			$this->db->query("INSERT INTO pages_backgrounds_xref(background_id, page_id) VALUES(".$this->db->escape($background_id).", ".$this->db->escape($page_id).")"); 
		}
		
		if($header_background == 'Image')
		{
			$header_background_image = 'bg_'.$this->input->post("DateTime").$_FILES["header_background_image"]["name"];
			$this->db->query("INSERT INTO header_background_images(header_background_image, header_background_status) VALUES(".$this->db->escape($header_background_image).", 'Active')"); 
			
			$header_background_id = $this->db->insert_id();
			$this->db->query("INSERT INTO pages_header_backgrounds_xref(header_background_id, page_id) VALUES(".$this->db->escape($header_background_id).", ".$this->db->escape($page_id).")"); 
		}
		
		if($page_status=='Schedule')
		{
			$page_start_date = $this->input->post('page_start_date');
			$page_start_date = date('Y-m-d h:i:s', strtotime($page_start_date));
			$page_end_date = $this->input->post('page_end_date');
			$page_end_date = date('Y-m-d h:i:s', strtotime($page_end_date)); 
			
			$qryUpdatePageInfo = "UPDATE pages SET header_background=".$this->db->escape($header_background).", page_header=".$this->db->escape($page_header).", page_background=".$this->db->escape($page_background).", page_status=".$this->db->escape($page_status).", page_start_date=".$this->db->escape($page_start_date).", page_end_date=".$this->db->escape($page_end_date)." WHERE page_id=".$this->db->escape($page_id);    
		}   
		else
		{
			$qryUpdatePageInfo = "UPDATE pages SET header_background=".$this->db->escape($header_background).", page_header=".$this->db->escape($page_header).", page_background=".$this->db->escape($page_background).", page_status=".$this->db->escape($page_status)." WHERE page_id=".$this->db->escape($page_id);
		}
		//echo $qryUpdatePageInfo;exit;     
		return $this->db->query($qryUpdatePageInfo);
		
		//return;
	}
	
	//input: from(page no.), records per page($intPageLimit), $page_title
	//output: search results records
	//process: search DB for records matching $page_title    
	function searchPages($from, $intPageLimit, $page_title, $site_id){                
		return $this->db->query("SELECT * FROM pages WHERE site_id=".$this->db->escape($site_id)." AND page_status NOT IN ('Deleted') AND page_title LIKE '%".$page_title."%' ORDER BY page_id DESC LIMIT ".$from.", ".$intPageLimit);
	}
	
	//input: Array of page_id
	//output: NULL
	//process: Updates page_status to Published    
	function totalSearchPages($page_title){
		$result = $this->db->query("SELECT * FROM pages WHERE page_status NOT IN ('Deleted') AND page_title LIKE '%".$page_title."%'");
		return $result->num_rows();       
	}
	
	//input: Array of page_id
	//output: NULL
	//process: Updates page_status to Published    
	function publishPages($arrPageId){
		$data = array(
			   'page_status' => "Published",
			   'page_modified_date' => date('Y-m-d h:i:s'),               
			);     
		for($i=0;$i<sizeof($arrPageId);$i++){
			$this->db->where('page_id', $arrPageId[$i]);
			$this->db->update('pages', $data); 
		}
		return;
	}
	
	//input: Array of page_id
	//output: NULL
	//process: Updates page_status to Not Published    
	function unpublishPages($arrPageId){
		$data = array(
			   'page_status' => "Not Published",
			   'page_modified_date' => date('Y-m-d h:i:s'),                              
			);     
		for($i=0;$i<sizeof($arrPageId);$i++){
			$this->db->where('page_id', $arrPageId[$i]);
			$this->db->update('pages', $data); 
		}
		return;
	}
	
	//input: Array of page_id
	//output: NULL
	//process: Updates page_status to Deleted    
	function deletePages($arrPageId){
		$data = array(
			   'page_status' => "Deleted",
			   'page_modified_date' => date('Y-m-d h:i:s'),                              
			);     
		for($i=0;$i<sizeof($arrPageId);$i++){
			$this->db->where('page_id', $arrPageId[$i]);
			$this->db->update('pages', $data); 
		}
		return;
	}
	
	//input: Array of page_id
	//output: page records in DB
	//process: Applies pagination to get records from DB    
	function showPages($from, $intPageLimit, $site_id){                
		return $this->db->query("SELECT * FROM pages WHERE site_id=".$this->db->escape($site_id)." AND page_status NOT IN ('Deleted') ORDER BY page_id DESC LIMIT ".$from.", ".$intPageLimit);
	}
	
	//input: NULL
	//output: page records in DB
	//process: gets page records from DB
	function getAllPages($site_id){                
		return $this->db->query("SELECT * FROM pages WHERE site_id=".$this->db->escape($site_id)." AND page_status NOT IN ('Deleted') ORDER BY page_id DESC");
	}
	
	//input: page_id
	//output: TRUE or FALSE
	//process: returns TRUE if page_id is set as Homepage
	function isHomepage($page_id){                
		$result = $this->db->query("SELECT * FROM pages WHERE page_id=".$page_id." AND page_ishomepage='Yes'");
		if($result->num_rows()>0){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	//input: page_id
	//output: NULL
	//process: sets page_id as homepage
	function setAsHomepage($site_id, $page_id){
		
		$data = array(
			   'page_ishomepage' => "No",               
			);       
		$this->db->update('pages', $data);
		
		$data = array(
			   'page_ishomepage' => "Yes",               
			);       
		$this->db->where('page_id', $page_id);
		$this->db->where('site_id', $site_id);
		$this->db->update('pages', $data);
				
		return;
	}                                                
	
	//input: NULL
	//output: number of page records in DB
	//process: Finds records in DB    
	function totalPages($site_id){
		$result = $this->db->query("SELECT * FROM pages WHERE site_id=".$this->db->escape($site_id)." AND page_status NOT IN ('Deleted')");
		return $result->num_rows();
	}
	
	
	
	
	// method to check ajax content elemnet id already exist 
	function check_elementID_exist($data = array())
	{
		$page_id = $data['page_id'];
		$file_name = $data['element_id'];
		$this->db->select('field_name');
		$this->db->where('page_id', $page_id);
		$this->db->where('field_name', $file_name);
		$result = $this->db->get('page_content_controls');

	  //  $query_string = "SELECT user_id FROM page_content_controls where user_id = ?";
	  // $result = $this->db->query($query_string,$user_id);
	 //  print_r($result->num_rows());
	   if ($result->num_rows() > 0 && $result->num_rows() != 0 )
	   {
		   return true;
	   }
	   else
	   {
		   return false;
	   }      
		
	}
	
	// methoed save ajax data
	function ajax_content_data_add($data)
	{
	   
		$data = array(
		'page_id' => $data['page_id'],
		'field_name' => $data['element_id'],
		'data' =>  $data['data'],
		'x' => $data['pos_top'],
		'y' =>  $data['pos_left'],
		'type' =>  $data['type']
		  );
 
	$this->db->insert('page_content_controls', $data);
		
		
	}
	
	 // methoed save ajax data
	function ajax_content_data_update($data_retrieve)
	{
	   
		 $data = array(
	   // 'page_id' => $data['page_id'],
	   // 'field_name' => $data['element_id'],
		'data' =>  $data_retrieve['data'],
		'x' => $data_retrieve['pos_top'],
		'y' =>  $data_retrieve['pos_left']
	   // 'type' =>  $data_retrieve['type']
		  );
	  
	   $page_id = intval($data_retrieve['page_id']);
	   $field_name = $data_retrieve['element_id'];
	   $this->db->where('page_id',$page_id);
	   $this->db->where('field_name', $field_name);
	   $this->db->update('page_content_controls', $data);

	}
	
	function ajax_content_data_delete($data_retrieve)
	{
		//echo "*************";
		//print_r($data_retrieve);
		//echo "*************";
		
	  $page_id = intval($data_retrieve['page_id']);
	  $field_name = $data_retrieve['element_id'];
	  $this->db->where('page_id',$page_id);
	  $this->db->where('field_name', $field_name);
	  $query = $this->db->limit(1,0);
	  $query = $this->db->delete('page_content_controls');
	  return ($this->db->affected_rows() > 0) ? TRUE : FALSE;

	}
	
	 // method to chek image already exixt
		function check_img_exist($data = array())
	{
		$page_id = $data['page_id'];
		$file_name = $data['img_id'];

		$this->db->select('field_name');
		$this->db->where('page_id', $page_id);
		$this->db->where('field_name', $file_name);
		$result = $this->db->get('page_content_controls');

	  //  $query_string = "SELECT user_id FROM page_content_controls where user_id = ?";
	  // $result = $this->db->query($query_string,$user_id);
	 //  print_r($result->num_rows());
	   if ($result->num_rows() > 0 && $result->num_rows() != 0 )
	   {
		   return true;
	   }
	   else
	   {
		   return false;
	   }      
		
	}
	
	
	
	
		 // methoed save image ajax data
	function ajax_content_img_update($data_retrieve)
	{
	   
		 $data = array(
	   // 'page_id' => $data['page_id'],
	   // 'field_name' => $data['element_id'],
		'image' =>  $data_retrieve['image'], 
		'x' => $data_retrieve['pos_top'],
		'y' =>  $data_retrieve['pos_left']
	   // 'type' =>  $data_retrieve['type']
		  );
	  
	   $page_id = intval($data_retrieve['page_id']);
	   $field_name = $data_retrieve['img_id'];
	   $this->db->where('page_id',$page_id);
	   $this->db->where('field_name', $field_name);
	   $this->db->update('page_content_controls', $data);

	}
	
	 // method to save image save ajax call
	  function ajax_content_img_add($data)
	{
	   
		$data = array(
		'page_id' => $data['page_id'],
		'field_name' => $data['img_id'],
		'image' =>  $data['image'],
		'x' => $data['pos_top'],
		'y' =>  $data['pos_left'],
		'type' =>  $data['type']
		  );
 
	$this->db->insert('page_content_controls', $data);
		
		
	}
	
		function ajax_content_img_delete($data_retrieve)
	{
		//echo "*************";
		//print_r($data_retrieve);
		//echo "*************";
		
	  $page_id = intval($data_retrieve['page_id']);
	  $field_name = $data_retrieve['img_id'];
	  $this->db->where('page_id',$page_id);
	  $this->db->where('field_name', $field_name);
	  $query = $this->db->limit(1,0);
	  $query = $this->db->delete('page_content_controls');
	  return ($this->db->affected_rows() > 0) ? TRUE : FALSE;

	}
	
	
	function delete_pagecontent_editorboard()
	{
		$page_id = $this->input->post('page_id');
		
		$qry = "DELETE FROM page_content_controls WHERE page_id=".$this->db->escape($page_id);
		$this->db->query($qry);
		
		return;    
	}
	
	//called in pagesController's layout_desc() function
	//saves page's content from editorboard's drag n drop screen(view) page/create/editorboard
	function save_pagecontent_editorboard()
	{
		//echo "<pre>";
		//print_r($_POST);
		
		//exit;
		
		$page_id = $this->input->post('page_id');
		$numControls = 0;
		$numControls = $this->input->post('numControls');
		//Save controls content
		for($i=0; $i<$numControls; $i++)
		{
			//echo $counter.'<br />';
			if($_POST['content'][$i]!='')
			{       
				if($_POST['control_type'][$i] == "image-para" || $_POST['control_type'][$i] == "para-image" )
				{
					$qryPageContent = "INSERT INTO page_content_controls(page_id, data,image, type) 
				VALUES(".$this->db->escape($page_id).", ".$this->db->escape($_POST['content'][$i]).",".$this->db->escape($_POST['image-para'][$i]).", ".$this->db->escape($_POST['control_type'][$i]).")";
					
				}
				else if($_POST['control_type'][$i] == "image")
				{
					$qryPageContent = "INSERT INTO page_content_controls(page_id, data,image, type) 
				VALUES(".$this->db->escape($page_id).",'',".$this->db->escape($_POST['content'][$i]).", ".$this->db->escape($_POST['control_type'][$i]).")";
					
				}
				else 
				{
					$qryPageContent = "INSERT INTO page_content_controls(page_id, data,image, type) 
				VALUES(".$this->db->escape($page_id).", ".$this->db->escape($_POST['content'][$i]).",'', ".$this->db->escape($_POST['control_type'][$i]).")";
					
				}
				
				
				$this->db->query($qryPageContent);
			//	echo $qryPageContent."<br />" ;          
			}
		}
		//exit;
		/*
		$page_id = $this->input->post('page_id');
		$numPara = 0;
		$numTextarea = 0;
		if(isset($_POST['para']))
		{
			$numPara = sizeof($_POST['para']);
		}
		if(isset($_POST['textarea']))
		{
			$numTextarea = sizeof($_POST['textarea']);    
		}
		if(isset($_POST['images']))
		{
			$numImages = sizeof($_POST['images']);    
		}
		
		
		//Save paragraphs
		for($i=0; $i<$numPara; $i++)
		{
			if($_POST['para'][$i]!='')
			{
				$qryPageContent = "INSERT INTO page_content_controls(page_id, data, type) 
				VALUES(".$this->db->escape($page_id).", ".$this->db->escape($_POST['para'][$i]).", 'para')";
				$this->db->query($qryPageContent);
				//echo $qryPageContent."<br />" ;          
			}
			
		}
		
		//Save textareas
		for($i=0; $i<$numTextarea; $i++)
		{
			if($_POST['textarea'][$i]!='')
			{
				$qryPageContent = "INSERT INTO page_content_controls(page_id, data, type) 
				VALUES(".$this->db->escape($page_id).", ".$this->db->escape($_POST['textarea'][$i]).", 'textarea')";
				$this->db->query($qryPageContent); 
				//echo $qryPageContent."<br />" ;      
			}
		}
		
		for($i=0; $i<$numImages; $i++)
		{
			if($_POST['images'][$i]!='')
			{
				$qryPageContent = "INSERT INTO page_content_controls(page_id, image, data, type) 
				VALUES(".$this->db->escape($page_id).", ".$this->db->escape($_POST['images'][$i]).", ".$this->db->escape($_POST['images'][$i]).", 'image')";
				$this->db->query($qryPageContent); 
				//echo $qryPageContent."<br />" ;      
			}
			
		}
		*/
		return; 
			
	}
		
	function edit_basic_info()
	{
		$site_id = $this->input->post('site_id');     
		$page_id = $this->input->post('page_id');
		$page_title = $this->input->post('page_title');
		$page_seo_url = $this->input->post('page_seo_url');  
		$page_keywords = $this->input->post('page_keywords');
		$page_desc = $this->input->post('page_desc');
		$page_code = $site_id."-".$page_id;
		
		$qry = "UPDATE pages SET page_title=".$this->db->escape($page_title).", page_seo_url=".$this->db->escape($page_seo_url).",
		page_keywords=".$this->db->escape($page_keywords).", page_desc=".$this->db->escape($page_desc).", page_code=".$this->db->escape($page_code)."
		WHERE page_id=".$this->db->escape($page_id);
		
		//echo $qry;exit;
		$this->db->query($qry);
		
		return;
			
	}
	
	//referenced in page_editor controller
	//
	/*
	function save_page_content_by_id($content_id)
	{
		$content = $this->input->post('content');
		$qry = "UPDATE page_content_controls SET data=".$this->db->escape($content)." WHERE id=".$this->db->escape($content_id);
		//echo $qry;exit;
		$this->db->query($qry);
		return;
	}
	*/
	
	//returns all active templates to the toolbox in page_editor(controller)
	function get_all_templates()
	{
		$qry = "SELECT * FROM system_templates WHERE status='Active'";
		$rslt = $this->db->query($qry);
		return $rslt;
	}
	
	//sets site's template in page_editor
	function set_site_template($site_id, $temp_id)
	{
		$qry = "UPDATE sites_templates_xref SET temp_id=".$this->db->escape($temp_id)." WHERE site_id=".$this->db->escape($site_id);
		$rslt = $this->db->query($qry);
		return;        
	}
	
	//delete page by page_id
	function delete_page($page_id)
	{
		$qry = "DELETE FROM pages WHERE page_id=".$this->db->escape($page_id);
		$rslt = $this->db->query($qry);
		return;
	}
	
	function getHeaderBackgroundImage($page_id)
	{
		$qry = "SELECT header_background_image FROM header_background_images hbi 
			JOIN pages_header_backgrounds_xref phx ON phx.header_background_id=hbi.header_background_id 
			WHERE page_id=".$this->db->escape($page_id);
			//echo $qry; exit;
		$rslt = $this->db->query($qry);
		$row = $rslt->row_array();
		return $row['header_background_image'];
	}
	
	function updatePageTitle($page_id, $page_title)
	{
		$qry = "UPDATE pages SET page_title=".$this->db->escape($page_title)." WHERE page_id=".$this->db->escape($page_id);
		$rslt = $this->db->query($qry);
		return true;    
	}
	
	function updateAdvanceInfo($page_id, $page_keywords, $page_desc)
	{
		$qry = "UPDATE pages SET page_keywords=".$this->db->escape($page_keywords).", page_desc=".$this->db->escape($page_desc)." WHERE page_id=".$this->db->escape($page_id);
		$rslt = $this->db->query($qry);
		return true;    
	}
	
	function updatePageBackgroundInfo($site_id, $page_id, $page_background)
	{
		$qry = "UPDATE pages SET page_background=".$this->db->escape($page_background)." 
		WHERE site_id=".$this->db->escape($site_id)." AND page_id=".$this->db->escape($page_id);
		$rslt = $this->db->query($qry);
		return true;
	}
	
	function deleteBackgroundInfo($site_id, $page_id, $background_id, $background_image)
	{   
		//delete background from db
		$qryBackgroundInfo = "DELETE FROM backgrounds WHERE background_id=".$this->db->escape($background_id);
		$rsltBackgroundInfo = $this->db->query($qryBackgroundInfo);
		
		//delefte background & pages xref record
		$qryPagesBackgroundsXref = "DELETE FROM pages_backgrounds_xref WHERE page_id=".$this->db->escape($page_id)." AND background_id=".$this->db->escape($background_id);
		$rsltPagesBackgroundsXref = $this->db->query($qryPagesBackgroundsXref);
		
		//delete background image from server
		$background_image = './backgrounds/'.$background_image;
		//echo $background_image;
		if(file_exists($background_image))
		{
			$action = unlink($background_image);        
		}
		//echo $action;
		return true;       
	}
	
	function updateBackgroundInfo($background_id, $background_style, $background_area)
	{
		$qry = "UPDATE backgrounds SET background_style=".$this->db->escape($background_style).", background_area=".$this->db->escape($background_area)." 
		WHERE background_id=".$this->db->escape($background_id);
		$rslt = $this->db->query($qry);
		return true;
	}
	
	function addBackgroundInfo($page_id, $background_image, $background_style, $background_area)
	{
		$qryAddBackground = "INSERT INTO backgrounds(background_image, background_style, background_area, background_status)
		VALUES(".$this->db->escape($background_image).", ".$this->db->escape($background_style).", ".$this->db->escape($background_area).", 'Active')";
		$rsltAddBackground = $this->db->query($qryAddBackground);
		$background_id = $this->db->insert_id();
		
		$qryAddPageBackgroundXref = "INSERT INTO pages_backgrounds_xref(page_id, background_id) 
		VALUES(".$this->db->escape($page_id).", ".$this->db->escape($background_id).")";
		$rsltAddPageBackgroundXref = $this->db->query($qryAddPageBackgroundXref);
		
		return true;
	}
	
	function deleteHeaderInfo($site_id, $page_id)
	{
		//delete header image(s) from server
		$qryHeaderImages = "SELECT hdr.header_image FROM headers hdr JOIN pages_headers_xref phx ON hdr.header_id=phx.header_id WHERE phx.page_id=".$this->db->escape($page_id);
		$rsltHeaderImages = $this->db->query($qryHeaderImages);
		foreach($rsltHeaderImages->result_array() as $rowHeaderImages)
		{
			$header_image = './headers/'.$rowHeaderImages['header_image']; 
			//delete header_image from server
			if(file_exists($header_image))
			{
				$action = unlink($header_image);        
			}   
		}
		
		//delete headers from db
		$qryHeaderInfo = "DELETE FROM headers WHERE header_id IN(SELECT hdr.header_id FROM headers hdr JOIN pages_headers_xref phx ON hdr.header_id=phx.header_id WHERE phx.page_id=".$this->db->escape($page_id).")";
		$rsltHeaderInfo = $this->db->query($qryHeaderInfo);
		
		//delete headers & pages xref records
		$qryPagesHeadersXref = "DELETE FROM pages_headers_xref WHERE page_id=".$this->db->escape($page_id);
		$rsltPagesHeadersXref = $this->db->query($qryPagesHeadersXref);
		
		return true;    
	}
	
	function addHeaderInfo($site_id, $page_id, $header_image)
	{
		$qryHeaderInfo = "INSERT INTO headers(header_image, header_status) 
		VALUES(".$this->db->escape($header_image).", 'Active')";
		$rsltHeaderInfo = $this->db->query($qryHeaderInfo);
		$header_id = $this->db->insert_id();
		
		$qryPageHeaderXref = "INSERT INTO pages_headers_xref(page_id, header_id)
		VALUES(".$this->db->escape($page_id).", ".$this->db->escape($header_id).")";
		$rsltPageHeaderXref = $this->db->query($qryPageHeaderXref); 
		
		return true;
	}
	
	function updatePageHeaderInfo($site_id, $page_id, $page_header, $header_background)
	{
		$qry = "UPDATE pages SET page_header=".$this->db->escape($page_header).", header_background=".$this->db->escape($header_background)." 
			WHERE site_id=".$this->db->escape($site_id)." AND page_id=".$this->db->escape($page_id);
		
		$rslt = $this->db->query($qry);
		
		return true;
	}
	
	function deleteMenuInfo($menu_id)
	{
		$qryDeleteMenuItems = "DELETE FROM menuitems WHERE item_id IN(SELECT item_id FROM menus_menuitems_xref WHERE menu_id=".$this->db->escape($menu_id).")";  
		$rsltDeleteMenuItems =  $this->db->query($qryDeleteMenuItems);
		
		$qryDeleteMenuItemsPagesXref = "DELETE FROM menuitems_pages_xref WHERE item_id IN(SELECT item_id FROM menus_menuitems_xref WHERE menu_id=".$this->db->escape($menu_id).")";
		$rsltDeleteMenuItemsPagesXref = $this->db->query($qryDeleteMenuItemsPagesXref); 
		
		$qryDeleteMenuItemsXref = "DELETE FROM menus_menuitems_xref WHERE menu_id=".$this->db->escape($menu_id);
		$rsltDeleteMenuItemsXref = $this->db->query($qryDeleteMenuItemsXref);
		
		$qryDeleteMenuRoles = "DELETE FROM menus_roles_xref WHERE menu_id=".$this->db->escape($menu_id); 
		$rsltDeleteMenuRoles = $this->db->query($qryDeleteMenuRoles);
		
		$qryDeleteMenuPages = "DELETE FROM menus_pages_xref WHERE menu_id=".$this->db->escape($menu_id);
		$rsltDeleteMenuPages = $this->db->query($qryDeleteMenuPages);
		
		$qryDeleteMenu = "DELETE FROM menus WHERE menu_id=".$this->db->escape($menu_id);
		$rsltDeleteMenu = $this->db->query($qryDeleteMenu); 
		
		return true; 
	}
	
	function deleteContentInfo($id)
	{
		$qryDeleteContent = "DELETE FROM page_content_controls WHERE id=".$this->db->escape($id);
		$rsltDeleteContent = $this->db->query($qryDeleteContent);
		   
		return;
	}
	
	function add_page_content($page_id, $data, $type)
	{
		$qryAddContent = "INSERT INTO page_content_controls(page_id, data, type) 
		VALUES(".$this->db->escape($page_id).", ".$this->db->escape($data).", ".$this->db->escape($type).")";
		$rsltAddContent = $this->db->query($qryAddContent);
		
		return true;    
	}
	
	function update_page_content($page_id, $id, $data, $type)
	{
		$qryUpdateContent = "UPDATE page_content_controls SET data=".$this->db->escape($data).", type=".$this->db->escape($type)." 
			WHERE page_id=".$this->db->escape($page_id)." AND id=".$this->db->escape($id);  
		$rsltUpdateContent = $this->db->query($qryUpdateContent);
		
		return true;    
	}
	
	function updateOtherHeaderInfo($site_id, $page_id, $header_image)
	{
		$qryDeleteOtherHeaderInfo = "DELETE FROM headers 
		WHERE header_id IN(SELECT header_id FROM pages_headers_xref WHERE page_id=".$this->db->escape($page_id).") 
		AND is_header='Yes'";
		$rsltDeleteOtherHeaderInfo = $this->db->query($qryDeleteOtherHeaderInfo);  
		
		$qryAddOtherHeaderInfo = "INSERT INTO headers(header_image, is_header, header_status)
		VALUES(".$this->db->escape($header_image).", 'Yes', 'Active')";      
		$rsltAddOtherHeaderInfo = $this->db->query($qryAddOtherHeaderInfo);
		$header_id = $this->db->insert_id();
		
		$qryAddPageOtherHeaderXref = "INSERT INTO pages_headers_xref(header_id, page_id)
		VALUES(".$this->db->escape($header_id).", ".$this->db->escape($page_id).")";
		$rsltAddPageOtherHeaderXref = $this->db->query($qryAddPageOtherHeaderXref);
		
		return true;
	}
	
	/*
	function deleteSlideshowHeaderImages($site_id, $page_id)
	{
		$qryDeleteSlideshowHeaderInfo = "DELETE FROM headers 
		WHERE header_id IN(SELECT header_id FROM pages_headers_xref WHERE page_id=".$this->db->escape($page_id).") 
		AND is_header='No'";
		$rsltDeleteSlideshowHeaderInfo = $this->db->query($qryDeleteSlideshowHeaderInfo);  
		
		return true;      
	}
	*/
	
	function updateSlideshowHeaderInfo($site_id, $page_id, $header_image)
	{
		$qryAddSlideshowHeaderInfo = "INSERT INTO headers(header_image, is_header, header_status)
		VALUES(".$this->db->escape($header_image).", 'No', 'Active')";      
		$rsltAddSlideshowHeaderInfo = $this->db->query($qryAddSlideshowHeaderInfo); 
		$header_id = $this->db->insert_id();
		//echo $qryAddSlideshowHeaderInfo."<br />";
		
		$qryAddPageSlideshowHeaderXref = "INSERT INTO pages_headers_xref(header_id, page_id)
		VALUES(".$this->db->escape($header_id).", ".$this->db->escape($page_id).")";
		$rsltAddPageSlideshowHeaderXref = $this->db->query($qryAddPageSlideshowHeaderXref);
		//echo $qryAddSlideshowHeaderInfo."<br />"; 
		return true;    
	}
	
	function updateHeaderBackgroundInfo($site_id, $page_id, $header_background_image)
	{
		$qryDeleteHeaderBackgroundInfo = "DELETE FROM header_background_images 
		WHERE header_background_id IN(SELECT header_background_id FROM pages_header_backgrounds_xref WHERE page_id=".$this->db->escape($page_id).")";   
		//echo $qryDeleteHeaderBackgroundInfo."<br />";
		$rsltDeleteHeaderBackgroundInfo = $this->db->query($qryDeleteHeaderBackgroundInfo);
		
		$qryDeleteHeaderBackgroundXref = "DELETE FROM pages_header_backgrounds_xref WHERE page_id=".$this->db->escape($page_id);
		//echo $qryDeleteHeaderBackgroundXref."<br />";  
		$rsltDeleteHeaderBackgroundXref = $this->db->query($qryDeleteHeaderBackgroundXref);
		
		$qryAddHeaderBackgroundInfo = "INSERT INTO header_background_images(header_background_image, header_background_status)
		VALUES(".$this->db->escape($header_background_image).", 'Active')";
		//echo $qryAddHeaderBackgroundInfo."<br />";  
		$rsltAddHeaderBackgroundInfo = $this->db->query($qryAddHeaderBackgroundInfo);
		$header_background_id = $this->db->insert_id();
		
		$qryAddPageHeaderBackgroundXref = "INSERT INTO pages_header_backgrounds_xref(page_id, header_background_id)
		VALUES(".$this->db->escape($page_id).", ".$this->db->escape($header_background_id).")"; 
		//echo $qryAddPageHeaderBackgroundXref."<br />";
		$rsltAddPageHeaderBackgroundXref = $this->db->query($qryAddPageHeaderBackgroundXref);
		//exit;
		return true;
	}
    
    function get_page_title($page_id)
    {
        $qry_page_title = "SELECT page_title FROM pages WHERE page_id=".$this->db->escape($page_id); 
        
        $rslt_page_title = $this->db->query($qry_page_title);  
        
        $row = $rslt_page_title->row_array();
        
        $page_title =  $row['page_title'];
        
        return $page_title;
    }
}
?>
