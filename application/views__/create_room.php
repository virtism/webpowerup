<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
<style type="text/css">
#popup3{
	color:#4E4E4E !important;
}
fieldset.group  { 
  margin: 0; 
  padding: 0; 
  margin-bottom: 1.25em; 
  padding: .125em; 
  width:900px;
  background-color:#f2f2f2 !important;
} 

fieldset.group legend { 
  margin: 0; 
  padding: 0; 
  font-weight: bold; 
  margin-left: 20px; 
  font-size: 100%; 
  color: black !important; 
} 

ul.checkbox  { 
  margin: 0; 
  padding: 0; 
  margin-left: 30px; 
  
} 

ul.checkbox li
{
	list-style: none; 
  	float:left;
  	margin-left:20px;
}

ul.checkbox li input { 
  margin-right: .25em; 
  
} 

ul.checkbox li { 
  border: 1px transparent solid; 
} 

ul.checkbox li label { 
  margin-left: ; 
} 

ul.checkbox li:hover, 

ul.checkbox li.focus  { 
  background-color: #E3E4FA !important; 
  border: 1px gray solid; 
  width: auto; 
  
} 
.checkbox li label a{
	color:#666 !important;
}      /* unvisited link */
</style>
<style>
#reminder
{
	opacity:1 !important;
}
	.meeting-time-table
	{
			
	}
	.meeting-time-table tr td 
	{
		padding-left:5px;	
	}
	#fancybox-close {
	position: absolute;
	top: -15px;
	right: -15px;
	width: 30px;
	height: 30px;
	background: transparent url('fancybox.png') -40px 0px;
	cursor: pointer;
	z-index: 1103;
	display: none !important;
}

.tblAddFiels tr td{
text-align:center;
}
.labels label{
display:block;
padding:1px 0;
}
#usman tr td{
padding:10px 3px;
}
.cke_skin_kama .cke_wrapper{
width:auto !important;
}
.form_items tr td{
text-align:center;
}
#usman tr td select {
    display: block;
    margin: 0 0 0 22px;
    padding: 10px 3px;
}
.enter_date{
padding:0 0 0 10px;
margin:0 0 0 10px;
}
</style>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<script src="<?=base_url()?>js/detect_timezone.js"></script>
<script src="<?=base_url()?>js/jquery.detect_timezone.js"></script>
<script>
$(function() {
$( "#reg_date_start" ).datepicker();

$("#group_users").fancybox({
			maxWidth	: 600,
			maxHeight	: 600,
			fitToView	: false,
			width		: '70%',
			height		: '70%',
			autoSize	: false,
			closeClick	: false,
			openEffect	: 'none',
			closeEffect	: 'none'
		});
		
		
		$('#show_zones').fancybox({
               maxWidth     : 600,
               maxHeight    : 600,
               fitToView    : false,
               width        : '70%',
               height       : '70%',
               autoSize     : false,
               closeClick   : false,
               openEffect   : 'none',
               closeEffect  : 'none',
			   hideOnOverlayClick:false,
			   hideOnContentClick:false,
               href  		: '#popup_show_zones', 
    });

});

	function openTimeZone()
	{
		
		var div = document.getElementById('popup_show_zones');
		div.style.display="block";
		NFFix();
		//alert('ddd');
	}
	
	function closeTimeZone()
	{
		//close_time_zone
		var display = document.getElementById('popup_show_zones');
		 display.style.display="none";     
		 $.fancybox.close();
	
	}

function displayPopup()
{
	
	$("#popup3").show();
}

function displayPopup2()
{
	$("#popup3").hide();	
	$(document).ready(function() {
		$('a.fncy-custom-close').click(function(e){
			e.preventDefault();
			$.fancybox.close();
			$('#blue_tick').fadeIn(); 
		});
	});
}

$(document).ready(function() {

		var newDate = new Date();
        $('#hidden_time_zone').set_timezone({'default' : 'America/Los_Angeles'});
	});

function get_current_time()
{
		var newDate = new Date();
        var hidField = document.getElementById('zone');  // ID of hidden field
         hidField.value = newDate.toLocaleString();
}
function openPassField(flag)
{
	if(flag==1)
	{
		$('#pass_div').show('slow');
	}
	else
	{
		$('#pass_div').hide('slow');
	}
}


