<?php

// Error Handler
function error_handler_for_export($errno, $errstr, $errfile, $errline) {
	$config =& Registry::get('config');
	$log =& Registry::get('log');
	
	switch ($errno) {
		case E_NOTICE:
		case E_USER_NOTICE:
			$errors = "Notice";
			break;
		case E_WARNING:
		case E_USER_WARNING:
			$errors = "Warning";
			break;
		case E_ERROR:
		case E_USER_ERROR:
			$errors = "Fatal Error";
			break;
		default:
			$errors = "Unknown";
			break;
	}
		
	if (($errors=='Warning') || ($errors=='Unknown')) {
		return true;
	}

	if ($config->get('config_error_display')) {
		echo '<b>' . $errors . '</b>: ' . $errstr . ' in <b>' . $errfile . '</b> on line <b>' . $errline . '</b>';
	}
	
	if ($config->get('config_error_log')) {
		$log->write('PHP ' . $errors . ':  ' . $errstr . ' in ' . $errfile . ' on line ' . $errline);
	}

	return true;
}

class ModelToolExport extends Model {

    private $product_id_column = 0;
    private $product_name_column = 1;
    private $product_option_id_column = 2;
    private $product_option_name_column = 3;
    private $product_option_value_id_column = 4;
    private $product_option_value_name_column = 5;
    private $product_price_column = 6;
    private $product_sborka_column = 7;
    private $product_option_value_prefix_column = 8;
    private $product_option_value_price_column = 9;
  
	function import( &$database, $sql ) {
		foreach (explode(";\n", $sql) as $sql) {
			$sql = trim($sql);
			if ($sql) {
				$database->query($sql);
			}
		}
	}


	protected function getDefaultLanguageId( &$database ) {
		$code = $this->config->get('config_admin_language');
		$sql = "SELECT language_id FROM `".DB_PREFIX."language` WHERE code = '$code'";
		$result = $database->query( $sql );
		$languageId = 1;
		if ($result->rows) {
			foreach ($result->rows as $row) {
				$languageId = $row['language_id'];
				break;
			}
		}
		return $languageId;
	}
    

	protected function detect_encoding( $str ) {
		// auto detect the character encoding of a string
		return mb_detect_encoding( $str, 'UTF-8,ISO-8859-15,ISO-8859-1,cp1251,KOI8-R' );
	}


	function validateHeading( &$data, &$expected ) {
		$heading = array();
		foreach ($data['cells'] as $row) {
			for ($i=0; $i<=count($expected); $i+=1) {
				$heading[] = isset($row[$i]) ? $row[$i] : "";
			}
			break;
		}
		$valid = TRUE;
		for ($i=0; $i < count($expected); $i+=1) {
			if (!isset($heading[$i])) {
				$valid = FALSE;
				break;
			}
			if (strtolower($heading[$i]) != strtolower($expected[$i])) {
				$valid = FALSE;
				break;
			}
		}
		return $valid;
	}


    function download_price() {
		set_error_handler('error_handler_for_export',E_ALL);
		$database = Registry::get('db');
		$languageId = $this->getDefaultLanguageId($database);

		// We use the package from http://pear.php.net/package/Spreadsheet_Excel_Writer/
		require_once DIR_SYSTEM . "library/excel/Writer.php";

		// Creating a workbook
		$workbook = new Spreadsheet_Excel_Writer();
		$workbook->setTempDir(DIR_CACHE);
		$workbook->setVersion(8); // Use Excel97/2000 Format
		$priceFormat =& $workbook->addFormat(array('Size' => 10,'Align' => 'right','NumFormat' => '######0.00'));
		$boxFormat =& $workbook->addFormat(array('Size' => 10,'vAlign' => 'vequal_space' ));
		$textFormat =& $workbook->addFormat(array('Size' => 10, 'NumFormat' => "@" ));

		// sending HTTP headers
		$workbook->send('price.xls');

		// Creating the categories worksheet
		$worksheet =& $workbook->addWorksheet('Price');
		$worksheet->setInputEncoding ( 'UTF-8' );
		$this->populatePriceWorksheet($worksheet, $database, $languageId, $priceFormat, $boxFormat, $textFormat );
        //$worksheet->freezePanes(array(1, 1, 1, 1));
        
		// Let's send the file
		$workbook->close();
		exit;
	}


