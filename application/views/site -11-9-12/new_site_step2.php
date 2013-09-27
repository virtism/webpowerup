<script type="text/javascript">

$(document).ready(function(e) {
    $("#dblColumn>div:even").addClass("ColumnA");
	$("#dblColumn>div:odd").addClass("ColumnB");
});
</script>

<div class="RightColumnHeading">
    <h1>
        <span>Create a Website - Step 1</span>
    </h1>
</div>
<div class="form">
	<form class="niceform" action="<?=base_url().index_page()?>SiteController/creatnewsite_step3" method="post" id="user" name="user">
    
        <input type="hidden" name="action" value="site_setup_stp3" />
        <input type="hidden" name="site_title" value="<?=$site_title?>" />
        <input type="hidden" name="site_domain" value="<?=$site_domain?>" />
         <input type="hidden" value="<?=$domain?>" name="domain" />
        
        
        <dl>
               <dt>
                     <label  class="NewsletterLabel">Templates</label>
               </dt>
               <dd>
               </dd>
        </dl>
        
    <div class="DoubleColumn" id="dblColumn">
                
		<?php
		$count = 1;
		?>
			<?php
			$total = count($templates);
				
				for($i=0; $i<$total; $i++)
				{ ?>
                    
        	<div >
                
                    <?php
                        if($user_login != '73' && $templates[$i]['temp_id'] !='5')
                        {
                            ?> 
                            <div>
                            <?=$templates[$i]['temp_name'] ?>
                            </div>
                            <div>
                            <img src = "<?=base_url();?>css/<?=$templates[$i]['temp_name'] ?>/images/<?=$templates[$i]['thumb_img'] ?>" width="128" height="128" border="0"  />
                            </div>
                            
                            <div>
                            Description : <?=$templates[$i]['temp_description'] ?>
                            </div>
                            
                            <div >
                            <input type="radio" id="template_select<?=$i?>" name="template_select" value="<?=$templates[$i]['temp_id'] ?>" <?php if($i== 0){echo 'CHECKED';} ?>  >
                            <label class="check_label"><?=$templates[$i]['temp_name'] ?></label>
                            </div>
                                            
                                          
                                          
                        <?php
                            $count++;                
                        } ?>
                    
            </div>
         <?php 
		 } ?>
        
        
	</div>
    
    
    <dl>
               <dt>
               </dt>
               <dd>
               <input type="button" value="BACK" onclick="javascript: history.go(-1);" /> &nbsp; <input type="submit" value="LET'S START" />
               </dd>
        </dl>
</form>
</div>