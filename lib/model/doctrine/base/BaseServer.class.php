<?php

/**
 * BaseServer
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $slug
 * @property string $name
 * @property string $ip
 * @property integer $port
 * @property integer $server_group_id
 * @property timestamp $last_message
 * @property string $verify_key
 * @property string $status
 * @property string $current_map
 * @property ServerGroup $ServerGroup
 * 
 * @method string      getSlug()            Returns the current record's "slug" value
 * @method string      getName()            Returns the current record's "name" value
 * @method string      getIp()              Returns the current record's "ip" value
 * @method integer     getPort()            Returns the current record's "port" value
 * @method integer     getServerGroupId()   Returns the current record's "server_group_id" value
 * @method timestamp   getLastMessage()     Returns the current record's "last_message" value
 * @method string      getVerifyKey()       Returns the current record's "verify_key" value
 * @method string      getStatus()          Returns the current record's "status" value
 * @method string      getCurrentMap()      Returns the current record's "current_map" value
 * @method ServerGroup getServerGroup()     Returns the current record's "ServerGroup" value
 * @method Server      setSlug()            Sets the current record's "slug" value
 * @method Server      setName()            Sets the current record's "name" value
 * @method Server      setIp()              Sets the current record's "ip" value
 * @method Server      setPort()            Sets the current record's "port" value
 * @method Server      setServerGroupId()   Sets the current record's "server_group_id" value
 * @method Server      setLastMessage()     Sets the current record's "last_message" value
 * @method Server      setVerifyKey()       Sets the current record's "verify_key" value
 * @method Server      setStatus()          Sets the current record's "status" value
 * @method Server      setCurrentMap()      Sets the current record's "current_map" value
 * @method Server      setServerGroup()     Sets the current record's "ServerGroup" value
 * 
 * @package    tf2logs
 * @subpackage model
 * @author     Brian Barnekow
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseServer extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('server');
        $this->hasColumn('slug', 'string', 30, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 30,
             ));
        $this->hasColumn('name', 'string', 100, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 100,
             ));
        $this->hasColumn('ip', 'string', 15, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 15,
             ));
        $this->hasColumn('port', 'integer', 2, array(
             'type' => 'integer',
             'unsigned' => true,
             'notnull' => true,
             'length' => 2,
             ));
        $this->hasColumn('server_group_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('last_message', 'timestamp', null, array(
             'type' => 'timestamp',
             'notnull' => false,
             ));
        $this->hasColumn('verify_key', 'string', 20, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 20,
             ));
        $this->hasColumn('status', 'string', 1, array(
             'type' => 'string',
             'notnull' => true,
             'default' => 'N',
             'length' => 1,
             ));
        $this->hasColumn('current_map', 'string', 25, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 25,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('ServerGroup', array(
             'local' => 'server_group_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}