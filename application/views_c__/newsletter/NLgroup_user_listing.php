<script type="text/javascript">
    function do_delete()
    {
        var msg = confirm("Are you sure you want to Delete?");
        if(msg)
        {
            return true;
        }
        return false;
    }
    
$(document).ready(function(e) {  
    $(".DataGrid2 ul:odd").addClass("TableData");
    $(".DataGrid2 ul:even").addClass("TableData AlterRow");
    $(".DataGrid2 ul:first").removeClass("TableData AlterRow").addClass("TableHeader");
});

</script>


<div class="RightColumnHeading">
    <h1>
        <img src="<?=base_url();?>images/webpowerup/CreatNewsletter.png" alt="Rooms Management"/>
        <span>Newsletter Management</span>
    </h1>
    
    <div class="RightSideButton">
        <a href="<?php echo base_url().index_page() ?>Create_Newsletter">
            <img src="<?=base_url();?>images/webpowerup/createNewsletter.png" alt="Rooms Management"/>
        </a>
    </div>
    <div class="RightSideButton">
        <a href="<?php echo base_url().index_page() ?>Create_Newsletter/creat_newsletter_group">
            <img src="<?=base_url();?>images/webpowerup/createNewsletter.png" alt="Rooms Management"/>
        </a>
    </div>
</div>

<div class="PageDetail">
<p>Newsletter Details  </p>
<p>Here All Records of Newsletters</p>
</div>
   <? if($this->session->flashdata('success')){ ?>
           <div style="color:#009900; font-weight:bold; margin-left:30px;"><?=$this->session->flashdata('success')?></div>
   <? } ?>     
 <div class="DataGrid2">
        <ul>
            <li>User Name </li>
            <li> User Email </li>
            <li class="Actions">Action</li>
        </ul>
         <?php
         if(!empty($NLgroup_lising))
         {   
             foreach($NLgroup_lising as $row )
             { 
                 
             ?>   
                <ul>
                    <li>
                        <?=$row->user_name;?> 
                    </li>
                    <li>
                        <?=$row->user_email;?> 
                    </li>
                    <li class="Actions">
                         
                         <a href="<?=base_url().index_page()?>Newsletter_Management/delete_NLgroup_user/<?=$row->id.'/'.$_SESSION['site_id'].'/'.$row->newsgroup_id;?>" onClick="return do_delete()" href= "" class="DeleteAction">
                            <img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/>
                        </a><br />
                        
                    </li>
                </ul>
             <?php
             }
         }
         else
         { ?>
            <ul class="TableData">
                <li>
                <span class="NoData">
                Sorry! No Record Found.
                </span>
                </li>
            </ul>
         <?php 
         } ?>
</div>

<!-------------------------Newsletter Group Listing------------------------------>
