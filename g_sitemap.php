<?php
// Sitemap 1.0

// Config
require('config.php');

// Startup
require_once(DIR_SYSTEM . 'startup.php');

// Database 
$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

// Base URL
if (@$_SERVER['HTTPS'] != 'on') {
  $catalog_url = HTTP_SERVER;
  $image_url = HTTP_IMAGE;
} else {
  $catalog_url = HTTPS_SERVER;
  $image_url = HTTPS_IMAGE;
}

//Output XML
     header('Content-type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

//Add the Home Page
echo '<url>' . "\n";
echo '<loc>' . $catalog_url . '</loc>' . "\n";
echo '<changefreq>weekly</changefreq>' . "\n";
echo '<priority>1.0</priority>' . "\n";
echo '</url>' . "\n";

//Add the Questions Page
echo '<url>' . "\n";
echo '<loc>' . $catalog_url . 'index.php?route=information/question</loc>' . "\n";
echo '<changefreq>weekly</changefreq>' . "\n";
echo '<priority>0.3</priority>' . "\n";
echo '</url>' . "\n";

// Settings
$query = $db->query("SELECT value FROM " . DB_PREFIX . "setting WHERE " . DB_PREFIX . "setting.key = 'config_seo_url' LIMIT 1");

if ($query->row['value']) {

// Get alias for information
  $query = $db->query("SELECT query, keyword FROM " . DB_PREFIX . "url_alias WHERE query like 'information_id=%'");
  foreach ($query->rows as $s_information_alias) {
    $information_key = substr($s_information_alias['query'], strrpos($s_information_alias['query'], "=") + 1);
    $information_alias[$information_key] = $s_information_alias['keyword'];
  }

// Get alias for manufacturer
  $query = $db->query("SELECT query, keyword FROM " . DB_PREFIX . "url_alias WHERE query like 'manufacturer_id=%'");
  foreach ($query->rows as $s_manufacturer_alias) {
    $manufacturer_key = substr($s_manufacturer_alias['query'], strrpos($s_manufacturer_alias['query'], "=") + 1);
    $manufacturer_alias[$manufacturer_key] = $s_manufacturer_alias['keyword'];
  }

// Get alias for category
  $query = $db->query("SELECT query, keyword FROM " . DB_PREFIX . "url_alias WHERE query like 'category_id=%'");
  foreach ($query->rows as $s_category_alias) {
    $category_key = substr($s_category_alias['query'], strrpos($s_category_alias['query'], "=") + 1);
    $category_alias[$category_key] = $s_category_alias['keyword'];
  }

// Get alias for product
  $query = $db->query("SELECT query, keyword FROM " . DB_PREFIX . "url_alias WHERE query like 'product_id=%'");
  foreach ($query->rows as $s_prod_alias) {
    $prod_key = substr($s_prod_alias['query'], strrpos($s_prod_alias['query'], "=") + 1);
    $prod_alias[$prod_key] = $s_prod_alias['keyword'];
  }

// (+) ALNAUA 091114 (START)
// Get alias for advice
  $query = $db->query("SELECT query, keyword FROM " . DB_PREFIX . "url_alias WHERE query like 'advice_id=%'");
  foreach ($query->rows as $s_advice_alias) {
    $advice_key = substr($s_advice_alias['query'], strrpos($s_advice_alias['query'], "=") + 1);
    $advice_alias[$advice_key] = $s_advice_alias['keyword'];
  }
// (+) ALNAUA 091114 (FINISH)


  // Information
  $query = $db->query("SELECT information_id FROM " . DB_PREFIX . "information");

  foreach ($query->rows as $information) {
    echo '<url>' . "\n";

    if (array_key_exists($information['information_id'], $information_alias))
      echo '<loc>' . $catalog_url . $information_alias[$information['information_id']] . '</loc>' . "\n";
    else
      echo '<loc>' . $catalog_url .'index.php?route=information/information&amp;information_id='. $information['information_id'] . '</loc>' . "\n";

    echo '<changefreq>monthly</changefreq>' . "\n";
    echo '<priority>0.8</priority>' . "\n";
    echo '</url>' . "\n";
  }

  // Manufacturer
  $query = $db->query("SELECT manufacturer_id FROM " . DB_PREFIX . "manufacturer");

  foreach ($query->rows as $manufacturer) {
    echo '<url>' . "\n";

    if (array_key_exists($manufacturer['manufacturer_id'], $manufacturer_alias))
      echo '<loc>' . $catalog_url . $manufacturer_alias[$manufacturer['manufacturer_id']] . '</loc>' . "\n";
    else
      echo '<loc>' . $catalog_url .'index.php?route=product/manufacturer&amp;manufacturer_id='. $manufacturer['manufacturer_id'] . '</loc>' . "\n";

    echo '<changefreq>weekly</changefreq>' . "\n";
    echo '<priority>0.4</priority>' . "\n";
    echo '</url>' . "\n";
  }

  // Category
  $query = $db->query("SELECT category_id, date_modified FROM " . DB_PREFIX . "category");

  foreach ($query->rows as $category) {
    echo '<url>' . "\n";

    if (array_key_exists($category['category_id'], $category_alias))
      echo '<loc>' . $catalog_url . $category_alias[$category['category_id']] . '</loc>' . "\n";
    else
      echo '<loc>' . $catalog_url .'index.php?route=product/category&amp;path='. $category['category_id'] . '</loc>' . "\n";

    echo '<lastmod>'.date("c", strtotime($category['date_modified'])).'</lastmod>' . "\n";
    echo '<changefreq>weekly</changefreq>' . "\n";
    echo '<priority>0.8</priority>' . "\n";
    echo '</url>' . "\n";
  }

  // Product
  $query = $db->query("SELECT product_id, date_modified FROM " . DB_PREFIX . "product");

  foreach ($query->rows as $product) {
    echo '<url>' . "\n";

    if (array_key_exists($product['product_id'], $prod_alias))
      echo '<loc>' . $catalog_url . $prod_alias[$product['product_id']] . '</loc>' . "\n";
    else
      echo '<loc>' . $catalog_url .'index.php?route=product/product&amp;product_id='. $product['product_id'] . '</loc>' . "\n";

    echo '<lastmod>'.date("c", strtotime($product['date_modified'])).'</lastmod>' . "\n";
    echo '<changefreq>weekly</changefreq>' . "\n";
    echo '<priority>0.5</priority>' . "\n";
    echo '</url>' . "\n";
  }

  // (+) ALNAUA 091114 (START)
  // Advice
  $query = $db->query("SELECT advice_id FROM " . DB_PREFIX . "advice");

  foreach ($query->rows as $advice) {
    echo '<url>' . "\n";

    if (array_key_exists($advice['advice_id'], $advice_alias))
      echo '<loc>' . $catalog_url . $advice_alias[$advice['advice_id']] . '</loc>' . "\n";
    else
      echo '<loc>' . $catalog_url .'index.php?route=information/advice/info&amp;advice_id='. $advice['advice_id'] . '</loc>' . "\n";

    echo '<changefreq>monthly</changefreq>' . "\n";
    echo '<priority>0.5</priority>' . "\n";
    echo '</url>' . "\n";
  }
  // (+) ALNAUA 091114 (FINISH)
}
else {
// Information
  $query = $db->query("SELECT information_id FROM " . DB_PREFIX . "information");

  foreach ($query->rows as $information) {
    echo '<url>' . "\n";
    echo '<loc>' . $catalog_url .'index.php?route=information/information&amp;information_id='. $information['information_id'] . '</loc>' . "\n";
    echo '<changefreq>monthly</changefreq>' . "\n";
    echo '<priority>0.8</priority>' . "\n";
    echo '</url>' . "\n";
  }

  // Manufacturer
  $query = $db->query("SELECT manufacturer_id FROM " . DB_PREFIX . "manufacturer");

  foreach ($query->rows as $manufacturer) {
    echo '<url>' . "\n";
    echo '<loc>' . $catalog_url .'index.php?route=product/manufacturer&amp;manufacturer_id='. $manufacturer['manufacturer _id'] . '</loc>' . "\n";
    echo '<changefreq>weekly</changefreq>' . "\n";
    echo '<priority>0.4</priority>' . "\n";
    echo '</url>' . "\n";
  }

  // Category
  $query = $db->query("SELECT category_id, date_modified FROM " . DB_PREFIX . "category");

  foreach ($query->rows as $category) {
    echo '<url>' . "\n";
    echo '<loc>' . $catalog_url .'index.php?route=product/category&amp;path='. $category['category_id'] . '</loc>' . "\n";
    echo '<lastmod>'.date("c", strtotime($category['date_modified'])).'</lastmod>' . "\n";
    echo '<changefreq>weekly</changefreq>' . "\n";
    echo '<priority>0.8</priority>' . "\n";
    echo '</url>' . "\n";
  }

  // Product
  $query = $db->query("SELECT product_id, date_modified FROM " . DB_PREFIX . "product");

  foreach ($query->rows as $product) {
    echo '<url>' . "\n";
    echo '<loc>' . $catalog_url .'index.php?route=product/product&amp;product_id='. $product['product_id'] . '</loc>' . "\n";
    echo '<lastmod>'.date("c", strtotime($product['date_modified'])).'</lastmod>' . "\n";
    echo '<changefreq>weekly</changefreq>' . "\n";
    echo '<priority>0.5</priority>' . "\n";
    echo '</url>' . "\n";
  }
  // (+) ALNAUA 091114 (START)
  // Advice
  $query = $db->query("SELECT advice_id FROM " . DB_PREFIX . "advice");

  foreach ($query->rows as $advice) {
    echo '<url>' . "\n";
    echo '<loc>' . $catalog_url .'index.php?route=information/advice/info&amp;advice_id='. $advice['advice_id'] . '</loc>' . "\n";
    echo '<changefreq>monthly</changefreq>' . "\n";
    echo '<priority>0.5</priority>' . "\n";
    echo '</url>' . "\n";
  }
  // (+) ALNAUA 091114 (FINISH)
}
echo '</urlset>';
?>