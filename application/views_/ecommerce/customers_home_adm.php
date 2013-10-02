<?php
/*    $attributes = array('class' => 'contact', 'id' => 'customer_search' ,  'name' => 'customer_search',  'onsubmit'=>'javascript: return checkRegFormFields(this);' );
    echo form_open(base_url().index_page().'customers',$attributes);
    echo form_hidden('action','search');
    
    $search_value = array('name'=>'search_value','id'=>'search_value','size'=>'85' , 'maxlength' => '64', 'value' => set_value('search_value','')); 
    $sort_by = array('' => 'Select One' ,'customer_fname' => 'First Name' , 'customer_lname'=>'Last Name', 'customer_email'=>'Mail ID', 'group_code'=>'Gruop Code');
*/?> 
<script type="text/javascript">
function deleteForm()
{
  var msg = confirm("Are you sure you want to Delete?");
  if(msg)
	 return true;
  else
     return false;
	
}
</script>
<style type="text/css">
tr.odd td{
    background: #F6F6F6 !important;
}
tr.even td{
    background: #FFFFFF !important;
	text-decoration:none;
}
form{
background:none!important;
border:none!important;
}
.alert-success
{
	text-align:center;
	border:#CCCCCC;
	color:#009900;
	font-size:14px;
	font-weight:bold;
	margin: 5px;
	
}
</style>

<div class="RightColumnHeading">
    <h1>
        <img src="<?=base_url();?>images/webpowerup/Invoice.png" alt="Manage Customers"/>
        <span>Manage Customers</span>
    </h1>
    
    <div class="RightSideButton">
        <a href="<?=base_url().index_page();?>customers/customer_registration">
            <img src="<?=base_url();?>images/webpowerup/createNewCustomer.png" alt="Rooms Management"/>
        </a>
    </div>
    
</div> 

<div class="form">

    <div class="DoubleColumn">
        <span style="padding:0 0 0 10px;" ></span>
        <form class="niceform" id="" name="" method="post" action="<?=site_url();?>customers">
        <input type="hidden" name="action" value="search" />
        <div class="ColumnA">
        
            <ul>
            <li> 
                <div style=" float:left; width:100%; position:relative;">
                <select size="1" style="width:300px" id="page_id_home" name="page_id_home" onChange="this.form.submit()" >  
                    <option value="">Select One</option>
                    <option value="customer_fname">First Name</option>
                    <option value="customer_lname">Last Name</option>
                    <option value="customer_email">Mail ID</option>
                    <option value="group_code">Gruop Code</option>
                </select>
                </div>
                
             </li>
            </ul>
        </div>
        
        <div class="ColumnB">
            <ul>
            <li>
             <input type="text" id="search_value" name="search_value"  value="" size="35" />
             </li>
            </ul>
        </div>
        
        <div class="ButtonRow">
                
        <button type="submit" class="SearchButton">
            <img src="<?=base_url()?>images/webpowerup/SearchGreen.png" alt="SearchGreen"/>
        </button>
        
        </div>
        </form>
     
    </div>

</div>
<?
	if($this->session->flashdata('message'))
	{
		$message = $this->session->flashdata('message');
		?>
		<div class="alert-success"><?php echo $message; ?> </div>
		<?
	}

?>

<?php
	$register_counter = 1;
  	$group_user_counter = 1;
	$search_user_counter = 1;
  
