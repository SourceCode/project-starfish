<?php

/**
 * @package starfish
 * @author Ryan Rentfro, http://www.rentfro.net 
 * @version obj.library.php, v0.0.1a
 * @copyright Ryan Rentfro, http://www.rentfro.net
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @category core
 */
 
/**
 * @access public
 * @var object library files dependency controller
 * @category objects
 */

abstract class stLibrary extends stHtml
{
	protected $includeList;
	protected $includeBuffer;
	
	abstract public function getBaseDependencies();
	abstract public function addPackage($package);
	abstract public function packageList();
	abstract public function genIncludes();
	
	protected function headerIncludes() 
	{
		$this->includeBuffer = '';
		if (is_array($this->includeList)) {
			foreach($this->includeList as $includeItem) {
				$this->includeBuffer .= $includeItem . "\n";
			}
			$this->includeList = '';
			return $this->includeBuffer;
		} else {
			//silent failure - no include list
		}
	}

	protected function jsInclude($includeFile) 
	{
		if (!empty($includeFile)) {
			$jsTag = $this->stTag('script', 'double');
			$jsAttr = array('src'=> $includeFile, 'type'=>'text/javascript');
			$this->includeList[] = $this->processTag($jsTag, $jsAttr);
		} else {
			return false;
		}
	}
	
	protected function cssInclude($includeFile) 
	{
		if (!empty($includeFile)) {
			$cssTag = $this->stTag('link');
			$cssAttr = array('href'=> $includeFile, 'type'=>'text/css', 'rel'=>'stylesheet');
			$this->includeList[] = $this->processTag($cssTag, $cssAttr);
		} else {
			return false;
		}
	}
	
}

class stYUI extends stLibrary {

	private $dependencyList;
	private $path;
	private $packages;
	
	public function __construct() 
	{
		$this->dependencyList = array();
		$this->path = new stWebPath();
		$this->path->yui = $this->path->lib . '/yui/build';
		$this->makePackageList();
		$this->getBaseDependencies();
	}
	
