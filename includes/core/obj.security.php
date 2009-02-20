<?php

/**
 * @package starfish
 * @author Ryan Rentfro, http://www.rentfro.net 
 * @version obj.security.php, v0.0.1a
 * @copyright Ryan Rentfro, http://www.rentfro.net
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @category core
 */

/**
 * @access public
 * @var object security vector
 * @category objects
 */

class stSecure 
{
	private static $instance;
	
	public $filter;
	
	public function initialize() 
	{
		$stLoad = stIncluder::getInstance();
		require_once($stLoad->get('inputfilter/class.inputfilter.php', 'lib'));
		$this->filter = new InputFilter();
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
	
	public function getFilter()
	{	
		if (!isset(self::$instance)) $this->getInstance();
		return self::$filter;	
	}
	
}