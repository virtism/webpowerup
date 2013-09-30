<div class="RightColumnHeading">
    <h1>
        <span>Change Template</span>
    </h1>
</div>
<div class="clr"></div>

<div class="InnerMain" >
    
    <form action="<?=base_url().index_page()?>SiteController/change_site_template/<?=$_SESSION["site_id"]?>" method="post" id="user" name="user" class="niceform">
    
        <fieldset>
            <input type="hidden" name="action" value="do_change_template" />

          
                    <?php
                    $count = 1;
                    ?>
                    <table width="100%" border="0" cellpadding="8" cellspacing="0">
                        <?php
                        $total = count($templates);
                        ?>
                        <tr>
                            <?php
                            for($i=0; $i<$total; $i++)
                            {
                            ?> 
                            <td width="50%" align="left">
                                <table id="signup_1" width="100%" border="0" cellpadding="2" cellspacing="0">
                                    <tr>
                                        <td align="left">
                                            <?=$templates[$i]['temp_name'] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left">
                                            <img src = "<?=base_url();?>css/<?=$templates[$i]['temp_name'] ?>/images/<?=$templates[$i]['thumb_img'] ?>" width="128" height="128" border="0"  />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left">
                                            <b align="left">Description : </b><?=$templates[$i]['temp_description'] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left">
                                            <div class="radio">
                                                <?php
                                                $strChecked='';
                                                if($current_template_id == $templates[$i]['temp_id'])
                                                {
                                                    $strChecked = 'class="checked"';    
                                                }
                                                ?>
                                                <span <?=$strChecked?>>
                                                   
                                                <label for="template_select<?=$i?>" class="check_label"><?=$templates[$i]['temp_name'] ?></label>
												<input type="radio" id="template_select<?=$i?>" name="template_select" value="<?=$templates[$i]['temp_id'] ?>" <?php if($current_template_id == $templates[$i]['temp_id']){echo 'CHECKED';} ?> checked="checked" />  
                                            </div>
                                        </td>  
                                    </tr>
                                </table>
                            </td>
                            <?php
                                if($count%2 == 0)
                                {
                                    echo '</tr><tr>';
                                }  
                                $count++;                  
                            } ?>
                        </tr>
                        
                    </table>
               
            
          <br />
         <input type="submit" value="Apply Template" />
             
        </fieldset>
    </form>
   
</div>

<script type="text/javascript">
	//jquery for radio button control
	$('div.radio span input:radio').click(function() {
		$(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().find('div.radio span').removeClass('checked');
		$(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().find('div.radio span input').attr('checked', false);    
		var className = $(this).parent().attr('class');
		if(className == "")
		{
			$(this).parent().addClass("checked"); 
			$(this).attr('checked', true);  
		}
		else
		{
			$(this).parent().removeClass('checked');   
			$(this).attr('checked', false);   
		}
	});
	
</script>

