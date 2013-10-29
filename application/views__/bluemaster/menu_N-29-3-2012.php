<?
	for($i=0; $i<count($menu); $i++)
	{
?>
<li ><a href="<?=base_url().index_page()?>site_preview/page/<?=$menu[$i]["site_id"]?>/<?=$menu[$i]["page_id"]?>"><?=$menu[$i]["page_title"]?></a></li>
 
<? 
	}
?>


