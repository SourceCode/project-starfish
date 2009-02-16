<?

class pDebug
{
	
	public $debugData;
	public $debugRows;
	public $debugPointers = 0;
	public $increasePointerCascadeCount = 0;
	
	public $currentRow;
	public $currentDataSet;
	
	public function __construct()
	{
		
	}		
		
	//main controls	
	public function printValue(&$anyValue)
	{
		$this->increasePointerCount();
		$valueName = $this->variableName($anyValue);
		$valueType = $this->variableTypeDiscover($anyValue);
		
		if (is_string($anyValue) || is_numeric($anyValue) || is_float($anyValue) || is_long($anyValue)) {
			//value is string or integer
			$this->setDebugRow($anyValue, $valueName, $valueType);
			$this->appendRow();
		} elseif(is_bool($anyValue)) {
			//value is boolean
			if ($anyValue === true) {
				$boolVal = 'true';
			} else {
				$boolVal = 'false';
			}
			$this->setDebugRow($boolVal, $valueName, $valueType);
			$this->appendRow();
		} elseif(is_array($anyValue)) {
			//value is array
			$arrayInfo = '<h5>Array Length [ ' . $this->arrayDetails($anyValue) . ' ]</h5> ' . "\n";
			$arrayInfo .= $this->arrayData($anyValue);
			$this->setDebugRow($arrayInfo, $valueName, $valueType);
			$this->appendRow();
		} elseif(is_object($anyValue)) {
			//value is object
			$tmpClassType = $this->classType($anyValue);
			$tmpClassProperties = $this->classProperties($anyValue);
			
			if (is_array($tmpClassProperties)) {
				foreach($tmpClassProperties as $propName => $propVal) {
					$propList .= '[ ' . $propName . ' ] = ' . $propVal . "<br />\n";
				} //end foreach
			} else {
				$propList = '';
			}
			
			$tmpClassMethods = $this->classMethods($anyValue);
			if (is_array($tmpClassMethods)) {
				foreach($tmpClassMethods as $methodName) {
					$methList .= $methodName . "<br />\n";
				} //end foreach
			} else {
				$methList = '';
			}			
			
			if ($tmpClassType == "") $tmpClassType = 'unknown';
			$objectInfo = '<h5>Class Type</h5>' . "\n";
			$objectInfo .= $tmpClassType . "\n";
			$objectInfo .= '<h5>Class Parent</h5>' . "\n";
			$objectInfo .= $this->classParent($anyValue) . "\n\n";
			$objectInfo .= '<h5>Class Methods</h5>' . "\n";
			$objectInfo .= $methList . "\n\n";
			$objectInfo .= '<h5>Class Properties</h5>' . "\n";
			$objectInfo .= $propList . "\n\n";
			$valueType .= ' - ' . $tmpClassType;
			$this->setDebugRow($objectInfo, $valueName, $valueType);
			$this->appendRow();
		} else {
			//unknown value type
			$this->setDebugRow('', $valueName, 'unknown', 'unknown value type encountered');
		}
	}
		
	public function objectSnapshot($object)
	{
		$this->increasePointerCount();
	}
	
	private function variableTypeDiscover($value)
	{
		return gettype($value);
	}
	
	public function variableName(&$var, $scope=false, $prefix='stUnique', $suffix='stValue')
	{
		if ($scope === true) { $vals = $scope; } else { $vals = $GLOBALS; }
		$old = $var;
		$var = $new = $prefix.rand().$suffix;
		$vname = FALSE;
		foreach($vals as $key => $val) {
		  if ($val === $new) $vname = $key;
		} //end foreach
		$var = $old;
		return  '$' . $vname;
	}	
	
	//value controls
	public function variableValue($value)
	{
		$this->increasePointerCount();
	}
	
	public function variableType($value)
	{
		$this->increasePointerCount();
	}
	
	//array controls
	public function arrayData($array)
	{
		$this->increasePointerCount();
		return print_r($array, true);
	}
	
	public function arrayDetails($array)
	{
		$this->increasePointerCount();
		if (is_array($array)) {
			$valueTotal = count($array);
		} else {
			$valueTotal = 0;
		}
		return $valueTotal;
	}
	
	//class methods
	public function classType($object)
	{
		$this->increasePointerCascadeCount();
		if (is_object($object)) {
			return get_class($object);
		} else {
			return false;
		}
	}
	
	public function classParent($object)
	{
		$this->increasePointerCascadeCount();
		if (is_object($object)) {
			return get_parent_class($object);
		} else {
			return false;
		}
	}
		
	public function classProperties($object)
	{
		$this->increasePointerCascadeCount();
		if (is_object($object)) {
			return get_object_vars($object);
		} else {
			return false;
		}

	}
	
	public function classMethods($object)
	{
		$this->increasePointerCascadeCount();
		if (is_object($object)) {
			return get_class_methods($object);
		} else {
			return false;
		}
	}
	
	//pointer methods
	private function increasePointerCount()
	{
		$this->debugPointers++;
	}
	
	private function increasePointerCascadeCount()
	{
		$this->increasePointerCascadeCount++;
	}	
	
	//row methods
	public function appendRow()
	{
		$this->debugRows[] = $this->currentRow;
	}
	
	public function setDebugRow($dataSet, $varName, $varType, $details='')
	{
		$tmpArray['dataSet'] = $dataSet;
		$tmpArray['varName'] = $varName;
		$tmpArray['varType'] = $varType;
		$tmpArray['details'] = $details;
		$this->currentRow = $tmpArray;
		return true;
	}
	
}



?>