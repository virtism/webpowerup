<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1"/>
<meta name="description" content="description"/>
<meta name="keywords" content="keywords"/> 
<meta name="author" content="author"/> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/hobbit/default.css" media="screen"/>
<title>The Hobbit</title>
</head>

<body>

<div class="container">

    <div class="gfx"><span></span></div>

    <div class="top">

         <?php $this->load->view('hobbit/menu'); ?>
         
         <div class="pattern"><span></span></div>
         
           <div class="header">
            
        
           <?php $this->load->view('hobbit/header'); ?> 
           </div> 

        <div class="pattern"><span></span></div>
         

    </div>

   <div class="content">

        <div class="spacer"></div>

 <!--        <div class="item">

            <div class="title">Porttitor posuere</div>
            <div class="metadata">Jun 13, 2006 by Vulputate</div>
            
            <div class="body">

                <p>In hac habitasse platea dictumst. Duis porttitor. Sed vulputate elementum nisl. Vivamus et mi at arcu mattis iaculis. Nullam posuere tristique tortor. Aenean ornare, <a href="index.html">nunc eget pretium</a> porttitor, sem est pretium leo.</p>

                <img class="left" src="img/map.jpg" width="180" height="152" alt="sample image"/>

                <p>Aliquam risus justo, mollis in, laoreet a, consectetuer nec, risus. Nunc blandit sodales lacus. Nam luctus semper mi. In eu diam. Aliquam risus justo, mollis in, laoreet a, consectetuer nec, risus. Nunc blandit sodales lacus. Nam luctus semper mi. In eu diam. Aliquam risus justo, mollis in, laoreet a, consectetuer nec, risus. Nunc blandit sodales lacus. Nam luctus semper mi. In eu diam.</p>

                <p>Fusce porta pede nec eros. Maecenas ipsum sem, interdum non, aliquam vitae, interdum nec, metus. Maecenas ornare lobortis risus. Etiam placerat varius mauris. Maecenas viverra. Sed feugiat. Donec mattis <a href="index.html">quam aliquam</a> risus. Nulla non felis sollicitudin urna blandit egestas. Integer et libero varius pede tristique ultricies. Cras nisl. Proin quis massa semper felis euismod ultricies.
                </p>

            </div>

        </div>

        <div class="divider"><span></span></div>-->

   

        <div class="item">

            

            <div class="body">
                
                <?= $content ?>
               
            </div>

        </div>

    </div>
        
    <div class="footer">

        <?php $this->load->view('hobbit/footer'); ?> 
          

    </div>

</div>

</body>

</html>