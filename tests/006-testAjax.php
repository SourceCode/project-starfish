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
 * Used to make sure the basics of ajax transactions are working
 */
 
require_once('../includes/core.php');
$yuiControls = new stYui();


$yuiControls->addPackage('XHR');
$includeList = $yuiControls->genIncludes();

$dBug->o($includeList);

?>