    function populatePriceWorksheet( &$worksheet, &$database, $languageId, &$priceFormat, &$boxFormat, &$textFormat, &$product_row_color )
	{
		// Set the column widths
		$j = 0;
		$worksheet->setColumn($this->product_id_column,$this->product_id_column,0);
		$worksheet->setColumn($this->product_name_column,$this->product_name_column,max(strlen('product_name'),30)+1);
		$worksheet->setColumn($this->product_price_column,$this->product_price_column,10,$priceFormat);
		$worksheet->setColumn($this->product_sborka_column,$this->product_sborka_column,10,$priceFormat);

        $worksheet->setColumn($this->product_option_id_column,$this->product_option_id_column,0);
		$worksheet->setColumn($this->product_option_name_column,$this->product_option_name_column,max(strlen('product_option_name'),30)+1);

        $worksheet->setColumn($this->product_option_value_id_column,$this->product_option_value_id_column,0);
		$worksheet->setColumn($this->product_option_value_name_column,$this->product_option_value_name_column,max(strlen('product_option_value_name'),50)+1);
        $worksheet->setColumn($this->product_option_value_prefix_column,$this->product_option_value_prefix_column,10,$textFormat);
		$worksheet->setColumn($this->product_option_value_price_column,$this->product_option_value_price_column,10,$priceFormat);

		// The options headings row
		$i = 0;
		//$worksheet->writeString( $i, $this->product_id_column, 'product_id', $boxFormat );
		$worksheet->writeString( $i, $this->product_name_column, 'product_name', $boxFormat  );
		$worksheet->writeString( $i, $this->product_price_column, 'p_price', $boxFormat  );
		$worksheet->writeString( $i, $this->product_sborka_column, 'p_sborka', $boxFormat  );
		
        //$worksheet->writeString( $i++, $this->product_option_id_column, 'po_id', $boxFormat  );
		$worksheet->writeString( $i, $this->product_option_name_column, 'product_option_name', $boxFormat  );
		
        //$worksheet->writeString( $i++, $this->product_option_value_id_column, 'pov_id', $boxFormat  );
		$worksheet->writeString( $i, $this->product_option_value_name_column, 'product_option_value_name', $boxFormat  );
		$worksheet->writeString( $i, $this->product_option_value_prefix_column, 'po_prefix', $boxFormat  );
        $worksheet->writeString( $i, $this->product_option_value_price_column, 'po_price', $boxFormat  );

		// The actual options data
		$i += 1;
		$j = 0;

        //Select parent categories
        $categories = $this->getCategories($database, 0);

        foreach ($categories as $category) {
            $category_id = $category['category_id'];

            $query  = "SELECT p.product_id,";
            $query .= "       pd.name,";
            $query .= "       p.price,";
            $query .= "       p.sborka";
            $query .= "  FROM product as p,";
            $query .= "       product_description as pd,";
            $query .= "       product_to_category as p2c";
            $query .= " WHERE p.product_id = pd.product_id";
            $query .= "   AND pd.language_id = '" . (int)$languageId . "'";
            $query .= "   AND p2c.product_id = pd.product_id";
            $query .= "   AND p2c.category_id = '" . (int)$category_id . "'";
            $query .= " ORDER BY p.sort_order;";

            $products = $database->query( $query );
            foreach ($products->rows as $product) {
                $product_id = $product['product_id'];
                $worksheet->write( $i, $this->product_id_column, $product['product_id'] );
                $worksheet->writeString( $i, $this->product_name_column, $product['name'] );
                $worksheet->write( $i, $this->product_price_column, $product['price'], $priceFormat );
                $worksheet->write( $i, $this->product_sborka_column, $product['sborka'], $priceFormat );
                $i += 1;


                $query  = "SELECT po.product_option_id,";
                $query .= "       pod.name,";
                $query .= "       po.color_option";
                $query .= "  FROM product_option as po,";
                $query .= "       product_option_description pod";
                $query .= " WHERE po.product_option_id = pod.product_option_id";
                $query .= "   AND pod.language_id = '" . (int)$languageId . "'";
                $query .= "   AND po.product_id = '" . (int)$product_id . "'";
                $query .= " ORDER BY po.sort_order;";

                $counter = 0;
                $product_options = $database->query( $query );
                foreach ($product_options->rows as $product_option) {

                    $product_option_id = $product_option['product_option_id'];
                    $worksheet->write( $i, $this->product_option_id_column, $product_option['product_option_id'] );
                    $worksheet->writeString( $i, $this->product_option_name_column, $product_option['name'] );
                    $i += 1;

                    if (!$product_option['color_option']) {
                        $query  = "SELECT pov.product_option_value_id,";
                        $query .= "       povd.name,";
                        $query .= "       pov.prefix,";
                        $query .= "       pov.price";
                        $query .= "  FROM product_option_value as pov,";
                        $query .= "       product_option_value_description as povd";
                        $query .= " WHERE pov.product_option_value_id = povd.product_option_value_id";
                        $query .= "   AND povd.language_id = '" . (int)$languageId . "'";
                        $query .= "   AND pov.product_option_id = '" . (int)$product_option_id . "'";
                        $query .= " ORDER BY pov.sort_order;";
                    } else {
                        $query  = "SELECT pov.product_option_value_id,";
                        $query .= "       povd.name,";
                        $query .= "       pov.prefix,";
                        $query .= "       pov.price";
                        $query .= "  FROM product_option_value as pov,";
                        $query .= "       product_option_value_description as povd,";
                        $query .= "       color as c,";
                        $query .= "       colorcategory as cc";
                        $query .= " WHERE pov.product_option_value_id = povd.product_option_value_id";
                        $query .= "   AND povd.language_id = '" . (int)$languageId . "'";
                        $query .= "   AND pov.product_option_id = '" . (int)$product_option_id . "'";
                        $query .= "   AND pov.color_id = c.color_id";
                        $query .= "   AND c.colorcategory_id = cc.colorcategory_id";
                        $query .= " ORDER BY cc.sort_order, pov.sort_order;";
                    }

                    //$counter_option_values = 0;
                    $product_option_values = $database->query( $query );
                    foreach ($product_option_values->rows as $product_option_value) {
                      $worksheet->write( $i, $this->product_option_value_id_column, $product_option_value['product_option_value_id'] );
                      $worksheet->writeString( $i, $this->product_option_value_name_column, $product_option_value['name'] );
                      $worksheet->writeString( $i, $this->product_option_value_prefix_column, $product_option_value['prefix'], $textFormat );
                      $worksheet->write( $i, $this->product_option_value_price_column, $product_option_value['price'], $priceFormat );
                      $i += 1;
                    }
                }
            }
        }
	}


