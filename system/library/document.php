<?php
final class Document {
	public $title;
	public $description;
    // (+) ALNAUA 100112 Tags (START)
    public $keywords;
    // (+) ALNAUA 100112 Tags (FINISH)
	public $base;	
	public $charset = 'utf-8';		
	public $language = 'en-gb';	
	public $direction = 'ltr';		
	public $links = array();		
	public $styles = array();
	public $scripts = array();
	public $breadcrumbs = array();
    // (+) ALNAUA 091114 (START)
    public $active;
    // (+) ALNAUA 091114 (FINISH)
}
?>