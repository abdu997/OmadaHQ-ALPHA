CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(60) NOT NULL,
  `password` varchar(150) NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `status` varchar(45) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_id_UNIQUE` (`user_id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=01 DEFAULT CHARSET=latin1;

CREATE TABLE `password_reset` (
  `request_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `user_email` varchar(45) DEFAULT NULL,
  `token` varchar(45) DEFAULT NULL,
  `timestamp` varchar(45) DEFAULT NULL,
  `expiration` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`request_id`)
) ENGINE=InnoDB AUTO_INCREMENT=01 DEFAULT CHARSET=latin1;

CREATE TABLE `team` (
  `team_id` int(11) NOT NULL AUTO_INCREMENT,
  `team_name` varchar(45) NOT NULL,
  `type` varchar(45) NOT NULL,
  `plan` varchar(45) NOT NULL,
  PRIMARY KEY (`team_id`),
  UNIQUE KEY `team_id_UNIQUE` (`team_id`)
) ENGINE=InnoDB AUTO_INCREMENT=01 DEFAULT CHARSET=latin1;

CREATE TABLE `team_user` (
  `team_connect_id` int(11) NOT NULL AUTO_INCREMENT,
  `team_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `admin` varchar(1) NOT NULL,
  PRIMARY KEY (`team_connect_id`),
  UNIQUE KEY `team_connect_id_UNIQUE` (`team_connect_id`)
) ENGINE=InnoDB AUTO_INCREMENT=01 DEFAULT CHARSET=latin1;

CREATE TABLE `team_nonuser` (
  `confirmation_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(45) NOT NULL,
  `team_id` int(11) NOT NULL,
  `admin` varchar(1) NOT NULL,
  `status` varchar(45) NOT NULL,
  PRIMARY KEY (`confirmation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=01 DEFAULT CHARSET=latin1;

CREATE TABLE `pert_table` (
  `record_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `team_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `start_message` varchar(255) DEFAULT NULL,
  `start_time` date DEFAULT NULL,
  `end_time` date DEFAULT NULL,
  `expected_time` int(11) DEFAULT NULL,
  `optimistic_time` int(11) DEFAULT NULL,
  `realistic_time` int(11) DEFAULT NULL,
  `pessimistic_time` int(11) DEFAULT NULL,
  `goal_id` int(11) DEFAULT NULL,
  `task_id` int(11) DEFAULT NULL,
  `color` varchar(10) DEFAULT NULL,
  `progress` varchar(20) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`record_id`),
  UNIQUE KEY `record_id_UNIQUE` (`record_id`)
) ENGINE=InnoDB AUTO_INCREMENT=01 DEFAULT CHARSET=latin1;