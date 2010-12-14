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
    if(!isset($this->Player)) {
      $p = Doctrine::getTable('Player')->findOneBySteamid($playerInfo->getSteamid());
      if($p != null) $this->setPlayer($p);
      else $this->Player->setSteamid($playerInfo->getSteamid());
    }
    $this->setName($playerInfo->getName());
    $this->setTeam($playerInfo->getTeam());
  }
  
  /**
  * Convenience method to determine if this stat record is equal to
  * the given playerInfo.
  */
  public function equalsPlayerInfo(PlayerInfo $playerInfo) {
    return $this->getPlayer()->getSteamid() == $playerInfo->getSteamid();
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
  
  /**
  * Calculates the stat's kills per death ratio.
  */
  public function getKillsPerDeath() {
    return $this->doPerDeathDivision($this->getKills());
  }
  
  /**
  * Calculates the stat's ubers per death ratio.
  */
  public function getUbersPerDeath() {
    return $this->doPerDeathDivision($this->getUbers());
  }
  
  protected function doPerDeathDivision($numerator) {
    if($this->getDeaths() == 0) return $numerator;
    return round((float) $numerator/$this->getDeaths(), 3);
  }
  
  /**
  * This will add the given weapon to the player's stats.
  * If the weapon does not exist in the database, a new one is created.
  */
  public function incrementWeaponForPlayer($weapon, $propertyToIncrement, $increment = 1) {
    $w = Doctrine::getTable('Weapon')->findOneByKeyName($weapon);
    if(!$w) {
      $w = new Weapon();
      $w->setKeyName($weapon);
      $w->save();
    }
    
    $addws = true;
    foreach($this->WeaponStats as &$ws) {
      if($ws->getWeaponId() == $w->getId()) {
        $ws->_set($propertyToIncrement, $ws->_get($propertyToIncrement)+$increment);
        $addws = false;
        break;
      }
    }
    if($addws) {
      $wsadd = new WeaponStat();
      $wsadd->setWeapon($w);
      $wsadd->setStat($this);
      $wsadd->_set($propertyToIncrement, $increment);
      $this->WeaponStats[] = $wsadd;
    }
  }
  
  /**
  * This will add the given role to the player's stats.
  * If the role does not exist in the database, an exception is thrown.
  */
  public function addRoleToPlayer($role) {
    $r = Doctrine::getTable('Role')->findOneByKeyName($role);
    if(!$r) {
      throw new InvalidArgumentException("Invalid role given to addRoleToPlayer method: ".$role);
    }
    $this->Roles[] = $r;
  }
  
  public function addRoleToPlayerFromWeapon($weapon) {
    $role = Doctrine::getTable('Role')->getRoleFromWeapon($weapon);
    if($role) $this->Roles[] = $role;
  }
}
