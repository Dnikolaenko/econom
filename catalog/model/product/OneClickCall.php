<?php


Class OneClickModel extends Model{


public function one_click ($order_id, $order_status_id, $comment = '') {
    $order_query = $this->db->query("SELECT *, l.code AS language FROM `" . DB_PREFIX . "order` o LEFT JOIN " . DB_PREFIX . "language l ON (o.language_id = l.language_id) WHERE o.order_id = '" . (int)$order_id . "' AND o.order_status_id = '0'");
   
    if ($order_query->num_rows) {
        $this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = '" . (int)$order_status_id . "' WHERE order_id = '" . (int)$order_id . "'");

        $this->db->query("INSERT INTO " . DB_PREFIX . "order_history SET order_id = '" . (int)$order_id . "', order_status_id = '" . (int)$order_status_id . "', notify = '1', comment = '" . $this->db->escape($comment) . "', date_added = NOW()");

                $language = new Language($order_query->row['language']);
                $language->load('checkout/confirm');

                $this->load->model('localisation/currency');
                $subject = sprintf($language->get('mail_new_order_subject'), html_entity_decode($this->config->get('config_store'), ENT_QUOTES, 'UTF-8'), $order_id);
                $order_status_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_status WHERE order_status_id = '" . (int)$order_status_id . "' AND language_id = '" . (int)$order_query->row['language_id'] . "'");
                $order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");
                $order_querys = $this->db->query("SELECT * FROM ". DB_PREFIX . "order_total WHERE order_id = '" . (int)$order_id . "'");
                $order_total_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$order_id . "' ORDER BY sort_order ASC");
                $order_total_vsego = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$order_id . "' AND sort_order = 10");
                $order_total_dostvaka = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$order_id . "' AND sort_order = 25");
                $order_total_skidka = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$order_id . "' AND sort_order = 20");
                $order_download_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_download WHERE order_id = '" . (int)$order_id . "'");
                // 20120204 ALNAUA ET-111227 Begin
                if ($order_query->row['credit_id'] > 0) {
                 $order_credit_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "credit c JOIN " . DB_PREFIX . "credit_description cd ON (c.credit_id = cd.credit_id) WHERE c.credit_id = '" . (int)$order_query->row['credit_id'] . "' AND language_id = '" . (int)$order_query->row['language_id'] . "'");
                }
                // 20120204 ALNAUA ET-111227 End

                // Text Mail
