<?

$original_name ='testfi!!!!~~~le.jpg';

$sanitized_name = preg_replace('/[^0-9a-z\.\_\-]/i','',$original_name);
if ($sanitized_name == $original_name) {
  echo "Great file name!";
} else {
  echo "Filename problems.  Try ".$sanitized_name;
}  

?>