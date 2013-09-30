<script language="javascript" type="text/javascript" src="<?=base_url()?>ckeditor/ckeditor.js"></script>
<script type="text/javascript">
$("div.NFRadio").live("click",function(){ 
if(id == "rdoPosition2")
    {
        $('#pages').fadeIn('slow');  
        NFFix(); 
    }
})
</script>


<div class="RightColumnHeading">
    <h1>
        <img src="<?=base_url();?>images/webpowerup/CreateResponder.png" alt="New Form"/>  
        <span>Create Newsletter Group</span>
    </h1>
</div>

<div class="form">
<p><div class="error_msg" align="center"> <?php echo validation_errors(); ?> </div></p>
    <form action="<?=base_url().index_page()?>Create_Newsletter/creat_newsletter_group/<?php echo $id;?>" method="post" id="reg_form" class="niceform">
    <input type="hidden" name="edit_id" value="<?php echo $id;?>">
        <dl>
            <dt><label for="email" class="NewsletterLabel">Newsletter Group Name</label></dt>
            <dd><input type="text" name="subject" id="subject" value="<?php echo $ngroup_name;?>" size="55" /></dd>
        </dl>
        <dl>
               <dt>
                     <label for="page_title" class="NewsletterLabel">Position Order:</label>
               </dt>
               <dd>
                    <label class="check_label">Left</label>
                    <input type="radio" value="Left" name="positionorder" id="rdoPosition1" <?php if($id != ''){if($position == 'Left'){echo 'checked="checked"';}}else{echo 'checked="checked"';}?> />
                    
                    <label class="check_label">Right</label>
                    <input type="radio" value="Right" name="positionorder" id="rdoPosition2" <?php if($position == 'Right'){echo 'checked="checked"';}?> />
               </dd>
        </dl>
        <dl>
               <dt>
                     <label for="page_title" class="NewsletterLabel">Published:</label>
               </dt>
               <dd>
                    <label class="check_label">Yes</label>
                    <input type="radio" value="yes" name="published" id="rdoPosition1" <?php if($id != ''){if($publish == 'yes'){echo 'checked="checked"';}}else{echo 'checked="checked"';}?>  />
                    
                    <label class="check_label">No</label>
                    <input type="radio" value="no" name="published" id="rdoPosition2" <?php if($publish == 'no'){echo 'checked="checked"';}?> />
               </dd>
        </dl>
        <dl>
               <dt>
                     <label for="page_title" class="NewsletterLabel">Display on Page:</label>
               </dt>
               <dd>
                    <label class="check_label">All Pages</label>
                    <input type="radio" value="yes" name="displayonpage" id="rdoPosition1" checked="checked" <?php if($id != ''){if($dispaly_page == 'yes'){echo 'checked="checked"';}}else{echo 'checked="checked"';}?> />
                    
                    <label class="check_label">Some Pages</label>
                    <input type="radio" value="no" name="displayonpage" id="rdoPosition2" <?php if($dispaly_page == 'no'){echo 'checked="checked"';}?>  />
                    <div id="pages" style="display: none; clear:both;">
                        <div  style=" position:relative; margin-top:15px; float:left;">
                        <select id="lstPages" name="lstPages[]" multiple="multiple" size="5" style="width:360px;">
                            <?php 
                            foreach($pages->result_array() as $rowPages)
                            {
                            ?>
                            <option value="<?=$rowPages['page_id']?>"><?=$rowPages['page_title']?></option>
                            <?php 
                            }
                            ?>        
                        </select>

                        </div>
                    </div>
               </dd>
        </dl>
        <dl>
               <dt>
                     <label for="page_title" class="NewsletterLabel">How Can See This slide?:</label>
               </dt>
               <dd>
                    <label class="check_label">Everyone</label>
                    <input type="radio" value="Everyone" name="rdoRights" id="rdoRights1" <?php if($id != ''){if($user_see == 'Everyone'){echo 'checked="checked"';}}else{echo 'checked="checked"';}?> />
                     <? if($template_name!='gymnastic')
                    { ?>
                    <label class="check_label">Registered</label>
                    <input type="radio" value="Registered" name="rdoRights" id="rdoRights2" <?php if($user_see == 'Registered'){echo 'checked="checked"';}?> />
                     <?php  if(isset($groups) && !empty($groups))
                    { ?>
                    <label class="check_label">Other</label>
                    <input type="radio" value="Other" name="rdoRights" id="rdoRights3" <?php if($user_see == 'Other'){echo 'checked="checked"';}?>  />
                    <label class="messages" id="menu_access_message" style="padding: 0;"></label>
                    <? 
                    }
                    else
                    {  
                    ?>
                        <a  href="<?=base_url().index_page()?>sitegroups/new_site_group/m" >No Group Exists Click To Create Group!</a>
                     <?php
                    }}        
                     ?>
                    
                    <!--    group ilst     -->
                    <? if($template_name!='gymnastic')
                    { 
                        if(isset($groups) && !empty($groups)){ ?>        
                                <div id="roles" style="display: none;clear:both;width:360px;">    
                                        <div  style=" position:relative; margin-top:10px; float:left; width:360px;">
                                        <select size="5" name="group_access[]" id="group_access" multiple="multiple" style="width:360px; margin-top:10px;margin-bottom:10px; ">
                                        <?
                                        foreach($groups as $group)
                                        {
                                        ?>
                                                <option value="<?=$group['id']?>"><?=$group['group_name']?></option>        
                                        <?
                                        } ?>
                                           </select>
                                        </div>    
                                </div>
                    <?  }
                    } ?> 
               </dd>
        </dl>
        <!--<table width="590" border="0" cellpadding="3" cellspacing="3">       
              <tr>
                <td width="141" align="right" ><label for="page_title" class="NewsletterLabel">Primary Color :</label> </td>
                <td width="111">
                <input type="text" name="prime_view_color" id="prime_view_color1" onmousemove="document.getElementById('prime_view_color').color.showPicker()" onmouseover="document.getElementById('prime_view_color1').color.hidePicker()" style="border: solid 1px #CCC; margin: 0 0 10px 15px;width: 60px; height: 35px;background-color: <?=(array_key_exists('primary_color',$groups)) ?  $groups['menu_primary_color'] : 'FFFFFF';?>;" class="color {valueElement:'prim_color' } none color_field" autocomplete="off" readonly="readonly" />
                <input type="hidden"  name="prim_color" id="prim_color" value="bkcolor"  >
                
                </td>
                <td width="10" rowspan="3">&nbsp;</td>
                <td width="141" align="right" class="NewsletterLabel"><label for="page_title" class="NewsletterLabel">Primary Text : </label> </td>                                                                                                                                                                                                                                                                                                
                <td width="139"><input type="text" name="prim_view_txt" id="prim_view_txt1"  onmousemove="document.getElementById('prim_view_txt').color.showPicker()" onmouseover="document.getElementById('prim_view_txt1').color.hidePicker()" style="border: solid 1px #CCC; margin: 0 0 10px 15px;width: 60px; height: 35px; background-color: <?=(array_key_exists('primary_txt',$groups)) ?  $groups['menu_txt_color'] : 'FFFFFF';?>;" class="color {valueElement:'prim_txt' } none color_field"  autocomplete="off" readonly="readonly" />
                 <input type="hidden" name="prim_txt" id="prim_txt"  value="testcolor"  >
                </td>
              </tr>
        </table>-->
        <dl>
            <dt><label for="email" class="NewsletterLabel">newsletter signup title</label></dt>
            <dd><input type="text" value="<?php echo $signup_titile;?>" name="sup_title" id="subject" size="55" /></dd>
        </dl>
        <dl>
            <dt><label for="comments" class="NewsletterLabel">Intro text :</label></dt>
            <dd><textarea name="body" id="ck_content" class="ckeditor" rows="10" cols="42"><?php echo $intro_text;?></textarea></dd>
        </dl>
        <dl>
        <dt><label for="color" class="NewsletterLabel"></label></dt>
        <dd>
            <div class="ButtonRow">
        <a href="#" class="CancelButton">
            <img src="<?=base_url();?>images/webpowerup/CancelRed.png" alt="search Button"/>
        </a>
            <input type="image" src="<?=base_url();?>images/webpowerup/SaveGreen.png">
        </div>
        </dd>
        </dl>
    </form>
</div>


