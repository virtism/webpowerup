<script type="text/javascript" src="<?=base_url()?>js/jquery-1.5.min.js"></script>
<?php 
if( !isset($form_number) ) // if there are multiple forms then 
{
	 $form_number = "";
}
?>
<script type="text/javascript">
$(document).ready(function() {
   	
	
    var chkboxName = new Array();
	var radioName = new Array();
	radioChecked = 0;
	var block = 0;
	$("#regFormFields<?=$form_number?>").submit(function(){
			
			clearAllError();
			block = 0;
			//alert(block); 
			var radioName = new Array();
		var checkboxName = new Array();
		var i = 0;
		var j = 0;
		var id,firstLetter,splitID;
		$(".required_custom_field").each(function() {
			
			id = $(this).attr("id");
			splitID = id.split("-");
			//alert(splitID);
			firstLetter = splitID[0];
			//alert(firstLetter);
			if(firstLetter == "check")
			{
				checkboxName[i] = $(this).attr("name");
				i++;
			}
			else if(firstLetter == "radio")
			{
				radioName[j] = $(this).attr("name");
				j++;
			}
			

		});
		//alert(radioName);alert(checkboxName);
		var unique = function(origArr) {  
			var newArr = [],  
				origLen = origArr.length,  
				found,  
				x, y;  
			for ( x = 0; x < origLen; x++ ) {  
				found = undefined;  
				for ( y = 0; y < newArr.length; y++ ) {  
					if ( origArr[x] === newArr[y] ) {  
					  found = true;  
					  break;  
					}  
				}  
				if ( !found) newArr.push( origArr[x] );  
			}  
		   return newArr;  
		};  
		
		radioName = unique(radioName);  
		checkboxName = unique(checkboxName);  
		
		chkboxName = checkboxName;
		radioName = radioName; 
			
			$.each(radioName, function(index, value) 
			{ 
				
				var name = "'"+value+"'";
				if( $("input[name="+name+"]").is(":checked") == false ) 
				{
					
					var radioChk = $("input[name="+value+"]").is(":checked");
					
					if(radioChk == false)
					{
						//radio.parent().css("border","solid 1px red");
						//radio.parent().css("border","green 1px red");
						$("input[name="+name+"]").parent().append("<span class='error'> This is required</span>");
						block = 1;
						return false;
					}
					//break;
				}
				
				
			});
			$.each(chkboxName, function(index, value) 
			{ 
				
				var name = "'"+value+"'";
				if( $("input[name="+name+"]").is(":checked") == false ) 
				{
					
					var chkboxChk = $("input[name="+value+"]").is(":checked");
					
					if(chkboxChk == false)
					{
						//radio.parent().css("border","solid 1px red");
						//radio.parent().css("border","green 1px red");
						$("input[name="+name+"]").parent().append("<span class='error'> This is required</span>");
						block = 1;
						return false;
					}
					//break;
				}
				
				
			});
			
			
		
			
			
			// var allFields = $(this).find(".required_custom_field").css("border","solid 1px red");
			
			// var v = $(".required_custom_field").val() || [];
			
			$("#regFormFields<?=$form_number?> .required_custom_field").each(function(index) {
				// alert(index + ': ' + $(this).val());
				
				
				if ( $(this).is(":text") ) // if it is a text field
				{
					if($(this).val() == "")
					{
						// $(this).css("border","solid 1px red");
						$(this).parent().append("<span class='error'> This is required</span>");
						block = 1;
						return false;
					}
				}
				
				else if( $(this).is("textarea") )
				{
					if($(this).val() == "")
					{
						// $(this).css("border","solid 1px red");
						$(this).parent().append("<span class='error'> This is required</span>");
						block = 1;
						return false;
					}
				}
				
				
			});
			
			if(block == 1)
			{
				return false;
			}
			else
			{
				return true;
			}
			
			
			
	});
	/*
	$("#regFormFields<?=$form_number?>").find(":radio").click(function(){
		radioChecked = 1;
	});
	*/
	
	
	
});


