<div class="RightColumnHeading">
    <h1>
        <span>Footer Management</span>
    </h1>
</div>
<div class="clr"></div>

<script>
 $(document).ready(function () {
      element = document.getElementById('content');
    editor = CKEDITOR.replace( element, { customConfig : '<?=base_url()?>/ckeditor/config.js' } );
});
</script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>ckeditor/ckeditor.js"></script>
<? 

	if(isset($status) && $status=='ok')
	{
	?>
    <p style="color:#009900; margin:20px 0px 5px 275px;"><b> Data Saved Successfully! </b></p>
    <?
	}
?>
<div class="InnerMain" >
<form action="<?=site_url()?>FooterController/update_footer/<?=$site_id?>" method="post"  enctype="multipart/form-data" >

<textarea name="content" id="content"><?php if(isset($content)&&!empty($content)){ echo stripslashes($content); }?></textarea>

<br />
<div class="btnBlue">
<img class="BtnLeft" src="../../../images/webpowerup/img/0.png">
<input class="BtnMid" type="submit" name="save_footer" value="Save Footer"/>
<img class="BtnRight" src="../../../images/webpowerup/img/0.png">
</div>

</form>
</div>