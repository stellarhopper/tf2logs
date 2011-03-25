<?php
function getWinSeparator($redScore, $blueScore) {
  if($redScore > $blueScore) return "&gt;";
  else if($redScore < $blueScore) return "&lt;";
  else if($redScore == $blueScore) return "==";
  else return "";
}

/**
* Outputs a number for seconds into a human readable format,
* like 10 minutes, 12 seconds, or if less than a minute,
* just 12 seconds.
*/
function outputSecondsToHumanFormat($seconds) {
  $mins = (int)($seconds/60);
  $secs = $seconds%60;
  $outmins = "";
  if($mins > 0) {
    $pluralmin = "";
    if($mins != 1) $pluralmin = "s";
    $outmins = $mins." minute".$pluralmin.", ";
  }
  $pluralsec = "";
  if($secs != 1) $pluralsec = "s";
  return $outmins.$secs." second".$pluralsec;
}

/**
* If the value given is zero, the output is changed
* to a class to fade the zero number. This is to
* draw attention more to the non-zero values.
* If the number is not zero, normal styling is used.
*/
function dataCellOutputClass($value) {
  if($value == 0) return 'zeroValue';
  return 'nonZeroValue';
}

function doPerDivision($numerator, $denominator) {
  if($denominator == 0) return $numerator;
  return round((float) $numerator/$denominator, 3);
}

function mapExists($map) {
  return $map != null && is_dir(sfConfig::get('sf_web_dir').'/maps/'.$map);
}

function getCoords($coord) {
  $a = explode(" ", $coord);
  return "x:".$a[0].",y:".$a[1];
}

function outputPlayerCollection($statsArray) {
  $s = "var playerCollection = new PlayerCollection([\n";
  $isFirst = true;
  foreach ($statsArray as $stat) {
    $comma = ",";
    if($isFirst) {
      $comma = ""; 
      $isFirst = false;
    }
    $s .= $comma."new PlayerDrawable(".$stat['Player']['id'].",\"".addslashes($stat['name'])."\",\"".strtolower($stat['team'])."\")\n";
  }
  $s .= "]);";
  return $s;
}

function outputEventsCollection($eventsArray) {
  $s = "var logEventCollection = new LogEventCollection([\n";
  $isFirst = true;
  foreach ($eventsArray as $event) {
    $comma = ",";
    if($isFirst) {
      $comma = "";
      $isFirst = false;
    }
    if($event['event_type'] == "kill") {
      $s .= $comma."new LogEvent(".$event['elapsed_seconds'].").k(".$event['weapon_id'].",".$event['attacker_player_id'].",{".getCoords($event['attacker_coord'])."},".$event['victim_player_id'].",{".getCoords($event['victim_coord'])."})\n";
    } elseif($event['event_type'] == "say") {
      $s .= $comma."new LogEvent(".$event['elapsed_seconds'].").s(".$event['chat_player_id'].",\"".addslashes($event['text'])."\")\n";
    } elseif($event['event_type'] == "say_team") {
      $s .= $comma."new LogEvent(".$event['elapsed_seconds'].").ts(".$event['chat_player_id'].",\"".addslashes($event['text'])."\")\n";
    } elseif($event['event_type'] == "pointCap") {
      $pids = array();
      foreach($event['EventPlayers'] as $ep) {
        $pids[] = $ep['player_id'];
      }
      $s .= $comma."new LogEvent(".$event['elapsed_seconds'].").pc(\"".$event['capture_point']."\",\"".$event['team']."\",[".implode(",", $pids)."])\n";
    } elseif($event['event_type'] == "rndStart") {
      $s .= $comma."new LogEvent(".$event['elapsed_seconds'].").rs(".$event['red_score'].",".$event['blue_score'].")\n";
    } elseif($event['event_type'] == "scrChng") {
      $s .= $comma."new LogEvent(".$event['elapsed_seconds'].").sc(".$event['red_score'].",".$event['blue_score'].")\n";
    }
  }
  $s .= "]);";
  return $s;
}

