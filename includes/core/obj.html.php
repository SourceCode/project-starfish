<?php

/**
 * @package starfish
 * @author Ryan Rentfro, http://www.rentfro.net 
 * @version obj.html.php, v0.0.1a
 * @copyright Ryan Rentfro, http://www.rentfro.net
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @category core
 */
 
/**
 * @access public
 * @var object html generation tools
 * @category objects
 */


class stHtml extends stCore 
{
    
    private static $instance;
    
    public function getInstance()
    {
        if (!isset(self::$instance))
        {
            $class = __CLASS__;
            self::$instance = new $class();
        }
        return self::$instance;
    }       
    
	final public function stAttr($attrArray) 
	{
        $tmpAttr = '';
		if (is_array($attrArray)) {
			foreach($attrArray as $key => $value) {
				if (strtolower($key) == 'selected') {
					$tmpAttr .= $value . ' ';
				} else {
					$tmpAttr .= $key . '="' . $value . '" ';
				}
			}
			return $tmpAttr;
		} else {
			return false;
		}
	}
	
	final public function stTag($tag, $type='') 
	{
		if (!empty($tag)) {
			switch($type) {
				default:
						return '<' . $tag . ' {tagData}/>';
					break;
				case 'double':
						return '<' . $tag . ' {tagData}>{content}</' . $tag . '>';
					break;
			}
		} else {
			return false;
		}
	}
	
	final public function stElement($tag, $attr, $tagType='', $content='') 
	{
		if (!empty($tag)) {
			$newTag = $this->stTag($tag, $tagType);
			return $this->processTag($newTag, $attr, $content);
		} else {
			return false;
		}
	}

	public function processTag($tag, $attr, $content='') 
	{
		if (!empty($tag)) {
			if (is_array($attr)) {
				$tagData = $this->stAttr($attr);
			} else {
				$tagData = '';
			} 
			$tag = str_replace('{tagData}', $tagData, $tag);
            $tag = str_replace('{content}', $content, $tag); 
			return $tag;
		} else {
			return false;
		}
	}

}