	function clearCache() {
		$this->cache->delete('product');
		$this->cache->delete('product_option');
		$this->cache->delete('product_option_value');
	}


    function validatePrice( &$reader ) {
		$expectedProductHeading = array
		( "", "product_name", "", "product_option_name", "", "product_option_value_name", "p_price", "p_sborka", "po_prefix", "po_price" );
		$data = $reader->sheets[0];
		return $this->validateHeading( $data, $expectedProductHeading );
	}


	function validateUpload_price( &$reader ) {
		if (count($reader->sheets) != 1) {
			return FALSE;
		}

		if (!$this->validatePrice( $reader )) {
			return FALSE;
		}
		return TRUE;
	}

    function updateProductsInDatabase( &$database, &$products ) {
		// start transaction, remove categories
		$sql = "START TRANSACTION;\n";
		$this->import( $database, $sql );

		// generate and execute SQL for updating the prices and option prices
		foreach ($products as $product) {
			$database->query( "UPDATE product SET price = '" . (float)$product['price'] . "', sborka = '" . (float)$product['sborka'] . "' WHERE product_id = '" . (int)$product['product_id'] . "';" );

            foreach ($product['option_value'] as $product_option_value) {
                $database->query( "UPDATE product_option_value SET prefix = '" . $this->db->escape($product_option_value['prefix']) . "', price = '".(float)$product_option_value['price']."' WHERE product_option_value_id = '" . (int)$product_option_value['product_option_value_id'] . "';" );
            }
		}

		// final commit
		$database->query( "COMMIT;" );
		return TRUE;
	}


	function uploadPrice( &$reader, &$database ) {
		$data = $reader->sheets[0];

		$products = array();
		$isFirstRow = TRUE;

		
        foreach ($data['cells'] as $row) {
            
			if ($isFirstRow) {
				$isFirstRow = FALSE;
				continue;
			}

            if (isset($row[$this->product_id_column]) && isset($row[$this->product_price_column]) && isset($row[$this->product_sborka_column])) {
              
                if (isset($product_id) && isset($product_price) && isset($product_sborka)) {
                    $products[] = array (
                        "product_id" => $product_id,
                        "price" => $product_price,
                        "sborka" => $product_sborka,
                        "option_value" => $product_option_value
                    );
                }

                $product_id = trim($row[$this->product_id_column]);
                $product_price = $row[$this->product_price_column];
                $product_sborka = $row[$this->product_sborka_column];

                $product_option_value = array();

                continue;
            }

            if (isset($row[$this->product_option_id_column])) {
                continue;
            }

            if (isset($row[$this->product_option_value_id_column]) && isset($row[$this->product_option_value_prefix_column]) && isset($row[$this->product_option_value_price_column])) {
                $product_option_value[] = array(
                    "product_option_value_id" => trim($row[$this->product_option_value_id_column]),
                    "prefix" => trim($row[$this->product_option_value_prefix_column]),
                    "price" => $row[$this->product_option_value_price_column]
                );

                continue;
            }

        }
        return $this->updateProductsInDatabase( $database, $products );
	}


	function upload_price( $filename ) {
		set_error_handler('error_handler_for_export',E_ALL);
		$database = Registry::get('db');
		require_once DIR_SYSTEM . 'library/excel/Reader.php';
		ini_set("memory_limit", "512M");
		ini_set("max_execution_time", 180);
		$reader=new Spreadsheet_Excel_Reader();
		$reader->setUTFEncoder('iconv');
		$reader->setOutputEncoding('UTF-8');
        $reader->setRowColOffset(0);
		$reader->read($filename);
		$ok = $this->validateUpload_price( $reader );

        if (!$ok) {
			return FALSE;
		}

        $this->clearCache();
		
		$ok = $this->uploadPrice( $reader, $database );

        if (!$ok) {
            $database->query( 'ROLLBACK;' );
			return FALSE;
		}

        return $ok;
	}


    public function getCategories(&$database, $parent_id) {
        $category_data = array();

        $query = $database->query("SELECT category_id FROM category c WHERE c.parent_id = '" . (int)$parent_id . "' ORDER BY c.sort_order ASC");

        foreach ($query->rows as $result) {
            $category_data[] = array(
                'category_id' => $result['category_id']
            );

            $category_data = array_merge($category_data, $this->getCategories($database, $result['category_id']));
        }

		return $category_data;
	}
}
?>