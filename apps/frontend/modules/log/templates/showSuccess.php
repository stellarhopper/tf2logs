<?php use_helper('Log') ?>
<?php use_helper('Implode') ?>
<?php use_stylesheet('jquery.tooltip.css'); ?>
<?php use_javascript('jquery-1.4.4.min.js'); ?>

<?php if(mapExists($log['map_name'])): ?>
<?php use_stylesheet('./mint-choc/jquery-ui-1.8.9.custom.css'); ?>
<?php use_stylesheet('canvas.css'); ?>
<?php use_javascript('jquery-ui-1.8.9.custom.min.js'); ?>
<?php use_javascript('class.js'); ?>
<?php use_javascript('mapviewer.js'); ?>
<?php use_javascript('/maps/'.$log['map_name'].'/map.js'); ?>
<?php use_dynamic_javascript(url_for('@events_by_id?id='.$log['id'])); ?>
<?php endif ?>


<?php use_javascript('jquery.dimensions.js'); ?>
<?php use_javascript('jquery.tooltip.min.js'); ?>
<?php use_javascript('logshow.js'); ?>
<div id="logName"><?php echo $log['name'] ?></div>

<div id="score">
  <span class="Red teamName">Red</span> <span class="red"><?php echo $log['redscore'] ?></span>
   <span class="winSeparator"><?php echo getWinSeparator($log['redscore'], $log['bluescore']) ?></span> 
   <span class="Blue teamName">Blue</span> <span class="blue"><?php echo $log['bluescore'] ?></span>
</div>

<?php if(mapExists($log['map_name'])): ?>
<canvas id="mapViewer"></canvas>
<div id="mapViewerControls">
	<button id="playPauseButton"></button>
	<div id="playbackProgress"><span id="totalTime"></span></div>
	<div style="clear: both">
	  <label for="playbackSpeed">Playback Speed</label>
	  <select id="playbackSpeed">
	    <option value="1">1x</option>
	    <option value="5" selected>5x</option>
	    <option value="20">20x</option>
	  </select>
	  
	  <label for="isCumulitive">Cumulitive</label>
	  <input type="checkbox" id="isCumulitive"/>
	</div>
</div>
<div id="chatBox"><ul></ul></div>
<?php endif ?>

<div id="totalTime">Total Time: <span class="time"><?php echo outputSecondsToHumanFormat($log['elapsed_time']) ?></span></div>
     