function clearAllError()
{
	$(".error").html("");
}

function submit_data()
{          
 
            /* get some values from elements on the page: */
           
 			//$("#regFormFields<?=$form_number?>").preventDefault();
            var url 	= $("#regFormFields").attr('action');
            var data 	= $("#regFormFields").serialize();
			//alert(data);
//Here I call the ajax and post the data
            $.ajax({
                type: "POST",
                dataType: "json",
                url: url,
                data: data,
                success: function (resp) {
                  
                    
                },
                error: function (xhr, status, error) {
 
                    var $jAlrtError = $('<div>' + xhr.responseText + '</div>');
 
                }
            });
       
}
</script>
<style>
.error 
{
color: #D8000C;
}
.formTbl
{
	padding-left:10px; 
}
.formTbl tr td{
	padding:3px 3px 3px 10px;
	
}

</style>
<?php 
if( ( !isset($thml_fixer)) )	// this fix the height problem for the view in specific page
{
?>		
	<div id="left" style="float: left; width: 688px; height: 760px;">
	<div  style="max-width: 688px;"> 
<?php
} 
?>
<?php
	$action = site_url()."Froms/index/";
	
	
?>
    


<h2><?php if(isset($form_data['form_title'])){ echo $form_data['form_title']; } ?></h2> 


<?php
// if form payment require

$is_payment = $form_detail['form_payment_required'];
$amount = $form_detail['pyment_qty'];
$item_number = $form_detail['form_id'];
$item_name =  $form_detail['form_title'];

