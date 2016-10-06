<?php
class ControllerSettingSetting extends Controller {
 private $error = array();
 
 public function index() { 
  $this->load->language('setting/setting'); 

  $this->document->title = $this->language->get('heading_title');
  
  $this->load->model('setting/setting');
  
  if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
   $data = array();
   
   if (is_uploaded_file($this->request->files['config_logo']['tmp_name']) && is_writable(DIR_IMAGE) && is_writable(DIR_IMAGE . 'cache/')) {
    move_uploaded_file($this->request->files['config_logo']['tmp_name'], DIR_IMAGE . strtolower(translite($this->request->files['config_logo']['name'])));
    
    if (file_exists(DIR_IMAGE . strtolower(translite($this->request->files['config_logo']['name'])))) {
     $data['config_logo'] = strtolower(translite($this->request->files['config_logo']['name']));
    }    
   }

   if (is_uploaded_file($this->request->files['config_icon']['tmp_name']) && is_writable(DIR_IMAGE) && is_writable(DIR_IMAGE . 'cache/')) {
    move_uploaded_file($this->request->files['config_icon']['tmp_name'], DIR_IMAGE . strtolower(translite($this->request->files['config_icon']['name'])));

    if (file_exists(DIR_IMAGE . strtolower(translite($this->request->files['config_icon']['name'])))) {
     $data['config_icon'] = strtolower(translite($this->request->files['config_icon']['name']));
    } 
   }

   //(+) ALNAUA 100120 Banner Upload (START)
   if (is_uploaded_file($this->request->files['config_banner']['tmp_name']) && is_writable(DIR_IMAGE . 'akcija/') && is_writable(DIR_IMAGE . 'cache/')) {
     move_uploaded_file($this->request->files['config_banner']['tmp_name'], DIR_IMAGE . 'akcija/' . 'right_bottom' .substr($this->request->files['config_banner']['name'], strlen($this->request->files['config_banner']['name'])-4, 4));

    if (file_exists(DIR_IMAGE . 'akcija/' . 'right_bottom' .substr($this->request->files['config_banner']['name'], strlen($this->request->files['config_banner']['name'])-4, 4))) {
     $data['config_banner'] = 'right_bottom' . substr($this->request->files['config_banner']['name'], strlen($this->request->files['config_banner']['name'])-4, 4);
                    $data['config_banner_ext'] = substr($this->request->files['config_banner']['name'], strlen($this->request->files['config_banner']['name'])-3, 3);

    }
   }
   // (+) ALNAUA 100120 Banner Upload (FINISH)
   // 100217 ALNAUA Second right-bottom banner Begin
   if (is_uploaded_file($this->request->files['config_second_banner']['tmp_name']) && is_writable(DIR_IMAGE . 'akcija/') && is_writable(DIR_IMAGE . 'cache/')) {
     move_uploaded_file($this->request->files['config_second_banner']['tmp_name'], DIR_IMAGE . 'akcija/' . 'right_bottom_second' .substr($this->request->files['config_second_banner']['name'], strlen($this->request->files['config_second_banner']['name'])-4, 4));

    if (file_exists(DIR_IMAGE . 'akcija/' . 'right_bottom_second' .substr($this->request->files['config_second_banner']['name'], strlen($this->request->files['config_second_banner']['name'])-4, 4))) {
     $data['config_second_banner'] = 'right_bottom_second' . substr($this->request->files['config_second_banner']['name'], strlen($this->request->files['config_second_banner']['name'])-4, 4);
                    $data['config_second_banner_ext'] = substr($this->request->files['config_second_banner']['name'], strlen($this->request->files['config_second_banner']['name'])-3, 3);

    }
   }
   // 100217 ALNAUA Second right-bottom banner End
   // 100129 ALNAUA Home Page change, add product sorting, translite russian filename upload Begin
   if (is_uploaded_file($this->request->files['config_left_top_banner']['tmp_name']) && is_writable(DIR_IMAGE . 'akcija/') && is_writable(DIR_IMAGE . 'cache/')) {
    move_uploaded_file($this->request->files['config_left_top_banner']['tmp_name'], DIR_IMAGE . 'akcija/' . 'left_top' .substr($this->request->files['config_left_top_banner']['name'], strlen($this->request->files['config_banner']['name'])-4, 4));

    if (file_exists(DIR_IMAGE . 'akcija/' . 'left_top' .substr($this->request->files['config_left_top_banner']['name'], strlen($this->request->files['config_left_top_banner']['name'])-4, 4))) {
     $data['config_left_top_banner'] = 'left_top' . substr($this->request->files['config_left_top_banner']['name'], strlen($this->request->files['config_left_top_banner']['name'])-4, 4);
                    $data['config_left_top_banner_ext'] = substr($this->request->files['config_left_top_banner']['name'], strlen($this->request->files['config_left_top_banner']['name'])-3, 3);

    }
   }

            if (is_uploaded_file($this->request->files['config_right_top_banner']['tmp_name']) && is_writable(DIR_IMAGE . 'akcija/') && is_writable(DIR_IMAGE . 'cache/')) {
    move_uploaded_file($this->request->files['config_right_top_banner']['tmp_name'], DIR_IMAGE . 'akcija/' . 'right_top' .substr($this->request->files['config_right_top_banner']['name'], strlen($this->request->files['config_right_top_banner']['name'])-4, 4));

    if (file_exists(DIR_IMAGE . 'akcija/' . 'right_top' .substr($this->request->files['config_right_top_banner']['name'], strlen($this->request->files['config_right_top_banner']['name'])-4, 4))) {
     $data['config_right_top_banner'] = 'right_top' . substr($this->request->files['config_right_top_banner']['name'], strlen($this->request->files['config_right_top_banner']['name'])-4, 4);
                    $data['config_right_top_banner_ext'] = substr($this->request->files['config_right_top_banner']['name'], strlen($this->request->files['config_right_top_banner']['name'])-3, 3);

    }
   }
   // 100129 ALNAUA Home Page change, add product sorting, translite russian filename upload End
   // 101115 Add icon layers to products images Begin
   if (is_uploaded_file($this->request->files['config_icon_24']['tmp_name']) && is_writable(DIR_IMAGE) && is_writable(DIR_IMAGE . 'cache/')) {
    move_uploaded_file($this->request->files['config_icon_24']['tmp_name'], DIR_IMAGE . strtolower(translite($this->request->files['config_icon_24']['name'])));

    if (file_exists(DIR_IMAGE . strtolower(translite($this->request->files['config_icon_24']['name'])))) {
     $data['config_icon_24'] = strtolower(translite($this->request->files['config_icon_24']['name']));
    }
   }

   if (is_uploaded_file($this->request->files['config_icon_new']['tmp_name']) && is_writable(DIR_IMAGE) && is_writable(DIR_IMAGE . 'cache/')) {
    move_uploaded_file($this->request->files['config_icon_new']['tmp_name'], DIR_IMAGE . strtolower(translite($this->request->files['config_icon_new']['name'])));

    if (file_exists(DIR_IMAGE . strtolower(translite($this->request->files['config_icon_new']['name'])))) {
     $data['config_icon_new'] = strtolower(translite($this->request->files['config_icon_new']['name']));
    }
   }
   // 101115 Add icon layers to products images End
   // 130829 ET-130815 Begin
   if (is_uploaded_file($this->request->files['config_icon_5']['tmp_name']) && is_writable(DIR_IMAGE) && is_writable(DIR_IMAGE . 'cache/')) {
    move_uploaded_file($this->request->files['config_icon_5']['tmp_name'], DIR_IMAGE . strtolower(translite($this->request->files['config_icon_5']['name'])));

    if (file_exists(DIR_IMAGE . strtolower(translite($this->request->files['config_icon_5']['name'])))) {
     $data['config_icon_5'] = strtolower(translite($this->request->files['config_icon_5']['name']));
    }
   }
   // 130829 ET-130815 End

   
   if ($this->config->get('config_currency_auto')) {
    $this->load->model('localisation/currency');
   
    $this->model_localisation_currency->updateCurrencies();
   }   
   
   $this->model_setting_setting->editSetting('config', array_merge($this->request->post, $data));

   $this->session->data['success'] = $this->language->get('text_success');

   $this->redirect($this->url->https('setting/setting'));
  }

  $this->data['heading_title'] = $this->language->get('heading_title');

  $this->data['text_none'] = $this->language->get('text_none');
  $this->data['text_yes'] = $this->language->get('text_yes');
  $this->data['text_no'] = $this->language->get('text_no');
  $this->data['text_mail'] = $this->language->get('text_mail');
  $this->data['text_smtp'] = $this->language->get('text_smtp');
  // (+) ALNAUA 091114 (START)
  $this->data['text_swift'] = $this->language->get('text_swift');
  // (+) ALNAUA 091114 (FINISH)
  // 101115 Add icon layers to products images Begin
  $this->data['text_topleft'] = $this->language->get('text_topleft');
  $this->data['text_topright'] = $this->language->get('text_topright');
  $this->data['text_bottomleft'] = $this->language->get('text_bottomleft');
  $this->data['text_bottomright'] = $this->language->get('text_bottomright');
  // 101115 Add icon layers to products images End
  
