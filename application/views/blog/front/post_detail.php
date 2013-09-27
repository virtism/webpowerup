<script type="text/javascript">



$(document).ready(function(e) {

    /*

	$("#commentReg").submit()

	{

		if( $("#message").val() == "" ) 

		{

			

		}

	}

	$("#commentUnreg").submit()

	{

		

	}

	*/

	$(".reply").click(function() {

		var rplyBox = $(this).parent().parent().parent().children(".replyDiv");

		

		var display = rplyBox.css("display");

		



		if (display == "none")

		{

			$(".replyDiv").hide();

			rplyBox.slideDown();

		}

		else if( display == "block" )

		{

			rplyBox.slideUp();

		}

		return false;

	});

	

});



</script>





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

#blogLeft h1{

	font-size:18px;

}

#blogLeft h2{

	font-size:12px;

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

.replies{

	

	height:auto;

	width:500px;

	float:right;

	clear:both;

}

.replyDiv{

	border:#0DA0E9 solid 1px;

	height:auto;

	width:500px;

	float:right;

	clear:both;

}



#commentForm{

	float:left;

}

.comment{

	float:left;

	clear:left;

	width:550px;

	margin:0 0 15px 0;

}

.comment .commentInfo{

	float:left;

	width:100%;

}

.replyInfo{

	margin:0 0 10px 0;

}

.replies{

	margin:5px 0 5px 0;

}

.by{

	color:#0DA0E9;

}

</style>



