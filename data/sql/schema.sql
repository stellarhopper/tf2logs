CREATE TABLE log (id BIGINT AUTO_INCREMENT, name VARCHAR(100) NOT NULL, redscore INT DEFAULT 0 NOT NULL, bluescore INT DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE stat (id BIGINT AUTO_INCREMENT, log_id BIGINT NOT NULL, name VARCHAR(100) NOT NULL, steamid VARCHAR(30) NOT NULL, team VARCHAR(4) NOT NULL, kills INT DEFAULT 0 NOT NULL, assists INT DEFAULT 0 NOT NULL, deaths INT DEFAULT 0 NOT NULL, kills_per_death INT DEFAULT 0 NOT NULL, longest_kill_streak INT DEFAULT 0 NOT NULL, capture_points_blocked INT DEFAULT 0 NOT NULL, capture_points_captured INT DEFAULT 0 NOT NULL, dominations INT DEFAULT 0 NOT NULL, times_dominated INT DEFAULT 0 NOT NULL, revenges INT DEFAULT 0 NOT NULL, builtobjects INT DEFAULT 0 NOT NULL, destroyedobjects INT DEFAULT 0 NOT NULL, extinguishes INT DEFAULT 0 NOT NULL, ubers INT DEFAULT 0 NOT NULL, dropped_ubers INT DEFAULT 0 NOT NULL, ubers_per_death INT DEFAULT 0 NOT NULL, INDEX log_id_idx (log_id), PRIMARY KEY(id)) ENGINE = INNODB;
ALTER TABLE stat ADD CONSTRAINT stat_log_id_log_id FOREIGN KEY (log_id) REFERENCES log(id) ON DELETE CASCADE;
