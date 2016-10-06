<?php
class ControllerModuleRandomProduct extends Controller {
	protected function index() {
		$this->language->load('module/randomproduct');

      	$this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['promo_head'] = $this->language->get('promo_head');
        $this->data['promo_middle'] = $this->language->get('promo_middle');

		$this->load->model('catalog/product');
//		$this->load->model('catalog/review');
		$this->load->model('tool/seo_url');
		$this->load->helper('image');

		$this->data['products'] = array();

		$results = $this->model_catalog_product->getRandomProduct();

		foreach ($results as $result) {
			if ($result['image']) {
				$image = $result['image'];
			} else {
				$image = 'no_image.jpg';
			}

//			$rating = $this->model_catalog_review->getAverageRating($result['product_id']);

			$special = FALSE;

			$discount = $this->model_catalog_product->getProductDiscount($result['product_id']);

			if ($discount) {
				$price = $this->currency->format($this->tax->calculate($discount, $result['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));

				$special = $this->model_catalog_product->getProductSpecial($result['product_id']);

				if ($special) {
					$special = $this->currency->format($this->tax->calculate($special, $result['tax_class_id'], $this->config->get('config_tax')));
				}
			}

            // (+) ALNAUA 091114 (START)
            $array = explode('.', $price);
            $price_int = $array[0];
            $array = explode(' ', $array[1]);
            $price_dec = $array[0];
            $price_curr = $array[1];

            $this->data['price_int'] = $price_int;
            $this->data['price_dec'] = $price_dec;
            $this->data['price_curr'] = $price_curr;
            // (+) ALNAUA 091114 (FINISH)

			$this->data['products'][] = array(
				'name'    => $result['name'],
                'model'   => $result['model'],
				'price'   => $price,
                'price_int' => $price_int,
                'price_dec' => $price_dec,
                'price_curr' => $price_curr,
				'special' => $special,
				'image'   => image_resize($image, 230, 300),
				'href'    => $this->model_tool_seo_url->rewrite($this->url->http('product/product&product_id=' . $result['product_id']))
			);
		}

		if (!$this->config->get('config_customer_price')) {
			$this->data['display_price'] = TRUE;
		} elseif ($this->customer->isLogged()) {
			$this->data['display_price'] = TRUE;
		} else {
			$this->data['display_price'] = FALSE;
		}

		$this->id = 'randomproduct';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/randomproduct.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/randomproduct.tpl';
		} else {
			$this->template = 'default/template/module/randomproduct.tpl';
		}

		$this->render();
	}
}
?>