  $this->data['entry_store'] = $this->language->get('entry_store');
  $this->data['entry_title'] = $this->language->get('entry_title');
  $this->data['entry_meta_description'] = $this->language->get('entry_meta_description');
  // (+) ALNAUA 100112 Tags (START)
  $this->data['entry_meta_keywords'] = $this->language->get('entry_meta_keywords');
  // (+) ALNAUA 100112 Tags (FINISH)
  // 100223 ALNAUA Site redesign Begin
  $this->data['entry_contacts_title'] = $this->language->get('entry_contacts_title');
  $this->data['entry_contacts_meta_description'] = $this->language->get('entry_contacts_meta_description');
  $this->data['entry_contacts_meta_keywords'] = $this->language->get('entry_contacts_meta_keywords');
  // 100223 ALNAUA Site redesign End
  // 130415 ET-130411 Begin
  $this->data['entry_slideshow_display'] = $this->language->get('entry_slideshow_display');
  $this->data['entry_slideshow_width_heigth'] = $this->language->get('entry_slideshow_width_heigth');
  // 130415 ET-130411 End
  // ET-150303 Begin
  $this->data['entry_slideshow_delay'] = $this->language->get('entry_slideshow_delay');
  // ET-150303 End
  // 100129 ALNAUA Home Page change, add product sorting, translite russian filename upload Begin
  $this->data['entry_left_top_banner_dislpay'] = $this->language->get('entry_left_top_banner_dislpay');
  $this->data['entry_left_top_banner'] = $this->language->get('entry_left_top_banner');
  $this->data['entry_left_top_banner_url'] = $this->language->get('entry_left_top_banner_url');
  $this->data['entry_right_top_banner_dislpay'] = $this->language->get('entry_right_top_banner_dislpay');
  $this->data['entry_right_top_banner'] = $this->language->get('entry_right_top_banner');
  $this->data['entry_right_top_banner_url'] = $this->language->get('entry_right_top_banner_url');
  $this->data['entry_bottom_message'] = $this->language->get('entry_bottom_message');
  // 130415 ET-130411 Begin
  $this->data['entry_contacts_extra'] = $this->language->get('entry_contacts_extra');
  // 130415 ET-130411 End
  // 100129 ALNAUA Home Page change, add product sorting, translite russian filename upload End
  $this->data['entry_welcome'] = $this->language->get('entry_welcome');
  $this->data['entry_owner'] = $this->language->get('entry_owner');
  $this->data['entry_address'] = $this->language->get('entry_address');
  $this->data['entry_email'] = $this->language->get('entry_email');
  // (+) ALNAUA 091114 (START)
  $this->data['entry_admin_email'] = $this->language->get('entry_admin_email');
  // (+) ALNAUA 091114 (FINISH)
  // 110418 ET-110411 Director Claim Begin
  $this->data['entry_director_email'] = $this->language->get('entry_director_email');
  // 110418 ET-110411 Director Claim End
  // 130226 ET-130226 New email column Begin
  $this->data['entry_bcc_email'] = $this->language->get('entry_bcc_email');
  // 130226 ET-130226 New email column End
  // 110805 ET-110805 Extra Telephone Field Begin
  //$this->data['entry_telephone'] = $this->language->get('entry_telephone');
  $this->data['entry_telephone_left'] = $this->language->get('entry_telephone_left');
  $this->data['entry_telephone_right'] = $this->language->get('entry_telephone_right');
  // 110805 ET-110805 Extra Telephone Field End
  $this->data['entry_fax'] = $this->language->get('entry_fax');
  $this->data['entry_template'] = $this->language->get('entry_template');
  $this->data['entry_country'] = $this->language->get('entry_country');
  $this->data['entry_zone'] = $this->language->get('entry_zone');
  $this->data['entry_language'] = $this->language->get('entry_language');
  $this->data['entry_admin_language'] = $this->language->get('entry_admin_language');
  $this->data['entry_currency'] = $this->language->get('entry_currency');
  $this->data['entry_currency_auto'] = $this->language->get('entry_currency_auto');
  $this->data['entry_tax'] = $this->language->get('entry_tax');
  $this->data['entry_weight_class'] = $this->language->get('entry_weight_class');
  $this->data['entry_measurement_class'] = $this->language->get('entry_measurement_class');
  $this->data['entry_alert_mail'] = $this->language->get('entry_alert_mail');
  // (+) ALNAUA 091114 (START)
  $this->data['entry_alert_mail_for_customer'] = $this->language->get('entry_alert_mail_for_customer');
  $this->data['entry_invoice_data'] = $this->language->get('entry_invoice_data');
  $this->data['entry_nds_invoice_data'] = $this->language->get('entry_nds_invoice_data');
  // (+) ALNAUA 091114 (FINISH)
  $this->data['entry_customer_group'] = $this->language->get('entry_customer_group');
  $this->data['entry_customer_price'] = $this->language->get('entry_customer_price');
  $this->data['entry_customer_approval'] = $this->language->get('entry_customer_approval');
  $this->data['entry_guest_checkout'] = $this->language->get('entry_guest_checkout');
  $this->data['entry_account'] = $this->language->get('entry_account');
  $this->data['entry_checkout'] = $this->language->get('entry_checkout');
  $this->data['entry_order_status'] = $this->language->get('entry_order_status');
  $this->data['entry_stock_display'] = $this->language->get('entry_stock_display');
  $this->data['entry_stock_check'] = $this->language->get('entry_stock_check');
  $this->data['entry_stock_checkout'] = $this->language->get('entry_stock_checkout');
  $this->data['entry_stock_subtract'] = $this->language->get('entry_stock_subtract');
  $this->data['entry_stock_status'] = $this->language->get('entry_stock_status');
  $this->data['entry_download'] = $this->language->get('entry_download');
  $this->data['entry_download_status'] = $this->language->get('entry_download_status');
  // 100218 ALNAUA New building mechanism in order, mail and invoice Begin
  $this->data['entry_sborka_cost_per_hour'] = $this->language->get('entry_sborka_cost_per_hour');
  // 100218 ALNAUA New building mechanism in order, mail and invoice End
  // 20120204 ALNAUA ET-111227 Begin
  $this->data['entry_default_credit'] = $this->language->get('entry_default_credit');
  // 20120204 ALNAUA ET-111227 End
  // 130829 ET-130808 Begin
  $this->data['entry_min_price_warranty_page'] = $this->language->get('entry_min_price_warranty_page');
  // 130829 ET-130808 End
  $this->data['entry_logo'] = $this->language->get('entry_logo');
  $this->data['entry_icon'] = $this->language->get('entry_icon');
  // 101115 Add icon layers to products images Begin
  $this->data['entry_icon_24'] = $this->language->get('entry_icon_24');
  // 130829 ET-130815 Begin
  $this->data['entry_icon_5'] = $this->language->get('entry_icon_5');
  // 130829 ET-130815 End
  $this->data['entry_icon_new'] = $this->language->get('entry_icon_new');
  $this->data['entry_image_icon_24'] = $this->language->get('entry_image_icon_24');
  $this->data['entry_image_icon_new'] = $this->language->get('entry_image_icon_new');
  $this->data['entry_image_icon_24_cat'] = $this->language->get('entry_image_icon_24_cat');
  $this->data['entry_image_icon_new_cat'] = $this->language->get('entry_image_icon_new_cat');
  $this->data['entry_image_icon_24_pos'] = $this->language->get('entry_image_icon_24_pos');
  $this->data['entry_image_icon_new_pos'] = $this->language->get('entry_image_icon_new_pos');
  $this->data['entry_image_icon_24_offset'] = $this->language->get('entry_image_icon_24_offset');
  $this->data['entry_image_icon_new_offset'] = $this->language->get('entry_image_icon_new_offset');
  // 101115 Add icon layers to products images End
  // 130829 ET-130815 Begin
  $this->data['entry_image_icon_5'] = $this->language->get('entry_image_icon_5');
  $this->data['entry_image_icon_5_cat'] = $this->language->get('entry_image_icon_5_cat');
  $this->data['entry_image_icon_5_pos'] = $this->language->get('entry_image_icon_5_pos');
  $this->data['entry_image_icon_5_offset'] = $this->language->get('entry_image_icon_5_offset');
  // 130829 ET-130815 End
  // (+) ALNAUA 100120 Banner Upload (START)
  $this->data['entry_banner_dislpay'] = $this->language->get('entry_banner_dislpay');
  $this->data['entry_banner'] = $this->language->get('entry_banner');
  $this->data['entry_banner_url'] = $this->language->get('entry_banner_url');
  // (+) ALNAUA 100120 Banner Upload (FINISH)
  // 100217 ALNAUA Second right-bottom banner Begin
  $this->data['entry_second_banner_dislpay'] = $this->language->get('entry_second_banner_dislpay');
  $this->data['entry_second_banner'] = $this->language->get('entry_second_banner');
  $this->data['entry_second_banner_url'] = $this->language->get('entry_second_banner_url');
  // 100217 ALNAUA Second right-bottom banner End
  $this->data['entry_image_thumb'] = $this->language->get('entry_image_thumb');
  $this->data['entry_image_popup'] = $this->language->get('entry_image_popup');
  $this->data['entry_image_category'] = $this->language->get('entry_image_category');
  // (+) ALNAUA 091114 (START)
  $this->data['entry_image_category_dops'] = $this->language->get('entry_image_category_dops');
  // (+) ALNAUA 091114 (FINISH)
  $this->data['entry_image_product'] = $this->language->get('entry_image_product');
  $this->data['entry_image_additional'] = $this->language->get('entry_image_additional');
  $this->data['entry_image_related'] = $this->language->get('entry_image_related');
  $this->data['entry_image_cart'] = $this->language->get('entry_image_cart');
  $this->data['entry_mail_protocol'] = $this->language->get('entry_mail_protocol');
  $this->data['entry_smtp_host'] = $this->language->get('entry_smtp_host');
  $this->data['entry_smtp_username'] = $this->language->get('entry_smtp_username');
  $this->data['entry_smtp_password'] = $this->language->get('entry_smtp_password');
  $this->data['entry_smtp_port'] = $this->language->get('entry_smtp_port');
  $this->data['entry_smtp_timeout'] = $this->language->get('entry_smtp_timeout');
  $this->data['entry_ssl'] = $this->language->get('entry_ssl');
  $this->data['entry_encryption'] = $this->language->get('entry_encryption');
  $this->data['entry_seo_url'] = $this->language->get('entry_seo_url');
  $this->data['entry_compression'] = $this->language->get('entry_compression');
  $this->data['entry_error_display'] = $this->language->get('entry_error_display');
  $this->data['entry_error_log'] = $this->language->get('entry_error_log');
  $this->data['entry_error_filename'] = $this->language->get('entry_error_filename');
  
