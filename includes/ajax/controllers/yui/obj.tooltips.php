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

class stTooltipFactory extends stYUIFactory
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
    
    public function create($namespace, $text, $context)
    {
        $this->dataStore['settings']['namespace'] = $namespace;
        $this->dataStore['defaults']['context'] = $context;
        $this->dataStore['defaults']['text'] = $text;  
        return $this;  
    }
    
    public function render()
    {
       $config = '';
       $config = $this->genConfig();
       $this->buffer = 'YAHOO.tooltipFactory.init.{name} = function() {' . "\n\n" . $this->dataStore['instantiate'] . "\n\n}\n\n" . 'YAHOO.util.Event.onDOMReady(YAHOO.tooltipFactory.init.{name});';
       $this->buffer = str_replace('{widgetConfig}', $config, $this->buffer);
       $this->buffer = str_replace($this->dataStore['tplVals']['settings'], $this->dataStore['settings']['namespace'], $this->buffer);
       $namespace = $this->dataStore['settings']['namespace'];
       $this->tooltips[$namespace] = $this->buffer;
       $this->dataStore = '';
       $this->buffer='';
       if (count($this->tooltips) == 1) {
            //invoke required YUI package
            $yuiControls = stYui::getInstance();
            $yuiControls->addPackage('container'); 
       }
       $this->setDefaultData();
       return true;
    }
    
    public function paint($collapse='')
    {
        $tmpBuffer = '';
        $nameSpaces = '';
        $namespace = '';
        $data = '';
        $windows = '';
        if (is_array($this->namespaces) && is_array($this->tooltips) && isset($this->dataStore['namespace']))
        {
            foreach($this->namespaces as $namespace)
            {
                $nameSpaces .= str_replace('{namespace}', $namespace, $this->dataStore['namespace']) . "\n";                  
            }
            
            $tooltips = implode("\n", $this->tooltips);         
            
            $finalCode = $nameSpaces . "\n" . $tooltips;
            $tooltips = '';
            if ($collapse === true) {
               $finalCode = trim(preg_replace('/\s+/',' ', $finalCode));
            } 
            return $finalCode;
        } else {
            return false;
        } 
    }
    
    private function genConfig()
    {
        $defaults = $this->iterateOptionSet($this->dataStore['defaults']);
        $options = $this->iterateOptionSet($this->dataStore['options']);
        return (!empty($options)) ? $defaults . ', ' . $options:$defaults;    
    }
    
    protected function setDefaultData()
    {
        $this->dataStore = array('namespace', 'functions', 'instantiate', 'settings', 'tplVals', 'defaults', 'options', 'target');
        
        $this->dataStore['instantiate'] = 'YAHOO.tooltipFactory.{name} = new YAHOO.widget.Tooltip("{name}", { {widgetConfig} });';
        
        $this->dataStore['namespace'] = 'YAHOO.namespace("{namespace}");';
        
        $this->dataStore['tplVals']['settings'] = array('{name}'); 
        
        $this->dataStore['defaults']['context'] = '';
        $this->dataStore['defaults']['text'] = ''; 
        
        $this->dataStore['options']['showdelay'] = '';
        $this->dataStore['options']['hidedelay'] = '';
        $this->dataStore['options']['autodismissdelay'] = '';
        
        return true;          
    }    
}