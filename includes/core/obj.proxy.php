<?php 

/**
 * @package starfish
 * @author Ryan Rentfro, http://www.rentfro.net 
 * @version obj.proxy.php, v0.0.1a
 * @copyright Ryan Rentfro, http://www.rentfro.net
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @category core
 */
 
/**
 * @access public
 * @var object curl local proxy controller
 * @category objects
 */

class stProxy 
{
	
	public $request;
	public $result;
	
	private $handler;
	private $outputBuffer;
	private $timeout = 8;
	
	public function __construct($requestURL) 
	{
		if (!empty($requestURL)) {
			$this->request = $requestURL;
		} else {
			return false;
		}
	}
	
	public function proxyExecute() 
	{
		if (!empty($this->request)) {
			$result = $this->retrieveRequest();
			if ($result === true) {
				$this->result = $this->outputBuffer;
				$this->outputBuffer='';
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	private function retrieveRequest() 
	{
		$this->handler = curl_init();
		curl_setopt($this->handler,CURLOPT_URL, $this->request);
		curl_setopt($this->handler,CURLOPT_CONNECTTIMEOUT,$this->timeout);
		curl_setopt($this->handler,CURLOPT_RETURNTRANSFER,1);
		$this->outputBuffer = curl_exec($this->handler);
		curl_close($this->handler);
		if (!empty($this->outputBuffer)) {
			return true;
		} else {
			return false;
		}
	}
}