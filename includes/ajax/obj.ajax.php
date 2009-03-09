<?php

/**
 * @package starfish
 * @author Ryan Rentfro, http://www.rentfro.net 
 * @version obj.ajax.php, v0.0.1a
 * @copyright Ryan Rentfro, http://www.rentfro.net
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @category ajax
 */

/**
 * @access public
 * @var object ajax dispatcher
 * @category objects
 */

class stAjax 
{
	
	private $post;
	private $get;
	private $files;
	private $request;
	private $callback;
	
	public function __construct()
	{
		return true;
	}
    
    public function parseRequest()
    {
        $stGlobal = stGlobal::getInstance();
           
    }

	private function invoke($object, $method, $data, &$callback) 
	{
	    	
	}
	
	private function callback($function, $object)
	{
		
	}

}