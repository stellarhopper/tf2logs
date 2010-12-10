<?php

/**
 * Weapon filter form base class.
 *
 * @package    tf2logs
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseWeaponFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'key_name'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'name'       => new sfWidgetFormFilterInput(),
      'stats_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Stat')),
    ));

    $this->setValidators(array(
      'key_name'   => new sfValidatorPass(array('required' => false)),
      'name'       => new sfValidatorPass(array('required' => false)),
      'stats_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Stat', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('weapon_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addStatsListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.UsedWeapon UsedWeapon')
      ->andWhereIn('UsedWeapon.stat_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Weapon';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'key_name'   => 'Text',
      'name'       => 'Text',
      'stats_list' => 'ManyKey',
    );
  }
}
