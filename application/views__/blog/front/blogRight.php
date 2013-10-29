<h1>Blog Posts</h1>

<?php 
	
	if ($blog_years)
	{
		foreach ($blog_years as $year)
		{ ?>
			<a href="<?=base_url().index_page()."blog/index/".$site_id."/".$page_id."/".$blog_id."/".$year['year'];?>">
			<?=$year['year'];?>
			</a>
            <br />
		<?php 
		}
	}
?>