
<script type="text/javascript">
// getting ajax call for state on base of country selected	
	$("div.NFSelect").live("click",function(){
	if($(this).next().attr("id")=='country_shipping')
	{
		var country_id = document.getElementById('country_shipping').value;
		//country_id = country_id.replace("-"," ");
		var path =  "<?=base_url().index_page()?>Shipping_Management/ajax_call_states/";
		
		var dataString = "country_id="+country_id;
		//alert( path);
			$.ajax({
				url: path, 
				data: dataString,
				type:'POST', 
				success: function(data){
					$("#state_option").html(' ');
					//alert(data);
					//$("#customers_detail").show();
					$("#state_option").html(data);
					//alert("success");
				}
			});
		
		}
	});
</script>

<style type="text/css">
div#actionMenu li {
    display: inline;
    list-style-type: none;
    padding-right: 20px;
}
div#actionMenu {
    margin-top:10px;
    margin-bottom:10px; 
}
p{
font-weight:bold;
}
</style>

<div class="RightColumnHeading">
    <h1>
        <span>Manage Country and States</span>
    </h1>
</div>

<div class="clr"></div>

<div class="form">
	<form action="<?=site_url();?>Shipping_Management/save_shipping" method="post" class="niceform">
	<dl>
       <dt>
             <label class="NewsletterLabel">country</label>
       </dt>
       <dd>
       		<div style=" position:relative;" >
            <select size="1" id="country_shipping" name="country_shipping" style="width:360px;" >
				<? foreach($countries as $country) 
                {
                    $country['countries_name'] = str_replace(" ","-",$country['countries_name']);
                    echo "<option value=".$country['countries_id'].">".$country['countries_name']."</option>";
                }
                ?>													
			</select>
            </div>
       </dd>
	</dl>
    
    <dl>
       <dt>
             <label class="NewsletterLabel">State/Province</label>
       </dt>
       <dd>
       		<div id="state_option" style=" position:relative;" >
            <select size="1" id="state" name="state" style="width:360px;" >
				<? foreach($states as $state) 
                {
                    echo "<option value=".$state['zone_name'].">".$state['zone_name']."</option>";
                }
                ?>													
            </select>
            </div>
       </dd>
	</dl>
    
    <dl>
       <dt>
             <label for="" class="NewsletterLabel">Shipping Rate Name</label>
             &nbsp;
       </dt>
       <dd>
      		<input type="text" name="shipping_rate_name" id="shipping_rate_name"  value="0.1-2" size="52" />
       </dd>
	</dl>
    
    <dl>
       <dt>
             <label for="" class="NewsletterLabel">Weight Range (g)</label>
             &nbsp;
       </dt>
       <dd>
       		<div style="float:left; display:inline;">
            
      		<label class="check_label">From</label>
            <input type="text" name="min_range" id=""  value="0.1" size="10" />
            </div>
            <div style="width:90px; float:left; display:inline;">
            &nbsp;
            </div>
            <div style="float:left; display:inline;">
            <label class="check_label">to</label>
            <input type="text" name="max_range" id=""  value="2" size="10" />
            </div>
       </dd>
	</dl>
    
    <dl>
       <dt>
             <label for="" class="NewsletterLabel">Shipping Rate (CAD)</label>
             &nbsp;
       </dt>
       <dd>
      		<input type="text" name="rate" id="rate" value="" size="52" />
            
       </dd>
	</dl>
    
    <div class="ButtonRow">
        <button type="submit">
            <img src="<?=base_url();?>images/webpowerup/SaveGreen.png" alt="Save"/>
        </button>
    </div>
    
</form>
</div>