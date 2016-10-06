<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>
<div class="heading">
  <h1><?php echo $heading_title; ?></h1>
  <div class="buttons"><a onclick="$('#form').submit();" class="button"><span class="button_left button_save"></span><span class="button_middle"><?php echo $button_save; ?></span><span class="button_right"></span></a><a onclick="location='<?php echo $cancel; ?>';" class="button"><span class="button_left button_cancel"></span><span class="button_middle"><?php echo $button_cancel; ?></span><span class="button_right"></span></a></div>
</div>
<div class="tabs"><a tab="#tab_shop"><?php echo $tab_shop; ?></a><a tab="#tab_local"><?php echo $tab_local; ?></a><a tab="#tab_option"><?php echo $tab_option; ?></a><a tab="#tab_image"><?php echo $tab_image; ?></a><a tab="#tab_mail"><?php echo $tab_mail; ?></a><a tab="#tab_server"><?php echo $tab_server; ?></a><a tab="#tab_banners"><?php echo $tab_banners; ?></a></div>
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
  <div id="tab_shop" class="page">
    <table class="form">
      <tr>
        <td width="25%"><span class="required">*</span> <?php echo $entry_store; ?></td>
        <td><input type="text" name="config_store" value="<?php echo $config_store; ?>" size="80" />
          <br />
          <?php if ($error_store) { ?>
          <span class="error"><?php echo $error_store; ?></span>
          <?php } ?></td>
      </tr>
      <tr>
        <td><span class="required">*</span> <?php echo $entry_title; ?></td>
        <td><input type="text" name="config_title" value="<?php echo $config_title; ?>" size="80" />
          <br />
          <?php if ($error_title) { ?>
          <span class="error"><?php echo $error_title; ?></span>
          <?php } ?></td>
      </tr>
      <tr>
        <td><?php echo $entry_meta_description; ?></td>
        <td><textarea name="config_meta_description" cols="77" rows="3"><?php echo $config_meta_description; ?></textarea></td>
      </tr>
      <tr>
        <td><?php echo $entry_meta_keywords; ?></td>
        <td><textarea name="config_meta_keywords" cols="77" rows="3"><?php echo $config_meta_keywords; ?></textarea></td>
      </tr>
      <tr>
        <td><span class="required">*</span> <?php echo $entry_owner; ?></td>
        <td><input type="text" name="config_owner" value="<?php echo $config_owner; ?>" size="80" />
          <br />
          <?php if ($error_owner) { ?>
          <span class="error"><?php echo $error_owner; ?></span>
          <?php } ?></td>
      </tr>
      <tr>
        <td><span class="required">*</span> <?php echo $entry_address; ?></td>
        <td><textarea name="config_address" cols="77" rows="5"><?php echo $config_address; ?></textarea>
          <br />
          <?php if ($error_address) { ?>
          <span class="error"><?php echo $error_address; ?></span>
          <?php } ?></td>
      </tr>
      <tr>
        <td><span class="required">*</span> <?php echo $entry_invoice_data; ?></td>
        <td><textarea name="config_invoice_data" cols="77" rows="8"><?php echo $config_invoice_data; ?></textarea>
      </tr>
      <tr>
        <td><span class="required">*</span> <?php echo $entry_nds_invoice_data; ?></td>
        <td><textarea name="config_nds_invoice_data" cols="77" rows="8"><?php echo $config_nds_invoice_data; ?></textarea>
      </tr>
      <tr>
        <td><span class="required">*</span> <?php echo $entry_email; ?></td>
        <td><input type="text" name="config_email" value="<?php echo $config_email; ?>" size="40" />
          <br />
          <?php if ($error_email) { ?>
          <span class="error"><?php echo $error_email; ?></span>
          <?php } ?></td>
      </tr>
      <tr>
        <td><span class="required">*</span> <?php echo $entry_admin_email; ?></td>
        <td><input type="text" name="config_admin_email" value="<?php echo $config_admin_email; ?>" size="40" />
          <br />
          <?php if ($error_admin_email) { ?>
          <span class="error"><?php echo $error_admin_email; ?></span>
          <?php } ?></td>
      </tr>
      <tr>
        <td><span class="required">*</span> <?php echo $entry_director_email; ?></td>
        <td><input type="text" name="config_director_email" value="<?php echo $config_director_email; ?>" size="40" />
          <br />
          <?php if ($error_director_email) { ?>
          <span class="error"><?php echo $error_director_email; ?></span>
          <?php } ?></td>
      </tr>
      <tr>
        <td><?php echo $entry_bcc_email; ?></td>
        <td><textarea name="config_bcc_email" cols="77" rows="4"><?php echo $config_bcc_email; ?></textarea>
      </tr>
      <tr>
        <td><span class="required">*</span> <?php echo $entry_telephone_right; ?></td>
        <td><input type="text" name="config_telephone_right" value="<?php echo $config_telephone_right; ?>"  size="80" />
          <br />
          <?php if ($error_telephone) { ?>
          <span class="error"><?php echo $error_telephone; ?></span>
          <?php } ?></td>
      </tr>
      <tr>
        <td><?php echo $entry_telephone_left; ?></td>
        <td><input type="text" name="config_telephone_left" value="<?php echo $config_telephone_left; ?>"  size="80" />
      </tr>
      <tr>
        <td><?php echo $entry_fax; ?></td>
        <td><input type="text" name="config_fax" value="<?php echo $config_fax; ?>" /></td>
      </tr>
      <tr>
        <td><?php echo $entry_contacts_title; ?></td>
        <td><input type="text" name="config_contacts_title" value="<?php echo $config_contacts_title; ?>" size="80" /></td>
      </tr>
      <tr>
        <td><?php echo $entry_contacts_meta_description; ?></td>
        <td><textarea name="config_contacts_meta_description" cols="77" rows="3"><?php echo $config_contacts_meta_description; ?></textarea></td>
      </tr>
      <tr>
        <td><?php echo $entry_contacts_meta_keywords; ?></td>
        <td><textarea name="config_contacts_meta_keywords" cols="77" rows="3"><?php echo $config_contacts_meta_keywords; ?></textarea></td>
      </tr>
      <tr>
        <td><?php echo $entry_template; ?></td>
        <td><select name="config_template" onchange="$('#template').load('index.php?route=setting/setting/template&template=' + encodeURIComponent(this.value));">
            <?php foreach ($templates as $template) { ?>
            <?php if ($template == $config_template) { ?>
            <option value="<?php echo $template; ?>" selected="selected"><?php echo $template; ?></option>
            <?php } else { ?>
            <option value="<?php echo $template; ?>"><?php echo $template; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td>
      </tr>
      <tr>
        <td></td>
        <td id="template"></td>
      </tr>
      <?php foreach ($languages as $language) { ?>
      <tr>
        <td><?php echo $entry_welcome; ?></td>
        <td><textarea name="config_welcome_<?php echo $language['language_id']; ?>" id="description<?php echo $language['language_id']; ?>"><?php echo ${'config_welcome_' . $language['language_id']}; ?></textarea>
          <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align: top;" /></td>
      </tr>
      <tr>
        <td><?php echo $entry_bottom_message; ?></td>
        <td><textarea name="config_bottom_message_<?php echo $language['language_id']; ?>" id="bottom_message<?php echo $language['language_id']; ?>"><?php echo ${'config_bottom_message_' . $language['language_id']}; ?></textarea>
          <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align: top;" /></td>
      </tr>
      <tr>
        <td><?php echo $entry_contacts_extra; ?></td>
        <td><textarea name="config_contacts_extra_<?php echo $language['language_id']; ?>" id="contacts_extra<?php echo $language['language_id']; ?>"><?php echo ${'config_contacts_extra_' . $language['language_id']}; ?></textarea>
          <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align: top;" /></td>
      </tr>
      <?php } ?>
    </table>
  </div>
  <div id="tab_local" class="page">
    <table class="form">
      <tr>
        <td width="25%"><?php echo $entry_country; ?></td>
        <td><select name="config_country_id" id="country" onchange="$('#zone').load('index.php?route=setting/setting/zone&country_id=' + this.value + '&zone_id=<?php echo $config_zone_id; ?>');">
            <?php foreach ($countries as $country) { ?>
            <?php if ($country['country_id'] == $config_country_id) { ?>
            <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td>
      </tr>
      <tr>
        <td><?php echo $entry_zone; ?></td>
        <td><select name="config_zone_id" id="zone">
          </select></td>
      </tr>
      <tr>
        <td><?php echo $entry_language; ?></td>
        <td><select name="config_language">
            <?php foreach ($languages as $language) { ?>
            <?php if ($language['code'] == $config_language) { ?>
            <option value="<?php echo $language['code']; ?>" selected="selected"><?php echo $language['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $language['code']; ?>"><?php echo $language['name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td>
      </tr>
      <tr>
        <td><?php echo $entry_admin_language; ?></td>
        <td><select name="config_admin_language">
            <?php foreach ($languages as $language) { ?>
            <?php if ($language['code'] == $config_admin_language) { ?>
            <option value="<?php echo $language['code']; ?>" selected="selected"><?php echo $language['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $language['code']; ?>"><?php echo $language['name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td>
      </tr>
      <tr>
        <td><?php echo $entry_currency; ?></td>
        <td><select name="config_currency">
            <?php foreach ($currencies as $currency) { ?>
            <?php if ($currency['code'] == $config_currency) { ?>
            <option value="<?php echo $currency['code']; ?>" selected="selected"><?php echo $currency['title']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $currency['code']; ?>"><?php echo $currency['title']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td>
      </tr>
      <tr>
        <td><?php echo $entry_currency_auto; ?></td>
        <td><?php if ($config_currency_auto) { ?>
          <input type="radio" name="config_currency_auto" value="1" checked="checked" />
          <?php echo $text_yes; ?>
          <input type="radio" name="config_currency_auto" value="0" />
          <?php echo $text_no; ?>
          <?php } else { ?>
          <input type="radio" name="config_currency_auto" value="1" />
          <?php echo $text_yes; ?>
          <input type="radio" name="config_currency_auto" value="0" checked="checked" />
          <?php echo $text_no; ?>
          <?php } ?></td>
      </tr>
      <tr>
        <td><?php echo $entry_tax; ?></td>
        <td><?php if ($config_tax) { ?>
          <input type="radio" name="config_tax" value="1" checked="checked" />
          <?php echo $text_yes; ?>
          <input type="radio" name="config_tax" value="0" />
          <?php echo $text_no; ?>
          <?php } else { ?>
          <input type="radio" name="config_tax" value="1" />
          <?php echo $text_yes; ?>
          <input type="radio" name="config_tax" value="0" checked="checked" />
          <?php echo $text_no; ?>
          <?php } ?></td>
      </tr>
      <tr>
        <td><?php echo $entry_measurement_class; ?></td>
        <td><select name="config_measurement_class_id">
            <?php foreach ($measurement_classes as $measurement_class) { ?>
            <?php if ($measurement_class['measurement_class_id'] == $config_measurement_class_id) { ?>
            <option value="<?php echo $measurement_class['measurement_class_id']; ?>" selected="selected"><?php echo $measurement_class['title']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $measurement_class['measurement_class_id']; ?>"><?php echo $measurement_class['title']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td>
      </tr>
      <tr>
        <td><?php echo $entry_weight_class; ?></td>
        <td><select name="config_weight_class_id">
            <?php foreach ($weight_classes as $weight_class) { ?>
            <?php if ($weight_class['weight_class_id'] == $config_weight_class_id) { ?>
            <option value="<?php echo $weight_class['weight_class_id']; ?>" selected="selected"><?php echo $weight_class['title']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $weight_class['weight_class_id']; ?>"><?php echo $weight_class['title']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td>
      </tr>
    </table>
  </div>
  <div id="tab_option" class="page">
    <table class="form">
      <tr>
        <td width="25%"><?php echo $entry_alert_mail; ?></td>
        <td><?php if ($config_alert_mail) { ?>
          <input type="radio" name="config_alert_mail" value="1" checked="checked" />
          <?php echo $text_yes; ?>
          <input type="radio" name="config_alert_mail" value="0" />
          <?php echo $text_no; ?>
          <?php } else { ?>
          <input type="radio" name="config_alert_mail" value="1" />
          <?php echo $text_yes; ?>
          <input type="radio" name="config_alert_mail" value="0" checked="checked" />
          <?php echo $text_no; ?>
          <?php } ?></td>
      </tr>
      <tr>
        <td width="25%"><?php echo $entry_alert_mail_for_customer; ?></td>
        <td><?php if ($config_alert_mail_for_customer) { ?>
          <input type="radio" name="config_alert_mail_for_customer" value="1" checked="checked" />
          <?php echo $text_yes; ?>
          <input type="radio" name="config_alert_mail_for_customer" value="0" />
          <?php echo $text_no; ?>
          <?php } else { ?>
          <input type="radio" name="config_alert_mail_for_customer" value="1" />
          <?php echo $text_yes; ?>
          <input type="radio" name="config_alert_mail_for_customer" value="0" checked="checked" />
          <?php echo $text_no; ?>
          <?php } ?></td>
      </tr>
      <tr>
        <td><?php echo $entry_customer_group; ?></td>
        <td><select name="config_customer_group_id">
            <?php foreach ($customer_groups as $customer_group) { ?>
            <?php if ($customer_group['customer_group_id'] == $config_customer_group_id) { ?>
            <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td>
      </tr>
      <tr>
        <td><?php echo $entry_customer_price; ?></td>
        <td><?php if ($config_customer_price) { ?>
          <input type="radio" name="config_customer_price" value="1" checked="checked" />
          <?php echo $text_yes; ?>
          <input type="radio" name="config_customer_price" value="0" />
          <?php echo $text_no; ?>
          <?php } else { ?>
          <input type="radio" name="config_customer_price" value="1" />
          <?php echo $text_yes; ?>
          <input type="radio" name="config_customer_price" value="0" checked="checked" />
          <?php echo $text_no; ?>
          <?php } ?></td>
      </tr>
      <tr>
        <td><?php echo $entry_customer_approval; ?></td>
        <td><?php if ($config_customer_approval) { ?>
          <input type="radio" name="config_customer_approval" value="1" checked="checked" />
          <?php echo $text_yes; ?>
          <input type="radio" name="config_customer_approval" value="0" />
          <?php echo $text_no; ?>
          <?php } else { ?>
          <input type="radio" name="config_customer_approval" value="1" />
          <?php echo $text_yes; ?>
          <input type="radio" name="config_customer_approval" value="0" checked="checked" />
          <?php echo $text_no; ?>
          <?php } ?></td>
      </tr>
      <tr>
        <td><?php echo $entry_guest_checkout; ?></td>
        <td><?php if ($config_guest_checkout) { ?>
          <input type="radio" name="config_guest_checkout" value="1" checked="checked" />
          <?php echo $text_yes; ?>
          <input type="radio" name="config_guest_checkout" value="0" />
          <?php echo $text_no; ?>
          <?php } else { ?>
          <input type="radio" name="config_guest_checkout" value="1" />
          <?php echo $text_yes; ?>
          <input type="radio" name="config_guest_checkout" value="0" checked="checked" />
          <?php echo $text_no; ?>
          <?php } ?></td>
      </tr>
      <tr>
        <td><?php echo $entry_account; ?></td>
        <td><select name="config_account">
            <option value="0"><?php echo $text_none; ?></option>
            <?php foreach ($informations as $information) { ?>
            <?php if ($information['information_id'] == $config_account) { ?>
            <option value="<?php echo $information['information_id']; ?>" selected="selected"><?php echo $information['title']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $information['information_id']; ?>"><?php echo $information['title']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td>
      </tr>
      <tr>
        <td><?php echo $entry_checkout; ?></td>
        <td><select name="config_checkout">
            <option value="0"><?php echo $text_none; ?></option>
            <?php foreach ($informations as $information) { ?>
            <?php if ($information['information_id'] == $config_checkout) { ?>
            <option value="<?php echo $information['information_id']; ?>" selected="selected"><?php echo $information['title']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $information['information_id']; ?>"><?php echo $information['title']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td>
      </tr>
      <tr>
        <td><?php echo $entry_stock_display; ?></td>
        <td><?php if ($config_stock_display) { ?>
          <input type="radio" name="config_stock_display" value="1" checked="checked" />
          <?php echo $text_yes; ?>
          <input type="radio" name="config_stock_display" value="0" />
          <?php echo $text_no; ?>
          <?php } else { ?>
          <input type="radio" name="config_stock_display" value="1" />
          <?php echo $text_yes; ?>
          <input type="radio" name="config_stock_display" value="0" checked="checked" />
          <?php echo $text_no; ?>
          <?php } ?></td>
      </tr>
      <tr>
        <td><?php echo $entry_stock_check; ?></td>
        <td><?php if ($config_stock_check) { ?>
          <input type="radio" name="config_stock_check" value="1" checked="checked" />
          <?php echo $text_yes; ?>
          <input type="radio" name="config_stock_check" value="0" />
          <?php echo $text_no; ?>
          <?php } else { ?>
          <input type="radio" name="config_stock_check" value="1" />
          <?php echo $text_yes; ?>
          <input type="radio" name="config_stock_check" value="0" checked="checked" />
          <?php echo $text_no; ?>
          <?php } ?></td>
      </tr>
      <tr>
        <td><?php echo $entry_stock_checkout; ?></td>
        <td><?php if ($config_stock_checkout) { ?>
          <input type="radio" name="config_stock_checkout" value="1" checked="checked" />
          <?php echo $text_yes; ?>
          <input type="radio" name="config_stock_checkout" value="0" />
          <?php echo $text_no; ?>
          <?php } else { ?>
          <input type="radio" name="config_stock_checkout" value="1" />
          <?php echo $text_yes; ?>
          <input type="radio" name="config_stock_checkout" value="0" checked="checked" />
          <?php echo $text_no; ?>
          <?php } ?></td>
      </tr>
      <tr>
        <td><?php echo $entry_stock_subtract; ?></td>
        <td><?php if ($config_stock_subtract) { ?>
          <input type="radio" name="config_stock_subtract" value="1" checked="checked" />
          <?php echo $text_yes; ?>
          <input type="radio" name="config_stock_subtract" value="0" />
          <?php echo $text_no; ?>
          <?php } else { ?>
          <input type="radio" name="config_stock_subtract" value="1" />
          <?php echo $text_yes; ?>
          <input type="radio" name="config_stock_subtract" value="0" checked="checked" />
          <?php echo $text_no; ?>
          <?php } ?></td>
      </tr>
      <tr>
        <td><?php echo $entry_order_status; ?></td>
        <td><select name="config_order_status_id">
            <?php foreach ($order_statuses as $order_status) { ?>
            <?php if ($order_status['order_status_id'] == $config_order_status_id) { ?>
            <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td>
      </tr>
      <tr>
        <td><?php echo $entry_stock_status; ?></td>
        <td><select name="config_stock_status_id">
            <?php foreach ($stock_statuses as $stock_status) { ?>
            <?php if ($stock_status['stock_status_id'] == $config_stock_status_id) { ?>
            <option value="<?php echo $stock_status['stock_status_id']; ?>" selected="selected"><?php echo $stock_status['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $stock_status['stock_status_id']; ?>"><?php echo $stock_status['name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td>
      </tr>
      <tr>
        <td><?php echo $entry_download; ?></td>
        <td><?php if ($config_download) { ?>
          <input type="radio" name="config_download" value="1" checked="checked" />
          <?php echo $text_yes; ?>
          <input type="radio" name="config_download" value="0" />
          <?php echo $text_no; ?>
          <?php } else { ?>
          <input type="radio" name="config_download" value="1" />
          <?php echo $text_yes; ?>
          <input type="radio" name="config_download" value="0" checked="checked" />
          <?php echo $text_no; ?>
          <?php } ?></td>
      </tr>
      <tr>
        <td><?php echo $entry_download_status; ?></td>
        <td><select name="config_download_status">
            <?php foreach ($order_statuses as $order_status) { ?>
            <?php if ($order_status['order_status_id'] == $config_download_status) { ?>
            <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td>
      </tr>
      <tr>
        <td><span class="required">*</span> <?php echo $entry_sborka_cost_per_hour; ?></td>
        <td><input type="text" name="config_sborka_cost_per_hour" value="<?php echo $config_sborka_cost_per_hour; ?>" size="5" />
      </tr>
      <tr>
        <td><?php echo $entry_default_credit; ?></td>
        <td><select name="config_default_credit_id">
            <option value="0"><?php echo $text_none; ?></option>
            <?php foreach ($credits as $credit) { ?>
            <?php if ($credit['credit_id'] == $config_default_credit_id) { ?>
            <option value="<?php echo $credit['credit_id']; ?>" selected="selected"><?php echo $credit['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $credit['credit_id']; ?>"><?php echo $credit['name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td>
      </tr>
      <tr>
        <td><?php echo $entry_min_price_warranty_page; ?></td>
        <td><select name="config_min_price_warranty_page">
            <option value="0"><?php echo $text_none; ?></option>
            <?php foreach ($informations as $information) { ?>
            <?php if ($information['information_id'] == $config_min_price_warranty_page) { ?>
            <option value="<?php echo $information['information_id']; ?>" selected="selected"><?php echo $information['title']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $information['information_id']; ?>"><?php echo $information['title']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td>
      </tr>
    </table>
  </div>
  <div id="tab_image" class="page">
    <table class="form">
      <tr>
        <td width="25%"><?php echo $entry_logo; ?></td>
        <td><input type="file" name="config_logo"  size="80" />
          <input type="hidden" name="config_logo" value="<?php echo $config_logo; ?>" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><img src="<?php echo $preview_logo; ?>" alt="" style="margin: 4px 0px; border: 1px solid #EEEEEE;" /></td>
      </tr>
      <tr>
        <td width="25%"><?php echo $entry_icon; ?></td>
        <td><input type="file" name="config_icon"  size="80" />
          <input type="hidden" name="config_icon" value="<?php echo $config_icon; ?>" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><img src="<?php echo $preview_icon; ?>" alt="" style="margin: 4px 0px; border: 1px solid #EEEEEE;" /></td>
      </tr>
      <tr>
        <td width="25%"><?php echo $entry_icon_24; ?></td>
        <td><input type="file" name="config_icon_24"  size="80" />
          <input type="hidden" name="config_icon_24" value="<?php echo $config_icon_24; ?>" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><img src="<?php echo $preview_icon_24; ?>" alt="" style="margin: 4px 0px; border: 1px solid #EEEEEE;" /></td>
      </tr>
      <tr>
        <td><?php echo $entry_image_icon_24; ?></td>
        <td><input type="text" name="config_icon_24_width" value="<?php echo $config_icon_24_width; ?>" size="3" />
          x
          <input type="text" name="config_icon_24_height" value="<?php echo $config_icon_24_height; ?>" size="3" /></td>
      </tr>
      <tr>
        <td><?php echo $entry_image_icon_24_cat; ?></td>
        <td><input type="text" name="config_icon_24_cat_width" value="<?php echo $config_icon_24_cat_width; ?>" size="3" />
          x
          <input type="text" name="config_icon_24_cat_height" value="<?php echo $config_icon_24_cat_height; ?>" size="3" /></td>
      </tr>
      <tr>
        <td width="25%"><?php echo $entry_image_icon_24_pos; ?></td>
        <td><select name="config_icon_24_pos">
            <?php if ($config_icon_24_pos == 'topleft') { ?>
            <option value="topleft" selected="selected"><?php echo $text_topleft; ?></option>
            <?php } else { ?>
            <option value="topleft"><?php echo $text_topleft; ?></option>
            <?php } ?>
            <?php if ($config_icon_24_pos == 'topright') { ?>
            <option value="topright" selected="selected"><?php echo $text_topright; ?></option>
            <?php } else { ?>
            <option value="topright"><?php echo $text_topright; ?></option>
            <?php } ?>
            <?php if ($config_icon_24_pos == 'bottomleft') { ?>
            <option value="bottomleft" selected="selected"><?php echo $text_bottomleft; ?></option>
            <?php } else { ?>
            <option value="bottomleft"><?php echo $text_bottomleft; ?></option>
            <?php } ?>
            <?php if ($config_icon_24_pos == 'bottomright') { ?>
            <option value="bottomright" selected="selected"><?php echo $text_bottomright; ?></option>
            <?php } else { ?>
            <option value="bottomright"><?php echo $text_bottomright; ?></option>
            <?php } ?>
          </select></td>
      </tr>
      <tr>
        <td><?php echo $entry_image_icon_24_offset; ?></td>
        <td><input type="text" name="config_icon_24_top_offset" value="<?php echo $config_icon_24_top_offset; ?>" size="3" />
          x
          <input type="text" name="config_icon_24_right_offset" value="<?php echo $config_icon_24_right_offset; ?>" size="3" />
          x
          <input type="text" name="config_icon_24_bottom_offset" value="<?php echo $config_icon_24_bottom_offset; ?>" size="3" />
          x
          <input type="text" name="config_icon_24_left_offset" value="<?php echo $config_icon_24_left_offset; ?>" size="3" />
        </td>
      </tr>
      <tr>
        <td width="25%"><?php echo $entry_icon_new; ?></td>
        <td><input type="file" name="config_icon_new"  size="80" />
          <input type="hidden" name="config_icon_new" value="<?php echo $config_icon_new; ?>" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><img src="<?php echo $preview_icon_new; ?>" alt="" style="margin: 4px 0px; border: 1px solid #EEEEEE;" /></td>
      </tr>
      <tr>
        <td><?php echo $entry_image_icon_new; ?></td>
        <td><input type="text" name="config_icon_new_width" value="<?php echo $config_icon_new_width; ?>" size="3" />
          x
          <input type="text" name="config_icon_new_height" value="<?php echo $config_icon_new_height; ?>" size="3" /></td>
      </tr>
      <tr>
        <td><?php echo $entry_image_icon_new_cat; ?></td>
        <td><input type="text" name="config_icon_new_cat_width" value="<?php echo $config_icon_new_cat_width; ?>" size="3" />
          x
          <input type="text" name="config_icon_new_cat_height" value="<?php echo $config_icon_new_cat_height; ?>" size="3" /></td>
      </tr>
      <tr>
        <td width="25%"><?php echo $entry_image_icon_new_pos; ?></td>
        <td><select name="config_icon_new_pos">
            <?php if ($config_icon_new_pos == 'topleft') { ?>
            <option value="topleft" selected="selected"><?php echo $text_topleft; ?></option>
            <?php } else { ?>
            <option value="topleft"><?php echo $text_topleft; ?></option>
            <?php } ?>
            <?php if ($config_icon_new_pos == 'topright') { ?>
            <option value="topright" selected="selected"><?php echo $text_topright; ?></option>
            <?php } else { ?>
            <option value="topright"><?php echo $text_topright; ?></option>
            <?php } ?>
            <?php if ($config_icon_new_pos == 'bottomleft') { ?>
            <option value="bottomleft" selected="selected"><?php echo $text_bottomleft; ?></option>
            <?php } else { ?>
            <option value="bottomleft"><?php echo $text_bottomleft; ?></option>
            <?php } ?>
            <?php if ($config_icon_new_pos == 'bottomright') { ?>
            <option value="bottomright" selected="selected"><?php echo $text_bottomright; ?></option>
            <?php } else { ?>
            <option value="bottomright"><?php echo $text_bottomright; ?></option>
            <?php } ?>
          </select></td>
      </tr>
      <tr>
        <td><?php echo $entry_image_icon_new_offset; ?></td>
        <td><input type="text" name="config_icon_new_top_offset" value="<?php echo $config_icon_new_top_offset; ?>" size="3" />
          x
          <input type="text" name="config_icon_new_right_offset" value="<?php echo $config_icon_new_right_offset; ?>" size="3" />
          x
          <input type="text" name="config_icon_new_bottom_offset" value="<?php echo $config_icon_new_bottom_offset; ?>" size="3" />
          x
          <input type="text" name="config_icon_new_left_offset" value="<?php echo $config_icon_new_left_offset; ?>" size="3" />
        </td>
      </tr>
      <tr>
        <td width="25%"><?php echo $entry_icon_5; ?></td>
        <td><input type="file" name="config_icon_5"  size="80" />
          <input type="hidden" name="config_icon_5" value="<?php echo $config_icon_5; ?>" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><img src="<?php echo $preview_icon_5; ?>" alt="" style="margin: 4px 0px; border: 1px solid #EEEEEE;" /></td>
      </tr>
      <tr>
        <td><?php echo $entry_image_icon_5; ?></td>
        <td><input type="text" name="config_icon_5_width" value="<?php echo $config_icon_5_width; ?>" size="3" />
          x
          <input type="text" name="config_icon_5_height" value="<?php echo $config_icon_5_height; ?>" size="3" /></td>
      </tr>
      <tr>
        <td><?php echo $entry_image_icon_5_cat; ?></td>
        <td><input type="text" name="config_icon_5_cat_width" value="<?php echo $config_icon_5_cat_width; ?>" size="3" />
          x
          <input type="text" name="config_icon_5_cat_height" value="<?php echo $config_icon_5_cat_height; ?>" size="3" /></td>
      </tr>
      <tr>
        <td width="25%"><?php echo $entry_image_icon_5_pos; ?></td>
        <td><select name="config_icon_5_pos">
            <?php if ($config_icon_5_pos == 'topleft') { ?>
            <option value="topleft" selected="selected"><?php echo $text_topleft; ?></option>
            <?php } else { ?>
            <option value="topleft"><?php echo $text_topleft; ?></option>
            <?php } ?>
            <?php if ($config_icon_5_pos == 'topright') { ?>
            <option value="topright" selected="selected"><?php echo $text_topright; ?></option>
            <?php } else { ?>
            <option value="topright"><?php echo $text_topright; ?></option>
            <?php } ?>
            <?php if ($config_icon_5_pos == 'bottomleft') { ?>
            <option value="bottomleft" selected="selected"><?php echo $text_bottomleft; ?></option>
            <?php } else { ?>
            <option value="bottomleft"><?php echo $text_bottomleft; ?></option>
            <?php } ?>
            <?php if ($config_icon_5_pos == 'bottomright') { ?>
            <option value="bottomright" selected="selected"><?php echo $text_bottomright; ?></option>
            <?php } else { ?>
            <option value="bottomright"><?php echo $text_bottomright; ?></option>
            <?php } ?>
          </select></td>
      </tr>
      <tr>
        <td><?php echo $entry_image_icon_5_offset; ?></td>
        <td><input type="text" name="config_icon_5_top_offset" value="<?php echo $config_icon_5_top_offset; ?>" size="3" />
          x
          <input type="text" name="config_icon_5_right_offset" value="<?php echo $config_icon_5_right_offset; ?>" size="3" />
          x
          <input type="text" name="config_icon_5_bottom_offset" value="<?php echo $config_icon_5_bottom_offset; ?>" size="3" />
          x
          <input type="text" name="config_icon_5_left_offset" value="<?php echo $config_icon_5_left_offset; ?>" size="3" />
        </td>
      </tr>
      <tr><td>&nbsp;</td></tr>
      <tr>
        <td><?php echo $entry_image_thumb; ?></td>
        <td><input type="text" name="config_image_thumb_width" value="<?php echo $config_image_thumb_width; ?>" size="3" />
          x
          <input type="text" name="config_image_thumb_height" value="<?php echo $config_image_thumb_height; ?>" size="3" /></td>
      </tr>
      <tr>
        <td width="25%"><?php echo $entry_image_popup; ?></td>
        <td><input type="text" name="config_image_popup_width" value="<?php echo $config_image_popup_width; ?>" size="3" />
          x
          <input type="text" name="config_image_popup_height" value="<?php echo $config_image_popup_height; ?>" size="3" /></td>
      </tr>
      <tr>
        <td width="25%"><?php echo $entry_image_category; ?></td>
        <td><input type="text" name="config_image_category_width" value="<?php echo $config_image_category_width; ?>" size="3" />
          x
          <input type="text" name="config_image_category_height" value="<?php echo $config_image_category_height; ?>" size="3" /></td>
      </tr>
      <tr>
        <td width="25%"><?php echo $entry_image_category_dops; ?></td>
        <td><input type="text" name="config_image_category_dops_width" value="<?php echo $config_image_category_dops_width; ?>" size="3" />
          x
          <input type="text" name="config_image_category_dops_height" value="<?php echo $config_image_category_dops_height; ?>" size="3" /></td>
      </tr>
      <tr>
        <td width="25%"><?php echo $entry_image_product; ?></td>
        <td><input type="text" name="config_image_product_width" value="<?php echo $config_image_product_width; ?>" size="3" />
          x
          <input type="text" name="config_image_product_height" value="<?php echo $config_image_product_height; ?>" size="3" /></td>
      </tr>
      <tr>
        <td width="25%"><?php echo $entry_image_additional; ?></td>
        <td><input type="text" name="config_image_additional_width" value="<?php echo $config_image_additional_width; ?>" size="3" />
          x
          <input type="text" name="config_image_additional_height" value="<?php echo $config_image_additional_height; ?>" size="3" /></td>
      </tr>
      <tr>
        <td width="25%"><?php echo $entry_image_related; ?></td>
        <td><input type="text" name="config_image_related_width" value="<?php echo $config_image_related_width; ?>" size="3" />
          x
          <input type="text" name="config_image_related_height" value="<?php echo $config_image_related_height; ?>" size="3" /></td>
      </tr>
      <tr>
        <td width="25%"><?php echo $entry_image_cart; ?></td>
        <td><input type="text" name="config_image_cart_width" value="<?php echo $config_image_cart_width; ?>" size="3" />
          x
          <input type="text" name="config_image_cart_height" value="<?php echo $config_image_cart_height; ?>" size="3" /></td>
      </tr>
    </table>
  </div>
  <div id="tab_mail" class="page">
    <table class="form">
      <tr>
        <td width="25%"><?php echo $entry_mail_protocol; ?></td>
        <td><select name="config_mail_protocol">
            <?php if ($config_mail_protocol == 'mail') { ?>
            <option value="mail" selected="selected"><?php echo $text_mail; ?></option>
            <?php } else { ?>
            <option value="mail"><?php echo $text_mail; ?></option>
            <?php } ?>
            <?php if ($config_mail_protocol == 'smtp') { ?>
            <option value="smtp" selected="selected"><?php echo $text_smtp; ?></option>
            <?php } else { ?>
            <option value="smtp"><?php echo $text_smtp; ?></option>
            <?php } ?>
            <?php if ($config_mail_protocol == 'swift') { ?>
            <option value="swift" selected="selected"><?php echo $text_swift; ?></option>
            <?php } else { ?>
            <option value="swift"><?php echo $text_swift; ?></option>
            <?php } ?>
          </select></td>
      </tr>
      <tr>
        <td><?php echo $entry_smtp_host; ?></td>
        <td><input type="text" name="config_smtp_host" value="<?php echo $config_smtp_host; ?>" /></td>
      </tr>
      <tr>
        <td><?php echo $entry_smtp_username; ?></td>
        <td><input type="text" name="config_smtp_username" value="<?php echo $config_smtp_username; ?>" /></td>
      </tr>
      <tr>
        <td><?php echo $entry_smtp_password; ?></td>
        <td><input type="text" name="config_smtp_password" value="<?php echo $config_smtp_password; ?>" /></td>
      </tr>
      <tr>
        <td><?php echo $entry_smtp_port; ?></td>
        <td><input type="text" name="config_smtp_port" value="<?php echo $config_smtp_port; ?>" /></td>
      </tr>
      <tr>
        <td><?php echo $entry_smtp_timeout; ?></td>
        <td><input type="text" name="config_smtp_timeout" value="<?php echo $config_smtp_timeout; ?>" /></td>
      </tr>
    </table>
  </div>
  <div id="tab_server" class="page">
    <table class="form">
      <tr>
        <td width="25%"><?php echo $entry_ssl; ?></td>
        <td><?php if ($config_ssl) { ?>
          <input type="radio" name="config_ssl" value="1" checked="checked" />
          <?php echo $text_yes; ?>
          <input type="radio" name="config_ssl" value="0" />
          <?php echo $text_no; ?>
          <?php } else { ?>
          <input type="radio" name="config_ssl" value="1" />
          <?php echo $text_yes; ?>
          <input type="radio" name="config_ssl" value="0" checked="checked" />
          <?php echo $text_no; ?>
          <?php } ?></td>
      </tr>
      <tr>
        <td><span class="required">*</span> <?php echo $entry_encryption; ?></td>
        <td><input type="text" name="config_encryption" value="<?php echo $config_encryption; ?>" /></td>
      </tr>
      <tr>
        <td><?php echo $entry_seo_url; ?></td>
        <td><?php if ($config_seo_url) { ?>
          <input type="radio" name="config_seo_url" value="1" checked="checked" />
          <?php echo $text_yes; ?>
          <input type="radio" name="config_seo_url" value="0" />
          <?php echo $text_no; ?>
          <?php } else { ?>
          <input type="radio" name="config_seo_url" value="1" />
          <?php echo $text_yes; ?>
          <input type="radio" name="config_seo_url" value="0" checked="checked" />
          <?php echo $text_no; ?>
          <?php } ?></td>
      </tr>
      <tr>
        <td><?php echo $entry_compression; ?></td>
        <td><input type="text" name="config_compression" value="<?php echo $config_compression; ?>" size="3" /></td>
      </tr>
      <tr>
        <td><?php echo $entry_error_display; ?></td>
        <td><?php if ($config_error_display) { ?>
          <input type="radio" name="config_error_display" value="1" checked="checked" />
          <?php echo $text_yes; ?>
          <input type="radio" name="config_error_display" value="0" />
          <?php echo $text_no; ?>
          <?php } else { ?>
          <input type="radio" name="config_error_display" value="1" />
          <?php echo $text_yes; ?>
          <input type="radio" name="config_error_display" value="0" checked="checked" />
          <?php echo $text_no; ?>
          <?php } ?></td>
      </tr>
      <tr>
        <td><?php echo $entry_error_log; ?></td>
        <td><?php if ($config_error_log) { ?>
          <input type="radio" name="config_error_log" value="1" checked="checked" />
          <?php echo $text_yes; ?>
          <input type="radio" name="config_error_log" value="0" />
          <?php echo $text_no; ?>
          <?php } else { ?>
          <input type="radio" name="config_error_log" value="1" />
          <?php echo $text_yes; ?>
          <input type="radio" name="config_error_log" value="0" checked="checked" />
          <?php echo $text_no; ?>
          <?php } ?></td>
      </tr>
      <tr>
        <td><span class="required">*</span> <?php echo $entry_error_filename; ?></td>
        <td><input type="text" name="config_error_filename" value="<?php echo $config_error_filename; ?>" />
          <br />
          <?php if ($error_error_filename) { ?>
          <span class="error"><?php echo $error_error_filename; ?></span>
          <?php } ?></td>
      </tr>
    </table>
  </div>
  <div id="tab_banners" class="page">
    <table class="form">
     <tr>
        <td><?php echo $entry_slideshow_display; ?></td>
        <td><?php if ($slideshow_display_on_home) { ?>
          <input type="radio" name="slideshow_display_on_home" value="1" checked="checked" />
          <?php echo $text_yes; ?>
          <input type="radio" name="slideshow_display_on_home" value="0" />
          <?php echo $text_no; ?>
          <?php } else { ?>
          <input type="radio" name="slideshow_display_on_home" value="1" />
          <?php echo $text_yes; ?>
          <input type="radio" name="slideshow_display_on_home" value="0" checked="checked" />
          <?php echo $text_no; ?>
          <?php } ?></td>
      </tr>
     <tr>
        <td><?php echo $entry_slideshow_width_heigth; ?></td>
        <td><input type="text" name="config_slideshow_width" value="<?php echo $config_slideshow_width; ?>" size="3" />
          x
          <input type="text" name="config_slideshow_height" value="<?php echo $config_slideshow_height; ?>" size="3" /></td>
      </tr>
      <tr>
          <td><?php echo $entry_slideshow_delay; ?></td>
          <td><input type="text" name="config_slideshow_delay" value="<?php echo $config_slideshow_delay; ?>" size="4" /></td>
        </tr>
      <tr>
        <td><?php echo $entry_left_top_banner_dislpay; ?></td>
        <td><?php if ($config_left_top_banner_display) { ?>
          <input type="radio" name="config_left_top_banner_display" value="1" checked="checked" />
          <?php echo $text_yes; ?>
          <input type="radio" name="config_left_top_banner_display" value="0" />
          <?php echo $text_no; ?>
          <?php } else { ?>
          <input type="radio" name="config_left_top_banner_display" value="1" />
          <?php echo $text_yes; ?>
          <input type="radio" name="config_left_top_banner_display" value="0" checked="checked" />
          <?php echo $text_no; ?>
          <?php } ?></td>
      </tr>
      <tr>
        <td width="25%"><?php echo $entry_left_top_banner; ?></td>
        <td><input type="file" name="config_left_top_banner"  size="80" />
          <input type="hidden" name="config_left_top_banner" value="<?php echo $config_left_top_banner; ?>" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>
          <?php if ($config_left_top_banner_ext == 'swf') { ?>
            <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="340" height="170">
              <param name="movie" value="<?php echo $preview_left_top_banner; ?>" />
              <param name="scale" value="noborder" />
              <param name="quality" value="high" />
              <param name="wmode" value="transparent">
              <embed src="<?php echo $preview_left_top_banner; ?>" wmode="transparent" quality="high" menu="false" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="205" height="340"></embed>
            </object>
          <?php } else {?>
            <img src="<?php echo $preview_left_top_banner; ?>" alt="" style="margin: 4px 0px; border: 1px solid #EEEEEE;" />
          <?php } ?>
        </td>
      </tr>
      <tr>
        <td><?php echo $entry_left_top_banner_url; ?></td>
        <td><input type="text" name="config_left_top_banner_url" value="<?php echo $config_left_top_banner_url; ?>" size="80" /></td>
      </tr>
      <tr>
        <td><?php echo $entry_right_top_banner_dislpay; ?></td>
        <td><?php if ($config_right_top_banner_display) { ?>
          <input type="radio" name="config_right_top_banner_display" value="1" checked="checked" />
          <?php echo $text_yes; ?>
          <input type="radio" name="config_right_top_banner_display" value="0" />
          <?php echo $text_no; ?>
          <?php } else { ?>
          <input type="radio" name="config_right_top_banner_display" value="1" />
          <?php echo $text_yes; ?>
          <input type="radio" name="config_right_top_banner_display" value="0" checked="checked" />
          <?php echo $text_no; ?>
          <?php } ?></td>
      </tr>
      <tr>
        <td width="25%"><?php echo $entry_right_top_banner; ?></td>
        <td><input type="file" name="config_right_top_banner"  size="80" />
          <input type="hidden" name="config_right_top_banner" value="<?php echo $config_right_top_banner; ?>" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>
          <?php if ($config_right_top_banner_ext == 'swf') { ?>
            <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="340" height="170">
              <param name="movie" value="<?php echo $preview_right_top_banner; ?>" />
              <param name="scale" value="noborder" />
              <param name="quality" value="high" />
              <param name="wmode" value="transparent">
              <embed src="<?php echo $preview_right_top_banner; ?>" wmode="transparent" quality="high" menu="false" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="340" height="170"></embed>
            </object>
          <?php } else {?>
            <img src="<?php echo $preview_right_top_banner; ?>" alt="" style="margin: 4px 0px; border: 1px solid #EEEEEE;" />
          <?php } ?>
        </td>
      </tr>
      <tr>
        <td><?php echo $entry_right_top_banner_url; ?></td>
        <td><input type="text" name="config_right_top_banner_url" value="<?php echo $config_right_top_banner_url; ?>" size="80" /></td>
      </tr>

      <tr>
        <td><?php echo $entry_banner_dislpay; ?></td>
        <td><?php if ($config_banner_display) { ?>
          <input type="radio" name="config_banner_display" value="1" checked="checked" />
          <?php echo $text_yes; ?>
          <input type="radio" name="config_banner_display" value="0" />
          <?php echo $text_no; ?>
          <?php } else { ?>
          <input type="radio" name="config_banner_display" value="1" />
          <?php echo $text_yes; ?>
          <input type="radio" name="config_banner_display" value="0" checked="checked" />
          <?php echo $text_no; ?>
          <?php } ?></td>
      </tr>
      <tr>
        <td width="25%"><?php echo $entry_banner; ?></td>
        <td><input type="file" name="config_banner"  size="80" />
          <input type="hidden" name="config_banner" value="<?php echo $config_banner; ?>" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>
          <?php if ($config_banner_ext == 'swf') { ?>
            <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="230" height="125">
              <param name="movie" value="<?php echo $preview_banner; ?>" />
              <param name="scale" value="noborder" />
              <param name="quality" value="high" />
              <param name="wmode" value="transparent">
              <embed src="<?php echo $preview_banner; ?>" wmode="transparent" quality="high" menu="false" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="230" height="125"></embed>
            </object>
          <?php } else {?>
            <img src="<?php echo $preview_banner; ?>" alt="" style="margin: 4px 0px; border: 1px solid #EEEEEE;" />
          <?php } ?>
        </td>
      </tr>
      <tr>
        <td><?php echo $entry_banner_url; ?></td>
        <td><input type="text" name="config_banner_url" value="<?php echo $config_banner_url; ?>" size="80" /></td>
      </tr>

      <tr>
        <td><?php echo $entry_second_banner_dislpay; ?></td>
        <td><?php if ($config_second_banner_display) { ?>
          <input type="radio" name="config_second_banner_display" value="1" checked="checked" />
          <?php echo $text_yes; ?>
          <input type="radio" name="config_second_banner_display" value="0" />
          <?php echo $text_no; ?>
          <?php } else { ?>
          <input type="radio" name="config_second_banner_display" value="1" />
          <?php echo $text_yes; ?>
          <input type="radio" name="config_second_banner_display" value="0" checked="checked" />
          <?php echo $text_no; ?>
          <?php } ?></td>
      </tr>
      <tr>
        <td width="25%"><?php echo $entry_second_banner; ?></td>
        <td><input type="file" name="config_second_banner"  size="80" />
          <input type="hidden" name="config_second_banner" value="<?php echo $config_second_banner; ?>" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>
          <?php if ($config_second_banner_ext == 'swf') { ?>
            <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="230" height="125">
              <param name="movie" value="<?php echo $preview_second_banner; ?>" />
              <param name="scale" value="noborder" />
              <param name="quality" value="high" />
              <param name="wmode" value="transparent">
              <embed src="<?php echo $preview_second_banner; ?>" wmode="transparent" quality="high" menu="false" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="230" height="125"></embed>
            </object>
          <?php } else {?>
            <img src="<?php echo $preview_second_banner; ?>" alt="" style="margin: 4px 0px; border: 1px solid #EEEEEE;" />
          <?php } ?>
        </td>
      </tr>
      <tr>
        <td><?php echo $entry_second_banner_url; ?></td>
        <td><input type="text" name="config_second_banner_url" value="<?php echo $config_second_banner_url; ?>" size="80" /></td>
      </tr>

    </table>
  </div>
</form>
<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script>
<script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
CKEDITOR.replace('description<?php echo $language['language_id']; ?>');
CKEDITOR.replace('bottom_message<?php echo $language['language_id']; ?>');
CKEDITOR.replace('contacts_extra<?php echo $language['language_id']; ?>');
<?php } ?>	
//--></script>
<script type="text/javascript"><!--
$('#template').load('index.php?route=setting/setting/template&template=' + encodeURIComponent($('select[name=\'config_template\']').attr('value')));

$('#zone').load('index.php?route=setting/setting/zone&country_id=' + $('#country').attr('value') + '&zone_id=<?php echo $config_zone_id; ?>');

$('#country_id').attr('value', '<?php echo $config_country_id; ?>');
$('#zone_id').attr('value', '<?php echo $config_zone_id; ?>');
//--></script>
<script type="text/javascript"><!--
$.tabs('.tabs a'); 
//--></script>
<?php echo $footer; ?>