  $this->data['button_save'] = $this->language->get('button_save');
  $this->data['button_cancel'] = $this->language->get('button_cancel');

  $this->data['tab_shop'] = $this->language->get('tab_shop');
  $this->data['tab_local'] = $this->language->get('tab_local');
  $this->data['tab_option'] = $this->language->get('tab_option');
  $this->data['tab_image'] = $this->language->get('tab_image');
  $this->data['tab_mail'] = $this->language->get('tab_mail');
  $this->data['tab_server'] = $this->language->get('tab_server');
  // 100217 ALNAUA Second right-bottom banner Begin
  $this->data['tab_banners'] = $this->language->get('tab_banners');
  // 100217 ALNAUA Second right-bottom banner End

   if (isset($this->error['warning'])) {
   $this->data['error_warning'] = $this->error['warning'];
  } else {
   $this->data['error_warning'] = '';
  }

   if (isset($this->error['store'])) {
   $this->data['error_store'] = $this->error['store'];
  } else {
   $this->data['error_store'] = '';
  }

   if (isset($this->error['title'])) {
   $this->data['error_title'] = $this->error['title'];
  } else {
   $this->data['error_title'] = '';
  }
  
   if (isset($this->error['error_filename'])) {
   $this->data['error_error_filename'] = $this->error['error_filename'];
  } else {
   $this->data['error_error_filename'] = '';
  }  

   if (isset($this->error['owner'])) {
   $this->data['error_owner'] = $this->error['owner'];
  } else {
   $this->data['error_owner'] = '';
  }

   if (isset($this->error['address'])) {
   $this->data['error_address'] = $this->error['address'];
  } else {
   $this->data['error_address'] = '';
  }
  
   if (isset($this->error['email'])) {
   $this->data['error_email'] = $this->error['email'];
  } else {
   $this->data['error_email'] = '';
  }

  // (+) ALNAUA 091114 (START)
  if (isset($this->error['admin_email'])) {
   $this->data['error_admin_email'] = $this->error['admin_email'];
  } else {
   $this->data['error_admin_email'] = '';
  }
  // (+) ALNAUA 091114 (FINISH)

  // 110418 ET-110411 Director Claim Begin
  if (isset($this->error['director_email'])) {
   $this->data['error_director_email'] = $this->error['director_email'];
  } else {
   $this->data['error_director_email'] = '';
  }
  // 110418 ET-110411 Director Claim End

  if (isset($this->error['telephone'])) {
   $this->data['error_telephone'] = $this->error['telephone'];
  } else {
   $this->data['error_telephone'] = '';
  }

    $this->document->breadcrumbs = array();

     $this->document->breadcrumbs[] = array(
         'href'      => $this->url->https('common/home'),
         'text'      => $this->language->get('text_home'),
        'separator' => FALSE
     );

     $this->document->breadcrumbs[] = array(
         'href'      => $this->url->https('setting/setting'),
         'text'      => $this->language->get('heading_title'),
        'separator' => ' :: '
     );
  
  if (isset($this->session->data['success'])) {
   $this->data['success'] = $this->session->data['success'];
  
   unset($this->session->data['success']);
  } else {
   $this->data['success'] = '';
  }
  
  $this->data['action'] = $this->url->https('setting/setting');
  
  $this->data['cancel'] = $this->url->https('setting/setting');
  
  if (isset($this->request->post['config_store'])) {
   $this->data['config_store'] = $this->request->post['config_store'];
  } else {
   $this->data['config_store'] = $this->config->get('config_store');
  }

  if (isset($this->request->post['config_title'])) {
   $this->data['config_title'] = $this->request->post['config_title'];
  } else {
   $this->data['config_title'] = $this->config->get('config_title');
  }
  
  if (isset($this->request->post['config_meta_description'])) {
   $this->data['config_meta_description'] = $this->request->post['config_meta_description'];
  } else {
   $this->data['config_meta_description'] = $this->config->get('config_meta_description');
  }
        
        // (+) ALNAUA 100112 Tags (START)
        if (isset($this->request->post['config_meta_keywords'])) {
   $this->data['config_meta_keywords'] = $this->request->post['config_meta_keywords'];
  } else {
   $this->data['config_meta_keywords'] = $this->config->get('config_meta_keywords');
  }
        // (+) ALNAUA 100112 Tags (FINISH)

        // 100223 ALNAUA Site redesign Begin
        if (isset($this->request->post['config_contacts_title'])) {
   $this->data['config_contacts_title'] = $this->request->post['config_contacts_title'];
  } else {
   $this->data['config_contacts_title'] = $this->config->get('config_contacts_title');
  }

  if (isset($this->request->post['config_contacts_meta_description'])) {
   $this->data['config_contacts_meta_description'] = $this->request->post['config_contacts_meta_description'];
  } else {
   $this->data['config_contacts_meta_description'] = $this->config->get('config_contacts_meta_description');
  }

        if (isset($this->request->post['config_contacts_meta_keywords'])) {
   $this->data['config_contacts_meta_keywords'] = $this->request->post['config_contacts_meta_keywords'];
  } else {
   $this->data['config_contacts_meta_keywords'] = $this->config->get('config_contacts_meta_keywords');
  }
        // 100223 ALNAUA Site redesign End
  
  $this->load->helper('image');
  
  $this->data['config_logo'] = $this->config->get('config_logo');

  if ($this->config->get('config_logo') && file_exists(DIR_IMAGE . $this->config->get('config_logo'))) {
   if ((isset($this->request->server['HTTPS'])) && ($this->request->server['HTTPS'] == 'on')) {
    $this->data['preview_logo'] = HTTPS_IMAGE . $this->config->get('config_logo');
   } else {
    $this->data['preview_logo'] = HTTP_IMAGE . $this->config->get('config_logo');
   }   
  } else {
   $this->data['preview_logo'] = image_resize('no_image.jpg', 100, 100);
  }
  
  $this->data['config_icon'] = $this->config->get('config_icon');  
  
  if ($this->config->get('config_icon') && file_exists(DIR_IMAGE . $this->config->get('config_icon'))) {
   if ((isset($this->request->server['HTTPS'])) && ($this->request->server['HTTPS'] == 'on')) {
    $this->data['preview_icon'] = HTTPS_IMAGE . $this->config->get('config_icon');
   } else {
    $this->data['preview_icon'] = HTTP_IMAGE . $this->config->get('config_icon');
   } 
  } else {
   $this->data['preview_icon'] = image_resize('no_image.jpg', 100, 100);
  }

  // 101115 Add icon layers to products images Begin
  // Иконка 24 часа
  $this->data['config_icon_24'] = $this->config->get('config_icon_24');

  if ($this->config->get('config_icon_24') && file_exists(DIR_IMAGE . $this->config->get('config_icon_24'))) {
   if ((isset($this->request->server['HTTPS'])) && ($this->request->server['HTTPS'] == 'on')) {
    $this->data['preview_icon_24'] = HTTPS_IMAGE . $this->config->get('config_icon_24');
   } else {
    $this->data['preview_icon_24'] = HTTP_IMAGE . $this->config->get('config_icon_24');
   }
  } else {
   $this->data['preview_icon_24'] = image_resize('no_image.jpg', 100, 100);
  }
        //Product size
        if (isset($this->request->post['config_icon_24_width'])) {
   $this->data['config_icon_24_width'] = $this->request->post['config_icon_24_width'];
  } else {
   $this->data['config_icon_24_width'] = $this->config->get('config_icon_24_width');
  }

  if (isset($this->request->post['config_icon_24_height'])) {
   $this->data['config_icon_24_height'] = $this->request->post['config_icon_24_height'];
  } else {
   $this->data['config_icon_24_height'] = $this->config->get('config_icon_24_height');
  }
        // Category size
        if (isset($this->request->post['config_icon_24_cat_width'])) {
   $this->data['config_icon_24_cat_width'] = $this->request->post['config_icon_24_cat_width'];
  } else {
   $this->data['config_icon_24_cat_width'] = $this->config->get('config_icon_24_cat_width');
  }

  if (isset($this->request->post['config_icon_24_cat_height'])) {
   $this->data['config_icon_24_cat_height'] = $this->request->post['config_icon_24_cat_height'];
  } else {
   $this->data['config_icon_24_cat_height'] = $this->config->get('config_icon_24_cat_height');
  }
        // Position
        if (isset($this->request->post['config_icon_24_pos'])) {
   $this->data['config_icon_24_pos'] = $this->request->post['config_icon_24_pos'];
  } else {
   $this->data['config_icon_24_pos'] = $this->config->get('config_icon_24_pos');
  }
        // Offset
        if (isset($this->request->post['config_icon_24_top_offset'])) {
   $this->data['config_icon_24_top_offset'] = $this->request->post['config_icon_24_top_offset'];
  } else {
   $this->data['config_icon_24_top_offset'] = $this->config->get('config_icon_24_top_offset');
  }

