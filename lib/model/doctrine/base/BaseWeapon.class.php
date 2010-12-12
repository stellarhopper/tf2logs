<?php

/**
 * BaseWeapon
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $key_name
 * @property string $name
 * @property integer $role_id
 * @property Role $Role
 * @property Doctrine_Collection $Stats
 * @property Doctrine_Collection $UsedWeapons
 * 
 * @method integer             getId()          Returns the current record's "id" value
 * @method string              getKeyName()     Returns the current record's "key_name" value
 * @method string              getName()        Returns the current record's "name" value
 * @method integer             getRoleId()      Returns the current record's "role_id" value
 * @method Role                getRole()        Returns the current record's "Role" value
 * @method Doctrine_Collection getStats()       Returns the current record's "Stats" collection
 * @method Doctrine_Collection getUsedWeapons() Returns the current record's "UsedWeapons" collection
 * @method Weapon              setId()          Sets the current record's "id" value
 * @method Weapon              setKeyName()     Sets the current record's "key_name" value
 * @method Weapon              setName()        Sets the current record's "name" value
 * @method Weapon              setRoleId()      Sets the current record's "role_id" value
 * @method Weapon              setRole()        Sets the current record's "Role" value
 * @method Weapon              setStats()       Sets the current record's "Stats" collection
 * @method Weapon              setUsedWeapons() Sets the current record's "UsedWeapons" collection
 * 
 * @package    tf2logs
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseWeapon extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('weapon');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('key_name', 'string', 40, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 40,
             ));
        $this->hasColumn('name', 'string', 40, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 40,
             ));
        $this->hasColumn('role_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => false,
             'autoincrement' => false,
             'notnull' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Role', array(
             'local' => 'role_id',
             'foreign' => 'id'));

        $this->hasMany('Stat as Stats', array(
             'refClass' => 'UsedWeapon',
             'local' => 'weapon_id',
             'foreign' => 'stat_id'));

        $this->hasMany('UsedWeapon as UsedWeapons', array(
             'local' => 'id',
             'foreign' => 'weapon_id'));
    }
}