<?php

/**
 * Stat
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    tf2logs
 * @subpackage model
 * @author     Brian Barnekow
 */
class Stat extends BaseStat {  
  /**
  * Sets the attributes found in the PlayerInfo object into this object.
  */
  function setPlayerInfoAttributes(PlayerInfo $playerInfo) {
    $this->setSteamid($playerInfo->getSteamid());
    $this->setName($playerInfo->getName());
    $this->setTeam($playerInfo->getTeam());
  }
  
  /**
  * Convenience method to determine if this stat record is equal to
  * the given playerInfo.
  */
  public function equalsPlayerInfo(PlayerInfo $playerInfo) {
    return $this->getSteamid() == $playerInfo->getSteamid();
  }
  
  /**
  * Gets the columns that can be incremented,
  * by filtering out certain values.
  */
  protected function getStatColumns() {
    return array_diff($this->getTable()->getColumnNames(), array('id', 'log_id', 'name', 'steamid', 'team'));
  }
  
  /**
  * Checks to see if the given statkey can be incremented.
  */
  protected function isKeyAbleToBeIncremented($statkey) {
    foreach($this->getStatColumns() as $col) {
      if($statkey == $col) return true;
    }
    return false;
  }
  
  /**
  * Increments the stat, if the key exists. Otherwise, it throws an exception.
  */
  public function incrementStat($statkey, $increment = 1) {
    if(!$this->isKeyAbleToBeIncremented($statkey)) {
      throw new InvalidArgumentException("Invalid key '$statkey' given to incrementStat method.");
    }
    
    $this->_set($statkey, $this->_get($statkey)+$increment);
  }
}
