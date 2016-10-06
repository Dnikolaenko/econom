<?php
// 141208 ET-141208 Begin
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
// 141208 ET-141208 End

class ModelCustomerCustomer extends Model {

    // 141208 ET-141208 Begin
    private $customer_id_col = 0;
    private $customer_name_col = 1;
    private $customer_email_col = 2;
    private $customer_telephone_col = 3;
    private $customer_first_order_date_col = 4;
    private $customer_newsletter_col = 5;
    //private $customer_unsubscribe_col = 6;
    // 141208 ET-141208 End


    public function addCustomer($data) {
          $this->db->query("INSERT INTO " . DB_PREFIX . "customer SET firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', newsletter = '" . (int)$data['newsletter'] . "', customer_group_id = '" . (int)$data['customer_group_id'] . "', password = '" . $this->db->escape(md5($data['password'])) . "', status = '" . (int)$data['status'] . "', date_added = NOW()");
    }
    
    public function editCustomer($customer_id, $data) {
        $this->db->query("UPDATE " . DB_PREFIX . "customer SET firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', newsletter = '" . (int)$data['newsletter'] . "', customer_group_id = '" . (int)$data['customer_group_id'] . "', status = '" . (int)$data['status'] . "' WHERE customer_id = '" . (int)$customer_id . "'");
    
          if ($data['password']) {
            $this->db->query("UPDATE " . DB_PREFIX . "customer SET password = '" . $this->db->escape(md5($data['password'])) . "' WHERE customer_id = '" . (int)$customer_id . "'");
          }
    }
    
    public function deleteCustomer($customer_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "address WHERE customer_id = '" . (int)$customer_id . "'");
    }
    
    public function getCustomer($customer_id) {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer_id . "'");
    
        return $query->row;
    }
        
    public function getCustomers($data = array()) {
        $sql = "SELECT *, CONCAT(firstname, ' ', lastname) AS name FROM " . DB_PREFIX . "customer";

        $implode = array();
        
        if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
            $implode[] = "CONCAT(firstname, ' ', lastname) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
        }
        
        if (isset($data['filter_email']) && !is_null($data['filter_email'])) {
            $implode[] = "email = '" . $this->db->escape($data['filter_email']) . "'";
        }    
        
        if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
            $implode[] = "status = '" . (int)$data['filter_status'] . "'";
        }            
        
        // 141208 ET-141208 Begin
        if (isset($data['filter_newsletter']) && !is_null($data['filter_newsletter'])) {
            $implode[] = "newsletter = '" . (int)$data['filter_newsletter'] . "'";
        }
        // 141208 ET-141208 End

        if (isset($data['filter_date_added']) && !is_null($data['filter_date_added'])) {
            $implode[] = "DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
        }
        
        if ($implode) {
            $sql .= " WHERE " . implode(" AND ", $implode);
        }
        
        $sort_data = array(
            'name',
            'email',
            'status',
            // 141208 ET-141208 Begin
            'newsletter',
            // 141208 ET-141208 End
            'date_added'
        );    
            
        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];    
        } else {
            $sql .= " ORDER BY name";    
        }
            
        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }
        
        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }            

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }    
            
            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }        
        
        $query = $this->db->query($sql);
        
        return $query->rows;    
    }
    
    public function activate($customer_id) {
        $this->db->query("UPDATE " . DB_PREFIX . "customer SET status = '1' WHERE customer_id = '" . (int)$customer_id . "'");
    }
    
    public function getCustomersByNewsletter() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE newsletter = '1' ORDER BY firstname, lastname, email");
    
        return $query->rows;
    }
    
    public function getCustomersByKeyword($keyword) {
        if ($keyword) {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE CONCAT(firstname, ' ', lastname) LIKE '%" . $this->db->escape($keyword) . "%' ORDER BY firstname, lastname, email");
    
            return $query->rows;
        } else {
            return array();    
        }
    }
    
    public function getTotalCustomers($data = array()) {
          $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer";
        
        $implode = array();
        
        if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
            $implode[] = "CONCAT(firstname, ' ', lastname) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
        }
        
        if (isset($data['filter_email']) && !is_null($data['filter_email'])) {
            $implode[] = "email = '" . $this->db->escape($data['filter_email']) . "'";
        }    
        
        if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
            $implode[] = "status = '" . (int)$data['filter_status'] . "'";
        }            
        
        // 141208 ET-141208 Begin
        if (isset($data['filter_newsletter']) && !is_null($data['filter_newsletter'])) {
            $implode[] = "newsletter = '" . (int)$data['filter_newsletter'] . "'";
        }
        // 141208 ET-141208 End

        if (isset($data['filter_date_added']) && !is_null($data['filter_date_added'])) {
            $implode[] = "DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
        }
        
        if ($implode) {
            $sql .= " WHERE " . implode(" AND ", $implode);
        }
                
        $query = $this->db->query($sql);
                
        return $query->row['total'];
    }
    
    public function getTotalAddressesByCustomerId($customer_id) {
          $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "address WHERE customer_id = '" . (int)$customer_id . "'");
        
        return $query->row['total'];
    }
    
    public function getTotalAddressesByCountryId($country_id) {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "address WHERE country_id = '" . (int)$country_id . "'");
        
        return $query->row['total'];
    }    
    
    public function getTotalAddressesByZoneId($zone_id) {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "address WHERE zone_id = '" . (int)$zone_id . "'");
        
        return $query->row['total'];
    }
    
    public function getTotalCustomersByGroupId($customer_group_id) {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE customer_group_id = '" . (int)$customer_group_id . "'");
        
        return $query->row['total'];
    }

    // 141208 ET-141208 Begin
