<?php

/**
 * @package starfish
 * @author Ryan Rentfro, http://www.rentfro.net 
 * @version obj.dialogs.php, v0.0.1a
 * @copyright Ryan Rentfro, http://www.rentfro.net
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @category ajaxUI
 */

 /**
 * @access public
 * @var object yui dialog factory
 * @category objects
 * 
 * codeStore stores individual page segments, then after segments are complete they are rendered in the buffer - then placed in list, then buffer / defaults are reset
 * 
 * Use method chaining when calling this object.
 * 
 */

class stDialogFactory 
{
    
    private static $instance;

    private $dataStore = array();
    private $buffer;
    
    public $dialogs = array();
    public $namespaces = array();
    
    
    public function initialize()
    {
        $this->namespaces = array('factory', 'factory.init');
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
    
    public function create($msg, $namespace, $callback, $trueLabel='Yes', $falseLabel='No')
    {
        $this->dataStore['settings']['msg'] = $msg;
        $this->dataStore['settings']['namespace'] = $namespace;
        $this->dataStore['settings']['trueLabel'] = $trueLabel;
        $this->dataStore['settings']['falseLabel'] = $falseLabel;
        $this->dataStore['callback'] = $callback;
        return $this;  
    }
    
    public function modify($property, $value)
    {
        if (isset($this->dataStore[$property]))
        {
            $this->dataStore[$property] = $value;     
        }    
        return $this; 
    }
    
    public function render()
    {
        $yesHandler = str_replace('{mode}', 'Yes', $this->dataStore['handler']);
        $yesHandler = str_replace('{callback}', $this->dataStore['callback'] . '();', $yesHandler); 
        $noHandler = str_replace('{mode}', 'No', $this->dataStore['handler']);
        $noHandler = str_replace('{callback}', '', $noHandler);
        $this->buffer = 'YAHOO.factory.init.{name} = function() {' . "\n" . $yesHandler . "\n" . $noHandler . "\n" . $this->dataStore['instantiate'] . "\n" . $this->dataStore['functions'] . "\n" . "\n}" . "\n" . 'YAHOO.util.Event.onDOMReady(YAHOO.factory.init.{name});';   
        $this->buffer = str_replace($this->dataStore['tplVals']['settings'], $this->dataStore['settings'], $this->buffer);
        $this->buffer = str_replace($this->dataStore['tplVals']['defaults'], $this->dataStore['defaults'], $this->buffer);        
        if (strtolower($this->dataStore['defaults']['isDefault']) === 'yes') {
            $this->buffer = str_replace('{defIsDefYes}', ', isDefault:true', $this->buffer);   
            $this->buffer = str_replace('{defIsDefNo}', '', $this->buffer);
        } else {
            $this->buffer = str_replace('{defIsDefYes}', '', $this->buffer);   
            $this->buffer = str_replace('{defIsDefNo}', ', isDefault:true', $this->buffer);
        }
        $namespace = $this->dataStore['settings']['namespace'];
        $this->dataStore = '';
        $this->dialogs[$namespace] = $this->buffer;
        if (count($this->dialogs) == 1) {
            //invoke required YUI package
            $yuiControls = stYui::getInstance();
            $yuiControls->addPackage('container'); 
        }
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
        if (is_array($this->namespaces) && is_array($this->dialogs) && isset($this->dataStore['namespace']))
        {
            foreach($this->namespaces as $namespace)
            {
                $nameSpaces .= str_replace('{namespace}', $namespace, $this->dataStore['namespace']) . "\n";                  
            }
            
            $dialogs = implode("\n", $this->dialogs);         
            
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
    
    private function setDefaultData()
    {
        
        
        $this->dataStore = array('namespace', 'handler', 'functions', 'instantiate', 'settings', 'tplVals', 'callback', 'defaults');
        $this->dataStore['namespace'] = 'YAHOO.namespace("{namespace}");';
        
        $this->dataStore['handler'] = 
            'var handle{mode} = function() {
                {callback}        
                 this.hide();
            };';
        $this->dataStore['instantiate'] =
            '
            
            YAHOO.factory.{name} = new YAHOO.widget.SimpleDialog("{name}", 
                                             { width: "{defWidth}",
                                               fixedcenter: {defFixedCenter},
                                               visible: {defVisible},
                                               draggable: {defDraggable},
                                               close: {defClose},
                                               text: "{message}",
                                               icon: {defIcon},
                                               constraintoviewport: {defConstraintoViewport},
                                               buttons: [ { text:"{trueLabel}", handler:handleYes{defIsDefYes} },
                                                          { text:"{falseLabel}",  handler:handleNo{defIsDefNo} } ]
                                             } );';
        $this->dataStore['functions'] =
            'YAHOO.factory.{name}.setHeader("{message}");
             YAHOO.factory.{name}.render();
             YAHOO.factory.{name}.show();
             console.log("test2"); 
             ';                                                     
            
        $this->dataStore['tplVals']['settings'] = array('{message}', '{name}', '{trueLabel}', '{falseLabel}');
        $this->dataStore['tplVals']['defaults'] = 
            array(
                '{defWidth}', 
                '{defFixedCenter}', 
                '{defVisible}', 
                '{defDraggable}', 
                '{defClose}',
                '{defIcon}',
                '{defConstraintoViewport}');
                /*'{defIsDefault}' used for switching default button */
                
            
        $this->dataStore['defaults']['width'] = '300px';
        $this->dataStore['defaults']['fixedcenter'] = 'true';
        $this->dataStore['defaults']['visible'] = 'false';
        $this->dataStore['defaults']['draggable'] = 'false';
        $this->dataStore['defaults']['close'] = 'true';
        $this->dataStore['defaults']['icon'] = 'YAHOO.widget.SimpleDialog.ICON_HELP';
        $this->dataStore['defaults']['constraintoviewport'] = 'true';
        $this->dataStore['defaults']['isDefault'] = 'yes';
                
        return true;    
            
    }
    	
}