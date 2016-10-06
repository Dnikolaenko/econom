<?php
class ControllerExportPricemonitor extends Controller {
 
 private $eof = "\n";

 public function index() {
  if ($this->config->get('yandex_market_status')) {
   $output  = '<?xml version="1.0" encoding="utf-8" ?>';
   $output .= '<!DOCTYPE yml_catalog SYSTEM "shops.dtd">';
   $output .= '<yml_catalog date="' . date("Y-m-d H:m") . '">';
   $output .= '<shop>'  . "\n";
   $output .= '<name>ЭкономТочка</name>';
   $output .= '<company>Nowy Styl Group</company>';
   $output .= '<url>' . HTTP_SERVER . '</url>'. "\n";

   // Перечесляем валюту магазина
   // TODO: Добавить возможность настраивать проценты.
   $output .= '<currencies>';
   $output .= '<currency id="UAH" rate="1"/>';
   $output .= '<currency id="RUR" rate="NBU"/>';
   $output .= '<currency id="USD" rate="NBU"/>';
   $output .= '<currency id="EUR" rate="NBU"/>';
   $output .= '</currencies>';

   // Категории товаров
   $this->load->model('catalog/category');
   $output .= '<categories>';
   $output .= $this->getCat(335);
   $output .= '</categories>';

   // Товарные позиции
   $this->load->model('catalog/product');
   $this->load->helper('image');
   $output .= '<offers>';
   $output .= $this->getProducts(335);
   $output .= '</offers>';
   $output .= '</shop>';
   $output .= '</yml_catalog>';
   $this->response->addHeader('Content-Type:', 'application/xml');
   $this->response->setOutput($output);
  }
 }

 // Возвращает массив категорий
 protected function getCat($pi=0) {
  //$categories = $this->model_catalog_category->getCategories($pi);
  //$categories = $this->model_catalog_category->getCategories($pi);
  $category = $this->model_catalog_category->getCategory($pi);
  $out = '';

  //foreach ($categories as $category) {
   $out .= '<category id="'.$category['category_id'].'"';
   //if($pi != 0)
   //  $out .= ' parentId="'.$pi.'"';
   $out .='>'.$category['name'].'</category>';
   //if($e = $this->getCat($category['category_id']))
   //  $out .= $e;
  //}
  return $out;
 }

    protected function getProducts($category=0) {
      //$categories = $this->model_catalog_category->getCategories($pi);
      $out = '';
      
      //foreach ($categories as $category) {
        $products = $this->model_catalog_product->getProductsByCategoryIdYml($category);
        foreach ($products as $product) {
            $out .= '<offer id="'.$product['product_id'].'" type="vendor.model" ' . ($product['stock_status_id'] == 7 ? 'available="true"' : 'available="false"') . '>' . $this->eof;
            $out .= '<url>'.(HTTP_SERVER . 'index.php?route=product/product&amp;product_id=' . $product['product_id']).'</url>';

            $special = $this->model_catalog_product->getProductSpecial($product['product_id']);

            if ($special) {
                $price = $this->tax->calculate($special, $product['tax_class_id']);
            } else {
                $price = $this->tax->calculate($product['price'], $product['tax_class_id']);
            }
            $out .= '<price>' . $price . '</price>';

            //$out .= '<price>' . $this->tax->calculate($product['price'], $product['tax_class_id']) . '</price>';
            $out .= '<currencyId>UAH</currencyId>';

            // Определяем категорию для товара
            //$categories = $this->model_catalog_product->getCategories($product['product_id']);
            $out .= '<categoryId>'.$category['category_id'].'</categoryId>';
            // Определеяме изображение
            if ($product['image']) {
                $out .= '<picture>' . image_resize($product['image'], 500, 500) . '</picture>';
            } else {
                $out .= '<picture>' . image_resize('no_image', 500, 500) . '</picture>';
            }
            $out .= '<delivery>' . ($product['shipping'] ? 'true' : 'false') . '</delivery>';
            //$out .= '<name></name>';
            $out .= '<typePrefix>' . $product['model'] . '</typePrefix>';
            $out .= '<vendor>' . $product['manufacturer'] . '</vendor>';
            $out .= ($product['serial_no'] ? '<vendorCode>'.$product['serial_no']. '</vendorCode>' : '');
            $out .= '<model>'.$product['name'].'</model>';           
            //$out .= '<local_delivery_cost>300</local_delivery_cost>';
            //Нет такого элемента
            //$out .= '<available>' . ($product['stock_status_id'] == 7 ? 'true' : 'false') . '</available>';
            //$out .= '<description>Сборка ' . $this->currency->format($product['sborka']) . '</description>';
            $out .= '<sales_notes>Предоплата ' . $product['prepayment'] . '%</sales_notes>';
            $out .= '<manufacturer_warranty>true</manufacturer_warranty>';
            $out .= '<country_of_origin>Украина</country_of_origin>';
            //$out .= '<downloadable>true</downloadable>';
            //$out .= '<barcode></barcode>';
            $techparams = $this->model_catalog_product->getProductTechParams($product['product_id']);
            foreach ($techparams as $techparam) {
              $out .= '<param name="' . $techparam['name'] . '"';
              if($techparam['unit'])
                $out .= ' unit="' . $techparam['unit'] . '"';
              $out .='>'.$techparam['value'].'</param>';
            }

            $out .= '</offer>';
      //  }
      //if($e = $this->getProducts($category['category_id']))
      //  $out .= $e;
      }
    return $out;
    }
}
?>