</script>
<script>
	 function validate()
     {
 		
		
		if(document.getElementById('name').value=='')
		{
			alert("Please enter name.");
			document.getElementById('name').focus;
			return false;
		}
		else if(document.getElementById('topic').value=='')
		{
			alert("Please enter topic.");
			return false;
		}
	/*	else if(document.getElementById('password').value=='')
		{
			alert("Please enter password.");
			flagSubmit = false;
		}*/
		
		var len = document.room_form.customers.length;
		var i = 0;
		var chosen = '';
		var nonGroups = $("#non_group").val();
		
		for (i = 0; i < len; i++)
		{
			if (document.room_form.customers[i].selected)
			{
				 chosen = document.room_form.customers[i].value;
			}
		}
		
		
		return true;
        
    }     
	function popUp(URL) {
		day = new Date();
		id = day.getTime();
		window.open(URL,'_blank');
		//eval("page" + id + " = window.open(URL, '" + id + "','mywindow' ,'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0');");
		//window.open('http://www.webpowerup.ca/broadcast/bin-debug/Red5Whiteboard.html','mywindow','width=400,height=200,toolbar=yes, location=yes,directories=yes,status=yes,menubar=yes,scrollbars=yes,copyhistory=yes, 
//resizable=yes')
		
}

// Using JQuery selectors to add onFocus and onBlur event handlers
	
$(document).ready( function() {
		
		  // Add the "focus" value to class attribute 
		  $('ul.checkbox li').focusin( function() {
			$(this).addClass('focus');
		  }
		  );
		
		  // Remove the "focus" value to class attribute 
		  $('ul.checkbox li').focusout( function() {
			$(this).removeClass('focus');
		  }
		  );
		
		});
	
		function selectGroup(id,childs)
		{
			
			var checkbox = document.getElementById(id);
			
			if(childs!=0)
			{
				if(checkbox.checked)
				{
					for(i=1; i<=childs; i++)
					{
						document.getElementById("child_"+id+'_'+i).checked=true;
						
					}
				}
				else
				{
					for(i=1; i<=childs; i++)
					{
						document.getElementById("child_"+id+'_'+i).checked=false;
					
					}
				}
				NFFix();
			}
		} 


$("div.NFRadio").live("click",function(){
	var id = $(this).next("input").attr("id");
	
	if(id == "join_admin_approval" || id == "join_anyone")
	{
		$("#join_pass_div").fadeOut();
	}
	
	if(id == "join_with_password" )
	{
		$("#join_pass_div").fadeIn();
	}
	
	
	if(id == "join_admin_approval" )
	{
		//$("#group_users").fadeOut();
		 $('#blue_tick').fadeOut();  
	}
	if(id == "join_with_password" )
	{
		//$("#group_users").fadeOut();
		 $('#blue_tick').fadeOut();  
	}
	if(id == "join_anyone" )
	{
		//$("#group_users").fadeIn();
		 $('#blue_tick').fadeOut();  
	}
	NFFix();
	
});

</script>


<div class="RightColumnHeading">
    <h1>
        <img src="<?=base_url();?>images/webpowerup/CreatRoom.png" alt="Creat a Newsletter"/>
        <span>Create Room</span>
    </h1>
