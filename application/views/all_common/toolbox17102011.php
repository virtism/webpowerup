<style type="text/css">
table#toolbar tr td ul#main
{
list-style-type:none;
margin:0;
padding:0;
}
table#toolbar tr td ul#main li
{
display:inline;
}
</style>
<div style="float: right;">
Toolbar <a href="javascript: void(0);" onclick="toogleToolbar()">[<span id="txt_toolbar">show</span>]</a>
</div>
<div id="toolbar" style="display: none; height: auto;">
<table id="toolbar" width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:15px; border:1px dotted #CCCCCC">
    <tr>
        <td width="25%">
        <ul id="main">
            <li>Site Templates:</li>
        </ul>
        </td>
        <td>
        <ul id="main">
            <li>Toolbox</li>
        </ul>
        </td>
    </tr>
    <tr id="templates">
        <td valign="top">
            <?php
            if($templates->num_rows()>0)
            {
                /*echo "<pre>";
                print_r($templates);
                exit;
                */
            ?>
                <ul style="list-style: none;"> 
                <?php foreach($templates->result_array() as $rowTemplate)
                {
                ?>
                    <li><a href="<?=base_url()?>index.php/page_editor/tmp_set_site_template/<?=$site_id?>/<?=$page_id?>/<?=$rowTemplate['temp_id']?>/<?=$rowTemplate['temp_name']?>"><?=$rowTemplate['temp_name']?></a></li>
                <?php
                }
                ?>   
                </ul>  
            <?php
            }
            else
            {
                echo "<p>No templates found.</p>";
            }
            ?>
            <form id="frmTemplate" action="<?=base_url()?>index.php/page_editor/set_site_template/<?=$site_id?>/<?=$page_id?>" method="">
                <input type="submit" value="Apply Template" />
            </form>
            <a class="edit_advance" href="<?=base_url()?>index.php/page_editor/editBackgroundInfo/<?=$site_id?>/<?=$page_id?>">Page Background</a>
            <br />
            <a class="edit_advance" href="<?=base_url()?>index.php/page_editor/editHeaderInfo/<?=$site_id?>/<?=$page_id?>">Page Header</a>
            <br />
            <a class="edit_advance" href="<?=base_url()?>index.php/page_editor/editAdvanceInfo/<?=$site_id?>/<?=$page_id?>">Advanced</a>
        </td>
        <td>
            <div id="item_container" style="width: auto;">
                <!--
                <div class="item" id="i1">
                    <label class="title">Text Area</label>
                    <label class="price"></label>
                </div>
                -->
                <div class="item" id="para">
                    <label class="title">Paragraph</label>
                    <label class="price"></label>
                </div>
                
                <div class="item" id="image">
                    <label class="title">Image</label>
                    <label class="price"></label>
                </div>
                      
                <div class="clear"></div> 
            </div>
        </td>
    </tr>
</table>
</div>