if ($this->config->get('config_alert_mail_for_customer')) {  
    foreach ($order_product_query->rows as $result){
//if ($result['nds'] == 0) {
                $message  = sprintf($language->get('mail_new_order_greeting'), html_entity_decode($this->config->get('config_store'), ENT_QUOTES, 'UTF-8')) . "\n\n";
                $message .= $language->get('mail_new_order_order') . ' Ф0' . $order_id . "\n";
                //$message .= $language->get('mail_new_order_nds'). "\n";
                $message .= $language->get('mail_new_order_date_added') . ' ' . date($language->get('date_format_short'), strtotime($order_query->row['date_added'])) . "\n";
                // 20120204 ALNAUA ET-111227 Begin
                //$message .= $language->get('mail_new_order_order_status') . ' ' . $order_status_query->row['name'] . "\n\n";
                $message .= $language->get('mail_new_order_order_status') . ' ' . $order_status_query->row['name'] . "\n";
                if ($order_query->row['credit_id'] > 0) {
                 $message .= $language->get('mail_new_order_order_credit') . ' ' . $order_credit_query->row['name'] . "\n";
                }
                // 140606 ET-140606 Begin
                if ($order_query->row['shipping_address_1']!='') {
                 $message .= $language->get('text_shipping_address') . ": " . html_entity_decode($order_query->row['shipping_address_1'], ENT_QUOTES, 'UTF-8') . "\n";
                }
                if ($order_query->row['payment_method']!='') {
                 $message .= $language->get('text_payment_method') . ": " . $order_query->row['payment_method'] . "\n";
                }
                // 140606 ET-140606 End
                $message .= "\n";
                // 20120204 ALNAUA ET-111227 End
                $message .= $language->get('mail_new_order_product') . "\n";
                
                foreach ($order_product_query->rows as $result) {
                    if  ($result['nds'] == 0) {
                    $message .= $result['quantity'] . ' x ' . $result['name'] . ' (' . $result['model'] . ') ' . html_entity_decode($this->currency->format($result['total'], $order_query->row['currency'], $order_query->row['value']), ENT_NOQUOTES, 'UTF-8') . "\n";

                    // (+) ALNAUA 091114 (START)
                    $order_product_options_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . $result['order_product_id'] . "'");

                    foreach ($order_product_options_query->rows as $order_product_options) {
                      $message .= "   - ". $order_product_options['name']. ": " .$order_product_options['value']. "\n";
                    }
                    // 100223 ALNAUA Site redesign Begin
                    //$color_query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "color a LEFT JOIN " . DB_PREFIX . "color_description ad ON (a.color_id = ad.color_id) WHERE a.color_id = '" . $result['color_id'] . "' AND ad.language_id = '" . $language->getId() . "'");
                    //$message .= "   - ". $language->get('text_color'). ": " .$color_query->row['name']. "\n";
                    // 100223 ALNAUA Site redesign End
                    // (+) ALNAUA 091114 (FINISH)

                    // 100218 ALNAUA New building mechanism in order, mail and invoice Begin
                    if ($result['sborka']) {
                      $message .= $result['quantity'] . ' x ' . $language->get('text_sborka') . ' ' . $result['name'] . ' (' . $result['model'] . ') ' . html_entity_decode($this->currency->format($result['quantity'] * $result['sborka_cost'], $order_query->row['currency'], $order_query->row['value']), ENT_NOQUOTES, 'UTF-8') . "\n";
                    }
                    // 100218 ALNAUA New building mechanism in order, mail and invoice End
                  }
                }

                $message .= "\n";

                //$message .= $language->get('mail_new_order_total') . "\n";

//                foreach ($order_total_query->rows as $results) {
//                    //$message .= $result['title'] . ' ' . html_entity_decode($result['val_nds'], ENT_NOQUOTES, 'UTF-8') . "\n";
//                }
//                foreach ($order_query->rows as $rez){
//                }
//                foreach($order_total_dostvaka as $dostavka){}
//                $message .= $dostavka['title'] . '' . html_entity_decode($dostavka ['value'], ENT_NOQUOTES, 'UTF-8') . "\n";
//                $message .= $results['title'] . ' ' .  number_format(round($rez['tottwo'], 2),2, '.', ''). "грн" . "\n";
                foreach ($order_total_query->rows as $results) {}
                foreach ($order_total_vsego->rows as $vsego){}
                foreach ($order_total_skidka->rows as $skidka){}
                foreach ($order_query->rows as $rez){}
                foreach($order_total_dostvaka->rows as $dostavka){}
                $message .= $vsego['title'] . ' ' .    number_format(round($vsego['val_no_nds'],2),2, '.', '') . "грн" ."\n"; 
                $message .= $skidka['title'] . ' '  .  number_format(round($skidka['value'],2),2, '.', '') . "грн" ."\n";               
                $message .= $dostavka['title'] . ' ' . number_format(round($dostavka ['value'], 2),2, '.', '') . "грн" ."\n";
                $message .= $results['title'] . ' ' .  number_format(round($rez['tottwo'], 2),2, '.', '') . "грн" ."\n";
                $message .= "\n";

                $message .= $language->get('mail_new_order_invoice') . "\n";
//                foreach ($order_product_query->rows as $result) {
//                if ($result['nds'] == 0){ 
//                   }
//                }
                $message .= html_entity_decode($this->url->http('account/invoice&order_id=' . $order_id . '&secret_code=' .$order_query->row['secret_code']), ENT_QUOTES, 'UTF-8') . "\n\n";
                
                if ($order_download_query->num_rows) {
                    $message .= $language->get('mail_new_order_download') . "\n";
                    $message .= $this->url->http('account/download') . "\n\n";
                }

                if ($comment) {
                    $message .= $language->get('mail_new_order_comment') . "\n\n";
                    $message .= $comment . "\n\n";
                }
                
                }

                $message .= $language->get('mail_new_order_footer');
                                $message .= $language->get('mail_new_order_footer');
                // (+) ALNAUA 091114 (START)
        foreach($order_querys->rows as $rez){
        }
            if($rez['val_no_nds']>0){
                if ($this->config->get('config_mail_protocol') == 'mail' || $this->config->get('config_mail_protocol') == 'smtp') {
                // (+) ALNAUA 091114 (FINISH)
                    $mail = new Mail($this->config->get('config_mail_protocol'), $this->config->get('config_smtp_host'), $this->config->get('config_smtp_username'), html_entity_decode($this->config->get('config_smtp_password'), ENT_QUOTES, 'UTF-8'), $this->config->get('config_smtp_port'), $this->config->get('config_smtp_timeout'));
                    $mail->setTo($order_query->row['email']);
                    $mail->setFrom($this->config->get('config_email'));
                    $mail->setSender(html_entity_decode($this->config->get('config_store'), ENT_QUOTES, 'UTF-8'));
                    $mail->setSubject($subject);
                    $mail->setText($message);
                    //$mail->send();
                // (+) ALNAUA 091114 (START)
                } elseif ($this->config->get('config_mail_protocol') == 'swift') {
                      $settings = array(
                          'config_smtp_host' => $this->config->get('config_smtp_host'),
                          'config_smtp_username' => $this->config->get('config_smtp_username'),
                          'config_smtp_password' => html_entity_decode($this->config->get('config_smtp_password'), ENT_QUOTES, 'UTF-8'),
                          'config_smtp_port' => $this->config->get('config_smtp_port')
                      );
                      $result = swift_send(
                              $settings,
                              array($this->config->get('config_email') => html_entity_decode($this->config->get('config_store'), ENT_QUOTES, 'UTF-8')), //from
                              array($this->config->get('config_admin_email') => html_entity_decode($this->config->get('config_store'), ENT_QUOTES, 'UTF-8')), //replyto
                              array($order_query->row['email'] => html_entity_decode($order_query->row['firstname'], ENT_QUOTES, 'UTF-8')), //to
                              $subject, //subject
                              $message  //message
                              );
//                    $transport = Swift_MailTransport::newInstance();
//                    $mailer = Swift_Mailer::newInstance($transport);
//                    //Create the message
//                    $message = Swift_Message::newInstance()
//                      //Give the message a subject
//                      ->setSubject($subject)
//                      //Set the From address with an associative array
//                      ->setFrom(array($this->config->get('config_email') => html_entity_decode($this->config->get('config_store'), ENT_QUOTES, 'UTF-8')))
//                      //Set the To addresses with an associative array
//                      ->setTo(array($order_query->row['email']))
//                      //Give it a body
//                      // 100219 ALNAUA Quotes bug fix Begin
//                      //->setBody($message)
//                      ->setBody(html_entity_decode($message, ENT_QUOTES, 'UTF-8'))
//                      // 100219 ALNAUA Quotes bug fix End
//                      ;
//                    $result = $mailer->send($message);
                }
            }
    //}
