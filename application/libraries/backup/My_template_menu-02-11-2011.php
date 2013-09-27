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
        $resultMenu = $obj->Menus_Model->getAllPageMenus($site_id, $page_id, "Registered", "All");
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
        $resultMenu = $obj->Menus_Model->getAllPageMenus($site_id, $page_id, "Other", "All");
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
        $resultMenu = $obj->Menus_Model->getAllPageMenus($site_id, $page_id, "Everyone", "Other");
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
        $resultMenu = $obj->Menus_Model->getAllPageMenus($site_id, $page_id, "Registered", "Other");
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
        $resultMenu = $obj->Menus_Model->getAllPageMenus($site_id, $page_id, "Other", "Other");
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
        
        //$finalArray = $this->sortmulti($finalArray, $finalArray[0][], 'ASC', $natsort=FALSE, $case_sensitive=FALSE);
        /*
        echo "<pre>";
        print_r($finalArray);
        exit;
        */
        
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
               $arrMenus2[$i]['sub_menu'][$j]['page_id'] = $rowPage[0]['page_id'];
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
               $arrMenus3[$i]['sub_menu'][$j]['page_id'] = $rowPage[0]['page_id'];
            }
        }
        
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
               $arrMenus4[$i]['sub_menu'][$j]['page_id'] = $rowPage[0]['page_id'];
            }
        }
        
        //Gets menus for site and page accessible for Registered and on Other(Some) of the pages       
        $resultMenu = $obj->Menus_Model->getPageMenus($site_id, $page_id, "Left", "Registered", "Other");
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
               $arrMenus6[$i]['sub_menu'][$j]['page_id'] = $rowPage[0]['page_id'];
            }
        }
        
        $finalArray = array_merge($arrMenus1, $arrMenus2, $arrMenus3, $arrMenus4, $arrMenus5, $arrMenus6);
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

    



}
?>  