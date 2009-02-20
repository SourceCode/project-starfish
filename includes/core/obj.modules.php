<?php

/**
 * @package starfish
 * @author Ryan Rentfro, http://www.rentfro.net 
 * @version obj.modules.php, v0.0.1a
 * @copyright Ryan Rentfro, http://www.rentfro.net
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @category core
 */

/**
 * @access public
 * @var object standard module interface
 * @category objects
 */


interface stStandardModule
{
	public function initialize();
}

/**
 * @access public
 * @var object runtime module interface
 * @category objects
 */

interface stRuntimeModule extends stStandardModule
{

}

/**
 * @access public
 * @var object extension module interface
 * @category objects
 */


interface stExtensionModule extends stStandardModule
{
	
}

/**
 * @access public
 * @var object ACID module interface
 * @category objects
 */

interface stACIDModule extends stStandardModule
{
	public function render();
	public function load();
	public function insert();
	public function update();
	public function delete();
}