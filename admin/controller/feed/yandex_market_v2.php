<?php
class ControllerFeedYandexMarketV2 extends Controller {

 private $error = array();

 public function index() {
  $this->load->language('feed/yandex_market_v2');

  $this->document->title = $this->language->get('heading_title');

  $this->load->model('setting/setting');

  if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
   $this->load->model('setting/setting');
   
   $data = $this->request->post;
   
   if (isset($this->request->post['export_category_list'])) {
    $data['export_category_list'] = serialize($this->request->post['export_category_list']);
   } else {
    $data['export_category_list'] = serialize(array());
   }

   $this->model_setting_setting->editSetting('yandex_market_v2', $data);

   $this->session->data['success'] = $this->language->get('text_success');

   $this->redirect($this->url->https('extension/feed'));
  }

  $this->data['heading_title'] = $this->language->get('heading_title');

  $this->data['text_enabled'] = $this->language->get('text_enabled');
  $this->data['text_disabled'] = $this->language->get('text_disabled');
  $this->data['text_data_feed_schedule_time'] = $this->language->get('text_data_feed_schedule_time');

  $this->data['entry_status'] = $this->language->get('entry_status');
  $this->data['entry_data_feed_on_fly'] = $this->language->get('entry_data_feed_on_fly');
  $this->data['entry_data_feed_schedule'] = $this->language->get('entry_data_feed_schedule');
  $this->data['entry_data_feed_schedule_time'] = $this->language->get('entry_data_feed_schedule_time');
  $this->data['entry_export_category_list'] = $this->language->get('entry_export_category_list');

  $this->data['button_save'] = $this->language->get('button_save');
  $this->data['button_cancel'] = $this->language->get('button_cancel');

  $this->data['tab_general'] = $this->language->get('tab_general');
  
  $this->load->model('catalog/category');
  
  $this->data['categories'] = $this->model_catalog_category->getCategories(0);

  if (isset($this->error['warning'])) {
   $this->data['error_warning'] = $this->error['warning'];
  } else {
   $this->data['error_warning'] = '';
  }

  $this->document->breadcrumbs = array();

  $this->document->breadcrumbs[] = array(
   'href'      => $this->url->https('common/home'),
   'text'      => $this->language->get('text_home'),
   'separator' => FALSE
  );

  $this->document->breadcrumbs[] = array(
   'href'      => $this->url->https('extension/feed'),
   'text'      => $this->language->get('text_feed'),
   'separator' => ' :: '
  );

  $this->document->breadcrumbs[] = array(
   'href'      => $this->url->https('feed/yandex_market_v2'),
   'text'      => $this->language->get('heading_title'),
   'separator' => ' :: '
  );

  $this->data['action'] = $this->url->https('feed/yandex_market_v2');

  $this->data['cancel'] = $this->url->https('extension/feed');

  if (isset($this->request->post['yandex_market_v2_status'])) {
   $this->data['yandex_market_v2_status'] = $this->request->post['yandex_market_v2_status'];
  } else {
   $this->data['yandex_market_v2_status'] = $this->config->get('yandex_market_v2_status');
  }
  
  $export_category_list = unserialize($this->config->get('export_category_list'));
  
  if (isset($this->request->post['export_category_list'])) {
   $this->data['export_category_list'] = $this->request->post['export_category_list'];
  } elseif (isset($export_category_list)) {
   $this->data['export_category_list'] = $export_category_list;
  } else {
   $this->data['export_category_list'] = array();
  }

  $this->data['data_feed_on_fly'] = HTTP_CATALOG . 'index.php?route=export/yandex_market_v2';
  $this->data['data_feed_schedule'] = HTTP_CATALOG . 'download/yandex_market_v2.yml';

  $this->template = 'feed/yandex_market_v2.tpl';
  $this->children = array(
   'common/header',
   'common/footer'
  );

  $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
 }

 private function validate() {
  if (!$this->user->hasPermission('modify', 'feed/yandex_market_v2')) {
   $this->error['warning'] = $this->language->get('error_permission');
  }

  if (!$this->error) {
   return TRUE;
  } else {
   return FALSE;
  }
 }
}
?>
