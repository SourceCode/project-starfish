<?php
require_once('../includes/core.php');
stLogFile::sysLog('This is logging test 1');
stLogFile::addLogBuffer('test line 1');
stLogFIle::addLogBuffer('test line 2');
stLogFile::addLogBuffer('test line 3');
stLogFile::writeLogBuffer();
echo 'Logging Test Completed<br />';
echo 'check log file: ' . stLogFile::sysLogFilename() . ' for details.';
