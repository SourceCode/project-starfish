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
    
    public static function getInstance()
    {
        if (!isset(self::$instance))
        {                  
            $stFilepath = stFilepath::getInstance();
            require_once($stFilepath->lib . '/htmlMimeMail5/' . 'htmlMimeMail5.php');
            self::$instance = new htmlMimeMail5();
        }
        return self::$instance;
    }
}