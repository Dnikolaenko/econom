<?php
class ControllerCatalogQuestion extends Controller { 
	private $error = array();

	public function index() {
		$this->load->language('catalog/question');

		$this->document->title = $this->language->get('heading_title');
		 
		$this->load->model('catalog/question');

		$this->getList();
	}

	public function insert() {
		$this->load->language('catalog/question');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('catalog/question');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $data = array();
            
			$this->model_catalog_question->addQuestion(array_merge($this->request->post, $data));
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
      		
			$this->redirect($this->url->https('catalog/question' . $url));
		}

		$this->getForm();
	}

	public function update() {
		$this->load->language('catalog/question');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('catalog/question');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_question->editQuestion($this->request->get['question_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
						
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->https('catalog/question' . $url));
		}

		$this->getForm();
	}
 
	public function delete() {
		$this->load->language('catalog/question');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('catalog/question');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $information_id) {
				$this->model_catalog_question->deleteQuestion($information_id);
			}
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
						
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->https('catalog/question' . $url));
		}

		$this->getList();
	}

	private function getList() {

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		$url = '';
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

  		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('common/home'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('catalog/question' . $url),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
							
		$this->data['insert'] = $this->url->https('catalog/question/insert' . $url);
		$this->data['delete'] = $this->url->https('catalog/question/delete' . $url);	

		$this->data['questions'] = array();

		$data = array(
			'start' => ($page - 1) * 10,
			'limit' => 10
		);
		
		$information_total = $this->model_catalog_question->getTotalQuestions();
	
		$results = $this->model_catalog_question->getQuestions($data);
 
    	foreach ($results as $result) {
			$action = array();
						
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->https('catalog/question/update&question_id=' . $result['question_id'] . $url)
			);
						
			$this->data['questions'][] = array(
				'question_id' => $result['question_id'],
				'text'      => $result['text'],
				'selected'   => isset($this->request->post['selected']) && in_array($result['question_id'], $this->request->post['selected']),
				'action'     => $action
			);
		}	
	
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_text'] = $this->language->get('column_text');
		$this->data['column_action'] = $this->language->get('column_action');		
		
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
 
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

		$url = '';

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$url = '';
		
		$pagination = new Pagination();
		$pagination->total = $information_total;
		$pagination->page = $page;
		$pagination->limit = 10; 
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->https('catalog/question' . $url . '&page=%s');
			
		$this->data['pagination'] = $pagination->render();

		$this->template = 'catalog/question_list.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	private function getForm() {

     
     if (isset($this->error['warning'])) {
      $this->data['error_warning'] = $this->error['warning'];
    } else {
      $this->data['error_warning'] = '';
    }

        $this->data['tab_general'] = $this->language->get('tab_general');
        
		$this->data['entry_name'] = $this->language->get('entry_name');
        $this->data['entry_text'] = $this->language->get('entry_text');
		$this->data['entry_email'] = $this->language->get('entry_email');
		$this->data['entry_answer'] = $this->language->get('entry_answer');
		$this->data['entry_published'] = $this->language->get('entry_published');
        $this->data['entry_date_added'] = $this->language->get('entry_date_added');
        $this->data['text_yes'] = $this->language->get('text_yes');
        $this->data['text_no'] = $this->language->get('text_no');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');


  		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('common/home'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('catalog/question'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
		$url = '';
			
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$this->data['heading_title'] = $this->language->get('heading_title');
							
		if (!isset($this->request->get['question_id'])) {
			$this->data['action'] = $this->url->https('catalog/question/insert' . $url);
		} else {
			$this->data['action'] = $this->url->https('catalog/question/update&question_id=' . $this->request->get['question_id'] . $url);
		}
		
		$this->data['cancel'] = $this->url->https('catalog/question' . $url);

		if (isset($this->request->get['question_id'])) {
			$question_info = $this->model_catalog_question->getQuestion($this->request->get['question_id']);
		}
		
		$this->load->model('localisation/language');

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

        if (isset($this->request->post['name'])) {
			$this->data['name'] = $this->request->post['name'];
		} elseif (isset($question_info)) {
			$this->data['name'] = $question_info['name'];
		} else {
			$this->data['name'] = '';
		}

        if (isset($this->request->post['email'])) {
			$this->data['email'] = $this->request->post['email'];
		} elseif (isset($question_info)) {
			$this->data['email'] = $question_info['email'];
		} else {
			$this->data['email'] = '';
		}

        if (isset($this->request->post['text'])) {
			$this->data['text'] = $this->request->post['text'];
		} elseif (isset($question_info)) {
			$this->data['text'] = $question_info['text'];
		} else {
			$this->data['text'] = '';
		}
        
        if (isset($this->request->post['answer'])) {
			$this->data['answer'] = $this->request->post['answer'];
		} elseif (isset($question_info)) {
			$this->data['answer'] = $question_info['answer'];
		} else {
			$this->data['answer'] = '';
		}
        
        if (isset($this->request->post['published'])) {
			$this->data['published'] = $this->request->post['published'];
		} elseif (isset($question_info)) {
			$this->data['published'] = $question_info['published'];
		} else {
			$this->data['published'] = 0;
		}

		if (isset($this->request->post['date_added'])) {
			$this->data['date_added'] = $this->request->post['date_added'];
		} elseif (isset($question_info)) {
			$this->data['date_added'] = $question_info['date_added'];
		} else {
			$this->data['date_added'] = date('Y') . '-' . date('m') . '-' . date('d');
		}

        //$this->data['question'] = $question_info;
        
		$this->template = 'catalog/question_form.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/question')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

//        if ($this->request->post['email'] == $this->language->get('text_email')) {
//          $this->error['email'] = $this->language->get('error_email');
//        } else
        if ((strlen(utf8_decode($this->request->post['email'])) < 3) || (strlen(utf8_decode($this->request->post['email'])) > 255)) {
            $this->error['email'] = $this->language->get('error_email');
        }

//        if ($this->request->post['name'] == $this->language->get('text_name')) {
//          $this->error['name'] = $this->language->get('error_name');
//        } else
        if ((strlen(utf8_decode($this->request->post['name'])) < 3) || (strlen(utf8_decode($this->request->post['name'])) > 255)) {
            $this->error['name'] = $this->language->get('error_name');
        }

        $pattern = '/^([a-z0-9])(([-a-z0-9._])*([a-z0-9]))*\@([a-z0-9])(([a-z0-9-])*([a-z0-9]))+(\.([a-z0-9])([-a-z0-9_-])?([a-z0-9])+)+$/i';

//        if ($this->request->post['email'] == $this->language->get('text_email')) {
//          $this->error['email'] = $this->language->get('error_email');
//        } else
        if (!preg_match($pattern, $this->request->post['email'])) {
            $this->error['email'] = $this->language->get('error_email_input');
        }


		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/question')) {
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