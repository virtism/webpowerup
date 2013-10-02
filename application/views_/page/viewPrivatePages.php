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
    for(i=1;i<=<?=$numRecords?>;i++){
        if(document.getElementById('chkPage'+i).checked==true){
            return true;            
        }
    }
    return false;
}
function publishPage(){    
    if(isChecked() == true){
	
        form = document.getElementById('frmPages');
        form.action = "<?=base_url().index_page()?>pagesController/publishPage/<?=$site_id?>";
        form.submit();
    }
    else{
        window.alert("No page(s) selected. Please select page(s) first to continue.");
        return;
    }    
}
function unpublishPage(){    
    if(isChecked() == true){
        form = document.getElementById('frmPages');
        form.action = "<?=base_url().index_page()?>pagesController/unpublishPage/<?=$site_id?>";
        form.submit();
    }
    else{
        window.alert("No page(s) selected. Please select page(s) first to continue.");
        return;
    }    
}
function deletePage(){    
    if(isChecked() == true){
       
	   var msg = confirm("Are you sure you want to Delete?");
		if(msg)
		{
			form = document.getElementById('frmPages');
			form.action = "<?=base_url().index_page()?>pagesController/trashPage/<?=$site_id?>";
			form.submit();	
		}
		return false;
    }
    else{
			// Define changes to default configuration here. For example:
// l = window.location;
// var base_url = l.host + "/" ;
// window.alert(base_url);
        window.alert("No page(s) selected. Please select page(s) first to continue.");
        return;
    }    
}
function selectAllPage(){
    state = document.getElementById('chkPageAll').checked;    
    for(i=1;i<=<?=$numRecords?>;i++){        
        document.getElementById('chkPage'+i).checked=state;        
    }       
}


$(document).ready(function(e) {  
	$(".DataGrid2 ul:odd").addClass("TableData");
	$(".DataGrid2 ul:even").addClass("TableData AlterRow");
	$(".DataGrid2 ul:first").removeClass("TableData AlterRow").addClass("TableHeader");
});



$("NFSelectRight").live("click",function(){
	var id = $(this).next("input").attr("id");
	alert(id);
	
	
});
</script>

<div class="RightColumnHeading">
    <h1>
        <span>Manage My Pages</span>
    </h1>
    <div class="RightSideButton">
        <a href="javascript: void(0)" onClick="return deletePage()">
            <img src="<?=base_url()?>images/webpowerup/Trash.png" alt="Trash"/>
        </a>
        <a href="javascript: void(0)" onClick="unpublishPage()">
            <img src="<?=base_url()?>images/webpowerup/Unpublish.png" alt="Unpublish"/>
        </a>
        <a href="javascript: void(0)" onClick="publishPage()">
            <img src="<?=base_url()?>images/webpowerup/Publish.png" alt="Publish"/>
        </a>
       <?php /*?> <a href="<?=base_url().index_page()?>pagesController/basic_info/<?=$site_id?>">
            <img src="<?=base_url()?>images/webpowerup/New.png" alt="New"/>
        </a><?php */?>
    </div>
</div>
<div class="clr"></div>

<div class="InnerMain2">

<div class="">

        <form  id="frmPages" name="frmPages" method="post" action="<?=base_url().index_page()?>pagesController/index/<?=$site_id?>/0" >
    <div class="DataGrid2">
    
                <ul>
                    <li class="Serial">
                        <input type="checkbox" value="0" name="chkPageAll" id="chkPageAll" onClick="selectAllPage()"  />  
                    </li>
                    <li>Title</li>
                    <li>Access Level</li>
                    <li>Status</li>
                    <li>Last Modified</li>
                </ul>
                
                
            <?php 
			if($records->num_rows()>0)
			{
                $intCount = 0;
                foreach($records->result_array() as $row)
                {
                $intCount++;
                ?>
                    <ul >
                        <li class="Serial" style="height:42px;">
                        <?php
                        $strDisabled = '';
                        if($this->Pages_Model->isHomepage($row["page_id"]))
                        {
                            $strDisabled = 'disabled="disabled"';
                        }
                        ?>
                            <input type="checkbox" value="<?php echo $row['page_id'];?>" name="chkPage[]" id="chkPage<?php echo $intCount;?>" <?=$strDisabled?>  />  
                        </li>
                        <li>
                            <a target="_blank" href="<?=base_url().index_page()?>page_editor/index/<?=$site_id?>/<?php echo $row['page_id'];?>" class="activelink"><?php echo $row['page_title'];?></a>
                        </li>
                         <li>
                           <?php 
                                if($row['page_access'] == "Other")
                                {
                                    //echo $this->Pages_Model->get_page_access_title($row['page_id']);	
                                    echo $row['page_access'];
                                }
                                else
                                {
                                    echo $row['page_access'];
                                }
                                
                            ?>
                        </li>
                        <li>
                            <?php echo $row['page_status'];?>
                        </li>
                        <li>
                          <?php
                            $page_modified_date = strtotime($row['page_modified_date']);
                            $page_modified_date = date('M. d, Y (h:i a)', $page_modified_date);        
                            echo $page_modified_date;
                            ?>
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
    <div class="pageDiv">
        <?php echo $paging;?>
        <br />
        Display # 
        <select id="numRecords" name="numRecords" onChange="document.frmPages.submit();">            
            <option value="5" <?php if($pageLimit==5){?>selected="selected"<?php }?>>5</option>
            <option value="10" <?php if($pageLimit==10){?>selected="selected"<?php }?>>10</option>
            <option value="20" <?php if($pageLimit==20){?>selected="selected"<?php }?>>20</option>    
        </select>
        Results <?php echo $from+1;?> - <?php echo $from+$numRecords;?> of <?=$totalRecords;?>
    </div>
    </form>	
    </div>

</div>

