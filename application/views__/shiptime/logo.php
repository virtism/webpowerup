<?php
            if(!isset($mode))
            {
                $mode = '';    
            }
            if($mode == 'edit')
            {
                $strLink = 'javascript: void(0);';     
            }
            else
            {
                 $strLink = base_url().index_page().'site_preview/site/'.$site_id;   
            }
            ?>

<a href="<?=$strLink?>"><img src="<?=base_url(); ?>css/shiptime/images/logo.png" alt="Your Company Logo" /></a>
        <span id="logo-text"><a href="./">&nbsp;</a></span>
        <!--<span class="orange"><?=$site_name?></span> -->