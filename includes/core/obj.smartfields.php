<?php

/**
 * @package starfish
 * @author Ryan Rentfro, http://www.rentfro.net 
 * @version obj.smartfields.php, v0.0.1a
 * @copyright Ryan Rentfro, http://www.rentfro.net
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @category core
 */
 
/**
 * @access public
 * @var object smart fields handler
 * @category objects
 */


class stSmartFields extends stHtml {
		
	public $configAutoAssume = true; //will assume post value of field is the primary value
	
	public function genField($type, $name, $value='', $id='', $attr='', $class='', $list='')
	{
		switch($type) {
			default:
					return false;
				break;
			case 'input':
					return $this->genInput($name, $value, $id, $attr, $class);
				break;
			case 'hidden':
					return $this->genHidden($name, $value, $id, $attr, $class);
				break;
			case 'textarea':
					return $this->genTextarea($name, $value, $id, $attr, $class);
				break;
			case 'checkbox':
					return $this->genCheckbox($name, $value, $id, $attr, $class);
				break;
			case 'checkboxset':
					return $this->genCheckboxSet($name, $value, $id, $attr, $class, $list);
				break;
			case 'radio':
					return $this->genRadio($name, $value, $id, $attr, $class);
				break;
			case 'radioset':
					return $this->genRadioSet($name, $value, $id, $attr, $class, $list);
				break;
			case 'select':
					return $this->genSelect($name, $value, $id, $attr, $class, $list);
				break;
			case 'imagefield':
					return $this->genImageField($name, $value, $id, $attr, $class);
				break;
			case 'filefield':
					return $this->genFileField($name, $value, $id, $attr, $class);
				break;
			case 'button':
					return $this->genButton($name, $value, $id, $attr, $class);
				break;
		}
	}
	
	public function gen($type, $name, $value='', $id='', $attr='', $class='', $list='') 
	{
		return $this->genField($type, $name, $value, $id, $attr, $class, $list);
	}
	
	private function valueAssume(&$attr, $name, $value='') 
	{
		if (!empty($name)) {
			if ($this->configAutoAssume === true) {
				if (!empty($_POST[$name])) {
					$attr['value'] =  $_POST[$name];
				} elseif(!empty($value)) {
					$attr['value'] =  $value;
				}
			} elseif($this->configAutoAssume === false) {
				if (!empty($value)) {
					$attr['value'] =  $value;
				} elseif(!empty($_POST[$name])) {
					$attr['value'] =  $_POST[$name];
				}
			} else {
				return false;
			}
			return true;
		}
	}
		
	private function assumeID(&$attr, $id='', $name='') 
	{
		if (!empty($id)) { 
			$attr['id'] = $id; 
		} elseif(array_key_exists('id', $attr)) { 
			//key was pre-set
		} else {
			$attr['id'] = $name; 
		}
	}
	
	private function assumeChecked(&$attr, $name, $value)
	{
		if (!empty($name)) {
			if ($_POST[$name] == $value) $attr['checked'] = 'checked';
		}
	}
	
	private function assumeSelected(&$nodeAttr, $name, $value)
	{
		if ($_POST['name'] == $value) $nodeAttr['selected'] = 'selected';
	}
	
	public function genInput($name, $value='', $id='', $attr='', $class='') 
	{
		if (!empty($name)) {
			$tmpTag = $this->stTag('input');
			if (is_array($attr)) $attrList = $attr;
			$attrList['name'] = $name;
			$attrList['type'] = 'text';
			if (!empty($class)) $attrList['class'] = $class;
			$this->assumeID($attrList, $id, $name);
			$this->valueAssume($attrList, $name, $value);
			return $this->processTag($tmpTag, $attrList);
		} else {
			return false;
		}	
	}
	
	public function genHidden($name, $value='', $id='', $attr='', $class='') 
	{
		if (!empty($name)) {
			$tmpTag = $this->stTag('input');
			if (is_array($attr)) $attrList = $attr;
			$attrList['name'] = $name;
			$attrList['type'] = 'hidden';
			if (!empty($class)) $attrList['class'] = $class;			
			$this->assumeID($attrList, $id, $name);
			$this->valueAssume($attrList, $name, $value);
			return $this->processTag($tmpTag, $attrList, $content);
		} else {
			return false;
		}	
	}
	
	public function genTextarea($name, $value='', $id='', $attr='', $class='') 
	{
		if (!empty($name)) {
			$tmpTag = $this->stTag('textarea', 'double');
			if (is_array($attr)) $attrList = $attr;
			$attrList['name'] = $name;
			if (!empty($class)) $attrList['class'] = $class;			
			$this->assumeID($attrList, $id, $name);
			$this->valueAssume($attrList, $name, $value);
			if (!empty($attrList['value'])) {
				$content = $attrList['value'];
				$attrList['value'] = '';
			} 
			return $this->processTag($tmpTag, $attrList, $content);
		} else {
			return false;
		}	
	}
	
	public function genCheckbox($name, $value=1, $id='', $attr='', $class='') 
	{
		if (!empty($name)) {
			$tmpTag = $this->stTag('input');
			if (is_array($attr)) $attrList = $attr;
			$attrList['name'] = $name;
			$attrList['type'] = 'checkbox';
			if (!empty($class)) $attrList['class'] = $class;
			if ($value !== 1 && $value != '') { $attrList['value'] = $value; } else { $attrList['value'] = 1; }
			$this->assumeID($attrList, $id, $name);
			$this->assumeChecked($attrList, $name, $value);
			return $this->processTag($tmpTag, $attrList);
		} else {
			return false;
		}	
	}
	
