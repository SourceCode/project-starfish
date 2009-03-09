<?php

/**
 * @package starfish
 * @author Ryan Rentfro, http://www.rentfro.net 
 * @version obj.events.php, v0.0.1a
 * @copyright Ryan Rentfro, http://www.rentfro.net
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @category core
 */

/**
 * @access public
 * @var object core event handler
 * @category objects
 */

class stEventHandler
{
    
    private static $instance;
    
	private $eventStorage; //events
    private $eventArgs;
	private $argStorage; //current page arguments
	private $eventTotal;
	private $eventSeed = 0;
    
    private $currentEvent;
	private $currentArgs;
	
    public function initialize()
    {
      $this->eventStorage = array();
      
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
    
/**
 * @access public
 * Checks if event array is valid
 *
 */
    
    public function is_validEvent($callbackObject)
    {
        if (is_array($callbackObject))
        {
            if (count($callbackObject) > 1)
            {
                return true;   
            }
        } else {
            return false;
        }   
    }
	
/**
 * @access private
 * Checks if events exist for a type of event
 *
 */
    
    private function eventTypeExist($type)
    {
      if (isset($this->eventStorage[$type])) 
      {
        if (is_array($this->eventStorage[$type]))
        {
            if (count($this->eventStorage[$type]) > 0)
            {
                return true;
            } else {
                return false;    
            }
        } else {
            return false;
        }
      } else {
          return false;
      }  
    }
    
/**
 * @access public
 * Checks if a specific event exists with a specific object callback
 *
 */    
    
    public function eventExist($type, $objectCallback)
    {
        $locateFlag = false;
        if (is_array($objectCallback))
        {
         if ($this->eventTypeExist($type) === true)
         {             
            $objectCall = $objectCallback[0];
            $objectMethod = $objectCallback[1]; 
            foreach($this->eventStorage[$type] as $eventArray)
            {
                $eventCall = $eventArray[0];
                $eventMethod = $eventArray[1];
                if ($objectCall == $eventCall)
                {
                    if ($objectMethod == $eventMethod)
                    {
                      return true;  
                    }
                }   
            }
            return false; 
         } else {
            return false;   
         }
        } else {
            return false;    
        }    
    }
/**
 * @access public
 * Registers a new event with a new Event ID
 *
 */     
    
    
    public function eventRegister($type, $arg, $objectCallback)
    {
        if ($this->eventExist($type, $objectCallback) === false && $this->is_validEvent($objectCallback) === true)
        {   
            $seed = $this->newEventID();
            $this->eventStorage[$type][$seed] = $objectCallback;
            $this->argStorage[$type][$seed] = $arg;
            $this->eventTotal++;
            return true;
        } else {
            return false;
        }          
    }
    
/**
 * @access private
 * Creates a new event ID and increments global id counter
 *
 */       
    
    private function newEventID()
    {
        $tSeed = $this->eventSeed;
        $this->eventSeed++;
        return $tSeed;
    }
    
/**
 * @access public
 * Accepts signals for events and their arguments.  Will locate and execute corresponding events
 *
 */      
    
    public function event($type, $arg)
    {
        if ($this->eventTypeExist($type) === true)
        {
            //event type exists
            $eventResults = array();
            foreach($this->eventStorage[$type] as $key => $value) {
                $eventArg = $this->argStorage[$type][$key];
                if ($eventArg === $arg) {
                    $validEvent = $this->eventStorage[$type][$key]; 
                    $eventResults[] = $this->executeEvent($validEvent, $arg);   
                }  
            } 
            
            if (is_array($eventResults))
            {
                return $eventResults;  
            } else {
                return false;    
            }    
        } else {
            return false;   
        }    
    }   
   
/**
 * @access private
 * Executes the stored event
 *
 */ 
     
    private function executeEvent($objectCallback, $arg)
    {  
      try { 
        $result = call_user_func($objectCallback, $arg); 
      } catch(Exception $e) {
        throw new stFatalError('Invalid Event Call for ' . $ObjectCallback[0] . '->' . $ObjectCallback[1] . ' with arguments ' . $arg);   
      } 
      return $result;         
    }
	
}