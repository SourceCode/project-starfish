<?php
require_once('../../includes/core.php');

/*
$testObj->test = 'test';
$dBug->o($testObj);
echo stConfig::$mailFromAddress;
$testIn = stConfig::getInstance();
$dBug->o($testIn);

*/
/*
echo 'test';
$filePath = new stFilepath();
$webPath = new stWebpath();

$dBug->o($filePath);
$dBug->o($webPath);

$dBug->o($stLoad);
*/



$stLoad->get('news');
$testObj = new pubNews();
$dBug->o($testObj);
$testObj->tester();


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>