        if (isset($this->request->post['config_icon_24_right_offset'])) {
   $this->data['config_icon_24_right_offset'] = $this->request->post['config_icon_24_right_offset'];
  } else {
   $this->data['config_icon_24_right_offset'] = $this->config->get('config_icon_24_right_offset');
  }

        if (isset($this->request->post['config_icon_24_bottom_offset'])) {
   $this->data['config_icon_24_bottom_offset'] = $this->request->post['config_icon_24_bottom_offset'];
  } else {
   $this->data['config_icon_24_bottom_offset'] = $this->config->get('config_icon_24_bottom_offset');
  }

        if (isset($this->request->post['config_icon_24_left_offset'])) {
   $this->data['config_icon_24_left_offset'] = $this->request->post['config_icon_24_left_offset'];
  } else {
   $this->data['config_icon_24_left_offset'] = $this->config->get('config_icon_24_left_offset');
  }

  // Иконка новинка
  $this->data['config_icon_new'] = $this->config->get('config_icon_new');

  if ($this->config->get('config_icon_new') && file_exists(DIR_IMAGE . $this->config->get('config_icon_new'))) {
   if ((isset($this->request->server['HTTPS'])) && ($this->request->server['HTTPS'] == 'on')) {
    $this->data['preview_icon_new'] = HTTPS_IMAGE . $this->config->get('config_icon_new');
   } else {
    $this->data['preview_icon_new'] = HTTP_IMAGE . $this->config->get('config_icon_new');
   }
  } else {
   $this->data['preview_icon_new'] = image_resize('no_image.jpg', 100, 100);
  }
  //Product size
  if (isset($this->request->post['config_icon_new_width'])) {
   $this->data['config_icon_new_width'] = $this->request->post['config_icon_new_width'];
  } else {
   $this->data['config_icon_new_width'] = $this->config->get('config_icon_new_width');
  }

  if (isset($this->request->post['config_icon_new_height'])) {
   $this->data['config_icon_new_height'] = $this->request->post['config_icon_new_height'];
  } else {
   $this->data['config_icon_new_height'] = $this->config->get('config_icon_new_height');
  }
        // Category size
        if (isset($this->request->post['config_icon_new_cat_width'])) {
   $this->data['config_icon_new_cat_width'] = $this->request->post['config_icon_new_cat_width'];
  } else {
   $this->data['config_icon_new_cat_width'] = $this->config->get('config_icon_new_cat_width');
  }

  if (isset($this->request->post['config_icon_new_cat_height'])) {
   $this->data['config_icon_new_cat_height'] = $this->request->post['config_icon_new_cat_height'];
  } else {
   $this->data['config_icon_new_cat_height'] = $this->config->get('config_icon_new_cat_height');
  }
        // Position
        if (isset($this->request->post['config_icon_new_pos'])) {
   $this->data['config_icon_new_pos'] = $this->request->post['config_icon_new_pos'];
  } else {
   $this->data['config_icon_new_pos'] = $this->config->get('config_icon_new_pos');
  }
        // Offset
        if (isset($this->request->post['config_icon_new_top_offset'])) {
   $this->data['config_icon_new_top_offset'] = $this->request->post['config_icon_new_top_offset'];
  } else {
   $this->data['config_icon_new_top_offset'] = $this->config->get('config_icon_new_top_offset');
  }

        if (isset($this->request->post['config_icon_new_right_offset'])) {
   $this->data['config_icon_new_right_offset'] = $this->request->post['config_icon_new_right_offset'];
  } else {
   $this->data['config_icon_new_right_offset'] = $this->config->get('config_icon_new_right_offset');
  }

        if (isset($this->request->post['config_icon_new_bottom_offset'])) {
   $this->data['config_icon_new_bottom_offset'] = $this->request->post['config_icon_new_bottom_offset'];
  } else {
   $this->data['config_icon_new_bottom_offset'] = $this->config->get('config_icon_new_bottom_offset');
  }

  if (isset($this->request->post['config_icon_new_left_offset'])) {
   $this->data['config_icon_new_left_offset'] = $this->request->post['config_icon_new_left_offset'];
  } else {
   $this->data['config_icon_new_left_offset'] = $this->config->get('config_icon_new_left_offset');
  }
  // 101115 Add icon layers to products images End
  
  // 130829 ET-130815 Begin
  $this->data['config_icon_5'] = $this->config->get('config_icon_5');

  if ($this->config->get('config_icon_5') && file_exists(DIR_IMAGE . $this->config->get('config_icon_5'))) {
   if ((isset($this->request->server['HTTPS'])) && ($this->request->server['HTTPS'] == 'on')) {
    $this->data['preview_icon_5'] = HTTPS_IMAGE . $this->config->get('config_icon_5');
   } else {
    $this->data['preview_icon_5'] = HTTP_IMAGE . $this->config->get('config_icon_5');
   }
  } else {
   $this->data['preview_icon_5'] = image_resize('no_image.jpg', 100, 100);
  }
  //Product size
  if (isset($this->request->post['config_icon_5_width'])) {
   $this->data['config_icon_5_width'] = $this->request->post['config_icon_5_width'];
  } else {
   $this->data['config_icon_5_width'] = $this->config->get('config_icon_5_width');
  }

  if (isset($this->request->post['config_icon_5_height'])) {
   $this->data['config_icon_5_height'] = $this->request->post['config_icon_5_height'];
  } else {
   $this->data['config_icon_5_height'] = $this->config->get('config_icon_5_height');
  }
        // Category size
        if (isset($this->request->post['config_icon_5_cat_width'])) {
   $this->data['config_icon_5_cat_width'] = $this->request->post['config_icon_5_cat_width'];
  } else {
   $this->data['config_icon_5_cat_width'] = $this->config->get('config_icon_5_cat_width');
  }

  if (isset($this->request->post['config_icon_5_cat_height'])) {
   $this->data['config_icon_5_cat_height'] = $this->request->post['config_icon_5_cat_height'];
  } else {
   $this->data['config_icon_5_cat_height'] = $this->config->get('config_icon_5_cat_height');
  }
  // Position
  if (isset($this->request->post['config_icon_5_pos'])) {
   $this->data['config_icon_5_pos'] = $this->request->post['config_icon_5_pos'];
  } else {
   $this->data['config_icon_5_pos'] = $this->config->get('config_icon_5_pos');
  }
  // Offset
  if (isset($this->request->post['config_icon_5_top_offset'])) {
   $this->data['config_icon_5_top_offset'] = $this->request->post['config_icon_5_top_offset'];
  } else {
   $this->data['config_icon_5_top_offset'] = $this->config->get('config_icon_5_top_offset');
  }

        if (isset($this->request->post['config_icon_5_right_offset'])) {
   $this->data['config_icon_5_right_offset'] = $this->request->post['config_icon_5_right_offset'];
  } else {
   $this->data['config_icon_5_right_offset'] = $this->config->get('config_icon_5_right_offset');
  }

        if (isset($this->request->post['config_icon_5_bottom_offset'])) {
   $this->data['config_icon_5_bottom_offset'] = $this->request->post['config_icon_5_bottom_offset'];
  } else {
   $this->data['config_icon_5_bottom_offset'] = $this->config->get('config_icon_5_bottom_offset');
  }

        if (isset($this->request->post['config_icon_5_left_offset'])) {
   $this->data['config_icon_5_left_offset'] = $this->request->post['config_icon_5_left_offset'];
  } else {
   $this->data['config_icon_5_left_offset'] = $this->config->get('config_icon_5_left_offset');
  }
  // 130829 ET-130815 End

  // (+) ALNAUA 100120 Banner Upload (START)
  if (isset($this->request->post['config_banner_display'])) {
   $this->data['config_banner_display'] = $this->request->post['config_banner_display'];
  } else {
   $this->data['config_banner_display'] = $this->config->get('config_banner_display');
  }

        $this->data['config_banner'] = $this->config->get('config_banner');
        $this->data['config_banner_ext'] = substr($this->config->get('config_banner'), strlen($this->config->get('config_banner'))-3, 3);

  if ($this->config->get('config_banner') && file_exists(DIR_IMAGE . 'akcija/' . $this->config->get('config_banner'))) {
   if ((isset($this->request->server['HTTPS'])) && ($this->request->server['HTTPS'] == 'on')) {
    $this->data['preview_banner'] = HTTPS_IMAGE . 'akcija/' . $this->config->get('config_banner');
   } else {
    $this->data['preview_banner'] = HTTP_IMAGE . 'akcija/' . $this->config->get('config_banner');
   }
  } else {
   $this->data['preview_banner'] = image_resize('no_image.jpg', 100, 100);
  }

        if (isset($this->request->post['config_banner_url'])) {
   $this->data['config_banner_url'] = $this->request->post['config_banner_url'];
  } else {
   $this->data['config_banner_url'] = $this->config->get('config_banner_url');
  }
        // (+) ALNAUA 100120 Banner Upload (FINISH)
        // 100217 ALNAUA Second right-bottom banner Begin
        if (isset($this->request->post['config_second_banner_display'])) {
   $this->data['config_second_banner_display'] = $this->request->post['config_second_banner_display'];
  } else {
   $this->data['config_second_banner_display'] = $this->config->get('config_second_banner_display');
  }

        $this->data['config_second_banner'] = $this->config->get('config_second_banner');
        $this->data['config_second_banner_ext'] = substr($this->config->get('config_second_banner'), strlen($this->config->get('config_second_banner'))-3, 3);

