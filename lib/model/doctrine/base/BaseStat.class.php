<?php

/**
 * BaseStat
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $log_id
 * @property string $name
 * @property integer $player_id
 * @property string $team
 * @property integer $kills
 * @property integer $assists
 * @property integer $deaths
 * @property integer $longest_kill_streak
 * @property integer $headshots
 * @property integer $backstabs
 * @property integer $capture_points_blocked
 * @property integer $capture_points_captured
 * @property integer $flag_defends
 * @property integer $flag_captures
 * @property integer $dominations
 * @property integer $times_dominated
 * @property integer $revenges
 * @property integer $extinguishes
 * @property integer $ubers
 * @property integer $dropped_ubers
 * @property integer $healing
 * @property Log $Log
 * @property Doctrine_Collection $Weapons
 * @property Doctrine_Collection $Roles
 * @property Player $Player
 * @property Doctrine_Collection $Players
 * @property Doctrine_Collection $WeaponStats
 * @property Doctrine_Collection $RoleStats
 * @property Doctrine_Collection $PlayerStats
 * 
 * @method integer             getId()                      Returns the current record's "id" value
 * @method integer             getLogId()                   Returns the current record's "log_id" value
 * @method string              getName()                    Returns the current record's "name" value
 * @method integer             getPlayerId()                Returns the current record's "player_id" value
 * @method string              getTeam()                    Returns the current record's "team" value
 * @method integer             getKills()                   Returns the current record's "kills" value
 * @method integer             getAssists()                 Returns the current record's "assists" value
 * @method integer             getDeaths()                  Returns the current record's "deaths" value
 * @method integer             getLongestKillStreak()       Returns the current record's "longest_kill_streak" value
 * @method integer             getHeadshots()               Returns the current record's "headshots" value
 * @method integer             getBackstabs()               Returns the current record's "backstabs" value
 * @method integer             getCapturePointsBlocked()    Returns the current record's "capture_points_blocked" value
 * @method integer             getCapturePointsCaptured()   Returns the current record's "capture_points_captured" value
 * @method integer             getFlagDefends()             Returns the current record's "flag_defends" value
 * @method integer             getFlagCaptures()            Returns the current record's "flag_captures" value
 * @method integer             getDominations()             Returns the current record's "dominations" value
 * @method integer             getTimesDominated()          Returns the current record's "times_dominated" value
 * @method integer             getRevenges()                Returns the current record's "revenges" value
 * @method integer             getExtinguishes()            Returns the current record's "extinguishes" value
 * @method integer             getUbers()                   Returns the current record's "ubers" value
 * @method integer             getDroppedUbers()            Returns the current record's "dropped_ubers" value
 * @method integer             getHealing()                 Returns the current record's "healing" value
 * @method Log                 getLog()                     Returns the current record's "Log" value
 * @method Doctrine_Collection getWeapons()                 Returns the current record's "Weapons" collection
 * @method Doctrine_Collection getRoles()                   Returns the current record's "Roles" collection
 * @method Player              getPlayer()                  Returns the current record's "Player" value
 * @method Doctrine_Collection getPlayers()                 Returns the current record's "Players" collection
 * @method Doctrine_Collection getWeaponStats()             Returns the current record's "WeaponStats" collection
 * @method Doctrine_Collection getRoleStats()               Returns the current record's "RoleStats" collection
 * @method Doctrine_Collection getPlayerStats()             Returns the current record's "PlayerStats" collection
 * @method Stat                setId()                      Sets the current record's "id" value
 * @method Stat                setLogId()                   Sets the current record's "log_id" value
 * @method Stat                setName()                    Sets the current record's "name" value
 * @method Stat                setPlayerId()                Sets the current record's "player_id" value
 * @method Stat                setTeam()                    Sets the current record's "team" value
 * @method Stat                setKills()                   Sets the current record's "kills" value
 * @method Stat                setAssists()                 Sets the current record's "assists" value
 * @method Stat                setDeaths()                  Sets the current record's "deaths" value
 * @method Stat                setLongestKillStreak()       Sets the current record's "longest_kill_streak" value
 * @method Stat                setHeadshots()               Sets the current record's "headshots" value
 * @method Stat                setBackstabs()               Sets the current record's "backstabs" value
 * @method Stat                setCapturePointsBlocked()    Sets the current record's "capture_points_blocked" value
 * @method Stat                setCapturePointsCaptured()   Sets the current record's "capture_points_captured" value
 * @method Stat                setFlagDefends()             Sets the current record's "flag_defends" value
 * @method Stat                setFlagCaptures()            Sets the current record's "flag_captures" value
 * @method Stat                setDominations()             Sets the current record's "dominations" value
 * @method Stat                setTimesDominated()          Sets the current record's "times_dominated" value
 * @method Stat                setRevenges()                Sets the current record's "revenges" value
 * @method Stat                setExtinguishes()            Sets the current record's "extinguishes" value
 * @method Stat                setUbers()                   Sets the current record's "ubers" value
 * @method Stat                setDroppedUbers()            Sets the current record's "dropped_ubers" value
 * @method Stat                setHealing()                 Sets the current record's "healing" value
 * @method Stat                setLog()                     Sets the current record's "Log" value
 * @method Stat                setWeapons()                 Sets the current record's "Weapons" collection
 * @method Stat                setRoles()                   Sets the current record's "Roles" collection
 * @method Stat                setPlayer()                  Sets the current record's "Player" value
 * @method Stat                setPlayers()                 Sets the current record's "Players" collection
 * @method Stat                setWeaponStats()             Sets the current record's "WeaponStats" collection
 * @method Stat                setRoleStats()               Sets the current record's "RoleStats" collection
 * @method Stat                setPlayerStats()             Sets the current record's "PlayerStats" collection
 * 
 * @package    tf2logs
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseStat extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('stat');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('log_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('name', 'string', 100, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 100,
             ));
        $this->hasColumn('player_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('team', 'string', 4, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('kills', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 0,
             'length' => 4,
             ));
        $this->hasColumn('assists', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 0,
             'length' => 4,
             ));
        $this->hasColumn('deaths', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 0,
             'length' => 4,
             ));
        $this->hasColumn('longest_kill_streak', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 0,
             'length' => 4,
             ));
        $this->hasColumn('headshots', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 0,
             'length' => 4,
             ));
        $this->hasColumn('backstabs', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 0,
             'length' => 4,
             ));
        $this->hasColumn('capture_points_blocked', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 0,
             'length' => 4,
             ));
        $this->hasColumn('capture_points_captured', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 0,
             'length' => 4,
             ));
        $this->hasColumn('flag_defends', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 0,
             'length' => 4,
             ));
        $this->hasColumn('flag_captures', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 0,
             'length' => 4,
             ));
        $this->hasColumn('dominations', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 0,
             'length' => 4,
             ));
        $this->hasColumn('times_dominated', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 0,
             'length' => 4,
             ));
        $this->hasColumn('revenges', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 0,
             'length' => 4,
             ));
        $this->hasColumn('extinguishes', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 0,
             'length' => 4,
             ));
        $this->hasColumn('ubers', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 0,
             'length' => 4,
             ));
        $this->hasColumn('dropped_ubers', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 0,
             'length' => 4,
             ));
        $this->hasColumn('healing', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 0,
             'length' => 4,
             ));


        $this->index('name_idx', array(
             'fields' => 
             array(
              0 => 'name',
             ),
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Log', array(
             'local' => 'log_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasMany('Weapon as Weapons', array(
             'refClass' => 'WeaponStat',
             'local' => 'stat_id',
             'foreign' => 'weapon_id'));

        $this->hasMany('Role as Roles', array(
             'refClass' => 'RoleStat',
             'local' => 'stat_id',
             'foreign' => 'role_id'));

        $this->hasOne('Player', array(
             'local' => 'player_id',
             'foreign' => 'id'));

        $this->hasMany('Player as Players', array(
             'refClass' => 'PlayerStat',
             'local' => 'stat_id',
             'foreign' => 'player_id'));

        $this->hasMany('WeaponStat as WeaponStats', array(
             'local' => 'id',
             'foreign' => 'stat_id'));

        $this->hasMany('RoleStat as RoleStats', array(
             'local' => 'id',
             'foreign' => 'stat_id'));

        $this->hasMany('PlayerStat as PlayerStats', array(
             'local' => 'id',
             'foreign' => 'stat_id'));
    }
}