<html>

<head>

<title>Web Builder - Menus</title>

<style type="text/css">

div#actionMenu li {

    display: inline;

    list-style-type: none;

    padding-right: 20px;

    

}

div#actionMenu {

    padding-top: 20px;       

}

</style>

<script language="javascript" type="text/javascript">

function isChecked(){

    for(i=1;i<=<?=$numRecords?>;i++){

        if(document.getElementById('chkMenu'+i).checked==true){

            return true;            

        }

    }

    return false;

}

function publishMenu(){    

    if(isChecked() == true){

        form = document.getElementById('frmMenus');

        form.action = "<?=base_url().index_page()?>menusController/publishMenu/<?=$site_id?>"+"/00";

        form.submit();

    }

    else{

        window.alert("No menu(s) selected. Please select menu(s) first to continue.");

        return;

    }    

}

function unpublishMenu(){    

    if(isChecked() == true){

        form = document.getElementById('frmMenus');

        form.action = "<?=base_url().index_page()?>menusController/unpublishMenu/<?=$site_id?>"+"/00";

        form.submit();

    }

    else{

        window.alert("No menu(s) selected. Please select menu(s) first to continue.");

        return;

    }    

}

function deleteMenu(){    

    if(isChecked() == true){

       var msg = confirm("Are you sure you want to Delete?");
		if(msg)
	    {
	    	form = document.getElementById('frmMenus');
        	form.action = "<?=base_url().index_page()?>menusController/trashMenu/<?=$site_id?>"+"/00";
        	form.submit();
		}
		return false;	

    }

    else{

        window.alert("No menu(s) selected. Please select menu(s) first to continue.");

        return;

    }    

}

function selectAllMenu(){

    state = document.getElementById('chkMenuAll').checked;    

    for(i=1;i<=<?=$numRecords?>;i++){        

        document.getElementById('chkMenu'+i).checked=true;        

    }       

}



</script>

</head>

<body>
<div >
	<?php echo($this->breadcrumb->output()); ?>
</div>

<table width="90%" border="0" cellpadding="0" cellspacing="0" style="background:none !important;">

<tr>

    <td><h1 style="padding: 0px;">Manage My Menus</h1></td>

</tr>

