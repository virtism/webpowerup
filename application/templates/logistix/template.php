<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Logistix</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="<?php echo base_url(); ?>css/logistix/default.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="header">
    <?php $this->load->view('logistix/header'); ?> 
</div>
<!-- end #header -->
<div id="menu">
     <?php $this->load->view('logistix/menu'); ?>
 
</div>
<!-- end #menu -->
<div id="content">

<?= $content ?>  


<!--  <div id="posts">
    <div class="post">
      <h2 class="title">Welcome to Logistix!</h2>
      <div class="story">
        <p><strong>Logistix</strong> is a free template from Free CSS Templates released under a <a href="http://creativecommons.org/licenses/by/2.5/">Creative Commons Attribution 2.5 License</a>. The  photo is from PDPhoto.org. You're free to use it for both commercial or personal use. I only ask that you link back to my site in some way. <em><strong>Enjoy :)</strong></em></p>
      </div>
    </div>
    <div class="post">
      <h2 class="title">A Few Examples of Common Tags</h2>
      <div class="story">
        <p><strong></strong>This is an example of a paragraph followed by a blockquote. In posuere eleifend odio. Quisque semper augue mattis wisi. Maecenas ligula. Pellentesque viverra vulputate enim. Aliquam erat volutpat lorem ipsum dolorem.</p>
        <blockquote>
          <p>Pellentesque tristique ante ut risus. Quisque dictum. Integer nisl risus, sagittis convallis, rutrum id, elementum congue, nibh. Suspendisse dictum porta lectus. Donec placerat odio</p>
        </blockquote>
        <h3>Heading Level Three</h3>
        <p>An unordered list example:</p>
        <ul>
          <li>List item number one</li>
          <li>List item number two</li>
          <li>List item number three</li>
        </ul>
        <p>An ordered list example:</p>
        <ol>
          <li>List item number one</li>
          <li>List item number two</li>
          <li>List item number three</li>
        </ol>
      </div>
    </div>
  </div>  -->
  <!-- end #posts -->
<!--  <div id="links">
    <ul>
      <li>
        <h2>News &amp; Updates</h2>
        <ul>
          <li><a href="http://www.free-css.com/">February 2007</a> <i>(22)</i></li>
          <li><a href="http://www.free-css.com/">January 2007</a> <i>(31)</i></li>
          <li><a href="http://www.free-css.com/">December 2006</a> <i>(31)</i></li>
          <li><a href="http://www.free-css.com/">November 2006</a> <i>(30)</i></li>
          <li><a href="http://www.free-css.com/">October 2006</a> <i>(31)</i></li>
        </ul>
      </li>
      <li>
        <h2>Lorem Ipsum Dolor</h2>
        <ul>
          <li><a href="http://www.free-css.com/">Donec Dictum Metus</a></li>
          <li><a href="http://www.free-css.com/">Etiam Rhoncus Volutpat</a></li>
          <li><a href="http://www.free-css.com/">Integer Gravida Nibh</a></li>
          <li><a href="http://www.free-css.com/">Maecenas Luctus Lectus</a></li>
          <li><a href="http://www.free-css.com/">Mauris Vulputate Dolor Nibh</a></li>
          <li><a href="http://www.free-css.com/">Nulla Luctus Eleifend</a></li>
          <li><a href="http://www.free-css.com/">Posuere Augue Sit Nisl</a></li>
        </ul>
      </li>
    </ul>
  </div>  -->
  <!-- end #links -->
  <div style="clear: both;">&nbsp;</div>
</div>

<!-- end #content -->

<div id="footer">

 <?php $this->load->view('logistix/footer'); ?>
  
</div>
<!-- end #footer -->

</body>
</html>
