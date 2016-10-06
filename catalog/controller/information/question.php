<?php 
class ControllerInformationQuestion extends Controller {
    private $error = array();

 public function index() {  
    
      $this->language->load('information/question');

      $this->load->model('catalog/information');

      $this->document->active = 'ask';

      $this->document->breadcrumbs = array();

      $this->document->breadcrumbs[] = array(
          'href'      => $this->url->http('common/home'),
          'text'      => $this->language->get('text_home'),
          'separator' => FALSE
      );

      $this->document->breadcrumbs[] = array(
          'href'      => $this->url->http('information/question'),
          'text'      => $this->language->get('text_question'),
          'separator' => $this->language->get('text_separator')
      );

      $this->data['questions'] = $this->model_catalog_information->getQuestions();
      $this->document->title = $this->language->get('text_question');
      $this->data['heading_title'] = $this->language->get('text_question');
      $this->data['button_send_question'] = $this->language->get('button_send_question');
      $this->data['entry_name'] = $this->language->get('entry_name');
      $this->data['entry_text'] = $this->language->get('entry_text');
      $this->data['entry_email'] = $this->language->get('entry_email');
      $this->data['entry_captcha'] = $this->language->get('entry_captcha');

      // 110418 ET-110411 Director Claim Begin
      $this->data['entry_to_manager'] = $this->language->get('entry_to_manager');
      $this->data['entry_to_director'] = $this->language->get('entry_to_director');

      // 110418 ET-110411 Director Claim End

      if (($this->request->server['REQUEST_METHOD'] == 'POST') ) {
        if ($this->validateForm()) {
          $this->load->model('catalog/information');
          if ((strrpos($this->request->post['text'], '[/url]') === FALSE) && (strrpos($this->request->post['text'], 'a href=') === FALSE)) {
            $this->model_catalog_information->createQuestion( $this->request->post['name'],
                                                              $this->request->post['email'],
                                                              strip_tags($this->request->post['text']),
                                                              $this->request->post['type']
            );
            $this->session->data['success'] = $this->language->get('text_success');
          }
        }
      }

      if (isset($this->error['warning'])) {
          $this->data['error_warning'] = $this->error['warning'];
      } else {
          $this->data['error_warning'] = '';
      }

      if (isset($this->session->data['success'])) {
          $this->data['success'] = $this->session->data['success'];

          unset($this->session->data['success']);
      } else {
          $this->data['success'] = '';
      }

      if (isset($this->error['email'])) {
          $this->data['error_email'] = $this->error['email'];
      } else {
          $this->data['error_email'] = '';
      }

      if (isset($this->error['name'])) {
          $this->data['error_name'] = $this->error['name'];
      } else {
          $this->data['error_name'] = '';
      }

      if (isset($this->error['text'])) {
          $this->data['error_text'] = $this->error['text'];
      } else {
          $this->data['error_text'] = '';
      }

      if (isset($this->error['captcha'])) {
          $this->data['error_captcha'] = $this->error['captcha'];
      } else {
          $this->data['error_captcha'] = '';
      }

      if (isset($this->request->post['name'])) {
          $this->data['name'] = $this->request->post['name'];
//      } elseif (isset($question_info)) {
//          $this->data['name'] = $question_info['name'];
      } else {
          $this->data['name'] = $this->language->get('entry_name');
      }

      if (isset($this->request->post['email'])) {
          $this->data['email'] = $this->request->post['email'];
      } else {
          $this->data['email'] = $this->language->get('entry_email');
      }

      if (isset($this->request->post['text'])) {
          $this->data['text'] = $this->request->post['text'];
      } else {
          $this->data['text'] = '';
      }

      if (isset($this->request->post['type'])) {
          $this->data['type'] = $this->request->post['type'];
      } else {
          $this->data['type'] = 'ask';
      }

      $this->template = $this->config->get('config_template') . '/template/information/question.tpl';

      $this->children = array(
        'common/header',
        'common/footer',
        'common/column_left',
        'common/column_right'
      );

      $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
        
   }
    
  public function create () {
    if (($this->request->server['REQUEST_METHOD'] == 'POST') ) {
      if ($this->validateForm()) {
        $this->load->model('catalog/information');
        
        if ((strrpos($this->request->post['text'], '[/url]') === FALSE) && (strrpos($this->request->post['text'], 'a href=') === FALSE)) {
          $this->model_catalog_information->createQuestion( $this->request->post['name'],
                                                            $this->request->post['email'],
                                                            strip_tags($this->request->post['text']),
                                                            $this->request->post['type']
          );
        }
      }
    }
    
    //$this->redirect($this->url->http('information/question'));
  }
  
  private function validateForm() {
    if ($this->request->post['email'] == $this->language->get('entry_email')) {
      $this->error['email'] = $this->language->get('error_email');
    } elseif ((strlen(utf8_decode($this->request->post['email'])) < 3) || (strlen(utf8_decode($this->request->post['email'])) > 255)) {
        $this->error['email'] = $this->language->get('error_email');
    }

    if ($this->request->post['name'] == $this->language->get('entry_name')) {
      $this->error['name'] = $this->language->get('error_name_input');
    } elseif ((strlen(utf8_decode($this->request->post['name'])) < 3) || (strlen(utf8_decode($this->request->post['name'])) > 255)) {
        $this->error['name'] = $this->language->get('error_name');
    }

    if ($this->request->post['text'] == '') {
      $this->error['text'] = $this->language->get('error_text');
    }

    $pattern = '/^([a-z0-9])(([-a-z0-9._])*([a-z0-9]))*\@([a-z0-9])(([a-z0-9-])*([a-z0-9]))+(\.([a-z0-9])([-a-z0-9_-])?([a-z0-9])+)+$/i';

    if ($this->request->post['email'] == $this->language->get('entry_email')) {
      $this->error['email'] = $this->language->get('error_email_input');
    } elseif (!preg_match($pattern, $this->request->post['email'])) {
        $this->error['email'] = $this->language->get('error_email_invalid');
    }

    if ($this->session->data['captcha'] != $this->request->post['captcha']) {
        $this->error['captcha'] = $this->language->get('error_captcha');
    }

   if (!$this->error) {
        return TRUE;
    } else {
        return FALSE;
    }
  }

  public function captcha() {
    $this->load->library('captcha');

    $captcha = new Captcha();

    $this->session->data['captcha'] = $captcha->getCode();

    $captcha->showImage();
}
}
?>