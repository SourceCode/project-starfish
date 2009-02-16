<?php

/**
 * @package starfish
 * @author Ryan Rentfro, http://www.rentfro.net 
 * @version config.php, v0.0.1a
 * @copyright Ryan Rentfro, http://www.rentfro.net
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @category config
 */


/**
 * @name stConfig
 * @access public
 * @var object config singleton
 * @category objects
 */
 
class stConfig 
{

	private static $instance;
	
	//framework version
	public static $version = '0.0.1';
	
	//database settings
	public static $dbDriver = 'mysql';
	public static $dbHost = 'localhost';
	public static $dbUser = 'root';
	public static $dbPass = '';
	public static $dbDatabase = 'starfish';
		
	//timezome settings
	public static $timezone = 'TZ=US/Central';
	
	//mail settings
	public static $mailFrom = 'From Name';
	public static $mailFromAddress = 'info@example.com';
	public static $mailNotifyAddress = 'info@example.com';
	
	//filtering settings
	public static $allowedTags = '';
	public static $allorAttr = '';
	
	//file settings
	public static $maxFilesize = '985368';
	public static $permittedImages = array('gif', 'png', 'jpeg', 'jpg', 'pjpeg');
	
	//permission table
	public static $permissionTable = array('0'=>'visitor', '1'=>'member', '8'=>'moderator', '9'=>'admin');
	
	//hash configs
	public static $salt = 'gmsCr3w2008-ph0tOD4Ta';
	
	//debug settings
	public static $enableDebug = true;
	
	private function __construct()
    {	
		//singleton pattern
    }
	
	public static function getInstance()
    {
        if (!isset(self::$instance)) 
		{
            self::$instance = new stConfig();
        }
        return self::$instance;
    }
	
	public function __clone()
    {
        trigger_error('Object Error: Cloning Disabled', E_USER_ERROR);
    }

}

?>