<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Video Gallery View</title>
<script type="text/javascript" src="<?=base_url()?>js/flowplayer/flowplayer-3.2.8.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>js/flowplayer/style.css">
<style>
	.video-ul
	{
		list-style:none;
	}
	#video-li
	{
		display:block;
		list-style:none;
		float:left;
		width:300px;
		padding-left:5px;
		text-align:left;
	}
</style>
</head>
<body>
	<h1 style="float:left; padding-left:40px; color:#000000; ">Gallery Videos</h1><br /><br />
	<? //echo '<pre>';print_r($rows); 
	if(!empty($rows))
	{
		echo "<ul class='video-ul'>";	
		$image_path = base_url()."media/uploads/";
		for($i=0; $i<count($rows); $i++)
		{
	?>
		<li id="video-li">
			<a  href="<?=$image_path.$rows[$i]['gallery_image']?>"	 style="display:block;width:300px;height:220px" class="player"> </a> 
			<script>
			flowplayer("a.player", "<?=base_url()?>js/flowplayer/flowplayer-3.2.9.swf", {
			clip: {   autoPlay:false } 
		   
			});	
			</script>
			<b>Title</b>: <?=$rows[$i]['gallery_title']?>
			<br  clear="all" />		
			<b>Description</b>: <?=$rows[$i]['gallery_description']?>
			<br style="padding-top:5px;" clear="all" />
		</li>	
	<? }
		echo "</ul>";
	 }
	 ?>
</body>
</html>