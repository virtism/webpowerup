
<? 
//echo "<pre>";
//print_r($roles);
//exit;?>

<table cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
        <td colspan="2">
            <h1>Affiliate Lising</h1>
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
                <th>Date</th>
                <th>Company</th>
                <th>Emial/Username</th>
                <th>Phone</th>
                <th>Affiliater</th>
                <th>Status</th> 
                <th>Action</th>
            </tr>
            <?php foreach($sub_admins as $sub_admin){?>
            <tr>
                <td><?php echo $sub_admin->user_trail_start_date;?></td>
                <td><?php echo $sub_admin->company;?></td>
                <td><?php echo $sub_admin->user_email;?></td>
                <td><?php echo $sub_admin->pnumber;?></td>
                <td>
                <?php
                 $affiliat = $this->UsersModel->get_user_details_by_user_id($sub_admin->affiliate_id);
                 print_r($affiliat['0']['user_fname']);
                ?></td>
                <td><?php echo $sub_admin->user_status;?></td>
                 <td align="center"><a href="<?=base_url().index_page();?>UsersController/myaccount/<?=$sub_admin->user_id;?>">Edit</a>&nbsp; | &nbsp; <a href="<?=base_url().index_page()?>administrator/packages/deletePackage/">Delete</a></td>
            </tr>
            <?}?>
               
            
        
        </table>
        
        </td>
    </tr>    
</table>     
