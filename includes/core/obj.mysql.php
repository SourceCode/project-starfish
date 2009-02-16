<?

/**
 * @package starfish
 * @author Ryan Rentfro, http://www.rentfro.net 
 * @version obj.mysql.php, v0.0.1a
 * @copyright Ryan Rentfro, http://www.rentfro.net
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @category core
 */
 
/**
 * @access public
 * @var object mysql vector
 * @category objects
 */

class stMysql
{
	private static $instance;
	
	public $dbCon;
	public $db;
	private $filter;
	
	public function initialize() 
	{
		$this->filter = stIncluder::getInstance();
		$this->dbCon = mysql_pconnect(stConfig::$dbHost, stConfig::$dbUser, stConfig::$dbPass) or die("INVALID DATABASE CONFIG");
		$this->db = mysql_select_db(stConfig::$dbDatabase, $this->dbCon);
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
	
	public function genResult($origin='', $details='', $rowTotal='', $rows='', $result='', $type='') {
		switch($type) {
			default:
				break;
			case 'object':
					$resultSet = new stQueryResult();
					$resultSet->origin = $origin;
					$resultSet->details = $details;
					$resultSet->rowTotal = $rowTotal;
					$resultSet->rows = $rows;
					$resultSet->result = $result;
				break;
			case 'array':
					$resultSet['origin'] = $origin;
					$resultSet['details'] = $details;
					$resultSet['rowTotal'] = $rowTotal;
					$resultSet['rows'] = $rows;
					$resultSet['result'] = $result;
				break;
		}
		
		if ($resultSet instanceof stQueryResult) {
			return $resultSet;
		} elseif(is_array($resultSet)) {
			return $resultSet;
		} else {
			return false;
		}
	}
	
	private function clean($sql) 
	{
		return $this->filter->process($sql, $this->dbCon);
	}
		
	public function get($sql, $returnFormat = null) 
	{
		if (empty($sql)) return false;
		if (strpos(strtolower($sql), 'select')===false) return false;
		$queryResult = mysql_query($this->clean($sql), $this->dbCon);
		if ($queryResult) {
			$queryTotal = @mysql_num_rows($queryResult);
			if ($queryTotal > 0) {
				while($tmpData = mysql_fetch_assoc($queryResult)) {
					$tmpStack[] = $tmpData;
				}
				if ($returnFormat != null) {
					return $this->genResult('stMysql', 'select', $queryTotal, $tmpStack, true, $returnFormat);
				} else {
					return $this->genResult('stMysql', 'select', $queryTotal, $tmpStack, true);
				}
			} else {
				if ($returnFormat != null) {
					return $this->genResult('stMysql', 'select', 0, '', false, $returnFormat);
				} else {
					return $this->genResult('stMysql', 'select', 0, '', false);
				}
			}
		} else {
			return false;
		}
	}
	
	public function insert($sql) 
	{
		if (empty($sql)) return false;
		if (strpos(strtolower($sql), 'insert')===false) return false;
		$queryResult = mysql_query($this->clean($sql), $this->dbCon);
		if ($queryResult) {
			$tmpUID = @mysql_insert_id();
			if ($tmpUID > 0) {
				return $tmpUID;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	public function edit($sql) 
	{
		if (empty($sql)) return false;
		if (strpos(strtolower($sql), 'update')===false) return false;
		$queryResult = mysql_query($this->clean($sql), $this->dbCon);
		if ($queryResult) {
			$tmpCount = @mysql_affected_rows();
			if ($tmpCount > -1) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
		
	public function remove($sql) 
	{
		if (empty($sql)) return false;
		if (strpos(strtolower($sql), 'delete from')===false) return false;
		$queryResult = mysql_query($this->clean($sql), $this->dbCon);
		if ($queryResult) {
			$tmpCount = @mysql_affected_rows();
			if ($tmpCount > -1) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	public function getRecordByUID($table, $uid, $returnFormat = null) 
	{
		if (empty($table) || !is_numeric($uid)) return false;
		if (strpos(strtolower($sql), 'select')===false) return false;
		$queryResult = mysql_query("SELECT * FROM " . $table . " WHERE uid=" . $uid . " ORDER BY uid DESC LIMIT 1", $this->dbCon);
		if ($queryResult) {
			$queryTotal = @mysql_num_rows($queryResult);
			if ($queryTotal > 0) {
				$tmpData = mysql_fetch_assoc($queryResult);
				if ($returnFormat != null) {
					return $this->genResult('stMysql', 'select', $queryTotal, $tmpData, true, $returnFormat);
				} elseif ($returnFormat == 'direct') {
					return mysql_fetch_object($queryResult);
				} else {
					return $this->genResult('stMysql', 'select', $queryTotal, $tmpData, true);
				}
			} else {
				if ($returnFormat != null) {
					return $this->genResult('stMysql', 'select', 0, '', false, $returnFormat);
				} else {
					return $this->genResult('stMysql', 'select', 0, '', false);
				}
			}
		} else {
			return false;
		}
	}
	
	public function filteredInsert($sql) 
	{
		if (empty($sql)) return false;
		if (strpos(strtolower($sql), 'insert')===false) return false;
		$queryResult = mysql_query($sql, $this->dbCon);
		if ($queryResult) {
			$tmpUID = @mysql_insert_id();
			if ($tmpUID > 0) {
				return $tmpUID;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	public function filteredEdit($sql) 
	{
		if (empty($sql)) return false;
		if (strpos(strtolower($sql), 'update')===false) return false;
		$queryResult = mysql_query($sql, $this->dbCon);
		if ($queryResult) {
			$tmpCount = @mysql_affected_rows();
			if ($tmpCount > -1) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}

	}
	
	public function totalRows($table) 
	{

		if (!empty($table)) {
			$tmpSQL = "SELECT COUNT(*) FROM " . $table;
				$queryResult = mysql_query($this->clean($tmpSQL));
				$tableTotal = mysql_result($queryResult, 0, 0);
				return $tableTotal;
		} else {
			return false;
		}
	}
	
}

class stQueryResult 
{
	
	public $origin;
	public $date;
	public $details;
	public $rowTotal;
	public $rows;
	public $result;
	
	public function __constructor() 
	{
		$this->date("Y-M-D");
	}
	
	public function add($propName, $propVal) 
	{
		if (!empty($propName) && isset($propVal)) {
			$this->{$propName} = $propVal;
			return true;
		} else {
			return false;
		}
	}
	
	public function recordTotal() 
	{
		if (is_array($this->rows)) {
			return count($this->rows);
		} else {
			return 0;
		}
	}

}

?>