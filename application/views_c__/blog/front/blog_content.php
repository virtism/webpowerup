<style>



#blogMainDiv{

	width:100%;

	clear:both;

	float:left;

	min-height:200px;

}

	

#blogLeft{

	float:left;

	width:74%;

	padding:10px;

}



#blogRight{

	float:right;

	width:20%;

	padding:10px;

}



#postBlock{

	width:90%;

	clear:both;

	float:left;

	margin:15px 0 0 0;

	padding:10px;

}

	

</style>



<div id="blogMainDiv">





<div id="blogLeft">

	<h1><?=$blog['title'];?></h1>

	 <p><?=$blog['description'];?></p>

     

     <div id="postBlock">

     <?php 

	 foreach ($posts as $post)

	 { ?>

     <div id="post">

         <a href="<?=base_url().index_page()."blog/post/".$post['blog_id']."/".$post['id'];?>">

		 	<?php echo $post['title']; ?>

         </a>

         <p>

		 	<?php 

			

			echo substr($post['description'],0,200); 

			if( strlen($post['description']) > 200 )	{  echo "... <a href=\"".base_url().index_page()."blog/post/".$post['blog_id']."/".$post['id']."\" >Read more</a>"; }  

			

			?>

          </p>

     </div>
	<br />
    <br />
		 

	 <?php 

	 }

	 

	 ?>

     </div>     

     

</div>

<div id="blogRight">

	<?php 
	
	include_once("blogRight.php");
	
	?>

</div>

    

</div>





