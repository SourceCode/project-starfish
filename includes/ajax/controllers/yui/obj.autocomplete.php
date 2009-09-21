<?php

/**
 * @package starfish
 * @author Ryan Rentfro, http://www.rentfro.net 
 * @version obj.autocomplete.php, v0.0.1a
 * @copyright Ryan Rentfro, http://www.rentfro.net
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @category ajaxUI
 */

/**
 * @access public
 * @var object yui auto complete factory
 * @category objects
 * 
 * Use method chaining when calling this object.
 * 
 */

class stAutoCompleteFactory extends stYUIFactory
{ 
    public $tooltips = array();
    
    public function initialize()
    {
        $this->namespaces = array('autoCompleteFactory', 'autoCompleteFactory.init');
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
    
    public function create($namespace, $context, $container)
    {
        $this->dataStore['settings']['namespace'] = $namespace;
        $this->dataStore['settings']['container'] = $namespace;
        $this->dataStore['defaults']['context'] = $context;
        return $this;
    }
    
    public function render()
    {

       return true;
    }
    
    public function paint($collapse='')
    {

    }
    
    public function call($call, $value) {
        if (isset($this->dataStore['calls'][$call]))
        {
            $this->dataStore['calls'][$call] = $value;     
        }
        return $this;     
    }
    
    private function genConfig()
    {
        $defaults = $this->iterateOptionSet($this->dataStore['defaults']);
        $options = $this->iterateOptionSet($this->dataStore['options']);
        return (!empty($options)) ? $defaults . ', ' . $options:$defaults;
    }
    
    public function setData($source, $type='')
    {
        if ($type=='local' || $type=='')
        {
         
         
        } elseif($type=='local') {
              
        } else {
            return false;
        }
        return $this;          
    }
    
    public function setSchema($schema)
    {
        
    }
    
    protected function setDefaultData()
    {
        $this->dataStore = array('namespace', 'instantiate', 'settings', 'tplVals', 'defaults', 'options', 'target', 'return', 'calls');
        
        $this->dataStore['instantiate'] = '
            // Define Datasource
            var oDS = new {dataSource};
            // Define Schema
            oDS.responseSchema = {{schema}};

            // Instantiate the AutoComplete
            YAHOO.autoCompleteFactory.{name} = new YAHOO.widget.AutoComplete("{field}", "{container}", oDS);';
        
        $this->dataStore['return'] = 'return {
            oDS: oDS,
            YAHOO.autoCompleteFactory.{name}: YAHOO.autoCompleteFactory.{name}
            };';
        
        $this->dataStore['namespace'] = 'YAHOO.namespace("{namespace}");';
        
        $this->dataStore['tplVals']['settings'] = array('{name}'); 
        
        $this->dataStore['defaults']['context'] = '';
        
        $this->dataStore['options']['showdelay'] = '';

        $this->dataStore['calls']['prehighlightClassName'] = 'yui-ac-prehighlight';
        
        $this->dataStore['calls']['useShadow'] = true;
        
        return true;
    }
}