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

    private $dataStore = array('namespace', 'handler', 'functions', 'instantiate', 'listeners', 'settings', 'tplVals', 'callback', 'defaults');
    private $buffer;

    public $dialogs = array();
    public $namespaces = array();
    
    
    public function initialize()
    {
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
        $yesHandler = str_replace('mode', 'Yes', $this->dataStore['handler']);
        $yesHandler = str_replace('{callback}', $this->dataStore['settings']['callback'], $yesHandler); 
        $noHandler = str_replace('mode', 'No', $this->dataStore['handler']);
        $noHandler = str_replace('{callback}', '', $noHandler);
        $this->buffer = 'YAHOO.generator.init.dialog.{name} = new function() {' . "\n" . $yesHandler . "\n" . $noHandler . "\n" . $this->dataStore['instantiate'] . "\n" . $this->dataStore['functions'] . "\n" . $this->dataStore['listeners'] . '}' . "\n" . 'YAHOO.util.Event.addListener(window, "load", YAHOO.factory.init.dialog.{name})';   
        $this->buffer = str_replace($this->dataStore['tplVals']['settings'], $this->dataStore['settings'], $this->buffer);
        $this->buffer = str_replace($this->dataStore['tplVals']['defaults'], $this->dataStore['defaults'], $this->buffer);        
        if (strtolower($this->dataStore['defaults']['isDefault']) === 'yes') {
            $this->buffer = str_replace('{defIsDefYes}', 'true', $this->buffer);   
            $this->buffer = str_replace('{defIsDefNo}', 'false', $this->buffer);
        } else {
            $this->buffer = str_replace('{defIsDefYes}', 'false', $this->buffer);   
            $this->buffer = str_replace('{defIsDefNo}', 'true', $this->buffer);
        }
 
        $namespace = $this->dataStore['settings']['namespace'];
        $this->dialogs[$namespace] = $this->buffer;
        $this->namespaces = $namespace;
        $this->buffer = '';
        $this->dataStore = array('handler', 'functions', 'instantiate', 'listeners', 'settings', 'tplVals', 'callback', 'defaults');
        return $this;
    }
    
    public function paint($collapse=false)
    {
        $tmpBuffer = '';
        if (is_array($this->$namespaces) && is_array($this->dialogs))
        {
            foreach($this->$namespaces as $namespace)
            {
                $nameSpaces .= str_replace('{namespace}', $namespace, $this->dataStore['namespace']) . "\n";                
            }

            foreach($this->dialogs as $name => $data)
            {
                $dialogs .= $data . "\n";          
            }
            
            $finalCode = $nameSpaces . "\n" . $dialogs;
            $dialogs = '';
            
            if ($collapse === true) trim($finalCode, "\n");
            return $finalCode;
        } else {
            return false;
        }    
    }
    
    private function setDefaultData()
    {
        $this->namespaces = array('factory', 'factoryinit');
        
        $this->dataStore['namespace'] = 'YAHOO.namespace("{namespace}");';
        
        $this->dataStore['handler'] = 
            'var handle{mode} = function() {
                {callBack};        
                 this.hide();
            };';
        $this->dataStore['instantiate'] =
            'YAHOO.factory.{name} = new YAHOO.widget.SimpleDialog("{name}", 
                                             { width: "{defWidth}",
                                               fixedcenter: {defFixedCenter},
                                               visible: {defVisible},
                                               draggable: {defDraggable},
                                               close: {defClose},
                                               text: "{message}",
                                               icon: {defIcon},
                                               constraintoviewport: {true},
                                               buttons: [ { text:"{trueLabel}", handler:handleYes, isDefault:{defIsDefYes} },
                                                          { text:"{falseLabel}",  handler:handleNo, isDefault:{defIsDefNo} } ]
                                             } );';
        $this->dataStore['functions'] =
            'YAHOO.factory.{name}.setHeader("{message}");
             YAHOO.factory.{name}.render();';                                     
        
        $this->dataStore['listeners'] =
            'YAHOO.util.Event.addListener("show", "click", YAHOO.factory.{name}.show, YAHOO.factory.{name}, true);
            YAHOO.util.Event.addListener("hide", "click", YAHOO.factory.{name}.hide, YAHOO.factory.{name}, true);';
            
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
                /*'{defIsDefault}' used for switching default buytton */
                
            
        $this->setDefaults();        
        return true;    
            
    }
    
    private function setDefaults()
    {
        $this->dataStore['defaults']['width'] = '300px';
        $this->dataStore['defaults']['fixedcenter'] = 'true';
        $this->dataStore['defaults']['visible'] = 'false';
        $this->dataStore['defaults']['draggable'] = 'false';
        $this->dataStore['defaults']['close'] = 'true';
        $this->dataStore['defaults']['icon'] = 'YAHOO.widget.SimpleDialog.ICON_HELP';
        $this->dataStore['defaults']['constraintoviewport'] = 'true';
        $this->dataStore['defaults']['isDefault'] = 'yes'; 
    }
    	
}