<table id="statPanel" class="statTable" border="0" cellspacing="0" cellpadding="3">
  <thead>
    <tr>
      <th>Name</th>
      <th>Steam ID</th>
      <th title="Classes">C</th>
      <th title="Kills">K</th>
      <th title="Assists">A</th>
      <th title="Deaths">D</th>
      <th title="Kills+Assists/Death">KAPD</th>
      <th title="Damage">DA</th>
      <th title="Longest Kill Streak">LKS</th>
      <th title="Capture Points Blocked">CPB</th>
      <th title="Capture Points Captured">CPC</th>
      <th title="Dominations">DOM</th>
      <th title="Times Dominated">TDM</th>
      <th title="Revenges">R</th>
      <th title="Extinguishes">E</th>
      <th title="Healing">H</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($log['Stats'] as $stat): ?>
    <tr class="<?php echo $stat['team'] ?>">
      <td>
        <img src="/avatars/<?php echo $stat['Player']['id'] ?>.jpg" class="avatar avatarImage" id="avatar<?php echo $stat['Player']['id'] ?>"/>
        <?php echo link_to($stat['name'], 'player/showNumericSteamId?id='.$stat['Player']['numeric_steamid']) ?>
      </td>
      <td><?php echo $stat['Player']['steamid'] ?></td>
      <td>
        <ul>
          <?php foreach($stat['RoleStats'] as $rs): ?>
            <li><img src="<?php echo sfConfig::get('app_class_icon_base_url').'/'.$rs['Role']['key_name']?>.png" class="classIcon" title="<?php echo $rs['Role']['name'] ?> - <?php echo outputSecondsToHumanFormat($rs['time_played']) ?>" alt="<?php echo $rs['Role']['name'] ?> - <?php echo outputSecondsToHumanFormat($rs['time_played']) ?>"/></li>
          <?php endforeach ?>
        </ul>
      </td>
      <td class="<?php echo dataCellOutputClass($stat['kills']) ?>"><?php echo $stat['kills'] ?></td>
      <td class="<?php echo dataCellOutputClass($stat['assists']) ?>"><?php echo $stat['assists'] ?></td>
      <td class="<?php echo dataCellOutputClass($stat['deaths']) ?>"><?php echo $stat['deaths'] ?></td>
      <td class="<?php echo dataCellOutputClass(doPerDeathDivision($stat['kills']+$stat['assists'], $stat['deaths'])) ?>"><?php echo doPerDeathDivision($stat['kills']+$stat['assists'], $stat['deaths']) ?></td>
      <td class="<?php echo dataCellOutputClass($stat['damage']) ?>"><?php echo $stat['damage'] ?></td>
      <td class="<?php echo dataCellOutputClass($stat['longest_kill_streak']) ?>"><?php echo $stat['longest_kill_streak'] ?></td>
      <td class="<?php echo dataCellOutputClass($stat['capture_points_blocked']) ?>"><?php echo $stat['capture_points_blocked'] ?></td>
      <td class="<?php echo dataCellOutputClass($stat['capture_points_captured']) ?>"><?php echo $stat['capture_points_captured'] ?></td>
      <td class="<?php echo dataCellOutputClass($stat['dominations']) ?>"><?php echo $stat['dominations'] ?></td>
      <td class="<?php echo dataCellOutputClass($stat['times_dominated']) ?>"><?php echo $stat['times_dominated'] ?></td>
      <td class="<?php echo dataCellOutputClass($stat['revenges']) ?>"><?php echo $stat['revenges'] ?></td>
      <td class="<?php echo dataCellOutputClass($stat['extinguishes']) ?>"><?php echo $stat['extinguishes'] ?></td>
      <td class="<?php echo dataCellOutputClass($stat['healing']) ?>"><?php echo $stat['healing'] ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<table class="statTable" border="0" cellspacing="0" cellpadding="3">
  <caption>Medic Comparison</caption>
  <thead>
    <tr>
      <th>Name</th>
      <th title="Kills+Assists/Death">KAPD</th>
      <th title="Extinguishes">E</th>
      <th title="Ubers">U</th>
      <th title="Ubers/Death">UPD</th>
      <th title="Dropped Ubers">DU</th>
      <th title="Healing">H</th>
      <th title="Healing/Death">HPD</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($log['Stats'] as $stat): ?>
      <?php foreach($stat['RoleStats'] as $rs): ?>
        <?php if($rs['Role']['key_name'] == "medic" && $rs['time_played'] > 1): ?>
          <tr>
            <td>
              <img src="/avatars/<?php echo $stat['Player']['id'] ?>.jpg" class="avatar avatarImage" id="avatar<?php echo $stat['Player']['id'] ?>"/>
              <?php echo link_to($stat['name'], 'player/showNumericSteamId?id='.$stat['Player']['numeric_steamid']) ?>
            </td>
            <td class="<?php echo dataCellOutputClass(doPerDeathDivision($stat['kills']+$stat['assists'], $stat['deaths'])) ?>"><?php echo doPerDeathDivision($stat['kills']+$stat['assists'], $stat['deaths']) ?></td>
            <td class="<?php echo dataCellOutputClass($stat['extinguishes']) ?>"><?php echo $stat['extinguishes'] ?></td>
            <td class="<?php echo dataCellOutputClass($stat['ubers']) ?>"><?php echo $stat['ubers'] ?></td>
            <td class="<?php echo dataCellOutputClass(doPerDeathDivision($stat['ubers'], $stat['deaths'])) ?>"><?php echo doPerDeathDivision($stat['ubers'], $stat['deaths']) ?></td>
            <td class="<?php echo dataCellOutputClass($stat['dropped_ubers']) ?>"><?php echo $stat['dropped_ubers'] ?></td>
            <td class="<?php echo dataCellOutputClass($stat['healing']) ?>"><?php echo $stat['healing'] ?></td>
            <td class="<?php echo dataCellOutputClass(doPerDeathDivision($stat['healing'], $stat['deaths'])) ?>"><?php echo doPerDeathDivision($stat['healing'], $stat['deaths']) ?></td>
          </tr>
        <?php endif ?>
      <?php endforeach ?>
    <?php endforeach; ?>
  </tbody>
</table>

