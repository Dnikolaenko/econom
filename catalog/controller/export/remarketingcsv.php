<?php
class ControllerExportRemarketingcsv extends Controller
{

    private $CSV_SEPARATOR = ';';
    private $CSV_ENCLOSURE = '"';
    private $OUTPUT_DIR = DIR_DOWNLOAD;

    private $setting = array();

    public function index()
    {

        if (isset($this->request->get['type'])) {
            $this->setting['type'] = $this->request->get['type'];
        } else {
            $this->setting['type'] = 'CSV';
        }

        $output = '';

        $charset = ini_get('default_charset');
        ini_set('default_charset', 'UTF-8');

        if ($this->setting['type'] == 'CSV') {
            $data = array();

            $file = $this->OUTPUT_DIR . '/remarketing.csv';

            if (($handle = fopen($file, 'w')) !== FALSE) {

                $this->load->model('catalog/category');
                $this->load->model('catalog/product');
                $this->load->helper('image');
                $this->load->model('tool/seo_url');

                $this->model_catalog_product->cleanExportedProducts();

                $data = $this->getProducts(0);

                foreach ($data as $row) {
                    fputcsv($handle, $row, $this->CSV_SEPARATOR, $this->CSV_ENCLOSURE);
                }
                fclose($handle);

                if (($output = file_get_contents($file)) !== FALSE ) {
//                    $this->response->addHeader('Content-Type:', 'text/csv');
                    $this->response->addHeader('Content-Type', 'text/plain');
                    $this->response->setOutput($output);
                } else {
                    $output = 'No products to display!';
                    $this->response->addHeader('Content-Type', 'text/plain');

                    $this->response->setOutput($output);
                }
            } else {
                $output = 'Unable to create file!';
                $this->response->addHeader('Content-Type', 'text/plain');
                $this->response->setOutput($output);
            }
        } else {
            $output = 'Invalid feed type!';
            $this->response->addHeader('Content-Type', 'text/plain');
            $this->response->setOutput($output);
        }
        ini_set('default_charset', $charset);
    }

    protected function getProducts($pi = 0)
    {
        $categories = $this->model_catalog_category->getCategories($pi);
        $out = array();

        foreach ($categories as $category) {
            $products = $this->model_catalog_product->getProductsByCategoryIdExport($category['category_id']);
            $this->model_catalog_product->insertExportedProductIds($category['category_id']);

            foreach ($products as $product) {
                $out[] = array(
                    $product['product_id'],
                    $product['name'],
                    $this->model_tool_seo_url->rewrite($this->url->http('product/product&product_id=' . $product['product_id'])),
                    ($product['image'] ? image_resize($product['image'], 500, 500) : image_resize('no_image', 500, 500)),
                    $category['name'],
                    $this->tax->calculate($product['price'], $product['tax_class_id']) . ' UAH'
                );
            }

            $children = $this->getProducts($category['category_id']);

            if (is_array($children)) {
                $out = array_merge($out, $children);
            }
        }
        return $out;
    }
}
?>