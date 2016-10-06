<?php 
class ControllerProductSearch extends Controller { 	
	public function index()
	{
		$this->language->load('product/search');

		$this->document->title = $this->language->get('heading_title');

		$this->document->breadcrumbs = array();

		$this->document->breadcrumbs[] = array(
			'href' => $this->url->http('common/home'),
			'text' => $this->language->get('text_home'),
			'separator' => FALSE
		);

		$url = '';

		if (isset($this->request->get['keyword'])) {
			$url .= '&keyword=' . $this->request->get['keyword'];
		}

		if (isset($this->request->get['description'])) {
			$url .= '&description=' . $this->request->get['description'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if(isset($this->request->get['manufacturer_id'])) {
			$url .= '&manufacturer=' . $this->request->get['manufacturer_id'];
		}

		$this->document->breadcrumbs[] = array(
			'href' => $this->url->http('product/search' . $url),
			'text' => $this->language->get('heading_title'),
			'separator' => $this->language->get('text_separator')
		);

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_critea'] = $this->language->get('text_critea');
		$this->data['text_search'] = $this->language->get('text_search');
		$this->data['text_keywords'] = $this->language->get('text_keywords');
		$this->data['text_empty'] = $this->language->get('text_empty');
		$this->data['text_sort'] = $this->language->get('text_sort');
		$this->data['text_man'] = $this->language->get('text_man');
		$this->data['text_select'] = $this->language->get('text_select');

		$this->data['entry_search'] = $this->language->get('entry_search');
		$this->data['entry_description'] = $this->language->get('entry_description');

		$this->data['button_search'] = $this->language->get('button_search');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.price';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}

		if (isset($this->request->get['keyword'])) {
			$this->data['keyword'] = $this->request->get['keyword'];
		} else {
			$this->data['keyword'] = '';
		}

		if (isset($this->request->get['description'])) {
			$this->data['description'] = $this->request->get['description'];
		} else {
			$this->data['description'] = '';
		}

		$manufactur = $_GET['manufacturer_id'];

		if (isset($manufactur)) {
			$this->data['manufacturer'] = $manufactur;
		} else {
			$this->data['manufacturer'] = '';
		}

		$this->load->model('catalog/manufacturer');
		$man = $this->model_catalog_manufacturer->getManufactures();
		//var_dump($man);
		$this->data['manf'] = $man;


		if (isset($this->request->get['keyword'])) {
			$this->load->model('catalog/product');

			$product_total = $this->model_catalog_product->getTotalProductsByKeyword($this->request->get['keyword'], isset($this->request->get['description']) ? $this->request->get['description'] : '', $manufactur);
            //$product_total = $this->model_catalog_product->getTotalProductsByManufacturerId($manufactur);

			if ($product_total) {
				$url = '';

				if (isset($this->request->get['description'])) {
					$url .= '&description=' . $this->request->get['description'];
				}

				$this->load->model('catalog/review');
				$this->load->model('tool/seo_url');
				$this->load->helper('image');

				$this->data['products'] = array();

				if (isset($manufactur)) {
					$results = $this->model_catalog_product->getProductbyManuf($this->request->get['keyword'], isset($this->request->get['description']) ? $this->request->get['description'] : '', $manufactur, $sort, $order, ($page - 1) * 20, 20);
				} else {
					$results = $this->model_catalog_product->getProductsByKeyword($this->request->get['keyword'], isset($this->request->get['description']) ? $this->request->get['description'] : '', $sort, $order, ($page - 1) * 20, 20);
				}

				foreach ($results as $result) {
					if ($result['image']) {
						$image = $result['image'];
					} else {
						$image = 'no_image.jpg';
					}

					//var_dump($result);

					//$rating = $this->model_catalog_review->getAverageRating($result['product_id']);

					//$this->data['manf'] = array();

					//$this->data['manf'][] = array(
					//'text'  => $result['manufacturer'],
					//'value' => $result['manufacturer_id']
					//);

					if ($result["power"] == 1) {
						$akcia = TRUE;
						$this->data['akcia'] = TRUE;
					} else if ($result["power"] == 0) {
						$akcia = FALSE;
						$this->data['akcia'] = FALSE;
					}

					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));


					$this->data['products'][] = array(
						'name'   => $result['name'],
						'model'  => $result['model'],
						'manu'   => $result['manufacturer_id'],
						'thumb'  => image_resize($image, $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height')),
						'akcia'  => $akcia,
						'price'  => $price,
						'special'=> $special,
						'href'   => $this->model_tool_seo_url->rewrite($this->url->http('product/product&keyword=' . $this->request->get['keyword'] . $url . '&product_id=' . $result['product_id'])),
					);
				}

				if (!$this->config->get('config_customer_price')) {
					$this->data['display_price'] = TRUE;
				} elseif ($this->customer->isLogged()) {
					$this->data['display_price'] = TRUE;
				} else {
					$this->data['display_price'] = FALSE;
				}

				$url = '';

				if (isset($this->request->get['keyword'])) {
					$url .= '&keyword=' . $this->request->get['keyword'];
				}

				if (isset($this->request->get['description'])) {
					$url .= '&description=' . $this->request->get['description'];
				}

				if (isset($this->request->get['page'])) {
					$url .= '&page=' . $this->request->get['page'];
				}

				if (isset($this->request->get['manufacturer_id'])) {
					$url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
				}

				$this->data['sorts'] = array();

				$this->data['sorts'][] = array(
					'text' => $this->language->get('text_name_asc'),
					'value' => 'pd.name-ASC',
					'href' => $this->url->http('product/search' . $url . '&sort=pd.name&order=ASC')
				);

				$this->data['sorts'][] = array(
					'text' => $this->language->get('text_name_desc'),
					'value' => 'pd.name-DESC',
					'href' => $this->url->http('product/search' . $url . '&sort=pd.name&order=DESC')
				);

				$this->data['sorts'][] = array(
					'text' => $this->language->get('text_price_asc'),
					'value' => 'p.price-ASC',
					'href' => $this->url->http('product/search' . $url . '&sort=p.price&order=ASC')
				);

				$this->data['sorts'][] = array(
					'text' => $this->language->get('text_price_desc'),
					'value' => 'p.price-DESC',
					'href' => $this->url->http('product/search' . $url . '&sort=p.price&order=DESC')
				);

				$url = '';

				if (isset($this->request->get['keyword'])) {
					$url .= '&keyword=' . $this->request->get['keyword'];
				}

				if (isset($this->request->get['description'])) {
					$url .= '&description=' . $this->request->get['description'];
				}

				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
				}

				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
				}

				if (isset($this->request->get['manufacturer_id'])) {
					$url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
				}

				$pagination = new Pagination();
				$pagination->total = $product_total;
				$pagination->page = $page;
				$pagination->limit = 20;
				$pagination->text = $this->language->get('text_pagination');
				$pagination->url = $this->url->http('product/search' . $url . '&page=%s');

				$this->data['pagination'] = $pagination->render();

				$this->data['sort'] = $sort;
				$this->data['order'] = $order;
			}

		}

  
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/search.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/product/search.tpl';
		} else {
			$this->template = 'default/template/product/search.tpl';
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
?>