	public function genCheckboxSet($name, $value=1, $id='', $attr='', $class='', $list) 
	{
		if (!empty($name)) {
			if (is_array($list)) {
				$checkBox = $this->stTag('input');
				$baseAttr['type'] = 'checkbox';
				if (is_array($attr)) $baseAttr = array_merge($baseAttr, $attr);
				if (!empty($class)) $baseAttr['class'] = $class;
				foreach($list as $key => $keyVal) {
					$tmpNode = $checkBox;
					$attrList = array();
					$attrList['value'] = $keyVal;
					$attrList['name'] = $name . '-' . $key;
					$this->assumeChecked($attrList, $name . '-' . $key, $keyVal);
					$attrList = array_merge($attrList, $baseAttr);
					$tmpNode = $this->processTag($tmpNode, $attrList);
					$checkSet .= $tmpNode . "\n";
				}
				return $checkSet;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	public function genRadio($name, $value=1, $id='', $attr='', $class='') 
	{
		if (!empty($name)) {
			$tmpTag = $this->stTag('input');
			if (is_array($attr)) $attrList = $attr;
			$attrList['name'] = $name;
			$attrList['type'] = 'radio';
			if (!empty($class)) $attrList['class'] = $class;
			if ($value !== 1 && $value != '') { $attrList['value'] = $value; } else { $attrList['value'] = 1; }
			$this->assumeID($attrList, $id, $name);
			$this->assumeChecked($attrList, $name, $value);
			return $this->processTag($tmpTag, $attrList);
		} else {
			return false;
		}	
	}
	
	public function genRadioSet($name, $value=1, $id='', $attr='', $class='', $list)
	{
		if (!empty($name)) {
			if (is_array($list)) {
				$checkBox = $this->stTag('input');
				$baseAttr['type'] = 'radio';
				$baseAttr['name'] = $name;
				if (is_array($attr)) $baseAttr = array_merge($baseAttr, $attr);
				if (!empty($class)) $baseAttr['class'] = $class;
				foreach($list as $key => $keyVal) {
					$tmpNode = $checkBox;
					$attrList = array();
					$attrList['value'] = $keyVal;
					$this->assumeChecked($attrList, $name, $keyVal);
					$attrList = array_merge($attrList, $baseAttr);
					$tmpNode = $this->processTag($tmpNode, $attrList);
					$radioSet .= $tmpNode . "\n";
				}
				return $radioSet;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	public function genSelect($name, $value='', $id='', $attr='', $class='', $list) 
	{
		if (!empty($name)) {
			if (is_array($list)) {
				$selectTag = $this->stTag('select', 'double');
				$attrList['name'] = $name;
				if (!empty($class)) $attrList['class'] = $class;
				$optionTag = $this->stTag('option', 'double');
				foreach($list as $nodeValue => $nodeLabel) {
					$tmpNodeAttr = array();
					$tmpNodeAttr['value'] = $nodeValue;
					$this->assumeSelected($tmpNodeAttr, $name, $nodeValue);
					if ($tmpNodeAttr['selected'] != 'selected' && $nodeValue == $value) $tmpNodeAttr['selected'] = 'selected';
					if (!empty($attrList['name'])) unset($attrList['name']);
					$tmpNodeAttr = array_merge($tmpNodeAttr, $attrList);
					$tmpOption = $this->processTag($optionTag, $tmpNodeAttr, $nodeLabel);
					$optionSet .= $tmpOption . "\n";
				}
				return $this->processTag($selectTag, $attrList, $optionSet);
			} else {
				return false;
			}	
		} else {
			return false;
		}
	}
	
	public function genImageField($name, $value='', $id='', $attr='', $class='') 
	{
		if (!empty($name)) {
			$tmpTag = $this->stTag('input');
			if (is_array($attr)) $attrList = $attr;
			$attrList['name'] = $name;
			$attrList['type'] = 'image';
			if (!empty($class)) $attrList['class'] = $class;
			$this->assumeID($attrList, $id, $name);
			if (strtolower($value) == "submit") {
				$attrList['value'] = $value;
			} else {
				 $this->valueAssume($attrList, $name, $value);
			}			
			return $this->processTag($tmpTag, $attrList);
		} else {
			return false;
		}	
	}
	
	public function genFileField($name, $value='', $id='', $attr='', $class='') 
	{
		if (!empty($name)) {
			$tmpTag = $this->stTag('input');
			if (is_array($attr)) $attrList = $attr;
			$attrList['name'] = $name;
			$attrList['type'] = 'file';
			if (!empty($class)) $attrList['class'] = $class;
			$this->assumeID($attrList, $id, $name);
			return $this->processTag($tmpTag, $attrList);
		} else {
			return false;
		}	
	}
	
	public function genButton($name, $value='', $id='', $attr='', $class='') 
	{
		if (!empty($name)) {
			$tmpTag = $this->stTag('input');
			if (is_array($attr)) $attrList = $attr;
			$attrList['name'] = $name;
			$attrList['type'] = 'button';
			$this->assumeID($attrList, $id, $name);
			if (!empty($class)) $attrList['class'] = $class;
			if (strtolower($value) == "submit") {
				$attrList['value'] = $value;
			} else {
				 $this->valueAssume($attrList, $name, $value);
			}			
			return $this->processTag($tmpTag, $attrList);
		} else {
			return false;
		}
	}
}

?>