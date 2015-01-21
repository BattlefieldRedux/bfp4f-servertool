<?php
/**
 * BattlefieldTools.com BFP4F ServerTool
 * Version 0.7.2
 *
 * Copyright (C) 2014 <Danny Li> a.k.a. SharpBunny
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>. 
 */
 
class GameMaps {
	
	public $maps = array(
	
		'lake' => 'Buccaneer bay',
		'seaside_skirmish' => 'Seaside Skirmish',
		'village' => 'Victory Village',
		'smack2' => 'Costal Clash',
		'heat' => 'Riverside Rush',
		'mayhem' => 'Sunset Showdown',
		'ruin' => 'Midnight Mayhem',
		'woodlands' => 'Alpine Assault',
		'wicked_wake' => 'Wicked Wake',
		'lunar' => 'Lunar Landing',
		'river' => 'Fortress Frenzy',
		'ruin_day' => 'Morning Mayhem',
		'dependant_day' => 'Inland Invasion',
		'dependant_day_night' => 'Inland Invasion Night',
		'woodlands_snow' => 'Alpine Assault Snow',
		'lake_snow' => 'Buccaneer Bay Snow',
		'lake_night' => 'Buccaneer Bay Night',
		'smack2_snow' => 'Costal Clash Snow',
		'royal_rumble_snow' => 'Perilous Port Snow',
		'royal_rumble_night' => 'Perilous Port Night',
		'heat_snow' => 'Riverside Rush Snow',
		'seaside_skirmish_night' => 'Seaside Skirmish Night',
		'village_snow' => 'Victory Village Snow',
		
	);
	
	public $gamemodes = array(
	
		'gpm_tdm' => 'Team Deathmatch',
		'gpm_hoth' => 'Hero Of The Hill',
		'gpm_ctf' => 'Capture The Flag',
		'gpm_cdm' => 'Team Elimination',
	
	);
	
	public $combos = array(
	
		'gpm_tdm' => array(
			'lake',
			'seaside_skirmish',
			'village',
			'smack2',
			'heat',
			'mayhem',
			'ruin',
			'woodlands',
			'wicked_wake',
			'lunar',
			'river',
			'ruin_day',
			'dependant_day',
			'dependant_day_night',
			'woodlands_snow',
			'lake_snow',
			'lake_night',
			'smack2_snow',
			'royal_rumble_snow',
			'royal_rumble_night',
			'heat_snow',
			'seaside_skirmish_night',
			'village_snow',
		),
		
		'gpm_hoth' => array(
			'woodlands',
			'smack2',
			'ruin',
			'ruin_snow',
			'seaside_skirmish',
			'mayhem',
		),
		
		'gpm_ctf' => array(
			'lake',
			'lunar',
			'royal_rumble_day',
			'heat',
			'village',
		),
		
		'gpm_cdm' => array(
			'ruin',
			'seaside_skirmish',
			'village',
		),
	
	);
	
	public $mapsAlt, $gamemodesAlt;
	
	public function __construct() {
		$this->mapsAlt = array_flip($this->maps);
		$this->gamemodesAlt = array_flip($this->gamemodes);
	}
	
	/**
	 * getMapName()
	 * Gets the mapname by key
	 * 
	 * @param $key str - Key e.g. strike_at_karkand
	 * @return str - Mapname
	 */
	public function getMapName($key) {
		if(isset($this->maps[strtolower($key)])) {
			return $this->maps[strtolower($key)];
		}
		
		return 'Unknown';
	}
	
	/**
	 * getGameMode()
	 * Gets the gamemode name by key
	 * 
	 * @param $key str - Key e.g. gpm_sa
	 * @return str - Gamemode name
	 */
	public function getGameMode($key) {
		if(isset($this->gamemodes[$key])) {
			return $this->gamemodes[$key];
		}
		
		return 'Unknown';
	}
	
	/**
	 * getMapNameKey()
	 * Gets the mapkey by map name
	 * 
	 * @param $name str - Mapname e.g. Buccaneer Bay
	 * @return str - Key
	 */
	public function getMapNameKey($name) {
		if(isset($this->mapsAlt[$name])) {
			return $this->mapsAlt[$name];
		}
		
		return 'lake';
	}
	
	/**
	 * getGameModeKey()
	 * Gets the gamemode key by gamemode name
	 * 
	 * @param $name str - Gamemode name e.g. Team Deathmatch
	 * @return str - Key
	 */
	public function getGameModeKey($name) {
		if(isset($this->gamemodesAlt[$name])) {
			return $this->gamemodesAlt[$name];
		}
		
		return 'gpm_tdm';
	}
	
}
 
?>