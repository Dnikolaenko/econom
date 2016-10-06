<?php 
class ControllerInformationNews extends Controller {
	public function index() {  
    	$this->language->load('information/news');
		
		$this->load->model('catalog/information');

        // (+) ALNAUA 091114 (START)
        $this->document->active = 'news';
        // (+) ALNAUA 091114 (FINISH)
		
		$this->document->breadcrumbs = array();

      	$this->document->breadcrumbs[] = array(
        	'href'      => $this->url->http('common/home'),
        	'text'      => $this->language->get('text_home'),
        	'separator' => FALSE
      	);
		
		$news_info = $this->model_catalog_information->getNews();
   		
		if ($news_info) {
	  		$this->document->title = $this->language->get('text_news');

      		$this->document->breadcrumbs[] = array(
        		'href'      => $this->url->http('information/news'),
        		'text'      => $this->language->get('text_news'),
        		'separator' => $this->language->get('text_separator')
      		);		

            foreach ($news_info as $result) {
            
            $this->data['news'][] = array(
           			//'anons'       => html_entity_decode($result['anons'], ENT_QUOTES, 'UTF-8'),
                    'anons'       => $result['anons'],
					'date_added'  => date('d.m.Y', strtotime($result['date_added'])),
					'href'        => $this->url->http('information/information&information_id=' . $result['information_id'])
       			);
            }
            $this->data['heading_title'] = $this->language->get('text_news');
      		
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/news.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/information/news.tpl';
			} else {
				$this->template = 'default/template/information/news.tpl';
			}
			
			$this->children = array(
				'common/header',
				'common/footer',
				'common/column_left',
				'common/column_right'
			);		
			
	  		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
    	} else {
      		$this->document->breadcrumbs[] = array(
        		'href'      => $this->url->http('information/news'),
        		'text'      => $this->language->get('text_news'),
        		'separator' => $this->language->get('text_separator')
      		);
				
	  		$this->document->title = $this->language->get('text_news');
			
      		$this->data['heading_title'] = $this->language->get('text_news');

      		$this->data['text_error'] = $this->language->get('text_error');

      		$this->data['button_continue'] = $this->language->get('button_continue');

      		$this->data['continue'] = $this->url->http('common/home');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
			} else {
				$this->template = 'default/template/error/not_found.tpl';
			}
			
			$this->children = array(
				'common/header',
				'common/footer',
				'common/column_left',
				'common/column_right'
			);
		
	  		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
    	}
  	}
}
?>