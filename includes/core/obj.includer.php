<?php 

/**
 * @package starfish
 * @author Ryan Rentfro, http://www.rentfro.net 
 * @version obj.includer.php, v0.0.1a
 * @copyright Ryan Rentfro, http://www.rentfro.net
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @category core
 */

/**
 * @access public
 * @var object includer controller
 * @category objects
 */

class stIncluder
{
	
	private static $instance;
	
	private $path;
	
	public function initialize() 
	{
		$this->path = stFilepath::getInstance();
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
	
	public function getIncludeFilePath($objName, $objType='') 
	{
		if (!empty($objName)) 
		{
			switch($objType) 
			{
				default:
						$path = $this->path->public . '/obj.';
					break;
				case 'core':
						$path = $this->path->core . '/obj.';
					break;
				case 'public':
						$path = $this->path->public . '/obj.';
					break;
				case 'private':
						$path = $this->path->private . '/obj.';
					break;
				case 'lib':
						$path = $this->path->lib . '/';
					break;
				case 'template':
						$path = $this->path->template . '/';
					break;	
				case 'content':
						$path = $this->path->content . '/';
					break;						
			}
			
			return $path . $objName . '.php';
		} else {
			die('Failed to include class/resource: ' . $objName . ' (' . $objType . ') ');
		}
	}
	
	public function getModuleFilePath($moduleName, $type='')
	{
		if (is_string($type)) 
		{
			switch($type)
			{
				default:
						$path = $this->path->modules . '/' . $moduleName . '/obj.' . $moduleName . '.php';
					break;
				case 'core':
						$path = $this->path->modules . '/core-' . $moduleName . '/obj.' . $moduleName . '.php';
					break;
			}
			return $path;
		} else {
			return false;	
		}
	}
	
	public function get($objName, $objType) //alias for getIncludeFilePath
	{
		return $this->getIncludeFilePath($objName, $objType);
	}
	
	public function getMod($moduleName, $type='')
	{
		return $this->getModuleFilePath($moduleName, $type);
	}

}

?>