<style type="text/css">
ul.address-container {
    margin: 0;
    padding: 0;
    text-align: left;
}
div.address-bg {
   /* background: url("../../skin/common_files/css/../images/bg_post.png") repeat scroll left top transparent;*/
    margin: 2px;
    padding: 8px;
    width: 260px;
}
ul.address-container {
    margin: 0;
    padding: 0;
    text-align: left;
}

ul, ol {
    color: #EC981F;
    margin: 10px 30px;
    padding: 0 15px;
}
li.address-box {
    border: 1px solid #DDDDDD;
    display: inline-block;
    list-style: none outside none;
    margin: 0 50px 50px 0;
    min-height: 46px;
    overflow: hidden;
    padding: 0;
    text-align: left;
    text-decoration: none;
    vertical-align: top;
    width: 216px;
}


</style>
<?php
   // echo '<pre>';
   // print_r($address);
?>

<ul class="address-container">
  
<li onclick="javascript: $('#address_0').submit();" class="address-box address-current" id="address_box_0" >
  <div class="address-bg">
    <div class="address-main" >
                <div class="new-address-label">
            <!--<a onclick="javascript: return !popupOpen('popup_address.php');" href="popup_address.php" class="new-address">Add new address</a> -->
            <a onclick="javascript: return !popupOpen('popup_address.php');" href="<?=base_url().index_page()?>MyAccount/AddressBook_new" class="new-address">Add new address</a>
          </div>

      
    </div>
  </div>
</li>  


<?php  if (!empty($address)) {
           $max = count($address);
        $address = $address[0];
        for($i=0; $i< $max; $i++) {
        if($address['default_shiping'] == 'Yes'){
            $addres_type = 'Shipping address';
        }else if($address['default_billing'] == 'Yes'){
              $addres_type = 'Billing address';
        }else if($address['default_billing'] == 'Yes' && $address['default_shiping'] == 'Yes' ){
              $addres_type = 'Shipping address/Billing address';
        }else{
             $addres_type = 'Deafult Address';
        }     
  ?> 
          
<li class="address-box" id="address_box_4">
  <div class="address-bg">
      <div class="address-main">
           <div class="address-default">  <?=$addres_type?> </div>
           <div class="address-line"> <?=$address['address_book_fname']?> &nbsp; <?=$address['address_book_lname']?></div>
           <div class="address-line">   <?=$address['address_book_address']?> ,<br>  <?=$address['address_book_city']?>,<?=$address['address_book_zipcode']?>
                <br>  <?=$address['address_book_country']?>
           </div>
           <div class="address-line">   <br>   </div>
              <br>
           <div class="buttons-row buttons-auto-separator">
              <!--<button onclick="javascript: popupOpen('popup_address.php?id=4');" title="Change" type="button" class="button">
              <span class="button-right"><span class="button-left">Change</span></span>
                   </button>  -->
            </div>
      </div>
  </div>
</li>
<?php
        }
}
?>
          
</ul>
