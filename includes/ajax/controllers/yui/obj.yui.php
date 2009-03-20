<?php

/**
 * @package starfish
 * @author Ryan Rentfro, http://www.rentfro.net 
 * @version obj.yui.php, v0.0.1a
 * @copyright Ryan Rentfro, http://www.rentfro.net
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @category ajaxUI
 */

/**
 * @access public
 * @var object yui controller base class
 * @category objects
 * 
 * stYuiController is the base class for all YUI controller classes.
 * 
 */

class stYUIController
{
    protected static $instance;
    
    private $dataStore = array();
    private $buffer;
    
    public $namespaces = array();
}

  /**
 * @access public
 * @var object yui factory base class
 * @category objects
 * 
 * stYUIFactory is the base abstract class for yui factory classes.
 * 
 */

abstract class stYUIFactory extends stYUIController 
{
    abstract protected function render();
    abstract protected function paint();
    abstract protected function getInstance();
    abstract protected function initialize();
    abstract protected function setDefaultData();
    
    public function modify($property, $value)
    {
        if (isset($this->dataStore['defaults'][$property]))
        {
            $this->dataStore['defaults'][$property] = $value;     
        }    
        return $this; 
    }
    
    public function option($property, $value)
    { 
        if (isset($this->dataStore['options'][$property]))
        {
            $this->dataStore['options'][$property] = $value;     
        }
        return $this; 
    }
    
    private function iterateOptionSet($array)
    {
        $options = '';
        if (is_array($array))
        {
            foreach($array as $key => $value)
            {
                if ((is_string($value) || is_int($value)) && !is_bool($value))
                {
                    if (!empty($value)) $options .= $key . ':"' . $value . '", ';
                } elseif (is_bool($value)) 
                {
                    $options .= ( ($value) ? $key . ':true':$key . ':false' ) . ', ';
                }         
            }
            $length = strlen($options) - 2;
            $options = substr($options, 0, $length);
            return $options;         
        } else {
            return false;   
        }         
    }
    
}