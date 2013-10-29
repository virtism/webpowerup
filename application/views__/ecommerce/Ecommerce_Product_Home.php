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
        <img src="<?=base_url();?>images/webpowerup/ManageOrders.png" alt="Manage Orders"/>
        <span>Manage Products</span>
    </h1>
    
</div>

<div class="RightColumnHeading">
    <div class="LeftSideButton">
        <a href="<?=site_url();?>Products_Management/create">
            <img src="<?=base_url();?>images/webpowerup/CreateProduct.png" alt="Create Category"/>
        </a>
  </div>
    
    <div class="RightSideButton">
        
        <a href="<?=site_url();?>Products_Management/export">
            <img src="<?=base_url();?>images/webpowerup/Export.png" alt="Export"/>
        </a>
    </div>
</div>

<div class="form">
<form class="niceform">

  			
            <!--<dl>
                <dt><label for="email" class="NewsletterLabel"></label></dt>
                <dd>
                    <div style="float:left; display:inline;width: 300px;">
                        <input type="file" name="csvfile"  />
                    </div>
                    
                    <div style="float:left; display:inline;">
                        <button type="submit" name="importSubmit" class="ImportButton">
                            <img src="<?=base_url();?>images/webpowerup/ImportGreen.png" alt="Import Green"/>
                        </button>
                    </div>
                </dd>
            </dl>-->
            
            
      <?php /*?>      <dl>
                <dt><label for="gender" class="NewsletterLabel">Category :</label></dt>
                <dd>
                    <?php 
					if( count($categories) > 0 )
					{ ?>
                    <div style="float:left; width:100%; position:relative;">
                    <select size="1" name="selectdrop" id=""  style="width:360px"> 
						<?php
						
                        foreach($categories as $key => $val )
                        { ?>
                            <option value="<?=$key?>"><?=$val?></option>
                        <?php
                        } ?>
                    </select>
                    </div>
                    <?php 
					}
					else
					{
						echo "No category exist click <strong><a href=\" ".site_url("Categories_Management/create")." \"> here </a></strong> to add category";
					} ?>
                   
                </dd>
            </dl>
            
             <dl>
                <dt><label for="email" class="NewsletterLabel"> Grouping: </label></dt>
                <dd><input type="text" name="" id="" size="55" /></dd>
            </dl>
            
                                
            <dl>
                <dt><label for="color" class="NewsletterLabel"></label></dt>
                <dd>
                    <div class="ButtonRow">
                        
                        <button type="submit" class="UpdateButton">
                            <img src="<?=base_url();?>images/webpowerup/UpdateGreen.png" alt="Insert Green"/>
                        </button>
                       
                     </div>
                     
                </dd>
            </dl><?php */?>
           
</form>
</div>

<div class="DataGrid2">
        <ul>
            
            <li class="Serial">Product ID </li>
            <li> Name </li>
            <li class="Serial">Product Code </li>
            <li class="Serial">Grouping </li>
            <li class="Serial">Publish </li>
            <li> Category ID </li>
            <li class="Serial">Price </li>
            <li class="Actions">Actions</li>
        </ul>

	<?php
	$counter = 0;
    if (count($products))
    {
		foreach ($products as $key => $list)
		{
		$counter++;
		
	?>            
        <ul >
            <li class="Serial"><?=$counter//$list['product_id']?></li>
            <li><a href="<?=site_url();?>Products_Management/edit/<?=$list['product_id']?>" class="activelink"><?=$list['product']?></a></li>
            <li class="Serial"><?=$list['product_code']?></li>
            <li class="Serial"><?=$list['group']?> </li>
            <li class="Serial"> <a href="<?=site_url();?>Products_Management/changeProductStatus/<?=$list['product_id'];?>" class="activelink"> <?=$list['publish']?></a> </li>
			<? if($list['category_id']!='0'){ ?>
            <li><a href="<?=site_url();?>Categories_Management/edit/<?=$list['category_id']?>" class="activelink"><?=$list['category_id']?></a></li>
			<? } else { ?>
			<li>No Category</li>
			<? } ?>
            <li class="Serial"><?=$list['list_price']?></li>
            <li class="Actions">
                 <a href="<?=site_url();?>Products_Management/edit/<?=$list['product_id']?>" class="EditAction">
                    <img src="<?=base_url();?>images/webpowerup/EditAction.png" alt="button"/>
                </a>
                 <a href="<?=site_url();?>Products_Management/delete/<?=$list['product_id']?>" class="DeleteAction">
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
    
