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
	private $eventStorage; //events
	private $argStorage; //current page arguments
	private $eventTotal;
	private $eventSeed = 0;
	private $currentArgs;
	
	public function __construct()
	{
		
	}
	
	public function _getEventList()
	{
		return $this->eventStorage;	
	}
	
	public function registerArg($arg, $value)
	{
		$this->argStorage[$arg] = $value;
	}
	
	public function registerEvent($event, $action, $args='', $callbackObject)
	{
		if (!empty($event) && !empty($action) && is_object($callbackObject)) 
		{
			$eventSeed = $this->$eventSeed;
			$this->eventStorage[$event][$action][$eventSeed][args] = $args;
			$this->eventStorage[$event][$action][$eventSeed][callback] = $callbackObject;
			$this->$eventSeed++;
			return true;
		} else {
			return false;	
		}
	}
	
	public function unregisterEvents($event, $action)
	{
		if (is_string($event) && is_string($action))
		{
			if (count($this->eventStorage[$event][$action]) > 0) 
			{
				unset($this->eventStorage[$event][$action]);
				return true;
			}
		}
		return false;
	}

	public function executeEvent($eventObject)
	{
		if (is_object($eventObject)) 
		{
			$eventResult = $this->checkEventMatrix($eventObject);
			if (is_array($eventResult))
			{
				//events exist - handle arguments
				foreach($eventResult as $eventData)
				{
					if ($this->checkArguments($eventData) === true)
					{
						//execute event
						
					} 
				} //end foreach
			} else {
				return false;	
			}
		}
	}
	
	private function checkEventMatrix($event)
	{
		$event = $eventObject->event;
		$action = $eventObject->action;
		
		if (count($this->eventStorage[$event]) > 0) 
		{
			if (count($this->eventStorage[$event][$action]) > 0)
			{
				return $this->eventStorage[$event][$action];
			}
		} else {
			return false;	
		}
	}
	
	private function checkArguments($event)
	{
		if (is_array($eventData))
		{
			
		} else {
			return false;	
		}
	}
	
}