<table class="statTable" border="0" cellspacing="0" cellpadding="3">
  <caption>Weapon Stats</caption>
  <thead>
    <tr>
      <th><!--playername--></th>
      <?php foreach($weapons as $w): ?>
        <th colspan="3"><?php echo outputWeapon($w['name'], $w['key_name'], $w['image_name']) ?></th>
      <?php endforeach ?>
    </tr>
    <tr>
      <th><!--playername--></th>
      <?php foreach($weapons as $w): ?>
        <th title="Kills">K</th>
        <th title="Damage">DA</th>
        <th title="Deaths">D</th>
      <?php endforeach ?>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($log['Stats'] as $stat): ?>
    <tr>
      <td><img src="/avatars/<?php echo $stat['Player']['id'] ?>.jpg" class="avatarImage"/><?php echo link_to($stat['name'], 'player/showNumericSteamId?id='.$stat['Player']['numeric_steamid']) ?></td>
      <?php foreach($weapons as $w): ?>
        <?php $foundWS = false ?>
        <?php foreach($weaponStats as $ws): ?>
          <?php if($ws['stat_id'] == $stat['id'] && $ws['weapon_id'] == $w['id']): ?>
            <td class="<?php echo dataCellOutputClass($ws['num_kills']) ?>"><?php echo $ws['num_kills'] ?></td>
            <td class="<?php echo dataCellOutputClass($ws['num_damage']) ?>"><?php echo $ws['num_damage'] ?></td>
            <td class="<?php echo dataCellOutputClass($ws['num_deaths']) ?>"><?php echo $ws['num_deaths'] ?></td>
            <?php $foundWS = true ?>
            <?php break ?>
          <?php endif ?>
        <?php endforeach ?>
        <?php if(!$foundWS): ?>
          <td class="zeroValue">0</td>
          <td class="zeroValue">0</td>
          <td class="zeroValue">0</td>
        <?php endif ?>
      <?php endforeach ?>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<table class="statTable" id="playerStats" border="0" cellspacing="0" cellpadding="3">
  <caption>Player Stats</caption>
  <thead>
    <tr>
      <th><!--playername--></th>
      <?php foreach($log['Stats'] as $s): ?>
        <th>
          <a href="<?php echo url_for('player/showNumericSteamId?id='.$s['Player']['numeric_steamid']) ?>"><img src="/avatars/<?php echo $s['Player']['id'] ?>.jpg" class="avatarImage" title="<?php echo $s['name'] ?>"/></a>
        </th>
      <?php endforeach ?>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($log['Stats'] as $stat): ?>
    <tr>
      <td><img src="/avatars/<?php echo $stat['Player']['id'] ?>.jpg" class="avatarImage"/><?php echo link_to($stat['name'], 'player/showNumericSteamId?id='.$stat['Player']['numeric_steamid']) ?></td>
      <?php foreach($log['Stats'] as $colstat): ?>
        <?php $foundPS = false ?>
        <?php foreach($playerStats as $ps): ?>
          <?php if($ps['stat_id'] == $stat['id'] && $ps['player_id'] == $colstat['Player']['id']): ?>
            <td class="<?php echo dataCellOutputClass($ps['num_kills']) ?>"><?php echo $ps['num_kills'] ?></td>
            <?php $foundPS = true ?>
            <?php break ?>
          <?php endif ?>
        <?php endforeach ?>
        <?php if(!$foundPS): ?>
          <td class="zeroValue">0</td>
        <?php endif ?>
      <?php endforeach ?>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

Created  <?php echo $log['created_at'] ?><br/>
<?php if($log['created_at'] != $log['updated_at']): ?>
  Last Generated <?php echo $log['updated_at'] ?> 
<?php endif ?>

<?php if(mapExists($log['map_name'])): ?>
<script type="application/x-javascript">
var gameMapObj;
var mapViewerObj;

<?php echo outputPlayerCollection($log['Stats']); ?>

<?php echo outputWeaponCollection($weapons); ?>

/////////////////////////////////////////////////////////////////////////////////////
// Doc ready
/////////////////////////////////////////////////////////////////////////////////////
$(function (){  
	mvc = $("#mapViewerControls");
	mapViewerObj = new MapViewer(gameMapObj, playerCollection, logEventCollection, weaponCollection, $("#mapViewer"), mvc, $("#playPauseButton"), $("#playbackProgress"), $("#chatBox"), $("#playbackSpeed"), $("#isCumulitive"));
});
</script>
<?php endif ?>
<div id="canvasTooltip"></div>
