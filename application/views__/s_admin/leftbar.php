<div id="mws-sidebar">
        
            <!-- Hidden Nav Collapse Button -->
            <div id="mws-nav-collapse">
                <span></span>
                <span></span>
                <span></span>
            </div>
            
            <!-- Searchbox -->
            <div id="mws-searchbox" class="mws-inset">
                <form action="">
                    <input type="text" class="mws-search-input" placeholder="Search...">
                    <button type="submit" class="mws-search-submit"><i class="icon-search"></i></button>
                </form>
            </div>
            
            <!-- Main Navigation -->
            <div id="mws-navigation">
                <ul>
                    <li <?php if( $left_bar == "dashboard" ){ echo 'class="active"';}?> ><a href="<?php echo base_url().'administrator/dashboard';?>"><i class="icon-home"></i> Dashboard</a></li>
                    <li <?php if( $left_bar == "design_congif" ){ echo 'class="active"';}?>><a href="<?=base_url().index_page()?>administrator/design_config/"><i class="icon-frame small"></i>Design & Configuration</a></li>
                    <li <?php if( $left_bar == "site_content" ){ echo 'class="active"';}?> ><a href="<?=base_url().index_page()?>administrator/site_content/"> <i class="icon-archive"></i>archiveSite Content</a></li>
                    <li <?php if( $left_bar == "member_group" ){ echo 'class="active"';}?> ><a href="<?=base_url().index_page()?>administrator/members_groups/"> <i class="icon-users"></i>Members & Groups</a></li>
                    <!--<li><a href="<?=base_url().index_page()?>administrator/newsletter/"> <i class="icon-envelope"></i>Newsletter</a></li>
                    <li><a href="<?=base_url().index_page()?>administrator/ecommerce/"> <i class="icon-shopping-cart"></i>E-Commerce</a></li>-->
                    <li <?php if( $left_bar == "packages" ){ echo 'class="active"';}?> ><a href="<?=base_url().index_page()?>administrator/packages/"> <i class="icon-briefcase"></i>Packages</a></li>
                    <li <?php if( $left_bar == "subadmin" ){ echo 'class="active"';}?> ><a href="<?=base_url().index_page()?>administrator/user_affiliate/all_subAdmin"> <i class="icon-accessibility-2"></i>Sub Admins</a></li>
                    <li <?php if( $left_bar == "affiliate" ){ echo 'class="active"';}?> ><a href="<?=base_url().index_page()?>administrator/user_affiliate/affiliate"> <i class="icon-accessibility"></i>Affiliate</a></li>

                    <!--<li <?php if( $left_bar == "user" ){ echo 'class="active"';}?>><a href="<?php echo URL.'index.php/pages/all_user';?>"><i class="icon-users"></i> Users</a></li>
                    <li <?php if( $left_bar == "category" ){ echo 'class="active"';}?>><a href="<?php echo URL.'index.php/pages/all_categories';?>"><i class="icon-network"></i>Categories</a></li>
                    <li <?php if( $left_bar == "sub_category" ){ echo 'class="active"';}?>><a href="<?php echo URL.'index.php/pages/all_sub_categories';?>"><i class="icon-filter"></i>Sub Categories</a></li>
                    <li <?php if( $left_bar == "product" ){ echo 'class="active"';}?>><a href="<?php echo URL.'index.php/pages/all_records';?>"><i class="icon-shopping-cart"></i>Products</a></li>
                    <li <?php if( $left_bar == "shop" ){ echo 'class="active"';}?>><a href="<?php echo URL.'index.php/pages/all_shops';?>"><i class="icon-table"></i>Shop</a></li>
                    <li <?php if( $left_bar == "order" ){ echo 'class="active"';}?>><a href="<?php echo URL.'index.php/pages/all_order';?>"><i class="icon-inbox"></i>Orders</a></li>-->
                   
                </ul>
            </div>         
        </div>