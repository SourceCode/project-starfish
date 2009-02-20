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

	public function hexColor($hex) 
	{
		if (strlen($hex) == 7 || strlen($hex) == 4) {
			$re = "(#?([A-Fa-f0-9]){3}(([A-Fa-f0-9]){3})?)";
			return parent::xpPreg($re, $hex);	
		} else {
			return false;
		}
	}
	
	public function inString($find, $string) 
	{
		if (!empty($string) && !empty($find)) {
			$re = "/\b" . $find . "\b/i";
			return parent::xpPreg($re, $string);
		} else {
			return false;
		}
	}
	
	public function securePass($pass) 
	{
		if (!empty($pass)) {
			$re = "/^.*(?=.{5,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/";
			return parent::xpPreg($re, $pass);
		} else {
			return false;
		}
	}
	
	public function validEmail($email)
	 {
		if (!empty($email)) {
			$re = "/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/";
			return parent::xpPreg($re, $email);
		} else {
			return false;
		}
	}
	
	public function checkHTML($string) 
	{
		if (!empty($string)) {
			$re = "(\<(/?[^\>]+)\>)";
			return parent::xpPreg($re, $string);
		} else {
			return false;
		}
	}
	
	public function stringEnd($string) 
	{
		if (!empty($string)) {
			$re = $string . "$";
			return parent::xpPreg($re, $string);
		} else {
			return false;
		}
	}
	
	public function stringStart($string) 
	{
		if (!empty($string)) {
			$re = "^" . $string;
			return parent::xpPreg($re, $string);
		} else {
			return false;
		}
	}
	
	public function isSocialSecurity($string) 
	{
		if (strlen($string) == 11) {
			$re = "[^\d{3}-\d{2}-\d{4}$]";
			return parent::xpPreg($re, $string);
		} else {
			return false;
		}
	}
	
	public function sqlInject($string) 
	{
		if (!empty($string)) {
			$re = '[(script)|(&lt;)|(&gt;)|(%3c)|(%3e)|(SELECT) |(UPDATE) |(INSERT) |(DELETE)|(GRANT) |(REVOKE)|(UNION)|(&amp;lt;)|(&amp;gt;)]';
			return parent::xpPreg($re, $string);
		} else {
			return false;
		}
	}
	
	public function isAlphaNum($string, $spaces=false) 
	{
		if (!empty($string)) {
			if ($spaces === false) { $re = "[^[a-zA-Z0-9]+$]"; } else { $re = "[^[a-zA-Z0-9 ]+$]"; }
			return parent::xpPreg($re, $string);
		} else {
			return false;
		}
	}
	
	public function validCC($creditCard) 
	{
		if (!empty($creditCard)) {
			$re = "[^(\d{4}[- ]){3}\d{4}|\d{16}$]";
			return parent::xpPreg($re, $creditCard);
		} else {
			return false;
		}
	}
	
	public function validISBN($isbn) 
	{
		if (!empty($isbn)) {
			$re = "[^\d{9}[\d|X]$]";
			return parent::xpPreg($re, $isbn);
		} else {
			return false;
		}
		
	}

	public function validPhone($phone) 
	{
		if (strlen($phone) == 12) {
			$re = "[^[2-9]\d{2}-\d{3}-\d{4}$]";
			return parent::xpPreg($re, $phone);
		} else {
			return false;
		}
	}
	
	public function validMD5($hash) 
	{
		if ($this->isAlphaNum($hash) !== false && strlen($hash) == 32) {
			return true;
		} else {
			return false;
		}
	}

}