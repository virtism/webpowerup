
<table width="100%" height="450" border="0" cellspacing="0" cellpadding="0">

<!-- PAGE CONTENT AREA START -->
<tr>
    <td valign="top">
        <?php
        if($mode=='edit')
        {
        ?>
        <form id="frmEditPageContent" style="border: none; background: none;" method="post" action="<?=base_url().index_page()?>pagesController/updatePageContent/<?=$site_id?>/<?=$page_id?>">
            <input type="submit" value="Save Changes" />
        <div id="cart_container" style="border: 1px #CCCCCC dotted; margin:0px; width: auto;">
              <div id="cart_title" style="width: auto;">
                  
              </div>
              <div id="cart_toolbar" style="width: auto; background: none;">
                  <div id="cart_items" class="back" style="width: auto; background: none;">
                  <?=$content?>
                  </div>
              </div>
              
        </div>
            <input type="submit" value="Save Changes" />
        </form> 
        <?php
        }
        else{
        ?>
            <div>
                <?=$content?>
            </div>
        <?php
        }
        ?>
    <td>
</tr>
<!-- PAGE CONTENT AREA END --> 

</table>