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
        $this->namespaces = array('windowFactory', 'windowFactory.init');
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
    
    public function create($namespace, $header='', $body='', $footer='')
    {
        $this->dataStore['settings']['namespace'] = $namespace;
        $this->dataStore['defaults']['header'] = $header;
        $this->dataStore['defaults']['body'] = $header; 
        $this->dataStore['defaults']['footer'] = $footer; 
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
        $contentFuncs = '';
        $config = '';
        $render = '';
        $config = $this->genConfig();
        $this->buffer = 'YAHOO.windowFactory.init.{name} = function() {' . "\n" . $this->dataStore['instantiate']  . "\n\n" . '{functions}' . "\n\n }" . "\n" . 'YAHOO.util.Event.onDOMReady(YAHOO.dialogFactory.init.{name});';
        if (!empty($this->dataStore['defaults']['header']) || !empty($this->dataStore['defaults']['body']) || !empty($this->dataStore['defaults']['footer']))
        {
            $contentFuncs = str_replace('{header}', $this->dataStore['defaults']['header'], $this->dataStore['functions']['setContent']);
            $contentFuncs = str_replace('{body}', $this->dataStore['defaults']['body'], $contentFuncs);
            $contentFuncs = str_replace('{body}', $this->dataStore['defaults']['footer'], $contentFuncs);
        }
        
        if (empty($this->dataStore['target']))
        {
            $render = str_replace('{renderTarget}', 'document.body', $this->dataStore['functions']['setRender']);    
        } else {
            $render = str_replace('{renderTarget}', '"' . $this->dataStore['target'] . '"', $this->dataStore['functions']['setRender']);
        }
        
        if (!empty($contentFuncs)) $render = $contentFuncs . "\n" . $render . "\n";
        $this->buffer = str_replace('{functions}', $render, $this->buffer); 
        $this->buffer = str_replace('{widgetConfig}', $config, $this->buffer);
        $this->buffer = str_replace($this->dataStore['tplVals']['settings'], $this->dataStore['settings'], $this->buffer);
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
                if (is_string($value) && !is_bool($value))
                {
                    if (!empty($value)) $options .= $key . ':"' . $value . '", ';
                } elseif (is_bool($value)) 
                {
                   if (!empty($value)) $options .= $key . ':' . $value . ', ';  
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
        $tmpBuffer = '';
        $nameSpaces = '';
        $namespace = '';
        $data = '';
        $windows = '';
        if (is_array($this->namespaces) && is_array($this->windows) && isset($this->dataStore['namespace']))
        {
            foreach($this->namespaces as $namespace)
            {
                $nameSpaces .= str_replace('{namespace}', $namespace, $this->dataStore['namespace']) . "\n";                  
            }
            
            $windows = implode("\n", $this->windows);         
            
            $finalCode = $nameSpaces . "\n" . $windows;
            $windows = '';
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
        $this->dataStore = array('namespace', 'functions', 'instantiate', 'settings', 'tplVals', 'defaults', 'options', 'target');
        
        $this->dataStore['instantiate'] =
            'YAHOO.windowFactory.{name} = new YAHOO.widget.Overlay("{name}", { 
                {widgetConfig} 
                } );';
        $this->dataStore['namespace'] = 'YAHOO.namespace("{namespace}");'; 
                    
        $this->dataStore['functions']['setContent'] = 
            'YAHOO.windowFactory.{name}.setHeader("{header}");
            YAHOO.windowFactory.{name}.setBody("{body}");
            YAHOO.windowFactory.{name}.setFooter("{footer}");';
                    
        $this->dataStore['functions']['setRender'] =      
            'YAHOO.windowFactory.{name}.render({renderTarget});'; 
        
        $this->dataStore['tplVals']['settings'] = array('{namespace}');
        
        $this->dataStore['defaults']['width'] = '300px';
        $this->dataStore['defaults']['visible'] = false;
        $this->dataStore['defaults']['draggable'] = false;
        $this->dataStore['defaults']['fixedcenter'] = false;
        $this->dataStore['defaults']['constraintoviewport'] = false; 
        $this->dataStore['defaults']['autofillheight'] = 'body';
        $this->dataStore['defaults']['header'] = '';
        $this->dataStore['defaults']['body'] = '';
        $this->dataStore['defaults']['footer'] = '';
        
        $this->dataStore['options']['height'] = '';
        $this->dataStore['options']['zIndex'] = '';
        $this->dataStore['options']['context'] = '';
        $this->dataStore['options']['x'] = '';
        $this->dataStore['options']['y'] = '';
        $this->dataStore['options']['effect'] = '';
        $this->dataStore['options']['iframe'] = '';
        
        $this->dataStore['target'] = ''; //use to target content instead of generating programmatically - if empty defaults to document.body
        
        return true;          
    }	
}