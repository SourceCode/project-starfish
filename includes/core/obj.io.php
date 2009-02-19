<?php

/**
 * @package starfish
 * @author Ryan Rentfro, http://www.rentfro.net 
 * @version obj.io.php, v0.0.1a
 * @copyright Ryan Rentfro, http://www.rentfro.net
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @category core
 */

/**
 * @access public
 * @var object io controls
 * @category objects
 */

class stIO {
    
    private static $instance; 
    
     public function initialize()
    {

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
	
	public function sanitizeFilename($filename)
	{
		return preg_replace('/[^0-9a-z\.\_\-]/i','',$filename);
	}
	
	public function newFile($file, $path)
	{
		if (!empty($file) && !empty($path)) {
			if (is_dir($path)) {
				$fh = fopen($file, 'w') or die("can't open file");
				fwrite($fh, '');
				fclose($fh);
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	public function copyFile($originalFile, $newFile, $destinationPath)
	{
		if (file_exists($originalFile)) {
			if (is_dir($destinationPath)) {
				copy($originalFile, $destinationPath . '/' . $newFile) or die("File Copy Failure");
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	public function moveFile($originalFile, $newFile, $destinationPath)
	{
		if (file_exists($originalFile)) {
			if (is_dir($destinationPath)) {
				copy($originalFile, $destinationPath . '/' . $newFile) or die("File Copy Failure");
				unlink($originalFile);
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	public function deleteFile($file)
	{
		if (file_exists($file)) {
			unlink($file);
			return true;
		} else {
			return false;
		}
	}
	
	public function loadFile($file)
	{
		if (file_exists($file)) {
			$fh = fopen($file, 'r');
			$fileData = fgets($fh);
			fclose($fh);
			return $fileData;
		} else {
			return false;
		}
	}
	
	public function editFile($file, $data='')
	{
		if (file_exists($file)) {
			$fh = fopen($file, 'w') or die("can't open file");
			fwrite($fh, $data);
			fclose($fh);
			return true;
		} else {
			return false;
		}
	}
	
	public function appendFile($file, $data)
	{
		if (file_exists($file)) {
			$fh = fopen($file, 'a') or die("can't open file");
			fwrite($fh, $data);
			fclose($fh);
			return true;
		} else {
			return false;
		}
	}
	
	public function fileInfo($file)
	{
		if (file_exists($file)) {
			$pathParts = pathinfo($file);
			$fileInfo['fullpath'] = $file;
			$fileInfo['size'] = filesize($file);
			$fileInfo['date'] = date ("Y-m-d", filemtime($file));
			$fileInfo['path'] = $pathParts['dirname'];
			$fileInfo['name'] = $pathParts['basename'];
			$fileInfo['extension'] = $pathParts['extension'];
			return $fileInfo;
		} else {
			return false;
		}
	}
	
	public function listDir($path, $includeDirectories = false)
	{
		if (is_dir($path)) {
			if ($dh = opendir($path)) {
				while (($file = readdir($path)) !== false) {
					if (strtolower(filetype($path . '/' . $file)) == 'dir') {
						if ($includeDirectories == true) $fileList[] = $file;
					} else {
						$fileList[] = $file;
					}
				}
				closedir($dh);
				return $fileList;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	public function listDirFiles($path)
	{
		return $this->listDir($path, false);
	}
	
	public function listSubDir($path)
	{
		if (is_dir($path)) {
			if ($dh = opendir($path)) {
				while (($file = readdir($path)) !== false) {
					if (strtolower(filetype($path . '/' . $file)) == 'dir') {
						$fileList[] = $file;
					}
				}
				closedir($dh);
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	public function makeDir($path, $newDir, $permissions=0755)
	{
		if (!empty($path) && !empty($newDir)) {
			if (is_dir($path)) {
				if (!is_dir($path . '/' . $newDir)) {
					mkdir($path . '/' . $dir, 0755);
					return true;
				} else {
					return true;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	public function getRemoteFile($remoteFile, $newFile)
	{
		$file = fopen ($remoteFile, "rb") or die('Cannot Open File');
		if (!$file) {
			return false;
		}else {
			$filename = basename($remoteFile);
			$fileInfo = pathinfo($newFile);
			if (is_dir($fileInfo['dirname'])) {
				$fc = fopen($newFile, "wb");
				while (!feof ($file)) {
				   $line = fread ($file, 1028);
				   fwrite($fc,$line);
				}
				fclose($fc);
				return true;
			} else {
				return false;
			}
		} 
	}
	
}

/**
 * @access public
 * @var object log controls
 * @category objects
 */

class stLogFile
{
       
     private static $instance; 
    
     public function initialize()
    {

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
    
    public function systemLog($message)
    {
      if (!empty($message))
      {
          
      } else {
          return false;
      }  
    }


}

?>