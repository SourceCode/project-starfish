<?php

/**
 * @package starfish
 * @author Ryan Rentfro, http://www.rentfro.net 
 * @version obj.mail.php, v0.0.1a
 * @copyright Ryan Rentfro, http://www.rentfro.net
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @category core
 */
 
 /**
 * @access public
 * @var object mail handler
 * @category objects
 */

class stMail 
{
    private static $instance;
    
    public function initialize()
    {
        
    }
    
    public function getInstance()
    {
        if (!isset(self::$instance))
        {                  
            $stFilepath = stFilepath::getInstance();
            require_once($stFilepath->lib . '/' . );
            self::$instance = new $class();
            self::$instance->initialize();
        }
        return self::$instance;
    }    
 
	public static function sendMail($toEmail, $fromEmail, $fromAddress, $subject, $content) 
	{

		
	}

}