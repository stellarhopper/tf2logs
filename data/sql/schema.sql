CREATE TABLE event (id BIGINT AUTO_INCREMENT, log_id BIGINT NOT NULL, event_type VARCHAR(10) NOT NULL, elapsed_seconds INT NOT NULL, attacker_player_id BIGINT, attacker_coord VARCHAR(17), victim_player_id BIGINT, victim_coord VARCHAR(17), assist_player_id BIGINT, assist_coord VARCHAR(17), chat_player_id BIGINT, text VARCHAR(255), team VARCHAR(4), capture_point VARCHAR(30), blue_score SMALLINT, red_score SMALLINT, weapon_id BIGINT, INDEX log_id_idx (log_id), INDEX attacker_player_id_idx (attacker_player_id), INDEX victim_player_id_idx (victim_player_id), INDEX assist_player_id_idx (assist_player_id), INDEX chat_player_id_idx (chat_player_id), INDEX weapon_id_idx (weapon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;
CREATE TABLE event_player (id BIGINT AUTO_INCREMENT, event_id BIGINT NOT NULL, event_player_type VARCHAR(1) NOT NULL, player_id BIGINT NOT NULL, INDEX player_id_idx (player_id), INDEX event_id_idx (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;
CREATE TABLE item_pickup_stat (id BIGINT AUTO_INCREMENT, stat_id BIGINT, item_key_name VARCHAR(20) NOT NULL, times_picked_up SMALLINT DEFAULT 0 NOT NULL, PRIMARY KEY(id, stat_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;
CREATE TABLE log (id BIGINT AUTO_INCREMENT, name VARCHAR(100) NOT NULL, redscore SMALLINT DEFAULT 0 NOT NULL, bluescore SMALLINT DEFAULT 0 NOT NULL, elapsed_time BIGINT DEFAULT 0 NOT NULL, game_seconds INT DEFAULT 0 NOT NULL, map_name VARCHAR(25), submitter_player_id BIGINT, error_log_name VARCHAR(50), error_exception TEXT, views INT DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX submitter_player_id_idx (submitter_player_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;
CREATE TABLE log_file (log_id BIGINT, log_data MEDIUMTEXT NOT NULL, PRIMARY KEY(log_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;
CREATE TABLE log_line (id BIGINT AUTO_INCREMENT, line_year SMALLINT NOT NULL, line_month TINYINT NOT NULL, line_day TINYINT NOT NULL, line_hour TINYINT NOT NULL, line_minute TINYINT NOT NULL, line_second TINYINT NOT NULL, created_at DATETIME NOT NULL, server_ip VARCHAR(15) NOT NULL, server_port SMALLINT UNSIGNED NOT NULL, line_data TEXT, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;
CREATE TABLE player (id BIGINT AUTO_INCREMENT, numeric_steamid BIGINT UNIQUE NOT NULL, steamid VARCHAR(30) NOT NULL UNIQUE, credential VARCHAR(10) DEFAULT 'user' NOT NULL, name VARCHAR(100), last_login DATETIME, views INT DEFAULT 0, avatar_url VARCHAR(75), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;
CREATE TABLE player_heal_stat (player_id BIGINT, stat_id BIGINT, healing MEDIUMINT DEFAULT 0 NOT NULL, PRIMARY KEY(player_id, stat_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;
CREATE TABLE player_stat (player_id BIGINT, stat_id BIGINT, kills SMALLINT DEFAULT 0 NOT NULL, deaths SMALLINT DEFAULT 0 NOT NULL, PRIMARY KEY(player_id, stat_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;
CREATE TABLE role (id BIGINT AUTO_INCREMENT, key_name VARCHAR(12) NOT NULL, name VARCHAR(20), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;
CREATE TABLE role_stat (role_id BIGINT, stat_id BIGINT, time_played BIGINT DEFAULT 0 NOT NULL, PRIMARY KEY(role_id, stat_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;
CREATE TABLE server (id BIGINT AUTO_INCREMENT, slug VARCHAR(30), name VARCHAR(100), ip VARCHAR(15) NOT NULL, port SMALLINT UNSIGNED NOT NULL, server_group_id BIGINT NOT NULL, last_message DATETIME, verify_key VARCHAR(20), status VARCHAR(1) DEFAULT 'N' NOT NULL, INDEX server_group_id_idx (server_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;
CREATE TABLE server_group (id BIGINT AUTO_INCREMENT, slug VARCHAR(30) NOT NULL UNIQUE, name VARCHAR(100) NOT NULL, owner_id BIGINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;
CREATE TABLE session (id VARCHAR(32), sdata TEXT NOT NULL, stime INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;
CREATE TABLE stat (id BIGINT AUTO_INCREMENT, log_id BIGINT NOT NULL, name VARCHAR(100) NOT NULL, player_id BIGINT NOT NULL, team VARCHAR(4) NOT NULL, kills SMALLINT DEFAULT 0 NOT NULL, assists SMALLINT DEFAULT 0 NOT NULL, deaths SMALLINT DEFAULT 0 NOT NULL, damage SMALLINT DEFAULT 0 NOT NULL, longest_kill_streak SMALLINT DEFAULT 0 NOT NULL, headshots SMALLINT DEFAULT 0 NOT NULL, backstabs SMALLINT DEFAULT 0 NOT NULL, capture_points_blocked SMALLINT DEFAULT 0 NOT NULL, capture_points_captured SMALLINT DEFAULT 0 NOT NULL, flag_defends SMALLINT DEFAULT 0 NOT NULL, flag_captures SMALLINT DEFAULT 0 NOT NULL, dominations SMALLINT DEFAULT 0 NOT NULL, times_dominated SMALLINT DEFAULT 0 NOT NULL, revenges SMALLINT DEFAULT 0 NOT NULL, extinguishes SMALLINT DEFAULT 0 NOT NULL, ubers SMALLINT DEFAULT 0 NOT NULL, dropped_ubers SMALLINT DEFAULT 0 NOT NULL, healing MEDIUMINT DEFAULT 0 NOT NULL, INDEX name_idx_idx (name), INDEX log_id_idx (log_id), INDEX player_id_idx (player_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;
CREATE TABLE track (id BIGINT AUTO_INCREMENT, url VARCHAR(255) NOT NULL UNIQUE, hits INT DEFAULT 0 NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;
CREATE TABLE weapon (id BIGINT AUTO_INCREMENT, key_name VARCHAR(40) NOT NULL UNIQUE, name VARCHAR(40), role_id BIGINT, image_name VARCHAR(50), INDEX role_id_idx (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;
CREATE TABLE weapon_stat (weapon_id BIGINT, stat_id BIGINT, kills SMALLINT DEFAULT 0 NOT NULL, deaths SMALLINT DEFAULT 0 NOT NULL, PRIMARY KEY(weapon_id, stat_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;
ALTER TABLE event ADD CONSTRAINT event_weapon_id_weapon_id FOREIGN KEY (weapon_id) REFERENCES weapon(id) ON DELETE CASCADE;
ALTER TABLE event ADD CONSTRAINT event_victim_player_id_player_id FOREIGN KEY (victim_player_id) REFERENCES player(id);
ALTER TABLE event ADD CONSTRAINT event_log_id_log_id FOREIGN KEY (log_id) REFERENCES log(id) ON DELETE CASCADE;
ALTER TABLE event ADD CONSTRAINT event_chat_player_id_player_id FOREIGN KEY (chat_player_id) REFERENCES player(id);
ALTER TABLE event ADD CONSTRAINT event_attacker_player_id_player_id FOREIGN KEY (attacker_player_id) REFERENCES player(id);
ALTER TABLE event ADD CONSTRAINT event_assist_player_id_player_id FOREIGN KEY (assist_player_id) REFERENCES player(id);
ALTER TABLE event_player ADD CONSTRAINT event_player_player_id_player_id FOREIGN KEY (player_id) REFERENCES player(id) ON DELETE CASCADE;
ALTER TABLE event_player ADD CONSTRAINT event_player_event_id_event_id FOREIGN KEY (event_id) REFERENCES event(id) ON DELETE CASCADE;
ALTER TABLE item_pickup_stat ADD CONSTRAINT item_pickup_stat_stat_id_stat_id FOREIGN KEY (stat_id) REFERENCES stat(id) ON DELETE CASCADE;
ALTER TABLE log ADD CONSTRAINT log_submitter_player_id_player_id FOREIGN KEY (submitter_player_id) REFERENCES player(id);
ALTER TABLE player_heal_stat ADD CONSTRAINT player_heal_stat_stat_id_stat_id FOREIGN KEY (stat_id) REFERENCES stat(id) ON DELETE CASCADE;
ALTER TABLE player_heal_stat ADD CONSTRAINT player_heal_stat_player_id_player_id FOREIGN KEY (player_id) REFERENCES player(id);
ALTER TABLE player_stat ADD CONSTRAINT player_stat_stat_id_stat_id FOREIGN KEY (stat_id) REFERENCES stat(id) ON DELETE CASCADE;
ALTER TABLE player_stat ADD CONSTRAINT player_stat_player_id_player_id FOREIGN KEY (player_id) REFERENCES player(id);
ALTER TABLE role_stat ADD CONSTRAINT role_stat_stat_id_stat_id FOREIGN KEY (stat_id) REFERENCES stat(id) ON DELETE CASCADE;
ALTER TABLE role_stat ADD CONSTRAINT role_stat_role_id_role_id FOREIGN KEY (role_id) REFERENCES role(id);
ALTER TABLE server ADD CONSTRAINT server_server_group_id_server_group_id FOREIGN KEY (server_group_id) REFERENCES server_group(id) ON DELETE CASCADE;
ALTER TABLE stat ADD CONSTRAINT stat_player_id_player_id FOREIGN KEY (player_id) REFERENCES player(id);
ALTER TABLE stat ADD CONSTRAINT stat_log_id_log_id FOREIGN KEY (log_id) REFERENCES log(id) ON DELETE CASCADE;
ALTER TABLE weapon ADD CONSTRAINT weapon_role_id_role_id FOREIGN KEY (role_id) REFERENCES role(id);
ALTER TABLE weapon_stat ADD CONSTRAINT weapon_stat_weapon_id_weapon_id FOREIGN KEY (weapon_id) REFERENCES weapon(id);
ALTER TABLE weapon_stat ADD CONSTRAINT weapon_stat_stat_id_stat_id FOREIGN KEY (stat_id) REFERENCES stat(id) ON DELETE CASCADE;