	public function makePackageList()
	{
		//global dependencies
		$this->packages['js']['required'][] = 'yahoo/yahoo-min.js';
		
		//basicEvents dependencies
		$this->packages['js']['basicEvents'][] = 'yahoo-dom-event/yahoo-dom-event.js';
		$this->packages['js']['basicEvents'][] = 'element/element-beta-min.js';
	
		//button dependencies
		$this->packages['css']['button'][] = 'button/assets/skins/sam/button.css';
		$this->packages['css']['button'][] = 'menu/assets/skins/sam/menu.css';
		$this->packages['js']['button'][] = 'yahoo-dom-event/yahoo-dom-event.js';
		$this->packages['js']['button'][] = 'element/element-beta-min.js';
		$this->packages['js']['button'][] = 'container/container_core-min.js';
		$this->packages['js']['button'][] = 'menu/menu-min.js';
		
		//calendar dependencies
		$this->packages['css']['calendar'][] = 'calendar/assets/skins/sam/calendar.css';
		$this->packages['js']['calendar'][] = 'yahoo-dom-event/yahoo-dom-event.js';
		
		//module dependencies
		$this->packages['js']['module'][] = 'yahoo-dom-event/yahoo-dom-event.js';
		
		//container dependencies
		$this->packages['css']['container'][] = 'container/assets/skins/sam/container.css';
		$this->packages['js']['container'][] = 'yahoo-dom-event/yahoo-dom-event.js';
		$this->packages['js']['container'][] = 'animation/animation-min.js';
		$this->packages['js']['container'][] = 'utilities/utilities.js';
		
		//datatable dependencies
		$this->packages['css']['datatable'][] = 'accent-theme/datatable.css';
		$this->packages['js']['datatable'][] = 'yahoo-dom-event/yahoo-dom-event.js';
		$this->packages['js']['datatable'][] = 'element/element-beta-min.js';
		$this->packages['js']['datatable'][] = 'datasource/datasource-beta-min.js';
		$this->packages['js']['datatable'][] = 'connection/connection-min.js';
		$this->packages['js']['datatable'][] = 'dragdrop/dragdrop-min.js';
		$this->packages['js']['datatable'][] = 'calendar/calendar-min.js';
		
		//tabview dependencies
		$this->packages['css']['tabview'][] = 'fonts/fonts-min.css';
		$this->packages['js']['tabview'][] = 'accent-theme/border_tabs.css';
		$this->packages['css']['tabview'][] = 'accent-theme/tabview.css';
		$this->packages['js']['tabview'][] = 'yahoo-dom-event/yahoo-dom-event.js';		
		$this->packages['js']['tabview'][] = 'connection/connection-min.js';
		
		//menu dependencies
		$this->packages['css']['menu'][] = 'menu/assets/skins/sam/menu.css';
		$this->packages['js']['menu'][] = 'yahoo-dom-event/yahoo-dom-event.js';
		$this->packages['js']['menu'][] = 'container/container_core-min.js';
		$this->packages['js']['menu'][] = 'menu/menu-min.js';
		
		//grid dependencies
		$this->packages['css']['grid'][] = 'grids/grids-min.css';
		
		//logger dependencies
		$this->packages['css']['logger'][] = 'assets/skins/sam/logger.css';
		$this->packages['js']['logger'][] = 'yahoo-dom-event/yahoo-dom-event.js';
		$this->packages['js']['logger'][] = 'dragdrop/dragdrop-min.js';
		
		//animation dependencies
		$this->packages['css']['animation'][] = 'assets/skins/sam/logger.css';
		
		//XHR dependencies
		$this->packages['js']['XHR'][] = 'event/event-min.js';
		
		//element dependencies
		$this->packages['js']['element'][] = 'yahoo-dom-event/yahoo-dom-event.js';
		
		//imageloader dependencies
		$this->packages['js']['imageloader'][] = 'yahoo-dom-event/yahoo-dom-event.js';
		
		//treeview dependenceis
		$this->packages['css']['treeview'][] = 'treeview/assets/skins/sam/treeview.css';
		
		//control includes (put these last so they appear at bottom of list)
		$this->packages['js']['button'][] = 'button/button-beta-min.js';
		$this->packages['js']['calendar'][] = 'calendar/calendar-min.js';
		$this->packages['js']['module'][] = 'container/container-min.js';
		$this->packages['js']['container'][] = 'container/container-min.js';
		$this->packages['js']['datatable'][] = 'datatable/datatable-beta.js';		
		$this->packages['js']['tabview'][] = 'tabview/tabview-min.js';
		$this->packages['js']['logger'][] = 'logger/logger-min.js';
		$this->packages['js']['animation'][] = 'animation/animation-min.js';
		$this->packages['js']['XHR'][] = 'connection/connection-min.js';
		$this->packages['js']['element'][] = 'element/element-beta-min.js';
		$this->packages['js']['imageloader'][] = 'imageloader/imageloader-experimental-min.js';
		$this->packages['js']['treeview'][] = 'treeview/treeview-min.js';
	}
	
	public function packageList()
	{
		if (is_array($this->packages['js'])) {
			foreach($this->packages['js'] as $packName => $packFiles) {
				$rawList[] = $packName;
			}
		} 
		
		if (is_array($this->packages['css'])) {
			foreach($this->packages['css'] as $packName => $packFiles) {
				$rawList[] = $packName;
			}
		} 
		
		if (is_array($rawList)) $rawList = array_unique($rawList);
		return $rawList;
	}
	
	public function getBaseDependencies()
	{
		$this->addPackage('required');
	}
	
	public function addPackage($package)
	{
		if (!empty($package)) {
			if (is_array($this->packages['js'][$package])) {
				foreach($this->packages['js'][$package] as $includeFile) {
					$this->jsInclude($this->path->yui . '/' . $includeFile);
				}
			}
			
			if (is_array($this->packages['css'][$package])) {
				foreach($this->packages['css'][$package] as $includeFile) {
					$this->cssInclude($this->path->yui . '/' . $includeFile);
				}
			}
			return true;
		} else {
			return false;
		}
	}
	
	public function genIncludes()
	{
		return $this->headerIncludes();
	}

}