<div id="blogMainDiv">

    <div id="blogLeft">

        <h1><?=$post['title'];?></h1>
		<br />
        <h2>

			<?php 

			echo "Posted By: ";

			echo $post['user_fname']." ".$post['user_lname'];

			echo " on ";

			

			$time = strtotime($post['date_created']);

			echo $date = date("l jS",$time);

			echo " of ";

			echo $date = date("F Y",$time);

			?>

        </h2>

        

        <p><?=$post['description'];?></p>

        <br />



        <h1>Comments</h1>

        <div id="postBlock"> 

        

            <?php 

			if($comments)

			{

				// echo "<pre>"; print_r($comments); echo "</pre>";

				foreach ($comments as $comment)

				{	

				 ?>

				<div class="comment">

                    <div class="commentInfo">

                        <p>

                            <?php echo $comment['message']; ?>

                        </p>

                        <p>

                            By: <span class="by"><?php echo $comment['name']; ?></span><a class="reply" href="#" style="float:right">Reply</a>

                        </p>

                    </div>

                    

                    <div class="replyDiv" style="display:none;">

                        <form name="replyForm" id="replyForm" method="post" action="<?=base_url().index_page()?>blog/reply">

                        <input type="hidden" name="post" value="<?=$post['id'];?>">

                        <input type="hidden" name="blog" value="<?=$this->uri->segment(3);?>">

                        <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>" />

                        <?php 

                        if($customer_logged_in == 1)

                        { 

                        ?>

                            <table width="100%" border="0">

                            <tr>

                            <th align="left" valign="top" scope="col">&nbsp;</th>

                            <th align="left" valign="top" scope="col">&nbsp;</th>

                            </tr>

                            <tr>

                            <td align="left" valign="top" style="vertical-align:top;">Your Reply</td>

                            <td align="left" valign="top"><textarea name="message" id="message" onClick="this.value='' "></textarea></td>

                            </tr>

                            <tr>

                            <td align="left" valign="top">&nbsp;</td>

                            <td align="left" valign="top">&nbsp;</td>

                            </tr>

                            <tr>

                            <td align="left" valign="top">&nbsp;</td>

                            <td align="left" valign="top"><input type="submit" name="submit" id="submit" value="Post Reply"></td>

                            </tr>

                            </table>

                        <?php

                        } 

                        else 

                        { ?>

                            <table width="100%" border="0">

                            <tr>

                            <th align="left" valign="top" scope="col">&nbsp;</th>

                            <th align="left" valign="top" scope="col">&nbsp;</th>

                            </tr>

                            <tr>

                            <td align="left" valign="top" style="vertical-align:top;">Name</td>

                            <td align="left" valign="top"><input name="name" id="email" type="text" /></td>

                            </tr>

                            <tr>

                            <td align="left" valign="top" style="vertical-align:top;">Email</td>

                            <td align="left" valign="top"><input name="email" id="email" type="text" /></td>

                            </tr>

                            <tr>

                            <td align="left" valign="top" style="vertical-align:top;">Your Reply</td>

                            <td align="left" valign="top"><textarea name="message" id="message" ></textarea></td>

                            </tr>

                            <tr>

                            <td align="left" valign="top">&nbsp;</td>

                            <td align="left" valign="top">&nbsp;</td>

                            </tr>

                            <tr>

                            <td align="left" valign="top">&nbsp;</td>

                            <td align="left" valign="top"><input type="submit" name="submit" id="submit" value="Post Reply"></td>

                            </tr>

                            </table>

                        <?php 

                        } ?>

                        </form>

                    </div>

                    

                    

                    <?php 

					

					if ( array_key_exists("replies",$comment) )

					{

					

					?>

                    <div class="replies">

                    	<?php

						foreach ($comment['replies'] as $reply)

						{ ?>

							<div class="replyInfo">

                                <p>

                                    <?php echo $reply['message']; ?>

                                </p>

                                <p>

                                    By: <span class="by"><?php echo $reply['name']; ?></span>

                                </p>

                            </div>

						<?php

                        }

						?>

                    </div>

                    <?php 

					} ?>

                    

				

				</div>

				 

				<?php 

				

				} 

            }

            else

			{

				echo "No comment yet.";

			}

			?>

            <div id="commentRsp">

            	<?php echo $this->session->flashdata('rspComment'); ?>

            </div>

            <?php 

			if($customer_logged_in == 1)

			{ 

			?>

            <form id="commentReg" method="post" action="<?=base_url().index_page()?>blog/comment">

            <input type="hidden" name="post" value="<?=$post['id'];?>">

            <input type="hidden" name="blog" value="<?=$this->uri->segment(3);?>">

            

            <div id="commentForm">

            	<table width="100%" border="0">

                  <tr>

                    <th align="left" valign="top" scope="col">&nbsp;</th>

                    <th align="left" valign="top" scope="col">&nbsp;</th>

                  </tr>

                  <tr>

                    <td align="left" valign="top" style="vertical-align:top;">Your Message</td>

                    <td align="left" valign="top"><textarea name="message" id="message" onClick="this.value='' "></textarea></td>

                  </tr>

                  <tr>

                    <td align="left" valign="top">&nbsp;</td>

                    <td align="left" valign="top">&nbsp;</td>

                  </tr>

                  <tr>

                    <td align="left" valign="top">&nbsp;</td>

                    <td align="left" valign="top"><input type="submit" name="submit" id="submit" value="SUBMIT"></td>

                  </tr>

                </table>



            </div>

            

            </form>

            <?php 

			} 

			else 

			{ ?>

				

            <form id="commentUnreg" method="post" action="<?=base_url().index_page()?>blog/comment">

            <input type="hidden" name="post" value="<?=$post['id'];?>">

            <input type="hidden" name="blog" value="<?=$this->uri->segment(3);?>">

            

            <div id="commentForm">

            	<table width="100%" border="0">

                  <tr>

                    <th align="left" valign="top" scope="col">&nbsp;</th>

                    <th align="left" valign="top" scope="col">&nbsp;</th>

                  </tr>

                  <tr>

                    <td align="left" valign="top" style="vertical-align:top;">Name</td>

                    <td align="left" valign="top"><input name="name" id="email" type="text" /></td>

                  </tr>

                  <tr>

                    <td align="left" valign="top" style="vertical-align:top;">Email</td>

                    <td align="left" valign="top"><input name="email" id="email" type="text" /></td>

                  </tr>

                  <tr>

                    <td align="left" valign="top" style="vertical-align:top;">Your Message</td>

                    <td align="left" valign="top"><textarea name="message" id="message" ></textarea></td>

                  </tr>

                  <tr>

                    <td align="left" valign="top">&nbsp;</td>

                    <td align="left" valign="top">&nbsp;</td>

                  </tr>

                  <tr>

                    <td align="left" valign="top">&nbsp;</td>

                    <td align="left" valign="top"><input type="submit" name="submit" id="submit" value="SUBMIT"></td>

                  </tr>

                </table>



            </div>

            

            </form> 

                

			<?php 

			}

			?>

            

            

        </div>     

         

    </div>

    <div id="blogRight">

        

    </div>



</div>