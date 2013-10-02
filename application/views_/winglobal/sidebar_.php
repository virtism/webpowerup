<!-- SEARCH BOX -->  



<div class="searchform">

<form id="formsearch" name="formsearch" method="post" action="#">

    <span>

        <input name="editbox_search" class="editbox_search" id="editbox_search" maxlength="80" value="Search our ste:" type="text" />

    </span>

    <input name="button_search" src="<?=base_url(); ?>css/winglobal/images/search_btn.gif" class="button_search" type="image" />

</form>

</div>



<!-- LEFT MENUS --> 

<?php   //exit();

//echo $_SESSION['user_info']['user_id'];exit();

//echo $page_id;exit;

if($page_id!=""){

    //exit;

?>

<?php 

$resultMenu = $this->Menus_Model->getPageMenus($site_id, $page_id, "Left", "Everyone", "All");

foreach($resultMenu->result_array() as $rowMenu):

    $resultMenuItem = $this->Menus_Model->getMenuItem($rowMenu['menu_name']);

    $boolDisplay=false;

    if($rowMenu['menu_published']=='Yes')

    {

        $boolDisplay = true;

    }

    else

    {          

        $dateStart = strtotime($rowMenu['menu_start']);

        $dateEnd = strtotime($rowMenu['menu_end']);

        $dateToday = strtotime(date("Y-m-d h:i:s"));          

        if($dateStart<$dateToday && $dateEnd>$dateToday)

        {

            $boolDisplay = true;

        }

    }

    if($boolDisplay == true)

    {?>

<div class="gadget">

    <h2 class="star"><span><?=$rowMenu['menu_name'];?></span></h2>

    <div class="clr"></div>

        <?php if($resultMenuItem->num_rows()>0){?>

        <ul class="sb_menu">

            <?php foreach($resultMenuItem->result_array() as $rowMenuItem):

            $resultPage = $this->Menus_Model->getPage($rowMenuItem['item_id']);

            $rowPage = $resultPage->row_array();?>

            <li><a href="<?=base_url().index_page()."site_preview/page/".$site_id."/".$rowPage["page_id"]?>"><?=$rowMenuItem["item_name"];?></a></li>

            <?php endforeach;?>            

        </ul>

        <?php

        }

        else

        {?>&nbsp;<?php

        }?>

    <?php

    }?>

</div>

<?php

endforeach;?>





<?php 

$resultMenu = $this->Menus_Model->getPageMenus($site_id, $page_id, "Left", "Everyone", "Other");

foreach($resultMenu->result_array() as $rowMenu):

    $resultMenuItem = $this->Menus_Model->getMenuItem($rowMenu['menu_name']);

    $boolDisplay=false;

    if($rowMenu['menu_published']=='Yes')

    {

        $boolDisplay = true;

    }

    else

    {          

        $dateStart = strtotime($rowMenu['menu_start']);

        $dateEnd = strtotime($rowMenu['menu_end']);

        $dateToday = strtotime(date("Y-m-d h:i:s"));          

        if($dateStart<$dateToday && $dateEnd>$dateToday)

        {

            $boolDisplay = true;

        }

    }

    if($boolDisplay == true)

    {?>

<div class="gadget">

    <h2 class="star"><span><?=$rowMenu['menu_name'];?></span></h2>

    <div class="clr"></div>

        <?php if($resultMenuItem->num_rows()>0){?>

        <ul class="sb_menu">

            <?php foreach($resultMenuItem->result_array() as $rowMenuItem):

            $resultPage = $this->Menus_Model->getPage($rowMenuItem['item_id']);

            $rowPage = $resultPage->row_array();?>

            <li><a href="<?=base_url().index_page()."site_preview/page/".$site_id."/".$rowPage["page_id"]?>"><?=$rowMenuItem["item_name"];?></a></li>

            <?php endforeach;?>            

        </ul>

        <?php

        }

        else

        {?>&nbsp;<?php

        }?>

    <?php

    }

    ?>

</div>

<?php

endforeach;?>





<?php

if(isset($_SESSION['user_info']['user_id']))

{  

$resultMenu = $this->Menus_Model->getPageMenus($site_id, $page_id, "Left", "Registered", "All");

foreach($resultMenu->result_array() as $rowMenu):

    $resultMenuItem = $this->Menus_Model->getMenuItem($rowMenu['menu_name']);

    $boolDisplay=false;

    if($rowMenu['menu_published']=='Yes')

    {

        $boolDisplay = true;

    }

    else

    {          

        $dateStart = strtotime($rowMenu['menu_start']);

        $dateEnd = strtotime($rowMenu['menu_end']);

        $dateToday = strtotime(date("Y-m-d h:i:s"));          

        if($dateStart<$dateToday && $dateEnd>$dateToday)

        {

            $boolDisplay = true;

        }

    }

    if($boolDisplay == true)

    {?>

<div class="gadget">

    <h2 class="star"><span><?=$rowMenu['menu_name'];?></span></h2>

    <div class="clr"></div>

        <?php if($resultMenuItem->num_rows()>0)

        {?>

        <ul class="sb_menu">

            <?php foreach($resultMenuItem->result_array() as $rowMenuItem):

            $resultPage = $this->Menus_Model->getPage($rowMenuItem['item_id']);

            $rowPage = $resultPage->row_array();?>             

            <li><a href="<?=base_url().index_page()."site_preview/page/".$site_id."/".$rowPage["page_id"]?>"><?=$rowMenuItem["item_name"]?></a></li>

            <?php endforeach;?>            

        </ul>

        <?php

        }

        else

        {?>&nbsp;<?php

        }?>

    <?php

    }?>

</div>  

<?php

endforeach;

}?>





<?php

if(isset($_SESSION['user_info']['user_id']))

{  

$resultMenu = $this->Menus_Model->getPageMenus($site_id, $page_id, "Left", "Registered", "Other");

foreach($resultMenu->result_array() as $rowMenu):

    $resultMenuItem = $this->Menus_Model->getMenuItem($rowMenu['menu_name']);

    $boolDisplay=false;

    if($rowMenu['menu_published']=='Yes')

    {

        $boolDisplay = true;

    }

    else

    {          

        $dateStart = strtotime($rowMenu['menu_start']);

        $dateEnd = strtotime($rowMenu['menu_end']);

        $dateToday = strtotime(date("Y-m-d h:i:s"));          

        if($dateStart<$dateToday && $dateEnd>$dateToday)

        {

            $boolDisplay = true;

        }

    }

    if($boolDisplay == true)

    {?>

<div class="gadget">

    <h2 class="star"><span><?=$rowMenu['menu_name'];?></span></h2>

    <div class="clr"></div>

        <?php if($resultMenuItem->num_rows()>0)

        {?>

        <ul class="sb_menu">

            <?php foreach($resultMenuItem->result_array() as $rowMenuItem):

            $resultPage = $this->Menus_Model->getPage($rowMenuItem['item_id']);

            $rowPage = $resultPage->row_array();?>             

            <li><a href="<?=base_url().index_page()."site_preview/page/".$site_id."/".$rowPage["page_id"]?>"><?=$rowMenuItem["item_name"]?></a></li>

            <?php endforeach;?>            

        </ul>

        <?php

        }

        else

        {?>&nbsp;<?php

        }?>

    <?php

    }?>

</div>

<?php

endforeach;

}?>

 

<?php

if(isset($_SESSION['user_info']['user_id']))

{

    //echo "this";exit; 

$user_id = $_SESSION['user_info']['user_id'];

$resultMenu = $this->Menus_Model->getPageMenus($site_id, $page_id, "Left", "Other", "All");

foreach($resultMenu->result_array() as $rowMenu):

    $resultMenuItem = $this->Menus_Model->getMenuItem($rowMenu['menu_name']);

    $boolDisplay=false;

    if($rowMenu['menu_published']=='Yes')

    {

        $boolDisplay = true;

    }

    else{          

        $dateStart = strtotime($rowMenu['menu_start']);

        $dateEnd = strtotime($rowMenu['menu_end']);

        $dateToday = strtotime(date("Y-m-d h:i:s"));          

        if($dateStart<$dateToday && $dateEnd>$dateToday)

        {

            $boolDisplay = true;

        }

    }

    if(isMenuforUser($rowMenu['menu_id'], $user_id)==TRUE)

    {

        $boolDisplay = true;        

    }

    else

    {

        $boolDisplay = false;    

    }

    if($boolDisplay == true)

    {?>

<div class="gadget">

    <h2 class="star"><span><?=$rowMenu['menu_name'];?></span></h2>

    <div class="clr"></div>

        <?php if($resultMenuItem->num_rows()>0)

        {?>

        <ul class="sb_menu">

            <?php foreach($resultMenuItem->result_array() as $rowMenuItem):

            $resultPage = $this->Menus_Model->getPage($rowMenuItem['item_id']);

            $rowPage = $resultPage->row_array();?>            

            <li><a href="<?=base_url().index_page()."site_preview/page/".$site_id."/".$rowPage["page_id"]?>"><?=$rowMenuItem["item_name"]?></a></li>

            <?php endforeach;?>            

        </ul>

        <?php

        }

        else

        {?>&nbsp;<?php

        }?>

    <?php

    }?>

</div>

<?php

endforeach;

}?>



<?php

if(isset($_SESSION['user_info']['user_id']))

{

$user_id = $_SESSION['user_info']['user_id'];

$resultMenu = $this->Menus_Model->getPageMenus($site_id, $page_id, "Left", "Other", "Other");

foreach($resultMenu->result_array() as $rowMenu):

    $resultMenuItem = $this->Menus_Model->getMenuItem($rowMenu['menu_name']);

    $boolDisplay=false;

    if($rowMenu['menu_published']=='Yes')

    {

        $boolDisplay = true;

    }

    else{          

        $dateStart = strtotime($rowMenu['menu_start']);

        $dateEnd = strtotime($rowMenu['menu_end']);

        $dateToday = strtotime(date("Y-m-d h:i:s"));          

        if($dateStart<$dateToday && $dateEnd>$dateToday)

        {

            $boolDisplay = true;

        }

    }

    if(isMenuforUser($rowMenu['menu_id'], $user_id))

    {

        $boolDisplay = true;        

    }

    else

    {

        $boolDisplay = false;    

    }

    if($boolDisplay == true)

    {?>

<div class="gadget">

    <h2 class="star"><span><?=$rowMenu['menu_name'];?></span></h2>

    <div class="clr"></div>

        <?php if($resultMenuItem->num_rows()>0)

        {?>

        <ul class="sb_menu">

            <?php foreach($resultMenuItem->result_array() as $rowMenuItem):

            $resultPage = $this->Menus_Model->getPage($rowMenuItem['item_id']);

            $rowPage = $resultPage->row_array();?>            

            <li><a href="<?=base_url().index_page()."site_preview/page/".$site_id."/".$rowPage["page_id"]?>"><?=$rowMenuItem["item_name"]?></a></li>

            <?php endforeach;?>            

        </ul>

        <?php

        }

        else

        {?>&nbsp;<?php

        }?>

    <?php

    }?>

</div>

<?php

endforeach;

}?>



<!-- RIGHT MENUS -->



<?php 

$resultMenu = $this->Menus_Model->getPageMenus($site_id, $page_id, "Right", "Everyone", "All");

foreach($resultMenu->result_array() as $rowMenu):

    $resultMenuItem = $this->Menus_Model->getMenuItem($rowMenu['menu_name']);

    $boolDisplay=false;

    if($rowMenu['menu_published']=='Yes'){

        $boolDisplay = true;

    }

    else{          

        $dateStart = strtotime($rowMenu['menu_start']);

        $dateEnd = strtotime($rowMenu['menu_end']);

        $dateToday = strtotime(date("Y-m-d h:i:s"));          

        if($dateStart<$dateToday && $dateEnd>$dateToday){

            $boolDisplay = true;

        }

    }

    if($boolDisplay == true){?>

<div class="gadget">

    <h2 class="star"><span><?=$rowMenu['menu_name'];?></span></h2>

    <div class="clr"></div>

        <?php if($resultMenuItem->num_rows()>0){?>

        <ul class="sb_menu">

            <?php foreach($resultMenuItem->result_array() as $rowMenuItem):

            $resultPage = $this->Menus_Model->getPage($rowMenuItem['item_id']);

            $rowPage = $resultPage->row_array();?>

            <li><a href="<?=base_url().index_page()."site_preview/page/".$site_id."/".$rowPage["page_id"]?>"><?=$rowMenuItem["item_name"];?></a></li>

            <?php endforeach;?>            

        </ul>

        <?php

        }

        else{?>&nbsp;<?php

        }?>

    <?php

    }?>

</div>  

<?php

endforeach;?>





<?php 

$resultMenu = $this->Menus_Model->getPageMenus($site_id, $page_id, "Right", "Everyone", "Other");

foreach($resultMenu->result_array() as $rowMenu):

    $resultMenuItem = $this->Menus_Model->getMenuItem($rowMenu['menu_name']);

    $boolDisplay=false;

    if($rowMenu['menu_published']=='Yes'){

        $boolDisplay = true;

    }

    else{          

        $dateStart = strtotime($rowMenu['menu_start']);

        $dateEnd = strtotime($rowMenu['menu_end']);

        $dateToday = strtotime(date("Y-m-d h:i:s"));          

        if($dateStart<$dateToday && $dateEnd>$dateToday){

            $boolDisplay = true;

        }

    }

    if($boolDisplay == true){?>

<div class="gadget">

    <h2 class="star"><span><?=$rowMenu['menu_name'];?></span></h2>

    <div class="clr"></div>

        <?php if($resultMenuItem->num_rows()>0){?>

        <ul class="sb_menu">

            <?php foreach($resultMenuItem->result_array() as $rowMenuItem):

            $resultPage = $this->Menus_Model->getPage($rowMenuItem['item_id']);

            $rowPage = $resultPage->row_array();?>

            <li><a href="<?=base_url().index_page()."site_preview/page/".$site_id."/".$rowPage["page_id"]?>"><?=$rowMenuItem["item_name"];?></a></li>

            <?php endforeach;?>            

        </ul>

        <?php

        }

        else{?>&nbsp;<?php

        }?>

    <?php

    }?>

</div>

<?php

endforeach;?>





<?php

if($this->session->userdata("user_id"))

{ 

$resultMenu = $this->Menus_Model->getPageMenus($site_id, $page_id, "Right", "Registered", "All");

foreach($resultMenu->result_array() as $rowMenu):

    $resultMenuItem = $this->Menus_Model->getMenuItem($rowMenu['menu_name']);

    $boolDisplay=false;

    if($rowMenu['menu_published']=='Yes'){

        $boolDisplay = true;

    }

    else{          

        $dateStart = strtotime($rowMenu['menu_start']);

        $dateEnd = strtotime($rowMenu['menu_end']);

        $dateToday = strtotime(date("Y-m-d h:i:s"));          

        if($dateStart<$dateToday && $dateEnd>$dateToday){

            $boolDisplay = true;

        }

    }

    if($boolDisplay == true){?>

<div class="gadget">

    <h2 class="star"><span><?=$rowMenu['menu_name'];?></span></h2>

    <div class="clr"></div>

        <?php if($resultMenuItem->num_rows()>0){?>

        <ul class="sb_menu">

            <?php foreach($resultMenuItem->result_array() as $rowMenuItem):

            $resultPage = $this->Menus_Model->getPage($rowMenuItem['item_id']);

            $rowPage = $resultPage->row_array();?>

            <li><a href="<?=base_url().index_page()."site_preview/page/".$site_id."/".$rowPage["page_id"]?>"><?=$rowMenuItem["item_name"]?></a></li>

            <?php endforeach;?>            

        </ul>

        <?php

        }

        else{?>&nbsp;<?php

        }?>

    <?php

    }?>

</div>

<?php

endforeach;

}?>



<?php

if($this->session->userdata("user_id"))

{ 

$resultMenu = $this->Menus_Model->getPageMenus($site_id, $page_id, "Right", "Registered", "Other");

foreach($resultMenu->result_array() as $rowMenu):

    $resultMenuItem = $this->Menus_Model->getMenuItem($rowMenu['menu_name']);

    $boolDisplay=false;

    if($rowMenu['menu_published']=='Yes'){

        $boolDisplay = true;

    }

    else{          

        $dateStart = strtotime($rowMenu['menu_start']);

        $dateEnd = strtotime($rowMenu['menu_end']);

        $dateToday = strtotime(date("Y-m-d h:i:s"));          

        if($dateStart<$dateToday && $dateEnd>$dateToday){

            $boolDisplay = true;

        }

    }

    if($boolDisplay == true){?>

<div class="gadget">

    <h2 class="star"><span><?=$rowMenu['menu_name'];?></span></h2>

    <div class="clr"></div>

        <?php if($resultMenuItem->num_rows()>0){?>

        <ul class="sb_menu">

            <?php foreach($resultMenuItem->result_array() as $rowMenuItem):

            $resultPage = $this->Menus_Model->getPage($rowMenuItem['item_id']);

            $rowPage = $resultPage->row_array();?>

            <li><a href="<?=base_url().index_page()."site_preview/page/".$site_id."/".$rowPage["page_id"]?>"><?=$rowMenuItem["item_name"]?></a></li>

            <?php endforeach;?>            

        </ul>

        <?php

        }

        else{?>&nbsp;<?php

        }?>

    <?php

    }?>

</div>

<?php

endforeach;

}?>



<?php 

if($this->session->userdata("user_id") && $this->session->userdata("role_id"))

{

$resultMenu = $this->Menus_Model->getPageMenus($site_id, $page_id, "Right", "Other", "All");

foreach($resultMenu->result_array() as $rowMenu):

    $resultMenuItem = $this->Menus_Model->getMenuItem($rowMenu['menu_name']);

    $boolDisplay=false;

    if($rowMenu['menu_published']=='Yes'){

        $boolDisplay = true;

    }

    else{          

        $dateStart = strtotime($rowMenu['menu_start']);

        $dateEnd = strtotime($rowMenu['menu_end']);

        $dateToday = strtotime(date("Y-m-d h:i:s"));          

        if($dateStart<$dateToday && $dateEnd>$dateToday){

            $boolDisplay = true;

        }

    }

    if($boolDisplay == true){?>

<div class="gadget">

    <h2 class="star"><span><?=$rowMenu['menu_name'];?></span></h2>

    <div class="clr"></div>

        <?php if($resultMenuItem->num_rows()>0){?>

        <ul class="sb_menu">

            <?php foreach($resultMenuItem->result_array() as $rowMenuItem):

            $resultPage = $this->Menus_Model->getPage($rowMenuItem['item_id']);

            $rowPage = $resultPage->row_array();?>

            <li><a href="<?=base_url().index_page()."site_preview/page/".$site_id."/".$rowPage["page_id"]?>"><?=$rowMenuItem["item_name"]?></a></li>

            <?php endforeach;?>            

        </ul>

        <?php

        }

        else{?>&nbsp;<?php

        }?>

    <?php

    }?>

</div> 

<?php

endforeach;

}?>





<?php 

if($this->session->userdata("user_id") && $this->session->userdata("role_id"))

{

$resultMenu = $this->Menus_Model->getPageMenus($site_id, $page_id, "Right", "Other", "Other");

foreach($resultMenu->result_array() as $rowMenu):

    $resultMenuItem = $this->Menus_Model->getMenuItem($rowMenu['menu_name']);

    $boolDisplay=false;

    if($rowMenu['menu_published']=='Yes'){

        $boolDisplay = true;

    }

    else{          

        $dateStart = strtotime($rowMenu['menu_start']);

        $dateEnd = strtotime($rowMenu['menu_end']);

        $dateToday = strtotime(date("Y-m-d h:i:s"));          

        if($dateStart<$dateToday && $dateEnd>$dateToday){

            $boolDisplay = true;

        }

    }

    if($boolDisplay == true){?>

<div class="gadget">

    <h2 class="star"><span><?=$rowMenu['menu_name'];?></span></h2>

    <div class="clr"></div>

        <?php if($resultMenuItem->num_rows()>0){?>

        <ul class="sb_menu">

            <?php foreach($resultMenuItem->result_array() as $rowMenuItem):

            $resultPage = $this->Menus_Model->getPage($rowMenuItem['item_id']);

            $rowPage = $resultPage->row_array();?>

            <li><a href="<?=base_url().index_page()."site_preview/page/".$site_id."/".$rowPage["page_id"]?>"><?=$rowMenuItem["item_name"]?></a></li>

            <?php endforeach;?>            

        </ul>

        <?php

        }

        else{?>&nbsp;<?php

        }?>

    <?php

    }

    ?>

</div>

<?php

endforeach;

}?>



<?php

}

else

{

?>

    <div class="gadget">

        <h2 class="star"><span>Sidebar</span> Menu</h2>

        <div class="clr"></div>

        <ul class="sb_menu">

            <li><a href="#">Home</a></li>

            <li><a href="#">TemplateInfo</a></li>

            <li><a href="#">Style Demo</a></li>

            <li><a href="#">Blog</a></li>

            <li><a href="#">Archives</a></li>

            <li><a href="#">Web Templates</a></li>

        </ul>

    </div>

    

    <div class="gadget">

          <h2 class="star"><span>Sponsors</span></h2>

          <div class="clr"></div>

          <ul class="ex_menu">

            <li><a href="#">Dream</a><br />

              </li>

            <li><a href="#">SOLD</a><br />

              Premium WordPress &amp; Joomla Themes</li>

            <li><a href="#">ImHosted.com</a><br />

              Affordable Web Hosting Provider</li>

            <li><a href="#">MyVectorStore</a><br />

              Royalty Free Stock Icons</li>

            <li><a href="#">Evrsoft</a><br />

              Website Builder Software &amp; Tools</li>

            <li><a href="#">CSS Hub</a><br />

              Premium CSS </li>

          </ul>

        </div>    

<?php

}

?>