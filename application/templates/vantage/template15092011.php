<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>  
<?=$_scripts?>

<?php
if(!isset($page_desc))
{
    $page_desc = "";    
}
?>
<meta name="Description" content="<?=$page_desc?>" />
<?php
if(!isset($page_keywords))
{
    $page_keywords = "";    
}
?>
<meta name="Keywords" content="<?=$page_keywords?>" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="Distribution" content="Global" />
<meta name="Author" content="Erwin Aligam - ealigam@gmail.com" />
<meta name="Robots" content="index,follow" />

<link rel="stylesheet" href="<?=base_url(); ?>css/vantage/images/Orange.css" type="text/css" />    

<title><?=$title?></title>

<script type="text/javascript">
$(document).ready(function() {
    $('.slideshow').cycle({
        fx: 'fade' // choose your transition type, ex: fade, scrollUp, shuffle, etc...
    });
});
</script>
    
</head>

<body>
<!-- wrap starts here -->
<div id="wrap"> 

    <div id="header">    
            
                   <?php  $this->load->view('vantage/logo');  ?>
        
    </div>        
        
    <div id="menu">
        <ul>
                  <?php // $this->load->view('all_common/menu',$menu);
                    // print_r(); exit();

                  
                  ?>
                  <?=$menu?> 
                  <? //=$other_top_navigation?>

        </ul>
    </div>
    
    <!-- content-wrap starts here -->    
    <div id="content-wrap"> 
            
            <?=$header?> 
            
            <?php
            if(!isset($background_image))
            {
                $background_image = '';    
            }
            $strStyle = "";
            if($background_image!="" && $background_area=='page' && $background_style=='stretch')
            {
                $strStyle = "background-image:url('".$background_image."'); background-size: 100%; background-repeat: no-repeat";    
            }
            else if($background_image!="" && $background_area=='page' && $background_style=='tile')
            {
                $strStyle = "background-image:url('".$background_image."'); background-repeat:repeat;";
            }
            ?>   
            <table border="0" width="100%" cellpadding="0" cellspacing="0" style="<?=$strStyle?>">
            <tr><td>
            
            <div id="sidebar">
                <?= $leftbar?>
                <!--            
                <h1>Sidebar Menu</h1>
                <ul class="sidemenu">
                    <li><a href="index.html">Home</a></li>
                    <li><a href="#TemplateInfo">Template Info</a></li>
                    <li><a href="#SampleTags">Sample Tags</a></li>
                    <li><a href="http://www.styleshout.com/">More Free Templates</a></li>
                    <li><a href="http://www.4templates.com/?aff=ealigam">Premium Templates</a></li>                    
                </ul>                
                        
                <h1>Themes</h1>                
                <ul class="sidemenu">
                    <li><a href="index.html">Orange</a></li>
                    <li><a href="Green.html">Green</a></li>
                    <li><a href="Blue.html">Blue</a></li>                    
              </ul>
                
                <h1>Site Partners</h1>                
                <ul class="sidemenu">
                    <li><a href="http://partners.ipower.com/z/57/CD5822/">IPowerweb</a></li>
                    <li><a href="http://www.4templates.com/?aff=ealigam">4templates</a></li>
                    <li><a href="http://www.fotolia.com/partner/114283">Fotolia.com</a></li>                        
                    <li><a href="http://www.bigstockphoto.com/?refid=grKPpdNw6k">BigStockPhoto.com</a></li>                
                    <li><a href="http://www.text-link-ads.com/?ref=40025">Text Link Ads</a></li>           
                </ul>
                
                <h1>Wise Words</h1>
                <p>&quot;Keep away from people who try to belittle your ambitions. Small people
                always do that, but the really great make you feel that you, too, can
                become great.&quot;</p>    
                
                <p class="align-right">- Mark Twain</p>-->        
                
            </div>        
    
                <?php
                $strStyle = "";
                if($background_image!="" && $background_area=='content' && $background_style=='stretch')
                {
                    $strStyle = "background-image:url('".$background_image."'); background-size: 100%; background-repeat: no-repeat";    
                }
                else if($background_image!="" && $background_area=='content' && $background_style=='tile')
                {
                    $strStyle = "background-image:url('".$background_image."'); background-repeat:repeat;";
                }
                ?>  
                <div id="main" style="<?=$strStyle?>"> 
                
                <h1><?=$title?></h1>
        
                <?=$content?>
                <!--                
                <a name="TemplateInfo"></a>
                <h1>Template Info</h1>
                
                <p><strong>Stylevantage</strong> is a free, W3C-compliant, CSS-based website template 
                by <strong><a href="http://www.styleshout.com/">styleshout.com</a></strong>. This work is 
                distributed under the <a rel="license" href="http://creativecommons.org/licenses/by/2.5/">
                Creative Commons Attribution 2.5  License</a>, which means that you are free to 
                use and modify it for any purpose. All I ask is that you include a link back to  
                <a href="http://www.styleshout.com/">my website</a> in your credits.</p>  

                <p>For more free designs, you can visit 
                <a href="http://www.styleshout.com/">my website</a> to see 
                my other works.</p>
        
                <p>Good luck and I hope you find my free templates useful!</p>
                
                <p class="post-footer align-right">                    
                    <a href="index.html" class="readmore">Read more</a>
                    <a href="index.html" class="comments">Comments (7)</a>
                    <span class="date">Sep 15, 2006</span>    
                </p>
                
                <a name="SampleTags"></a>                
                <h1>Sample Tags</h1>
                
                <h3>Code</h3>                
                <p><code>
                code-sample { <br />
                font-weight: bold;<br />
                font-style: italic;<br />                
                }
                </code></p>    
                
                <h3>Example Lists</h3>
                
                <ol>
                    <li><span>example of ordered list</span></li>
                    <li><span>uses span to color the numbers</span></li>                            
                </ol>    
                            
                <ul>                    
                    <li><span>example of unordered list</span></li>
                    <li><span>uses span to color the bullets</span></li>                                
                </ul>                
                
                <h3>Blockquote</h3>            
                <blockquote><p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy 
                nibh euismod tincidunt ut laoreet dolore magna aliquam erat....</p></blockquote>
                
                <h3>Image and text</h3>
                <p><a href="http://getfirefox.com/"><img src="images/firefox-gray.jpg" width="100" height="120" alt="firefox" class="float-left" /></a>
                Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec libero. Suspendisse bibendum. 
                Cras id urna. Morbi tincidunt, orci ac convallis aliquam, lectus turpis varius lorem, eu 
                posuere nunc justo tempus leo. Donec mattis, purus nec placerat bibendum, dui pede condimentum 
                odio, ac blandit ante orci ut diam. Cras fringilla magna. Phasellus suscipit, leo a pharetra 
                condimentum, lorem tellus eleifend magna, eget fringilla velit magna id neque. Curabitur vel urna. 
                In tristique orci porttitor ipsum. Aliquam ornare diam iaculis nibh. Proin luctus, velit pulvinar 
                ullamcorper nonummy, mauris enim eleifend urna, congue egestas elit lectus eu est.                 
                </p>
                                
                <h3>Example Form</h3>
                <form action="#">    
                    <p>                    
                    <label>Name</label>
                    <input name="dname" value="Your Name" type="text" size="30" />
                    <label>Email</label>
                    <input name="demail" value="Your Email" type="text" size="30" />
                    <label>Your Comments</label>
                    <textarea rows="5" cols="5"></textarea>
                    <br />    
                    <input class="button" type="submit" />    
                    </p>            
                </form>                
                <br />       
                -->     
                                
              </div>     
            
            <div id="sidebar">
                <?=$rightbar?>
            <!--                
                <h1>More Text</h1>
                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec libero. Suspendisse bibendum. 
                Cras id urna. Morbi tincidunt, orci ac convallis aliquam, lectus turpis varius lorem, eu 
                posuere nunc justo tempus leo. Donec mattis, purus nec placerat bibendum, dui pede condimentum 
                odio, ac blandit ante orci ut diam. Cras fringilla magna.</p>
                
                <h1>Support Styleshout</h1>
                <p>If you are interested in supporting my work and would like to contribute, you are
                welcome to make a small donation through the 
                <a href="http://www.styleshout.com/">donate link</a> on my website - it will 
                be a great help and will surely be appreciated.</p>   
            -->   
            </div>          
    
            </td></tr>
            </table>
    <!-- content-wrap ends here -->    
    </div>
    
<!-- wrap ends here -->
</div>        

<!-- footer starts here -->        
        <div id="footer">
                 <?php  $this->load->view('vantage/footer');  ?>    
        </div>    
<!-- footer ends here -->    

</body>
</html>