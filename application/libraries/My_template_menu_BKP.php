<?php

class My_template_menu
{

    var $obj;
    var $area;

  public function __construct()
    {   
        $obj =& get_instance(); 
        // Do something with $params
        
        $obj->load->database();
        $obj->load->model("Menus_Model");
        $obj->load->model("Pages_Model");
        $obj->load->model("Site_Model");
        $obj->load->model("usersmodel");
        $obj->load->library('pagination');
        $obj->load->library('session');    
        $obj->load->helper('url');   
        $obj->load->library('form_validation');       
        $obj->load->helper('html'); 
        $obj->load->library('template');
        
    }
    
    //$order has to be either asc or desc
 function sortmulti ($array, $index, $order, $natsort=FALSE, $case_sensitive=FALSE) 
 { 
        $sorted = new ArrayObject();
        if(is_array($array) && count($array)>0) {
            foreach(array_keys($array) as $key)
            $temp[$key]=$array[$key][$index];
            if(!$natsort) {
                if ($order=='asc')
                    asort($temp);
                else   
                    arsort($temp);
            }
            else
            {
                if ($case_sensitive===true)
                    natsort($temp);
                else
                    natcasesort($temp);
            if($order!='asc')
                $temp=array_reverse($temp,TRUE);
            }
            foreach(array_keys($temp) as $key)
                if (is_numeric($key))
                    $sorted[]=$array[$key];
                else   
                    $sorted[$key]=$array[$key];
            return $sorted;
        }
    return $sorted;
} 
    
    // function set and get template dynamicly
    function set_get_template($site_id)
    {
        
        $obj =& get_instance(); 
        $temp_name = $obj->Site_Model->getSiteTemplate($site_id);
        
        //set site template
        $obj->template->set_template($temp_name);
        /*
        $obj->template->add_js('js/jquery-1.5.1.min.js');
        $obj->template->add_js('js/jquery.cycle.all.js');
        $obj->template->add_js('js/arial.js');
        $obj->template->add_js('js/radius.js');
        $obj->template->add_js('js/fancybox/jquery.fancybox-1.3.4.js');
        $obj->template->add_js('js/fancybox/jquery.mousewheel-3.0.4.pack.js');
        */                                                                     
         return $temp_name;
        
        
    }
    
    
    
