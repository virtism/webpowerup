<html>
<head>
<title>Edit Page Title</title>

</head>
<body>
<h2>Page Info(Advanced)</h2>
<form id="frmEditAdvance" method="post" action="<?=base_url().index_page()?>page_editor/updateAdvanceInfo/<?=$site_id?>/<?=$page_id?>" onsubmit="return validate()">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td valign="top"><b>Keywords:</b></td>
            <td>
                <textarea rows="5" cols="30" id="page_keywords" name="page_keywords"><?=$page_keywords?></textarea>
                <br /><br />
            </td>  
        </tr>
        <tr>
            <td valign="top"><b>Description:</b></td>
            <td>
                <textarea rows="5" cols="30" id="page_desc" name="page_desc"><?=$page_desc?></textarea>
                <br /><br />
            </td>  
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input type="button" value="Cancel" onclick="parent.$.fancybox.close();" /> <input type="submit" value="Update" /></td>
        </tr>
    </table>
</form>
</body>
</html>
