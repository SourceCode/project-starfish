<?php

/**
 * @package starfish
 * @author Ryan Rentfro, http://www.rentfro.net 
 * @version obj.windows.php, v0.0.1a
 * @copyright Ryan Rentfro, http://www.rentfro.net
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @category ajaxUI
 */

  /**
 * @access public
 * @var object yui window factory
 * @category objects
 * 
 * codeStore stores individual page segments, then after segments are complete they are rendered in the buffer - then placed in list, then buffer / defaults are reset
 * 
 * Use method chaining when calling this object.
 * 
 */

class stWindowFactory
{
    private static $instance;

    private $dataStore = array();
    private $buffer;
    
    public $windows = array();
    public $namespaces = array();
    
    
    public function initialize()
    {
        $this->namespaces = array('tooltipFactory', 'tooltipFactory.init');
        $this->setDefaultData();
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
    
    public function create($namespace, $context, $msg)
    {
        $this->dataStore['settings']['namespace'] = $namespace;
        $this->dataStore['settings']['context'] = $context;
        $this->dataStore['settings']['msg'] = $msg; 
        return $this;  
    }
    
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
    
    public function render()
    {

        return true;
    }
    
    private function genConfig()
    {
        $defaults = $this->iterateOptionSet($this->dataStore['defaults']);
        $options = $this->iterateOptionSet($this->dataStore['options']);
        return (!empty($options)) ? $defaults . ', ' . $options:$defaults;    
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
    
    public function paint($collapse='')
    {
 
    }
    
    private function setDefaultData()
    {
        $this->dataStore = array('namespace', 'functions', 'instantiate', 'settings', 'tplVals', 'defaults', 'options', 'target');
        
        
        $this->dataStore['instantiate'] = 'YAHOO.tooltipFactory = new YAHOO.widget.Tooltip("tt1", { context:"ctx", text:"My text was set using the \'text\' configuration property" });';

        $this->dataStore['options']['showdelay'] = '';
        $this->dataStore['options']['hidedelay'] = '';
        $this->dataStore['options']['autodismissdelay'] = '';
        
        return true;          
    }    
}