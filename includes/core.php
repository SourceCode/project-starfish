<?php 

/**
 * @package starfish
 * @author Ryan Rentfro, http://www.rentfro.net 
 * @version core.php, v0.0.1a
 * @copyright Ryan Rentfro, http://www.rentfro.net
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @category core
 */

//disable autoloading of objects	
function __autoload($class_name) 
{
	die('Missing Class: ' . $class_name . ' Dynamic Class Loading is not permitted');
}

/*-------------------------------------------------------------
 Core Required Objects
-------------------------------------------------------------*/

//instantiate required core configuration singletons
require_once('config.php');
require_once('environment.php');

//instantiate exceptions vectors
require_once('core/obj.exceptions.php');

//boot core
require_once('core/obj.core.php');
$stCore = new stCore();

//enable debugger
if (stConfig::$enableDebug === true) {
	require_once('core/obj.debug.php');
	$dBug = new debug();
}

//load module handler
require_once('core/obj.modules.php');

//instantiate filesystem vector
require_once('core/obj.filesystem.php');

//instantiate include handler
require_once('core/obj.includer.php');
$stLoad = stIncluder::getInstance();

/*-------------------------------------------------------------
 Includer required from this point forward
-------------------------------------------------------------*/

//instantiate security vector
require_once($stLoad->get('security', 'core'));

//instantiate required core globals
require_once($stLoad->get('global', 'core'));

//instantiate controller
require_once($stLoad->get('controller', 'core'));

$controller = stController::getInstance();

/*-------------------------------------------------------------
 Enviornment Controlled Objects
-------------------------------------------------------------*/

if (file_exists($stFile->includes . '/core-ext.php')) //extends core functionality
{
	require_once($stFile->includes . '/core-ext.php');
}

?>