</div>
<div class="form">        
    <form onSubmit="return validate()" method="post" id="room_form" name="room_form" action="<?=base_url().index_page()?>room_management/create_new_room" class="niceform" >
    <input type="hidden" name="hidden_time_zone" id="hidden_time_zone" >
    <fieldset>
        <dl>
            <dt><label for="email" class="NewsletterLabel">Name </label></dt>
            <dd><input type="text" name="name"   id="name" size="55" /></dd>
        </dl>
        
         <dl>
            <dt><label for="email" class="NewsletterLabel">Topic </label></dt>
            <dd><input type="text" name="topic"  id="topic" size="55" /></dd>
        </dl>
        
         <dl>
            <dt><label for="email" class="NewsletterLabel">Password </label></dt>
            <dd><input type="password" name="password"   id="password" size="55" /></dd>
        </dl>
       
      <dl>
            <dt><label for="color" class="NewsletterLabel">Group code </label></dt>
            <dd>
                <label class="check_label">Join meeting with admin approval</label>
                <input type="radio" checked="checked" name="attendee_options" id="join_admin_approval"  value="With Approval" />
                <br /><br>
                <label class="check_label">Join meeting with password</label>
                <input type="radio" name="attendee_options" id="join_with_password"  value="With Password" />
                
              <!--  <div id="join_pass_div" style="clear:both; display:none;">
                <input type="password" name="join_password" id="join_password" size="20" />-->
                <br /><br>
               <!-- </div>-->
                
                
                <label class="check_label">Anyone can join </label>
                <input type="radio" name="attendee_options" id="join_anyone"  value="Anyone" />
                
               
            </dd>
        </dl>
        <dl>
            <dt><label for="color" class="NewsletterLabel"> </label></dt>
            <dd>
             <input  type="checkbox" name="check1" name="approval" id="approval" checked="checked" />   
             <label class="check_label">Ask for my approval when someone joins Only start session after admin has joined</label>
            </dd>
        </dl>
        
        <dl>
            <dt><label for="comments" class="NewsletterLabel">Select Invitees</label></dt>
            <dd>
            
				
            <a id="group_users"  class="group_users" href="#popup3" onClick="displayPopup()">Select Groups and users.</a><img style="display:none;" id="blue_tick" src="<?=base_url().index_page()?>css/images/blue_tick.png" />
                <div style="display:none;" >
                                <div id="popup3">
                    <h1>Select Group & Users</h1>
                   
                    <?php  if(isset($groups_users) && count($groups_users)>0)
                            { 
                                for($i = 0; $i < count($groups_users); $i++)
                                {
                                    if(isset($groups_users[$i]['group_name']))
                                    {
                                        
                                        $child_count = count($groups_users[$i]['users']);
                                        if($groups_users[$i]['users']==0)
                                        {
                                            $child_count = 0;
                                        }
                                        
                    ?>	
                                        <fieldset class="group"> 
                                            <legend onClick="selectGroup(<?=$i?>,<?=$child_count?>)"><input type="checkbox" id="<?=$i?>"  value="<?=$groups_users[$i]['id']?>" name="group_<?=$i?>" onClick="selectGroup(<?=$i?>,<?=$child_count?>)" /><label for="cb1"><?=$groups_users[$i]['group_name']?></label></legend> 
                    <?php 					if(isset($groups_users[$i]['users']) && $groups_users[$i]['users']!=0)
                                            { 
                    ?>
                                                <ul class="checkbox">
                    <?php							$j=0;
                                                    foreach($groups_users[$i]['users'] as $key => $users)
                                                    {
                                                        $j++;
                                                        
                    ?><input type="hidden" name="group_count_<?=$i?>" id="group_count_<?=$i?>" value="<?=$i?>" />
                        <input type="hidden" name="user_count_<?=$i?>" id="user_count_<?=$i?>" value="<?=$j?>" />
                                                        <li><input type="checkbox" name="child_<?=$i?>_<?=$j?>" id="child_<?=$i?>_<?=$j?>"  value="<?=$key?>" /><label for="cb6>"><a href="javascript:void(0)" ><?=$users?></a></label></li> 
                                          
                    <?  							}
                                                echo "</ul>";
                                            }
                                            else
                                            {
                                                echo '<ul class="checkbox"><li>No user has been registerd for this group.</li></ul>';
                                            }
                    ?>
                                                
                                        </fieldset> 
                    <?php
                                    }
                                } ?>
                                <input type="hidden" name="group_total" id="group_total" value="<?=$i?>" />
                        	<?
							}
							else
							{
								echo '<ul class="checkbox noGroup"><li>No Groups or User have been Registered.</li></ul>';
							}
                    ?>
                    
                    <a href="#" class="fncy-custom-close">
                    <input type="button" value="close" onClick="displayPopup2()"/>
                    </a>
              </div>
              </div>
            </dd>
        </dl>
        
         <dl>
            <dt><label for="comments2" class="NewsletterLabel">Invite Non-members 
            (Enter E-mail Comma 
            Sperated)</label></dt>
            <dd><textarea id="non_group" name="non_group" rows="10" cols="42"></textarea></dd>
        </dl>
        
        <dl>
            <dt><label for="email" class="NewsletterLabel"> Set date </label></dt>
            <dd><input type="text" id="reg_date_start" name="reg_date_start" /></dd>
           
        </dl> 
         <dl>
            <dt><label for="email" class="NewsletterLabel"> Timezone </label></dt>
            <dd>
            
                   <div style="float:left; margin:0 0 0 10px;" >
                    <div style=" position:relative; float:left; ">
                     
            		<select size="1" name="r_hours" id="r_hours" style="width:80px;"> 
                       <option selected="selected" value="HH">HH</option><option  value="00">00</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option>
                    </select>      
                    </div>
                    </div>      
              <div style="float:left; margin:0 0 0 10px;" >
              <div style=" position:relative; float:left;  " >
              
            		<select size="1" name="r_minuts" id="r_minuts" style="width:80px;"> 
                       <option selected="selected"  value="MM">MM</option><option value="00">00</option><option value="15">15</option><option value="30">30</option><option value="45">45</option></select>
                    </select>      
                    </div>                   
             </div>
             
             <div style="float:left; margin:0 0 0 10px;" >
                    <div style=" position:relative; float:left">
            		<select size="1" name="ampm" id="ampm" style="width:80px;"> 
                        <option value="AM" selected="selected">AM</option>
                        <option value="PM">PM</option>
                    </select>      
                    </div>      
             </div>
             <br />
             <a style="float:left; padding-left:10px;" id="show_zones" href="#popup_show_zones" onclick="openTimeZone()"><b>
                <span id="time_zone_name" style="text-decoration:underline;">Central Time (US &amp; Canada)</span></b></a>
                
            </dd>
      </dl>
    	<dl>
        	<dd>
            	<div id="popup_show_zones" style="float:left; display:none;  width:700px; height:500px;" >
                   <ul style="padding-bottom:10px;">
                       <li style="padding: 10px 0px 10px 0px;">
                       		<input type="radio"	name="show_us_intl" value="intl" id="show_international_time_zones"/><label for="email" class="NewsletterLabel"> International Time Zones </label>
                       </li>
                    
                    	<li style="padding: 10px 0px 10px 0px;">
                                <select size="10" name="time_zone_intl" id="time_zone"  style="width:auto; height:400px;"  >
                                <? for($i = 0; $i<count($times_zones); $i++){ ?>
                                    <option value="<?=$times_zones[$i]['time_zone_offset']?>"><?=$times_zones[$i]['time_zone_area']?></option>
                                <? } ?>
                                </select>
                        </li>
                    </ul>
                    <ul>
                       <li style="padding: 10px 0px 10px 0px;">
                            	<input type="radio" checked="checked" name="show_us_intl" value="us" id="show_us_time_zones"/><label for="email" class="NewsletterLabel"> US Time Zones </label>
                           </li>
                    	<li>

                                <select name="time_zone_us" size="8" style="height:300;width:290;">
                                   <option value="-08:00">(GMT-08:00) Pacific Time (US &amp; Canada); Tijuana</option>
                                   <option value="-07:00">(GMT-07:00) Mountain Time (US &amp; Canada)</option>
                                   <option value="-06:00">(GMT-06:00) Central America</option>
                                   <option value="-06:00" selected="">(GMT-06:00) Central Time (US &amp; Canada)</option>
                                   <option value="-05:00">(GMT-05:00) Eastern Time (US &amp; Canada)</option>
                                </select>
						</li>
                    </ul>
                    <ul><li style="padding: 10px 0px 10px 0px;"><input type="button" id="close_time_zone" onclick="closeTimeZone()" value="Close"/></li></ul>
                 </div>
            
            </dd>        
        </dl>       
        <dl>
            <dt><label for="gender" class="NewsletterLabel">Reminder</label></dt>
            <dd>
              <select size="1" name="reminder" id="reminder" style="width:360px"> 
                    <option value="1">1  Hour Before</option>
                    <option value="3">3  Hour Before</option>
                    <option value="6">6  Hour Before</option>
                    <option value="24">24 Hour Before</option>
                </select>
            </dd>
        </dl>
        
    <!--   <dl>
            <dt><label for="email" class="NewsletterLabel"> Timezone </label></dt>
            <dd>
            	<input type="text" name="zone" id="zone" onClick="get_current_time()" value="" />
            </dd>
      </dl>-->
        
        <dl>
            <dt><label for="email" class="NewsletterLabel"> Message </label></dt>
            <dd><textarea id="message" name="message" rows="10" cols="42"></textarea>
            </dd>
        </dl>
                            
        <dl>
            <dt><label for="color" class="NewsletterLabel"></label></dt>
            <dd>
                <div class="ButtonRow">
            <button type="submit" name="save" value="Save" >
                <img src="<?=base_url();?>images/webpowerup/SaveGreen.png" alt="SaveGreen"/>
            </button>
            <button type="submit"  name="save-start" value="Save & Start Meeting">
                <img src="<?=base_url();?>images/webpowerup/MeetingBlue.png" alt="Meeting"/>
            </button>
            
            <a href="#" class="CancelButton">
                <img src="<?=base_url();?>images/webpowerup/CancelRed.png" alt="search Button"/>
            </a>
             
            
         </div>
            </dd>
        </dl>
    
         
        
    </fieldset>
    
    
    
    </form>
</div>