//}
//if ($result['nds'] == 1){

                $message  = sprintf($language->get('mail_new_order_greeting'), html_entity_decode($this->config->get('config_store'), ENT_QUOTES, 'UTF-8')) . "\n\n";
                $message .= $language->get('mail_new_order_order') . ' Т0' . $order_id . "\n";
                //$message .= $language->get('mail_new_order'). "\n";
                $message .= $language->get('mail_new_order_date_added') . ' ' . date($language->get('date_format_short'), strtotime($order_query->row['date_added'])) . "\n";
                // 20120204 ALNAUA ET-111227 Begin
                //$message .= $language->get('mail_new_order_order_status') . ' ' . $order_status_query->row['name'] . "\n\n";
                $message .= $language->get('mail_new_order_order_status') . ' ' . $order_status_query->row['name'] . "\n";
                if ($order_query->row['credit_id'] > 0) {
                 $message .= $language->get('mail_new_order_order_credit') . ' ' . $order_credit_query->row['name'] . "\n";
                }
                // 140606 ET-140606 Begin
                if ($order_query->row['shipping_address_1']!='') {
                 $message .= $language->get('text_shipping_address') . ": " . html_entity_decode($order_query->row['shipping_address_1'], ENT_QUOTES, 'UTF-8') . "\n";
                }
                if ($order_query->row['payment_method']!='') {
                 $message .= $language->get('text_payment_method') . ": " . $order_query->row['payment_method'] . "\n";
                }
                // 140606 ET-140606 End
                $message .= "\n";
                // 20120204 ALNAUA ET-111227 End
                $message .= $language->get('mail_new_order_product') . "\n";
                
                    foreach ($order_product_query->rows as $result) {
                        if  ($result['nds'] == 1) {
                    $message .= $result['quantity'] . ' x ' . $result['name'] . ' (' . $result['model'] . ') ' . html_entity_decode($this->currency->format($result['total'], $order_query->row['currency'], $order_query->row['value']), ENT_NOQUOTES, 'UTF-8') . "\n";

                    // (+) ALNAUA 091114 (START)
                    $order_product_options_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . $result['order_product_id'] . "'");

                    foreach ($order_product_options_query->rows as $order_product_options) {
                      $message .= "   - ". $order_product_options['name']. ": " .$order_product_options['value']. "\n";
                    }
                    // 100223 ALNAUA Site redesign Begin
                    //$color_query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "color a LEFT JOIN " . DB_PREFIX . "color_description ad ON (a.color_id = ad.color_id) WHERE a.color_id = '" . $result['color_id'] . "' AND ad.language_id = '" . $language->getId() . "'");
                    //$message .= "   - ". $language->get('text_color'). ": " .$color_query->row['name']. "\n";
                    // 100223 ALNAUA Site redesign End
                    // (+) ALNAUA 091114 (FINISH)

                    // 100218 ALNAUA New building mechanism in order, mail and invoice Begin
                    if ($result['sborka']) {
                      $message .= $result['quantity'] . ' x ' . $language->get('text_sborka') . ' ' . $result['name'] . ' (' . $result['model'] . ') ' . html_entity_decode($this->currency->format($result['quantity'] * $result['sborka_cost'], $order_query->row['currency'], $order_query->row['value']), ENT_NOQUOTES, 'UTF-8') . "\n";
                    }
                    // 100218 ALNAUA New building mechanism in order, mail and invoice End

                  }
               }
             //  }

                $message .= "\n";

                //$message .= $language->get('mail_new_order_total') . "\n";
                 

            foreach ($order_total_query->rows as $results) {}
            foreach ($order_total_vsego->rows as $vsego){}
            foreach ($order_total_skidka->rows as $skidka){}
            foreach ($order_query->rows as $rez){}
            foreach($order_total_dostvaka->rows as $dostavka){}
            $message .= $vsego['title'] . ' ' .    number_format(round($vsego['val_nds'],2),2, '.', '') . "грн" ."\n"; 
            $message .= $skidka['title'] . ' '  .  number_format(round($skidka['value'],2),2, '.', '') . "грн" ."\n";               
            $message .= $dostavka['title'] . ' ' . number_format(round($dostavka ['value'],2),2, '.', '') . "грн" ."\n";
            $message .= $results['title'] . ' ' .  number_format(round($rez['totone'], 2),2, '.', '') . "грн" ."\n";
                //$message .= $results['2']['title'] . ' ' .  number_format($results['2']['value'], 2, '.', ''). "\n";
                //$message .= $result['title'] . ' ' . html_entity_decode($result ['value'], ENT_NOQUOTES, 'UTF-8') . "\n";
                //$message .= $result['title'] . ' ' . html_entity_decode($result ['value'], ENT_NOQUOTES, 'UTF-8') . "\n";
                //$message .= $result['title'] . ' ' . html_entity_decode($result ['val_no_nds'], ENT_NOQUOTES, 'UTF-8') . "\n";
                

                $message .= "\n";

                $message .= $language->get('mail_new_order_invoice') . "\n";
