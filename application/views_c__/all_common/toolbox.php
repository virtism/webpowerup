<style type="text/css">

table#toolbar tr td ul#main

{

list-style-type:none;

margin:0;

padding:0;

}

table#toolbar tr td ul#main li

{

display:inline;

}

</style>

<?

	if(isset($is_page_edit) && $is_page_edit == "1")

	{

		$this->load->view("all_common/drag_drop_script");

	}

?>

<div id="toolbar" style="height: auto;">

<table id="toolbar" width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:15px; border:1px dotted #CCCCCC">

	<tr id="templates">

		<!--

		<td valign="top">

			<?php

			if($templates->num_rows()>0)

			{

			?>

				<ul style="list-style: none;"> 

				<?php foreach($templates->result_array() as $rowTemplate)

				{

				?>

					<li><a href="<?=base_url().index_page()?>page_editor/tmp_set_site_template/<?=$site_id?>/<?=$page_id?>/<?=$rowTemplate['temp_id']?>/<?=$rowTemplate['temp_name']?>"><?=$rowTemplate['temp_name']?></a></li>

				<?php

				}

				?>   

				</ul>  

			<?php

			}

			else

			{

				echo "<p>No templates found.</p>";

			}

			?>

			<form id="frmTemplate" action="<?=base_url().index_page()?>page_editor/set_site_template/<?=$site_id?>/<?=$page_id?>" method="">

				<input type="submit" value="Apply Template" />

			</form>

			<a class="edit_advance" href="<?=base_url().index_page()?>page_editor/editBackgroundInfo/<?=$site_id?>/<?=$page_id?>">Page Background</a>

			<br />

			<a class="edit_advance" href="<?=base_url().index_page()?>page_editor/editHeaderInfo/<?=$site_id?>/<?=$page_id?>">Page Header</a>

			<br />

			<a class="edit_advance" href="<?=base_url().index_page()?>page_editor/editAdvanceInfo/<?=$site_id?>/<?=$page_id?>">Advanced</a>

		</td>

		-->

		<td>

			<div id="item_container" style="width: auto;">

				<div class="item" id="para">

					  <label class="title">Content</label>

					  <label class="price"></label>

				  </div>

				  

				  <div class="item" id="image">

					  <label class="title">Image</label>

					  <label class="price"></label>

				  </div>

				  

				  <div class="item" id="image_content">

					  <label class="title">Image and Content</label>

					  <label class="price"></label>

				  </div>

				<div class="item" id="video">

					  <label class="title">Add Video</label>

					  <label class="price"></label>

				  </div>
				<!--  Start Document Upload 8 March, 2012 -->
				 <div class="item" id="menu_doc">
					  <label class="title">Upload Document</label>
					  <label class="price"></label>
				  </div>  
				<!--  End Document Upload 8 March, 2012 -->
				<div class="tools" id="bkground">

					<label class="title">

						<a class="edit_background" href="<?=base_url().index_page()?>page_editor/editBackgroundInfo/<?=$site_id?>/<?=$page_id?>">Background</a>

					</label>

				</div>

				

				<div class="tools" id="hdr">

					<label class="title">

						<a class="edit_header" href="<?=base_url().index_page()?>page_editor/editHeaderInfo/<?=$site_id?>/<?=$page_id?>">Header</a>

					</label>

				</div>

				

				<div class="tools" id="seo">

					<label class="title">

						<a class="edit_advance" href="<?=base_url().index_page()?>page_editor/editAdvanceInfo/<?=$site_id?>/<?=$page_id?>">SEO</a>

					</label>

				</div>

				

				<div class="tools" id="seo">

					<label class="title">

						<a class="edit_slider" href="<?=base_url().index_page()?>page_editor/createSlider/<?=$site_id?>">Slideshow</a>

					</label>

				</div>

				<div class="tools" id="menu_temp">

					<label class="title">

						<a  class="edit_slider" href="<?=base_url().index_page()?>menusController/createNewMenu/<?=$site_id?>" target="_blank">New Menu</a>

					</label>

				</div>
                
                
                <div class="tools" id="page_privacy">

					<label class="title">

						<a  class="edit_slider" href="<?=base_url().index_page()?>page_editor/editPagePrivacy/<?=$site_id?>/<?=$page_id?>" target="_blank">Page Privacy</a>

					</label>

				</div>

				<div class="clear"></div> 

			</div>

		</td>

	</tr>

</table>

</div>

