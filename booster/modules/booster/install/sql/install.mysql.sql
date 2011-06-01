CREATE TABLE %%PREFIX%%boo_items (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `item_info_id` varchar(100) NOT NULL,
  `short_desc` varchar(255) NOT NULL,
  `type_id` int(12) NOT NULL,
  `url_website` varchar(255) NOT NULL,
  `url_repo` varchar(255) NOT NULL,
  `author` varchar(80) NOT NULL,
  `item_by` int(12) NOT NULL,
  `status` int(1) NOT NULL,
  `created` datetime NOT NULL,
  `edited` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_by` (`item_by`),
  KEY `type_id` (`type_id`),
  KEY `status` (`status`),
  KEY `created` (`created`),
  KEY `edited` (`edited`),
  KEY `modified` (`modified`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



CREATE TABLE %%PREFIX%%boo_type (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    `type_name` VARCHAR( 80 ) NOT NULL
) ENGINE = MYISAM DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS %%PREFIX%%boo_versions (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(12) NOT NULL,
  `status` int(1) NOT NULL,
  `version_name` varchar(80) NOT NULL,
  `last_changes` varchar(255) NOT NULL,
  `stability` enum('pre-alpha','alpha','stable','mature') NOT NULL DEFAULT 'stable',
  `filename` varchar(80) NOT NULL,
  `download_url` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `edited` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `status` (`status`),
  KEY `created` (`created`),
  KEY `edited` (`edited`),
  KEY `modified` (`modified`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;




-- --------------------------------------------------------

--
-- Structure de la table `boo_versions_mod`
--

CREATE TABLE IF NOT EXISTS %%PREFIX%%boo_versions_mod (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(12) NOT NULL,
  `status` int(1) NOT NULL,
  `version_name` varchar(80) NOT NULL,
  `last_changes` varchar(255) NOT NULL,
  `stability` enum('pre-alpha','alpha','stable','mature') NOT NULL DEFAULT 'stable',
  `filename` varchar(80) NOT NULL,
  `download_url` varchar(255) NOT NULL,
  `created` datetime DEFAULT NULL,
  `edited` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `status` (`status`),
  KEY `created` (`created`),
  KEY `edited` (`edited`),
  KEY `modified` (`modified`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


--
-- Structure de la table `boo_items_jelix_versions`
--

CREATE TABLE IF NOT EXISTS %%PREFIX%%boo_items_jelix_versions (
  `id_item` int(11) NOT NULL,
  `id_version` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id_item`,`id_version`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Structure de la table `boo_jelix_versions`
--

CREATE TABLE IF NOT EXISTS %%PREFIX%%boo_jelix_versions (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `boo_jelix_versions`
--

INSERT INTO %%PREFIX%%boo_jelix_versions (`id`, `version`) VALUES
(1, 'Jelix 1.1'),
(2, 'Jelix 1.2'),
(3, 'Jelix 1.3'),
(4, 'trunk');
