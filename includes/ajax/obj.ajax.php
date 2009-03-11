<?php
   require_once('../core.php'); 
/**
 * @package starfish
 * @author Ryan Rentfro, http://www.rentfro.net 
 * @version obj.ajax.php, v0.0.1a
 * @copyright Ryan Rentfro, http://www.rentfro.net
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @category ajax
 */

/**
 * @access public
 * @var object ajax dispatcher
 * @category objects
 */

class stAjax 
{
	
	private $post;
	private $get;
	private $files;
	private $request;
	private $callback;
	
	public function __construct()
	{
		return true;
	}
    
    public function parseRequest()
    {
        $stGlobal = stGlobal::getInstance();
        if (is_array($stGlobal->active))
        {
            $request = $stGlobal->active;
            unset($stGlobal);
            if (isset($request['object']))
            {
                if (isset($request['method']))
                {
                    $objectCall = array($request['object'], $request['method']);  
                    try { 
                        $result = call_user_func($objectCall);
                        if (!empty($result))
                        {
                            
                        } 
                    } catch(Exception $e) {
                        throw new stFatalError('Invalid Event Call for ' . $objectCall[0] . '->' . $objectCall[1]);   
                    } 
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
	
	private function returnData($jsonData)
	{
		
	}

}