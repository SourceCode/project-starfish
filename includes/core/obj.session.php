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
	public $hash;
	public $level;
	public $datetime;
	
	public $userUID;
	
	public function __construct() 
	{

	}
	
	public function parseSession()
	{
		
	}
	
	public function newSession($userUID=0, $level=0)
	{
        if (is_numeric($level) && is_numeric($userUID))
        {
            $this->level = $level;
            $this->userUID = $userUID;
            return true;    
        } else {
            return false;
        }
	}
	
	public function updateSession($key, $value)
	{
		
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
		parent::__construct();
	}
	
	public function authUser($username, $password)
	{
        
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
		parent::__construct();
	}
	
	public function authUser($username, $password)
	{
	    
	}

}