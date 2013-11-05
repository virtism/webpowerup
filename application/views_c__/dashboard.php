
<div class="RightColumnHeading">
    <h1>
        <span>Site Traffic</span>
    </h1>
    
    <div class="RightSideButton">
        <a href="<?=base_url()?>Promotional_Boxes_Management/">
            <img src="<?=base_url()?>images/webpowerup/CreateBoxes.png" alt="Create Boxes"/>
        </a>
    </div>
</div>

<div class="MainPage">
            <div class="box" style="width:743px !important;">
    <div class="inside">
        <div class="in">
        	<div id="graph_show_home1" style="width: 100%; height: 236px;"></div>
        </div>
    </div>
</div>
        	
            <ul>
            	<li>
                	<div class="InfoBox">
                    	<div class="MainBox">
                        	<div class="BoxHeading">
                            	<h1>
                                	<img src="<?=base_url()?>images/webpowerup/HeadingIcon.png" alt="Configuration"/>
                                    <span>Design & Configuration </span>
                                </h1>
                                <a href="#">
                                	<img src="<?=base_url()?>images/webpowerup/DownArrow.png" alt="DownArrow"/>
                                </a>
                            </div>
                            <div class="MainIcon">
                            	<img src="<?=base_url()?>images/webpowerup/MainIcon1.png" alt="MainIcon"/>
                            </div>
                            <ul class="BoxData">
                            	<li> 
                                	<a href="<?=base_url().index_page()?>scheme_settings/index/<?=$_SESSION['site_id']?>"> Color Scheme Management</a>
                                </li>
                                <li> 
                                	<a href="<?=base_url().index_page()?>font_setting/index/<?=$_SESSION['site_id']?>"> Set Menu Font</a>
                                </li>
                                <li> 
                                	<a href="<?=base_url().index_page()?>FooterController/index/<?=$_SESSION['site_id']?>"> Footer Managment</a>
                                </li>
                                <li> 
                                	<a href="<?=base_url().index_page()?>SiteController/change_site_template/<?=$_SESSION['site_id']?>"> Change Template</a>
                                </li>
                                <?php /*?><li> 
                                	<a href="#"> Contact Form Management</a>
                                </li><?php */?>
                            </ul>
                        </div>
                    </div>
                </li>
                <li>
                	<div class="InfoBox">
                    	<div class="MainBox">
                        	<div class="BoxHeading">
                            	<h1>
                                	<img src="<?=base_url()?>images/webpowerup/HeadingIcon.png" alt="Configuration"/>
                                    <span>Web Pages </span>
                                </h1>
                                <a href="#">
                                	<img src="<?=base_url()?>images/webpowerup/DownArrow.png" alt="DownArrow"/>
                                </a>
                            </div>
                            <div class="MainIcon">
                            	<img src="<?=base_url()?>images/webpowerup/MainIcon2.png" alt="MainIcon"/>
                            </div>
                            <ul class="BoxData">
                            	<li> 
                                	<a href="<?=base_url().index_page()?>pagesController/basic_info/<?=$_SESSION['site_id']?>"> Create a Page</a>
                                </li>
                                <li> 
                                	<a href="<?=base_url().index_page()?>pagesController/index/<?=$_SESSION['site_id']?>/0"> Manage Web Pages</a>
                                </li>
                                <?php 
								// echo count($blog); die();
								if(count($blog) > 0)
								{ ?>
                                	<li> 
                                		<a href="<?=base_url().index_page()?>blog_managment/blog/<?=$blog['id'];?>">Manage your blog post</a>
                                    </li>
                                <?php 
								}
								else
								{ ?>
                                    <li> 
                                        <a href="<?=base_url().index_page()?>blog_managment/create_blog"> Create a blog post</a>
                                    </li>
                                <?php
								} ?>
                                
                              <li> 
                                	<a href="<?=base_url().index_page()?>pagesController/basic_info/<?=$_SESSION['site_id']?>/private">Create a private page</a>
                                </li>
                                <li> 
                                	<a href="<?=base_url().index_page()?>SiteController/contact_management/<?=$_SESSION['site_id']?>">Create a contact page(UC)</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li>
                	<div class="InfoBox">
                    	<div class="MainBox">
                        	<div class="BoxHeading">
                            	<h1>
                                	<img src="<?=base_url()?>images/webpowerup/HeadingIcon.png" alt="Configuration"/>
                                    <span>Forms </span>
                                </h1>
                                <a href="#">
                                	<img src="<?=base_url()?>images/webpowerup/DownArrow.png" alt="DownArrow"/>
                                </a>
                            </div>
                            <div class="MainIcon">
                            	<img src="<?=base_url()?>images/webpowerup/MainIcon3.png" alt="MainIcon"/>
                            </div>
                            <ul class="BoxData">
                            	<li> 
                                	<a href="<?=base_url().index_page()?>menusController/createMenu/<?=$_SESSION['site_id']?>">Create a Menu</a>
                                </li>
                                <li> 
                                	<a href="<?=base_url().index_page()?>menusController/index/<?=$_SESSION['site_id']?>/0"> Manage Menus</a>
                                </li>
                                <li style="white-space:nowrap;"> 
                                	<a href="<?=base_url().index_page()?>Registration_Froms/"> Create a Registration form</a>
                                    <?php /*?>&nbsp;|&nbsp;
                                    <a style="background:none; float:left; overflow:none; width:50px; border:red solid 1px; padding:0; margin:0;" href="<?=base_url().index_page()?>Registration_Froms/details">Details</a><?php */?>
                                </li>
                                <li> 
                                	<a href="#"> Create a poll(UC)</a>
                                </li>
                                <li> 
                                	<a href="<?=base_url().index_page()?>Promotional_Boxes_Management/"> Promotional Ads</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
            <ul>
            	<li>
                	<div class="InfoBox">
                    	<div class="MainBox">
                        	<div class="BoxHeading">
                            	<h1>
                                	<img src="<?=base_url()?>images/webpowerup/HeadingIcon.png" alt="Configuration"/>
                                    <span>Members </span>
                                </h1>
                                <a href="#">
                                	<img src="<?=base_url()?>images/webpowerup/DownArrow.png" alt="DownArrow"/>
                                </a>
                            </div>
                            <div class="MainIcon">
                            	<img src="<?=base_url()?>images/webpowerup/MainIcon4.png" alt="MainIcon"/>
                            </div>
                            <ul class="BoxData">
                            	<li> 
                                	<a href="<?=base_url().index_page()?>customers/"> Create Members/Search for Members</a>
                                </li>
                                <li> 
                                	<a href="<?=base_url().index_page()?>invoice/invoice_managment_view"> Create Invoices</a>
                                </li>
                                <li> 
                                	<a href="#"> Add note to client's record(UC) </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li>
                	<div class="InfoBox">
                    	<div class="MainBox">
                        	<div class="BoxHeading">
                            	<h1>
                                	<img src="<?=base_url()?>images/webpowerup/HeadingIcon.png" alt="Configuration"/>
                                    <span>Groups </span>
                                </h1>
                                <a href="#">
                                	<img src="<?=base_url()?>images/webpowerup/DownArrow.png" alt="DownArrow"/>
                                </a>
                            </div>
                            <div class="MainIcon">
                            	<img src="<?=base_url()?>images/webpowerup/MainIcon5.png" alt="MainIcon"/>
                            </div>
                            <ul class="BoxData">
                            	<li> 
                                	<a href="<?=base_url().index_page()?>sitegroups/index"> Groups</a>
                                </li>
                                <li> 
                                	<a href="<?=base_url().index_page()?>access_levels/index"> Access Levels</a>
                                </li>
                                <?php /*?><li> 
                                	<a href="#"> Autoresponders</a>
                                </li><?php */?>
                            </ul>
                        </div>
                    </div>
                </li>
                <li>
                	<div class="InfoBox">
                    	<div class="MainBox">
                        	<div class="BoxHeading">
                            	<h1>
                                	<img src="<?=base_url()?>images/webpowerup/HeadingIcon.png" alt="Configuration"/>
                                    <span>Communications </span>
                                </h1>
                                <a href="#">
                                	<img src="<?=base_url()?>images/webpowerup/DownArrow.png" alt="DownArrow"/>
                                </a>
                            </div>
                            <div class="MainIcon">
                            	<img src="<?=base_url()?>images/webpowerup/MainIcon6.png" alt="MainIcon"/>
                            </div>
                            <ul class="BoxData">
                            	<li> 
                                	<a href="<?=base_url().index_page()?>Newsletter_Management/"> Create/ send newsletter</a>
                                </li>
                                <li> 
                                	<a href="<?=base_url().index_page()?>autoresponders_management/index/<?=$_SESSION['site_id']?>"> Create Auto Responder</a>
                                </li>
                                <li> 
                                	<a href="<?=base_url().index_page()?>webinar_controller/index/<?=$_SESSION["site_id"]?>"> Webinar Management</a>
                                </li>
                                <li> 
                                	<a href="<?=base_url().index_page()?>room_management/index/"> Create Meeting Room</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
            <ul>
            	<li>
                	<div class="InfoBox">
                    	<div class="MainBox">
                        	<div class="BoxHeading">
                            	<h1>
                                	<img src="<?=base_url()?>images/webpowerup/HeadingIcon.png" alt="Configuration"/>
                                    <span>Help Center / FAQ </span>
                                </h1>
                                <a href="#">
                                	<img src="<?=base_url()?>images/webpowerup/DownArrow.png" alt="DownArrow"/>
                                </a>
                            </div>
                            <div class="MainIcon">
                            	<img src="<?=base_url()?>images/webpowerup/MainIcon7.png" alt="MainIcon"/>
                            </div>
                            <ul class="BoxData">
                            	<li> 
                                	<a href="<?=base_url().index_page()?>help_center/topics_home"> Topics</a>
                                </li>
                                <li> 
                                	<a href="<?=base_url().index_page()?>help_center/questions_home"> Questions and Answers</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li>
                	<div class="InfoBox">
                    	<div class="MainBox">
                        	<div class="BoxHeading">
                            	<h1>
                                	<img src="<?=base_url()?>images/webpowerup/HeadingIcon.png" alt="Configuration"/>
                                    <span>Your Store </span>
                                </h1>
                                <a href="#">
                                	<img src="<?=base_url()?>images/webpowerup/DownArrow.png" alt="DownArrow"/>
                                </a>
                            </div>
                            <div class="MainIcon">
                            	<img src="<?=base_url()?>images/webpowerup/MainIcon8.png" alt="MainIcon"/>
                            </div>
                            <ul class="BoxData">
                            	<li> 
                                	<a href="<?=base_url().index_page()?>shop/"> Store Settings</a>
                                </li>
                                <li> 
                                	<a href="<?=base_url().index_page()?>Categories_Management/">Manage Catagories</a>
                                </li>
                                <li> 
                                	<a href="<?=base_url().index_page()?>Products_Management/">Manage Products</a>
                                </li>
                                <li> 
                                	<a href="<?=base_url().index_page()?>orders/">Manage Orders</a>
                                </li>
                                <li> 
                                	<a href="<?=base_url().index_page()?>Shipping_Management/index/<?=$_SESSION['site_id']?>/0"> Manage Shipping</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li>
                	<div class="InfoBox">
                    	<div class="MainBox">
                        	<div class="BoxHeading">
                            	<h1>
                                	<img src="<?=base_url()?>images/webpowerup/HeadingIcon.png" alt="Configuration"/>
                                    <span>Photo & Slide Show  </span>
                                </h1>
                                <a href="#">
                                	<img src="<?=base_url()?>images/webpowerup/DownArrow.png" alt="DownArrow"/>
                                </a>
                            </div>
                            <div class="MainIcon">
                            	<img src="<?=base_url()?>images/webpowerup/MainIcon9.png" alt="MainIcon"/>
                            </div>
                            <ul class="BoxData">
                            	<li> 
                                	<a href="<?=base_url().index_page()?>gallery_management/index/<?=$_SESSION['site_id']?>">Create a photo gallery</a>
                                </li>
                                <li> 
                                	<a href="<?=base_url().index_page()?>site_slides/create/<?=$_SESSION['site_id']?>"> Create Slideshow(s)</a>
                                </li>
                                <li> 
                                	<a href="<?=base_url().index_page()?>site_slides/index/<?=$_SESSION['site_id']?>/0"> Manage Slideshow(s)</a>
                                </li>
                                <li> 
                                	<a href="<?=base_url().index_page()?>video_gallery/index/<?=$_SESSION['site_id']?>"> Create a video gallery</a>
                                </li>
                                <li> 
                                	<a href="<?=base_url().index_page()?>SiteController/create_logo/<?=$_SESSION['site_id']?>">Create a Site Logo</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
            
            <ul>
            	<li>
                	<div class="InfoBox">
                    	<div class="MainBox">
                        	<div class="BoxHeading">
                            	<h1>
                                	<img src="<?=base_url()?>images/webpowerup/HeadingIcon.png" alt="Configuration"/>
                                    <span>Tickets </span>
                                </h1>
                                <a href="#">
                                	<img src="<?=base_url()?>images/webpowerup/DownArrow.png" alt="DownArrow"/>
                                </a>
                            </div>
                            <div class="MainIcon">
                            	<img src="<?=base_url()?>images/webpowerup/MainIcon10.png" alt="MainIcon"/>
                            </div>
                            <ul class="BoxData">
                            	<li> 
                                	<a href="<?=base_url().index_page()?>support_ticket/"> View/ Create support tickets</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li style="width:490px;">
                	<div class="InfoBox" style="width:490px;">
                    	<div class="MainBox" style="width:490px;">
                        	<div class="BoxHeading" style="width:490px;">
                            	<h1>
                                	<img src="<?=base_url()?>images/webpowerup/HeadingIcon.png" alt="Configuration"/>
                                    <span>Settings and Account Information </span>
                                </h1>
                                <a href="#">
                                	<img src="<?=base_url()?>images/webpowerup/DownArrow.png" alt="DownArrow"/>
                                </a>
                            </div>
                            <div class="MainIcon" style="width:490px;">
                            	<img src="<?=base_url()?>images/webpowerup/MainIcon11.png" alt="MainIcon"/>
                            </div>
                            <ul class="BoxData">
                            	<li> 
                                	<a href="#"> Profile(UC) </a>
                                </li>
                                <li> 
                                	<a href="#"> Website traffic report (UC) </a>
                                </li>
                                <li> 
                                	<a href="#"> Search engine optimization(UC) </a>
                                </li>
                                <li> 
                                	<a href="#"> Account upgrade(UC)</a>
                                </li>
                                <li> 
                                	<a href="#"> 3rd party Configuration (UC) </a>
                                </li>
                            </ul>
                            <ul class="BoxData">
                            	<li> 
                                	<a href="#"> Manage files and Bulk upload (UC) </a>
                                </li>
                                <li> 
                                	<a href="#">Create Affiliates for your Website (UC)</a>
                                </li>
                                <li> 
                                	
                                </li>
                                <li> 
                                	
                                </li>
                                <li> 
                                	
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                
            </ul>
            
</div>
