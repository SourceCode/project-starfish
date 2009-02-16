<?php

/**
 * @package starfish
 * @author Ryan Rentfro, http://www.rentfro.net 
 * @version obj.xml.php, v0.0.1a
 * @copyright Ryan Rentfro, http://www.rentfro.net
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @category core
 */
 
/**
 * @access public
 * @var object xml handler
 * @category objects
 */


class stXML
{
	
	public $xmlURL;
	public $xmlData;

	public function __construct() {
	}
	
	public function openXMLFile($xmlURL)
	{
		if (!empty($xmlURL)) {
			try {
				$this->xmlURL = $xmlURL;
				$this->xmlData = simplexml_load_file($xmlURL);
				return true;
			} catch (Exception $e) {
				return false;
			}
		} else {
			return false;
		}
	}
	
	public function parseXMLFile($xmlURL)
	{
		if (!empty($xmlURL)) {
			try {
				$this->xmlURL = $xmlURL;
				$this->xmlData = new SimpleXMLElement($xmlURL);
				return true;
			} catch (Exception $e) {
				return false;
			}
		} else {
			return false;
		}
	}

}


?>