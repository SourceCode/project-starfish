<?php
require_once('../includes/core.php');
$smarty = stSmarty::getInstance();

//change the template dir. - 
$smarty->template_dir = $stFilepath->root . '/tests/content'; 

$smarty->assign('name', 'Ned');
$smarty->display('004-testSmarty.tpl');