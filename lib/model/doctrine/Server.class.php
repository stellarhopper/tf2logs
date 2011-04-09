<?php

/**
 * Server
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    tf2logs
 * @subpackage model
 * @author     Brian Barnekow
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Server extends BaseServer {
  const STATUS_NOT_VERIFIED = 'N';
  const STATUS_INACTIVE = 'I'; //previous owner gave up rights to this server
  const STATUS_ACTIVE = 'A';
  const STATUS_RECORDING = 'R';
  const STATUS_PROCESSING = 'P';
  
  /**
    retrieves a description for the given status code.
  */
  public static function getDescriptionForStatus($status) {
    switch($status) {
      case self::STATUS_NOT_VERIFIED:
        return "Server not Verified";
      case self::STATUS_ACTIVE:
        return "Server is Active";
      case self::STATUS_INACTIVE:
        return "Server is Inactive";
      case self::STATUS_RECORDING:
        return "Recording New Log";
      case self::STATUS_PROCESSING:
        return "Processing New Log";
      default:
        return "N/A";
    }
  }

  public function saveNewSingleServer($slug, $name, $ip, $port, $owner_id) {
    $serverGroup = new ServerGroup();
    $serverGroup->setSlug($slug);
    $serverGroup->setName($name);
    $serverGroup->setOwnerPlayerId($owner_id);
    $serverGroup->setGroupType(ServerGroup::GROUP_TYPE_SINGLE_SERVER);
    
    $this->ip = $ip;
    $this->port = $port;
    $this->ServerGroup = $serverGroup;
    
    $this->verify_key = $this->generateVerifyKey($name);
    $this->status = self::STATUS_NOT_VERIFIED;
    
    $this->save();
  }
  
  public function saveNewGroupServer($group_name, $group_slug, $server_name, $server_slug, $ip, $port, $owner_id) {
    $serverGroup = new ServerGroup();
    $serverGroup->setSlug($group_slug);
    $serverGroup->setName($group_name);
    $serverGroup->setOwnerPlayerId($owner_id);
    $serverGroup->setGroupType(ServerGroup::GROUP_TYPE_MULTI_SERVER);
    
    $this->slug = $server_slug;
    $this->name = $server_name;
    $this->ip = $ip;
    $this->port = $port;
    $this->ServerGroup = $serverGroup;
    
    $this->verify_key = $this->generateVerifyKey($server_name);
    $this->status = self::STATUS_NOT_VERIFIED;
    
    $this->save();
  }
  
  public function saveNewServerToGroup($group_slug, $server_name, $server_slug, $ip, $port, $owner_id) {
    $this->ServerGroup = Doctrine::getTable('ServerGroup')->findOneBySlugAndOwnerPlayerId($group_slug, $owner_id);
    if(!$this->ServerGroup) throw new IllegalArgumentException("Could not find group $group_slug, $owner_id");
    
    $this->slug = $server_slug;
    $this->name = $server_name;
    $this->ip = $ip;
    $this->port = $port;
    
    $this->verify_key = $this->generateVerifyKey($server_name);
    $this->status = self::STATUS_NOT_VERIFIED;
    
    $this->save();
  }
  
  public function generateVerifyKey($serverName = null) {
    if(!$serverName) {
      $serverName = $this->name;
    }
    $key = "tf2logs:";
    
    $fieldlength = $this->getTable()->getColumnDefinition('verify_key');
    $fieldlength = $fieldlength['length'];
    
    $keylength = $fieldlength-strlen($key);
    return $key.substr(sha1($serverName.time()), 0 ,$keylength);
  }
  
  /**
    Since single servers inherit settings from the group, need to modify these getters to 
    look at the group if needed.
  */
  public function getSlug() {
    if(!$this->_get('slug')) {
      if(!$this->_get('ServerGroup')) {
        return null;
      } else {
        return $this->ServerGroup->getSlug();
      }
    } else {
      return $this->_get('slug');
    }
  }
  
  public function getName() {
    if(!$this->_get('name')) {
      if(!$this->_get('ServerGroup')) {
        return null;
      } else {
        return $this->ServerGroup->getName();
      }
    } else {
      return $this->_get('name');
    }
  }
}
