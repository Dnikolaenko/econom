<?php
class ModelCatalogInformation extends Model {
 public function getInformation($information_id) {
  $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id) WHERE i.information_id = '" . (int)$information_id . "' AND id.language_id = '" . (int)$this->language->getId() . "'");
 
  return $query->row;
 }
 
 public function getInformations() {
  // (-/+) ALNAUA 091114 (START)
  //$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id) WHERE id.language_id = '" . (int)$this->language->getId() . "' ORDER BY i.sort_order ASC");
  $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id) WHERE id.language_id = '" . (int)$this->language->getId() . "' AND i.type = 'page' ORDER BY i.sort_order ASC");
  // (-/+) ALNAUA 091114 (FINISH)
 
  return $query->rows;
 }
 // (-/+) ALNAUA 091114 (START)
 public function getNews() {
     $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id) WHERE id.language_id = '" . (int)$this->language->getId() . "' AND i.type = 'news' ORDER BY i.date_added DESC");

  return $query->rows;
 }

 // (-/+) ALNAUA 091114 (START)
 public function getQuestions() {
     $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "question WHERE published = 1 ORDER BY date_added DESC");

     return $query->rows;
 }

    public function createQuestion($name, $email, $text, $type) {
      if ($type == 'ask') {
        $query = $this->db->query("INSERT INTO  " . DB_PREFIX . "question (name, email, text, published, date_added) VALUES ( '"
          .$this->db->escape($name)."', '"
          .$this->db->escape($email)."', '"
          .$this->db->escape($text)."', 0, NOW() );");
        
        if ($this->config->get('config_mail_protocol') == 'mail' || $this->config->get('config_mail_protocol') == 'smtp') {
            $mail = new Mail($this->config->get('config_mail_protocol'), $this->config->get('config_smtp_host'), $this->config->get('config_smtp_username'), html_entity_decode($this->config->get('config_smtp_password'), ENT_QUOTES, 'UTF-8'), $this->config->get('config_smtp_port'), $this->config->get('config_smtp_timeout'));
            $mail->setTo($this->config->get('config_director_email'));
            $mail->setFrom($email);
            $mail->setSender(html_entity_decode($name, ENT_QUOTES, 'UTF-8'));
            $mail->setSubject(html_entity_decode('Вопрос - ', ENT_QUOTES, 'UTF-8')||html_entity_decode($name, ENT_QUOTES, 'UTF-8'));
            $mail->setText($text);
            $mail->send();
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
                      array($this->db->escape($email) => html_entity_decode($name, ENT_QUOTES, 'UTF-8')), //replyto
                      array($this->config->get('config_admin_email') => html_entity_decode($this->config->get('config_store'), ENT_QUOTES, 'UTF-8')), //to
                      html_entity_decode('Вопрос -', ENT_QUOTES, 'UTF-8'). ' ' .html_entity_decode($name, ENT_QUOTES, 'UTF-8'), //subject
                      $text,  //message
                      explode(';', $this->config->get('config_bcc_email')) //bcc
                      );
//            $transport = Swift_MailTransport::newInstance();
//            $mailer = Swift_Mailer::newInstance($transport);
//            //Create the message
//            $message = Swift_Message::newInstance()
//              //Give the message a subject
//              ->setSubject(html_entity_decode('Жалоба', ENT_QUOTES, 'UTF-8'))
//              //Set the From address with an associative array
//              ->setFrom(array($this->db->escape($email) => html_entity_decode($name, ENT_QUOTES, 'UTF-8')))
//              //Set the To addresses with an associative array
//              ->setTo(array($this->config->get('config_director_email')))
//              //Give it a body
//              ->setBody(html_entity_decode($text, ENT_QUOTES, 'UTF-8'))
//              ;
//            $result = $mailer->send($message);
        }
      } else {
        if ($this->config->get('config_mail_protocol') == 'mail' || $this->config->get('config_mail_protocol') == 'smtp') {
            $mail = new Mail($this->config->get('config_mail_protocol'), $this->config->get('config_smtp_host'), $this->config->get('config_smtp_username'), html_entity_decode($this->config->get('config_smtp_password'), ENT_QUOTES, 'UTF-8'), $this->config->get('config_smtp_port'), $this->config->get('config_smtp_timeout'));
            $mail->setTo($this->config->get('config_director_email'));
            $mail->setFrom($email);
            $mail->setSender(html_entity_decode($name, ENT_QUOTES, 'UTF-8'));
            $mail->setSubject('Жалоба');
            $mail->setText($text);
            $mail->send();
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
                      array($this->db->escape($email) => html_entity_decode($name, ENT_QUOTES, 'UTF-8')), //replyto
                      array($this->config->get('config_director_email')), //to
                      html_entity_decode('Жалоба', ENT_QUOTES, 'UTF-8'), //subject
                      $text  //message
                      );
//            $transport = Swift_MailTransport::newInstance();
//            $mailer = Swift_Mailer::newInstance($transport);
//            //Create the message
//            $message = Swift_Message::newInstance()
//              //Give the message a subject
//              ->setSubject(html_entity_decode('Жалоба', ENT_QUOTES, 'UTF-8'))
//              //Set the From address with an associative array
//              ->setFrom(array($this->db->escape($email) => html_entity_decode($name, ENT_QUOTES, 'UTF-8')))
//              //Set the To addresses with an associative array
//              ->setTo(array($this->config->get('config_director_email')))
//              //Give it a body
//              ->setBody(html_entity_decode($text, ENT_QUOTES, 'UTF-8'))
//              ;
//            $result = $mailer->send($message);
        }
      }
    }

 public function getFreeShipping() {
  $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id) WHERE id.language_id = '" . (int)$this->language->getId() . "' AND i.type = 'page' AND i.name = 'freeshipping' ORDER BY i.sort_order ASC");

  return $query->row;
 }

 public function getItems($information_id) {
  $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id) WHERE id.language_id = '" . (int)$this->language->getId() . "' AND i.type = 'page' AND i.parent_information_id = '" . (int)$information_id . "' ORDER BY i.sort_order ASC");

  return $query->rows;
 }
 
 public function getPayment() {
  $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id) WHERE id.language_id = '" . (int)$this->language->getId() . "' AND i.type = 'page' AND i.name = 'payment' ORDER BY i.sort_order ASC");

  return $query->row;
 }
 // (-/+) ALNAUA 091114 (FINISH)
 // 121210 SEO optimization Begin
 public function getLatestNews($limit = 4) {
  $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id) WHERE id.language_id = '" . (int)$this->language->getId() . "' AND i.type = 'news' ORDER BY i.date_added DESC LIMIT " . $limit);

  return $query->rows;
 }
 // 121210 SEO optimization End
}
?>