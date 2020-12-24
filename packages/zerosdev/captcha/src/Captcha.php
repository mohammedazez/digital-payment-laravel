<?php

/**
*
* PHP Captcha Generator
*
* (c) Zeros Technology
*
* @link www.zeros.co.id
*
* @link https://github.com/ZerosDev/PHP-Captcha
*
**/

namespace ZerosDev\Captcha;

use Session, Exception;

class Captcha
{
	/** captcha id **/
	protected $id = null;

	/** image buffer data **/
	protected $bufferData = null;

	/** error message **/
	protected $error = null;

	/** latest captcha session key **/
	protected $lastSessionKey = '';

	/** default captcha image width (px) **/
	protected $width = 170;

	/** default captcha image height (px) **/
	protected $height = 50;

	/** default captcha characters **/
	protected $chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

	/** default captcha length */
	protected $captchaLength = 6;

	/**
	*	
	* Initializing captcha
	*	
	* @return void
	*
	**/

	public function __construct()
	{
		$this->font = dirname(__DIR__).'/data/fonts/Arimo-Bold.ttf';

		/** Check if font is exists **/
		if( !file_exists($this->font) || !is_file($this->font) )
		{
			$this->error = 'Font file is not found!';
		}

		/** Start session if not started **/
		if( session_status() !== PHP_SESSION_ACTIVE )
		{
			if( !headers_sent() )
			{
				session_start();
			}
			else
			{
				$this->error = 'Session can not be started';
			}
		}
	}

	/**
	*	
	* Set the character list
	*
	* @param string of character $chars
	* @return \ZerosDev\Captcha\Captcha
	*
	**/

	public function chars($chars)
	{
		$this->chars = $chars;
		return $this;
	}

	/**
	*	
	* Set the length of captcha code
	*
	* @param integer $length
	* @return \ZerosDev\Captcha\Captcha
	*
	**/

	public function length($length)
	{
		$this->captchaLength = $length;
		return $this;
	}

	/**
	*	
	* Set the size of captcha image
	*
	* @param integer $width
	* @param integer $height
	* @return \ZerosDev\Captcha\Captcha
	*
	**/

	public function size($width, $height)
	{
		$this->width = intval($width);
		$this->height = intval($height);
		return $this;
	}

	/**
	*	
	* Generating captcha
	*	
	* @return \ZerosDev\Captcha\Captcha
	*
	**/

	public function generate()
	{
		try
		{
			if( $this->isError() ) {
				throw new Exception($this->error());
			}

			$image = imagecreatetruecolor($this->width, $this->height);
			$background_color = imagecolorallocate($image, 255, 255, 255);  
			imagefilledrectangle($image, 0, 0, $this->width, $this->height, $background_color);
			$line_color = imagecolorallocate($image, 64,64,64);

			for($i=0; $i<10; $i++)
			{
				imageline($image, 0, rand()%$this->height, $this->width, rand()%$this->height, $line_color);
			}

			$pixel_color = imagecolorallocate($image, 0, 0, 255);

			for($i=0; $i<1000; $i++)
			{
				imagesetpixel($image, rand()%$this->width, rand()%$this->height, $pixel_color);
			}

			$len = strlen($this->chars);
			$text_color = imagecolorallocate($image, 0,0,0);
			$shadow_color = $grey = imagecolorallocate($image, 128, 128, 128);
			$word = '';

			for($i=0; $i < $this->captchaLength; $i++)
			{
				$angle = mt_rand(-4, 4);
				$r = $i > 0 ? mt_rand(5, 12) : 0;
				$sizeStart = (($this->height/2)-5);
				$sizeEnd = (($this->height/2)+5);
				$font_size = mt_rand($sizeStart, $sizeEnd);
				$letter = $this->chars[mt_rand(0, $len-1)];
				imagettftext($image, $font_size, ($angle*$i), 18+($i*25)-$r, 35, $shadow_color, $this->font, $letter);
				imagettftext($image, $font_size, ($angle*$i), 18+($i*25)-$r, 35, $text_color, $this->font, $letter);
				$word .= $letter;
			}

			$word = str_replace(' ', '', $word);

			ob_start();
			imagepng($image);
			imagedestroy($image);

			$this->bufferData = ob_get_clean();
			$this->id = uniqid().time();
			$this->lastSessionKey = '_'.$this->id;
			$cd = Session::has('captcha') ? json_decode(Session::get('captcha'), true) : [];

			if( count($cd) >= 10 )
			{
				Session::forget('captcha');
				$cd = [];
			}

			$cd[$this->lastSessionKey] = $word;
			$sessionValue = json_encode($cd);
			Session::put('captcha', $sessionValue);
		}
		catch(Exception $e)
		{
			$this->error = $e->getMessage();
		}

		return $this;
	}

	/**
	*
	* Get captcha image
	*	
	* @return string of generated base64 image
	*
	**/

	public function image()
	{
		if( $this->isError() ) {
			return null;
		}

		return 'data:image/png;base64, ' . base64_encode($this->bufferData);
	}

	/**
	*	
	* Get captcha id
	*	
	* @return string of captcha generation id
	*
	**/

	public function id()
	{
		if( $this->isError() ) {
			return null;
		}

		return $this->id;
	}
	
	/**
	*	
	* Generate html hidden input
	*	
	* @param Captcha ID $id
	* 
	* @return html
	*
	**/
	
	public function form_field($id = null)
	{
	    if( $this->isError() ) {
			return null;
		}

		return '<input type="hidden" name="captcha_id" value="'.($id ? $id : $this->id).'">';
	}
	
	/**
	*	
	* Creating html tag of captcha image
	*	
	* @param HTML Attributes (array) $attributes
	* 
	* @return html
	*
	**/
	
	public function html_image($attributes = [])
	{
	    if( $this->isError() ) {
			return null;
		}
		
		$html = '<img src="'.$this->image().'" ';
		
		foreach($attributes as $name => $value)
		{
		    $html .= $name.'="'.$value.'" ';
		}
		
		$html .= '/>';

		return $html;
	}

	/**
	*	
	* Validating captcha
	*	
	* @param Captcha ID $id
	* @param Captcha Code $captcha
	* @return boolean
	*
	**/

	public function validate($id, $captcha)
	{
		if( $this->isError() ) {
			return false;
		}

		$cd = Session::has('captcha') ? Session::get('captcha') : null;
		if( !empty($cd) )
		{
			$list = json_decode($cd, true);
			$key = '_'.$id;
			if( isset($list[$key]) )
			{
				$result = hash_equals($list[$key], $captcha) ? true : false;
				
				if( $result )
				{
				    unset($list[$key]);
				    $sessionValue = json_encode($list);
			        Session::put('captcha', $sessionValue);
				}
				
				return $result;
			}
		}

		return false;
	}

	/**
	*	
	* Check if there is an error occured
	*	
	* @return boolean
	*
	**/

	public function isError()
	{
		return !empty($this->error) ? true : false;
	}

	/**
	*	
	* Get error message
	*	
	* @return string of error message
	*
	**/

	public function error()
	{
		if( !$this->isError() ) {
			return '';
		}

		return $this->error;
	}
}