if($is_payment) 	
{ 
	/*?>if(!$is_loggedin)
	{ ?>
		<legend>Form Field</legend>
                    <table class="formTbl">
                
                        <?php
                    
                            if($form_fields)
							{
								$n = count($form_fields);
								for($i=0; $i<$n; $i++ )
								{
									
									 echo  "<tr><td>".$form_fields[$i]['label']; 
									 echo $required = ($form_fields[$i]['required']=='Yes')? '*' : '';
									 echo " </td><td>";
									 echo  $form_fields[$i]['field'].' '.$form_fields[$i]['id']."</td></tr>"; 
									 
								}
							}
                        ?>
                           
                    </table>
                    <br /><br />
        <?            
		echo "This is paid form. You have to login first click <a href=\"".site_url()."MyAccount/login/".$site_id."\" > here </a> to login!";		
	}
	else 
	{<?php */
		if(!$is_user_paid )
		{
			?>
			<form action="<?=$action?>" method="post" id="regFormFields<?=$form_number?>" >
            <fieldset>           
                <?php if(isset($form_data['form_intro'])){ echo $form_data['form_intro']; }?>      
            </fieldset>
            <?php 
			// if form fields exist 
			if($form_fields)
			{
				
				echo form_hidden('action','done');
				if(isset($form_data['form_id']))
				{
					echo form_hidden('form_id',$form_data['form_id']);
				}
		
						?>       
					   <fieldset>
							<legend>Form Field</legend>
				<table class="formTbl">
				
						<?php
						
					
							
							$n = count($form_fields);
							
							
							for($i=0; $i<$n; $i++ )
							{
								
								 echo  "<tr><td>".$form_fields[$i]['label']; 
								 echo $required = ($form_fields[$i]['required']=='Yes')? '*' : '';
								 echo " </td><td>";
								 echo  $form_fields[$i]['field'].' '.$form_fields[$i]['id']."</td></tr>"; 
								 
							}
						?>
						   
					</table>
						</fieldset> 
					<?php 
			} 
			echo "<tr><td>".form_submit(array('name' => 'Submit'),'Submit')."</td></tr>";
			?>        
            </form>
            <? 
			//echo "This is paid form. You Have pay first";
			?>
			<br />	
			<form onclick="submit_data()" action="<?=$this->paypal_lib->paypal_url?>" method="post" id="paypalForm" class="niceform" >
			<input type="hidden" name="cmd" value="_xclick">
			<!--<input type="hidden" name="upload" value="1">-->
			<input type="hidden" name="business" value="<?=$payPal_id?>">
			<input type="hidden" name="currency_code" value="USD">
			<input type="hidden" name="rm" value="2">   
			<input type="hidden" name="return" value="<?=site_url()?>Froms/save_payment">
			<input type="hidden" name="cancel_return" value="<?=current_url()?>">
			<input type="hidden" name="notify_url" value="<?=base_url().index_page()?>paypal/ipn">      
			<input type="hidden" name="item_name" value="<?=$item_name?>">
			<input type="hidden" name="item_number" value="<?=$item_number?>">
			<input type="hidden" name="quantity" value="1">
			<input type="hidden" name="amount" id="price" value="<?=$amount?>">
			<input type="hidden" name="custom" value="<?=$_SESSION['login_info']['customer_id']?>">
			<!--<input type="hidden" name="on0" value="usman">
			<input type="hidden" name="os0" value="999999">-->
			<input id="btnPaypal" style="margin:10px;" type="image" src="http://www.paypal.com/en_US/i/btn/x-click-but01.gif" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
			</form>	
			<?
		}
		else
		{
			if(!$is_user_submit )
			{
			?>
            <form action="<?=$action?>" method="post" id="regFormFields<?=$form_number?>" >
            <fieldset>           
                <?php if(isset($form_data['form_intro'])){ echo $form_data['form_intro']; }?>      
            </fieldset>
            <?php 
			// if form fields exist 
			if($form_fields)
			{
				
				echo form_hidden('action','done');
				if(isset($form_data['form_id']))
				{
					echo form_hidden('form_id',$form_data['form_id']);
				}
		
						?>       
					   <fieldset>
							<legend>Form Field</legend>
				<table class="formTbl">
				
						<?php
						
					
							
							$n = count($form_fields);
							
							
							for($i=0; $i<$n; $i++ )
							{
								
								 echo  "<tr><td>".$form_fields[$i]['label']; 
								 echo $required = ($form_fields[$i]['required']=='Yes')? '*' : '';
								 echo " </td><td>";
								 echo  $form_fields[$i]['field'].' '.$form_fields[$i]['id']."</td></tr>"; 
								 
							}
						?>
						   
					</table>
						</fieldset> 
					<?php 
			} 
			echo "<tr><td>".form_submit(array('name' => 'Submit'),'Submit')."</td></tr>";
			?>        
            </form>
            <?php
			}
			else
			{
				echo "You have already paid and submitted this form";
			}
		}
		

	//}
?>
<?php 
} 
// if form payment is not required 
else
{ 
	
	?>
	<form action="<?=$action?>" method="post" id="regFormFields<?=$form_number?>" >
    <fieldset>           
        <?php if(isset($form_data['form_intro'])){ echo $form_data['form_intro']; }?>      
    </fieldset>
    <?php 
    // if form fields exist 
    if($form_fields)
    {
        
        echo form_hidden('action','done');
        if(isset($form_data['form_id']))
        {
            echo form_hidden('form_id',$form_data['form_id']);
        }

                ?>       
               <fieldset>
                    <legend>Form Field</legend>
                    <table class="formTbl">
                
                        <?php
                        
                    
                            
                            $n = count($form_fields);
                            
                            
                            for($i=0; $i<$n; $i++ )
                            {
                                
                                 echo  "<tr><td>".$form_fields[$i]['label']; 
                                 echo $required = ($form_fields[$i]['required']=='Yes')? '*' : '';
                                 echo " </td><td>";
                                 echo  $form_fields[$i]['field'].' '.$form_fields[$i]['id']."</td></tr>"; 
                                 
                            }
                        ?>
                           
                    </table>
                </fieldset> 
            <?php 
    } 
    echo "<tr><td>".form_submit(array('name' => 'Submit'),'Submit')."</td></tr>"; 
    ?>        
    </form>
	<?php
}  
if( ( !isset($thml_fixer)) )
{
?>	
</div>
</div>
<?php
} 
?>
