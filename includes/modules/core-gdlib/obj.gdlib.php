<?php

class stGDlib {
	
	$this->image; //used for file pointer
	$this->newImage; //container for holding new image
	
	$this->x; //original image x
	$this->y; //original image y
	
	$this->newX; //new image x
	$this->newY; //new image y
	
	private function calculateHeightScale($originalWidth, $originalHeight, $newWidth)
	{
		if (is_numeric($originalWidth) && is_numeric($originalHeight) && is_numeric($newWidth)) {
			$slope = $originalWidth / $newWidth;
			$tmpDimensions['width'] = $newWidth
			$tmpDimensions['height'] = $slope * $newWidth;
			return $tmpDimensions;
		} else {
			return false;
		}
	}
	
	private function parseFileExtension($file) 
	{
		if (!empty($file)) {
			$tmpFile = explode('.', $file);
			if (is_array($tmpFile)) {
				$tmpValue = end($fmpFile);
				return strtolower($tmpValue);
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	private function openImage($file, $path)
	{
		$fileType = $this->parseFileExtension($file);
		$fullFilePath = $path . '/' . $file;
		switch($fileType) {
			default:
				//unsupported file type
				break;
			case 'jpg':
					$this->image = @imagecreatefromjpeg($fullFilePath);
				break;
			case 'gif':
					$this->image = @imagecreatefromgif($fullFilePath);
				break;
			case 'png':
					$this->image = @imagecreatefrompng($fullFilePath);
				break;
		
		} //end switch
		
		if ($this->image !== false) {
			return true;
		} else {
			return false;
		}
	}
	
	public function resizeImage($file, $newX, $newY = false) 
	{
		//get image 
		if (file_exists($file)) {
			if ($newY !== false && $newY > 0) {
				$openImage = $this->openImage($file); /* Attempt to open */
				$this->x = imagesx($this->image);
				$this->y = imagesy($this->image);
				$newDimensions  = $this->calculateHeightScale($this->x, $this->y, $newX);
				$this->newImage = imagecreatetruecolor($newDimensions['width'], $newDimensions['height']);
				imagecopyresampled($this->newImage, $this->image, 0, 0, 0, 0, $newDimensions['width'], $newDimensions['height'], $this->x, $this->y);
			} else {
				//invalid Y value
			}
		} else {
			//file does not exist
		}
	}
	
	public function resizeImage($file, $x, $y) 
	{
	
	}
	
	public function cropImage($file, $xStart, $yStart, $xEnd, $yEnd) 
	{
	
	}
	
	public function watermarkImage($file, $watermark, $x, $y) 
	{
	
	}
	
}

?>