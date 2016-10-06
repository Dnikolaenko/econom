<div style='display:none'>
  <div class='contact-top'></div>
  <div class='contact-content'>
    <h1 class='contact-title'><?php echo $text_contact_title; ?></h1>
    <div class='contact-loading' style='display:none'></div>
    <div class='contact-message' style='display:none'></div>
    <form action='#' style='display:none'>
      <label for='contact-name'>* <?php echo $text_contact_name; ?></label>
      <input type='text' id='contact-name' class='contact-input' name='name' tabindex='1001' />
      <label for='contact-phone'>* <?php echo $text_contact_phone; ?></label>
      <input type='text' id='contact-phone' class='contact-input' name='phone' tabindex='1002' />
      <?php if ($settings['callback_time']) { ?>
      <label for='contact-subject'><?php echo $text_contact_callback_time; ?></label>
      <SELECT id='contact-subject' class='contact-input' name='subject' tabindex='1003'> 
      <OPTION value='Передзвонити з xx:xx до xx:xx'>с xx:xx до xx:xx</OPTION>
      <OPTION value='Передзвонити з 09:00 до 10:00'>с 09:00 до 10:00</OPTION>
      <OPTION value='Передзвонити з 10:00 до 11:00'>с 10:00 до 11:00</OPTION>
      <OPTION value='Передзвонити з 11:00 до 12:00'>с 11:00 до 12:00</OPTION>
      <OPTION value='Передзвонити з 12:00 до 13:00'>с 12:00 до 13:00</OPTION>
      <OPTION value='Передзвонити з 13:00 до 14:00'>с 13:00 до 14:00</OPTION>
      <OPTION value='Передзвонити з 14:00 до 15:00'>с 14:00 до 15:00</OPTION>
      <OPTION value='Передзвонити з 15:00 до 16:00'>с 15:00 до 16:00</OPTION>
      <OPTION value='Передзвонити з 16:00 до 17:00'>с 16:00 до 17:00</OPTION>
      <OPTION value='Передзвонити з 17:00 до 18:00'>с 17:00 до 18:00</OPTION>
      <OPTION value='Передзвонити з 18:00 до 19:00'>с 18:00 до 19:00</OPTION>
      </SELECT>
      <br/>
      <?php } ?>
      <?php if ($settings['show_message']) { ?>
      <label for='contact-message'>* <?php echo $text_contact_message; ?></label>
      <textarea id='contact-message' class='contact-input' name='message' cols='20' rows='4' tabindex='1004'></textarea>
      <?php } ?>
      <br/>
      <label>&nbsp;</label>
      <button type='submit' class='contact-send contact-button' tabindex='1006'><?php echo $text_contact_button_send; ?></button>
      <button type='submit' class='contact-cancel contact-button simplemodal-close' tabindex='1007'><?php echo $text_contact_button_cancel; ?></button>
      <br/>
      <input type='hidden' name='token' value='<?php echo $token; ?>'/>
      <br/>
    </form>
  </div>
  <div class='contact-bottom'><?php echo $text_contact_bottom; ?></div>
</div>