//                foreach ($order_product_query->rows as $result) {
//                if ($result['nds'] == 1){   
//                }
//                }
                $message .= html_entity_decode($this->url->http('account/invoice_nds&order_id=' . $order_id . '&secret_code=' .$order_query->row['secret_code']), ENT_QUOTES, 'UTF-8') . "\n\n";
                if ($order_download_query->num_rows) {
                    $message .= $language->get('mail_new_order_download') . "\n";
                    $message .= $this->url->http('account/download') . "\n\n";
                }

                if ($comment) {
                    $message .= $language->get('mail_new_order_comment') . "\n\n";
                    $message .= $comment . "\n\n";
                }
                
                $message .= $language->get('mail_new_order_footer');
                // (+) ALNAUA 091114 (START)
        foreach($order_querys->rows as $rez){
        }
            if($rez['val_nds']>0){                
                if ($this->config->get('config_mail_protocol') == 'mail' || $this->config->get('config_mail_protocol') == 'smtp') {
                // (+) ALNAUA 091114 (FINISH)
                    $mail = new Mail($this->config->get('config_mail_protocol'), $this->config->get('config_smtp_host'), $this->config->get('config_smtp_username'), html_entity_decode($this->config->get('config_smtp_password'), ENT_QUOTES, 'UTF-8'), $this->config->get('config_smtp_port'), $this->config->get('config_smtp_timeout'));
                    $mail->setTo($order_query->row['email']);
                    $mail->setFrom($this->config->get('config_email'));
                    $mail->setSender(html_entity_decode($this->config->get('config_store'), ENT_QUOTES, 'UTF-8'));
                    $mail->setSubject($subject);
                    $mail->setText($message);
                    //$mail->send();
                // (+) ALNAUA 091114 (START)
                } elseif ($this->config->get('config_mail_protocol') == 'swift') {
                      $settings = array(
                          'config_smtp_host' => $this->config->get('config_smtp_host'),
                          'config_smtp_username' => $this->config->get('config_smtp_username'),
                          'config_smtp_password' => html_entity_decode($this->config->get('config_smtp_password'), ENT_QUOTES, 'UTF-8'),
                          'config_smtp_port' => $this->config->get('config_smtp_port')
                      );
                      $result = swift_send(
                              $settings,
                              array($this->config->get('config_email') => html_entity_decode($this->config->get('config_store'), ENT_QUOTES, 'UTF-8')), //from
                              array($this->config->get('config_admin_email') => html_entity_decode($this->config->get('config_store'), ENT_QUOTES, 'UTF-8')), //replyto
                              array($order_query->row['email'] => html_entity_decode($order_query->row['firstname'], ENT_QUOTES, 'UTF-8')), //to
                              $subject, //subject
                              $message  //message
                              );
//                    $transport = Swift_MailTransport::newInstance();
//                    $mailer = Swift_Mailer::newInstance($transport);
//                    //Create the message
//                    $message = Swift_Message::newInstance()
//                      //Give the message a subject
//                      ->setSubject($subject)
//                      //Set the From address with an associative array
//                      ->setFrom(array($this->config->get('config_email') => html_entity_decode($this->config->get('config_store'), ENT_QUOTES, 'UTF-8')))
//                      //Set the To addresses with an associative array
//                      ->setTo(array($order_query->row['email']))
//                      //Give it a body
//                      // 100219 ALNAUA Quotes bug fix Begin
//                      //->setBody($message)
//                      ->setBody(html_entity_decode($message, ENT_QUOTES, 'UTF-8'))
//                      // 100219 ALNAUA Quotes bug fix End
//                      ;
//                    $result = $mailer->send($message);
                }
            //}
            }
    }
//}

