<?php

/**
 * PlayerHealStatTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class PlayerHealStatTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object PlayerHealStatTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('PlayerHealStat');
    }
    
    public function getPlayerHealStatsForLogId($logid) {
      return Doctrine_Query::create()
        ->select('phs.stat_id, phs.player_id, phs.healing, p.avatar_url, s.name, s.team')
        ->from('PlayerHealStat phs')
        ->innerJoin('phs.Stat s')
        ->innerJoin('s.Log l')
        ->innerJoin('s.Player p')
        ->where('l.id = ?', $logid)
        ->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY)
        ->execute();
    }
    
    public function findArrayByStatId($statid) {
      return $this
        ->createQuery('phs')
        ->leftJoin('phs.Player p')
        ->where('phs.stat_id = ?', $statid)
        ->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY)
        ->execute();
    }
}
