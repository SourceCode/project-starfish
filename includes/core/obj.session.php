<?

/**
 * @package starfish
 * @author Ryan Rentfro, http://www.rentfro.net 
 * @version obj.session.php, v0.0.1a
 * @copyright Ryan Rentfro, http://www.rentfro.net
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @category core
 */

/**
 * @access public
 * @var object session data object
 * @category objects
 */

class stSessionData 
{
	public $uid;
	public $hash;
	public $object;
	public $level;
	public $active;
	
	public $userUID;
	
	public function __construct() 
	{
		//setup empty object
		$this->object = new stdClass();
		$this->object->startPage = '';
		$this->object->currentPage = '';
		$this->object->startTime = '';
		$this->object->touchTime = '';
		$this->object->referer = '';
		$this->object->ip = '';
		$this->object->hostname = '';
		$this->object->userUID = '';
		$this->object->sitePath = array();
	}
	
	public function parseSessionObject($object)
	{
		$this->object->startPage = $object->startPage;
		$this->object->currentPage = $object->currentPage;
		$this->object->startTime = $object->startTime;
		$this->object->touchTime = $object->touchTime;
		$this->object->referer = $object->referer;
		$this->object->ip = $object->ip;
		$this->object->hostname = $object->hostname;
		$this->object->sitePath = $object->sitePath;
		$this->object->userUID = $object->userUID;
		$this->userUID = $this->object->userUID;
		return true;		
	}
	
	public function startupSession()
	{
		$this->object->startPage = $_SERVER['SCRIPT_FILENAME'];
		$this->object->currentPage = $_SERVER['SCRIPT_FILENAME'];
		$this->object->startTime = date("D M j G:i:s T Y");
		$this->object->referer = $_SERVER['HTTP_REFERER'];
		$this->updateSession('startup');
		return true;
	}
	
	public function updateSession($mode='update')
	{
		if (!empty($ip)) {
			$this->object->ip = $ip;
			$this->object->hostname = GetHostByName($ip);
		}
		
		$this->object->touchTime = date("D M j G:i:s T Y");
		if ($mode=='update') $this->object->sitePath[] = $_SERVER['SCRIPT_FILENAME'];
		
	}
	
	public function validateAgainstSelf(stSessionData $stSessionData)
	{
		if ($stSessionData instanceof stSessionData) {
			if ($this->hash == $stSessionData->hash) {
				if ($this->level == $stSessionData->level) {
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			} 
		} else {
			return false;
		}
	}
	
}

/**
 * @access public
 * @var object session handler
 * @category objects
 */

class stSession
{

	public function __construct($caller)
	{
		global $stSQL;
		if ($caller == 'child') {
			$tmpDay = date("l");
			if (strtolower($tmpDay) == 'sunday') {
				$totalSessions = $stSQL->totalRows('site_sessions');
				if ($totalSessions > 7500) {
					$this->pruneSessions();
				}
			}
		} else {
			throw new stFatalError("Session Class can only be accessed from children");
		}
	}

	public function loadSession($hash)
	{
		global $stSQL, $dBug;
		if (strlen($hash) == 32) {
			$loadResult = $stSQL->get("SELECT * FROM site_sessions WHERE session_hash='" . $hash . "' ORDER BY uid DESC LIMIT 1", 'object');
			if (is_object($loadResult) && is_array($loadResult->rows[0])) {
				$tmpObj = new stSessionData();
				$tmpObj->uid = $loadResult->rows[0]['uid'];
				$tmpObj->hash = $loadResult->rows[0]['session_hash'];
				$tmpObj->level = $loadResult->rows[0]['session_level'];
				$tmpObj->active = $loadResult->rows[0]['session_active'];
				if (!empty($loadResult->rows[0]['session_object'])) {
					$tmpSessionObj = unserialize($loadResult->rows[0]['session_object']);
					$tmpObj->parseSessionObject($tmpSessionObj);
				}
				$this->markActive($hash);
				return $tmpObj;
			} else {
				return false;
			}
		} else {
			throw new stFatalError('Invalid Session Hash with length of ' . strlen($hash) . ' passed to method');
			return false;
		}
	}
	
	public function newSession() 
	{
		global $dBug;
		if (strlen($_SESSION['stHash']) == 32) {
			$stSessionData = $this->loadSession($_SESSION['stHash']);
			if ($stSessionData instanceof stSessionData) {
				//session exists
			} else {
				$_SESSION['stHash']='';
				return $this->newSession();
			}
		} else {
			$tmpSession = new stSessionData();
			$tmpSession->startupSession();
			$tmpSession->hash = $this->genFreshHash();
			$_SESSION['stHash'] = $tmpSession->hash;
			return $this->save($tmpSession);
		}
	}