if ($this->config->get('config_alert_mail')) {  
    foreach ($order_product_query->rows as $result) {
    // 100729 ALNAUA Add domain to mail subject Begin
    $subject = sprintf($language->get('mail_new_order_subject'), html_entity_decode($this->config->get('config_store'), ENT_QUOTES, 'UTF-8'), $order_id) .' ( ' . HTTP_SERVER . ' )';
    // 100729 ALNAUA Add domain to mail subject End

    $message  = $language->get('mail_new_order_received') . "\n\n";
    $message .= $language->get('mail_new_order')."\n";
    // (+) ALNAUA 091114 (START)
    $message .= $language->get('text_email') . ": " . $order_query->row['email']. "\n";
    if ($order_query->row['firstname']!='') {
        $message .= $language->get('text_fistname') . ": " . html_entity_decode(str_replace('&amp;amp;', '&amp;', $order_query->row['firstname']), ENT_QUOTES, 'UTF-8') . "\n";
    } elseif ($order_query->row['shipping_company']!='') {
        $message .= $language->get('text_company') . ": " . html_entity_decode(str_replace('&amp;amp;', '&amp;', $order_query->row['shipping_company']), ENT_QUOTES, 'UTF-8') . "\n";
    }

    $message .= $language->get('text_telephone') . ": " . $order_query->row['telephone']. "\n";
    // 140606 ET-140606 Begin
    // $message .= $language->get('text_shipping_address') . ": " . html_entity_decode($order_query->row['shipping_address_1'], ENT_QUOTES, 'UTF-8') . "\n";
    if ($order_query->row['shipping_address_1']!='') {
        $message .= $language->get('text_shipping_address') . ": " . html_entity_decode($order_query->row['shipping_address_1'], ENT_QUOTES, 'UTF-8') . "\n";
    }
    // 140606 ET-140606 End
    if ($order_query->row['shipping_address_2']!='') {
        $message .= $language->get('text_payment_address') . ": " . html_entity_decode($order_query->row['shipping_address_2'], ENT_QUOTES, 'UTF-8') . "\n";
    }
    if ($order_query->row['shipping_postcode']!='') {
        $message .= $language->get('text_postcode') . ": " . $order_query->row['shipping_postcode'] . "\n";
    }
    // (+) ALNAUA 091114 (FINISH)
    // 100729 ALNAUA Add domain to mail subject Begin
    //$message .= "\n" . $language->get('mail_new_order_order') . ' ' . $order_id . "\n";
    $message .= "\n" . $language->get('mail_new_order_order') . ' Ф0' . $order_id  .' ( ' . HTTP_SERVER . ' )' . "\n";
    // 100729 ALNAUA Add domain to mail subject End
    $message .= $language->get('mail_new_order_date_added') . ' ' . date($language->get('date_format_short'), strtotime($order_query->row['date_added'])) . "\n";
    // 20120204 ALNAUA ET-111227 Begin
    //$message .= $language->get('mail_new_order_order_status') . ' ' . $order_status_query->row['name'] . "\n\n";
    $message .= $language->get('mail_new_order_order_status') . ' ' . $order_status_query->row['name'] . "\n";
    if ($order_query->row['credit_id'] > 0) {
     $message .= $language->get('mail_new_order_order_credit') . ' ' . $order_credit_query->row['name'] . "\n";
    }
    // 140606 ET-140606 Begin
    if ($order_query->row['payment_method']!='') {
        $message .= $language->get('text_payment_method') . ": " . $order_query->row['payment_method'] . "\n";
    }
    // 140606 ET-140606 End
    $message .= "\n";
    // 20120204 ALNAUA ET-111227 End
    $message .= $language->get('mail_new_order_product') . "\n";
    
        foreach ($order_product_query->rows as $result) {
            if  ($result['nds'] == 0) {   
            $message .= $result['serial_no'] . ' | ' . $result['quantity'] . ' x ' . $result['name'] . ' (' . $result['model'] . ') ' . html_entity_decode($this->currency->format($result['total'], $order_query->row['currency'], $order_query->row['value']), ENT_NOQUOTES, 'UTF-8') . "\n";

     // (+) ALNAUA 091114 (START)
     $order_product_options_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . $result['order_product_id'] . "'");

     foreach ($order_product_options_query->rows as $order_product_options) {
       $message .= "   - ". $order_product_options['name']. ": " .$order_product_options['value']. "\n";
     }

     // 100223 ALNAUA Site redesign Begin
     //$color_query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "color a LEFT JOIN " . DB_PREFIX . "color_description ad ON (a.color_id = ad.color_id) WHERE a.color_id = '" . $result['color_id'] . "' AND ad.language_id = '" . $language->getId() . "'");
     //$message .= "   - ". $language->get('text_color'). ": " .$color_query->row['name']. "\n";
     // 100223 ALNAUA Site redesign End
     // (+) ALNAUA 091114 (FINISH)

     // 100218 ALNAUA New building mechanism in order, mail and invoice Begin
     if ($result['sborka']) {
       $message .= $result['quantity'] . ' x ' . $language->get('text_sborka') . ' ' . $result['name'] . ' (' . $result['model'] . ') ' . html_entity_decode($this->currency->format($result['quantity'] * $result['sborka_cost'], $order_query->row['currency'], $order_query->row['value']), ENT_NOQUOTES, 'UTF-8') . "\n";
     }
     // 100218 ALNAUA New building mechanism in order, mail and invoice End
        }    
     }
    
    $message .= "\n";

    //$message .= $language->get('mail_new_order_total') . "\n";
    
//    foreach ($order_total_query->rows as $results) {
//     //$message .= $result['title'] . ' ' . html_entity_decode($result['val_nds'], ENT_NOQUOTES, 'UTF-8') . "\n";
//    }
//    foreach ($order_query->rows as $rez){    
//    }
//    foreach($order_total_dostvaka as $dostavka){
//    $message .= $dostavka['title'] . '' . html_entity_decode($dostavka ['value'], ENT_NOQUOTES, 'UTF-8') . "\n";
//    }
//    $message .= $results['title'] . ' ' . number_format(round($rez['tottwo'], 2),2, '.', ''). "грн" . "\n";
        foreach ($order_total_query->rows as $results) {}
        foreach ($order_total_vsego->rows as $vsego){}
        foreach ($order_total_skidka->rows as $skidka){}
        foreach ($order_query->rows as $rez){}
        foreach($order_total_dostvaka->rows as $dostavka){}
        $message .= $vsego['title'] . ' ' .    number_format(round($vsego['val_no_nds'], 2),2, '.', '') . "грн" ."\n"; 
        $message .= $skidka['title'] . ' '  .  number_format(round($skidka['value'], 2),2, '.', '') . "грн" ."\n";               
        $message .= $dostavka['title'] . ' ' . number_format(round($dostavka ['value'], 2),2, '.', '') . "грн" ."\n";
        $message .= $results['title'] . ' ' .  number_format(round($rez['tottwo'], 2),2, '.', '') . "грн" ."\n";
    
    $message .= "\n";   
    
    if ($order_download_query->num_rows) {
     $message .= $language->get('mail_new_order_download') . "\n";
     $message .= $this->url->http('account/download') . "\n\n";
    }
    
    if ($comment) {
     $message .= $language->get('mail_new_order_comment') . "\n\n";
     $message .= $comment . "\n\n";
    }
 }
                // (+) ALNAUA 091114 (START)
        foreach($order_querys->rows as $rez){
        }
            if($rez['val_no_nds']>0){
                if ($this->config->get('config_mail_protocol') == 'mail' || $this->config->get('config_mail_protocol') == 'smtp') {
                // (+) ALNAUA 091114 (FINISH)
                    $mail = new Mail($this->config->get('config_mail_protocol'), $this->config->get('config_smtp_host'), $this->config->get('config_smtp_username'), $this->config->get('config_smtp_password'), $this->config->get('config_smtp_port'), $this->config->get('config_smtp_timeout'));
                    $mail->setTo($this->config->get('config_admin_email'));
                    $mail->setFrom($this->config->get('config_email'));
                    $mail->setSender(html_entity_decode($this->config->get('config_store'), ENT_QUOTES, 'UTF-8'));
                    $mail->setSubject($subject);
                    $mail->setText($message);
                    //$mail->send();
                // (+) ALNAUA 091114 (START)
                } elseif ($this->config->get('config_mail_protocol') == 'swift') {
                      $settings = array(
                          'config_smtp_host' => $this->config->get('config_smtp_host'),
                          'config_smtp_username' => $this->config->get('config_smtp_username'),
                          'config_smtp_password' => html_entity_decode($this->config->get('config_smtp_password'), ENT_QUOTES, 'UTF-8'),
                          'config_smtp_port' => $this->config->get('config_smtp_port')
                      );
                      $result = swift_send(
                              $settings,
                              array($this->config->get('config_email') => html_entity_decode($this->config->get('config_store'), ENT_QUOTES, 'UTF-8')), //from
                              array($this->config->get('config_admin_email') => html_entity_decode($this->config->get('config_store'), ENT_QUOTES, 'UTF-8')), //replyto
                              array($this->config->get('config_admin_email') => html_entity_decode($this->config->get('config_store'), ENT_QUOTES, 'UTF-8')), //to
                              $subject, //subject
                              $message,  //message
                              explode(';', $this->config->get('config_bcc_email')) //bcc
                              );
//                    $transport = Swift_MailTransport::newInstance();
//                    $mailer = Swift_Mailer::newInstance($transport);
//                    //Create the message
//                    $message = Swift_Message::newInstance()
//                      //Give the message a subject
//                      ->setSubject($subject)
//                      //Set the From address with an associative array
//                      ->setFrom(array($this->config->get('config_email') => html_entity_decode($this->config->get('config_store'), ENT_QUOTES, 'UTF-8')))
//                      //Set the To addresses with an associative array
//                      ->setTo(array($this->config->get('config_admin_email')))
//                      //Give it a body
//                      // 100219 ALNAUA Quotes bug fix Begin
//                      //->setBody($message)
//                      ->setBody(html_entity_decode($message, ENT_QUOTES, 'UTF-8'))
//                      // 100219 ALNAUA Quotes bug fix End
//                      ;
//                    $result = $mailer->send($message);
                }
            }
                
    // 100729 ALNAUA Add domain to mail subject Begin
    $subject = sprintf($language->get('mail_new_order_subject'), html_entity_decode($this->config->get('config_store'), ENT_QUOTES, 'UTF-8'), $order_id) .' ( ' . HTTP_SERVER . ' )';
    // 100729 ALNAUA Add domain to mail subject End

    $message  = $language->get('mail_new_order_received') . "\n\n";
    $message .= $language->get('mail_new_order_nds')."\n";
    // (+) ALNAUA 091114 (START)
    $message .= $language->get('text_email') . ": " . $order_query->row['email']. "\n";
    if ($order_query->row['firstname']!='') {
        $message .= $language->get('text_fistname') . ": " . html_entity_decode(str_replace('&amp;amp;', '&amp;', $order_query->row['firstname']), ENT_QUOTES, 'UTF-8') . "\n";
    } elseif ($order_query->row['shipping_company']!='') {
        $message .= $language->get('text_company') . ": " . html_entity_decode(str_replace('&amp;amp;', '&amp;', $order_query->row['shipping_company']), ENT_QUOTES, 'UTF-8') . "\n";
    }

    $message .= $language->get('text_telephone') . ": " . $order_query->row['telephone']. "\n";
    // 140606 ET-140606 Begin
    // $message .= $language->get('text_shipping_address') . ": " . html_entity_decode($order_query->row['shipping_address_1'], ENT_QUOTES, 'UTF-8') . "\n";
    if ($order_query->row['shipping_address_1']!='') {
        $message .= $language->get('text_shipping_address') . ": " . html_entity_decode($order_query->row['shipping_address_1'], ENT_QUOTES, 'UTF-8') . "\n";
    }
    // 140606 ET-140606 End
    if ($order_query->row['shipping_address_2']!='') {
        $message .= $language->get('text_payment_address') . ": " . html_entity_decode($order_query->row['shipping_address_2'], ENT_QUOTES, 'UTF-8') . "\n";
    }
    if ($order_query->row['shipping_postcode']!='') {
        $message .= $language->get('text_postcode') . ": " . $order_query->row['shipping_postcode'] . "\n";
    }
    // (+) ALNAUA 091114 (FINISH)
    // 100729 ALNAUA Add domain to mail subject Begin
    //$message .= "\n" . $language->get('mail_new_order_order') . ' ' . $order_id . "\n"; 
    $message .= "\n" . $language->get('mail_new_order_order') . ' Т0' . $order_id  .' ( ' . HTTP_SERVER . ' )' . "\n";
    // 100729 ALNAUA Add domain to mail subject End
    $message .= $language->get('mail_new_order_date_added') . ' ' . date($language->get('date_format_short'), strtotime($order_query->row['date_added'])) . "\n";
    // 20120204 ALNAUA ET-111227 Begin
    //$message .= $language->get('mail_new_order_order_status') . ' ' . $order_status_query->row['name'] . "\n\n";
    $message .= $language->get('mail_new_order_order_status') . ' ' . $order_status_query->row['name'] . "\n";
    if ($order_query->row['credit_id'] > 0) {
     $message .= $language->get('mail_new_order_order_credit') . ' ' . $order_credit_query->row['name'] . "\n";
    }
    // 140606 ET-140606 Begin
    if ($order_query->row['payment_method']!='') {
        $message .= $language->get('text_payment_method') . ": " . $order_query->row['payment_method'] . "\n";
    }
    // 140606 ET-140606 End
    $message .= "\n";
    // 20120204 ALNAUA ET-111227 End
    $message .= $language->get('mail_new_order_product') . "\n";

        foreach ($order_product_query->rows as $result) {
            if  ($result['nds'] == 1) {
            $message .= $result['serial_no'] . ' | ' . $result['quantity'] . ' x ' . $result['name'] . ' (' . $result['model'] . ') ' . html_entity_decode($this->currency->format($result['total'], $order_query->row['currency'], $order_query->row['value']), ENT_NOQUOTES, 'UTF-8') . "\n";

     // (+) ALNAUA 091114 (START)
     $order_product_options_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . $result['order_product_id'] . "'");

     foreach ($order_product_options_query->rows as $order_product_options) {
       $message .= "   - ". $order_product_options['name']. ": " .$order_product_options['value']. "\n";
     }

     // 100223 ALNAUA Site redesign Begin
     //$color_query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "color a LEFT JOIN " . DB_PREFIX . "color_description ad ON (a.color_id = ad.color_id) WHERE a.color_id = '" . $result['color_id'] . "' AND ad.language_id = '" . $language->getId() . "'");
     //$message .= "   - ". $language->get('text_color'). ": " .$color_query->row['name']. "\n";
     // 100223 ALNAUA Site redesign End
     // (+) ALNAUA 091114 (FINISH)

     // 100218 ALNAUA New building mechanism in order, mail and invoice Begin
     if ($result['sborka']) {
       $message .= $result['quantity'] . ' x ' . $language->get('text_sborka') . ' ' . $result['name'] . ' (' . $result['model'] . ') ' . html_entity_decode($this->currency->format($result['quantity'] * $result['sborka_cost'], $order_query->row['currency'], $order_query->row['value']), ENT_NOQUOTES, 'UTF-8') . "\n";
     }
     // 100218 ALNAUA New building mechanism in order, mail and invoice End
        }
     }
    
    $message .= "\n";

    //$message .= $language->get('mail_new_order_total') . "\n";
    
