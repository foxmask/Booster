

ALTER TABLE `boo_items` ADD `recommendation` BOOLEAN NOT NULL DEFAULT false AFTER `status`;

ALTER TABLE `boo_items_mod` ADD `recommendation` BOOLEAN NOT NULL DEFAULT false AFTER `status`;