function outputWeaponCollection($weaponsArray) {
  $s = "var weaponCollection = new WeaponCollection(\"".sfConfig::get('app_kill_icon_base_url')."\",[\n";
  $isFirst = true;
  foreach ($weaponsArray as $w) {
    $comma = ",";
    if($isFirst) {
      $comma = ""; 
      $isFirst = false;
    }
    $s .= $comma."new Weapon(".$w['id'].",\"".$w['key_name']."\",\"".addslashes($w['name'])."\",\"".addslashes($w['image_name'])."\")\n";
  }
  $s .= "]);";
  return $s;
}

function outputAsJSArray($a) {
  $s = "[";
  $isFirst = true;
  foreach ($a as $item) {
    $comma = ",";
    if($isFirst) {
      $comma = "";
      $isFirst = false;
    }
    $s .= $comma.'"'.addslashes($item).'"';
  }
  $s .= "]";
  return $s;
}

function outputWeapon($name, $key_name, $image_name) {
 $s = "";
 $t = "";
 if($name) {
  $t = $name;
 } else {
  $t = $key_name;
 }
 if($image_name) {
  $s .= '<img class="killIcon" src="'.sfConfig::get('app_kill_icon_base_url').'/'.$image_name.'" alt="'.$t.'"/>';
 } else {
  $s .= $t;
 }
 return $s;
}

function outputWeaponName($name, $key_name) {
 if($name) {
  return $name;
 } else {
  return $key_name;
 }
}

//takes the mini stat array generated by outputstatpanel
function outputWeaponStats($weapons, $miniStats, $weaponStats) {
$avbase = sfConfig::get('app_avatar_base_url');
  $s = <<<EOD
<div class="statTableContainer" id="weaponStatsContainer">
<table class="statTable" id="weaponStats" border="0" cellspacing="0" cellpadding="3">
  <caption class="ui-toolbar ui-widget-header ui-corner-tl ui-corner-tr">Weapon Stats</caption>
  <thead>
    <tr>
      <th rowspan="2" class="ui-state-default weaponStatPlayer"><!--playername--></th>
EOD;
    for($x = 0; $x < count($weapons); ++$x) {
      $w = $weapons[$x];
      $title = "";
      $weaponHTML = outputWeapon($w['name'], $w['key_name'], $w['image_name']);
      //only want a tooltip if there is an img.
      if(strpos($weaponHTML, "<img") === 0) $title = ' title="'.outputWeaponName($w['name'], $w['key_name']).'"';
      $s .= '<th colspan="2" class="ui-state-default weaponStatWeapon"'.$title.'>'.$weaponHTML."</th>";
    }
    $s .= "</tr><tr>";
    for($x = 0; $x < count($weapons); ++$x) {
      $s .= '<th title="Kills" class="ui-state-default">K</th><th title="Deaths" class="ui-state-default">D</th>';
    }
    $s .= '</tr></thead><tbody>';
    for($x = 0; $x < count($miniStats); ++$x) {
      $stat = $miniStats[$x];
      $s .= '<tr><td class="ui-table-content weaponStatPlayer">';
        $s .= '<img src="'.$avbase.$stat['playerAvatarUrl'].'" class="'.$stat['team'].' avatarImage ui-corner-all"/>'.link_to($stat['name'], 'player/showNumericSteamId?id='.$stat['playerNumericSteamid']).'</td>';
      for($y = 0; $y < count($weapons); ++$y) {
        $w = $weapons[$y];
        $foundWS = false;
        for($z = 0; $z < count($weaponStats); ++$z) {
          $ws = $weaponStats[$z];
          if($ws['stat_id'] == $stat['id'] && $ws['weapon_id'] == $w['id']) {
            $kills = $ws['num_kills'];
            $deaths = $ws['num_deaths'];
            $s .= '<td class="ui-table-kills"><span class="'.dataCellOutputClass($kills).'">'.$kills.'</span></td><td class="ui-table-deaths"><span class="'.dataCellOutputClass($deaths).'">'.$deaths.'</span></td>';
            $foundWS = true;
            break;
          }
        }
        if(!$foundWS) {
          $s .= '<td class="ui-table-kills"><span class="zeroValue">0</span></td><td class="ui-table-deaths"><span class="zeroValue">0</span></td>';
        }
      }
    $s .= '</tr>';
    }
$s .= '</tbody></table></div><br class="hardSeparator"/>';
return $s;
}