if (isset($search_result) && count($search_result)>0)
{
  ?>
  	<div class="RightColumnHeading">
        <h1>
            <img src="<?=base_url();?>images/webpowerup/5.png" alt="Group User"/>
            <span>Search Result</span>
        </h1>
	</div>

  <div class="DataGrid2">
    <ul class="TableHeader">
        <li>Customer ID</li>
        <li>First Name</li>
        <li style="width:20px;">Last Name</li>
        <li>Email</li>
       <!-- <li>Membership ID</li>-->
        <li>Group</li>
        <li class="Actions">Actions</li>
    </ul>
  <?
  
  //echo "<pre>";print_r($search_result);exit;
  
    foreach ($search_result as $key => $list)
	{
		
        ?>    
            <ul class="TableData">
            <?php /*?><li><?=$list['customer_id'];?></li><?php */?>
            <li><?=$search_user_counter++?></li>
            <li><?=$list['customer_fname'];?></li>
            <li><?=$list['customer_lname'];?></li>
            <li><?=$list['customer_email'];?></li>
           <!-- <li><?=$list['membershipid'];?></li>-->
            <li><? if(isset($list['all_groups']) && !empty($list['all_groups']))
			{
				foreach ($list['all_groups'] as $g_name)
				{
					echo $g_name['group_name']."<br/>";
				}			
			}?></li>
            <li class="Actions">
            
            <a href="<?=site_url()?>customers/edit/<?=$list['customer_id']?>" class="EditAction">
                <img src="<?=base_url();?>images/webpowerup/EditAction.png" alt="button"/>
            </a>
            <a href="<?=site_url()?>customers/delete/<?=$list['customer_id']?>" class="DeleteAction" onclick="return deleteForm()">
                <img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/>
            </a>
			<a title="Start Meeting" href="<?=base_url();?>room_management/start_direct_meeting/<?=$list['customer_id']?>" class="RefreshAction">
                    <img src="<?=base_url();?>images/webpowerup/RefreshAction.png" alt="button"/>
            </a>           
            <br /><br /><br />
            <a href="<?=site_url()?>pagesController/basic_info/<?=$_SESSION['site_id']?>/private/<?=$list['customer_id']?>" >
               Create private page 
            </a> |
             <a href="<?=site_url()?>customers/group/<?=$list['customer_id']?>" >
              	Assign Group 
            </a> 
            <?php
			for($i = 0; $i < sizeof($private_page); $i++)
			{
			   if(isset($private_page[$i][0]['page_users']) && $list['customer_id'] == $private_page[$i][0]['page_users'])			{
				  $page_id = $private_page[$i][0]['page_id'];
				}
			}
			
			if(isset($page_id) && $page_id != '')
			{ ?>
              <a href="<?=site_url()?>page_editor/index/<?=$_SESSION['site_id']?>/<?=$page_id?>" >
              	Manage Private Page 
              </a>
			<?php 
			} ?>
            </li>
            </ul>
        <?php
		 
	}
	
} 
else if(isset($search_param))
{ ?>
	<ul class="TableData">
        <li>
        <span class="NoData">
        Sorry! No Customer Record Found.
        </span>
        </li>
    </ul>
<?php
} 
?>
<div class="RightColumnHeading">
    <h1>
        <img src="<?=base_url();?>images/webpowerup/5.png" alt="Group User"/>
        <span>Group User</span>
    </h1>
</div>

<div class="DataGrid2">
    <ul class="TableHeader">
        <li>Customer ID</li>
        <li>First Name</li>
        <li style="width:20px;">Last Name</li>
        <li>Email</li>
       <!-- <li>Membership ID</li>-->
        <li>Group</li>
        <li class="Actions">Actions</li>
    </ul>
<?

if (isset($customers) && count($customers))
{
	foreach ($customers as $key => $list)
	{
        if($list['group_id'] != '')
	    { ?>    
            <ul class="TableData">
            <li><?=$group_user_counter++?></li>
            <li><?=$list['customer_fname'];?></li>
            <li style="width:20px;"><?=$list['customer_lname'];?></li>
            <li><?=$list['customer_email'];?></li>
       		<!--<li><?=$list['membershipid'];?></li>-->
            <li>
			<? if(isset($list['all_groups']) && !empty($list['all_groups']))
			{
				foreach ($list['all_groups'] as $g_name)
				{
					echo $g_name['group_name']."<br/>";
				}			
			}?>
            </li>
            <li class="Actions">
            <a href="<?=site_url()?>customers/edit/<?=$list['customer_id']?>" class="EditAction">
                <img src="<?=base_url();?>images/webpowerup/EditAction.png" alt="button"/>
            </a>
            <a href="<?=site_url()?>customers/delete/<?=$list['customer_id']?>" class="DeleteAction" onclick="return deleteForm()">
                <img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/>
            </a>
            <a title="Start Meeting" href="<?=base_url();?>room_management/start_direct_meeting/<?=$list['customer_id']?>" class="RefreshAction">
                    <img src="<?=base_url();?>images/webpowerup/RefreshAction.png" alt="button"/>
            </a>  
            <br />
            <a href="<?=site_url()?>pagesController/basic_info/<?=$_SESSION['site_id']?>/private/<?=$list['customer_id']?>" >
               Create private page 
            </a> |  <a href="<?=site_url()?>customers/group/<?=$list['customer_id']?>" >
              	Assign Group 
            </a>
            <?php
			$page_id = 0;
			$private_page_user = 0;
			for($i = 0; $i < sizeof($private_page); $i++)
			{
			   if(isset($private_page[$i][0]['page_users']) && $list['customer_id'] == $private_page[$i][0]['page_users'])			
			   {
				  $page_id = $private_page[$i][0]['page_id'];
				  $private_page_user = $private_page[$i][0]['page_users'];
				}
			}
			
			if(isset($page_id) && $page_id != '')
			{ ?>
               <a href="<?=site_url()?>pagesController/private_pages/<?=$_SESSION['site_id']?>/<?=$page_id?>/<?=$private_page_user?>">
              	Manage Private Page 
              </a>
			<?php 
			} ?>
            </li>
            </ul>
        <?php
		} 
	}
	
} 

