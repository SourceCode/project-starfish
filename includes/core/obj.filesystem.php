<?php

/**
 * @package starfish
 * @author Ryan Rentfro, http://www.rentfro.net 
 * @version obj.filesystem.php, v0.0.1a
 * @copyright Ryan Rentfro, http://www.rentfro.net
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @category core
 */
 
/**
 * @access public
 * @var object system filepath manager
 * @category objects
 */

class stFilepath 
{
	
	private static $instance;

	//path settings
	public $root;
	public $admin;
	public $css;
	public $includes;
	public $core;
	public $lib;
	public $images;
	public $media;
	
	private function initialize() 
	{
		$this->root = dirname(dirname(__FILE__));
        $this->root = str_replace('includes', '', $this->root);
		$this->admin = $this->root . '/admin';
		$this->css = $this->root . '/css';
		$this->includes = $this->root . '/includes';
		$this->core = $this->root . '/includes/core';
		$this->lib = $this->root . '/includes/lib';
		$this->images = $this->root . '/includes/images';
		$this->media = $this->root . '/media';
		$this->content = $this->media . '/content';
		$this->modules = $this->root . '/includes/modules';
		$this->templates = $this->root . '/includes/templates';
	}
	
	public function getInstance()
	{
		if (!isset(self::$instance))
		{
			$class = __CLASS__;
			self::$instance = new $class();
			self::$instance->initialize();
		}
		return self::$instance;
	}
			
}

/**
 * @access public
 * @var object web filepath manager
 * @category objects
 */

class stWebpath 
{

	private static $instance;

	//path settings
	public $root;
	public $admin;
	public $css;
	public $includes;
	public $core;
	public $lib;
	public $images;
	public $media;
	public $modules;
	public $templates;
	
	public function initialize() 
	{
		$this->root = 'http://' . $_SERVER['SERVER_NAME'];
		$this->admin = $this->root . '/admin';
		$this->css = $this->root . '/css';
		$this->includes = $this->root . '/includes';
		$this->core = $this->root . '/includes/core';
		$this->lib = $this->root . '/includes/lib';
		$this->images = $this->root . '/includes/images';
		$this->media = $this->root . '/media';
		$this->content = $this->media . '/content';
		$this->modules = $this->root . '/includes/modules';
		$this->templates = $this->root . '/includes/templates';
	}
	
	public function getInstance()
	{
		if (!isset(self::$instance))
		{
			$class = __CLASS__;
			self::$instance = new $class();
			self::$instance->initialize();
		}
		return self::$instance;
	}
		
}

?>