<tr>

    <td>

    <?php     

    if($records->num_rows()>0){?>

    <form id="frmMenus" name="frmMenus" method="post" action="<?=base_url().index_page()?>menusController/index/<?=$site_id?>/0" style="background:none !important;border: medium none !important;">

    <table width="680" border="0" cellpadding="0" cellspacing="0" style="background:none !important;">

    <tr>

        <td align="left" colspan="2" style="padding-left: 20px;">

        <div id="actionMenu">

        <ul>

            <li><a href="<?=base_url().index_page()?>menusController/createMenu/<?=$site_id?>">New</a></li>

            <li><a href="#" onClick="publishMenu()">Publish</a></li>

            <li><a href="#" onClick="unpublishMenu()">UnPublish</a></li>

            <li><a href="#" onClick="return deleteMenu()">Trash</a></li>

        </ul>

        </div>

        </td>

        <td align="right" colspan="2" style="padding-right: 20px;" valign="top">

            <div id="actionMenu">&nbsp;</div>

        </td>

    </tr>

    </table>

<div class="head_area"><table width="100%" border="0" cellpadding="0"  cellspacing="0">
<tr>

        <th width="15%"><input type="checkbox" value="0" name="chkMenuAll" id="chkMenuAll" onClick="selectAllMenu()" /></th>

        <th width="18%" align="center" style="padding-left: 5px;">Menu Name</th>

        <th width="16%">Position</th>

        <th width="22%">Published?</th>

        <th width="29%">Display Order</th>

    </tr>
</table></div>

    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="site_builder"> 

    

    <?php 

    $intCount = 0;

    $numRecords = $records->num_rows();

    foreach($records->result_array() as $row):

        $intCount++;
		
		 
			if($intCount%2==0)
			{
				echo "<tr style='background:#f6f6f6;' calss='even'>";
			}
			else
			{
				echo "<tr style='background:#fff;' calss='odd'>";
			}   
		

    ?>
        <td width="15%" align="center">

            <?php

            $strDisabled = '';

            if($this->Menus_Model->is_main_menu($site_id, $row['menu_id']))

            {

                $strDisabled = 'disabled="disabled"';        

            }

            ?>

            <input type="checkbox" value="<?php echo $row['menu_id'];?>" name="chkMenu[]" id="chkMenu<?php echo $intCount;?>" <?=$strDisabled?> />

        </td>

        <td width="18%" style="padding-left:5px;"><a href="<?=base_url().index_page()?>menusController/showMenuInfo/<?=$site_id?>/<?php echo $row['menu_id'];?>"><?php echo $row['menu_name'];?></a></td>

        <td width="16%" align="center"><?php echo $row['menu_position'];?></td>

        <td width="22%" align="center"><?php echo $row['menu_published'];?></td>

        <td width="29%" align="center">

            <table width="45%" align="center" border="0" cellpadding="0" cellspacing="0">

                <tr>

                    <td align="center" width="15%">

                    <?php

                    $strSort = '';

                    if($intCount>1)

                    {

                        $strSort = '<a href="'.base_url().index_page().'menusController/moveUp/'.$site_id.'/'.$from.'/'.$intCount.'"><img src="'.base_url().'images/up_icon.gif" /></a>';    

                    }

                    else

                    {

                        $strSort = '&nbsp;';

                    }

                    echo $strSort;

                    ?>

                    </td>

                    <td align="center" width="15%">

                        <?=$row['menu_order'];?>

                    </td>

                    <td align="center" width="15%">

                    <?php

                    $strSort = '';

                    if($intCount<$numRecords)

                    {

                        $strSort = '<a href="'.base_url().index_page().'menusController/moveDown/'.$site_id.'/'.$from.'/'.$intCount.'"><img src="'.base_url().'images/down_icon.gif" /></a>';    

                    }

                    else

                    {

                        $strSort = '&nbsp;';

                    }

                    echo $strSort;

                    ?>

                    </td>

                </tr>

            </table>

        </td>

    </tr>

    <?php endforeach;?>

    <?php while($intCount<$pageLimit){

    $intCount++;?>

    <tr>

        <td>&nbsp;</td>

        <td>&nbsp;</td>

        <td>&nbsp;</td>

        <td>&nbsp;</td>

        <td>&nbsp;</td>

    </tr>

    <?php

    }?>

    </table>

    <table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>

        <td align="center" colspan="4" style="padding-top:20px;"><?php echo $paging;?><br />

        Display # 

        <select id="numRecords" name="numRecords" onChange="document.frmMenus.submit();">            

            <option value="5" <?php if($pageLimit==5){?>selected="selected"<?php }?>>5</option>

            <option value="10" <?php if($pageLimit==10){?>selected="selected"<?php }?>>10</option>

            <option value="20" <?php if($pageLimit==20){?>selected="selected"<?php }?>>20</option>    

        </select>

        Results <?php echo $from+1;?> - <?php echo $from+$numRecords;?> of <?=$totalRecords;?>

        </td>

    </tr>    

    </table>

    </form>

    <?php 

    }

    else{?>

    <table width="680" border="0" cellpadding="0" cellspacing="0">

    <tr>

        <td align="left" colspan="2" style="padding-left: 20px;">

        <div id="actionMenu">

        <ul>

            <li><a href="<?=base_url().index_page()?>menusController/createMenu/<?=$site_id?>">New</a></li>

            <li><a href="javascript: void(0)" onClick="publishMenu()">Publish</a></li>

            <li><a href="javascript: void(0)" onClick="unpublishMenu()">UnPublish</a></li>

            <li><a href="javascript: void(0)" onClick="return deleteMenu()">Trash</a></li>

        </ul>

        </div>

        </td>

        <td align="right" colspan="2" valign="top" style="padding-right: 20px;">

        <div id="actionMenu">

        <!--

        <ul>

            <li><a target="_blank" href="<?=base_url().index_page()?>menusController/preview/<?=$page_id?>">Preview</a></li>            

        </ul>

        -->

        </div>

        </td>

    </tr>

    </table>

    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top:20px;"> 

    <tr>

        <th width="5%"><input type="checkbox" value="0" name="chkMenuAll" id="chkMenuAll" /></th>

        <th align="left" style="padding-left: 5px;">Menu Name</th>

        <th>Position</th>

        <th>Published?</th>

    </tr>

    <?php 

    $intCount = 0;    

    while($intCount<$pageLimit){

    $intCount++;?>

    <tr>

        <td>&nbsp;</td>

        <td>&nbsp;</td>

        <td>&nbsp;</td>

        <td>&nbsp;</td>

    </tr>

    <?php

    }?>

    </table>

    <table width="680" border="0" cellspacing="0" cellpadding="0" style="padding-top: 20px;">

    <tr>

        <td align="center" colspan="4"><?php echo $paging;?><br />

        Display # 

        <select id="numRecords" name="numRecords" onChange="document.frmMenus.submit();">            

            <option value="3" <?php if($pageLimit==3){?>selected="selected"<?php }?>>3</option>

            <option value="10" <?php if($pageLimit==10){?>selected="selected"<?php }?>>10</option>

            <option value="20" <?php if($pageLimit==20){?>selected="selected"<?php }?>>20</option>    

        </select>

        Results <?php echo $from+1;?> - <?php echo $from+$numRecords;?> of <?=$totalRecords;?>

        </td>

    </tr>    

    </table>

    <?php    

    }?>    

    </td>

</tr>



</table>

</body>

</html>