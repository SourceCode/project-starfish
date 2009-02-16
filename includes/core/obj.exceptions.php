<?php

/**
 * @package starfish
 * @author Ryan Rentfro, http://www.rentfro.net 
 * @version obj.exceptions.php, v0.0.1a
 * @copyright Ryan Rentfro, http://www.rentfro.net
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @category core
 */
 
/**
 * @access public
 * @var object general exception handler
 * @category objects
 */
 
class stException extends Exception {

	public function __construct($message, $code = 0) 
	{
		parent::__construct($message, $code);
	}

}

/**
 * @access public
 * @var object fatal exception handler
 * @category objects
 */

class stFatalError extends stException {

	public function __construct($message, $code = 0) 
	{
		parent::__construct($message, $code);
	}

}

/**
 * @access public
 * @var object warning exception handler
 * @category objects
 */
 
class stWarningError extends stException 
{

	public function __construct($message, $code = 0) 
	{
		parent::__construct($message, $code);
	}

}

/**
 * @access public
 * @var object permission exception handler
 * @category objects
 */
 
class stPermissionError extends stException 
{

	public function __construct($message, $code = 0) 
	{
		parent::__construct($message, $code);
	}

}

/**
 * @access public
 * @var object base exception handler
 * @category objects
 */
 
class stBasicError {
	
	public $errorData;
	
	public function newError($errorMessage)
	{
		$this->errorData[] = $errorMessage;
		return true;
	}
	
	public function makeErrorList()
	{
		if (is_array($this->errorData)) {
			return implode('<br />', $this->errorData);
		} else {
			return false;
		}
	
	}
	
}

?>