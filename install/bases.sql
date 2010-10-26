
CREATE TABLE `$__comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `files_id` int(11) NOT NULL,
  `notation` text NOT NULL,
  `data` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1;

CREATE TABLE `$__comments_tree` (
  `item_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  PRIMARY KEY (`item_id`)
) TYPE=MyISAM;

CREATE TABLE `$__files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `data` timestamp NOT NULL,
  `ip` varchar(15) NOT NULL,
  `agent` text NOT NULL,
  PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1;

CREATE TABLE `$__files_param` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `files_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `comment` tinyint(1) NOT NULL,
  `visibly` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1;

CREATE TABLE `$__users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1;

INSERT INTO `$__users` (`id`, `email`, `password`) VALUES
(1, 'guest', 'guest'),
(2, 'test@tut.com', '25d55ad283aa400af464c76d713c07ad');