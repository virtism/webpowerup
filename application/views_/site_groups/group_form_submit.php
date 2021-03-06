<script>
	$(document).ready(function(e) {
		
        	$(".DataGrid2 ul:odd").addClass("TableData");
			$(".DataGrid2 ul:even").addClass("TableData AlterRow");
			$(".DataGrid2 ul:first").removeClass("TableData AlterRow").addClass("TableHeader");
		
		
		$(".subDetail").fancybox({
				'width'                : '70%',
				'height'            : '95%',
				'autoScale'            : false,
				'transitionIn'        : 'none',
				'transitionOut'        : 'none'
		});
	
	


	
	});
	
	
	
	
</script>
<style>
.heading{
	font-size:14px;
	font-weight:bold;
	height:50px;
}
</style>

<div class="RightColumnHeading">
    <h1>
        <img src="<?=base_url();?>images/webpowerup/5.png" alt="Group"/>
        <span>Group Form Submissions</span>
    </h1>
    
    <div class="RightSideButton">
        <a href="<?=base_url().index_page()?>sitegroups/new_site_group">
            <img src="<?=base_url();?>images/webpowerup/CreateGroup.png" alt="Create Group"/>
        </a>
    </div>
</div>
<div class="clr"></div>


<div class="InnerMain2">


<div id="expRsp"></div>
<div style="float:right; margin-right: 10px;"><a href="<?=base_url().index_page()?>sitegroups/exportCVS/<?=$group_id?>" id="exportCVS"><b>Export in CSV File</b></a></div>
<br />

 
<div class="DataGrid2">
	<ul>
        <li >Submission ID</li>
        <li>Details</li>
        <li class="Actions">Action</li>
    </ul> 

	<?php
    if ($submits)
    { 
        $i = 1;
        foreach($submits as $submit )
        { ?>
           
            <ul>
                <li >
                <?php 
                $str = $submit['submit_id'];
                echo str_pad($str,10,"0",STR_PAD_LEFT);
                ?>
                </li>
                <li>
                    <a id="subDetial_<?=$submit['submit_id'];?>" target="_blank" class="subDetail" href="<?=site_url()?>sitegroups/submit_detail/<?=$submit['submit_id'];?>" > [View Submission Details ] </a>
                </li>
                <li class="Actions">
                <a class="DeleteAction" href="<?=site_url()?>sitegroups/submit_delete/<?=$group_id?>/<?=$submit['submit_id'];?>">
                	<img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/>
                </a>
                </li>
            </ul> 
        
            
        <?php
        }
    
    }
    else
    {
    ?>
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

</div>