	public function save(stSessionData $stSessionData)
	{
		global $stSQL;
		if ($stSessionData instanceof stSessionData) {
		
			if (is_object($stSessionData->object)) {
				$tmpObj = serialize($stSessionData->object);
			} else {
				$tmpObj = '';
			}		
			
			//save method handler
			if ($this->checkSessionExist($stSessionData->hash) === true) {
				//session exists
				$editResult = $stSQL->edit("UPDATE site_sessions SETsession_object='" . $tmpObj . "', session_level='" . $stSessionData->level . "', session_active=NOW() WHERE session_hash='" . $stSessionData->hash . "' ORDER BY uid DESC LIMIT 1");
				if ($editResult !== false) {
					return $this->loadSession($stSessionData->hash);
				} else {
					throw new stFatalError('Failed to Save Session Data');
					return false;
				}
			} else {
				//session does not exist
				$addResult = $stSQL->insert("INSERT INTO site_sessions SET session_hash='" . $stSessionData->hash . "', session_object='" . $tmpObj . "', session_level='" . $stSessionData->level . "', session_active=NOW()");
				if ($addResult > 0) {
					return $this->loadSession($stSessionData->hash);
				} else {
					throw new stFatalError('Failed to Save Session Data');
					return false;
				}
			}
		} else {
			throw new stFatalError('Invalid Session Data Passed to Method');
			return false;
		}
	}
	
	private function pruneSessions()
	{
		global $stSQL;
		$stSQL->delete("DELETE FROM site_sessions WHERE session_active < DATE_SUB(NOW(), INTERVAL 3 DAY");
	}
	
	protected function markActive($hash)
	{
		global $stSQL;
		if (strlen($hash) == 32) {
			$editResult = $stSQL->edit("UPDATE site_sessions SET session_active=NOW() WHERE session_hash='" . $hash . "' ORDER BY uid DESC LIMIT 1");
			if ($editResult !== false) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	protected function genFreshHash() 
	{
		$tmpString = stConfig::$salt . date("md-/D-Yhss-m");
		$tmpHash = md5($tmpString);
		while($this->checkSessionExist($tmpHash) === true) {
			$tmpString = stConfig::$salt . date("sdmMd/D-Yhss-m") . stConfig::$salt . date("md-/D-Yhss-m") . $tmpHash;
			$tmpHash = md5($tmpString);
		} //end while
		return $tmpHash;
	}
	
	protected function checkSessionExist($hash) 
	{
		global $stSQL;
		if (strlen($hash) == 32) {
			$result = $stSQL->get("SELECT uid FROM site_sessions WHERE session_hash='" . $hash . "' ORDER BY uid DESC LIMIT 1", 'object');
			if (is_array($result->rows)) {
				return true;
			} else {
				return false; //session hash is unique
			}
		} else {
			return true; //invalid hash so return it as invalid/dupe
		}
	}
	
	protected function validateSession(stSessionData $stSessionData)
	{
		global $stSQL;
		if ($stSessionData instanceof stSessionData) {
			if (strlen($stSessionData->hash) == 32) {
				$result = $stSQL->get("SELECT uid FROM site_sessions WHERE session_hash='" . $stSessionData->hash . "' ORDER BY uid DESC LIMIT 1");
				if (is_array($result->rows[0])) {
					return $this->loadSession($stSessionData->hash);
				} else {
					return false;
				}
			} else {
				throw new stFatalError('Invalid Session Hash Passed to Method');
				return false;
			}
		} else {
			throw new stFatalError('Invalid Session Object Passed to Method');
			return false;
		}
	}
	
}

/**
 * @access public
 * @var object visitor session controller
 * @category objects
 */

class stVisitorSession extends stSession
{
	
	public function __construct()
	{
		parent::__construct('child');
	}
	
}

/**
 * @access public
 * @var object member session controller
 * @category objects
 */


class stMemberSession extends stSession
{

	public function __construct()
	{
		parent::__construct('child');
	}
	
	public function authUser($username, $password)
	{
		global $stSQL;
		return false;
	}
	
}

/**
 * @access public
 * @var object admin session controller
 * @category objects
 */


class stAdminSession extends stSession
{

	public function __construct()
	{
		parent::__construct('child');
	}
	
	public function authUser($username, $password)
	{
		global $stSQL, $dBug;
		return false;
	}

}
?>