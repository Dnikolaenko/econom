<?php 
class ControllerCallbackOneClickCall extends Controller {
// private $error = array();

 public function index() {

  $this->language->load('callback/OneClickCall');
  //send product id
  if (isset($this->request->get['path'])) {
   $path = '';

//id
if ($this->request->server['REQUEST_METHOD'] == 'POST') {
   
   $product_id = $_POST['data']['product_id'];

   $this->load->model('catalog/product');
  
  if (isset($this->request->get['product_id'])) {
   $product_id = $this->request->get['product_id'];
  } else {
   $product_id = 5;
  }
}

  $this->data['token'] = swift_token($this->config->get('config_email'));   
   
   foreach (explode('_', $this->request->get['path']) as $path_id) {
    $category_info = $this->model_catalog_category->getCategory($path_id);
    
    if (!$path) {
     $path = $path_id;
    } else {
     $path .= '_' . $path_id;
    }
  }
}
  // Settings
  $this->data['settings'] = array(
    'callback_time'     => false,
    'show_message'      => false,
    'ip'                => true,
    'user_agent'        => true
  );

  $this->data['text_click_title'] = $this->language->get('text_click_title');
  $this->data['text_click_name'] = $this->language->get('text_click_name');
  $this->data['text_click_phone'] = $this->language->get('text_click_phone');
  $this->data['text_click_product'] = $this->language->get('text_click_product');
  $this->data['text_click_model'] = $this->language->get('text_click_model');
  $this->data['text_click_callback_time'] = $this->language->get('text_click_callback_time');
  $this->data['text_click_message'] = $this->language->get('text_click_message');
  $this->data['text_click_button_send'] = $this->language->get('text_click_button_send');
  $this->data['text_click_button_cancel'] = $this->language->get('text_click_button_cancel');
  $this->data['text_click_product'] = $this->language->get('text_click_product');
  $this->data['text_click_model'] = $this->language->get('text_click_model');
  //$this->data['product_id'] = $product_id;
  if ($this->data['settings']['callback_time']) {
    $this->data['text_click_bottom'] = $this->language->get('text_click_bottom_time');
  } else {
    $this->data['text_click_bottom'] = $this->language->get('text_click_bottom');
  }
 
//  if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
//   $mail = new Mail($this->config->get('config_mail_protocol'), $this->config->get('config_smtp_host'), $this->config->get('config_smtp_username'), html_entity_decode($this->config->get('config_smtp_password')), $this->config->get('config_smtp_port'), $this->config->get('config_smtp_timeout'));
//   $mail->setTo($this->config->get('config_email'));
//   $mail->setFrom($this->request->post['email']);
//   $mail->setSender(html_entity_decode($this->request->post['name'], ENT_QUOTES, 'UTF-8'));
//   $mail->setSubject(sprintf($this->language->get('email_subject'), $this->request->post['name']));
//   $mail->setText(strip_tags(html_entity_decode($this->request->post['enquiry'], ENT_QUOTES, 'UTF-8')));
//   $mail->send();
//
//   $this->redirect($this->url->https('information/contact/success'));
//  }

  if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/callback/OneClickCall.tpl')) {
  $this->template = $this->config->get('config_template') . '/template/callback/OneClickCall.tpl';
  } else {
  $this->template = 'default/template/callback/OneClickCall.tpl';
  }
  $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
 
 }
 
 public function send() {
  $this->language->load('callback/OneClickCall');
  
    if ($this->request->server['REQUEST_METHOD'] == 'GET') {
   
    if ($this->request->get['product_id'] == 1718 || $this->request->get['product_id'] == 4595 || $this->request->get['product_id'] == 4601){
    $da = TRUE;
    $this->data['da'] = $da;
   }
   else {
    $da = FALSE;
    $this->data['da'] = $da;
   }

   $this->load->model('catalog/product');
  
  if (isset($this->request->get['product_id'])) {
   $product_id = $this->request->get['product_id'];
  } else {
   $product_id = 0;
  }
   // $subject = sprintf($this->language->get('text_contact_subject_formated'), date("d-m-y H:i:s"));
   $subject = $this->language->get('text_click_subject');
   
   $message  = $this->language->get('text_click_name'). ' ' . html_entity_decode($this->request->post['name'], ENT_QUOTES, 'UTF-8') . "\n";
   $message .= $this->language->get('text_click_phone'). ' ' . html_entity_decode($this->request->post['phone'], ENT_QUOTES, 'UTF-8') . "\n\n";
   $message .= $this->language->get('text_click_product'). ' ' . 'dima'; //html_entity_decode($this->request->post['product'], ENT_QUOTES, 'UTF-8') . "\n\n";
   $message .= $this->language->get('text_click_model'). ' ' . 'eto zalupa';//html_entity_decode($this->request->post['model'], ENT_QUOTES, 'UTF-8') . "\n\n";
   
   if (isset($this->request->post['subject'])) {
    $message .= $this->language->get('text_click_callback_time'). ' ' . html_entity_decode($this->request->post['subject'], ENT_QUOTES, 'UTF-8') . "\n";
   }
   if (isset($this->request->post['message'])) {
    $message .= $this->language->get('text_click_message'). ' ' . html_entity_decode($this->request->post['message'], ENT_QUOTES, 'UTF-8') . "\n";
   }
   
   if($this->request->post['token'] === swift_token($this->config->get('config_email'))){

    if ($this->config->get('config_mail_protocol') == 'mail' || $this->config->get('config_mail_protocol') == 'smtp') {
     $mail = new Mail($this->config->get('config_mail_protocol'), $this->config->get('config_smtp_host'), $this->config->get('config_smtp_username'), html_entity_decode($this->config->get('config_smtp_password'), ENT_QUOTES, 'UTF-8'), $this->config->get('config_smtp_port'), $this->config->get('config_smtp_timeout'));
     $mail->setTo($this->config->get('config_admin_email'));
     $mail->setFrom($this->config->get('config_email'));
     $mail->setSender(html_entity_decode($this->config->get('config_store'), ENT_QUOTES, 'UTF-8'));
     $mail->setSubject($subject);
     $mail->setText($message);
     $mail->send();
     $output = $this->language->get('text_contact_sent');
    } elseif ($this->config->get('config_mail_protocol') == 'swift') {
     $settings = array(
         'config_smtp_host' => $this->config->get('config_smtp_host'),
         'config_smtp_username' => $this->config->get('config_smtp_username'),
         'config_smtp_password' => html_entity_decode($this->config->get('config_smtp_password'), ENT_QUOTES, 'UTF-8'),
         'config_smtp_port' => $this->config->get('config_smtp_port')
     );
     $result = swift_send(
             $settings,
             array($this->config->get('config_email') => html_entity_decode($this->config->get('config_store'), ENT_QUOTES, 'UTF-8')), //from
             array($this->config->get('config_admin_email') => html_entity_decode($this->config->get('config_store'), ENT_QUOTES, 'UTF-8')), //replyto
             array($this->config->get('config_admin_email') => html_entity_decode($this->config->get('config_store'), ENT_QUOTES, 'UTF-8')), //to
             $subject, //subject
             $message,  //message
             explode(';', $this->config->get('config_bcc_email')) //bcc
             );
     $output = ($result > 0 ? $this->language->get('text_click_sent') : $this->language->get('text_click_error'));
    }
    
   } else {
    $output = $this->language->get('text_click_error');
   }
   
   $this->response->setOutput($output, $this->config->get('config_compression'));
   
  }
 }
}
?>
