<?php

/**
 * @package starfish
 * @author Ryan Rentfro, http://www.rentfro.net 
 * @version obj.debug.php, v0.0.1a
 * @copyright Ryan Rentfro, http://www.rentfro.net
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @category core
 */

/**
 * @access public
 * @var object debugger
 * @category objects
 */

class debug 
{
	
	public function p($var) 
	{
		if (is_string($var) || is_numeric($var) || is_float($var) || is_long($var)) {
			echo $var;
		} elseif (is_array($var)){
			echo '<pre>' . print_r($var, true) . '</pre>';
		} elseif (is_bool($var)) {
			if ($var==true) { echo 'false'; } else { echo 'true'; }
		} elseif (is_object) {
			echo '<pre>' . print_r($var, true) . '</pre>';
		} else {
			echo $var;
		}
	}
	
	public function t($checkVar) 
	{
		if (isset($checkVar)) {
			$varType = gettype($checkVar);
			echo '<br />Value type is: ' . $varType . '<br />';
		} else {
			return false;
		}
	}
	
	public function o($object) 
	{
		if (is_object($object)) {
			$this->classType($object);
			$this->classParent($object);
			$this->properties($object);
			$this->methods($object);
		} else {
			return false;
		}
	}
	
	public function objList() 
	{
		echo '<h2>Object List</h2>';
		$objArray = get_declared_classes();
			$this->p($objArray);
	}
	
	public function includeList() 
	{
		echo '<h2>Include List</h2>';
		$includeArray = get_included_files();
			$this->p($includeArray);
	}
	
	public function dump()
	{
		$this->objList();
		$this->includeList();
	}
	
	public function classType($object)
	{
		if (is_object($object)) {
			$classType = get_class($object);
				echo '<h2>Object Type</h2>';
				$this->p($classType);
		} else {
			return false;
		}
	}
	
	public function properties($object)
	{
		if (is_object($object)) {
			$objArray = get_object_vars($object);
				echo '<h2>Object Properties</h2>';
				$this->p($objArray);
		} else {
			return false;
		}
	}
	
	public function methods($object)
	{
		if (is_object($object)) {
			$objArray = get_class_methods($object);
				echo '<h2>Object Methods</h2>';
				$this->p($objArray);
		} else {
			return false;
		}
	}
	
	public function classParent($object)
	{
		if (is_object($object)) {
			$parentClass = get_parent_class($object);
				echo '<h2>Object Parent</h2>';
				$this->p($parentClass);
		} else {
			return false;
		}
	}
	
}

?>