//    public function downloadCustomers($data = array()) {
//        set_error_handler('error_handler_for_export', E_ALL);
//
//        // We use the package from http://pear.php.net/package/Spreadsheet_Excel_Writer/
//        require_once DIR_SYSTEM . "library/excel/Writer.php";
//
//        // Creating a workbook
//        $workbook = new Spreadsheet_Excel_Writer();
//        $workbook->setTempDir(DIR_CACHE);
//        $workbook->setVersion(8); // Use Excel97/2000 Format
//        $boxFormat =& $workbook->addFormat(array('Size' => 10,'vAlign' => 'vequal_space', 'Align' => 'center' ));
//        $textFormat =& $workbook->addFormat(array('Size' => 10, 'NumFormat' => "@" ));
//
//        // sending HTTP headers
//        $workbook->send('customers.xls');
//
//        // Creating the categories worksheet
//        $worksheet =& $workbook->addWorksheet('Customers');
//        $worksheet->setInputEncoding ( 'UTF-8' );
//
//        $language = new Language($this->config->get('config_language'));
//        $language->load('customer/customer');
//
//        $worksheet->setColumn($this->customer_id_col, $this->customer_id_col, 10);
//        $worksheet->setColumn($this->customer_name_col, $this->customer_name_col, 60);
//        $worksheet->setColumn($this->customer_email_col, $this->customer_email_col, 45+1);
//        $worksheet->setColumn($this->customer_telephone_col, $this->customer_telephone_col, 32+1);
//        $worksheet->setColumn($this->customer_newsletter_col, $this->customer_newsletter_col, 10);
//
//        // The customer heading row
//        $i = 0;
//        $worksheet->writeString($i, $this->customer_id_col, $language->get('customer_id_col'), $boxFormat);
//        $worksheet->writeString($i, $this->customer_name_col, $language->get('customer_name_col'), $boxFormat);
//        $worksheet->writeString($i, $this->customer_email_col, $language->get('customer_email_col'), $boxFormat);
//        $worksheet->writeString($i, $this->customer_telephone_col, $language->get('customer_telephone_col'), $boxFormat);
//        $worksheet->writeString($i, $this->customer_newsletter_col, $language->get('customer_newsletter_col'), $boxFormat);
//
//        // The actual customer data
//        $i += 1;
//
//        $customers = $this->getCustomers($data);
//
//        $patterns = array(
//            '/&amp;amp;/',
//            '/amp;quot;/',
//            '/amp;laquo;/',
//            '/amp;raquo;/'
//            //, '/&quot;/'
//        );
//
//        $replacements = array(
//            '&amp;',
//            'quot;',
//            'laquo;',
//            'raquo;'
//            //, 'quot;'
//        );
//
//        foreach ($customers as $customer) {
//            $worksheet->write( $i, $this->customer_id_col, $customer['customer_id'] );
//            $worksheet->writeString( $i, $this->customer_name_col, html_entity_decode(preg_replace($patterns, $replacements, preg_replace($patterns, $replacements, $customer['name'])), ENT_QUOTES, 'UTF-8'));
//            $worksheet->writeString( $i, $this->customer_email_col, $customer['email'] );
//            $worksheet->writeString( $i, $this->customer_telephone_col, $customer['telephone'] );
//            $worksheet->write( $i, $this->customer_newsletter_col, $customer['newsletter'], $boxFormat );
//            $i += 1;
//        }
//
//        // Let's send the file
//        $workbook->close();
//        exit;
//    }

    public function downloadCustomers($data = array()) {
        //set_error_handler('error_handler_for_export', E_ALL);

        // We use the package from http://phpexcel.codeplex.com/
        require_once DIR_SYSTEM . "library/PHPExcel/PHPExcel.php";
        // Подключаем класс для вывода данных в формате excel
        require_once DIR_SYSTEM . 'library/PHPExcel/PHPExcel/Writer/Excel5.php';

        $language = new Language($this->config->get('config_language'));
        $language->load('customer/customer');

        // Создаем объект класса PHPExcel
        $xls = new PHPExcel();
        // Устанавливаем индекс активного листа
        $xls->setActiveSheetIndex(0);
        // Получаем активный лист
        $sheet = $xls->getActiveSheet();

        //Row
        $i = 1;

        // Подписываем лист
        $sheet->setTitle($language->get('heading_title'));

        //Заголовок таблицы
        $sheet->setCellValueByColumnAndRow($this->customer_id_col, $i, $language->get('customer_id_col'));
        $sheet->setCellValueByColumnAndRow($this->customer_name_col, $i, $language->get('customer_name_col'));
        $sheet->setCellValueByColumnAndRow($this->customer_email_col, $i, $language->get('customer_email_col'));
        $sheet->setCellValueByColumnAndRow($this->customer_telephone_col, $i, $language->get('customer_telephone_col'));
        $sheet->setCellValueByColumnAndRow($this->customer_first_order_date_col, $i, $language->get('customer_first_order_date_col'));
        $sheet->setCellValueByColumnAndRow($this->customer_newsletter_col, $i, $language->get('customer_newsletter_col'));

        //Ширина столбцов
        $sheet->getColumnDimensionByColumn($this->customer_id_col)->setWidth(10);
        $sheet->getColumnDimensionByColumn($this->customer_name_col)->setWidth(60);
        $sheet->getColumnDimensionByColumn($this->customer_email_col)->setWidth(45);
        $sheet->getColumnDimensionByColumn($this->customer_telephone_col)->setWidth(32);
        $sheet->getColumnDimensionByColumn($this->customer_first_order_date_col)->setWidth(20);
        $sheet->getColumnDimensionByColumn($this->customer_newsletter_col)->setAutoSize(true);

        //Заливка заголовка таблицы
        $sheet->getStyleByColumnAndRow($this->customer_id_col, $i)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $sheet->getStyleByColumnAndRow($this->customer_id_col, $i)->getFill()->getStartColor()->setRGB('EEEEEE');
        $sheet->getStyleByColumnAndRow($this->customer_name_col, $i)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $sheet->getStyleByColumnAndRow($this->customer_name_col, $i)->getFill()->getStartColor()->setRGB('EEEEEE');
        $sheet->getStyleByColumnAndRow($this->customer_email_col, $i)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $sheet->getStyleByColumnAndRow($this->customer_email_col, $i)->getFill()->getStartColor()->setRGB('EEEEEE');
        $sheet->getStyleByColumnAndRow($this->customer_telephone_col, $i)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $sheet->getStyleByColumnAndRow($this->customer_telephone_col, $i)->getFill()->getStartColor()->setRGB('EEEEEE');
        $sheet->getStyleByColumnAndRow($this->customer_first_order_date_col, $i)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $sheet->getStyleByColumnAndRow($this->customer_first_order_date_col, $i)->getFill()->getStartColor()->setRGB('EEEEEE');
        $sheet->getStyleByColumnAndRow($this->customer_newsletter_col, $i)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $sheet->getStyleByColumnAndRow($this->customer_newsletter_col, $i)->getFill()->getStartColor()->setRGB('EEEEEE');

        // Применяем выравнивание заголовка таблицы
        //$sheet->getRowDimension($i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyleByColumnAndRow($this->customer_id_col, $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyleByColumnAndRow($this->customer_name_col, $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyleByColumnAndRow($this->customer_email_col, $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyleByColumnAndRow($this->customer_telephone_col, $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyleByColumnAndRow($this->customer_first_order_date_col, $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyleByColumnAndRow($this->customer_newsletter_col, $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        // The actual customer data
        $i += 1;

        $customers = $this->getCustomers($data);

        $patterns = array(
            '/&amp;amp;/',
            '/amp;quot;/',
            '/amp;laquo;/',
            '/amp;raquo;/'
            //, '/&quot;/'
        );

        $replacements = array(
            '&amp;',
            'quot;',
            'laquo;',
            'raquo;'
            //, 'quot;'
        );

        foreach ($customers as $customer) {
            $sheet->setCellValueByColumnAndRow($this->customer_id_col, $i, $customer['customer_id']);
            $sheet->setCellValueByColumnAndRow($this->customer_name_col, $i, html_entity_decode(preg_replace($patterns, $replacements, preg_replace($patterns, $replacements, $customer['name'])), ENT_QUOTES, 'UTF-8'));
            $sheet->setCellValueByColumnAndRow($this->customer_email_col, $i, $customer['email']);
            $sheet->setCellValueByColumnAndRow($this->customer_telephone_col, $i, $customer['telephone']);
            $sheet->getStyleByColumnAndRow($this->customer_telephone_col, $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $sheet->setCellValueByColumnAndRow($this->customer_first_order_date_col, $i, date($language->get('date_format_short'), strtotime($customer['date_added'])));
            $sheet->getStyleByColumnAndRow($this->customer_first_order_date_col, $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->setCellValueByColumnAndRow($this->customer_newsletter_col, $i, $customer['newsletter']);
            $sheet->getStyleByColumnAndRow($this->customer_newsletter_col, $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $i += 1;
        }

        // Выводим содержимое файла
        $objWriter = new PHPExcel_Writer_Excel5($xls);
        $objWriter->save('php://output');
    }
    // 141208 ET-141208 End
}
?>