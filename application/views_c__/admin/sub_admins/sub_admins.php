
<? 
//echo "<pre>";
//print_r($roles);
//exit;?>

<table cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
        <td colspan="2">
            <h1>Sub-Admin Lising</h1>
        </td>
    </tr>
    <tr>
        <td colspan="2">
             <a href="<?=base_url().index_page()?>administrator/packages/addnew">Add New</a> 
        </td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2">
        
        <table cellpadding="0" cellspacing="0" border="1" width="100%">
            <tr>
                <th>Sub-admin Id</th>
                <th>Sub-admin Name</th>
                <th>Sub-admin E-mail</th>
                <th>Sub-admin Status</th>
                <th>Action</th>
            </tr>
            <?php foreach($sub_admins as $sub_admin){?>
            <tr>
                <td><?php echo $sub_admin->user_id;?></td>
                <td><?php echo $sub_admin->user_fname.' '.$sub_admin->user_lname;?></td>
                <td><?php echo $sub_admin->user_email;?></td>
                <td><?php echo $sub_admin->user_status;?></td>
                 <td align="center"><a href="<?=base_url().index_page();?>UsersController/myaccount/<?=$sub_admin->user_id;?>">Edit</a>&nbsp; | &nbsp; <a href="<?=base_url().index_page()?>administrator/packages/deletePackage/">Delete</a></td>
            </tr>
            <?}?>
               
            
        
        </table>
        
        </td>
    </tr>    
</table>     
