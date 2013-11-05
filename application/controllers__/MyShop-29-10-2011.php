<?php
if(!session_start()){
    session_start(); }

    class MyShop extends CI_Controller { // Our Cart class extends the Controller class
    
         var $site_id;
         var $user_id;
         var $temp_name;
           
        function MyShop()
        {
            parent::__construct();  // We define the the Controller class is the parent.    
            $this->load->model('cart_model'); // Load our cart model for our entire class
            $this->load->model('categories_model');  
            $this->load->model('shop_model');  
            $this->load->model('product_model');  
            $this->load->library('cart');
            $this->load->helper('url');      
            $this->load->helper('html'); 
            $this->load->library('template');
            $this->load->library('my_template_menu');
            
            $this->load->library('pagination');
           // $this->load->library('table'); 
            
            $this->site_id = $_SESSION['site_id'];   
            $this->user_id = $_SESSION['user_info']['user_id']; 
            $this->temp_name =  $this->my_template_menu->set_get_template($this->site_id); 

        }
        
        function index( $cat_id=0, $offset=NULL )
        {
            
           // print_r($_SESSION);  exit();
            $data = array ();
            $top_site_menu_basic =  $this->Menus_Model->top_navigation_default($this->site_id);
            $other_top_navigation =  $this->Menus_Model->top_navigation_eshop($this->site_id,$this->user_id);  
            $this->template->write('title', 'Online Shop');
            $data['site_id']=$this->site_id;
            $this->template->write_view('logo', $this->temp_name.'/logo', $data);
            $this->template->write('description', 'online product store'); 
            $this->template->write('keywords', 'online product store , Eshop,Ecommerce'); 
            $data["site_name"] = '';  


           $menu_data['menu'] =  $top_site_menu_basic;
           $menu_data['other_top_navigation'] =  $other_top_navigation; 
           $this->template->write_view('menu', $this->temp_name.'/menu', $menu_data); 
            
            // Retrieve an array with all products
            //--------------------- paging variables ----------------------------//
                $store_settings = $this->shop_model->get_store_settings($this->site_id);
                $total = $this->product_model->count_posts($cat_id);
                $config['base_url'] = base_url().index_page().'MyShop/index/'.$cat_id.'/';
               // $config['total_rows'] = $this->db->get('tblname')->num_rows(); 
                $config['total_rows'] = intval($total);
                $config['per_page'] = intval($store_settings['product_per_page']);
                $config['num_links'] = intval($store_settings['link_per_page']);  
             //  print_r($config['per_page']); echo '>>>>>>>>>>>'; exit();
               // $config['per_page'] = 5;
               // $config['num_links'] = 20;  
               
               
                $config['full_tag_open'] = '<div id="pagination" style="float:right; margin:10px 0px 20px 0px;">';
                $config['full_tag_close'] = '</div>';
                
                $this->pagination->initialize($config);
                
             //   $data['records'] = $this->db->get('data', $config['per_page'], $this->uri->segment(3)); \
             $data['products'] = $this->product_model->getProductsByCategory(intval($cat_id), $config['per_page'], $offset);
            //--------------------- /paging variables ----------------------------//

            
           if($cat_id != 0 )
           {  
                $site_name =  $this->categories_model->getSiteNameById($this->site_id);
                $cat_data =  $this->categories_model->getCategory(intval($cat_id),$this->site_id);
                $cat_name = str_replace(' ','_',strtolower(trim($cat_data['cat_name'])));
                $data["img_path_full"] = $site_name.'/'.$cat_name.'/full_size';  
                $data["img_path_thumb"] = $site_name.'/'.$cat_name.'/thumb';
           }
           // $this->template->write_view('content','cart/product_grid',$data);
            $data['view'] = $store_settings['product_view'];
            if($cat_id== 0){
            $data['ishome'] = 'yes';
            }else{
                $data['ishome'] = 'no';
            }
            $this->template->write_view('content','cart/products',$data);
            
            $all_categories = $this->categories_model->getAllCategories_shop($this->site_id);
           //echo '<pre>'; print_r($all_categories); exit();
            
            $data['left_menus'] = $all_categories;  
            $data['left_menus_type'] = 'myshop'; 

            $this->template->write_view('leftbar', $this->temp_name.'/leftbar', $data); 
            
          //  $data['right_menus'] = '';
           // $this->template->write_view('rightbar', $temp_name.'/rightbar', $data); 
            
            $this->template->render();
        }
        
     function detail( $pd_id=0 )
        {

            $data = array ();
            $top_site_menu_basic =  $this->Menus_Model->top_navigation_default($this->site_id);
            $other_top_navigation =  $this->Menus_Model->top_navigation_eshop($this->site_id,$this->user_id);  
            $this->template->write('title', 'Online Shop');
            $data['site_id']=$this->site_id;
            $this->template->write_view('logo', $this->temp_name.'/logo', $data);
            $this->template->write('description', 'online product store'); 
            $this->template->write('keywords', 'online product store , Eshop,Ecommerce'); 
            $data["site_name"] = '';  

           $menu_data['menu'] =  $top_site_menu_basic;
           $menu_data['other_top_navigation'] =  $other_top_navigation; 
           $this->template->write_view('menu', $this->temp_name.'/menu', $menu_data); 
            
           $data['product'] = $this->product_model->getProduct(intval($pd_id)); // Retrieve an array with all products

            
            $site_name =  $this->categories_model->getSiteNameById($this->site_id);
            $cat_data =  $this->categories_model->getCategoryNamebyProductID(intval($pd_id),$this->site_id); 
            $cat_name = str_replace(' ','_',strtolower(trim($cat_data['cat_name'])));
            $data["img_path_full"] = $site_name.'/'.$cat_name.'/full_size';  
            $data["img_path_thumb"] = $site_name.'/'.$cat_name.'/thumb';
            
            $this->template->write_view('content','cart/products_details',$data);
            
            $all_categories = $this->categories_model->getAllCategories_shop($this->site_id);
           //echo '<pre>'; print_r($all_categories); exit();
            
            $data['left_menus'] = $all_categories;  
            $data['left_menus_type'] = 'myshop';  
            $this->template->write_view('leftbar', $this->temp_name.'/leftbar', $data); 
            
          //  $data['right_menus'] = '';
           // $this->template->write_view('rightbar', $temp_name.'/rightbar', $data); 
            
            $this->template->render();
        }
        

       function mycart( )
        {

             $data = array ();
            $top_site_menu_basic =  $this->Menus_Model->top_navigation_default($this->site_id);
            $other_top_navigation =  $this->Menus_Model->top_navigation_eshop($this->site_id,$this->user_id);  
            $this->template->write('title', 'Online Shop');
            $data['site_id']=$this->site_id;
            $this->template->write_view('logo', $this->temp_name.'/logo', $data);
            $this->template->write('description', 'online product store'); 
            $this->template->write('keywords', 'online product store , Eshop,Ecommerce'); 
            $data["site_name"] = '';  

           $menu_data['menu'] =  $top_site_menu_basic;
           $menu_data['other_top_navigation'] =  $other_top_navigation; 
           $this->template->write_view('menu', $this->temp_name.'/menu', $menu_data); 

            $this->template->write_view('content','cart/cart',$data);
            
            $all_categories = $this->categories_model->getAllCategories_shop($this->site_id);
           //echo '<pre>'; print_r($all_categories); exit();
            
            $data['left_menus'] = $all_categories;  
            $data['left_menus_type'] = 'myshop';  
            $this->template->write_view('leftbar', $this->temp_name.'/leftbar', $data); 
            
          //  $data['right_menus'] = '';
           // $this->template->write_view('rightbar', $temp_name.'/rightbar', $data); 
            
            $this->template->render();
        }
        
        
        function add_cart_item(){
            
            if($this->cart_model->validate_add_cart_item() == TRUE){
                
                // Check if user has javascript enabled
                if($this->input->post('ajax') != '1'){
                    redirect('MyShop/mycart'); // If javascript is not enabled, reload the page with new data
                }else{
                    echo 'true'; // If javascript is enabled, return true, so the cart gets updated
                }
            }
            
        }
    
        function update_cart(){
            $this->cart_model->validate_update_cart();
            redirect('MyShop');
        }
        
                                                     
        function show_cart(){
            $this->load->view('cart/cart');
        }
    
        function empty_cart(){
            $this->cart->destroy();
            redirect('MyShop');
        }
 }


/* End of file cart.php */
/* Location: ./application/controllers/cart.php */
?>