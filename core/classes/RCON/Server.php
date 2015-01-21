<?php

/**
 * Battlefield Play4Free RCON Server Sub-Class
 * Provides Server based Methods
 * 
 * This Package is based on 'bf2php' from 'jamie.rfurness@gmail.com' (http://code.google.com/p/bf2php/)
 * 
 * Requires PHP 5.3 or greater
 * 
 * @package   T4G\BFP4F
 * @author    Ronny 'roennel' Gysin <roennel@alchemical.cc>
 * @copyright (c) 2012 Ronny Gysin / 2009 Jamie Furness
 * @license   GPL v3 (http://www.gnu.org/licenses/gpl-3.0.html)
 * @version   0.3.4
 */

namespace T4G\BFP4F\Rcon;

class Server
{
    /**
     * Fetches Server Info
     * @return object
     */
    public function fetch()
    {
        $data = Base::query('bf2cc si');
        
        $spl = explode("\t", $data);
        
        $result = array
        (
            'name' => $spl[7],
            'map' => $spl[5],
            'ranked' => $spl[25], // ADDED BY SHARPBUNNY
            'playersCurrent' => $spl[3],
            'playersMax' => $spl[2],
            'playersJoining' => $spl[4],
            'playersTotal' => $spl[3] + $spl[4], // ADDED BY SHARPBUNNY
            'tickets' => array($spl[10] - $spl[11], $spl[10] - $spl[16]),
            'ticketsMax' => $spl[10],
            'timeElapsed' => $spl[18],
            'timeRemaining' => $spl[19],
            'gameMode' => $spl[20], // ADDED BY SHARPBUNNY
            'roundsCount' => $spl[31], // ADDED BY SHARPBUNNY
            'rounds' => $spl[30] // ADDED BY SHARPBUNNY
        );
        
        return (object) $result;
    }
	
	/**
	 * Fetches VIP people
	 * @return object
	 * 
	 * ADDED BY SHARPBUNNY
	 */
	public function fetchVips() {
		$data = Base::query('exec game.getVipList');
		
		$spl = explode("\r", $data);
		
		$result = array();
		
		foreach($spl as $vip) {
			
			$spl2 = explode("\t", $vip);
			
			$result[] = array(
				'playerName' => $spl2[0],
				'profileId' => $spl2[1]
			);
		}
		
		return $result;
	}
	
	/**
	 * Set VIP status
	 * 
	 * @param $name Playername
	 * @param $profileId Profile ID
	 * @param $vip 0=deactivate VIP status, 1=activate VIP status
	 * 
	 * @return
	 * 
	 * ADDED BY SHARPBUNNY
	 */
	public function setVip($name, $profileId, $vip=1) {
		return Base::query("exec game.setPersonaVipStatus {$name} {$profileId} {$vip}");
	}
	
	/**
	 * Fetches IGA admins
	 * @return object
	 * 
	 * ADDED BY SHARPBUNNY
	 */
	public function fetchIgaAdmins() {
		$data = Base::query('iga listAdmins');
		
		$spl = explode("\n", $data);
		$spl = array_slice($spl, 0, -1);
		
		$result = array();
		
		foreach($spl as $admin) {
			
			$spl2 = explode(' ', $admin);
			
			$result[] = array(
				'soldierId' => str_replace("'", '', $spl2[1]),
				'privileges' => $spl2[3]
			);
			
		}
		
		return $result;
	}
	
	/**
	 * Adds an IGA admin
	 * 
	 * @param $soldierId SoldierID
	 * @param $cmds Commands the admin can use (default=all)
	 * 
	 * @return void
	 */
	public function addIgaAdmin($soldierId, $cmds='all') {
		return Base::query("iga addAdmin {$soldierId} {$cmds}");
	}
	
	/**
	 * Deletes an IGA admin
	 * 
	 * @param $soldierId SoldierID
	 * 
	 * @return void
	 */
	public function deleteIgaAdmin($soldierId) {
		return Base::query("iga delAdmin {$soldierId}");
	}
	
    /**
     * Changes next (append?) map to declared. 
     * rcon::runNextLevel is needed to skip current map.
     *
     * <ul>
     *  <li>Map List
     *   <ul>
     *    <li>strike_at_karkand</li>
     *    <li>gulf_of_oman</li>
     *    <li>dalian_plant</li>
     *    <li>downtown</li>
     *    <li>mashtuur_city</li>
     *    <li>trail</li>
     *    <li>dragon_valley</li>
     *    <li>karkand_rush</li>
     *    <li>sharqi</li>
     *   </ul>
     *  </li>
     *  <li>Game Types
     *   <ul>
     *    <li>gpm_sa</li>
     *    <li>gpm_rush</li>
     *    <li>There are also so unreleased/lefotovers in BFP4F mm/game files.
     *   </ul>
     *  </li>
     * </ul>
     *
     * @param string $map Map Name
     * @param string $gameType Game Type
     * @param int $size Size of map (according to max players number)
     * 
     * @return 
     */
    public function changeMap($map, $gameType, $size = 16)
    {
        return Base::query("map {$map} {$gameType} {$size}");
    }
    public function appendMap($map, $gameType, $size = 16)
    {
        return Base::query("exec maplist.append {$map} {$gameType} {$size}");
    }   
	public function clearRotation() // ADDED BY SHARPBUNNY
	{
		return Base::query("exec maplist.clear");
	}

    /**
     * Retrieves position of current map in map rotator
     * 0, 1, 2, 3, ...   
     *
     * @return int
     */
    public function currentMap()
    {
        return Base::query("exec admin.currentLevel");
    }

    /**
     * Switch to next level
     *
     * @return 
     */
    public function skipToNextMap()
    {
        return Base::query("exec admin.runNextLevel");
    }

    /**
     * Sets number of rounds variable (applies to all maps)
     * 
     * @param int $num_of_rounds 
     */
    public function setNumOfRounds($num_of_rounds)
    {
        return Base::query("exec admin.setNrOfRounds {$num_of_rounds}");
    }
    
    /**
     * Jump to <map_[id|name]>?
     *
     * @param string $map ID of map in map-rotator or name of map
     *
     * @return 
     */
    public function skipToMap($map)
    {
        return Base::query('exec admin.nextLevel ' . ($map));
    }

    /**
     * End current round, and restart with the same map.
     *
     * @return 
     */
    public function restartMap()
    {
        return Base::query('exec admin.restartMap');
    }

    /**
     * Returns Help all (modmanager) commands.
     *
     * Commands are listed in nested view using 
     * - "\r\n"
     * - "\t"
     * - spaces? I haven't noticed
     * 
     * @return 
     */
    public function getHelp()
    {
        return $data = Base::query('help');
        // return explode("\r\n", $data);
    }

    public function getMaplist($name)
    {
        $data = Base::query('maplist');
        return $data;
    }

    /*** Leftovers to remove ***/

    /**
     * Get the play lists for the server
     *
     * @param string $name (optional) Get the current play list for the server
     *
     * @return 
     */
    public function getPlaylist($name)
    {
        $data = Base::query('bf2cc pl');
        return $data;
    }
    /**
     * Leftover from BFBC2
     *
     * @param string $bannerUrl Server Banner URL
     *
     * @return 
     */
    public function setBannerUrl($bannerUrl = "")
    {
        $data = Base::query('exec sv.bannerUrl ' . ((string) $bannerUrl));
        // $data = Base::query('vars.bannerUrl ' . ((string) $bannerUrl));
        return $data;
    }
}
