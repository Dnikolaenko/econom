<?php 
class ControllerCallbackCallback extends Controller {
// private $error = array();

 public function index() {
  $this->language->load('callback/callback');
  
  // Settings
  $this->data['settings'] = array(
    'callback_time'     => false,
    'show_message'      => false,
    'ip'                => true,
    'user_agent'        => true
  );
  
  $this->data['text_contact_title'] = $this->language->get('text_contact_title');
  $this->data['text_contact_name'] = $this->language->get('text_contact_name');
  $this->data['text_contact_phone'] = $this->language->get('text_contact_phone');
  $this->data['text_contact_callback_time'] = $this->language->get('text_contact_callback_time');
  $this->data['text_contact_message'] = $this->language->get('text_contact_message');
  $this->data['text_contact_button_send'] = $this->language->get('text_contact_button_send');
  $this->data['text_contact_button_cancel'] = $this->language->get('text_contact_button_cancel');
  if ($this->data['settings']['callback_time']) {
    $this->data['text_contact_bottom'] = $this->language->get('text_contact_bottom_time');
  } else {
    $this->data['text_contact_bottom'] = $this->language->get('text_contact_bottom');
  }
  
  $this->data['token'] = swift_token($this->config->get('config_email'));

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

  if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/callback/callback.tpl')) {
  $this->template = $this->config->get('config_template') . '/template/callback/callback.tpl';
  } else {
  $this->template = 'default/template/callback/callback.tpl';
  }

  $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
 }
 
 public function send() {
  $this->language->load('callback/callback');
  
  if ($this->request->server['REQUEST_METHOD'] == 'POST') {
   
   // $subject = sprintf($this->language->get('text_contact_subject_formated'), date("d-m-y H:i:s"));
   $subject = $this->language->get('text_contact_subject');
   
   $message  = $this->language->get('text_contact_name'). ' ' . html_entity_decode($this->request->post['name'], ENT_QUOTES, 'UTF-8') . "\n";
   $message .= $this->language->get('text_contact_phone'). ' ' . html_entity_decode($this->request->post['phone'], ENT_QUOTES, 'UTF-8') . "\n\n";
   
   if (isset($this->request->post['subject'])) {
    $message .= $this->language->get('text_contact_callback_time'). ' ' . html_entity_decode($this->request->post['subject'], ENT_QUOTES, 'UTF-8') . "\n";
   }
   if (isset($this->request->post['message'])) {
    $message .= $this->language->get('text_contact_message'). ' ' . html_entity_decode($this->request->post['message'], ENT_QUOTES, 'UTF-8') . "\n";
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
     $output = ($result > 0 ? $this->language->get('text_contact_sent') : $this->language->get('text_contact_error'));
    }
    
   } else {
    $output = $this->language->get('text_contact_error');
   }
   
   $this->response->setOutput($output, $this->config->get('config_compression'));
   
  }
 }
}
?>