//this will create a mini Stats array with the $miniStatsRet ref
function outputStatPanel($game_seconds, $stats, &$miniStatsRet) {
$avbase = sfConfig::get('app_avatar_base_url');
$minutes = (float)$game_seconds/60;
$s = <<<EOD
<div class="statTableContainer">
<table id="statPanel" class="statTable" border="0" cellspacing="0" cellpadding="3">
  <caption>Log Stats</caption>
  <thead>
    <tr>
      <th>Name</th>
      <th title="Classes">C</th>
      <th title="Kills">K</th>
      <th title="Assists">A</th>
      <th title="Deaths">D</th>    
      <th title="Kills+Assists/Death">KAPD</th>
      <th title="Kills+Assists/Minute">KAPM</th>
      <th title="Damage">DA</th>
      <th title="Damage/Death">DAPD</th>
      <th title="Damage/Minute">DAPM</th>
      <th title="Longest Kill Streak">LKS</th>
      <th title="Headshots">HS</th>
      <th title="Backstabs">BS</th>
      <th title="Capture Points Blocked">CPB</th>
      <th title="Capture Points Captured">CPC</th>
      <th title="Intel Defends">ID</th>
      <th title="Intel Captures">IC</th>
      <th title="Dominations">DOM</th>
      <th title="Times Dominated">TDM</th>
      <th title="Revenges">R</th>
      <th title="Extinguishes">E</th>
    </tr>
  </thead>
  <tbody>
EOD;
  foreach ($stats as $stat) {
    $miniStat = array();
    $miniStat['playerId'] = $stat['Player']['id'];
    $miniStat['playerNumericSteamid'] = $stat['Player']['numeric_steamid'];
    $miniStat['playerAvatarUrl'] = $stat['Player']['avatar_url'];
    $miniStat['name'] = $stat['name'];
    $miniStat['team'] = $stat['team'];
    $miniStat['id'] = $stat['id'];
    $miniStatsRet[] = $miniStat;
    
    $s .= '<tr><td class="ui-table-content txtnowrap" title="Steam ID: '.$stat['Player']['steamid'].'">';
        $s .= '<img src="'.$avbase.$miniStat['playerAvatarUrl'].'" class="'.$stat['team'].' avatar avatarImage ui-corner-all" id="avatar'.$miniStat['playerId'].'"/>';
        $s .= link_to($miniStat['name'], 'player/showNumericSteamId?id='.$miniStat['playerNumericSteamid']);
      $s .= '</td>';
      $s .= '<td class="ui-table-content">';
        $s .= '<ul>';
          foreach($stat['RoleStats'] as $rs) {
            $s .= '<li><img src="'.sfConfig::get('app_class_icon_base_url').'/'.$rs['Role']['key_name'].'.png" class="classIcon" title="'.$rs['Role']['name'].' - '.outputSecondsToHumanFormat($rs['time_played']).'" alt="'.$rs['Role']['name'].' - '.outputSecondsToHumanFormat($rs['time_played']).'"/></li>';
          }
        $s .= '</ul>';
      $s .= '</td>';
      $s .= '<td class="ui-table-content"><span class="'.dataCellOutputClass($stat['kills']).'">'. $stat['kills'].'</span></td>';
      $s .= '<td class="ui-table-content"><span class="'.dataCellOutputClass($stat['assists']).'">'. $stat['assists'].'</span></td>';
      $s .= '<td class="ui-table-content"><span class="'.dataCellOutputClass($stat['deaths']).'">'. $stat['deaths'].'</span></td>';
      $s .= '<td class="ui-table-content">';
        $s .= '<span class="'.dataCellOutputClass(doPerDivision($stat['kills']+$stat['assists'], $stat['deaths'])).'">';
          $s .= doPerDivision($stat['kills']+$stat['assists'], $stat['deaths']);
        $s .= '</span>';
      $s .= '</td>';
      $s .= '<td class="ui-table-content">';
        $s .= '<span class="'.dataCellOutputClass(doPerDivision($stat['kills']+$stat['assists'], $minutes)).'">';
          $s .= doPerDivision($stat['kills']+$stat['assists'], $minutes);
        $s .= '</span>';
      $s .= '</td>';
      $s .= '<td class="ui-table-content"><span class="'.dataCellOutputClass($stat['damage']).'">'. $stat['damage'].'</span></td>';
      $s .= '<td class="ui-table-content">';
        $s .= '<span class="'.dataCellOutputClass(doPerDivision($stat['damage'], $stat['deaths'])).'">';
          $s .= doPerDivision($stat['damage'], $stat['deaths']);
        $s .= '</span>';
      $s .= '</td>';
      $s .= '<td class="ui-table-content">';
        $s .= '<span class="'.dataCellOutputClass(doPerDivision($stat['damage'], $minutes)).'">';
          $s .= doPerDivision($stat['damage'], $minutes);
        $s .= '</span>';
      $s .= '</td>';
      $s .= '<td class="ui-table-content"><span class="'.dataCellOutputClass($stat['longest_kill_streak']).'">'. $stat['longest_kill_streak'].'</span></td>';
      $s .= '<td class="ui-table-content"><span class="'.dataCellOutputClass($stat['headshots']).'">'. $stat['headshots'].'</span></td>';
      $s .= '<td class="ui-table-content"><span class="'.dataCellOutputClass($stat['backstabs']).'">'. $stat['backstabs'].'</span></td>';
      $s .= '<td class="ui-table-content"><span class="'.dataCellOutputClass($stat['capture_points_blocked']).'">'. $stat['capture_points_blocked'].'</span></td>';
      $s .= '<td class="ui-table-content"><span class="'. dataCellOutputClass($stat['capture_points_captured']).'">'. $stat['capture_points_captured'].'</span></td>';
      $s .= '<td class="ui-table-content"><span class="'. dataCellOutputClass($stat['flag_defends']).'">'. $stat['flag_defends'].'</span></td>';
      $s .= '<td class="ui-table-content"><span class="'. dataCellOutputClass($stat['flag_captures']).'">'. $stat['flag_captures'].'</span></td>';
      $s .= '<td class="ui-table-content"><span class="'. dataCellOutputClass($stat['dominations']).'">'. $stat['dominations'].'</span></td>';
      $s .= '<td class="ui-table-content"><span class="'. dataCellOutputClass($stat['times_dominated']).'">'. $stat['times_dominated'].'</span></td>';
      $s .= '<td class="ui-table-content"><span class="'. dataCellOutputClass($stat['revenges']).'">'. $stat['revenges'].'</span></td>';
      $s .= '<td class="ui-table-content"><span class="'. dataCellOutputClass($stat['extinguishes']).'">'. $stat['extinguishes'].'</span></td>';
      $s .= '</tr>';
    }
  $s .= '</tbody>';
$s .= '</table>';
$s .= '</div>';
$s .= '<br class="hardSeparator"/>';
return $s;
}

