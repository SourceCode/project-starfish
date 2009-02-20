<?php

/**
 * @package starfish
 * @author Ryan Rentfro, http://www.rentfro.net 
 * @version obj.fieldpresets.php, v0.0.1a
 * @copyright Ryan Rentfro, http://www.rentfro.net
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @category core
 */


/**
 * @access public
 * @var object field presets
 * @category objects
 */

class stFieldPresets
{
	public $states;
	public $statesVerbose;
	
	public $months;
	public $monthsVerbose;
	
	public $sex;
	public $sexVerbose;
	
	public $honorifics;
	
	public $years;
	
	public $days;

	public $dayNames;
	
	public function __construct() 
	{
		$this->sex['f'] = 'F';
		$this->sex['m'] = 'M';
		$this->sexVerbose['f'] = 'Female';
		$this->sexVerbose['m'] = 'Male';		
		$this->honorifics = array('mr'=>'Mr.', 'mrs'=>'Mrs.', 'miss'=>'Miss', 'ms'=>'Ms.');
		$this->dayNames = array('monday'=>'Monday', 'tuesday'=>'Teusday', 'wednesday'=>'Wednesday', 'thursday'=>'Thursday', 'friday'=>'Friday', 'saturday'=>'Saturday', 'sunday'=>'Sunday');
		$startYear = date("Y") - 2;
		$endYear = $startYear + 10;
		$this->genYears($startYear, $endYear);
		$this->genMonths();
		$this->genDays();
		$this->genStates();
	}
	
	public function genYears($start, $end) 
	{
		if ((is_numeric($start) && is_numeric($end)) && $start < $end) {
			while($start <= $end) {
				$this->years[$start] = $start;
				$start++;
			}
			return true;
		} else {
			return false;
		}
	}
	
	public function genDays() 
	{
		$start = 1;
		while($start <= 31) {
			$this->days[$start] = $start;
			$start++;
		}
	}
	
	public function genMonths() 
	{
		$startMonth = 1;
		while($startMonth <= 12) {
			if ($startMonth < 10) {
				$this->month[$startMonth] = '0' . $startMonth;
			} else {
				$this->month[$startMonth] = $startMonth;
			}
			$this->monthVerbose[$startMonth] = date("F", mktime(0, 0, 0, $startMonth, 0,0));
			$startMonth++;
		}
	}
	
