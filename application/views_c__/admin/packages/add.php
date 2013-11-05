
<? 
//echo "<pre>";
//print_r($modules);
//print_r($moduleArray);

if(isset($action) && $action == "edit" )
{
    $action = "editPackage";
    $btnCaption = "Update";
    
}
else
{
    $action = "creatNewPackage" ;
    $btnCaption = "Save";
}


//exit;
?>
<form name="user", method="post" action="<?=base_url().index_page()?>administrator/packages/package_management/">
<input type="hidden" name="action" value="<?=$action?>">
<? if(isset($action) && $action == "editPackage" ) {?>
<input type="hidden" name="package_id" value="<?=$packageArray[0]["package_id"]?>">
<? }?>  

<table cellpadding="0" cellspacing="0" border="0" width="100%">
    <? if(isset($errosMsg)){?>
    <tr>
        <td colspan="2"><span style="color: red;"><?echo $errosMsg?></span></td>
    </tr>
    <? }?>
    
    <tr>
        <td colspan="2">
                <h1> New Package </h1>
        </td>
    </tr>
    <tr>
        <td width="150px">
                Package Name  
        </td>
        <td>
                <input type="text" name="package_name" value="<? if(isset($packageArray[0]["package_name"])) echo $packageArray[0]["package_name"];?>">
        </td>
    </tr>
    <tr>
        <td>
                Description  
        </td>
        <td>
                <input type="text" name="package_description" value="<? if(isset($packageArray[0]["package_description"])) echo $packageArray[0]["package_description"]?>">
        </td>
    </tr>
    
    <tr>
        <td>
                Status   
        </td>
        <td>
                <select name="package_status">
                    <option value="Active"> Active </option>
                    <option value="Inactive"> Inactive </option>
                    <option value="Deleted"> Deleted </option>
                </select>
        </td>
    </tr>
    <tr>
        <td>
                Package Price  
        </td>
        <td>
                <input type="text" name="package_price" value="<? if(isset($packageArray[0]["package_fixed_price"])) echo $packageArray[0]["package_fixed_price"]?>">
        </td>
    </tr>
    <tr>
     <td>
            Package Modules
     </td>
     <td>
        <?
            for($i = 0; $i<count($modules); $i++ )
            {
                
                $checked = "";
                if(isset($moduleArray[$i]["module_id"]))
                {
                    if($moduleArray[$i]["module_id"] == $modules[$i]["module_id"])
                    {
                        $checked = 'checked= "checked"';
                    }    
                }
                
        ?>
            <input type="checkbox" name="module_id[]" value="<?=$modules[$i]["module_id"]?>" <?=$checked?>> <?=$modules[$i]["module_name"]?>
        <? }?>
            
     </td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2"><input type="submit" name="submit" value="<?=$btnCaption?>"></td>
    </tr>
    </table>     
</form>
