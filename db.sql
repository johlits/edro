SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `rpg_chars` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `isplayer` int(1) NOT NULL DEFAULT 0,
  `target` int(11) NOT NULL DEFAULT 0,
  `lvl` int(11) NOT NULL DEFAULT 1,
  `exp` int(11) NOT NULL DEFAULT 0,
  `maxhp` int(11) NOT NULL DEFAULT 100,
  `hp` int(11) NOT NULL DEFAULT 100,
  `maxmp` int(11) NOT NULL DEFAULT 100,
  `mp` int(11) NOT NULL DEFAULT 100,
  `maxstamina` int(11) NOT NULL DEFAULT 2400,
  `stamina` int(11) NOT NULL DEFAULT 2400,
  `atk` int(11) NOT NULL DEFAULT 10,
  `def` int(11) NOT NULL DEFAULT 10,
  `spd` int(11) NOT NULL DEFAULT 10,
  `evd` int(11) NOT NULL DEFAULT 10,
  `weapon` int(11) NOT NULL DEFAULT 0,
  `body` int(11) NOT NULL DEFAULT 0,
  `legs` int(11) NOT NULL DEFAULT 0,
  `cape` int(11) NOT NULL DEFAULT 0,
  `current_room` int(11) NOT NULL DEFAULT 1,
  `gold` int(11) NOT NULL DEFAULT 0,
  `sp` int(11) NOT NULL DEFAULT 0,
  `hp_v1` int(11) NOT NULL DEFAULT 10,
  `mp_v1` int(11) NOT NULL DEFAULT 10,
  `role` varchar(16) NOT NULL DEFAULT '',
  `atp` int(11) NOT NULL DEFAULT 0,
  `int_stat` int(11) NOT NULL DEFAULT 0,
  `fire_res` int(11) NOT NULL DEFAULT 0,
  `water_res` int(11) NOT NULL DEFAULT 0,
  `ground_res` int(11) NOT NULL DEFAULT 0,
  `wind_res` int(11) NOT NULL DEFAULT 0,
  `light_res` int(11) NOT NULL DEFAULT 0,
  `dark_res` int(11) NOT NULL DEFAULT 0,
  `follow` int(11) NOT NULL DEFAULT 0,
  `cp` int(11) NOT NULL DEFAULT 0,
  `auto_cp` int(11) NOT NULL DEFAULT 1,
  `ring` int(11) NOT NULL DEFAULT 0,
  `owner` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `rpg_classes` (
  `id` int(11) NOT NULL,
  `charid` int(11) NOT NULL,
  `class` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `rpg_commands` (
  `id` int(11) NOT NULL,
  `cdate` datetime NOT NULL,
  `name` varchar(128) NOT NULL,
  `action` varchar(128) NOT NULL,
  `p1` varchar(128) DEFAULT NULL,
  `p2` varchar(128) DEFAULT NULL,
  `result` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `rpg_connections` (
  `id` int(11) NOT NULL,
  `from_room` int(11) NOT NULL,
  `to_room` int(11) NOT NULL,
  `lvlcap` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `rpg_items` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `type` int(11) NOT NULL,
  `inroom` tinyint(1) NOT NULL,
  `ownerid` int(11) NOT NULL,
  `atk` int(11) NOT NULL,
  `def` int(11) NOT NULL,
  `spd` int(11) NOT NULL,
  `evd` int(11) NOT NULL,
  `price` int(11) NOT NULL DEFAULT -1,
  `lvl` int(11) NOT NULL DEFAULT 1,
  `hp` int(11) NOT NULL DEFAULT 0,
  `mp` int(11) NOT NULL DEFAULT 0,
  `int_stat` int(11) NOT NULL DEFAULT 0,
  `fire_res` int(11) NOT NULL DEFAULT 0,
  `water_res` int(11) NOT NULL DEFAULT 0,
  `ground_res` int(11) NOT NULL DEFAULT 0,
  `wind_res` int(11) NOT NULL DEFAULT 0,
  `light_res` int(11) NOT NULL DEFAULT 0,
  `dark_res` int(11) NOT NULL DEFAULT 0,
  `classreq` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `rpg_pets` (
  `id` int(11) NOT NULL,
  `ownerid` int(11) NOT NULL,
  `petid` int(11) NOT NULL,
  `cost` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `rpg_rooms` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` int(11) NOT NULL DEFAULT 0,
  `description` varchar(1023) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `rpg_saves` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `exp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `rpg_server` (
  `id` int(11) NOT NULL,
  `sdate` datetime NOT NULL,
  `sname` varchar(512) NOT NULL,
  `sweather` varchar(512) NOT NULL,
  `sday` int(11) NOT NULL DEFAULT 1,
  `helplink` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `rpg_patches` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `pdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `rpg_skills` (
  `id` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `cid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `rpg_switches` (
  `id` int(11) NOT NULL,
  `goto_room` int(11) NOT NULL,
  `s1` int(11) NOT NULL DEFAULT -1,
  `s2` int(11) NOT NULL DEFAULT -1,
  `s3` int(11) NOT NULL DEFAULT -1,
  `s4` int(11) NOT NULL DEFAULT -1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `rpg_server` (`id`, `sdate`, `sname`, `sweather`, `sday`, `helplink`) VALUES
(1, '2020-06-15 00:00:00', 'Arsta', 'Rain', 0, 'https://palplanner.com/blog/rpg-tutorial/');

ALTER TABLE `rpg_chars`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `rpg_classes`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `rpg_commands`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `rpg_connections`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `rpg_items`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `rpg_pets`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `rpg_rooms`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `rpg_saves`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

ALTER TABLE `rpg_server`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `rpg_skills`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sid` (`sid`,`cid`);
  
ALTER TABLE `rpg_patches`
  ADD PRIMARY KEY (`id`);
  
ALTER TABLE `rpg_switches`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `rpg_chars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `rpg_classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `rpg_commands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `rpg_connections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `rpg_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `rpg_pets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `rpg_rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `rpg_saves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `rpg_server`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `rpg_skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
  
ALTER TABLE `rpg_patches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
  
ALTER TABLE `rpg_switches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;
