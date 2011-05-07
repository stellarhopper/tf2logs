<?php

/**
 * Server form.
 *
 * @package    tf2logs
 * @subpackage form
 * @author     Brian Barnekow
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ServerUpdateForm extends BaseServerForm {
  public function configure() {
    unset($this->widgetSchema['server_group_id']);
    unset($this->validatorSchema['server_group_id']);
    unset($this->widgetSchema['last_message']);
    unset($this->validatorSchema['last_message']);
    unset($this->widgetSchema['verify_key']);
    unset($this->validatorSchema['verify_key']);
    unset($this->widgetSchema['status']);
    unset($this->validatorSchema['status']);
    unset($this->widgetSchema['current_map']);
    unset($this->validatorSchema['current_map']);
    unset($this->widgetSchema['live_log_id']);
    unset($this->validatorSchema['live_log_id']);
    unset($this->widgetSchema['ip']);
    unset($this->validatorSchema['ip']);
    unset($this->widgetSchema['port']);
    unset($this->validatorSchema['port']);

    $max = $this->validatorSchema['slug']->getOption('max_length');
    $this->validatorSchema['slug'] = new sfValidatorAnd(array(
      new sfValidatorString(array('max_length' => $max, 'required' => true), array('required' => 'The URL field is required.'))
      , new sfValidatorRegex(array('pattern' => '/^([a-zA-Z0-9_\-]+)$/'), array('invalid' => 'The Server URL field is invalid. It can only contain letters, numbers, underscores (_), and dashes (-).'))
    ), array('required' => 'The URL field is required.'));
    $this->widgetSchema['slug']->setOption('label', 'tf2logs.com/servers/');
    
    $this->validatorSchema['name']->setOption('required', true);
    $this->validatorSchema['name']->setMessage('required', 'The Server Name field is required.');
    $this->widgetSchema['name']->setOption('label', 'Server Name');

    $this->validatorSchema->setPostValidator(new sfValidatorAnd(array(
      new sfValidatorDoctrineUnique(array('model' => 'ServerGroup', 'column' => array('slug')), array('invalid' => 'The Server URL must be unique.'))
      ,new SlugUniqueToGroupValidator()
    )));
    
    $this->widgetSchema['region'] = new sfWidgetFormChoice(array(
      'choices'   => array_merge(array('' => 'Select a Region'), Server::getRegions())
    )));
    
    $this->validatorSchema['region'] = new sfValidatorChoice(array(
      'choices' => Server::getRegions()
    )));
  }
  
  public function configureUniqueSlugValidator($group_slug_value, $old_server_slug_value) {
    $this->validatorSchema->setPostValidator(new sfValidatorAnd(array(
      new sfValidatorDoctrineUnique(array('model' => 'ServerGroup', 'column' => array('slug')), array('invalid' => 'The Server URL must be unique.'))
      ,new SlugUniqueToGroupValidator(array('group_slug_value' => $group_slug_value, 'server_slug_key' => 'slug', 'old_server_slug_value' => $old_server_slug_value))
    )));
  }
}