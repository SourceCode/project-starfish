<?
session_start();
require_once('../../includes/core.php');
echo 'core loaded';
require_once($stLoad->get('template', 'core'));
echo 'get';
$templateControls = new stTemplate();

$dBug->o($templateControls);

echo 'includer test complete';

echo '<br /><br />Start Template Test 1<br />';
$tplExample = $templateControls->get('example');
$dBug->p($tplExample);

echo '<br /><br />Start Template Test 2<br />';
$templateControls->set($tplExample['example1']);
$dBug->p($templateControls);
$tmpArray = array('user'=>'ryan', 'site'=>'test site');

$templateControls->set($tplExample['example2']);
$finalTemplate = $templateControls->matchObject($tmpArray);

$dBug->p($finalTemplate);

echo '<br /><br />Start Template Test 3<br />';

$templateControls->set($tplExample['example1']);
$dBug->p($templateControls);
$tmpObj = new stdClass();
$tmpObj->user = 'ryan';
$tmpObj->site = 'test site';

$templateControls->set($tplExample['example2']);
$finalTemplate = $templateControls->matchObject($tmpObj);

$dBug->p($finalTemplate);




?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>

<body>
Template Tester Complete
</body>
</html>
