<?php

/**
 * BaseLogLine
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $line_year
 * @property integer $line_month
 * @property integer $line_day
 * @property integer $line_hour
 * @property integer $line_minute
 * @property integer $line_second
 * @property timestamp $created_at
 * @property integer $server_id
 * @property string $line_data
 * @property Server $Server
 * 
 * @method integer   getLineYear()    Returns the current record's "line_year" value
 * @method integer   getLineMonth()   Returns the current record's "line_month" value
 * @method integer   getLineDay()     Returns the current record's "line_day" value
 * @method integer   getLineHour()    Returns the current record's "line_hour" value
 * @method integer   getLineMinute()  Returns the current record's "line_minute" value
 * @method integer   getLineSecond()  Returns the current record's "line_second" value
 * @method timestamp getCreatedAt()   Returns the current record's "created_at" value
 * @method integer   getServerId()    Returns the current record's "server_id" value
 * @method string    getLineData()    Returns the current record's "line_data" value
 * @method Server    getServer()      Returns the current record's "Server" value
 * @method LogLine   setLineYear()    Sets the current record's "line_year" value
 * @method LogLine   setLineMonth()   Sets the current record's "line_month" value
 * @method LogLine   setLineDay()     Sets the current record's "line_day" value
 * @method LogLine   setLineHour()    Sets the current record's "line_hour" value
 * @method LogLine   setLineMinute()  Sets the current record's "line_minute" value
 * @method LogLine   setLineSecond()  Sets the current record's "line_second" value
 * @method LogLine   setCreatedAt()   Sets the current record's "created_at" value
 * @method LogLine   setServerId()    Sets the current record's "server_id" value
 * @method LogLine   setLineData()    Sets the current record's "line_data" value
 * @method LogLine   setServer()      Sets the current record's "Server" value
 * 
 * @package    tf2logs
 * @subpackage model
 * @author     Brian Barnekow
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseLogLine extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('log_line');
        $this->hasColumn('line_year', 'integer', 2, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 2,
             ));
        $this->hasColumn('line_month', 'integer', 1, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 1,
             ));
        $this->hasColumn('line_day', 'integer', 1, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 1,
             ));
        $this->hasColumn('line_hour', 'integer', 1, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 1,
             ));
        $this->hasColumn('line_minute', 'integer', 1, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 1,
             ));
        $this->hasColumn('line_second', 'integer', 1, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 1,
             ));
        $this->hasColumn('created_at', 'timestamp', null, array(
             'type' => 'timestamp',
             'notnull' => true,
             ));
        $this->hasColumn('server_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('line_data', 'string', 1000, array(
             'type' => 'string',
             'length' => 1000,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Server', array(
             'local' => 'server_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}