function outputMedicStats($game_seconds, $stats) {
$avbase = sfConfig::get('app_avatar_base_url');
$minutes = (float)$game_seconds/60;
$s = <<<EOD
<div class="statTableContainer">
<table class="statTable" id="medicStats" border="0" cellspacing="0" cellpadding="3">
  <caption>Medic Comparison</caption>
  <thead>
    <tr>
      <th>Name</th>
      <th title="Kills+Assists/Death">KAPD</th>
      <th title="Kills+Assists/Minute">KAPM</th>
      <th title="Ubers">U</th>
      <th title="Ubers/Death">UPD</th>
      <th title="Ubers/Minute">UPM</th>
      <th title="Dropped Ubers">DU</th>
      <th title="Healing">H</th>
      <th title="Healing/Death">HPD</th>
      <th title="Healing/Minute">HPM</th>
      <th title="Extinguishes">E</th>
    </tr>
  </thead>
  <tbody>
EOD;
    foreach ($stats as $stat) {
      foreach($stat['RoleStats'] as $rs) {
        if($rs['Role']['key_name'] == "medic" && $rs['time_played'] > 1) {
          $s .= '<tr>';
            $s .= '<td class="ui-table-content txtnowrap">';
              $s .= '<img src="'.$avbase.$stat['Player']['avatar_url'].'" class="'.$stat['team'].' avatar avatarImage ui-corner-all" id="avatar'.$stat['Player']['id'].'"/>';
              $s .= link_to($stat['name'], 'player/showNumericSteamId?id='.$stat['Player']['numeric_steamid']).'';
            $s .= '</td>';
            $s .= '<td class="ui-table-content">';
              $s .= '<span class="'.dataCellOutputClass(doPerDivision($stat['kills']+$stat['assists'], $stat['deaths'])).'">';
                $s .= doPerDivision($stat['kills']+$stat['assists'], $stat['deaths']).'';
              $s .= '</span>';
            $s .= '</td>';
            $s .= '<td class="ui-table-content">';
            $s .= '<span class="'.dataCellOutputClass(doPerDivision($stat['kills']+$stat['assists'], $minutes)).'">';
                $s .= doPerDivision($stat['kills']+$stat['assists'], $minutes).'';
              $s .= '</span>';
            $s .= '</td>';
            $s .= '<td class="ui-table-content"><span class="'.dataCellOutputClass($stat['ubers']).'">'.$stat['ubers'].'</span></td>';
            $s .= '<td class="ui-table-content"><span class="'.dataCellOutputClass(doPerDivision($stat['ubers'], $stat['deaths'])).'">'.doPerDivision($stat['ubers'], $stat['deaths']).'</span></td>';
            $s .= '<td class="ui-table-content"><span class="'.dataCellOutputClass(doPerDivision($stat['ubers'], $minutes)).'">'.doPerDivision($stat['ubers'], $minutes).'</span></td>';
            $s .= '<td class="ui-table-content"><span class="'.dataCellOutputClass($stat['dropped_ubers']).'">'.$stat['dropped_ubers'].'</span></td>';
            $s .= '<td class="ui-table-content"><span class="'.dataCellOutputClass($stat['healing']).'">'.$stat['healing'].'</span></td>';
            $s .= '<td class="ui-table-content"><span class="'.dataCellOutputClass(doPerDivision($stat['healing'], $stat['deaths'])).'">'.doPerDivision($stat['healing'], $stat['deaths']).'</span></td>';
            $s .= '<td class="ui-table-content"><span class="'.dataCellOutputClass(doPerDivision($stat['healing'], $minutes)).'">'.doPerDivision($stat['healing'], $minutes).'</span></td>';
            $s .= '<td class="ui-table-content"><span class="'.dataCellOutputClass($stat['extinguishes']).'">'.$stat['extinguishes'].'</span></td>';
          $s .= '</tr>';
        }
      }
    }
  $s .= '</tbody>';
$s .= '</table>';
$s .= '</div>';
$s .= '<br class="hardSeparator"/>';
return $s;
}