       //returns menus for display in sidebar region of the template
    function getSidebar($site_id, $page_id)
    {
        $obj =& get_instance(); 
        //Gets menus for site and page accessible for every one and on all pages       
        $resultMenu = $obj->Menus_Model->getAllPageMenus($site_id, $page_id, "Everyone", "All");
        $arrMenus1 = $resultMenu->result_array();
        
        for($i=0; $i<sizeof($arrMenus1); $i++)
        {
            $resultMenuItems = $obj->Menus_Model->getMenuItem($arrMenus1[$i]['menu_id'],'Everyone');    
            $arrMenus1[$i]["sub_menu"] = $resultMenuItems->result_array();
        
		//echo "<pre>";
		//print_r($arrMenus1[$i]["sub_menu"]);
			//We dont need Page ID for Custom Link		
			
			//echo $arrMenus1[$i]["sub_menu"]["item_link"]."<br>";
			//exit;
				//To fetch the page ID for each menu item.
				for($j=0; $j<count($arrMenus1[$i]["sub_menu"]);$j++)
				{
	//echo "<pre>";
	//print_r($arrMenus1[$i]["sub_menu"]);
				   $item_id =  $arrMenus1[$i]["sub_menu"][$j]["item_id"]."<br>";
				   $resultPage = $obj->Menus_Model->getPage($item_id);


	
				   $rowPage = $resultPage->result_array();
				 //  echo "<pre>";
					if(!empty($rowPage))
					{
						$arrMenus1[$i]['sub_menu'][$j]['page_id'] = $rowPage[0]['page_id'];
					}
					else
					{
						$arrMenus1[$i]['sub_menu'][$j]['page_id'] = "";
					}
					
				}
        }
        
       //echo "<pre>";
       // print_r($arrMenus1);
        //exit;
        
        //Gets menus for site and page accessible for Registered(logged-in) users and on all pages       
        $resultMenu = $obj->Menus_Model->getAllPageMenus($site_id, $page_id, "Registered", "All");
        $arrMenus2 = $resultMenu->result_array();
        for($i=0; $i<sizeof($arrMenus2); $i++)
        {
            $resultMenuItems = $obj->Menus_Model->getMenuItem($arrMenus2[$i]['menu_id'],'Registered');    
            $arrMenus2[$i]['sub_menu'] = $resultMenuItems->result_array();
            //To fetch the page ID for each menu item.
            for($j=0; $j<count($arrMenus2[$i]["sub_menu"]);$j++)
            {
               $item_id =  $arrMenus2[$i]["sub_menu"][$j]["item_id"]."<br>";
               $resultPage = $obj->Menus_Model->getPage($item_id);
               $rowPage = $resultPage->result_array();
				if(!empty($rowPage))
				{
					$arrMenus2[$i]['sub_menu'][$j]['page_id'] = $rowPage[0]['page_id'];
				}
				else
				{
					$arrMenus2[$i]['sub_menu'][$j]['page_id'] = "";
				}
               
            }
        }
        /*echo "<pre>";
        print_r($arrMenus1);
        exit;*/
        //$finalArray = array_merge($arrMenus1, $arrMenus2);
        
        //Gets menus for site and page accessible for Other(Special) users(Roles) and on all pages       
        $resultMenu = $obj->Menus_Model->getAllPageMenus($site_id, $page_id, "Other", "All");
        $arrMenus3 = $resultMenu->result_array();
        for($i=0; $i<sizeof($arrMenus3); $i++)
        {
            $resultMenuItems = $obj->Menus_Model->getMenuItem($arrMenus3[$i]['menu_id'],'Other');    
            $arrMenus3[$i]['sub_menu'] = $resultMenuItems->result_array();
            
            //To fetch the page ID for each menu item.
            for($j=0; $j<count($arrMenus3[$i]["sub_menu"]);$j++)
            {
               $item_id =  $arrMenus3[$i]["sub_menu"][$j]["item_id"]."<br>";
               $resultPage = $obj->Menus_Model->getPage($item_id);
               $rowPage = $resultPage->result_array();
			   if(!empty($rowPage))
				{
					$arrMenus3[$i]['sub_menu'][$j]['page_id'] = $rowPage[0]['page_id'];
				}
				else
				{
					$arrMenus3[$i]['sub_menu'][$j]['page_id'] = "";
				}
               
            }
        }
        
        //Gets menus for site and page accessible for Everyone and on Other(Some) of the pages       
        $resultMenu = $obj->Menus_Model->getAllPageMenus($site_id, $page_id, "Everyone", "Other");
        $arrMenus4 = $resultMenu->result_array();
        for($i=0; $i<sizeof($arrMenus4); $i++)
        {
            $resultMenuItems = $obj->Menus_Model->getMenuItem($arrMenus4[$i]['menu_id'],'Everyone');    
            $arrMenus4[$i]['sub_menu'] = $resultMenuItems->result_array();
            
            //To fetch the page ID for each menu item.
            for($j=0; $j<count($arrMenus4[$i]["sub_menu"]);$j++)
            {
               $item_id =  $arrMenus4[$i]["sub_menu"][$j]["item_id"]."<br>";
               $resultPage = $obj->Menus_Model->getPage($item_id);
               $rowPage = $resultPage->result_array();
			   if(!empty($rowPage))
				{
					$arrMenus4[$i]['sub_menu'][$j]['page_id'] = $rowPage[0]['page_id'];
				}
				else
				{
					$arrMenus4[$i]['sub_menu'][$j]['page_id'] = "";
				}
               
            }
        }
        
        //Gets menus for site and page accessible for Registered and on Other(Some) of the pages       
        $resultMenu = $obj->Menus_Model->getAllPageMenus($site_id, $page_id, "Registered", "Other");
        $arrMenus5 = $resultMenu->result_array();
        for($i=0; $i<sizeof($arrMenus5); $i++)
        {
            $resultMenuItems = $obj->Menus_Model->getMenuItem($arrMenus5[$i]['menu_id'],'Registered');    
            $arrMenus5[$i]['sub_menu'] = $resultMenuItems->result_array();
            
            //To fetch the page ID for each menu item.
            for($j=0; $j<count($arrMenus5[$i]["sub_menu"]);$j++)
            {
               $item_id =  $arrMenus5[$i]["sub_menu"][$j]["item_id"]."<br>";
               $resultPage = $obj->Menus_Model->getPage($item_id);
               $rowPage = $resultPage->result_array();
			   if(!empty($rowPage))
				{
					$arrMenus5[$i]['sub_menu'][$j]['page_id'] = $rowPage[0]['page_id'];
				}
				else
				{
					$arrMenus5[$i]['sub_menu'][$j]['page_id'] = "";
				}
               
            }
        }
        
        //Gets menus for site and page accessible for Other(Special) Users(Roles) and on Other(Some) of the pages       
        $resultMenu = $obj->Menus_Model->getAllPageMenus($site_id, $page_id, "Other", "Other");
        $arrMenus6 = $resultMenu->result_array();
        for($i=0; $i<sizeof($arrMenus6); $i++)
        {
            $resultMenuItems = $obj->Menus_Model->getMenuItem($arrMenus6[$i]['menu_id'],'Other');    
            $arrMenus6[$i]['sub_menu'] = $resultMenuItems->result_array();
            
            //To fetch the page ID for each menu item.
            for($j=0; $j<count($arrMenus6[$i]["sub_menu"]);$j++)
            {
               $item_id =  $arrMenus6[$i]["sub_menu"][$j]["item_id"]."<br>";
               $resultPage = $obj->Menus_Model->getPage($item_id);
               $rowPage = $resultPage->result_array();
			    if(!empty($rowPage))
				{
					$arrMenus6[$i]['sub_menu'][$j]['page_id'] = $rowPage[0]['page_id'];
				}
				else
				{
					$arrMenus6[$i]['sub_menu'][$j]['page_id'] = "";
				}
               
            }
        }
        $finalArray = array_merge($arrMenus1, $arrMenus2, $arrMenus3, $arrMenus4, $arrMenus5, $arrMenus6);
        $finalArray = $this->sortmulti($finalArray, 'menu_order', 'asc', 'FALSE', 'FALSE');
        
        //$finalArray = $this->sortmulti($finalArray, $finalArray[0][], 'ASC', $natsort=FALSE, $case_sensitive=FALSE);
        
        /*echo "<pre>";
        print_r($arrMenus1);
        print_r($arrMenus2);
        print_r($arrMenus3);
        print_r($arrMenus4);
        print_r($arrMenus5);
        print_r($arrMenus6);
        echo "</pre>";*/
       // exit;
        
        
        return $finalArray;   
    }
    
