<?php

/**
 * @package starfish
 * @author Ryan Rentfro, http://www.rentfro.net 
 * @version obj.template.php, v0.0.1a
 * @copyright Ryan Rentfro, http://www.rentfro.net
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @category core
 */

/**
 * @access public
 * @var object template controller
 * @category objects
 */


class stTemplate extends stCore
{
	public $path;
	public $preTpl;
	public $postTpl;
	
	public function __construct() 
	{
		global $stFile;
		if ($stFile instanceof stFilepath) {
			$this->path = $stFile;
		} else {
			die('st error');
			throw new Exception('Invalid Filepath Object.');
		}
	}
	
	public function getTemplate($tplName) 
	{
		if (!empty($tplName)) {
			require_once($this->path->theme . '/' . 'theme.' . $tplName . '.php');
			return $theme;
		} else {
			throw new Exception('Invalid Template.');
		}
	}
	
	public function loadTemplate($tplFile)
	{
		if (!empty($tplFile)) {
			require_once($tplFile);
			return $theme;
		} else {
			throw new Exception('Invalid Template.');
		}
	}
	
	public function setTemplate($template) 
	{
		if (!empty($template)) {
			$this->_reset();
			$this->preTpl = $template;
			return true;
		} else {
			return false;
		}
	}	
	
	public function get($tplName) 
	{
		return $this->getTemplate($tplName);
	}
	
	public function set($template) 
	{
		return $this->setTemplate($template);
	}
	
	public function matchObject($tplObj) 
	{
		$this->postTpl = '';
		if (strlen($this->preTpl) > 4) {
			if (is_object($tplObj) || is_array($tplObj)) {
				$this->postTpl = $this->preTpl;
				foreach($tplObj as $prop => $value) {
					$this->postTpl = str_replace('{' . $prop . '}', $value, $this->postTpl);
				}
				return $this->postTpl;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	public function match($tplObj) 
	{
		return $this->matchObject($tplObj);
	}
	
	public function replace($find, $replace='')
	{
		if (!empty($find)) {
			$this->postTpl = str_replace('{' . $find . '}', $replace, $this->postTpl);
			return $this->postTpl;
		} else {
			return false;
		}
	}
	
	public function _reset() 
	{
		$this->preTpl = '';
		$this->postTpl = '';
	}
	
}