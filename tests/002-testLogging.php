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
 * Used to make sure the base functionality of system logging is operating
 */

require_once('../includes/core.php');
stLogFile::sysLog('This is logging test 1');
stLogFile::addLogBuffer('test line 1');
stLogFIle::addLogBuffer('test line 2');
stLogFile::addLogBuffer('test line 3');
stLogFile::writeLogBuffer();
echo 'Logging Test Completed<br />';
echo 'check log file: ' . stLogFile::sysLogFilename() . ' for details.';
