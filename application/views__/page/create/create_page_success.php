<style>
h1{
	color:#4F8A10;
}
</style>
<div class="RightColumnHeading">
    <h1>
        <span>Create a New Page </span>
    </h1>
</div>

<div class="form">
<div class="InnerMain" style="padding-left:25px;">

	<table width="100%" border="0" cellpadding="0" cellspacing="0">

 <tr>

    <td>

        <h1 style="padding: 0px;">New Page Created Successfully!</h1>

    </td>

 </tr>

 <tr>

    <td>

    <h3>Your New Page details are as under:</h3>



    <h4>URL:</h4>

    

   <?php /*?> <a target="_blank" href="<?=base_url().index_page()?>site_preview/page/<?=$site_id?>/<?=$page_id?>">

    <?=base_url().index_page()?>site_preview/page/<?=$site_id?>/<?=$page_id?>

    </a><?php */?>
	
	 <a target="_blank" href="http://<?=$_SESSION['current_site_info']['site_domain'].".webpowerup.com"?>/site_preview/page/<?=$site_id?>/<?=$page_id?>">

    http://<?=$_SESSION['current_site_info']['site_domain'].".webpowerup.com"?>/site_preview/page/<?=$site_id?>/<?=$page_id?>

    </a>

    

    <p>

    To manage pages, <a href="<?=base_url().index_page()?>pagesController/index/<?=$site_id?>/0"><strong>click here</strong></a>

    </p>

    </td>

 </tr>

</table>
</div>
</div>