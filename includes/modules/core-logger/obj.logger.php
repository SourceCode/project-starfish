<?php

class stLogData 
{

	public $uid;
	public $userUID;
	public $type;
	public $data;
	public $object;
	public $date;
	
	public $logLine;
	
	public function process() 
	{
		$this->logLine = '[ ' . ucwords($this->type) . ' ] ' . $this->data . ' - ' . $this->object;
		return true;
	}
	
	public function setLog($userUID=0, $type, $data, $object='', $save=true)
	{
		$this->userUID = $userUID;
		$this->type = $type;
		$this->data = $data;
		$this->object = $object;
		if ($save === true) {
			return $this->save();
		} else {
			return true;
		} 
	}
	
	public function save() 
	{
		global $stLog;
		return $stLog->addLog($this);
	}
	
}

class stLogger extends stCore 
{
	
	private static $instance;
	
	public function	loadLog($uid)
	{
		global $stSQL;
		if (is_numeric($uid)) {
			$result = $stSQL->get("SELECT * FROM service_log WHERE uid=" . $uid . " ORDER BY uid DESC LIMIT 1", 'object');
			if (is_array($result->rows)) {
				$tmpLog = new stLogData();
				$tmpLog->uid = $result->rows[0]['uid'];
				$tmpLog->userUID = $result->rows[0]['user_uid'];
				$tmpLog->type = $result->rows[0]['log_type'];
				$tmpLog->object = $result->rows[0]['log_object'];
				$tmpLog->data = $result->rows[0]['log_data'];
				$tmpLog->date = $result->rows[0]['log_date'];
				return $tmpLog;
			} else {
				throw new stWarningError('Could not load log with uid: ' . $uid);
				return false;
			}
		} else {
			throw new stWarningError('Invalid UID Passed to Function');
			return false;
		}
	}
	
	public function getInstance()
	{
		if (!isset(self::$instance))
		{
			$class = __CLASS__;
			self::$instance = new $class();
			self::$instance->initialize();
		}
		return self::$instance;
	}

	
	public function addLog(stLogData $stLogData) 
	{
		global $stSQL;
		
		if ($stLogData instanceof stLogData) {
			$tmpSQL = "INSERT INTO service_log SET user_uid=" . $stLogData->userUID . ", log_type='" . $stLogData->type . "', log_data='" . $stLogData->data . "', log_object='" . $stLogData->object . "', log_date=NOW()";
			$logResult = $stSQL->insert($tmpSQL);
			if ($logResult > 0) {
				return $this->loadLog($logResult);
			} else {
				throw new stWarningError('Insert SQL Failed');
				return false;
			}
		} else {
			throw new stWarningError('Invalid Object Passed to Function');
			return false;
		}
	}
	
	public function searchLogsByType($type) 
	{
		global $stSQL;
		
		if (!empty($type)) {
			$result = $stSQL->get("SELECT uid FROM service_log WHERE log_type='" . $type . "' ORDER BY uid ASC");
			if (is_array($result)) {
				foreach($result as $logData) {
					$tmpObj = $this->loadLog($logData['uid']);
					if ($tmpObj instanceof stLogData) {
						$tmpCollection[] = $tmpObj;
					}
				} //end foreach
				return $tmpCollection;
			} else {
				return false;
			}
		} else {
			throw new stWarningError('Invalid or Empty String Passed to Function');
			return false;
		}
	}
	
	public function searchLogsByData($search) 
	{
		global $stSQL;
		
		if (!empty($search)) {
			$result = $stSQL->get("SELECT uid FROM service_log WHERE log_data LIKE '%" . $search . "%' ORDER BY uid ASC");
			if (is_array($result)) {
				foreach($result as $logData) {
					$tmpObj = $this->loadLog($logData['uid']);
					if ($tmpObj instanceof stLogData) {
						$tmpCollection[] = $tmpObj;
					}
				} //end foreach
				return $tmpCollection;
			} else {
				return false;
			}
		} else {
			throw new stWarningError('Invalid or Empty String Passed to Function');
			return false;
		}
	}
}

?>