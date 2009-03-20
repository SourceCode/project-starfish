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
 * @var object yui tooltip factory
 * @category objects
 * 
 * Use method chaining when calling this object.
 * 
 */

class stWindowFactory
{ 
    public $tooltips = array();
    
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
        $this->dataStore['default']['context'] = $context;
        $this->dataStore['default']['msg'] = $msg;  
        return $this;  
    }
    
    public function render()
    {
       $config = '';
       $config = $this->genConfig();
       $this->buffer = 'YAHOO.tooltipFactory.init.{name} = function() {' . "\n\n" . $this->dataStore['instantiate'] . "\n\n}\n\n" . 'YAHOO.util.Event.onDOMReady(YAHOO.tooltipFactory.init.{name});';
        return true;
    } 

    
    public function paint($collapse='')
    {
 
    }
    
    private function genConfig()
    {
        $defaults = $this->iterateOptionSet($this->dataStore['defaults']);
        $options = $this->iterateOptionSet($this->dataStore['options']);
        return (!empty($options)) ? $defaults . ', ' . $options:$defaults;    
    }
    
    private function setDefaultData()
    {
        $this->dataStore = array('namespace', 'functions', 'instantiate', 'settings', 'tplVals', 'defaults', 'options', 'target');
        
        $this->dataStore['instantiate'] = 'YAHOO.tooltipFactory.{name} = new YAHOO.widget.Tooltip("{name}", { {widgetConfig} });';

        $this->dataStore['default']['context'] = '';
        $this->dataStore['default']['msg'] = ''; 
        
        $this->dataStore['options']['showdelay'] = '';
        $this->dataStore['options']['hidedelay'] = '';
        $this->dataStore['options']['autodismissdelay'] = '';
        
        return true;          
    }    
}