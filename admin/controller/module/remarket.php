<?php
class ControllerModuleRemarket extends Controller {
    private $error = array(); 

	public function index() {
		require_once(DIR_SYSTEM . 'simple_html_dom.php');
		$this->load->language('module/remarket');
                
        $this->document->title = $this->language->get('heading_title');
		
		$this->document->title = ($this->language->get('heading_title'));
                
        $this->load->model('module/remarket');
       
        $this->load->model('setting/setting');

        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['text_enabled'] = $this->language->get('text_enabled');
        $this->data['text_disabled'] = $this->language->get('text_disabled');
        $this->data['unloads'] = $this->language->get('unloads');
        $this->data['update'] = $this->language->get('update');
        $this->data['upload_price'] = $this->language->get('upload_file');
        // $this->data['compare_price'] = $this->language->get('compare_price');
        $this->data['file_name'] = $this->language->get('file_name');	
        $this->data['entry_status'] = $this->language->get('entry_status');
        $this->data['button_save'] = $this->language->get('button_save');
        $this->data['button_cancel'] = $this->language->get('button_cancel');
        $this->data['tab_general'] = $this->language->get('tab_general');
        
        if (isset($this->request->post['unload'])) {
            $this->data['unload'] = $this->request->post['unload']; 

        $q = $this->model_module_remarket->getPrices();

        $files ="".DIR_DOWNLOAD."Feed.csv"; 

        if(file_exists($files)){
        unlink($files);
        }

        $report = fopen($files, "w+");
        
        foreach ($q as $res) {
        
        $out1 = "<tr>"
                . "<td width=\"25%\"> $res[product_id] </td>"
                . "<td  width=\"25%\"> $res[name]</td>"
                . "<td  width=\"25%\"> $res[special] UAH</td>"
                . "<td  width=\"25%\">http://economtochka.com.ua/index.php?route=product/product&path=$res[parent_id]_$res[category_id]&product_id=$res[product_id]</td>"
                . "<td width=\"25%\">http://economtochka.com.ua/image/cache/$res[image]</td>"
                . "<td width=\"25%\"> $res[lol] </td></tr>";
                       
        $html = str_get_html($out1);
        foreach ($html->find('tr') as $element) {
            $td = array();
            foreach($element->find('td') as $row){
                $td[] = $row->plaintext;
                }
        }        
        fwrite($report,implode(";",$td)."\r\n");      
        }
        fclose($report);  
        }

        if(isset($_FILES["file"])) {
            if(is_uploaded_file($_FILES["file"]["tmp_name"])){
                move_uploaded_file($_FILES["file"], $upload_dir);
            } else {
               echo "move file error!";
            }
        }

                 
                 if ($this->request->server['REQUEST_METHOD'] == 'POST') {
                  $this->model_setting_setting->editSetting('remarket', $this->request->post);  
     
                  $this->session->data['success'] = $this->language->get('text_success');
      
                  $this->redirect($this->url->https('extension/module'));
                 }


     $this->document->breadcrumbs = array();

     $this->document->breadcrumbs[] = array(
         'href'      => $this->url->https('common/home'),
         'text'      => $this->language->get('text_home'),
        'separator' => FALSE
     );

     $this->document->breadcrumbs[] = array(
         'href'      => $this->url->https('extension/module'),
         'text'      => $this->language->get('text_module'),
        'separator' => ' :: '
     );
  
     $this->document->breadcrumbs[] = array(
         'href'      => $this->url->https('module/remarket'),
         'text'      => $this->language->get('heading_title'),
        'separator' => ' :: '
     );
        
        $this->data['action'] = $this->url->https('module/remarket');
        
        $this->data['cancel'] = $this->url->https('extension/module');
          
        if (isset($this->request->post['remarket_status'])) {
          $this->data['remarket_status'] = $this->request->post['remarket_status'];
          } else {
           $this->data['remarket_status'] = $this->config->get('remarket_status');
            }          

        //$upload_dir = DIR_PRICES;

        

        //var_dump($_FILES["file"]["name"]);

	$this->template = 'module/remarket.tpl';
        $this->children = array(
            'common/header',    
            'common/footer' 
        );
        $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
    }

    // public function update() {

    //     $this->load->language('module/remarket');

    //     $this->load->model('module/remarket');

    //     if (isset($this->request->post['upload'])) {
    //         $this->data['upload'] = $this->request->post['upload'];

    //     $file ="".DIR_DOWNLOAD."Feed.csv";

    //     if (is_writable($file)){
    //     $row =1 ;
    //     $report = fopen($file, "r+");
    //     while (($prices = fgetcsv($report)) != FALSE){
    //         //$num = count($prices);
    //         $row++;
    //         //$write = mysql_query("UPDATE product SET price = '".$data[2]."' WHERE product_id = '".$data[0]."'")or die(mysql_error());
    //         //$u = $this->model_module_remarket->updatePrices($prices);
    //         }
    //     fclose($report);    
    //     }
    //    } 
    // }
    // public function compare() {

    //     $this->load->language('module/remarket');

    //     $upload_dir = DIR_PRICES;

    //     if(isset($_FILES["file"]["name"])) {
    //         if(is_uploaded_file($_FILES["file"]["tmp_name"])){
    //             move_uploaded_file($_FILES["file"]["tmp_name"], $upload_dir);
    //         } else {
    //            echo "lol";
    //         }
    //     }

    // }
}
?>