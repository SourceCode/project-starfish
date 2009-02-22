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
	
    private static $instance;
    
	public $request;
	public $result;
	
	private $handler;
	private $outputBuffer;
	private $timeout = 8;
    
    public function getInstance()
    {
        if (!isset(self::$instance))
        {
            $class = __CLASS__;
            self::$instance = new $class();
        }
        return self::$instance;
    }
    
	
	public static function setRequest($requestURL) 
	{
		if (!empty($requestURL)) {
			self::$request = $requestURL;
		} else {
			return false;
		}
	}
	
	public static function processTransaction() 
	{
		if (!empty(self::$request)) {
			$result = self::getRequest();
			if ($result === true) {
				self::$result = self::$outputBuffer;
				self::$outputBuffer='';
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	private function getRequest() 
	{
		self::$handler = curl_init();
		curl_setopt(self::$handler,CURLOPT_URL, self::$request);
		curl_setopt(self::$handler,CURLOPT_CONNECTTIMEOUT,self::$timeout);
		curl_setopt(self::$handler,CURLOPT_RETURNTRANSFER,1);
		self::$outputBuffer = curl_exec(self::$handler);
		curl_close(self::$handler);
		if (!empty(self::$outputBuffer)) {
			return true;
		} else {
			return false;
		}
	}
}