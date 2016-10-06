<?php
class Captcha {
	protected $code;
	protected $width  = 35;
	protected $height = 150;

	function __construct() { 
		$this->code = substr(sha1(mt_rand()), 17, 5);
	}

	function getCode(){
		return $this->code;
	}

	function showImage() {
        $image = imagecreatetruecolor($this->height, $this->width);

        $width = imagesx($image); 
        $height = imagesy($image);
		
        $text  = imagecolorallocate($image, ceil(rand(0, 150)), ceil(rand(0, 150)), ceil(rand(0, 150)));
        $black = imagecolorallocate($image, 0, 0, 0);
        $white = imagecolorallocate($image, 255, 255, 255); 
        $red = imagecolorallocatealpha($image, 255, 0, 0, 75); 
        $green = imagecolorallocatealpha($image, 0, 255, 0, 75); 
        $blue = imagecolorallocatealpha($image, 0, 0, 255, 75); 
         
        imagefilledrectangle($image, 0, 0, $width, $height, $white); 
         
        imagefilledellipse($image, ceil(rand(25, 125)), ceil(rand(0, 35)), ceil(rand(30, 50)), ceil(rand(30, 50)), $red); 
        imagefilledellipse($image, ceil(rand(25, 125)), ceil(rand(0, 35)), ceil(rand(30, 50)), ceil(rand(30, 50)), $green); 
        imagefilledellipse($image, ceil(rand(25, 125)), ceil(rand(0, 35)), ceil(rand(30, 50)), ceil(rand(30, 50)), $blue); 

        imagefilledrectangle($image, 0, 0, $width, 0, $black); 
        imagefilledrectangle($image, $width - 1, 0, $width - 1, $height - 1, $black); 
        imagefilledrectangle($image, 0, 0, 0, $height - 1, $black); 
        imagefilledrectangle($image, 0, $height - 1, $width, $height - 1, $black); 
         
        imagestring($image, ceil(rand(2, 5)), intval(($width - (strlen($this->code) * 9)) / 2),  intval(($height - 15) / 2), $this->code, $text);
	
		header('Content-type: image/jpeg');
		
		imagejpeg($image);
		
		imagedestroy($image);		
	}
}
?>