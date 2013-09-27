<html>
<head>
<title></title>


<script type="text/javascript" language="javascript">

numMenus = <?=$menus->num_rows()?>;
submitFlag = true;
/*
function popMenu()
{
	var width = 800;
	var height = 600;
	var page_title = document.getElementById("page_title");
	
	window.open("<?=base_url()?>index.php/menusController/addMenuForm/<?=$site_id?>", "CreateMenu", "width=800, height=600, scrollbars=yes");   
}
*/
function showRoles(){
	var role = document.getElementById("roles");        
	
	if(role.style.visibility=="hidden"){
		role.style.visibility="visible";
		role.style.position="relative";
	}    
}

function hideRoles(){
	var role = document.getElementById("roles");        
	
	if(role.style.visibility=="visible"){
		role.style.visibility="hidden";
		role.style.position="absolute";
	}    
}

function uncheckMenus()
{
	for(i=1;i<=numMenus;i++)
	{
		var chkMenu = document.getElementById("menu_id_"+i);
        $(chkMenu).parent().removeClass('checked');
		if(chkMenu.checked == true)
		{
			chkMenu.checked = false;    
		}  
          
	}  
    
}

function uncheckCreateLink()
{
	var page_link1 =  document.getElementById("page_link1"); 
    var page_link2 =  document.getElementById("page_link2");
    var page_link3 =  document.getElementById("page_link3");
    
	$(page_link1).parent().removeClass('checked');
	if(page_link1.checked == true)
	{
		page_link1.checked = false;           
	}  
    
    $(page_link2).parent().removeClass('checked');
    if(page_link2.checked == true)
    {
        page_link2.checked = false;           
    } 
    
    $(page_link3).parent().removeClass('checked');
    if(page_link3.checked == true)
    {
        page_link3.checked = false;           
    } 
}

function setForm(){    
	var page_link1 =  document.getElementById("page_link1");
	page_link1.checked = true;
	var page_access_1 =  document.getElementById("page_access_1");
	page_access_1.checked = true;
}


</script>
<script type="text/javascript"> 
    <!-- 
    function showMe (it, box) { 
      var vis = (box.checked) ? "block" : "none"; 
      document.getElementById(it).style.display = vis;
    } 
    function hideMe (it, box) { 
      var vis = (box.checked) ? "none" : "block"; 
      document.getElementById(it).style.display = vis;
    } 
    //--> 
</script>    
</head>
<?php
$strOnLoad = '';
if($action != 'edit')
{
    $strOnLoad = 'setForm()';
}                  
?>
<body onload="<?=$strOnLoad?>">
<script type="text/javascript">
	$(document).ready(function() {
	   
		$("#create_menu").fancybox({
			'width'                : '60%',
			'height'            : '95%',
			'autoScale'            : false,
			'transitionIn'        : 'none',
			'transitionOut'        : 'none',
			'type'                : 'iframe' 
		});

		
	});
    $(document).ready(function() {
       
        $("a.edit_menu").fancybox({
            'width'                : '60%',
            'height'            : '95%',
            'autoScale'            : false,
            'transitionIn'        : 'none',
            'transitionOut'        : 'none',
            'type'                : 'iframe'
        });

        
    });
    
function validate()
{
    page_access = document.getElementById('page_access_3');
    role_id = document.getElementById('role_id[]')
    if(page_access.checked==true && role_id.value=="")
    {
        alert("Please select Role(s) allowed to access this page");
        return false;
    }
    else
    {
        return true;    
    }
    
}

</script>
<!--
<?php
if($action=='edit')
{
    $strAction = base_url().'index.php/pagesController/edit_page_menu';
}
else
{
    $strAction = base_url().'index.php/pagesController/save_page_menu';   
}
?>
<form id="frmMenuInfo" name="frmMenuInfo" action="<?=$strAction?>" method="post" onsubmit="return validate()">
<input type="hidden" name="site_id" value="<?=$site_id?>" />
<input type="hidden" name="page_id" value="<?=$page_id?>" />
<input type="hidden" name="item_name" value="<?=$item_name?>" />
<?php
/*if(isset($_POST["role_id"]))
{
	for($i=0; $i<sizeof($this->input->post("role_id")); $i++)
	{
?>
   <!--<input type="hidden" name="role_id[]" value="<?=$_POST["role_id"][$i]?>" />-->    
<?
	}
}*/    
?>

