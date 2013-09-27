
<html>
<title></title>
<head>
<script language="javascript" type="text/javascript" src="<?=base_url()?>js/jquery-1.5.1.min.js"></script>
<script type="text/javascript" language="javascript">


function get_group_member()
{
	
	
	var group_ids = $("#groups_ids").val();
	//alert(group_ids);
	dataString = "groups_ids="+group_ids; 
	
	$.ajax({

        type: "POST",

        url: "<?=base_url().index_page()?>pagesController/get_groups_members",

        data: dataString,

        success: function(response){
                
				if(response != ""){                                               
                    $("#memberDropdown").show();
                    $("#memberDropdown").html(response);

                }
				else
				{
					$("#memberDropdown").show();
                    $("#memberDropdown").html("No member found in this group");
				}
				
            }

        });
		
	
}
function get_group_member_selected()
{
	
	
	var group_ids = $("#groups_ids").val();
	
	var page_users = "<?php echo $page_users; ?>";
	//alert(page_users);
	dataString = "groups_ids="+group_ids+"&page_users="+page_users; 
	
	$.ajax({

        type: "POST",

        url: "<?=base_url().index_page()?>pagesController/get_groups_members_selected",

        data: dataString,

        success: function(response){
                
				if(response != ""){                                               
                    $("#memberDropdown").show();
                    $("#memberDropdown").html(response);

                }
				else
				{
					$("#memberDropdown").show();
                    $("#memberDropdown").html("");
				}
				
            }

        });
		
	
}

function hide_element(id)
{
	$("#"+id).slideUp('slow');
}
function show_element(id)
{
	$("#"+id).slideDown('slow');
}


$(document).ready(function() {
    
	<?php 
	if ($page_access == "Other")
	{ ?>
		
       
		show_element("groups_ids");
		
        
	<?php
    } 
	else
	{ ?>
		$("#groups_ids").hide();
		$("#memberDropdown").html("");
		
	<?php
	} ?>
	
	
	$("#page_access1").click(function(){
	
		hide_element("groups_ids");
		$("#memberDropdown").html("");
		
	});
	$("#page_access2").click(function(){
	
		hide_element("groups_ids");
		$("#memberDropdown").html("");
		
	});
	$("#page_access3").click(function(){
	
		show_element("groups_ids");
		
	});
	$("#groups_ids").change(function(){
	
		get_group_member();
		
	});
	
	<?php 
	if ($page_users != "")
	{ ?>
		
       
		get_group_member_selected();
		
        
	<?php
    }
	?>
	
	
	
});

</script>
</head>
<body>
<h2>Page Privacy </h2>
<form id="frmEditPageTitle" method="post" action="<?=base_url().index_page()?>page_editor/savePagePrivacy/<?=$site_id?>/<?=$page_id?>" onSubmit="return validate()">

   <table width="100%" border="0">
  <tr>
    <td width="25%">Who can see this page?</th>
    <td width="75%">
    	
        
        
        <input type="radio" name="page_access" id="page_access1" value="Everyone" <?php if ($page_access == "Everyone") { echo "checked=\"checked\""; } ?>  />
        <label for="page_access1">Everyone</label>
        
        
        <input type="radio" name="page_access" id="page_access2" value="Registered" <?php if ($page_access == "Registered") { echo "checked=\"checked\""; } ?> />
        <label for="page_access2">Registered</label>
        
        <input type="radio" name="page_access" id="page_access3" value="Other" <?php if ($page_access == "Other") { echo "checked=\"checked\""; } ?> />
        <label for="page_access3">Other</label>
    
    </th>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
    
    
    <select multiple="multiple" name="groups_ids[]" id="groups_ids" >
		<?php
        foreach($groups as $group)
        {
			$checked = "";
			if(in_array($group['id'],$groups_ids_array) )
			{
				$checked = " selected=\"selected\" ";
			}
        ?>
            <option value="<?=$group['id']?>" <?php echo $checked; ?> ><?=$group['group_name']?></option>		

        <?php } ?>
    </select>
    
   
    <br><br>

	<div id="memberDropdown" style="display:none;">
    
    </div>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
        <input type="button" value="Cancel" onClick="parent.$.fancybox.close();" />
        <input type="submit" value="Update" />
    </td>
  </tr>
</table>




    <!--<input type="text" id="page_title" name="page_title" value="<?=$page_title?>" />
    &nbsp; <input type="button" value="Cancel" onClick="parent.$.fancybox.close();" />
    <input type="submit" value="Update" />
    <br />
    <label id="page_title_message" class="messages"></label>-->
    
    
    
            
</form>
</body>
</html>