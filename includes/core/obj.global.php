<?php 

/**
 * @package starfish
 * @author Ryan Rentfro, http://www.rentfro.net 
 * @version obj.global.php, v0.0.1a
 * @copyright Ryan Rentfro, http://www.rentfro.net
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @category core
 */

/**
 * @access public
 * @var object global handler
 * @category objects
 */

class stGlobal
{
	
	//instance
	private static $instance;
	
	//global settings
	public $post = '';
	public $get = '';
	public $files = '';
	public $request = '';
			
	private function initialize()
	{
		$this->post = $_POST;
		$this->get = $_GET;
		$this->files = $_FILES;
		$this->request = $_REQUEST;
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