      <div class="col c1">
        <h2><span>Image Gallery</span></h2>
        <a href="#"><img src="<?=base_url(); ?>css/winglobal/images/pix1.jpg" width="58" height="58" alt="" /></a> 
        <a href="#"><img src="<?=base_url(); ?>css/winglobal/images/pix2.jpg" width="58" height="58" alt="" /></a>
        <a href="#"><img src="<?=base_url(); ?>css/winglobal/images/pix3.jpg" width="58" height="58" alt="" /></a>
        <a href="#"><img src="<?=base_url(); ?>css/winglobal/images/pix4.jpg" width="58" height="58" alt="" /></a>
        <a href="#"><img src="<?=base_url(); ?>css/winglobal/images/pix5.jpg" width="58" height="58" alt="" /></a>
        <a href="#"><img src="<?=base_url(); ?>css/winglobal/images/pix6.jpg" width="58" height="58" alt="" /></a>
      </div>          
      <div class="col c2">
        <!--
        <h2><span>Lorem Ipsum</span></h2>
        <p>Lorem ipsum dolor<br />
          Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec libero. Suspendisse bibendum. Cras id urna. <a href="#">Morbi tincidunt, orci ac convallis aliquam</a>, lectus turpis varius lorem, eu posuere nunc justo tempus leo. Donec mattis, purus nec placerat bibendum, dui pede condimentum odio, ac blandit ante orci ut diam.</p>
        -->
        <ul style="list-style: none;">
        <?php
        for($i=0; $i<count($footer_navigation); $i++)
        {
            if($mode == 'edit')
            {
                $link = 'javascript: void(0);';
            }
            else
            {
                $link = base_url().index_page().'site_preview/page/'.$footer_navigation[$i]['site_id'].'/'.$footer_navigation[$i]['page_id'];     
            }
        ?>
            <li><a href="<?=$link?>"><?=$footer_navigation[$i]['page_title']?></a></li>
        <?php        
        }
        ?>
        </ul>
      </div> 
                         
      <div class="col c3">
        <h2><span>Contact</span></h2>
        <p><a href="#">mudassar@virtism.com</a></p>
        <p><a href="#">sahil_bwp@yahoo.com</a></p>
        <p>+92 (334) 6862971<br />
          +92 (312) 6862971</p>
        <p>Address: Virtism </p>
      </div>