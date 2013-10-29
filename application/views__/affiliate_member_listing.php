<script type="text/javascript">

$(document).ready(function(e) {  
    $(".DataGrid2 ul:odd").addClass("TableData");
    $(".DataGrid2 ul:even").addClass("TableData AlterRow");
    $(".DataGrid2 ul:first").removeClass("TableData AlterRow").addClass("TableHeader");
});

</script>
<div class="RightColumnHeading">
    <h1>
        <img src="<?=base_url();?>images/webpowerup/5.png" alt="Group"/>
        <span>Member Listing</span>
    </h1>
    
    <div class="RightSideButton">
        <a href="<?=base_url().index_page()?>sitegroups/new_site_group">
            <!--<img src="<?=base_url();?>images/webpowerup/CreateGroup.png" alt="Create Group"/>-->
        </a>
    </div>
</div>


<div class="DataGrid2">
                
        <ul>
            <li class="Serial">Sr.No </li>
            <li>Name</li>
            <li>Webpowerup URL</li>
            <li>Package Type </li>
            <li>Amount owed</li>
            <li class="Actions">Actions</li>
        </ul>
            
        <?
            if(count($members) >0)
            {
                 $i = 1;
                foreach($members as $member)
                
                {?>
                
                <ul >
                    
                    <li class="Serial">
                    <?=$i;?>
                    </li>
                    
                    <li>
                        <?=$member->user_fname?>
                    </li>
                    
                     <li style="max-width: none;">
                        <?=$member->site_url.'.webpowerup.ca';?>
                    </li>
                    
                    <li>
                       <?=$member->package_name?>
                    </li>
                    
                    <li>
                       <?=$member->package_fixed_price?>
                    </li>
                    <li class="Actions">
                      <?=$member->site_status?> 
                    </li>
                    </ul>
                    
               <?php  $i++;
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