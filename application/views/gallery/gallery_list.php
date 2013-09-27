<style type="text/css">
div#actionMenu li {
    display: inline;
    list-style-type: none;
    padding-right: 20px;
}

div#actionMenu {
    margin-top:10px;
    margin-bottom:10px; 
}
</style>
<script language="javascript" type="text/javascript">
function isChecked(){
    for( i=1; i<=<?=$numRecords?>; i++ )
    {
        if( document.getElementById('chkSlide'+i).checked == true )
        {
            return true;            
        }
    }
    return false;
}
function publishGallery()
{    
    if(isChecked() == true)
    {
        form = document.getElementById('frmSlides');
        form.action = "<?=base_url().index_page()?>gallery_management/publishGallery/<?=$site_id?>";
        form.submit();
    }
    else
    {
        window.alert("No Gallery selected. Please select Gallery first to continue.");
        return;
    }    
}
function unpublishGallery()
{    
    if(isChecked() == true)
    {
        form = document.getElementById('frmSlides');
        form.action = "<?=base_url().index_page()?>gallery_management/unpublishGallery/<?=$site_id?>";
        form.submit();
    }
    else
    {
        window.alert("No Gallery selected. Please select Gallery first to continue.");
        return;
    }    
}
function deleteGallery()
{    
    if(isChecked() == true)
    {
		  var msg = confirm("Are you sure you want to Delete?");
          if(msg)
		  {
		    form = document.getElementById('frmSlides');
            form.action = "<?=base_url().index_page()?>gallery_management/trashGallery/<?=$site_id?>";
            form.submit();
			return true;
		  }	 
          else
          return false;
       
    }
    else
    {
        window.alert("No Gallery selected. Please select Gallery first to continue.");
        return;
    }    
}
function selectAllGalleries()
{
    state = document.getElementById('chkSlideAll').checked;    
    for(i=1;i<=<?=$numRecords?>;i++)
    {        
        document.getElementById('chkSlide'+i).checked=state;        
    }       
}
$(document).ready(function(e) {  
	$(".DataGrid2 ul:odd").addClass("TableData");
	$(".DataGrid2 ul:even").addClass("TableData AlterRow");
	$(".DataGrid2 ul:first").removeClass("TableData AlterRow").addClass("TableHeader");
});
</script>


<div class="RightColumnHeading">
    <h1>
        <img src="<?=base_url();?>images/webpowerup/CreateGallery.png" alt="CreateGallery"/>
        <span>Manage Photo Gallery</span>
    </h1>
    
     <div class="RightSideButton">
        
        <a href="javascript: void(0)" onclick="return deleteGallery()">
            <img src="<?=base_url();?>images/webpowerup/Trash.png" alt="Trash"/>
        </a>
        <a href="javascript: void(0)" onclick="return unpublishGallery()">
            <img src="<?=base_url();?>images/webpowerup/Unpublish.png" alt="Unpublish"/>
        </a>
        <a href="javascript: void(0)" onclick="return publishGallery()">
            <img src="<?=base_url();?>images/webpowerup/Publish.png" alt="Publish"/>
        </a>
        <a href="<?=base_url().index_page();?>gallery_management/create/<?=$site_id?>">
            <img src="<?=base_url();?>images/webpowerup/New.png" alt="New"/>
        </a>
    </div>
</div>

<form action="<?=base_url().index_page();?>gallery_management/index/<?=$site_id?>" method="post" id="frmSlides" name="frmSlides" >      
<div class="DataGrid2">
        
        <ul>
            <li class="Serial">
            	<input type="checkbox" value="0" name="chkSlideAll" id="chkSlideAll" onclick="selectAllGalleries()" />  
            </li>
            <li>Title </li>
            <li>Template Options</li>
            <li>Access Level </li>
            <li>Published </li>
            <li>Last Modified </li>
        </ul>
		
        <?php 
		// echo "<pre>";  print_r($records);	echo "</pre>";
		
		if($records)
		{
				$intCount = 0;
			foreach($records as $row)
			{
			  $intCount++;
			?>
			<ul>
				<li class="Serial">
				<input type="checkbox" value="<?php echo $row['gallery_id'];?>" name="chkSlide[]" id="chkSlide<?php echo $intCount;?>" /> 
				</li>
				<li>
                    <a href="<?=base_url().index_page();?>gallery_management/edit/<?=$site_id?>/<?=$row['gallery_id']?>" class="activelink">
                    <?=$row['gallery_title'];?>
                	</a>
				</li>
				<li>
					<?=$row['template_options'];?>
				</li>
				<li>
					<?=$row['gallery_access'];?>
				</li>
				<li>
					<?=$row['gallery_published'];?>
				</li>
				<li>
				   <span class="GridCalendar"> 
				   <?php
					$slide_modified_date = strtotime($row['gallery_modified_date']);
					$slide_modified_date = date('M. d, Y (h:i a)', $slide_modified_date);        
					?>
					<?=$slide_modified_date;?> 
                	</span>
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

<?php 
if($records)
{ ?>
<div class="pageDiv">
	<?php echo $paging;?>
    <br />
    Display # 
    <select id="numRecords" name="numRecords" onChange="document.frmSlides.submit();">            
        <option value="5" <?php if($pageLimit==5){?>selected="selected"<?php }?>>5</option>
        <option value="10" <?php if($pageLimit==10){?>selected="selected"<?php }?>>10</option>
        <option value="20" <?php if($pageLimit==20){?>selected="selected"<?php }?>>20</option>    
    </select>
    Results <?php echo $from+1;?> - <?php echo $from+$numRecords;?> of <?=$totalRecords;?>
</div>
<?php 
} ?>
</form>
     
   