//    foreach ($order_total_query->rows as $result) {
//     //$message .= $result['title'] . ' ' . html_entity_decode($result['val_no_nds'], ENT_NOQUOTES, 'UTF-8') . "\n";
//    }
//    foreach ($order_query->rows as $rez){   
//    }
//    foreach($order_total_dostvaka as $dostavka){
//    $message .= $dostavka['title'] . '' . html_entity_decode($dostavka ['value'], ENT_NOQUOTES, 'UTF-8') . "\n";
//    }
//    $message .= $result['title'] . ' ' . number_format(round($rez['totone'], 2),2, '.', '') . "грн" . "\n";
    foreach ($order_total_query->rows as $results) {}
    foreach ($order_total_vsego->rows as $vsego){}
    foreach ($order_total_skidka->rows as $skidka){}
    foreach ($order_query->rows as $rez){}
    foreach($order_total_dostvaka->rows as $dostavka){}
    $message .= $vsego['title'] . ' ' .    number_format(round($vsego['val_nds'],2),2, '.', '') . "грн" ."\n"; 
    $message .= $skidka['title'] . ' '  .  number_format(round($skidka['value'],2),2, '.', '') . "грн" ."\n";               
    $message .= $dostavka['title'] . ' ' . number_format(round($dostavka ['value'],2),2, '.', '') . "грн" ."\n";
    $message .= $results['title'] . ' ' .  number_format(round($rez['totone'], 2),2, '.', '') . "грн" ."\n";
    
    $message .= "\n";
    
    if ($order_download_query->num_rows) {
     $message .= $language->get('mail_new_order_download') . "\n";
     $message .= $this->url->http('account/download') . "\n\n";
    }
    
    if ($comment) {
     $message .= $language->get('mail_new_order_comment') . "\n\n";
     $message .= $comment . "\n\n";
    }
                // (+) ALNAUA 091114 (START)
        foreach($order_querys->rows as $rez){
        }
            if($rez['val_nds']>0){             
                if ($this->config->get('config_mail_protocol') == 'mail' || $this->config->get('config_mail_protocol') == 'smtp') {
                // (+) ALNAUA 091114 (FINISH)
                    $mail = new Mail($this->config->get('config_mail_protocol'), $this->config->get('config_smtp_host'), $this->config->get('config_smtp_username'), $this->config->get('config_smtp_password'), $this->config->get('config_smtp_port'), $this->config->get('config_smtp_timeout'));
                    $mail->setTo($this->config->get('config_admin_email'));
                    $mail->setFrom($this->config->get('config_email'));
                    $mail->setSender(html_entity_decode($this->config->get('config_store'), ENT_QUOTES, 'UTF-8'));
                    $mail->setSubject($subject);
                    $mail->setText($message);
                    //$mail->send();
                // (+) ALNAUA 091114 (START)
                } elseif ($this->config->get('config_mail_protocol') == 'swift') {
                      $settings = array(
                          'config_smtp_host' => $this->config->get('config_smtp_host'),
                          'config_smtp_username' => $this->config->get('config_smtp_username'),
                          'config_smtp_password' => html_entity_decode($this->config->get('config_smtp_password'), ENT_QUOTES, 'UTF-8'),
                          'config_smtp_port' => $this->config->get('config_smtp_port')
                      );
                      $result = swift_send(
                              $settings,
                              array($this->config->get('config_email') => html_entity_decode($this->config->get('config_store'), ENT_QUOTES, 'UTF-8')), //from
                              array($this->config->get('config_admin_email') => html_entity_decode($this->config->get('config_store'), ENT_QUOTES, 'UTF-8')), //replyto
                              array($this->config->get('config_admin_email') => html_entity_decode($this->config->get('config_store'), ENT_QUOTES, 'UTF-8')), //to
                              $subject, //subject
                              $message,  //message
                              explode(';', $this->config->get('config_bcc_email')) //bcc
                              );
//                    $transport = Swift_MailTransport::newInstance();
//                    $mailer = Swift_Mailer::newInstance($transport);
//                    //Create the message
//                    $message = Swift_Message::newInstance()
//                      //Give the message a subject
//                      ->setSubject($subject)
//                      //Set the From address with an associative array
//                      ->setFrom(array($this->config->get('config_email') => html_entity_decode($this->config->get('config_store'), ENT_QUOTES, 'UTF-8')))
//                      //Set the To addresses with an associative array
//                      ->setTo(array($this->config->get('config_admin_email')))
//                      //Give it a body
//                      // 100219 ALNAUA Quotes bug fix Begin
//                      //->setBody($message)
//                      ->setBody(html_entity_decode($message, ENT_QUOTES, 'UTF-8'))
//                      // 100219 ALNAUA Quotes bug fix End
//                      ;
//                    $result = $mailer->send($message);
                }  
            }   
     }
}
    if ($this->config->get('config_stock_subtract')) {
    $order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");
   
    foreach ($order_product_query->rows as $product) {
        $this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = (quantity - " . (int)$product['quantity'] . ") WHERE product_id = '" . (int)$product['product_id'] . "'");
    
    $order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$product['order_product_id'] . "'");
    
    foreach ($order_option_query->rows as $option) {
        $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = (quantity - " . (int)$product['quantity'] . ") WHERE product_option_value_id = '" . (int)$option['product_option_value_id'] . "' AND subtract = '1'");
            }
          }
        }   
 }
 }
 ?>