<table width="100%" border="0" cellspacing="5" cellpadding="0" style="margin-top: 20px;">
	<tr>
		<td valign="top">Menus which appear on this page: <span style="color: red">*</span></td>
		<td>
            <a id="create_menu" href="<?=base_url()?>index.php/menusController/addMenuForm/<?=$site_id?>">Add New Menu</a>
            <br />
            
			<?php                        
			$strChecked = "";
			$i = 1;
            if(!isset($item_id))
            {
                $item_id = 0;
            }
            $flagMenuSet = false;
			foreach($menus->result_array() as $rowMenus){
                $flag = $this->Pages_Model->isPageItemMenu($item_id, $rowMenus['menu_id']);
                if($flag == true)
                {                               
                    $strChecked = 'checked="checked"'; 
                    $flagMenuSet = true;   
                }
                else
                {
                    $strChecked = "";
                }
			?>
                <a class="edit_menu" href="<?=base_url()?>index.php/menusController/showMenu/<?=$site_id?>/<?=$rowMenus["menu_id"]?>"><img src="<?=base_url()?>images/edit_icon.jpg" style="border:none;background:none;" /></a>
                <label>
                    <input type="checkbox" id="menu_id_<?=$i?>" name="menu_id[]" value="<?=$rowMenus["menu_id"] ?>" <?=$strChecked;?> onclick="uncheckCreateLink()" /> 
                    <?=$rowMenus["menu_name"];?>
                </label>
                <br />
            <?php
			$i++;
			}?> 
            
            <?php
            $strChecked = '';
            if($flagMenuSet == false)
            {
                $strChecked = 'checked="checked"';    
            }
            ?>
            <label>
				<input type="radio" id="page_link" name="page_link" value="Create" onclick="uncheckMenus()" <?=$strChecked?> /> None (Don't Create a Page)<font size="-1"> &nbsp; &nbsp;Just show me the link after the page is saved</font>
			</label>
			<br />
			<?=form_error("menu_id[]")?>
            
		</td>
	</tr>
	<tr>
		<td valign="top">Who can see this page? <span style="color: red">*</span></td>
		<td>
			<?php
			if($this->input->post("page_access")){
				$page_access = $this->input->post("page_access");
			}
			else{
				$page_access = "";
			}
		?>
		<?php
			if($page_access == "Everyone"){
				$strChecked = 'checked="checked"';
			}
			else{
				$strChecked = "";
			}
		?>
		<label>
			<input type="radio" id="page_access_1" name="page_access" value="Everyone" onclick="hideRoles()" <?=$strChecked;?> selected="selected" /> Everyone
		</label>
		<?php
			if($page_access == "Registered"){
				$strChecked = 'checked="checked"';
			}
			else{
				$strChecked = "";
			}
		?>
		<br />
		<label>
			<input type="radio" id="page_access_2" name="page_access" value="Registered" onclick="hideRoles()" <?=$strChecked;?> /> All Registered Users
		</label>
		<br />
		<?php
			if($page_access == "Other"){
				$strChecked = 'checked="checked"';
			}
			else{
				$strChecked = "";
			}
		?>
		<label>
			<input type="radio" id="page_access_3" name="page_access" value="Other" onclick="showRoles()" <?=$strChecked;?> /> Only Users With a Certain Access Level
			&nbsp;<?=form_error("role_id[]");?>
		</label>
		<br />
		<?php
		if($page_access == 'Other'){
			$strStyle="visibility: visible; position: relative;";
		}
		else{
			$strStyle="visibility: hidden; position: absolute;";    
		}
		?>
		<span id="roles" name="roles" style="<?=$strStyle;?>">    
		<select id="role_id[]" name="role_id[]" multiple="multiple" style="width:130px; margin-left:25px;margin-bottom:10px;">
			<?php 
			$strSelected = "";
			foreach($roles->result_array() as $rowRoles)
            {
			    if($page_access == "Other" && $action=='edit')
                {
				    if($this->Pages_Model->isPageRole($page_id, $rowRoles['role_id']))
                    {
					    $strSelected = 'selected="selected"';
				    }
				    else
                    {
					    $strSelected = "";
				    }
			    }    
			?>
			<option value="<?=$rowRoles['role_id']?>" <?=$strSelected;?>><?=$rowRoles['role_name']?></option>
			<?php 
			}?>        
		</select>
		</span>
		</td> 
			   
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>
            <input type="button" value="Back" onclick="document.getElementById('frmEditBasicInfo').submit();" />
            <input type="submit" value="Continue" />
        </td>        
	</tr>    
</table>
</form> 
-->

<?php
if($action=='edit')
{
    $strAction = base_url().'index.php/pagesController/edit_page_menu';
}
else
{
    $strAction = base_url().'index.php/pagesController/save_page_menu';   
}
$main_menu_id=0;
?>
<form id="frmMenuInfo" name="frmMenuInfo" action="<?=$strAction?>" method="post" onsubmit="return validate()">

    <fieldset>
        <input type="hidden" name="site_id" value="<?=$site_id?>" />
        <input type="hidden" name="page_id" value="<?=$page_id?>" />
        <input type="hidden" name="item_name" value="<?=$item_name?>" />
        
        
        <label>Create a New Page : Menu & Access (Step 2)</label>
        
        <div class="section">
            <label>Select Menu(s) <span class="required">&nbsp;</span></label>
            
            <div>
                <a id="create_menu" href="<?=base_url()?>index.php/page_editor/createMenu/<?=$site_id?>">Create New Menu</a>
                <br />
            
                <?php                        
                $strChecked = "";
                $i = 1;
                if(!isset($item_id))
                {
                    $item_id = 0;
                }
                $flagMenuSet = false;
                foreach($menus->result_array() as $rowMenus)
                {
                    $flag = $this->Pages_Model->isPageItemMenu($item_id, $rowMenus['menu_id']);
                    if($flag == true)
                    {                               
                        $strChecked = 'checked="checked"'; 
                        $strClass = 'class="checked"'; 
                        $flagMenuSet = true;   
                    }
                    else
                    {
                        $strChecked = "";
                        $strClass = '';
                    }
                    
                    if($rowMenus['menu_name'] == 'Main Menu'){
                        $main_menu_id = $rowMenus['menu_id'];
                    }
                    
                ?>
                
                <div class="checker">
                    <span <?=$strClass?>><input type="checkbox" id="menu_id_<?=$i?>" name="menu_id[]" value="<?=$rowMenus["menu_id"] ?>" <?=$strChecked;?> onclick="uncheckCreateLink()" onchange="hideMe('link', this)" /></span>
                </div>
              <label for="menu_id_<?=$i?>"><?=$rowMenus["menu_name"];?></label>
                <br />
                <?php
                $i++;
                }
               
                $strChecked = '';
                $strClass = '';
                if($flagMenuSet == false)
                {
                    $strChecked = 'checked="checked"';  
                    $strClass = 'class="checked"';  
                }
                ?>
                <input type="hidden" name="main_menu_id" value="<?=$main_menu_id?>" />
                <br />
                <div class="radio">
                    <span <?=$strClass?>><input type="radio" id="page_link1" name="page_link" value="Create" onchange="hideMe('link', this)"  onclick="uncheckMenus()" <?=$strChecked?> /></span>
                </div>
                <label for="page_link1">None (Don't Create a Menu item) Just show me the URL after the page has been created.</label>                        
                
                <br />
                <br />
                <div class="radio">
                    <span><input type="radio" id="page_link2" name="page_link" value="Top" onclick="uncheckMenus()" onchange="showMe('link', this)" /></span>
                </div>
                <label for="page_link2">Top Navigation (Select Parent :  for sub menu of top menu)</label>
                
                <div class="selector" id="link" style="display: none; margin-top: 4px;">
                    <span style=""> <?php echo current($page); ?> </span> 
                  <?php echo form_dropdown('parent_id',$page, 0 , ' id="drop" ') ?>
                  </div>
  
                <br />
                <br />
                <div class="radio">
                    <span><input type="radio" id="page_link3" name="page_link" value="Footer" onclick="uncheckMenus()"  onchange="hideMe('link', this)" /></span>
                </div>
                <label for="page_link3">Footer Links</label>
            </div>
        </div>
        
        <div class="section">
            <label>Who can see this page? <span class="required">&nbsp;</span></label>
             <div>      
                <div class="radio">
                    <?php
                    if($this->input->post("page_access"))
                    {
                        $page_access = $this->input->post("page_access");
                    }
                    else
                    {
                        $page_access = "";
                    }
                
                    if($page_access == "Everyone" || $page_access=='')
                    {
                        $strChecked = 'checked="checked"';
                        $strClass = 'class="checked"';
                    }
                    else
                    {
                        $strChecked = "";
                        $strClass = '';
                    }
                    ?>
                    <span <?=$strClass?>><input type="radio" id="page_access_1" name="page_access" value="Everyone" onclick="hideRoles()" <?=$strChecked;?> /></span>
                </div>
                <label for="page_access_1">Everyone</label>
                
                <div class="radio">
                    <?php
                    if($page_access == "Registered")
                    {
                        $strChecked = 'checked="checked"';
                        $strClass = 'class="checked"';
                    }
                    else
                    {
                        $strChecked = "";
                        $strClass = '';
                    }
                    ?>
                    <span <?=$strClass?>><input type="radio" id="page_access_2" name="page_access" value="Registered" onclick="hideRoles()" <?=$strChecked;?> /></span>
                </div>
                <label for="page_access_2">Registered</label>
                
                <div class="radio">
                    <?php
                    if($page_access == "Other")
                    {
                        $strChecked = 'checked="checked"';
                        $strClass = 'class="checked"';
                    }
                    else
                    {
                        $strChecked = "";
                        $strClass = '';
                    }
                    ?>
                    <span <?=$strClass?>><input type="radio" id="page_access_3" name="page_access" value="Other" onclick="showRoles()" <?=$strChecked;?> /></span>
                </div>
                <label for="page_access_3">Other</label>
                
                <?php
                if($page_access == 'Other'){
                    $strStyle="visibility: visible; position: relative;";
                }
                else{
                    $strStyle="visibility: hidden; position: absolute;";    
                }
                ?>
                <div id="roles" name="roles" style="<?=$strStyle;?>">    
                <select id="role_id[]" name="role_id[]" multiple="multiple" style="width:130px; opacity: 1;filter: alpha(opacity = 100); margin-top: 10px;">
                    <?php 
                    $strSelected = "";
                    $i = 0;
                    foreach($roles->result_array() as $rowRoles)
                    {
                        if($page_access == "Other" && $action=='edit')
                        {
                            if($this->Pages_Model->isPageRole($page_id, $rowRoles['role_id']))
                            {
                                $strSelected = 'selected="selected"';
                            }
                            else
                            {
                                $strSelected = "";
                            }
                        }
                        if($action!='edit' && $i==0)
                        {
                            $strFirstSelected = 'selected="selected"';    
                        }    
                        else
                        {
                            $strFirstSelected = '';    
                        }
                    ?>
                    <option value="<?=$rowRoles['role_id']?>" <?=$strSelected;?> <?=$strFirstSelected?>><?=$rowRoles['role_name']?></option>
                    <?php 
                    $i++;
                    }
                    ?>        
                </select>
                </div>
                
            </div>
            
            <div class="section">
                <div>
                    <input type="button" value="Back" onclick="document.getElementById('frmEditBasicInfo').submit();" /> 
                    <input type="submit" value="Continue" />
                </div>
            </div>
        </div>
           
    </fieldset>
</form>

<form id="frmEditBasicInfo" action="<?=base_url()?>index.php/pagesController/basic_info/<?=$site_id?>" method="post" style="visibility: hidden;">
    <input type="hidden" name="site_id" value="<?=$site_id?>" /> 
    <input type="hidden" name="page_id" value="<?=$page_id?>" />
    <input type="hidden" name="item_name" value="<?=$item_name?>" />
    <?php
    if(!isset($item_id))
    {
        $item_id = '0';
    }
    ?>
    <input type="hidden" name="item_id" value="<?=$item_id?>" />  
</form>

<script type="text/javascript" language="javascript">
//jquery for checkbox control
    $('div.checker span').click(function() {
        var className = $(this).attr('class');
        if(className == "")
        {
            $(this).addClass("checked"); 
            $(this).find('input').attr("checked", true);         
        }
        else
        {
            $(this).removeClass('checked');
            $(this).find('input').attr("checked", false);   
        }
    });
    
     //jquery for select list control
    $('div.selector select').change(function() {
        $(this).parent().find('span').text($(this).find('option:selected').html()) ;   
    });    
    
//jquery for radio button control
$('div.radio span input:radio').click(function() {
    $(this).parent().parent().parent().find('div.radio span').removeClass('checked');
    $(this).parent().parent().parent().find('div.radio span input').attr('checked', false);
    
    var className = $(this).parent().attr('class');
    if(className == "")
    {
        $(this).parent().addClass("checked");
        $(this).attr('checked', true);
    }
    else
    {
        $(this).parent().removeClass('checked'); 
        $(this).attr('checked', false);
    }
});
</script>
</body>
</html>
