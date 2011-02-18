<?php

/**
 * BaseSession
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $id
 * @property string $sdata
 * @property integer $stime
 * 
 * @method string  getId()    Returns the current record's "id" value
 * @method string  getSdata() Returns the current record's "sdata" value
 * @method integer getStime() Returns the current record's "stime" value
 * @method Session setId()    Sets the current record's "id" value
 * @method Session setSdata() Sets the current record's "sdata" value
 * @method Session setStime() Sets the current record's "stime" value
 * 
 * @package    tf2logs
 * @subpackage model
 * @author     Brian Barnekow
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseSession extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('session');
        $this->hasColumn('id', 'string', 32, array(
             'type' => 'string',
             'primary' => true,
             'length' => 32,
             ));
        $this->hasColumn('sdata', 'string', 4096, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 4096,
             ));
        $this->hasColumn('stime', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 4,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}