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
	public $post = array('module'=>'', 'view'=>''); 
	public $get = array('module'=>'', 'view'=>''); 
	public $files = '';
	public $request = array('module'=>'', 'view'=>'');
    public $type = '';
    public $upload = false;
    
    public $active;
			
	private function initialize()
	{       
		if (isset($_POST)) $this->setValue($_POST, $this->post);  
		if (isset($_GET)) $this->setValue($_GET, $this->get);  
		if (isset($_FILES)) $this->setValue($_FILES, $this->files); 
		if (isset($_REQUEST)) $this->setValue($_REQUEST, $this->request);
        $this->detectMethods();
        return true;
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
    
    private function setValue($array, &$reference)
    {
        if (isset($array) && is_array($array))
        {
          foreach($array as $key=>$data)
          {
              $reference[$key] = $data;
          }  
        } else {
            $reference = '';
        }
        return true;
    }
    
    private function detectMethods()
    {
        $pCount = 0;
        $gCount = 0;
        
        if (is_array($this->files)) $this->upload = true;
        
        if (is_array($_POST))
        {
            $pCount = count($_POST);  
        }
        
        if (is_array($_GET))
        {
            $gCount = count($_GET);
        }    
        
        if ($pCount > $gCount) {
            $this->type = 'post';
            $this->active = $this->post;                
        } elseif ($pCount == $gCount) {
            $this->type = 'get';
            $this->active = $this->get;
        }
        return true;
    }
    
}