//this will create a mini Stats array with the $miniStatsRet ref
function outputPlayerStats($miniStats, $playerStats) {
$avbase = sfConfig::get('app_avatar_base_url');
$s = <<<EOD
<div class="statTableContainer">
<table class="statTable" id="playerStats" border="0" cellspacing="0" cellpadding="3">
  <caption>Player Stats</caption>
  <thead>
    <tr>
      <th><!--playername--></th>
EOD;
      for($x = 0; $x < count($miniStats); ++$x) {
        $st = $miniStats[$x];
        $s .= '<th title="'.$st['name'].'" class="ui-state-default txtnowrap"><img src="'.$avbase.$st['playerAvatarUrl'].'" class="'.$st['team'].' avatarImage ui-corner-all"/></th>';
      }
    $s .= '</tr></thead><tbody>';
  for($x = 0; $x < count($miniStats); ++$x) {
    $stat = $miniStats[$x];
    $s .= '<tr><td class="ui-table-content txtnowrap"><img src="'.$avbase.$stat['playerAvatarUrl'].'" class="'.$stat['team'].' avatarImage ui-corner-all"/>'.link_to($stat['name'], 'player/showNumericSteamId?id='.$stat['playerNumericSteamid']).'</td>';
      for($y = 0; $y < count($miniStats); ++$y) {
        $colstat = $miniStats[$y];
        $foundPS = false;
        for($z = 0; $z < count($playerStats); ++$z) {
          $ps = $playerStats[$z];
          if($ps['stat_id'] == $stat['id'] && $ps['player_id'] == $colstat['playerId']) {
            $s .= '<td class="ui-table-content"><span class="'.dataCellOutputClass($ps['num_kills']).'">'.$ps['num_kills'].'</span></td>';
            $foundPS = true;
            break;
          }
        }
        if(!$foundPS) {
          $s .= '<td class="ui-table-content"><span class="zeroValue">0</span></td>';
        }
      }
    $s .= '</tr>';
    }
  $s .= '</tbody></table></div><br class="hardSeparator"/>';
return $s;
}

