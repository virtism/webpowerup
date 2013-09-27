            			<?php
						
						if(isset($_SESSION['current_site_info']))
						{
							$site_id = $_SESSION['current_site_info']['site_id'];
							$site_name = $_SESSION['current_site_info']['site_name'];
						}					
/*					echo "<pre>";	
					print_r($_SESSION);*/
					
			if(!isset($mode))

			{

				$mode = '';    

			}

			if($mode == 'edit')

			{

				$strLink = 'javascript: void(0);';     

			}

			else

			{

				 $strLink = base_url().index_page().'site_preview/site/'.$site_id;   

			}

			?>

			<a href="<?=$strLink?>">

				<h1 id="logo">

					<span class="orange"><?=$site_name?></span>

				</h1>

			</a>

			<h2 id="slogan">put your site slogan here...</h2>

			

			<form method="post" class="searchform" action="#">

				<p>

					<input type="text" name="search_query" class="textbox" />

					<input type="submit" name="search" class="button" value="Search" />

				</p>

			</form>