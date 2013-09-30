<?php echo doctype();?>
<html>
<head>
<title>Web Builder - Add Menu</title>
<script language="javascript" type="text/javascript" src="<?=base_url();?>datetimepick/datetimepicker.js"></script>
<script language="javascript" type="text/javascript">
<?php if($this->input->post("numItems")){?>
countItems = <?=$this->input->post("numItems");?>;    
<?php
}
else{?>
countItems = 0;
<?php 
}?>
function addMenuItem(){
    countItems++;    
    var items = document.getElementById('numItems');    
    items.value++;    
    var tbl = document.getElementById('tblItems');
    var lastRow = tbl.rows.length-1;
    var row = tbl.insertRow(lastRow);
    var cell1 = row.insertCell(0);
    cell1.innerHTML = '<input type="text" id="txtItemName'+countItems+'" name="txtItemName'+countItems+'" value="" />';
    cell1.align = "center";
    var cell2 = row.insertCell(1);
    cell2.innerHTML = '<select id="lstItemPage'+countItems+'" name="lstItemPage'+countItems+'"><?php //foreach($pages->result_array() as $rowPages):?><option value="<?=$rowPages['page_id']?>"><?=$rowPages['page_title']?></option><?php endforeach;?></select>';
    cell2.align = "center";
    var cell3 = row.insertCell(2);
    cell3.innerHTML = '<label><input type="radio" id="rdoItemPublished'+countItems+'" name="rdoItemPublished'+countItems+'" value="Yes" checked="checked" />Yes</label> <label><input type="radio" id="rdoItemPublished'+countItems+'" name="rdoItemPublished'+countItems+'" value="No" />No</label>';
    cell3.align = "center";      
}

function hideRoles(){
    var role = document.getElementById("roles");        
    
    if( role.style.visibility=="visible"){
        role.style.visibility="hidden";
        role.style.position="absolute";
    }    
}

function showRoles(){
    var role = document.getElementById("roles");        
    
    if(role.style.visibility=="hidden"){
        role.style.visibility="visible";
        role.style.position="relative";
    }    
}

function hideSchedule(){
    var schedule = document.getElementById("schedular");        
    
    if(schedule.style.visibility=="visible"){
        schedule.style.visibility="hidden";
        schedule.style.position="absolute";
    }    
}

function showSchedule(){
    var schedule = document.getElementById("schedular");        
    
    if(schedule.style.visibility=="hidden"){
        schedule.style.visibility="visible";
        schedule.style.position="relative";
    }    
}

function showPages(){    
    var page = document.getElementById("pages");
    
    if(page.style.visibility=="hidden"){
        page.style.visibility="visible";
        page.style.position="relative";
    }    
}

function hidePages(){
    var page = document.getElementById("pages");        
    
    if(page.style.visibility=="visible"){
        page.style.visibility="hidden";
        page.style.position="absolute";
    }    
}

