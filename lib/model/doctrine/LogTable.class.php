<?php

/**
 * LogTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class LogTable extends Doctrine_Table {
    /**
     * Returns an instance of this class.
     *
     * @return object LogTable
     */
    public static function getInstance() {
        return Doctrine_Core::getTable('Log');
    }
    
    public function getLogById($id) {
      $l = $this
        ->createQuery('l')
        ->where('l.id = ?', $id)
        ->leftJoin('l.Stats s')
        ->leftJoin('s.Player p')
        ->leftJoin('s.Weapons w')
        ->leftJoin('s.Roles r')
        ->andWhere('l.error_log_name is null')
        ->orderBy('s.team, s.name')
        ->execute();
     
      if(count($l) == 0) return null;
      return $l[0]; //returns doctrine_collection obj, we only want first (all we should get)
    }
    
    public function getErrorLogById($id) {
      $l = $this
        ->createQuery('l')
        ->where('l.id = ?', $id)
        ->andWhere('l.error_log_name is not null')
        ->execute();
     
      if(count($l) == 0) return null;
      return $l[0]; //returns doctrine_collection obj, we only want first (all we should get)
    }
    
    public function listErrorLogs() {
      return $this
        ->createQuery('l')
        ->where('l.error_log_name is not null')
        ->orderBy('l.created_at ASC')
        ->execute();
    }
    
    public function deleteLog($log_id) {
      $this->createQuery('l')
        ->delete('Log l')
        ->where('l.id = ?', $log_id)
        ->execute();
    }
    
    public function getMostRecentLogs($num_to_retrieve = 10) {
      return $this
        ->createQuery('l')
        ->orderBy('l.created_at DESC')
        ->limit($num_to_retrieve)
        ->execute();
    }
}
