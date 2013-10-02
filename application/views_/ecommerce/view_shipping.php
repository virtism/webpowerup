
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
p{
font-weight:bold;
}

tr.odd td{
    background: #F6F6F6 !important;
}
tr.even td{
    background: #F6F6F6 !important;
	text-decoration:none;
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
			form.action = "<?=base_url().index_page()?>Shipping_Management/trashPage/<?=$site_id?>";
			form.submit();	
		}
		return false;
    }
    else{
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

</script>

<div class="RightColumnHeading">
    <h1>
        <span>Shipping Management</span>
    </h1>
    <div class="RightSideButton">
        <a href="javascript: void(0)" onClick="return deletePage()" >
            <img alt="Trash" src="<?=base_url()?>images/webpowerup/Trash.png">
        </a>
        <a href="<?=site_url()?>Shipping_Management/select_country">
            <img alt="New" src="<?=base_url()?>images/webpowerup/New.png">
        </a>
     </div>
</div>

<div class="clr"></div>

<div class="PageDetail">
        
    <p style="font-weight:normal;">
    To <strong>create a shipping rate</strong>,Click the New button(top right).<br />
    </p>

</div>
 
<div class="InnerMain" >
	<div>
    
	<?php 
	if ( isset($country_states_ship) )
	{
		if( count($country_states_ship) > 0 )
		{ 
			foreach($country_states_ship as $countries => $country)
			{
				
				//echo "<pre>";echo $countries;print_r($country);echo $country[0]['state'];
		?>
        <table border="0" width="70%" align="center" style="border:solid 1px #DEDEDE; margin:10px 0 15px 10px;">
				<?php
				//echo "<pre>";print_r($country_states_ship);exit;
				
                for($i = 0; $i < count($country); $i++)
                {
					
					if(isset($country[$i]['state_ranges']) && !empty($country[$i]['state_ranges']))
					{
                ?>
                
                        <tr >
                         <th style="background:#DCDCDC; line-height:25px; height:25px; font-weight:bold;" colspan="4" align="center"><? echo $countries."-".$country[$i]['state']; ?></th> 
                        </tr>
                        <tr>
                         <td><strong>Name</strong></td>
                         <td><strong>Range</strong></td>
                         <td><strong>Price</strong></td>
                         <td><strong>Action</strong></td>
                        </tr>	 
                <?
				//echo "<pre>";print_r($country_states_ship[$i]);
				
						for($j = 0; $j < count($country[$i]['state_ranges']); $j++)
						{
						?>
						<tr <? if ($j%2 == 0) {?> class="even" <? } ?>>
                          <td><? echo $country[$i]['state_ranges'][$j]['shipping_rate_name'];?></td>
						  <td><? echo $country[$i]['state_ranges'][$j]['min_range']."-".$country[$i]['state_ranges'][$j]['max_range']." kg";?></td>
						  <td><? echo $country[$i]['state_ranges'][$j]['rate'];?></td>
						  <td><a href="<?=base_url()."Shipping_Management/delete_range/".$country[$i]['state_ranges'][$j]['range_id']?>" title="Delete Range">Delete</a></td>
						</tr>
						<?  }?>
						<br clear="all">
				<? 		
						}
					}
				?>
			</table>
    <?php 
	}//foreach
	}//if
	}//if ?>
    </div>
</div>