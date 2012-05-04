--
-- Structure de la table `boo_items_modifs`
--
DROP TABLE `%%PREFIX%%boo_items_mod`;
DROP TABLE `%%PREFIX%%boo_versions_mod`;


CREATE TABLE IF NOT EXISTS `%%PREFIX%%boo_items_modifs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `field` varchar(40) NOT NULL,
  `old_value` text NOT NULL,
  `new_value` text NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Structure de la table `boo_versions_modifs`
--

CREATE TABLE IF NOT EXISTS `%%PREFIX%%boo_versions_modifs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `version_id` int(11) NOT NULL,
  `field` varchar(40) NOT NULL,
  `old_value` varchar(255) NOT NULL,
  `new_value` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;