
<? 
//echo "<pre>";
//print_r($roles);
//exit;?>

<table cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
        <td colspan="2">
            <h1>Package Management</h1>
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
                <th>Sr.No</th>
                <th>Package Name</th>
                <th>Package Description</th>
                <th>Package Price</th>
                <th>Package Status</th>
                <th>Action</th>
            </tr>
                <?
                     //echo "<pre>";
                     //print_r($packages);
                     //exit;
                    for($i = 0; $i<count($packages);$i++) {
                ?>
                <tr>
                    <td><?=$i+1?></td>
                    <td ><?=$packages[$i]["package_name"]?></td>
                    <td><?=$packages[$i]["package_description"]?></td>
                    <td ><?=$packages[$i]["package_fixed_price"]?></td>
                    <td align="center"><?=$packages[$i]["package_status"]?></td>
                    <td align="center"><a href="<?=base_url().index_page()?>administrator/packages/editPackage/<?=$packages[$i]["package_id"]?>">Edit</a>&nbsp; | &nbsp; <a href="<?=base_url().index_page()?>administrator/packages/deletePackage/<?=$packages[$i]["package_id"]?>">Delete</a></td>
                </tr>
                <? } ?>
            
        
        </table>
        
        </td>
    </tr>    
</table>     
