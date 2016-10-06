<?php  
class ControllerCommonFooter extends Controller {
 protected function index() {
  $this->language->load('common/footer');

  // 100129 ALNAUA Home Page change, add product sorting, translite russian filename upload Begin
  $this->data['bottom_message'] = html_entity_decode($this->config->get('config_bottom_message_' . $this->language->getId()));
  // 100129 ALNAUA Home Page change, add product sorting, translite russian filename upload End

  $this->data['text_powered_by'] = sprintf($this->language->get('text_powered_by'));
  $this->data['text_right'] = sprintf($this->language->get('text_right'));
  $this->data['text_copy'] = sprintf($this->language->get('text_copy'), date('Y', time()));
  $this->data['text_line'] = $this->language->get('text_line');
  
  $this->id = 'footer';

  if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/footer.tpl')) {
   $this->template = $this->config->get('config_template') . '/template/common/footer.tpl';
  } else {
   $this->template = 'default/template/common/footer.tpl';
  }
  
  $this->render();
 }
}
?>