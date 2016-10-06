<div style='display:none'>
  <div class='contact-top'></div>
  <div class='contact-content'>
    <h1 class='contact-title'><?php echo $text_click_title ?></h1>
    <div class='contact-loading' style='display:none'></div>
    <div class='contact-message' style='display:none'></div>
    <form action='#' style='display:none' class="form_check">
      <label for='contact-name'>* <?php echo $text_click_name; ?></label>
      <input type='text' id='contact-name' class='contact-input nameinput rfield"' name="name" onKeyUp="if(/[^a-zA-Zа-яА-ЯёЁ ]/i.test(this.value)){this.value='';}" />
      <label class="telholder" for='contact-phone'>* <?php echo $text_click_phone; ?></label>
      <input type="tel"  id='contact-phone' class='contact-input user_phone rfield phonefield' name='phone' placeholder="*** *** ***"/>
      <label>&nbsp;</label>
      <button type='submit' class='contact-send contact-button btnsubmit'><?php echo $text_click_button_send; ?></button>
      <button type='submit' class='contact-cancel contact-button simplemodal-close'><?php echo $text_click_button_cancel; ?></button>
      <br/>
      <input type='hidden' name='token' value='<?php echo $token; ?>'/>
      <br/> 
    </form>
  <div class='contact-bottom'><?php echo $text_click_bottom; ?></div>
<script src="catalog/view/javascript/jquery/is.mobile.js" type="text/javascript"></script>
<script src="catalog/view/javascript/jquery/jquery.maskedinput.min.js" type="text/javascript"></script>
<script src="catalog/view/javascript/jquery/script.js" type="text/javascript"></script>