        //returns menus for display in leftbar region of the template
    function getLeftbar($site_id, $page_id)
    {
        $obj =& get_instance(); 
        //Gets menus for site and page accessible for every one and on all pages       
        $resultMenu = $obj->Menus_Model->getPageMenus($site_id, $page_id, "Left", "Everyone", "All");
        $arrMenus1 = $resultMenu->result_array();
        
        for($i=0; $i<sizeof($arrMenus1); $i++)
        {
            $resultMenuItems = $obj->Menus_Model->getMenuItem($arrMenus1[$i]['menu_id'],'Everyone');    
            $arrMenus1[$i]["sub_menu"] = $resultMenuItems->result_array();
//        echo "<pre>";print_r($arrMenus1[$i]);exit; 
		
            //To fetch the page ID for each menu item.
            for($j=0; $j<count($arrMenus1[$i]["sub_menu"]);$j++)
            {
               $item_id =  $arrMenus1[$i]["sub_menu"][$j]["item_id"]."<br>";
               $resultPage = $obj->Menus_Model->getPage($item_id);
               $rowPage = $resultPage->result_array();
			   //echo "<pre>";print_r($rowPage);exit;
			    if(!empty($rowPage))
				{
					//This will check when page is created under a menu
					if(isset($_SESSION['customer_group_id']))
					{
						if($obj->Menus_Model->is_page_allowed_for_group($rowPage[0]['page_id'],$_SESSION['customer_group_id']))
						{
							$arrMenus1[$i]['sub_menu'][$j]['page_id'] = $rowPage[0]['page_id'];
						}
						else
						{
							$page_not_in_menu[] = $j;
						}
					}
					else
					{
						$arrMenus1[$i]['sub_menu'][$j]['page_id'] = $rowPage[0]['page_id'];
					}
					$arrMenus1[$i]['sub_menu'][$j]['page_id'] = $rowPage[0]['page_id'];	
				}
				else
				{
					//This will check if link is created and a External Link (have not page ID but Menu ID)
					$arrMenus1[$i]['sub_menu'][$j]['page_id'] = "";
				}
               
            }
			  //echo "<pre>";print_r($page_not_in_menu); 
        }
        
		for($i=0;$i<count($arrMenus1);$i++)
		{
			//echo "i m in 1<pre>";
		//	print_r($arrMenus1[$i]);	
		//	exit;
			if(isset($arrMenus1[$i]["sub_menu"]) && (count($arrMenus1[$i]["sub_menu"]) > 0 ) && isset($page_not_in_menu))
			{
				foreach($page_not_in_menu as $key => $val)
				{
				//	unset($arrMenus1[$i]["sub_menu"][$val]);
				}
			}
		}
		
		//echo "<pre>";
		//print_r($arrMenus1);
		
	//	exit;
		
 		//Gets menus for site and page accessible for Everyone and on Other(Some) of the pages       
        $resultMenu = $obj->Menus_Model->getPageMenus($site_id, $page_id, "Left", "Everyone", "Other");
        $arrMenus4 = $resultMenu->result_array();
        for($i=0; $i<sizeof($arrMenus4); $i++)
        {
            $resultMenuItems = $obj->Menus_Model->getMenuItem($arrMenus4[$i]['menu_id']);    
            $arrMenus4[$i]['sub_menu'] = $resultMenuItems->result_array();
            
            //To fetch the page ID for each menu item.
            for($j=0; $j<count($arrMenus4[$i]["sub_menu"]);$j++)
            {
               $item_id =  $arrMenus4[$i]["sub_menu"][$j]["item_id"]."<br>";
               $resultPage = $obj->Menus_Model->getPage($item_id);
               $rowPage = $resultPage->result_array();
				if(!empty($rowPage))
				{
					$arrMenus4[$i]['sub_menu'][$j]['page_id'] = $rowPage[0]['page_id'];
				}
				else
				{
					$arrMenus4[$i]['sub_menu'][$j]['page_id'] = "";
				}
			   
			   
            }
        }
		
		//Gets menus for site and page accessible for Registered(logged-in) users and on all pages       
        if(isset($_SESSION["customer_group_id"]))
		{
			
			$resultMenu = $obj->Menus_Model->getPageMenus($site_id, $page_id, "Left", "Registered", "All");
			$arrMenus2 = $resultMenu->result_array();
			for($i=0; $i<sizeof($arrMenus2); $i++)
			{
				$resultMenuItems = $obj->Menus_Model->getMenuItem($arrMenus2[$i]['menu_id']);    
				$arrMenus2[$i]['sub_menu'] = $resultMenuItems->result_array();
				
				//To fetch the page ID for each menu item.
				for($j=0; $j<count($arrMenus2[$i]["sub_menu"]);$j++)
				{
				   $item_id =  $arrMenus2[$i]["sub_menu"][$j]["item_id"]."<br>";
				   $resultPage = $obj->Menus_Model->getPage($item_id);
				   $rowPage = $resultPage->result_array();
					if(!empty($rowPage))
					{
						$arrMenus2[$i]['sub_menu'][$j]['page_id'] = $rowPage[0]['page_id'];
					}
					else
					{
						$arrMenus2[$i]['sub_menu'][$j]['page_id'] = "";
					}
				   
				}
			}
		
			//Gets menus for site and page accessible for Registered and on Other(Some) of the pages       
			$resultMenu = $obj->Menus_Model->getPageMenus($site_id, $page_id, "Left", "Registered", "Other");
			$arrMenus5 = $resultMenu->result_array();
			for($i=0; $i<sizeof($arrMenus5); $i++)
			{
				$resultMenuItems = $obj->Menus_Model->getMenuItem($arrMenus5[$i]['menu_id']);    
				$arrMenus5[$i]['sub_menu'] = $resultMenuItems->result_array();
				//echo "i m in";exit;
				//To fetch the page ID for each menu item.
				for($j=0; $j<count($arrMenus5[$i]["sub_menu"]);$j++)
				{
				   $item_id =  $arrMenus5[$i]["sub_menu"][$j]["item_id"]."<br>";
				   $resultPage = $obj->Menus_Model->getPage($item_id);
				   $rowPage = $resultPage->result_array();
				   if(!empty($rowPage))
					{
						$arrMenus5[$i]['sub_menu'][$j]['page_id'] = $rowPage[0]['page_id'];
					}
					else
					{
						$arrMenus5[$i]['sub_menu'][$j]['page_id'] = "";
					}
				   
				}
			}
			
		}

        //$finalArray = array_merge($arrMenus1, $arrMenus2);
        
        //Gets menus for site and page accessible for Other(Special) users(Roles) and on all pages       
        $resultMenu = $obj->Menus_Model->getPageMenus($site_id, $page_id, "Left", "Other", "All");
        $arrMenus3 = $resultMenu->result_array();
        for($i=0; $i<sizeof($arrMenus3); $i++)
        {
            $resultMenuItems = $obj->Menus_Model->getMenuItem($arrMenus3[$i]['menu_id']);    
            $arrMenus3[$i]['sub_menu'] = $resultMenuItems->result_array();
            
            //To fetch the page ID for each menu item.
            for($j=0; $j<count($arrMenus3[$i]["sub_menu"]);$j++)
            {
				$item_id =  $arrMenus3[$i]["sub_menu"][$j]["item_id"]."<br>";
				$resultPage = $obj->Menus_Model->getPage($item_id);
				$rowPage = $resultPage->result_array();
				
				if(!empty($rowPage))
				{
					$arrMenus3[$i]['sub_menu'][$j]['page_id'] = $rowPage[0]['page_id'];
				}
				else
				{
					$arrMenus3[$i]['sub_menu'][$j]['page_id'] = "";
				}
            }
        }
    
        
        //Gets menus for site and page accessible for Other(Special) Users(Roles) and on Other(Some) of the pages       
        $resultMenu = $obj->Menus_Model->getPageMenus($site_id, $page_id, "Left", "Other", "Other");
        $arrMenus6 = $resultMenu->result_array();
        for($i=0; $i<sizeof($arrMenus6); $i++)
        {
            $resultMenuItems = $obj->Menus_Model->getMenuItem($arrMenus6[$i]['menu_id']);    
            $arrMenus6[$i]['sub_menu'] = $resultMenuItems->result_array();
            
            //To fetch the page ID for each menu item.
            for($j=0; $j<count($arrMenus6[$i]["sub_menu"]);$j++)
            {
               $item_id =  $arrMenus6[$i]["sub_menu"][$j]["item_id"]."<br>";
               $resultPage = $obj->Menus_Model->getPage($item_id);
               $rowPage = $resultPage->result_array();
			   if(!empty($rowPage))
				{
					$arrMenus6[$i]['sub_menu'][$j]['page_id'] = $rowPage[0]['page_id'];
				}
				else
				{
					$arrMenus6[$i]['sub_menu'][$j]['page_id'] = "";
				}
               
            }
        }
        
        $finalArray = array_merge($arrMenus1, $arrMenus3, $arrMenus4,$arrMenus6);
		if(isset($arrMenus2))
		{
			$finalArray = array_merge($finalArray,$arrMenus2);
		}
		if(isset($arrMenus5))
		{
			$finalArray = array_merge($finalArray,$arrMenus5);
		}
		
		 
		
		
        // print_r($finalArray); exit();
        $finalArray = $this->sortmulti($finalArray, 'menu_order', 'asc', 'FALSE', 'FALSE');
        return $finalArray;
        
    }

