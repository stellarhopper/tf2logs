<?php

/**
 * PlayerTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class PlayerTable extends Doctrine_Table {
  /**
   * Returns an instance of this class.
   *
   * @return object PlayerTable
   */
  public static function getInstance() {
      return Doctrine_Core::getTable('Player');
  }
    
  public function getPlayerStatsByNumericSteamid($id) {
    $p = Doctrine_Query::create()
      ->select('p.*'
        .', count(s.id) as num_matches'
        .', sum(s.kills) as kills'
        .', sum(s.assists) as assists'
        .', sum(s.deaths) as deaths'
        .', round((sum(s.kills)+sum(s.assists))/sum(s.deaths), 3) as killsassists_per_death'
        .', max(s.longest_kill_streak) as longest_kill_streak'
        .', sum(s.headshots) as headshots'
        .', sum(s.backstabs) as backstabs'
        .', sum(s.capture_points_blocked) as capture_points_blocked'
        .', sum(s.capture_points_captured) as capture_points_captured'
        .', sum(s.flag_defends) as flag_defends'
        .', sum(s.flag_captures) as flag_captures'
        .', sum(s.dominations) as dominations'
        .', sum(s.times_dominated) as times_dominated'
        .', sum(s.revenges) as revenges'
        .', sum(s.extinguishes) as extinguishes'
        .', sum(s.ubers) as ubers'
        .', round(sum(s.ubers)/sum(s.deaths), 3) as ubers_per_death'
        .', sum(s.dropped_ubers) as dropped_ubers'
        .', sum(s.healing) as healing'
      )
      ->from('Player p')
      ->leftJoin('p.Stats s')
      ->where('p.numeric_steamid = ?', $id)
      ->groupBy('p.numeric_steamid')
      ->execute();
      
    if(count($p) == 0) return null;
    return $p[0]; //returns doctrine_collection obj, we only want first (all we should get)
  }
  
  public function getPlayerRolesByNumericSteamid($id) {
    $connection = Doctrine_Manager::connection();
    $query = 'SELECT p.id, r.name, r.key_name, COUNT( rs.role_id ) as num_times, sum(time_played) as time_played '
      .'FROM  role_stat rs '
      .'INNER JOIN stat s ON rs.stat_id = s.id '
      .'INNER JOIN player p ON p.id = s.player_id '
      .'INNER JOIN role r ON r.id = rs.role_id '
      .'WHERE p.numeric_steamid = ? '
      .'GROUP BY p.id, r.name '
      .'ORDER BY num_times DESC ';
    $statement = $connection->execute($query, array($id));
    $ret = array();
    while($row = $statement->fetch(PDO::FETCH_OBJ)) {
      $ret[] = $row;
    }
    return $ret;
  }
  
  public function findPlayerForGivenNamePartialQuery($name) {
    return $this
        ->createQuery('p')
        ->leftJoin('p.Stats s')
        ->where('s.name LIKE ?', '%'.$name.'%')
        ->orderBy('s.name asc');
  }
  
  public function getTopUploaders($num_to_retrieve = 10) {
    $connection = Doctrine_Manager::connection();
    $query = 'select p.numeric_steamid as numeric_steamid, p.name as name, count(l.submitter_player_id) as num_logs '
      .'from log l '
      .'left join player p on l.submitter_player_id = p.id '
      .'group by p.numeric_steamid, p.name '
      .'having num_logs > 0 '
      .'limit 0, '.$num_to_retrieve;
    $statement = $connection->execute($query);
    $ret = array();
    while($row = $statement->fetch(PDO::FETCH_OBJ)) {
      $ret[] = $row;
    }
    return $ret;
  }
    
  public function incrementViews($id, $increment = 1) {
    return Doctrine_Query::create()
      ->update('Player')
      ->set('views', 'views + ?', $increment)
      ->where('numeric_steamid = ?', $id)
      ->execute();
  }
}
