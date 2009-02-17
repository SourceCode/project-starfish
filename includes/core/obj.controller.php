<?php

/**
 * @package starfish
 * @author Ryan Rentfro, http://www.rentfro.net 
 * @version obj.controller.php, v0.0.1a
 * @copyright Ryan Rentfro, http://www.rentfro.net
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @category core
 */

/**
 * @access public
 * @var object core controller
 * @category core
 */


class stController
{
	private static $instance;
	
	//call context
	public $module = 'init';
	public $view = 'init';
	public $state = array('module' => 'init', 'view' => 'init', 'data' => '');
	
	//module and data storage - clear on finish
	private $storage;
	
	//execution stack
	public $stack;
	
	public function initialize()
	{
		//priority for context is always post before get and never request.
		$this->storage = stGlobal::getInstance();
		$this->setState();
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
	
	private function setState()
	{
        
		if (count($this->storage->post) > 0)
		{
			if (is_string($this->storage->post['module']))
			{
				$this->module = $this->storage->post['module'];
				$this->state['module'] = $this->module;
				unset($this->storage->post['module']);
			}  
			
			if (is_string($this->storage->post['view']))
			{
				$this->view = $this->storage->post['view'];
				$this->state['view'] = $this->view;
				unset($this->storage->post['module']);
			}
			$this->state['data'] = $this->storage->post;
		} elseif (count($this->storage->get) > 0) 
		{
			if (is_string($this->storage->get['module']))
			{
				$this->module = $this->storage->get['module'];
				$this->state['module'] = $this->module;
				unset($this->storage->get['module']);
			}
			
			if (is_string($this->storage->get['view']))
			{
				$this->view = $this->storage->get['view'];
				$this->state['view'] = $this->view;
				unset($this->storage->get['view']);
			}
			$this->state['data'] = $this->storage->get;
		}

        
		$this->storage = null;
	}
	
	public function dispatch()
	{
		if (!empty($this->module) && !empty($this->view))
		{			
			$stLoad = stIncluder::getInstance();
			require_once($stLoad->getMod($this->module));
			$this->storage = new $this->module();
			$this->storage->initialize();
			$this->storage = null;
		} else {
			throw new stFatalError('Invalid Controller Call');
		}
	}
	
}

?>