        //returns menus for display in rightbar region of the template
    function getRightbar($site_id, $page_id)
    {
        $obj =& get_instance();
        //Gets menus for site and page accessible for every one and on all pages       
        $resultMenu = $obj->Menus_Model->getPageMenus($site_id, $page_id, "Right", "Everyone", "All");
        $arrMenus1 = $resultMenu->result_array();
        
        for($i=0; $i<sizeof($arrMenus1); $i++)
        {
            $resultMenuItems = $obj->Menus_Model->getMenuItem($arrMenus1[$i]['menu_id']);    
            $arrMenus1[$i]["sub_menu"] = $resultMenuItems->result_array();
        
            //To fetch the page ID for each menu item.
            for($j=0; $j<count($arrMenus1[$i]["sub_menu"]);$j++)
            {
               $item_id =  $arrMenus1[$i]["sub_menu"][$j]["item_id"]."<br>";
               $resultPage = $obj->Menus_Model->getPage($item_id);
               $rowPage = $resultPage->result_array();
               $arrMenus1[$i]['sub_menu'][$j]['page_id'] = $rowPage[0]['page_id'];
            }
        }
        
        /*echo "<pre>";
        print_r($arrMenus1);
        exit;*/
        
        //Gets menus for site and page accessible for Registered(logged-in) users and on all pages       
        $resultMenu = $obj->Menus_Model->getPageMenus($site_id, $page_id, "Right", "Registered", "All");
        $arrMenus2 = $resultMenu->result_array();
        for($i=0; $i<sizeof($arrMenus2); $i++)
        {
            $resultMenuItems = $obj->Menus_Model->getMenuItem($arrMenus2[$i]['menu_id']);    
            $arrMenus2[$i]['sub_menu'] = $resultMenuItems->result_array();
            
            //To fetch the page ID for each menu item.
            for($j=0; $j<count($arrMenus2[$i]["sub_menu"]);$j++)
            {
               $item_id =  $arrMenus2[$i]["sub_menu"][$j]["item_id"]."<br>";
               $resultPage = $obj->Menus_Model->getPage($item_id);
               $rowPage = $resultPage->result_array();
               $arrMenus2[$i]['sub_menu'][$j]['page_id'] = $rowPage[0]['page_id'];
            }
        }
        /*echo "<pre>";
        print_r($arrMenus1);
        exit;*/
        //$finalArray = array_merge($arrMenus1, $arrMenus2);
        
        //Gets menus for site and page accessible for Other(Special) users(Roles) and on all pages       
        $resultMenu = $obj->Menus_Model->getPageMenus($site_id, $page_id, "Right", "Other", "All");
        $arrMenus3 = $resultMenu->result_array();
        for($i=0; $i<sizeof($arrMenus3); $i++)
        {
            $resultMenuItems = $obj->Menus_Model->getMenuItem($arrMenus3[$i]['menu_id']);    
            $arrMenus3[$i]['sub_menu'] = $resultMenuItems->result_array();
            
            //To fetch the page ID for each menu item.
            for($j=0; $j<count($arrMenus3[$i]["sub_menu"]);$j++)
            {
               $item_id =  $arrMenus3[$i]["sub_menu"][$j]["item_id"]."<br>";
               $resultPage = $obj->Menus_Model->getPage($item_id);
               $rowPage = $resultPage->result_array();
               $arrMenus3[$i]['sub_menu'][$j]['page_id'] = $rowPage[0]['page_id'];
            }
        }
        
        //Gets menus for site and page accessible for Everyone and on Other(Some) of the pages       
        $resultMenu = $obj->Menus_Model->getPageMenus($site_id, $page_id, "Right", "Everyone", "Other");
        $arrMenus4 = $resultMenu->result_array();
        for($i=0; $i<sizeof($arrMenus4); $i++)
        {
            $resultMenuItems = $obj->Menus_Model->getMenuItem($arrMenus4[$i]['menu_id']);    
            $arrMenus4[$i]['sub_menu'] = $resultMenuItems->result_array();
            
            //To fetch the page ID for each menu item.
            for($j=0; $j<count($arrMenus4[$i]["sub_menu"]);$j++)
            {
               $item_id =  $arrMenus4[$i]["sub_menu"][$j]["item_id"]."<br>";
               $resultPage = $obj->Menus_Model->getPage($item_id);
               $rowPage = $resultPage->result_array();
               $arrMenus4[$i]['sub_menu'][$j]['page_id'] = $rowPage[0]['page_id'];
            }
        }
        
        //Gets menus for site and page accessible for Registered and on Other(Some) of the pages       
        $resultMenu = $obj->Menus_Model->getPageMenus($site_id, $page_id, "Right", "Registered", "Other");
        $arrMenus5 = $resultMenu->result_array();
        for($i=0; $i<sizeof($arrMenus5); $i++)
        {
            $resultMenuItems = $obj->Menus_Model->getMenuItem($arrMenus5[$i]['menu_id']);    
            $arrMenus5[$i]['sub_menu'] = $resultMenuItems->result_array();
            
            //To fetch the page ID for each menu item.
            for($j=0; $j<count($arrMenus5[$i]["sub_menu"]);$j++)
            {
               $item_id =  $arrMenus5[$i]["sub_menu"][$j]["item_id"]."<br>";
               $resultPage = $obj->Menus_Model->getPage($item_id);
               $rowPage = $resultPage->result_array();
               $arrMenus5[$i]['sub_menu'][$j]['page_id'] = $rowPage[0]['page_id'];
            }
        }
        
        //Gets menus for site and page accessible for Other(Special) Users(Roles) and on Other(Some) of the pages       
        $resultMenu = $obj->Menus_Model->getPageMenus($site_id, $page_id, "Right", "Other", "Other");
        $arrMenus6 = $resultMenu->result_array();
        for($i=0; $i<sizeof($arrMenus6); $i++)
        {
            $resultMenuItems = $obj->Menus_Model->getMenuItem($arrMenus6[$i]['menu_id']);    
            $arrMenus6[$i]['sub_menu'] = $resultMenuItems->result_array();
            
            //To fetch the page ID for each menu item.
            for($j=0; $j<count($arrMenus6[$i]["sub_menu"]);$j++)
            {
               $item_id =  $arrMenus6[$i]["sub_menu"][$j]["item_id"]."<br>";
               $resultPage = $obj->Menus_Model->getPage($item_id);
               $rowPage = $resultPage->result_array();
               $arrMenus6[$i]['sub_menu'][$j]['page_id'] = $rowPage[0]['page_id'];
            }
        }
        
        $finalArray = array_merge($arrMenus1, $arrMenus2, $arrMenus3, $arrMenus4, $arrMenus5, $arrMenus6);
        $finalArray = $this->sortmulti($finalArray, 'menu_order', 'asc', 'FALSE', 'FALSE');
        return $finalArray;
            
    }
    
