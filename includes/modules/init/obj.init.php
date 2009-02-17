<?php

class init implements stStandardModule
{
	
	private $storage;
	
	public function initialize()
	{
		$this->storage = stController::getInstance();
		echo 'hello world';	
	}
}

?>