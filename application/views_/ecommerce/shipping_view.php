<div class="RightColumnHeading">
    <h1>
        <span>Shipping Management</span>
    </h1>
</div>

<div class="clr"></div>
 
<div class="InnerMain" >
<form id="store_setting" name="store_setting" method="post" class="niceform" action="<?=site_url()?>Shipping_Management" >
<input type="hidden" name="action" value="setStore" />

	<dl>
       <dt>
             <label  class="NewsletterLabel">Total Weight:</label>
       </dt>
       <dd>
       		<input type="text" id="weight" name="weight" value="0.00" size="20"  /> 
            <div style=" float:left; margin:0 0 0 15px; ">
                <div  style="position:relative;" >
                <select size="1" name="weight_type" style="width:120px;"> 
                    <option value="Kilos">Kilos</option>
                    <option value="Tons">Tons</option>
                    <option value="Lbs">Lbs</option>
                </select>
                </div>
            </div>
       </dd>
	</dl>
    
    <dl>
       <dt>
             <label  class="NewsletterLabel">Free shipping:</label>
       </dt>
       <dd>
           <div  style="position:relative;" >
            <select size="1" name="free_shipping" style="width:160px;"> 
                <option value="No">No</option>
                <option value="Yes">Yes</option>
            </select>
            </div>
       </dd>
	</dl>
    
    <dl>
       <dt>
             <label  class="NewsletterLabel">Shipping freight ($):</label>
       </dt>
       <dd>
           <input type="text" id="shipping_freight" name="shipping_freight" value="0.00" size="20"  />
       </dd>
	</dl>
    
    <dl>
       <dt>
             <label  class="NewsletterLabel"></label>
       </dt>
       <dd>
            <input type="checkbox" name="use_weight_for_shipping" id="use_weight_for_shipping" value="Yes" checked="checked" />
            <label class="check_label">Use the Weight of this product for shipping cost calculation</label>
       </dd>
	</dl>

    <div class="ButtonRow">
       
        <button type="submit">
            <img src="<?=base_url();?>images/webpowerup/SaveGreen.png" alt="SaveGreen"/>
        </button>
        
     </div>





</form>
</div>