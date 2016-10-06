<?php 
final class Url { 
  	public function http($route) {
        // (+) ALNAUA 091114 (START)
        if ($route == 'common/home') {
          return HTTP_SERVER;
        }
        else {
        // (+) ALNAUA 091114 (FINISH)
          return HTTP_SERVER . 'index.php?route=' . str_replace('&', '&amp;', $route);
        // (+) ALNAUA 091114 (START)
        }
        // (+) ALNAUA 091114 (FINISH)
  	}

  	public function https($route) {
		if (HTTPS_SERVER != '') {
	  		$link = HTTPS_SERVER . 'index.php?route=' . str_replace('&', '&amp;', $route);
		} else {
	  		$link = HTTP_SERVER . 'index.php?route=' . str_replace('&', '&amp;', $route);
		}
				
		return $link;
  	}
}
?>