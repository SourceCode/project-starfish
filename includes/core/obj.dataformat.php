<?php

/**
 * @package starfish
 * @author Ryan Rentfro, http://www.rentfro.net 
 * @version obj.dataformat.php, v0.0.1a
 * @copyright Ryan Rentfro, http://www.rentfro.net
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @category core
 */

/**
 * @access public
 * @var object data format controls
 * @category objects
 */


class stDataFormats
{

	public $dataOutput;
	
	public function encodeData($data) 
	{
		return json_encode($data);
	}
	
	public function decodeData($data) 
	{
		return json_decode($data);
	}
	
	public function filterArray($array) 
	{
		if (is_array($array)) {
			foreach($array as $key => $value) {
				if (!is_numeric($key)) $data[$key] = $value;
			}
			return $data;
		} else {
			return false;
		}
	}
		
}