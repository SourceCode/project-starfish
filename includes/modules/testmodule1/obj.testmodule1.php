<?php

class testmodule1 implements stStandardModule
{
	
	private $storage;
	
	public function initialize()
	{
		$this->storage = stController::getInstance();
		echo 'Test Module 1';
		$this->dumpTestData();
	}
	
	
	private function dumpTestData()
	{
		global $dBug;
		$dBug->o($this);
		$tmpController = stController::getInstance();
		$dBug->o($tmpController);
	}
	
	private function moduleTest1()
	{
			
	}
	
}