function outputPlayerHealStats($miniStats, $playerHealStats) {
  $avbase = sfConfig::get('app_avatar_base_url');
  $htmlid = "playerHealStats";
  
  //make the header
  $thead = "<tr><th><!--player name--></th>";
  $headerColIds = array();
  for($x = 0; $x < count($playerHealStats); ++$x) {
    $phs = $playerHealStats[$x];
    //only want distinct columns
    if(!in_array($phs['stat_id'], $headerColIds)) {
      $headerColIds[] = $phs['stat_id'];
      
      $thead .= '<th title="'.$phs['Stat']['name'].'" class="ui-state-default txtnowrap"><img src="'.$avbase.$phs['Stat']['Player']['avatar_url'].'" class="'.$phs['Stat']['team'].' avatarImage ui-corner-all"/></th>';
    }
  }
  $thead .= "</tr>";
  
  //make the body
  $tbody = "";
  for($x = 0; $x < count($miniStats); ++$x) {
    $stat = $miniStats[$x];
    $tbody .= '<tr><td class="ui-table-content txtnowrap"><img src="'.$avbase.$stat['playerAvatarUrl'].'" class="'.$stat['team'].' avatarImage ui-corner-all"/>'.link_to($stat['name'], 'player/showNumericSteamId?id='.$stat['playerNumericSteamid']).'</td>';
    
    foreach($headerColIds as $id) {
      $found = false;
      for($y = 0; $y <count($playerHealStats); ++$y) {
        $phs = $playerHealStats[$y];
        
        if($phs['player_id'] == $stat['playerId'] && $phs['stat_id'] == $id) {
          $tbody .= '<td class="ui-table-content"><span class="'.dataCellOutputClass($phs['healing']).'">'.$phs['healing'].'</span></td>';
          $found = true;
        }
      }
      if(!$found) {
        $tbody .= '<td class="ui-table-content"><span class="zeroValue">0</span></td>';
      }
    }
    
    $tbody .= "</tr>";
  }
  
  $s = <<<EOD
<div class="statTableContainer">
  <table class="statTable" id="$htmlid" border="0" cellspacing="0" cellpadding="3">
    <caption>Heal Spread</caption>
    <thead>
      $thead
    </thead>
    <tbody>
      $tbody
    </tbody>
  </table>
</div>
EOD;
  return $s;
}

