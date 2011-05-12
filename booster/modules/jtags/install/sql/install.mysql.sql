
-- Tags
CREATE TABLE `%%PREFIX%%sc_tags` (
    `tag_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `tag_name` VARCHAR(50) NOT NULL,
    `nbuse` int(11) default '0',
    
    PRIMARY KEY pk_tag (`tag_id`),
    UNIQUE uk_tag (`tag_name`)
) ENGINE=MyISAM;

-- Tags in use
CREATE TABLE `%%PREFIX%%sc_tags_tagged` (
    `tt_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `tag_id` INT UNSIGNED NOT NULL,
    `tt_scope_id` VARCHAR(50) NOT NULL,    -- 'snippet' or 'application'
    `tt_subject_id` INt UNSIGNED NOT NULL,  -- sc_snippets::sn_id or sc_apps::app_id

    PRIMARY KEY pk_tt (`tt_id`),
    INDEX idx1_tt (`tt_scope_id`, `tt_subject_id`),
    INDEX idx2_tt (`tag_id`)
    
) ENGINE=MyISAM;