  if ($this->config->get('config_second_banner') && file_exists(DIR_IMAGE . 'akcija/' . $this->config->get('config_second_banner'))) {
   if ((isset($this->request->server['HTTPS'])) && ($this->request->server['HTTPS'] == 'on')) {
    $this->data['preview_second_banner'] = HTTPS_IMAGE . 'akcija/' . $this->config->get('config_second_banner');
   } else {
    $this->data['preview_second_banner'] = HTTP_IMAGE . 'akcija/' . $this->config->get('config_second_banner');
   }
  } else {
   $this->data['preview_second_banner'] = image_resize('no_image.jpg', 100, 100);
  }

        if (isset($this->request->post['config_second_banner_url'])) {
   $this->data['config_second_banner_url'] = $this->request->post['config_second_banner_url'];
  } else {
   $this->data['config_second_banner_url'] = $this->config->get('config_second_banner_url');
  }
  // 100217 ALNAUA Second right-bottom banner End
  // 130415 ET-130411 Begin
  if (isset($this->request->post['slideshow_display_on_home'])) {
   $this->data['slideshow_display_on_home'] = $this->request->post['slideshow_display_on_home'];
  } else {
   $this->data['slideshow_display_on_home'] = $this->config->get('slideshow_display_on_home');
  }
  if (isset($this->request->post['config_slideshow_width'])) {
   $this->data['config_slideshow_width'] = $this->request->post['config_slideshow_width'];
  } else {
   $this->data['config_slideshow_width'] = $this->config->get('config_slideshow_width');
  }
  if (isset($this->request->post['config_slideshow_height'])) {
   $this->data['config_slideshow_height'] = $this->request->post['config_slideshow_height'];
  } else {
   $this->data['config_slideshow_height'] = $this->config->get('config_slideshow_height');
  }
  // 130415 ET-130411 End
  // ET-150303 Begin
  if (isset($this->request->post['config_slideshow_delay'])) {
   $this->data['config_slideshow_delay'] = $this->request->post['config_slideshow_delay'];
  } else {
   $this->data['config_slideshow_delay'] = $this->config->get('config_slideshow_delay');
  }
  // ET-150303 End
  // 100129 ALNAUA Home Page change, add product sorting, translite russian filename upload Begin
  if (isset($this->request->post['config_left_top_banner_display'])) {
   $this->data['config_left_top_banner_display'] = $this->request->post['config_left_top_banner_display'];
  } else {
   $this->data['config_left_top_banner_display'] = $this->config->get('config_left_top_banner_display');
  }

  $this->data['config_left_top_banner'] = $this->config->get('config_left_top_banner');
  $this->data['config_left_top_banner_ext'] = substr($this->config->get('config_left_top_banner'), strlen($this->config->get('config_left_top_banner'))-3, 3);

  if ($this->config->get('config_left_top_banner') && file_exists(DIR_IMAGE . 'akcija/' . $this->config->get('config_left_top_banner'))) {
   if ((isset($this->request->server['HTTPS'])) && ($this->request->server['HTTPS'] == 'on')) {
    $this->data['preview_left_top_banner'] = HTTPS_IMAGE . 'akcija/' . $this->config->get('config_left_top_banner');
   } else {
    $this->data['preview_left_top_banner'] = HTTP_IMAGE . 'akcija/' . $this->config->get('config_left_top_banner');
   }
  } else {
   $this->data['preview_left_top_banner'] = image_resize('no_image.jpg', 100, 100);
  }

        if (isset($this->request->post['config_left_top_banner_url'])) {
   $this->data['config_left_top_banner_url'] = $this->request->post['config_left_top_banner_url'];
  } else {
   $this->data['config_left_top_banner_url'] = $this->config->get('config_left_top_banner_url');
  }

        if (isset($this->request->post['config_right_top_banner_display'])) {
   $this->data['config_right_top_banner_display'] = $this->request->post['config_right_top_banner_display'];
  } else {
   $this->data['config_right_top_banner_display'] = $this->config->get('config_right_top_banner_display');
  }

        $this->data['config_right_top_banner'] = $this->config->get('config_right_top_banner');
        $this->data['config_right_top_banner_ext'] = substr($this->config->get('config_right_top_banner'), strlen($this->config->get('config_right_top_banner'))-3, 3);

  if ($this->config->get('config_right_top_banner') && file_exists(DIR_IMAGE . 'akcija/' . $this->config->get('config_right_top_banner'))) {
   if ((isset($this->request->server['HTTPS'])) && ($this->request->server['HTTPS'] == 'on')) {
    $this->data['preview_right_top_banner'] = HTTPS_IMAGE . 'akcija/' . $this->config->get('config_right_top_banner');
   } else {
    $this->data['preview_right_top_banner'] = HTTP_IMAGE . 'akcija/' . $this->config->get('config_right_top_banner');
   }
  } else {
   $this->data['preview_right_top_banner'] = image_resize('no_image.jpg', 100, 100);
  }

        if (isset($this->request->post['config_right_top_banner_url'])) {
   $this->data['config_right_top_banner_url'] = $this->request->post['config_right_top_banner_url'];
  } else {
   $this->data['config_right_top_banner_url'] = $this->config->get('config_right_top_banner_url');
  }
        // 100129 ALNAUA Home Page change, add product sorting, translite russian filename upload End

  $this->load->model('localisation/language');
  
  $languages = $this->model_localisation_language->getLanguages();
  
  foreach ($languages as $language) {
   if (isset($this->request->post['config_welcome_' . $language['language_id']])) {
    $this->data['config_welcome_' . $language['language_id']] = $this->request->post['config_welcome_' . $language['language_id']];
   } else {
    $this->data['config_welcome_' . $language['language_id']] = $this->config->get('config_welcome_' . $language['language_id']);
   }
   // 100129 ALNAUA Home Page change, add product sorting, translite russian filename upload Begin
   if (isset($this->request->post['config_bottom_message_' . $language['language_id']])) {
    $this->data['config_bottom_message_' . $language['language_id']] = $this->request->post['config_bottom_message_' . $language['language_id']];
   } else {
    $this->data['config_bottom_message_' . $language['language_id']] = $this->config->get('config_bottom_message_' . $language['language_id']);
   }
   // 100129 ALNAUA Home Page change, add product sorting, translite russian filename upload End
   // 130415 ET-130411 Begin
   if (isset($this->request->post['config_contacts_extra_' . $language['language_id']])) {
    $this->data['config_contacts_extra_' . $language['language_id']] = $this->request->post['config_contacts_extra_' . $language['language_id']];
   } else {
    $this->data['config_contacts_extra_' . $language['language_id']] = $this->config->get('config_contacts_extra_' . $language['language_id']);
   }
   // 130415 ET-130411 End
  }

  if (isset($this->request->post['config_owner'])) {
   $this->data['config_owner'] = $this->request->post['config_owner'];
  } else {
   $this->data['config_owner'] = $this->config->get('config_owner');
  }

  if (isset($this->request->post['config_address'])) {
   $this->data['config_address'] = $this->request->post['config_address'];
  } else {
   $this->data['config_address'] = $this->config->get('config_address');
  }
        
  // (+) ALNAUA 091114 (START)
  if (isset($this->request->post['config_invoice_data'])) {
   $this->data['config_invoice_data'] = $this->request->post['config_invoice_data'];
  } else {
   $this->data['config_invoice_data'] = $this->config->get('config_invoice_data');
  }

  if (isset($this->request->post['config_nds_invoice_data'])) {
    $this->data['config_nds_invoice_data'] = $this->request->post['config_nds_invoice_data'];
  } else {
    $this->data['config_nds_invoice_data'] = $this->config->get('config_nds_invoice_data');
  }
  // (+) ALNAUA 091114 (FINISH)

  if (isset($this->request->post['config_email'])) {
   $this->data['config_email'] = $this->request->post['config_email'];
  } else {
   $this->data['config_email'] = $this->config->get('config_email');
  }

        // (+) ALNAUA 091114 (START)
   if (isset($this->request->post['config_admin_email'])) {
   $this->data['config_admin_email'] = $this->request->post['config_admin_email'];
  } else {
   $this->data['config_admin_email'] = $this->config->get('config_admin_email');
  }
        // (+) ALNAUA 091114 (FINISH)

  // 110418 ET-110411 Director Claim Begin
  if (isset($this->request->post['config_admin_email'])) {
   $this->data['config_director_email'] = $this->request->post['config_director_email'];
  } else {
   $this->data['config_director_email'] = $this->config->get('config_director_email');
  }
  // 110418 ET-110411 Director Claim End
  
  // 130226 ET-130226 New email column Begin
  if (isset($this->request->post['config_bcc_email'])) {
   $this->data['config_bcc_email'] = $this->request->post['config_bcc_email'];
  } else {
   $this->data['config_bcc_email'] = $this->config->get('config_bcc_email');
  }
  // 130226 ET-130226 New email column End
  
  //110805 ET-110805 Extra Telephone Field Begin
                //if (isset($this->request->post['config_telephone'])) {
  // $this->data['config_telephone'] = $this->request->post['config_telephone'];
  //} else {
  // $this->data['config_telephone'] = $this->config->get('config_telephone');
  //}
                
    if (isset($this->request->post['config_telephone_right'])) {
   $this->data['config_telephone_right'] = $this->request->post['config_telephone_right'];
  } else {
   $this->data['config_telephone_right'] = $this->config->get('config_telephone_right');
  }
                
    if (isset($this->request->post['config_telephone_left'])) {
   $this->data['config_telephone_left'] = $this->request->post['config_telephone_left'];
  } else {
   $this->data['config_telephone_left'] = $this->config->get('config_telephone_left');
  }
                // 110805 ET-110805 Extra Telephone Field End

  if (isset($this->request->post['config_fax'])) {
   $this->data['config_fax'] = $this->request->post['config_fax'];
  } else {
   $this->data['config_fax'] = $this->config->get('config_fax');
  }
  
