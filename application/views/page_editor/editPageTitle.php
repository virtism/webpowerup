<html>
<head>
<title>Edit Page Title</title>
<script type="text/javascript" language="javascript">

function validate()
{
    var page_title = document.getElementById('page_title');
    var page_title_message = document.getElementById('page_title_message');
    if(page_title.value == "")
    {
        page_title_message.innerHTML = '<code style="font-size:11px; color: red">Please enter page title for this page to continue.</code>';
        return false;
    }
    else
    {
        return true;
    }
}
</script>
</head>
<body>
<h2>Page Title</h2>
<form id="frmEditPageTitle" method="post" action="<?=base_url().index_page()?>page_editor/updatePageTitle/<?=$site_id?>/<?=$page_id?>" onsubmit="return validate()">
    <input type="text" id="page_title" name="page_title" value="<?=$page_title?>" />
    &nbsp; <input type="button" value="Cancel" onclick="parent.$.fancybox.close();" />
    <input type="submit" value="Update" />
    <br />
    <label id="page_title_message" class="messages"></label>        
</form>
</body>
</html>