function resetForm(){    
    document.frmAddMenu.txtName.focus();
    position = document.getElementById('rdoPosition1');
    position.checked = true;
    publish = document.getElementById('rdoPublished1'); 
    publish.checked = true;
    page = document.getElementById('rdoPages1');
    page.checked = true;
    view = document.getElementById('rdoRights1'); 
    view.checked = true;
}
</script>
</head>
<body <?php if(!$this->input->post()){?>onload="resetForm()<?php }else{?>onload="document.frmAddMenu.txtName.focus();"<?php }?>">
<table align="center" width="960" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td>
            <h1>Add New Menu</h1>
        </td>
    </tr>
<tr>                 
        <?
        if(1)
        {
          $_POST["txtName"] = "dbValue";   
          $_POST["rdoPosition"] = "Right";
        }
        else
        {
          //Post
          
        }
        
        ?>
    <td valign="top">    
    <h3>Menu Name</h3>
    <hr />
    <form id="frmAddMenu" name="frmAddMenu" action="<?=base_url().index_page()?>menusController/addMenu" method="post">
    <input type="hidden" id="numItems" name="numItems" value="<?php if($this->input->post("numItems")){?><?=$this->input->post("numItems");?><?php }else{?>0<?php }?>" />
    <input type="text" name="txtName" id="txtName" value="<?=$this->input->post("txtName");?>" /><?=form_error("txtName");?>
    <br />
    <h3>Menu Position</h3>
    <hr />
    <label><input type="radio" id="rdoPosition1" name="rdoPosition" value="Left" <?php if($this->input->post("rdoPosition")=="Left"){?>checked="checked"<?php }?> /> Left</label>
    <br />
    <label><input type="radio" id="rdoPosition2" name="rdoPosition" value="Right" <?php if($this->input->post("rdoPosition")=="Right"){?>checked="checked"<?php }?> /> Right</label>
    <h3>Published?</h3>
    <hr />  
    <label><input type="radio" id="rdoPublished1" name="rdoPublished" value="Yes" onclick="hideSchedule()" <?php if($this->input->post("rdoPublished")=="Yes"){?>checked="checked"<?php }?> />Yes</label>
    <br />
    <label><input type="radio" id="rdoPublished2" name="rdoPublished" value="No" onclick="hideSchedule()" <?php if($this->input->post("rdoPublished")=="No"){?>checked="checked"<?php }?> />No</label><br />
    <label><input type="radio" id="rdoPublished3" name="rdoPublished" value="Schedule" onclick="showSchedule()" <?php if($this->input->post("rdoPublished")=="Schedule"){?>checked="checked"<?php }?> />Publish for specific amount of time</label><br />
    <div id="schedular" style="<?php if($this->input->post("rdoPublished")=="Schedule"){?>visibility: visible; position: relative;<?php }else{?>visibility: hidden; position: absolute;<?php }?>">
    <p style="padding-left:20px;">
    <b>Start:</b><br />    
    Date/Time:<input id="startDate" name="startDate" type="text" value="<?=$this->input->post("startDate");?>" size="25" readOnly="readOnly"><a href="javascript:NewCal('startDate','ddMMyyyy',true,12)"><img src="<?=base_url();?>datetimepick/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a><?=form_error("startDate");?>    
    </p>
    <p style="padding-left:20px;">    
    <b>End:</b><br />    
    Date/Time:<input id="endDate" name="endDate" type="text" value="<?=$this->input->post("endDate");?>" size="25" readOnly="readOnly"><a href="javascript:NewCal('endDate','ddMMyyyy',true,12)"><img src="<?=base_url();?>datetimepick/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a><?=form_error("endDate");?><br />    
    </p>
    </div>
    <h3>Display on Which Pages?</h3>
    <hr />
    <label><input type="radio" id="rdoPages1" name="rdoPages" value="All" onclick="hidePages()" <?php if($this->input->post("rdoPages")=="All"){?>checked="checked"<?php }?> />All Pages</label><br />
    <label><input type="radio" id="rdoPages2" name="rdoPages" value="Other" onclick="showPages()" <?php if($this->input->post("rdoPages")=="Other"){?>checked="checked"<?php }?> />Only on these Pages:</label><br />
    <?
        if($this->input->post("rdoPages")=="Other")
        {
            $styles = " visibility: visible; position: relative;";
        }
        else
        {
            $styles = " visibility: hidden; position: absolute;";
        }
    ?>
    <div id="pages" style="<?=$styles?>">
    <select id="lstPages[]" name="lstPages[]" multiple="multiple" size="5" style="margin-left: 25px; width:130px;">
        <?php foreach($pages->result_array() as $rowPages){?>
        <option value="<?=$rowPages['page_id']?>" <?php if($this->input->post("lstPages")){if(in_array($rowPages['page_id'], $this->input->post("lstPages"))){?>selected="selected"<?php }}?>><?=$rowPages['page_title']?></option>
        <?php }?>        
    </select><?=form_error("lstPages[]");?>
    </div>
    <h3>Who Can View This Menu?</h3>
    <hr />
    <label><input type="radio" id="rdoRights1" name="rdoRights" value="Everyone" onclick="hideRoles()" <?php if($this->input->post("rdoRights")=="Everyone"){?>checked="checked"<?php }?>  />Everyone</label><br />
    <label><input type="radio" id="rdoRights2" name="rdoRights" value="Registered" onclick="hideRoles()" <?php if($this->input->post("rdoRights")=="Registered"){?>checked="checked"<?php }?> />Only Registered Users</label><br />
    <label><input type="radio" id="rdoRight3s" name="rdoRights" value="Other" onclick="showRoles()" <?php if($this->input->post("rdoRights")=="Other"){?>checked="checked"<?php }?> />Only Users With Certain Access Level</label><br />
    <span id="roles" style="<?php if($this->input->post("rdoRights")=="Other"){?>visibility: visible; position: relative;<?php }else{?>visibility: hidden; position: absolute;<?php }?>">    
    <select id="lstRoles[]" name="lstRoles[]" multiple="multiple" style="width:130px; margin-left:25px;margin-bottom:10px;">
        <?php foreach($roles->result_array() as $rowRoles):?>
        <option value="<?=$rowRoles['role_id']?>" <?php if($this->input->post("lstRoles")){if(in_array($rowRoles['role_id'], $this->input->post("lstRoles"))){?>selected="selected"<?php }}?>><?=$rowRoles['role_name']?></option>
        <?php endforeach;?>        
    </select><?=form_error("lstRoles[]");?>
    </span>
   
    <h3>Menu Items</h3>
    <hr />
    <table id="tblItems" width="100%" border="1" cellpadding="0" cellspacing="0">
    <tr>
        <th width="40%">Item</th>
        <th width="30%">Destination</th>
        <th>Published</th>
    </tr>
    <?php
    if($this->input->post("numItems")>0){?>
        <?php for($i=1;$i<=$this->input->post("numItems");$i++){?>
    <tr>
        <td align="center"><input type="text" id="txtItemName<?=$i;?>" name="txtItemName<?=$i;?>" value="<?=$this->input->post("txtItemName".$i);?>" /></td>
        <td align="center"><select id="lstItemPage<?=$i;?>" name="lstItemPage<?=$i;?>"><?php foreach($pages->result_array() as $rowPages):?><option value="<?=$rowPages['page_id']?>" <?php if($this->input->post("lstItemPage".$i)==$rowPages['page_id']){?>selected="selected"<?php }?>><?=$rowPages['page_title']?></option><?php endforeach;?></select></td>
        <td align="center"><label><input type="radio" id="rdoItemPublished<?=$i;?>" name="rdoItemPublished<?=$i;?>" value="Yes" <?php if($this->input->post("rdoItemPublished".$i)=="Yes"){?>checked="checked"<?php }?> />Yes</label> <label><input type="radio" id="rdoItemPublished<?=$i;?>" name="rdoItemPublished<?=$i;?>" value="No" <?php if($this->input->post("rdoItemPublished".$i)=="No"){?>checked="checked"<?php }?> />No</label></td>
    </tr>
        <?php
        }?>
    <?php 
    }?>
    <tr>
        <td colspan="3"><a name="item" href="#item" onclick="addMenuItem()">Click here to Create a New Menu Item.</a></td>
    </tr>
    </table>
    <br />   
    <input type="submit" value="Create Menu" /> 
    </form>
    </td>
</tr>
</table>
</body>
</html>