  $this->data['templates'] = array();

  $directories = glob(DIR_CATALOG . 'view/theme/*', GLOB_ONLYDIR);
  
  foreach ($directories as $directory) {
   $this->data['templates'][] = basename($directory);
  }
  
  if (isset($this->request->post['config_template'])) {
   $this->data['config_template'] = $this->request->post['config_template'];
  } else {
   $this->data['config_template'] = $this->config->get('config_template');
  }
  
  if (isset($this->request->post['config_country_id'])) {
   $this->data['config_country_id'] = $this->request->post['config_country_id'];
  } else {
   $this->data['config_country_id'] = $this->config->get('config_country_id');
  }
  
  $this->load->model('localisation/country');
  
  $this->data['countries'] = $this->model_localisation_country->getCountries();

  if (isset($this->request->post['config_zone_id'])) {
   $this->data['config_zone_id'] = $this->request->post['config_zone_id'];
  } else {
   $this->data['config_zone_id'] = $this->config->get('config_zone_id');
  }

  if (isset($this->request->post['config_language'])) {
   $this->data['config_language'] = $this->request->post['config_language'];
  } else {
   $this->data['config_language'] = $this->config->get('config_language');
  }

  if (isset($this->request->post['config_admin_language'])) {
   $this->data['config_admin_language'] = $this->request->post['config_admin_language'];
  } else {
   $this->data['config_admin_language'] = $this->config->get('config_admin_language');
  }
  
  $this->load->model('localisation/language');
  
  $this->data['languages'] = $this->model_localisation_language->getLanguages();

  if (isset($this->request->post['config_currency'])) {
   $this->data['config_currency'] = $this->request->post['config_currency'];
  } else {
   $this->data['config_currency'] = $this->config->get('config_currency');
  }

  if (isset($this->request->post['config_currency_auto'])) {
   $this->data['config_currency_auto'] = $this->request->post['config_currency_auto'];
  } else {
   $this->data['config_currency_auto'] = $this->config->get('config_currency_auto');
  }
  
  $this->load->model('localisation/currency');
  
  $this->data['currencies'] = $this->model_localisation_currency->getCurrencies();
  
  if (isset($this->request->post['config_tax'])) {
   $this->data['config_tax'] = $this->request->post['config_tax'];
  } else {
   $this->data['config_tax'] = $this->config->get('config_tax');
  }
  
  if (isset($this->request->post['config_weight_class_id'])) {
   $this->data['config_weight_class_id'] = $this->request->post['config_weight_class_id'];
  } else {
   $this->data['config_weight_class_id'] = $this->config->get('config_weight_class_id');
  }
  
  $this->load->model('localisation/weight_class');
  
  $this->data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();
    
  if (isset($this->request->post['config_measurement_class_id'])) {
   $this->data['config_measurement_class_id'] = $this->request->post['config_measurement_class_id'];
  } else {
   $this->data['config_measurement_class_id'] = $this->config->get('config_measurement_class_id');
  }
  
  $this->load->model('localisation/measurement_class');
  
  $this->data['measurement_classes'] = $this->model_localisation_measurement_class->getMeasurementClasses();

  if (isset($this->request->post['config_alert_mail'])) {
   $this->data['config_alert_mail'] = $this->request->post['config_alert_mail'];
  } else {
   $this->data['config_alert_mail'] = $this->config->get('config_alert_mail');
  }

        // (+) ALNAUA 091114 (START)
        if (isset($this->request->post['config_alert_mail_for_customer'])) {
   $this->data['config_alert_mail_for_customer'] = $this->request->post['config_alert_mail_for_customer'];
  } else {
   $this->data['config_alert_mail_for_customer'] = $this->config->get('config_alert_mail_for_customer');
  }
        // (+) ALNAUA 091114 (FINISH)

  $this->load->model('customer/customer_group');
  
  $this->data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();
  
  if (isset($this->request->post['config_customer_group_id'])) {
   $this->data['config_customer_group_id'] = $this->request->post['config_customer_group_id'];
  } else {
   $this->data['config_customer_group_id'] = $this->config->get('config_customer_group_id');
  }
  
  if (isset($this->request->post['config_customer_price'])) {
   $this->data['config_customer_price'] = $this->request->post['config_customer_price'];
  } else {
   $this->data['config_customer_price'] = $this->config->get('config_customer_price');
  }
  
  if (isset($this->request->post['config_customer_approval'])) {
   $this->data['config_customer_approval'] = $this->request->post['config_customer_approval'];
  } else {
   $this->data['config_customer_approval'] = $this->config->get('config_customer_approval');
  }
  
  if (isset($this->request->post['config_guest_checkout'])) {
   $this->data['config_guest_checkout'] = $this->request->post['config_guest_checkout'];
  } else {
   $this->data['config_guest_checkout'] = $this->config->get('config_guest_checkout');
  }
  
  if (isset($this->request->post['config_account'])) {
   $this->data['config_account'] = $this->request->post['config_account'];
  } else {
   $this->data['config_account'] = $this->config->get('config_account');
  }
  
  if (isset($this->request->post['config_checkout'])) {
   $this->data['config_checkout'] = $this->request->post['config_checkout'];
  } else {
   $this->data['config_checkout'] = $this->config->get('config_checkout');
  }

  $this->load->model('catalog/information');
  
  $this->data['informations'] = $this->model_catalog_information->getInformations();

  if (isset($this->request->post['config_stock_display'])) {
   $this->data['config_stock_display'] = $this->request->post['config_stock_display'];
  } else {
   $this->data['config_stock_display'] = $this->config->get('config_stock_display');
  }
  
  if (isset($this->request->post['config_stock_check'])) {
   $this->data['config_stock_check'] = $this->request->post['config_stock_check'];
  } else {
   $this->data['config_stock_check'] = $this->config->get('config_stock_check');
  }

  if (isset($this->request->post['config_stock_checkout'])) {
   $this->data['config_stock_checkout'] = $this->request->post['config_stock_checkout'];
  } else {
   $this->data['config_stock_checkout'] = $this->config->get('config_stock_checkout');
  }

  if (isset($this->request->post['config_stock_subtract'])) {
   $this->data['config_stock_subtract'] = $this->request->post['config_stock_subtract'];
  } else {
   $this->data['config_stock_subtract'] = $this->config->get('config_stock_subtract');
  }

  $this->load->model('localisation/order_status');
  
  $this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

  if (isset($this->request->post['config_order_status_id'])) {
   $this->data['config_order_status_id'] = $this->request->post['config_order_status_id'];
  } else {
   $this->data['config_order_status_id'] = $this->config->get('config_order_status_id');
  }
  
  $this->load->model('localisation/stock_status');
  
  $this->data['stock_statuses'] = $this->model_localisation_stock_status->getStockStatuses();

  if (isset($this->request->post['config_stock_status_id'])) {
   $this->data['config_stock_status_id'] = $this->request->post['config_stock_status_id'];
  } else {
   $this->data['config_stock_status_id'] = $this->config->get('config_stock_status_id');
  }
  
  if (isset($this->request->post['config_download'])) {
   $this->data['config_download'] = $this->request->post['config_download'];
  } else {
   $this->data['config_download'] = $this->config->get('config_download');
  }

  if (isset($this->request->post['config_download_status'])) {
   $this->data['config_download_status'] = $this->request->post['config_download_status'];
  } else {
   $this->data['config_download_status'] = $this->config->get('config_download_status');
  }

  // 100218 ALNAUA New building mechanism in order, mail and invoice Begin
  if (isset($this->request->post['config_sborka_cost_per_hour'])) {
   $this->data['config_sborka_cost_per_hour'] = $this->request->post['config_sborka_cost_per_hour'];
  } else {
   $this->data['config_sborka_cost_per_hour'] = $this->config->get('config_sborka_cost_per_hour');
  }
  // 100218 ALNAUA New building mechanism in order, mail and invoice End
  
  // 20120204 ALNAUA ET-111227 Begin
  $this->load->model('catalog/credit');
  
  $this->data['credits'] = $this->model_catalog_credit->getEnabledCredits();
  
  if (isset($this->request->post['config_default_credit_id'])) {
   $this->data['config_default_credit_id'] = $this->request->post['config_default_credit_id'];
  } else {
   $this->data['config_default_credit_id'] = $this->config->get('config_default_credit_id');
  }
  // 20120204 ALNAUA ET-111227 End
  
  // 130829 ET-130808 Begin
  if (isset($this->request->post['config_min_price_warranty_page'])) {
   $this->data['config_min_price_warranty_page'] = $this->request->post['config_min_price_warranty_page'];
  } else {
   $this->data['config_min_price_warranty_page'] = $this->config->get('config_min_price_warranty_page');
  }
  // 130829 ET-130808 End
  
  if (isset($this->request->post['config_image_thumb_width'])) {
   $this->data['config_image_thumb_width'] = $this->request->post['config_image_thumb_width'];
  } else {
   $this->data['config_image_thumb_width'] = $this->config->get('config_image_thumb_width');
  }
  
  if (isset($this->request->post['config_image_thumb_height'])) {
   $this->data['config_image_thumb_height'] = $this->request->post['config_image_thumb_height'];
  } else {
   $this->data['config_image_thumb_height'] = $this->config->get('config_image_thumb_height');
  }
  
  if (isset($this->request->post['config_image_popup_width'])) {
   $this->data['config_image_popup_width'] = $this->request->post['config_image_popup_width'];
  } else {
   $this->data['config_image_popup_width'] = $this->config->get('config_image_popup_width');
  }
  
