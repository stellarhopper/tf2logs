<?php

/**
 * UsedWeapon form base class.
 *
 * @method UsedWeapon getObject() Returns the current form's model object
 *
 * @package    tf2logs
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseUsedWeaponForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'weapon_id' => new sfWidgetFormInputHidden(),
      'stat_id'   => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'weapon_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('weapon_id')), 'empty_value' => $this->getObject()->get('weapon_id'), 'required' => false)),
      'stat_id'   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('stat_id')), 'empty_value' => $this->getObject()->get('stat_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('used_weapon[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'UsedWeapon';
  }

}
