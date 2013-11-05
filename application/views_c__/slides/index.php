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
function publishSlide()
{    
    if(isChecked() == true)
    {
        form = document.getElementById('frmSlides');
        form.action = "<?=base_url().index_page()?>site_slides/publishSlide/<?=$site_id?>";
        form.submit();
    }
    else
    {
        window.alert("No slideshow(s) selected. Please select slideshow(s) first to continue.");
        return;
    }    
}
function unpublishSlide()
{    
    if(isChecked() == true)
    {
        form = document.getElementById('frmSlides');
        form.action = "<?=base_url().index_page()?>site_slides/unpublishSlide/<?=$site_id?>";
        form.submit();
    }
    else
    {
        window.alert("No slideshow(s) selected. Please select slideshow(s) first to continue.");
        return;
    }    
}
function deleteSlide()
{    
    if(isChecked() == true)
    {
		  var msg = confirm("Are you sure you want to Delete?");
          if(msg)
		  {
		    form = document.getElementById('frmSlides');
			form.action = "<?=base_url().index_page()?>site_slides/trashSlide/<?=$site_id?>";
			form.submit();
			return true;
		  }	 
          else
          return false;
       
    }
    else
    {
        window.alert("No Slide Show selected. Please select Slide Show first to continue.");
        return;
    }    
}
function selectAllSlides()
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
        <span>Manage SlideShow(s)</span>
    </h1>
    
     <div class="RightSideButton">
        
        <a href="javascript: void(0)" onclick="return deleteSlide()">
            <img src="<?=base_url();?>images/webpowerup/Trash.png" alt="Trash"/>
        </a>
        <a href="javascript: void(0)" onclick="unpublishSlide()">
            <img src="<?=base_url();?>images/webpowerup/Unpublish.png" alt="Unpublish"/>
        </a>
        <a href="javascript: void(0)" onclick="publishSlide()">
            <img src="<?=base_url();?>images/webpowerup/Publish.png" alt="Publish"/>
        </a>
        <a href="<?=base_url().index_page()?>site_slides/create/<?=$site_id?>">
            <img src="<?=base_url();?>images/webpowerup/New.png" alt="New"/>
        </a>
    </div>
</div>

<form id="frmSlides" name="frmSlides" method="post" action="<?=base_url().index_page()?>site_slides/index/<?=$site_id?>/0" >      
<div class="DataGrid2">
        
        <ul>
            <li class="Serial">
            	<input type="checkbox" value="0" name="chkSlideAll" id="chkSlideAll" onclick="selectAllSlides()" />
            </li>
            <li>Title </li>
            <li>Position</li>
            <li>Access Level </li>
            <li>Published </li>
            <li>Last Modified </li>
        </ul>
        
        <?php 
		// echo "<pre>";  print_r($records);	echo "</pre>";
		
		if($records->num_rows()>0)
   		{
			
            $intCount = 0;
            foreach($records->result_array() as $row)
			{
            $intCount++;
			?>
			<ul>
				<li class="Serial">
				<input type="checkbox" value="<?php echo $row['slide_id'];?>" name="chkSlide[]" id="chkSlide<?php echo $intCount;?>" /> 
				</li>
				<li>
                    <a class="activelink" href="<?=base_url().index_page()?>site_slides/edit/<?=$site_id?>/<?=$row['slide_id']?>">
                        <?=$row['slide_title'];?>
                    </a>
				</li>
				<li>
					<?=$row['slide_position'];?>
				</li>
				<li>
					<?=$row['slide_access'];?>
				</li>
				<li>
					<?=$row['slide_published'];?>
				</li>
				<li>
				   <span class="GridCalendar"> 
				   <?php
                    $slide_modified_date = strtotime($row['slide_modified_date']);
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
if($records->num_rows()>0)
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
 