    function getTopNavigation($site_id, $page_id)
    {
        $obj =& get_instance();
        //Gets menus for site and page accessible for every one and on all pages       
        $resultMenu = $obj->Menus_Model->getPageMenus($site_id, $page_id, "Top", "Everyone", "All");
        $arrMenus1 = $resultMenu->result_array();
        
        for($i=0; $i<sizeof($arrMenus1); $i++)
        {
            $resultMenuItems = $obj->Menus_Model->getMenuItem($arrMenus1[$i]['menu_id']);    
            $arrMenus1[$i]["sub_menu"] = $resultMenuItems->result_array();
        
            //To fetch the page ID for each menu item.
            for($j=0; $j<count($arrMenus1[$i]["sub_menu"]);$j++)
            {
               $item_id =  $arrMenus1[$i]["sub_menu"][$j]["item_id"]."<br>";
               $resultPage = $obj->Menus_Model->getPage($item_id);
               $rowPage = $resultPage->result_array();
               $arrMenus1[$i]['sub_menu'][$j]['page_id'] = $rowPage[0]['page_id'];
            }
        }
        
        //Gets menus for site and page accessible for Registered(logged-in) users and on all pages       
        $resultMenu = $obj->Menus_Model->getPageMenus($site_id, $page_id, "Top", "Registered", "All");
        $arrMenus2 = $resultMenu->result_array();
        for($i=0; $i<sizeof($arrMenus2); $i++)
        {
            $resultMenuItems = $obj->Menus_Model->getMenuItem($arrMenus2[$i]['menu_id']);    
            $arrMenus2[$i]['sub_menu'] = $resultMenuItems->result_array();
            
            //To fetch the page ID for each menu item.
            for($j=0; $j<count($arrMenus2[$i]["sub_menu"]);$j++)
            {
               $item_id =  $arrMenus2[$i]["sub_menu"][$j]["item_id"]."<br>";
               $resultPage = $obj->Menus_Model->getPage($item_id);
               $rowPage = $resultPage->result_array();
               $arrMenus2[$i]['sub_menu'][$j]['page_id'] = $rowPage[0]['page_id'];
            }
        }
        
        //Gets menus for site and page accessible for Other(Special) users(Roles) and on all pages       
        $resultMenu = $obj->Menus_Model->getPageMenus($site_id, $page_id, "Top", "Other", "All");
        $arrMenus3 = $resultMenu->result_array();
        for($i=0; $i<sizeof($arrMenus3); $i++)
        {
            $resultMenuItems = $obj->Menus_Model->getMenuItem($arrMenus3[$i]['menu_id']);    
            $arrMenus3[$i]['sub_menu'] = $resultMenuItems->result_array();
            
            //To fetch the page ID for each menu item.
            for($j=0; $j<count($arrMenus3[$i]["sub_menu"]);$j++)
            {
               $item_id =  $arrMenus3[$i]["sub_menu"][$j]["item_id"]."<br>";
               $resultPage = $obj->Menus_Model->getPage($item_id);
               $rowPage = $resultPage->result_array();
               $arrMenus3[$i]['sub_menu'][$j]['page_id'] = $rowPage[0]['page_id'];
            }
        }
        
        //Gets menus for site and page accessible for Everyone and on Other(Some) of the pages       
        $resultMenu = $obj->Menus_Model->getPageMenus($site_id, $page_id, "Top", "Everyone", "Other");
        $arrMenus4 = $resultMenu->result_array();
        for($i=0; $i<sizeof($arrMenus4); $i++)
        {
            $resultMenuItems = $obj->Menus_Model->getMenuItem($arrMenus4[$i]['menu_id']);    
            $arrMenus4[$i]['sub_menu'] = $resultMenuItems->result_array();
            
            //To fetch the page ID for each menu item.
            for($j=0; $j<count($arrMenus4[$i]["sub_menu"]);$j++)
            {
               $item_id =  $arrMenus4[$i]["sub_menu"][$j]["item_id"]."<br>";
               $resultPage = $obj->Menus_Model->getPage($item_id);
               $rowPage = $resultPage->result_array();
               $arrMenus4[$i]['sub_menu'][$j]['page_id'] = $rowPage[0]['page_id'];
            }
        }
        
        //Gets menus for site and page accessible for Registered and on Other(Some) of the pages       
        $resultMenu = $obj->Menus_Model->getPageMenus($site_id, $page_id, "Top", "Registered", "Other");
        $arrMenus5 = $resultMenu->result_array();
        for($i=0; $i<sizeof($arrMenus5); $i++)
        {
            $resultMenuItems = $obj->Menus_Model->getMenuItem($arrMenus5[$i]['menu_id']);    
            $arrMenus5[$i]['sub_menu'] = $resultMenuItems->result_array();
            
            //To fetch the page ID for each menu item.
            for($j=0; $j<count($arrMenus5[$i]["sub_menu"]);$j++)
            {
               $item_id =  $arrMenus5[$i]["sub_menu"][$j]["item_id"]."<br>";
               $resultPage = $obj->Menus_Model->getPage($item_id);
               $rowPage = $resultPage->result_array();
               $arrMenus5[$i]['sub_menu'][$j]['page_id'] = $rowPage[0]['page_id'];
            }
        }
        
        //Gets menus for site and page accessible for Other(Special) Users(Roles) and on Other(Some) of the pages       
        $resultMenu = $obj->Menus_Model->getPageMenus($site_id, $page_id, "Top", "Other", "Other");
        $arrMenus6 = $resultMenu->result_array();
        for($i=0; $i<sizeof($arrMenus6); $i++)
        {
            $resultMenuItems = $obj->Menus_Model->getMenuItem($arrMenus6[$i]['menu_id']);    
            $arrMenus6[$i]['sub_menu'] = $resultMenuItems->result_array();
            
            //To fetch the page ID for each menu item.
            for($j=0; $j<count($arrMenus6[$i]["sub_menu"]);$j++)
            {
               $item_id =  $arrMenus6[$i]["sub_menu"][$j]["item_id"]."<br>";
               $resultPage = $obj->Menus_Model->getPage($item_id);
               $rowPage = $resultPage->result_array();
               $arrMenus6[$i]['sub_menu'][$j]['page_id'] = $rowPage[0]['page_id'];
            }
        }
        
        $finalArray = array_merge($arrMenus1, $arrMenus2, $arrMenus3, $arrMenus4, $arrMenus5, $arrMenus6);
        $finalArray = $this->sortmulti($finalArray, 'menu_order', 'asc', 'FALSE', 'FALSE');
        return $finalArray;    
    }

    
         // function set and get template dynamicly
    function set_site_color_scheme($site_id)
    {
        
        $obj =& get_instance(); 
        $color_scheme = $obj->Menus_Model->get_scheme_color($site_id);
       // $data['color_scheme'] = $this->Menus_Model->get_scheme_color($site_id);
        if(isset($color_scheme)){
        /*echo '<pre>';
            print_r($color_scheme);
             echo '</pre>';
             exit();*/
        $anchor_style  = $anchor_style_active = $my_css_anchor ='';
        if(array_key_exists('default',$color_scheme) && $color_scheme['default'] != '' && $color_scheme['default'] != 'Default'){
            
            $anchor_backgroud =  (array_key_exists('primary_color',$color_scheme)) ?  $color_scheme['primary_color'] : '';
            $anchor_txt =  (array_key_exists('primary_txt',$color_scheme)) ?  $color_scheme['primary_txt'] : '';
            $anchor_back_active =  (array_key_exists('secondary_color',$color_scheme)) ?  $color_scheme['secondary_color'] : '';
            $anchor_back_txt =  (array_key_exists('secondary_txt',$color_scheme)) ?  $color_scheme['secondary_txt'] : '';
          //  $anchor_others =  (array_key_exists('tertiary_color',$color_scheme)) ?  $color_scheme['tertiary_color'] : '';
          //  $anchor_txt =  (array_key_exists('tertiary_txt',$color_scheme)) ?  $color_scheme['tertiary_txt'] : '';
          
          $anchor_style  .= 'style=" ';
          $anchor_style .= 'background-color: #'.trim($anchor_backgroud).'; ';
          $anchor_style .= 'color: #'.trim($anchor_txt).'; ';
          $anchor_style .= ' " ';
          //echo $anchor_style;
         
          $anchor_style_active .= 'style=" ';
          $anchor_style_active .= 'background-color: #'.trim($anchor_back_active).'; ';
          $anchor_style_active .= 'color: #'.trim($anchor_back_txt).'; ';
          $anchor_style_active .= ' " ';
          
         $my_css_anchor = ' 
                a.link_style:link , a.link_style:visited {color: #'.trim($anchor_txt).';  background-color: #'.trim($anchor_backgroud).';}
               /* a.link_style:visited {color: #'.trim($anchor_txt).';  background-color: #'.trim($anchor_backgroud).';} */
                a.link_style:hover {color: #'.trim($anchor_back_txt).';  background-color: #'.trim($anchor_back_active).';}
               /* a.link_style:focus {color: #'.trim($anchor_txt).';  background-color: #'.trim($anchor_backgroud).';}  */
                a.link_style:active , a.link_style:hover {color: #'.trim($anchor_back_txt).';  background-color: #'.trim($anchor_back_active).';}
            ';
          
        }
        
    }
      //  $my_css_li = ' .li_style{ cursor:hand;  cursor:pointer;  } .switchgroup1{ margin:4px 0px 8px 36px; } ';
       
       // $this->template->add_css($my_css,'embed');                                                                   
         return $my_css_anchor;
        
        
    }
    


}
?>