  if (isset($this->request->post['config_image_popup_height'])) {
   $this->data['config_image_popup_height'] = $this->request->post['config_image_popup_height'];
  } else {
   $this->data['config_image_popup_height'] = $this->config->get('config_image_popup_height');
  }

  if (isset($this->request->post['config_image_category_width'])) {
   $this->data['config_image_category_width'] = $this->request->post['config_image_category_width'];
  } else {
   $this->data['config_image_category_width'] = $this->config->get('config_image_category_width');
  }

  if (isset($this->request->post['config_image_category_height'])) {
   $this->data['config_image_category_height'] = $this->request->post['config_image_category_height'];
  } else {
   $this->data['config_image_category_height'] = $this->config->get('config_image_category_height');
  }

        // (+) ALNAUA 091114 (START)
        if (isset($this->request->post['config_image_category_dops_width'])) {
   $this->data['config_image_category_dops_width'] = $this->request->post['config_image_category_dops_width'];
  } else {
   $this->data['config_image_category_dops_width'] = $this->config->get('config_image_category_dops_width');
  }

        if (isset($this->request->post['config_image_category_dops_height'])) {
   $this->data['config_image_category_dops_height'] = $this->request->post['config_image_category_dops_height'];
  } else {
   $this->data['config_image_category_dops_height'] = $this->config->get('config_image_category_dops_height');
  }
  // (+) ALNAUA 091114 (FINISH)
  
  if (isset($this->request->post['config_image_product_width'])) {
   $this->data['config_image_product_width'] = $this->request->post['config_image_product_width'];
  } else {
   $this->data['config_image_product_width'] = $this->config->get('config_image_product_width');
  }
  
  if (isset($this->request->post['config_image_product_height'])) {
   $this->data['config_image_product_height'] = $this->request->post['config_image_product_height'];
  } else {
   $this->data['config_image_product_height'] = $this->config->get('config_image_product_height');
  }

  if (isset($this->request->post['config_image_additional_width'])) {
   $this->data['config_image_additional_width'] = $this->request->post['config_image_additional_width'];
  } else {
   $this->data['config_image_additional_width'] = $this->config->get('config_image_additional_width');
  }
  
  if (isset($this->request->post['config_image_additional_height'])) {
   $this->data['config_image_additional_height'] = $this->request->post['config_image_additional_height'];
  } else {
   $this->data['config_image_additional_height'] = $this->config->get('config_image_additional_height');
  }
  
  if (isset($this->request->post['config_image_related_width'])) {
   $this->data['config_image_related_width'] = $this->request->post['config_image_related_width'];
  } else {
   $this->data['config_image_related_width'] = $this->config->get('config_image_related_width');
  }
  
  if (isset($this->request->post['config_image_related_height'])) {
   $this->data['config_image_related_height'] = $this->request->post['config_image_related_height'];
  } else {
   $this->data['config_image_related_height'] = $this->config->get('config_image_related_height');
  }
  
  if (isset($this->request->post['config_image_cart_width'])) {
   $this->data['config_image_cart_width'] = $this->request->post['config_image_cart_width'];
  } else {
   $this->data['config_image_cart_width'] = $this->config->get('config_image_cart_width');
  }
  
  if (isset($this->request->post['config_image_cart_height'])) {
   $this->data['config_image_cart_height'] = $this->request->post['config_image_cart_height'];
  } else {
   $this->data['config_image_cart_height'] = $this->config->get('config_image_cart_height');
  }
  
  if (isset($this->request->post['config_mail_protocol'])) {
   $this->data['config_mail_protocol'] = $this->request->post['config_mail_protocol'];
  } else {
   $this->data['config_mail_protocol'] = $this->config->get('config_mail_protocol');
  }
  
  if (isset($this->request->post['config_smtp_host'])) {
   $this->data['config_smtp_host'] = $this->request->post['config_smtp_host'];
  } else {
   $this->data['config_smtp_host'] = $this->config->get('config_smtp_host');
  }  

  if (isset($this->request->post['config_smtp_username'])) {
   $this->data['config_smtp_username'] = $this->request->post['config_smtp_username'];
  } else {
   $this->data['config_smtp_username'] = $this->config->get('config_smtp_username');
  } 
  
  if (isset($this->request->post['config_smtp_password'])) {
   $this->data['config_smtp_password'] = $this->request->post['config_smtp_password'];
  } else {
   $this->data['config_smtp_password'] = $this->config->get('config_smtp_password');
  } 
  
  if (isset($this->request->post['config_smtp_port'])) {
   $this->data['config_smtp_port'] = $this->request->post['config_smtp_port'];
  } elseif ($this->config->get('config_smtp_port')) {
   $this->data['config_smtp_port'] = $this->config->get('config_smtp_port');
  } else {
   $this->data['config_smtp_port'] = 25;
  } 
  
  if (isset($this->request->post['config_smtp_timeout'])) {
   $this->data['config_smtp_timeout'] = $this->request->post['config_smtp_timeout'];
  } elseif ($this->config->get('config_smtp_timeout')) {
   $this->data['config_smtp_timeout'] = $this->config->get('config_smtp_timeout');
  } else {
   $this->data['config_smtp_timeout'] = 5; 
  } 
  
  if (isset($this->request->post['config_ssl'])) {
   $this->data['config_ssl'] = $this->request->post['config_ssl'];
  } else {
   $this->data['config_ssl'] = $this->config->get('config_ssl');
  }

  if (isset($this->request->post['config_encryption'])) {
   $this->data['config_encryption'] = $this->request->post['config_encryption'];
  } else {
   $this->data['config_encryption'] = $this->config->get('config_encryption');
  }
  
  if (isset($this->request->post['config_seo_url'])) {
   $this->data['config_seo_url'] = $this->request->post['config_seo_url'];
  } else {
   $this->data['config_seo_url'] = $this->config->get('config_seo_url');
  }
  
  if (isset($this->request->post['config_compression'])) {
   $this->data['config_compression'] = $this->request->post['config_compression']; 
  } else {
   $this->data['config_compression'] = $this->config->get('config_compression');
  }

  if (isset($this->request->post['config_error_display'])) {
   $this->data['config_error_display'] = $this->request->post['config_error_display']; 
  } else {
   $this->data['config_error_display'] = $this->config->get('config_error_display');
  }

  if (isset($this->request->post['config_error_log'])) {
   $this->data['config_error_log'] = $this->request->post['config_error_log']; 
  } else {
   $this->data['config_error_log'] = $this->config->get('config_error_log');
  }

  if (isset($this->request->post['config_error_filename'])) {
   $this->data['config_error_filename'] = $this->request->post['config_error_filename']; 
  } else {
   $this->data['config_error_filename'] = $this->config->get('config_error_filename');
  }
   
  $this->template = 'setting/setting.tpl';
  $this->children = array(
   'common/header', 
   'common/footer' 
  );
  
