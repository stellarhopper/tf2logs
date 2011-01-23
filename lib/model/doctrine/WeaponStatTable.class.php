<?php

/**
 * WeaponStatTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class WeaponStatTable extends Doctrine_Table {
    /**
     * Returns an instance of this class.
     *
     * @return object WeaponStatTable
     */
    public static function getInstance() {
        return Doctrine_Core::getTable('WeaponStat');
    }
    
    /**
    * Gets the data that was recorded for the log for use in the weapon kills,deaths
    */
    public function getWeaponStatsForLogId($logid) {
      return Doctrine_Query::create()
        ->select('ws.stat_id, ws.weapon_id, sum(ws.kills) as num_kills, sum(ws.damage) as num_damage, sum(ws.deaths) as num_deaths')
        ->from('WeaponStat ws')
        ->innerJoin('ws.Stat s')
        ->innerJoin('s.Log l')
        ->innerJoin('ws.Weapon w')
        ->where('l.id = ?', $logid)
        ->groupBy('s.name, w.name')
        ->orderBy('s.name, w.name')
        ->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY)
        ->execute();
    }
    
    /**
    * Gets all data for use in the weapon kills,deaths
    */
    public function getPlayerWeaponStatsByNumericSteamid($numericSteamId) {
      return Doctrine_Query::create()
        ->select('ws.weapon_id, w.name, w.key_name, sum(ws.kills) as num_kills, sum(ws.damage) as num_damage, sum(ws.deaths) as num_deaths')
        ->from('WeaponStat ws')
        ->innerJoin('ws.Stat s')
        ->innerJoin('s.Player p')
        ->innerJoin('ws.Weapon w')
        ->where('p.numeric_steamid = ?', $numericSteamId)
        ->groupBy('ws.weapon_id, w.name, w.key_name')
        ->orderBy('w.name')
        ->execute();
    }
}
