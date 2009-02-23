<?php

/**
 * @package starfish
 * @author Ryan Rentfro, http://www.rentfro.net 
 * @version obj.validate.php, v0.0.1a
 * @copyright Ryan Rentfro, http://www.rentfro.net
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @category core
 */
 
/**
 * @access public
 * @var object data validation object
 * @category objects
 */


class stValidate 
{
    private static $instance;
    
    
    public function getInstance()
    {
        if (!isset(self::$instance))
        {
            $class = __CLASS__;
            self::$instance = new $class();
        }
        return self::$instance;
    }
    
    private static function xpPreg($re, $value) {
        if (preg_match($re, $value, $f)) {
            return $f;
        } else {
            return false;
        }
    }
    
    
	public static function hexColor($hex) 
	{
		if (strlen($hex) == 7 || strlen($hex) == 4) {
			$re = "(#?([A-Fa-f0-9]){3}(([A-Fa-f0-9]){3})?)";
			return self::xpPreg($re, $hex);	
		} else {
			return false;
		}
	}
	
	public static function inString($find, $string) 
	{
		if (!empty($string) && !empty($find)) {
			$re = "/\b" . $find . "\b/i";
			return self::xpPreg($re, $string);
		} else {
			return false;
		}
	}
	
	public static function securePass($pass) 
	{
		if (!empty($pass)) {
			$re = "/^.*(?=.{5,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/";
			return self::xpPreg($re, $pass);
		} else {
			return false;
		}
	}
	
	public static function validEmail($email)
	 {
		if (!empty($email)) {
			$re = "/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/";
			return self::xpPreg($re, $email);
		} else {
			return false;
		}
	}
	
	public static function checkHTML($string) 
	{
		if (!empty($string)) {
			$re = "(\<(/?[^\>]+)\>)";
			return self::xpPreg($re, $string);
		} else {
			return false;
		}
	}
	
	public static function stringEnd($string) 
	{
		if (!empty($string)) {
			$re = $string . "$";
			return self::xpPreg($re, $string);
		} else {
			return false;
		}
	}
	
	public static function stringStart($string) 
	{
		if (!empty($string)) {
			$re = "^" . $string;
			return self::xpPreg($re, $string);
		} else {
			return false;
		}
	}
	
	public static function isSocialSecurity($string) 
	{
		if (strlen($string) == 11) {
			$re = "[^\d{3}-\d{2}-\d{4}$]";
			return self::xpPreg($re, $string);
		} else {
			return false;
		}
	}
	
	public static function sqlInject($string) 
	{
		if (!empty($string)) {
			$re = '[(script)|(&lt;)|(&gt;)|(%3c)|(%3e)|(SELECT) |(UPDATE) |(INSERT) |(DELETE)|(GRANT) |(REVOKE)|(UNION)|(&amp;lt;)|(&amp;gt;)]';
			return self::xpPreg($re, $string);
		} else {
			return false;
		}
	}
	
	public static function isAlphaNum($string, $spaces=false) 
	{
		if (!empty($string)) {
			if ($spaces === false) { $re = "[^[a-zA-Z0-9]+$]"; } else { $re = "[^[a-zA-Z0-9 ]+$]"; }
			return self::xpPreg($re, $string);
		} else {
			return false;
		}
	}
	
	public static function validCC($creditCard) 
	{
		if (!empty($creditCard)) {
			$re = "[^(\d{4}[- ]){3}\d{4}|\d{16}$]";
			return self::xpPreg($re, $creditCard);
		} else {
			return false;
		}
	}
	
	public static function validISBN($isbn) 
	{
		if (!empty($isbn)) {
			$re = "[^\d{9}[\d|X]$]";
			return self::xpPreg($re, $isbn);
		} else {
			return false;
		}
		
	}

	public static function validPhone($phone) 
	{
		if (strlen($phone) == 12) {
			$re = "[^[2-9]\d{2}-\d{3}-\d{4}$]";
			return self::xpPreg($re, $phone);
		} else {
			return false;
		}
	}
	
	public static function validMD5($hash) 
	{
		if ($this->isAlphaNum($hash) !== false && strlen($hash) == 32) {
			return true;
		} else {
			return false;
		}
	}

}