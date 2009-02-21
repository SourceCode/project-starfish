<?php

/**
 * @package starfish
 * @author Ryan Rentfro, http://www.rentfro.net 
 * @version environment.php, v0.0.1a
 * @copyright Ryan Rentfro, http://www.rentfro.net
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @category config
 */


/**
 * @access public
 * @var object environment singleton
 * @category objects
 */

class stEnv
{
	
	private static $instance;
	
	//enviorment settings for core modules
	public static $mysql = true;
	public static $logger = true;
	public static $session = true;
	public static $html = true;
	public static $library = true;
	public static $events = true;
	public static $templates = true;
    
    //PHP libraries
    public static $smarty = true;
			
	private function __construct()
    {	
		//singleton pattern
    }
	
	public function getInstance()
	{
		if (!isset(self::$instance))
		{
			$class = __CLASS__;
			self::$instance = new $class();
		}
		return self::$instance;
	}
	
	public function __clone()
    {
        trigger_error('Object Error: Cloning Disabled', E_USER_ERROR);
    }

}