  $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
 }

 private function validate() {
  if (!$this->user->hasPermission('modify', 'setting/setting')) {
   $this->error['warning'] = $this->language->get('error_permission');
  }

  if (!$this->request->post['config_store']) {
   $this->error['store'] = $this->language->get('error_store');
  } 
  
  if (!$this->request->post['config_title']) {
   $this->error['title'] = $this->language->get('error_title');
  } 
  
  if ((strlen(utf8_decode($this->request->post['config_owner'])) < 3) || (strlen(utf8_decode($this->request->post['config_owner'])) > 64)) {
   $this->error['owner'] = $this->language->get('error_owner');
  }

  if ((strlen(utf8_decode($this->request->post['config_address'])) < 3) || (strlen(utf8_decode($this->request->post['config_address'])) > 500)) {
   $this->error['address'] = $this->language->get('error_address');
  }
  
  $pattern = '/^([a-z0-9])(([-a-z0-9._])*([a-z0-9]))*\@([a-z0-9])(([a-z0-9-])*([a-z0-9]))+(\.([a-z0-9])([-a-z0-9_-])?([a-z0-9])+)+$/i';
  
    if ((strlen(utf8_decode($this->request->post['config_email'])) > 32) || (!preg_match($pattern, $this->request->post['config_email']))) {
       $this->error['email'] = $this->language->get('error_email');
    }

    // (+) ALNAUA 091114 (START)
    if ((strlen(utf8_decode($this->request->post['config_admin_email'])) > 32) || (!preg_match($pattern, $this->request->post['config_admin_email']))) {
       $this->error['admin_email'] = $this->language->get('error_admin_email');
    }
    // (+) ALNAUA 091114 (FINISH)

    // 110418 ET-110411 Director Claim Begin
    if ((strlen(utf8_decode($this->request->post['config_director_email'])) > 32) || (!preg_match($pattern, $this->request->post['config_director_email']))) {
       $this->error['director_email'] = $this->language->get('error_director_email');
    }
    // 110418 ET-110411 Director Claim End

    // (-/+) ALNAUA 091114 (START)
    //if ((strlen(utf8_decode($this->request->post['config_telephone'])) < 3) || (strlen(utf8_decode($this->request->post['config_telephone'])) > 32)) {
    if ((strlen(utf8_decode($this->request->post['config_telephone_right'])) < 3) || (strlen(utf8_decode($this->request->post['config_telephone_right'])) > 1024))
    {
    // (-/+) ALNAUA 091114 (FINISH)
       $this->error['telephone'] = $this->language->get('error_telephone');
    }

    if (!$this->request->post['config_error_filename']) {
     $this->error['error_filename'] = $this->language->get('error_error_filename');
    }
  
    if ($this->request->files['config_logo']['name']) {
     if ((strlen(utf8_decode($this->request->files['config_logo']['name'])) < 3) || (strlen(utf8_decode($this->request->files['config_logo']['name'])) > 255)) {
          $this->error['warning'] = $this->language->get('error_filename');
     }

   $allowed = array(
    'image/jpeg',
    'image/pjpeg',
    'image/png',
    'image/x-png',
    'image/gif'
      );
    
   if (!in_array($this->request->files['config_logo']['type'], $allowed)) {
    $this->error['warning'] = $this->language->get('error_filetype');
   }
   
   if (!is_writable(DIR_IMAGE)) {
    $this->error['warning'] = $this->language->get('error_writable_image');
   }
   
   if (!is_writable(DIR_IMAGE . 'cache/')) {
    $this->error['warning'] = $this->language->get('error_writable_image_cache');
   }
   
   if ($this->request->files['config_logo']['error'] != UPLOAD_ERR_OK) { 
    $this->error['warning'] = $this->language->get('error_upload_' . $this->request->files['config_logo']['error']);
   }
  }

    if ($this->request->files['config_icon']['name']) {
     if ((strlen(utf8_decode($this->request->files['config_icon']['name'])) < 3) || (strlen(utf8_decode($this->request->files['config_icon']['name'])) > 255)) {
          $this->error['warning'] = $this->language->get('error_filename');
     }

      $allowed = array(
       'image/jpeg',
       'image/pjpeg',
    'image/png',
    'image/x-png',
    'image/gif'
      );
    
   if (!in_array($this->request->files['config_icon']['type'], $allowed)) {
    $this->error['warning'] = $this->language->get('error_filetype');
   }
   
   if (!is_writable(DIR_IMAGE)) {
    $this->error['warning'] = $this->language->get('error_writable_image');
   }
   
   if (!is_writable(DIR_IMAGE . 'cache/')) {
    $this->error['warning'] = $this->language->get('error_writable_image_cache');
   }
   
   if ($this->request->files['config_icon']['error'] != UPLOAD_ERR_OK) { 
    $this->error['warning'] = $this->language->get('error_upload_' . $this->request->files['config_icon']['error']);
   }
  }

        // 101115 Add icon layers to products images Begin
        if ($this->request->files['config_icon_24']['name']) {
     if ((strlen(utf8_decode($this->request->files['config_icon_24']['name'])) < 3) || (strlen(utf8_decode($this->request->files['config_icon_24']['name'])) > 255)) {
          $this->error['warning'] = $this->language->get('error_filename');
     }

      $allowed = array(
       'image/jpeg',
       'image/pjpeg',
    'image/png',
    'image/x-png',
    'image/gif'
      );

   if (!in_array($this->request->files['config_icon_24']['type'], $allowed)) {
    $this->error['warning'] = $this->language->get('error_filetype');
   }

   if (!is_writable(DIR_IMAGE)) {
    $this->error['warning'] = $this->language->get('error_writable_image');
   }

   if (!is_writable(DIR_IMAGE . 'cache/')) {
    $this->error['warning'] = $this->language->get('error_writable_image_cache');
   }

   if ($this->request->files['config_icon_24']['error'] != UPLOAD_ERR_OK) {
    $this->error['warning'] = $this->language->get('error_upload_' . $this->request->files['config_icon_24']['error']);
   }
  }

        if ($this->request->files['config_icon_new']['name']) {
     if ((strlen(utf8_decode($this->request->files['config_icon_new']['name'])) < 3) || (strlen(utf8_decode($this->request->files['config_icon_new']['name'])) > 255)) {
          $this->error['warning'] = $this->language->get('error_filename');
     }

      $allowed = array(
       'image/jpeg',
       'image/pjpeg',
    'image/png',
    'image/x-png',
    'image/gif'
      );

   if (!in_array($this->request->files['config_icon_new']['type'], $allowed)) {
    $this->error['warning'] = $this->language->get('error_filetype');
   }

   if (!is_writable(DIR_IMAGE)) {
    $this->error['warning'] = $this->language->get('error_writable_image');
   }

   if (!is_writable(DIR_IMAGE . 'cache/')) {
    $this->error['warning'] = $this->language->get('error_writable_image_cache');
   }

   if ($this->request->files['config_icon_new']['error'] != UPLOAD_ERR_OK) {
    $this->error['warning'] = $this->language->get('error_upload_' . $this->request->files['config_icon_new']['error']);
   }
  }
        // 101115 Add icon layers to products images End

        // (+) ALNAUA 100120 Banner Upload (START)
        if ($this->request->files['config_banner']['name']) {

      $allowed = array(
       'image/jpeg',
       'image/pjpeg',
    'image/png',
    'image/x-png',
    'image/gif',
                'application/x-shockwave-flash'
      );

   if (!in_array($this->request->files['config_banner']['type'], $allowed)) {
    $this->error['warning'] = $this->language->get('error_filetype');
   }

   if (!is_writable(DIR_IMAGE)) {
    $this->error['warning'] = $this->language->get('error_writable_image');
   }

   if (!is_writable(DIR_IMAGE . 'cache/')) {
    $this->error['warning'] = $this->language->get('error_writable_image_cache');
   }

   if ($this->request->files['config_banner']['error'] != UPLOAD_ERR_OK) {
    $this->error['warning'] = $this->language->get('error_upload_' . $this->request->files['config_banner']['error']);
   }
  }
        // (+) ALNAUA 100120 Banner Upload (FINISH)
        // 100217 ALNAUA Second right-bottom banner Begin
        if ($this->request->files['config_second_banner']['name']) {

      $allowed = array(
       'image/jpeg',
       'image/pjpeg',
    'image/png',
    'image/x-png',
    'image/gif',
                'application/x-shockwave-flash'
      );

   if (!in_array($this->request->files['config_second_banner']['type'], $allowed)) {
    $this->error['warning'] = $this->language->get('error_filetype');
   }

   if (!is_writable(DIR_IMAGE)) {
    $this->error['warning'] = $this->language->get('error_writable_image');
   }

   if (!is_writable(DIR_IMAGE . 'cache/')) {
    $this->error['warning'] = $this->language->get('error_writable_image_cache');
   }

   if ($this->request->files['config_second_banner']['error'] != UPLOAD_ERR_OK) {
    $this->error['warning'] = $this->language->get('error_upload_' . $this->request->files['config_second_banner']['error']);
   }
  }
        // 100217 ALNAUA Second right-bottom banner End
        // 100129 ALNAUA Home Page change, add product sorting, translite russian filename upload Begin
        if ($this->request->files['config_left_top_banner']['name']) {

      $allowed = array(
       'image/jpeg',
       'image/pjpeg',
    'image/png',
    'image/x-png',
    'image/gif',
                'application/x-shockwave-flash'
      );

   if (!in_array($this->request->files['config_left_top_banner']['type'], $allowed)) {
    $this->error['warning'] = $this->language->get('error_filetype');
   }

   if (!is_writable(DIR_IMAGE)) {
    $this->error['warning'] = $this->language->get('error_writable_image');
   }

   if (!is_writable(DIR_IMAGE . 'cache/')) {
    $this->error['warning'] = $this->language->get('error_writable_image_cache');
   }

   if ($this->request->files['config_left_top_banner']['error'] != UPLOAD_ERR_OK) {
    $this->error['warning'] = $this->language->get('error_upload_' . $this->request->files['config_left_top_banner']['error']);
   }
  }

        if ($this->request->files['config_right_top_banner']['name']) {

      $allowed = array(
       'image/jpeg',
       'image/pjpeg',
    'image/png',
    'image/x-png',
    'image/gif',
                'application/x-shockwave-flash'
      );

   if (!in_array($this->request->files['config_right_top_banner']['type'], $allowed)) {
    $this->error['warning'] = $this->language->get('error_filetype');
   }

   if (!is_writable(DIR_IMAGE)) {
    $this->error['warning'] = $this->language->get('error_writable_image');
   }

   if (!is_writable(DIR_IMAGE . 'cache/')) {
    $this->error['warning'] = $this->language->get('error_writable_image_cache');
   }

   if ($this->request->files['config_right_top_banner']['error'] != UPLOAD_ERR_OK) {
    $this->error['warning'] = $this->language->get('error_upload_' . $this->request->files['config_right_top_banner']['error']);
   }
  }
        // 100129 ALNAUA Home Page change, add product sorting, translite russian filename upload End
  if (!$this->error) {
   return TRUE;
  } else {
   return FALSE;
  }
 }

 public function zone() {
  $output = '';
  
  $this->load->model('localisation/zone');
  
  $results = $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']);
  
  foreach ($results as $result) {
   $output .= '<option value="' . $result['zone_id'] . '"';

   if (isset($this->request->get['zone_id']) && ($this->request->get['zone_id'] == $result['zone_id'])) {
    $output .= ' selected="selected"';
   }

   $output .= '>' . $result['name'] . '</option>';
  }

  if (!$results) {
   $output .= '<option value="0">' . $this->language->get('text_none') . '</option>';
  }

  $this->response->setOutput($output, $this->config->get('config_compression'));
 }
 
 public function template() {
  $template = basename($this->request->get['template']);
  
  if ((!isset($this->request->server['HTTPS'])) || ($this->request->server['HTTPS'] != 'on')) {
   $server = HTTP_IMAGE;
  } else {
   $server = HTTPS_IMAGE;
  }
  
  if (file_exists(DIR_IMAGE . 'templates/' . $template . '.png')) {
   $image = $server . 'templates/' . $template . '.png';
  } else {
   $image = $server . 'no_image.jpg';
  }
  
  $this->response->setOutput('<img src="' . $image . '" alt="" title="" style="border: 1px solid #EEEEEE;" />');
 }  
}
?>