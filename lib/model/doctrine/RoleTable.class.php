<?php

/**
 * RoleTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class RoleTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object RoleTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Role');
    }
    
    public function getRoleFromWeapon($weapon) {
      $r = $this
      ->createQuery('r')
      ->innerJoin('r.Weapon w')
      ->where('w.key_name = ?', $weapon)
      ->execute();
     
      if(count($r) == 0) return null;
      return $r[0]; //returns doctrine_collection obj, we only want first (all we should get)
    }
}
