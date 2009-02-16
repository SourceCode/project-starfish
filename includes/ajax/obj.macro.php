<?php

/**
 * @package starfish
 * @author Ryan Rentfro, http://www.rentfro.net 
 * @version obj.macro.php, v0.0.1a
 * @copyright Ryan Rentfro, http://www.rentfro.net
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @category ajax
 */

/**
 * @access public
 * @var object ajax macro controller
 * @category objects
 */

class stAjaxMacro()
{
	
	private $post;
	private $get;
	private $files;
	private $request;
	
	public function __construct()
	{
		global $stGlobal;
		$this->post = $stGlobal->post;
		$this->get = $stGlobal->get;
		$this->files = $stGlobal->files;
		$this->request = $stGlobal->request;
		return true;
	}
	
	public function setMacro($macro)
	{
		
	}
	
	private function executeMacro()
	{
	
	}
}

?>