function outputItemPickupStats($miniStats, $itemPickupStats) {
  $avbase = sfConfig::get('app_avatar_base_url');  
  $htmlid = "itemPickupStats";
  
  //make the header
  $thead = "<tr><th><!--player name--></th>";
  $headerColKeys = array();
  $tfammopack = null;
  for($x = 0; $x < count($itemPickupStats); ++$x) {
    $ips = $itemPickupStats[$x];
    //only want distinct columns
    if(!in_array($ips['item_key_name'], $headerColKeys)) {
      if($ips['item_key_name'] == 'tf_ammo_pack') {
        $tfammopack = 'tf_ammo_pack';
      } else {
        $headerColKeys[] = $ips['item_key_name'];
      }
    }
  }
  //array is sorted by item key name in reverse alpha order, which works for most items. We want this last, but will end up first originally.
  if($tfammopack) $headerColKeys[] = $tfammopack;
  
  foreach($headerColKeys as $key) {
    $data = $key;
    $title = "";
    
    if($key == 'medkit_small') {
      $title = "Small Medkit";
      $data = '<img class="itemIcon" src="'.sfConfig::get('app_item_icon_base_url').'/medkit_small.png" alt="'.$title.'"/>';
    } else if($key == 'medkit_medium') {
      $title = "Medium Medkit";
      $data = '<img class="itemIcon" src="'.sfConfig::get('app_item_icon_base_url').'/medkit_medium.png" alt="'.$title.'"/>';
    } else if($key == 'medkit_large') {
      $title = "Large Medkit";
      $data = '<img class="itemIcon" src="'.sfConfig::get('app_item_icon_base_url').'/medkit_large.png" alt="'.$title.'"/>';
    } else if($key == 'ammopack_small') {
      $title = "Small Ammo";
      $data = '<img class="itemIcon" src="'.sfConfig::get('app_item_icon_base_url').'/ammopack_small.png" alt="'.$title.'"/>';
    } else if($key == 'ammopack_medium') {
      $title = "Medium Ammo";
      $data = '<img class="itemIcon" src="'.sfConfig::get('app_item_icon_base_url').'/ammopack_medium.png" alt="'.$title.'"/>';
    } else if($key == 'ammopack_large') {
      $title = "Large Ammo";
      $data = '<img class="itemIcon" src="'.sfConfig::get('app_item_icon_base_url').'/ammopack_large.png" alt="'.$title.'"/>';
    } else if($key == 'tf_ammo_pack') {
      $title = "Dropped Metal/Ammo";
      $data = '<img class="itemIcon" src="'.sfConfig::get('app_item_icon_base_url').'/tf_ammo_pack.png" alt="'.$title.'"/>';
    }
    
    $thead .= '<th title="'.$title.'" class="ui-state-default txtnowrap">'.$data.'</th>';
  }
  $thead .= "</tr>";
  
  //make the body
  $tbody = "";
  for($x = 0; $x < count($miniStats); ++$x) {
    $stat = $miniStats[$x];
    $tbody .= '<tr><td class="ui-table-content txtnowrap"><img src="'.$avbase.$stat['playerAvatarUrl'].'" class="'.$stat['team'].' avatarImage ui-corner-all"/>'.link_to($stat['name'], 'player/showNumericSteamId?id='.$stat['playerNumericSteamid']).'</td>';
    
    foreach($headerColKeys as $key) {
      $found = false;
      for($y = 0; $y <count($itemPickupStats); ++$y) {
        $ips = $itemPickupStats[$y];
        
        if($ips['stat_id'] == $stat['id'] && $ips['item_key_name'] == $key) {
          $tbody .= '<td class="ui-table-content"><span class="'.dataCellOutputClass($ips['times_picked_up']).'">'.$ips['times_picked_up'].'</span></td>';
          $found = true;
        }
      }
      if(!$found) {
        $tbody .= '<td class="ui-table-content"><span class="zeroValue">0</span></td>';
      }
    }
    
    $tbody .= "</tr>";
  }
  
  $s = <<<EOD
<div class="statTableContainer">
  <table class="statTable" id="$htmlid" border="0" cellspacing="0" cellpadding="3">
    <caption>Items Picked Up</caption>
    <thead>
      $thead
    </thead>
    <tbody>
      $tbody
    </tbody>
  </table>
</div>
<br class="hardSeparator"/>
EOD;
  return $s;
}
?>
