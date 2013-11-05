<script type="text/javascript">
function do_delete()
{
  var msg = confirm("Are you sure you want to Delete?");
  if(msg)
	 return true;
  else
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
        <span><?=$title?></span>
    </h1>
    
</div>
<div class="RightColumnHeading">
    <div class="LeftSideButton">
        <a href="<?=site_url();?>Categories_Management/create" >
        	<img src="<?=base_url();?>images/webpowerup/CreateCategory.png" alt="Create Category"/>
        </a>
    </div>
	<div class="RightSideButton">
    	<a href="<?=site_url();?>Categories_Management/export" >
        	<img src="<?=base_url();?>images/webpowerup/Export.png" alt="Export"/>
        </a>
    </div>
</div>
 <p><div class="error_msg" align="center"> <?php echo validation_errors(); ?> </div></p>

<div class="DataGrid2">
    <ul>
        <li class="Serial">id</li>
        <li>Name</li>
        <li>Status</li>
        <li>Parent ID</li>
        <li class="Actions">Action</li>
    </ul>
	<?php
    if (count($categories))
    { 
		$counter = 1;
        foreach ($categories as $key => $list)
        { ?>
        <ul>
			<li class="Serial"><?=$counter++//$list['cat_id'];?></li>
            <li> <a  href="<?=site_url();?>Categories_Management/edit/<?=$list['cat_id']?>"  class="activelink">
           <?=$list['cat_name'];?></a></li>
            <li><a href="<?=site_url();?>Categories_Management/changeCatStatus/<?=$list['cat_id'];?>"><?=$list['status']?></a></li>
            <li><?=$list['parentid']?></li>
            <li class="Actions">
            
            <a href="<?=site_url();?>Categories_Management/edit/<?=$list['cat_id']?>" class="EditAction">
                <img src="<?=base_url();?>images/webpowerup/EditAction.png" alt="button"/>
            </a>
             <a  onClick="return do_delete()" href="<?=site_url();?>Categories_Management/delete/<?=$list['cat_id']?>" class="DeleteAction">
                <img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/>
            </a>
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




