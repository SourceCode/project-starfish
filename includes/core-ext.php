<?php

/**
 * @package starfish
 * @author Ryan Rentfro, http://www.rentfro.net 
 * @version core-ext.php, v0.0.1a
 * @copyright Ryan Rentfro, http://www.rentfro.net
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @category core
 */

//process environment 
if (stEnv::$mysql === true)
{
	require_once($stLoad->get('mysql', 'core'));
}

if (stEnv::$logger === true)
{
	require_once($stLoad->getMod('logger', 'core'));
}

if (stEnv::$session === true)
{
	require_once($stLoad->get('session', 'core'));
}

if (stEnv::$templates === true)
{
	require_once($stLoad->get('templates', 'core'));	
}

if (stEnv::$html === true)
{
	require_once($stLoad->get('html', 'core'));
}

if (stEnv::$library === true)
{
	require_once($stLoad->get('library', 'core'));
}

if (stEnv::$events === true)
{
	require_once($stLoad->get('events', 'core'));	
}

$stLoad = null;

?>