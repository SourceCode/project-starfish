<?
require_once('../../includes/core.php');
require_once($stLoad->get('html', 'core'));
require_once($stLoad->get('smartfields', 'core'));
require_once($stLoad->get('fieldpresets', 'core'));

$smartFields = new stSmartFields();
$fieldPresets = new stFieldPresets();

$dBug->o($smartFields);
$newField = $smartFields->gen('input', 'test_field');

echo '<br /><br />Input Fields<br/>';

echo $newField;

$newField2 = $smartFields->gen('input', 'testfield2', 'value', 'testfieldID', '', 'testClass');

echo '<br />' . $newField2;

$tmpAttr = array('attr1' => 'attr1', 'attr2' => 'attr2');
$newField3 = $smartFields->gen('input', 'testfield3', 'value2', 'testfieldID2', $tmpAttr, 'testClass');

echo '<br />' . $newField3;


echo '<br /><br />Text Areas<br/>';
$tmpAttr = array('attr1' => 'attr1a', 'attr2' => 'attr2a');
$newField4 = $smartFields->gen('textarea', 'testfield4', 'value Question', 'areaID2', $tmpAttr, 'classTextArea');

echo $newField4;

echo '<br /><br />Hidden Fields<br/>';
$tmpAttr = array('attr1' => 'attr1a', 'attr2' => 'attr2a');
$newField4 = $smartFields->gen('hidden', 'testfield4', 'value Question', 'areaID2', $tmpAttr, 'classTextArea');

echo $newField4;

echo '<br /><br />Button Fields<br/>';
$tmpAttr = array('attr1' => 'attr1a', 'attr2' => 'attr2a');
$newField4 = $smartFields->gen('button', 'testfield4', 'Submit Form', 'areaID2', $tmpAttr, 'classTextArea');

echo $newField4;

echo '<br /><br />Image Fields<br/>';
$tmpAttr = array('attr1' => 'attr1a', 'src' => $stPath .'/images/logo.gif');
$newField4 = $smartFields->gen('imagefield', 'testfield4', 'Submit Form', 'areaID2', $tmpAttr, 'classTextArea');

echo $newField4;

echo '<br /><br />File Fields<br/>';
$tmpAttr = array('attr1' => 'attr1a', 'attr2' => 'attr2');
$newField4 = $smartFields->gen('filefield', 'testfield4', 0, 'areaID2', $tmpAttr, 'classTextArea');

echo $newField4;

echo '<br /><br />Check Boxs<br/>';
$tmpAttr = array('attr1' => 'attr1a', 'attr2' => 'attr2');
$newField4 = $smartFields->gen('checkbox', 'testfield4', 1, 'areaID2', $tmpAttr, 'classTextArea');

echo $newField4;


echo '<br /><br />Radio Options<br/>';
$tmpAttr = array('attr1' => 'attr1a', 'attr2' => 'attr2');
$newField4 = $smartFields->gen('radio', 'testfield4', 1, 'areaID2', $tmpAttr, 'classTextArea');

echo $newField4;

echo '<br /><br />Select Field<br/>';
$tmpAttr = array('attr1' => 'attr1a', 'attr2' => 'attr2');
$newField4 = $smartFields->gen('select', 'testfield4', 'MO', 'areaID2', $tmpAttr, 'classTextArea', $fieldPresets->states);

echo $newField4;

echo '<br /><br />Check Box Set<br/>';
$tmpAttr = array('attr1' => 'attr1a', 'attr2' => 'attr2');
$newField4 = $smartFields->gen('checkboxset', 'testfield4', 'MO', 'areaID2', $tmpAttr, 'classTextArea', $fieldPresets->states);

echo $newField4;

echo '<br /><br />Radio Set<br/>';
$tmpAttr = array('attr1' => 'attr1a', 'attr2' => 'attr2');
$newField4 = $smartFields->gen('radioset', 'testfield4', 'MO', 'areaID2', $tmpAttr, 'classTextArea', $fieldPresets->states);

echo $newField4;

?>