	public function genStates() 
	{
		$this->states['AL'] = 'AL';
		$this->statesVerbose['AL'] = 'Alabama';
		
		$this->states['AK'] = 'AK';
		$this->statesVerbose['AK'] = 'Alaska';
		
		$this->states['AZ'] = 'AZ';
		$this->statesVerbose['AZ'] = 'Arizona';
		
		$this->states['AR'] = 'AR';
		$this->statesVerbose['AR'] = 'Arkansas';
		
		$this->states['CA'] = 'CA';
		$this->statesVerbose['CA'] = 'California';

		$this->states['CO'] = 'CO';
		$this->statesVerbose['CO'] = 'Colorado';

		$this->states['CT'] = 'CT';
		$this->statesVerbose['CT'] = 'Connecticut';

		$this->states['DE'] = 'DE';
		$this->statesVerbose['DE'] = 'Delaware';

		$this->states['FL'] = 'FL';
		$this->statesVerbose['FL'] = 'Florida';
	
		$this->states['GA'] = 'GA';
		$this->statesVerbose['GA'] = 'Georgia';
	
		$this->states['HI'] = 'HI';
		$this->statesVerbose['HI'] = 'Hawaii';
	
		$this->states['ID'] = 'ID';
		$this->statesVerbose['ID'] = 'Idaho';
		
		$this->states['IL'] = 'IL';
		$this->statesVerbose['IL'] = 'Illinois';
		
		$this->states['IN'] = 'IN';
		$this->statesVerbose['IN'] = 'Indiana';
		
		$this->states['IA'] = 'IA';
		$this->statesVerbose['IA'] = 'Iowa';
		
		$this->states['KS'] = 'KS';
		$this->statesVerbose['KS'] = 'Kansas';
		
		$this->states['KY'] = 'KY';
		$this->statesVerbose['KY'] = 'Kentucky';
		
		$this->states['LA'] = 'LA';
		$this->statesVerbose['LA'] = 'Louisiana';
		
		$this->states['ME'] = 'ME';
		$this->statesVerbose['ME'] = 'Maine';
		
		$this->states['MD'] = 'MD';
		$this->statesVerbose['MD'] = 'Maryland';
		
		$this->states['MA'] = 'MA';
		$this->statesVerbose['MA'] = 'Massachusetts';
		
		$this->states['MI'] = 'MI';
		$this->statesVerbose['MI'] = 'Michigan';
		
		$this->states['MN'] = 'MN';
		$this->statesVerbose['MN'] = 'Minnesota';
		
		$this->states['MS'] = 'MS';
		$this->statesVerbose['MS'] = 'Mississippi';
		
		$this->states['MO'] = 'MO';
		$this->statesVerbose['MO'] = 'Missouri';
		
		$this->states['MT'] = 'MT';
		$this->statesVerbose['MT'] = 'Montana';
		
		$this->states['NE'] = 'NE';
		$this->statesVerbose['NE'] = 'Nebraska';
		
		$this->states['NV'] = 'NV';
		$this->statesVerbose['NV'] = 'Nevada';
		
		$this->states['NH'] = 'NH';
		$this->statesVerbose['NH'] = 'New Hampshire';
		
		$this->states['NJ'] = 'NJ';
		$this->statesVerbose['NJ'] = 'New Jersey';
		
		$this->states['NM'] = 'NM';
		$this->statesVerbose['NM'] = 'New Mexico';
		
		$this->states['NY'] = 'NY';
		$this->statesVerbose['NY'] = 'New York';
		
		$this->states['NC'] = 'NC';
		$this->statesVerbose['NC'] = 'North Carolina';
		
		$this->states['ND'] = 'ND';
		$this->statesVerbose['ND'] = 'North Dakota';
		
		$this->states['OH'] = 'OH';
		$this->statesVerbose['OH'] = 'Ohio';
		
		$this->states['OK'] = 'OK';
		$this->statesVerbose['OK'] = 'Oklahoma';
		
		$this->states['OR'] = 'OR';
		$this->statesVerbose['OR'] = 'Oregon';
		
		$this->states['PA'] = 'PA';
		$this->statesVerbose['PA'] = 'Pennsylvania';
		
		$this->states['RI'] = 'RI';
		$this->statesVerbose['RI'] = 'Rhode Island';
		
		$this->states['SC'] = 'SC';
		$this->statesVerbose['SC'] = 'South Carolina';
		
		$this->states['SD'] = 'SD';
		$this->statesVerbose['SD'] = 'South Dakota';
		
		$this->states['TN'] = 'TN';
		$this->statesVerbose['TN'] = 'Tennessee';
		
		$this->states['TX'] = 'TX';
		$this->statesVerbose['TX'] = 'Texas';
		
		$this->states['UT'] = 'UT';
		$this->statesVerbose['UT'] = 'Utah';
		
		$this->states['VT'] = 'VT';
		$this->statesVerbose['VT'] = 'Vermont';
		
		$this->states['VA'] = 'VA';
		$this->statesVerbose['VA'] = 'Virginia';
		
		$this->states['WA'] = 'WA';
		$this->statesVerbose['WA'] = 'Washington';
		
		$this->states['WV'] = 'WV';
		$this->statesVerbose['WV'] = 'West Virginia';
		
		$this->states['WI'] = 'WI';
		$this->statesVerbose['WI'] = 'Wisconsin';
		
		$this->states['WY'] = 'WY';
		$this->statesVerbose['WY'] = 'Wyoming';
		
	}

}