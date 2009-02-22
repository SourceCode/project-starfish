<?php

/**
 * @package starfish
 * @author Ryan Rentfro, http://www.rentfro.net 
 * @version 002-testLogging.php, v0.0.1a
 * @copyright Ryan Rentfro, http://www.rentfro.net
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @category tests
 */


/**
 * Used to test the Smarty templating engine
 */

require_once('../includes/core.php');
$smarty = stSmarty::getInstance();

//change the template dir. - 
$smarty->template_dir = $stFilepath->root . '/tests/content'; 

$smarty->assign('name', 'Starfish Smarty Test');
$smarty->display('004-testSmarty.tpl');