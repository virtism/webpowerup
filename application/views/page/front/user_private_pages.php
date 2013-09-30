<h2>Private Pages</h2>

<?php

if ( $private_pages ) 
{ ?>


<table width="100%" border="1">
  <tr>
    <th scope="col" width="25px">&nbsp;</th>
    <th scope="col" align="left">Page Title</th>
  </tr>
  <?php
  $i = 1;
  foreach( $private_pages as $row) 
  { ?>
  <tr>
    <td><?=$i?></td>
	
	<? if($this->config->item('seo_url') == 'On'){?>
	
    <td><a href="<?='http://'.$_SERVER['HTTP_HOST'].'/'.'pages/'.$row['page_seo_url'].$this->config->item('custom_url_suffix');?>"><?=$row['page_title'];?></a></td>
	<? } 
	else
	{ 
	?>
	<td><a href="<?=site_url()?>site_preview/page/<?=$row['site_id'];?>/<?=$row['page_id'];?>"><?=$row['page_title'];?></a></td>
	<? } ?>
	
  </tr>
  <?php
  $i++;
  } ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<?php
}
else
{ 
	echo "<div> No record found! </div>";
}
?>