else if(isset($search_param))
{ ?>
	<ul class="TableData">
        <li>
        <span class="NoData">
        Sorry! No Customer Record Found.
        </span>
        </li>
    </ul>
<?php
} 
?>
</div>

<div class="RightColumnHeading">
    <h1>
        <img src="<?=base_url();?>images/webpowerup/Product.png" alt="Registered User"/>
        <span>Registered User</span>
    </h1>
</div>

<div class="DataGrid2">
    
    <ul class="TableHeader">
        <li>Customer ID</li>
        <li>First Name</li>
        <li>Last Name</li>
        <li>Email</li>
        <!--<li>Group</li>-->
        <li class="Actions">Actions</li>
    </ul>
    
    <?php  
if (isset($customers) && count($customers))
{	  
      foreach ($customers as $key => $list)
	{
        if($list['group_id'] == '')
	    { ?>    
            <ul class="TableData">
            <?php /*?><li><?=$list['customer_id'];?></li><?php */?>
            <li><?=$register_counter++?></li>
            <li><?=$list['customer_fname'];?></li>
            <li><?=$list['customer_lname'];?></li>
            <li><?=$list['customer_email'];?></li>
            <?php /*?><li><? if(isset($list['all_groups']))
			{
				foreach ($list['all_groups'] as $g_name)
				{
					echo $g_name['group_name']."<br/>";
				}			
			}?></li><?php */?>
            <li class="Actions">
            <a  href="<?=site_url()?>customers/edit/<?=$list['customer_id']?>" class="EditAction">
                <img src="<?=base_url();?>images/webpowerup/EditAction.png" alt="button"/>
            </a>
            <a href="<?=site_url()?>customers/delete/<?=$list['customer_id']?>" onclick="return deleteForm()" target="_blank" class="DeleteAction">
                <img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/>
            </a>
			<a  title="Start Meeting" href="<?=base_url();?>room_management/start_direct_meeting/<?=$list['customer_id']?>" class="RefreshAction">
                    <img src="<?=base_url();?>images/webpowerup/RefreshAction.png" alt="button"/>
            </a>  
			
            <a href="<?=site_url()?>customers/group/<?=$list['customer_id']?>" >
              	Assign Group 
            </a>
			
            
            <br />
            <a href="<?=site_url()?>pagesController/basic_info/<?=$_SESSION['site_id']?>/private/<?=$list['customer_id']?>" >
               Create private page 
            </a> | 
            <?php
			$page_id = 0;
			$private_page_user = 0;
			for($i = 0; $i < sizeof($private_page); $i++)
			{
			   if(isset($private_page[$i][0]['page_users']) && $list['customer_id'] == $private_page[$i][0]['page_users'])			
			   {
				  $page_id = $private_page[$i][0]['page_id'];
				  $private_page_user = $private_page[$i][0]['page_users'];
				}
			}
			
			if(isset($page_id) && $page_id != '')
			{ ?>
               <a href="<?=site_url()?>pagesController/private_pages/<?=$_SESSION['site_id']?>/<?=$page_id?>/<?=$private_page_user?>">
              	Manage Private Page 
              </a>
			<?php 
			} ?>
            
            </li>
            </ul>
        <?php
		} 
	}
} 

else if(isset($search_param))
{ ?>
	<ul class="TableData">
        <li>
        <span class="NoData">
        Sorry! No Customer Record Found.
        </span>
        </li>
    </ul>
<?php
} 
?>
</div>