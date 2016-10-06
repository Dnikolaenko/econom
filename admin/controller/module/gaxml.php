<?php 
class ControllerModuleGaxml extends Controller {
    private $error = array(); 

    public function index() {
        $this->load->language('module/gaxml');

        $this->document->title = ($this->language->get('heading_title'));
        
        $this->load->model('setting/setting');
        
        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->load->model('module/gaxml');

        $this->data['text_enabled'] = $this->language->get('text_enabled');
        $this->data['text_disabled'] = $this->language->get('text_disabled');

        $this->data['entry_xml'] = $this->language->get('entry_xml');
        $this->data['entry_status'] = $this->language->get('entry_status');
        $this->data['button_save'] = $this->language->get('button_save');
        $this->data['button_cancel'] = $this->language->get('button_cancel');
        $this->data['tab_general'] = $this->language->get('tab_general');

        $this->data['action'] = $this->url->https('module/gaxml');
        
        $this->data['cancel'] = $this->url->https('extension/module');

        
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
         'href'      => $this->url->https('module/gaxml'),
         'text'      => $this->language->get('heading_title'),
        'separator' => ' :: '
     );
  
  $this->data['action'] = $this->url->https('module/gaxml');
  
  $this->data['cancel'] = $this->url->https('extension/module');
  
   if (isset($this->request->post['gaxml_status'])) {
   $this->data['gaxml_status'] = $this->request->post['gaxml_status'];
  } else {
   $this->data['gaxml_status'] = $this->config->get('gaxml_status');
  }

        if (isset($this->request->post['xml'])) {
            $this->data['xml'] = $this->request->post['xml'];

        $w =  $this->model_module_gaxml->getcategories();
        $q =  $this->model_module_gaxml->getproduct();
        $m =  $this->model_module_gaxml->getmanufacturer();
        //var_dump($q);
        $w = $this->replace($w);
        $q = $this->replaceq($q);

        $files = "".DIR_DOWNLOAD."feedeconom.xml";

        if(file_exists($files)){
        unlink($files);
        }

        $report = fopen($files, "x+");
        $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        $xml .= "<!DOCTYPE yml_catalog SYSTEM \"shops.dtd\">\n";
        $xml .= "<yml_catalog date=\"".date('Y-m-d h:i')."\">\n";
        $xml .= "<shop>\n";
        $xml .= "<name>ЭкономТочка</name>\n";
        $xml .= "<company>Economtochka</company>\n";
        $xml .= "<url>http://economtochka.com.ua/</url>\n";
        $xml .= "<currencies>\n";
        // $xml .= "<currency id=\"USD\" rate=\"27,09\"/>\n";
        $xml .= "<currency id=\"UAH\" rate=\"1\"/>\n";
        $xml .= "</currencies>\n";
        $xml .= "<categories>\n";
        foreach ($w as $result){
        $xml .= "<category id=\"".$result['category_id']."\">".strip_tags($result['name'])."</category>\n";
        }
        $xml .= "</categories>\n";
        $xml .= "<offers>\n";
        foreach ($q as $res){
        $xml .= "<offer id=\"".$res['product_id']."\" available=\"true\">\n";
        $xml .= "<url>http://economtochka.com.ua/index.php?route=product/product&amp;path=".$res['parent_id']."_".$res['category_id']."&amp;product_id=".$res['product_id']."</url>\n";
        $xml .= "<price>". $res['special'] ."</price>\n";
        $xml .= "<currencyId>UAH</currencyId>\n";
        $xml .= "<categoryId>".$res['category_id']."</categoryId>\n";
        $xml .= "<name>".$res['name']."</name>\n";
        foreach ($m as $man) {
            if($man['manufacturer_id'] == $res['manufacturer_id']) {
        $xml .= "<vendor>".$man['name']."</vendor>\n";
            }
        }
        $xml .= "<description>". $res['model'] ."</description>\n";
        $xml .= "</offer>\n";
        }
        $xml .= "</offers>\n";
        $xml .= "</shop>\n";
        $xml .= "</yml_catalog>\n";
        fwrite($report,$xml);
        fclose($report);
        }

        $this->template = 'module/gaxml.tpl';
        $this->children = array(
            'common/header',    
            'common/footer' 
        );

         if ($this->request->server['REQUEST_METHOD'] == 'POST') {
                  $this->model_setting_setting->editSetting('gaxml', $this->request->post);  
     
                  $this->session->data['success'] = $this->language->get('text_success');
      
                  $this->redirect($this->url->https('extension/module'));
                 }
        
        $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
    }
    public function replace($w) {
        $xmlStr = str_replace("&laquo;","",$w);
        $xmlStr = str_replace("&raquo;","",$w);
        $xmlStr = str_replace('&lt;','<',$w);
        $xmlStr = str_replace('&gt;','>',$w);
        $xmlStr = str_replace('&quot;','"',$w);
        $xmlStr = str_replace('&apos;',"'",$w);
        $xmlStr = str_replace('&amp;',"&",$w);
        $xmlStr = str_replace("&ndash","–",$w);
        
    return $xmlStr;
    }
    public function replaceq($q) {
        $xmlStr = str_replace("&laquo;","",$q);
        $xmlStr = str_replace("&raquo;","",$q);
        $xmlStr = str_replace('&lt;','<',$q);
        $xmlStr = str_replace('&gt;','>',$q);
        $xmlStr = str_replace('&quot;','"',$q);
        $xmlStr = str_replace('&apos;',"'",$q);
        $xmlStr = str_replace('&amp;',"&",$q);
        $xmlStr = str_replace("&ndash","–",$q);

    return $xmlStr;
    }
}
?>