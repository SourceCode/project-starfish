
<?php
  /**
* @package starfish
* @author Ryan Rentfro, http://www.rentfro.net
* @version 005-testEvents.php, v0.0.1a
* @copyright Ryan Rentfro, http://www.rentfro.net
* @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
* @category tests
*/
 
 
/**
* Used to make sure the basics of events are working
*/
 
 require_once('../includes/core.php');
 
 class exObjA
 {
     
    private $events;
     
    public function __construct()
    {
      $this->events = stEventHandler::getInstance();
      $this->events->eventRegister('onLoad', 'exObjB', array("exObjA", "callbackFunc"));
      $this->events->eventRegister('onExecute', array('exObjA', 'testFunction1'), array("exObjB", "callbackFunc"));
      $this->events->event('onLoad', __CLASS__);
    }
    
    public function callbackFunc($arg)
    {
        global $dBug;
       echo 'exObjA Callback Called with ' . $dBug->p($arg) . '<br /><br />';
    }
    
    public function testFunction1()
    {
        echo 'test Function 1';
        $this->events->event('onExecute', array(__CLASS__, 'testFunction1'));
    }
    
 }
 
 class exObjB
 {
    private $events;
     
    public function __construct()
    {
      $this->events = stEventHandler::getInstance();
      $this->events->eventRegister('onLoad', 'exObjA', array("exObjB", "callbackFunc"));
      $this->events->event('onLoad', __CLASS__);
    }
    
    public function callbackFunc($arg)
    {
        global $dBug;
        echo 'exObjB Callback Called with ' . $dBug->p($arg) . '<br /><br />';
    }
    
 }
 
$tmpA = new exObjA();
$tmpB = new exObjB();
 
unset($tmpA);
 
$tmpA = new exObjA();
$tmpA->testFunction1();