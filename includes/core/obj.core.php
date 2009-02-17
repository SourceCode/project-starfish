<?php

/**
 * @package starfish
 * @author Ryan Rentfro, http://www.rentfro.net 
 * @version obj.core.php, v0.0.1a
 * @copyright Ryan Rentfro, http://www.rentfro.net
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @category core
 */

/**
 * @access public
 * @var object core bootstrap
 * @category objects
 */

class stCore 
{
	public function __construct() 
	{
		error_reporting(E_ALL); //set error reporting
		putenv(stConfig::$timezone); //set application timezone
	}
}

?>