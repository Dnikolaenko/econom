<?php 
class ControllerCallbackOneClick extends Controller {
// private $error = array();

 public function index() {
  $this->language->load('callback/oneClick');
  
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
  $this->data['text_click_callback_time'] = $this->language->get('text_click_callback_time');
  $this->data['text_click_message'] = $this->language->get('text_click_message');
  $this->data['text_click_button_send'] = $this->language->get('text_click_button_send');
  $this->data['text_click_button_cancel'] = $this->language->get('text_click_button_cancel');

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

  if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/callback/oneClick.tpl')) {
  $this->template = $this->config->get('config_template') . '/template/callback/oneClick.tpl';
  } else {
  $this->template = 'default/template/callback/oneClick.tpl';
  }

  $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
 }
 
 public function send() {
  $this->language->load('callback/oneClick');
  
  if ($this->request->server['REQUEST_METHOD'] == 'POST') {
   
   // $subject = sprintf($this->language->get('text_contact_subject_formated'), date("d-m-y H:i:s"));
   $subject = $this->language->get('text_click_subject');


   if (isset($this->request->get['product_id'])) {
   $product_id = $this->request->get['product_id'];
   } else {
   $product_id = 0;
   }
   
   //Take id from url address
  $url = parse_url($_SERVER['HTTP_REFERER']);
  $path = str_split($url['query']);
  $i=0;
  $x=0;
  $id= array();
  foreach($path as $key=>$value){
    
    if($value == 'i' || $value == 'd' || $value == '='){
      $x++;
    }
    elseif($x==3){
      $id[] = $path[$i];  
    }
    else{
      $x=0;
    }
    if(count($id)>4){
      break;
    }
    $path[$i]=NULL;
    $i++;
  }
 $tovar_id = implode('', $id);
//take product from table
$this->load->model('catalog/product');

$product_info = $this->model_catalog_product->getProduct($tovar_id);

$p_name = $product_info['name'];

$p_model = $product_info['model'];

$this->data['product_name'] = $p_name;
$this->data['product_model'] = $p_model;
   
   $message  = $this->language->get('text_click_name'). ' ' . html_entity_decode($this->request->post['name'], ENT_QUOTES, 'UTF-8') . "\n";
   $message .= $this->language->get('text_click_phone'). ' ' .'+380'. html_entity_decode($this->request->post['phone'], ENT_QUOTES, 'UTF-8') . "\n\n";
   $message .= $this->language->get('text_click_product'). ' ' . $p_name. "\n";
   $message .= $this->language->get('text_click_model'). ' ' . $p_model. "\n";
   $message .= $this->request->get['product_id'];
   
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
     $output = ($result > 0 ? $this->language->get('text_click_sent') : $this->language->get('text_contact_error'));
    }
    
   } else {
    $output = $this->language->get('text_click_error');
   }
   
   $this->response->setOutput($output, $this->config->get('config_compression'));
   
  }
 }
}
?>
