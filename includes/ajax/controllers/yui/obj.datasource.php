<?php

/**
 * @package starfish
 * @author Ryan Rentfro, http://www.rentfro.net 
 * @version obj.datasource.php, v0.0.1a
 * @copyright Ryan Rentfro, http://www.rentfro.net
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @category ajaxUI
 */

/**
 * @access public
 * @var object yui dataSource factory
 * @category objects
 * 
 * Use method chaining when calling this object.
 * 
 */

class stAutoCompleteFactory extends stYUIFactory
{ 
    public $dataSource = array();
    private $schemaSet = false;
    
    public function initialize()
    {
        $this->namespaces = array('dataSourceFactory', 'dataSourceFactory.init');
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
    
    public function create($namespace, $data, $type, $method='')
    {
        $this->dataStore['settings']['namespace'] = $namespace;
        $this->dataStore['settings']['data'] = $data;
        $this->dataStore['settings']['type'] = $type;
        $this->dataStore['settings']['method'] = $type;
        return $this;  
    }
    
    public function render()
    { 
        if ($this->schemaSet === false) return false;
        $callSet = '';
        $name = '';
        $this->buffer = $this->dataStore['instantiate'] . "\n" . '{calls}' . "\n}\n\n";
        $this->buffer = str_replace('{name}', $this->dataStore['settings']['namespace'], $this->buffer);
        $this->buffer = str_replace('{type}', $this->dataStore['settings']['type'], $this->buffer);
        $this->buffer = str_replace('{source}', $this->dataStore['settings']['data'], $this->buffer);
        foreach($this->dataStore['calls'] as $function => $arg)
        {
            if (!empty($arg))
            {
                $call =  'YAHOO.dataSourceFactory.init.{name}.' . $function . ' = ';
                 if ((is_string($arg) || is_int($arg)) && !is_bool($arg))
                {
                    if (!empty($arg)) $call .= ((is_int($arg)) ?  $arg:'"' . $arg . '"');
                } elseif (is_bool($arg)) 
                {
                    $call .= ($arg) ? 'true':'false';
                }
                $callSet .= $call . "\n";
            }   
        }
        $this->buffer = str_replace('{calls}', $callSet, $this->buffer);
        $callSet = '';
        $this->buffer = str_replace('{schema}', $this->dataStore['settings']['schema'], $this->buffer);
        $this->dataStore['settings']['schema'] = '';
        $this->buffer = str_replace('{dataClass}', $this->dataStore['settings']['dataClass'], $this->buffer);
        $name = $this->dataStore['settings']['namespace'];
        $this->dataSource[$name] = $this->buffer;
        $this->buffer = '';
        $this->setDefaultData();
       return true;
    }
    
    public function paint($collapse='')
    {
        $tmpBuffer = '';
        $nameSpaces = '';
        $namespace = '';
        $data = '';
        $dialogs = '';
        if (is_array($this->namespaces) && is_array($this->dataSource) && isset($this->dataStore['namespace']))
        {
            foreach($this->namespaces as $namespace)
            {
                $nameSpaces .= str_replace('{namespace}', $namespace, $this->dataStore['namespace']) . "\n";                  
            }
            
            $dataSources = implode("\n", $this->dataSource);         
            
            $finalCode = $nameSpaces . "\n" . $dialogs;
            $dialogs = '';
            if ($collapse === true) {
               $finalCode = trim(preg_replace('/\s+/',' ', $finalCode));
            } 
            return $finalCode;
        } else {
            return false;
        }  
    }
    
    public function setSchema($schema, $dataClass)
    {
        $this->schemaSet = true;
        $this->dataStore['settings']['schema'] = $schema;
        $this->dataStore['settings']['dataClass'] = $dataClass;   
    }
    
    private function genConfig()
    {
        $defaults = $this->iterateOptionSet($this->dataStore['defaults']);
        $options = $this->iterateOptionSet($this->dataStore['options']);
        return (!empty($options)) ? $defaults . ', ' . $options:$defaults;
    }
    
    protected function setDefaultData()
    {
        $this->dataStore = array('namespace', 'instantiate', 'settings', 'tplVals', 'defaults', 'options', 'calls');
        
        $this->dataStore['instantiate'] = '
        YAHOO.dataSourceFactory.{name} = new YAHOO.util.{type}({source});
        YAHOO.dataSourceFactory.{name}.responseSchema = {schema}';

        $this->dataStore['settings']['schema'] = '';
        $this->dataStore['settings']['dataClass'] = '';
        
        $this->dataStore['defaults']['connXhrMode'] = ''; 
        
        $this->dataStore['calls']['setType'] = 'YAHOO.util.{type}.{dataClass}';
        $this->dataStore['calls']['responseType'] = '';
        $this->dataStore['calls']['responseSchema'] = '';
        $this->dataStore['calls']['setInterval'] = '';
        $this->dataStore['calls']['clearInterval'] = '';
        
        $this->schemaSet = false;
        
        return true;
    }
}