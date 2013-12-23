<?php
if (!defined('_MYSQL_ENGINE_')) {
    define(_MYSQL_ENGINE_, 'MyISAM');
}
//execute all queries :


$db = Db::getInstance();
$queries = array();

//install publication table :
$queries[] = "CREATE TABLE IF NOT EXISTS `" . _DB_PREFIX_ . "lofblogs_publication` (
              `id_lofblogs_publication` int(10) NOT NULL auto_increment,
              `date_add` date default NULL,
              `status` enum('published','drafted','suspended') default NULL,
              `date_upd` date default NULL,
              `created_by` smallint(3) NOT NULL,
              `updated_by` smallint(3) NOT NULL,
              `image` varchar(255) default NULL,
              `position` int(10) NOT NULL default '0',
              `id_lofblogs_category` int(10) NOT NULL default '1',
              `id_author` mediumint(4) NOT NULL,
              `featured` tinyint(1) NOT NULL default '0',
              `hits` int(11) NOT NULL default '0',
              `rating` tinyint(1) NOT NULL default '0',
              `rating_num` int(11) NOT NULL default '0',
              `rating_point` int(11) NOT NULL default '0',
			  `access` varchar(255) default NULL,
              PRIMARY KEY  (`id_lofblogs_publication`)
            ) ENGINE=" . _MYSQL_ENGINE_ . "  DEFAULT CHARSET=utf8;";

$queries[] = "CREATE TABLE IF NOT EXISTS `" . _DB_PREFIX_ . "lofblogs_publication_lang` (
              `id_lang` int(10) NOT NULL,
              `id_lofblogs_publication` int(10) NOT NULL,
              `title` varchar(255) NOT NULL,
              `content` text NOT NULL,
              `excerpt` text,
              `link_rewrite` varchar(128) default NULL,
              `short_desc` text,
              `meta_title` varchar(255) default NULL,
              `meta_keywords` varchar(255) default NULL,
              `meta_description` varchar(255) default NULL,
              PRIMARY KEY (`id_lang`,`id_lofblogs_publication`)
            ) ENGINE=" . _MYSQL_ENGINE_ . " DEFAULT CHARSET=utf8;";

//install category table :
$queries[] = "CREATE TABLE IF NOT EXISTS `" . _DB_PREFIX_ . "lofblogs_categories` (
              `id_lofblogs_publication` int(10) unsigned NOT NULL,
              `id_lofblogs_category` int(10) unsigned NOT NULL,
              PRIMARY KEY  (`id_lofblogs_publication`,`id_lofblogs_category`),
              KEY `id_lofblogs` (`id_lofblogs_publication`)
            ) ENGINE=" . _MYSQL_ENGINE_ . " DEFAULT CHARSET=utf8;";

$queries[] = "CREATE TABLE IF NOT EXISTS `" . _DB_PREFIX_ . "lofblogs_category` (
              `id_lofblogs_category` int(10) NOT NULL auto_increment,
              `id_parent` int(10) NOT NULL,
              `level_depth` tinyint(3) NOT NULL default '0',
              `active` tinyint(1) NOT NULL default '1',
              `position` int(10) NOT NULL default '0',
              `image` varchar(255) default NULL,
              `template` varchar(255) default NULL,
              PRIMARY KEY  (`id_lofblogs_category`)
            ) ENGINE=" . _MYSQL_ENGINE_ . "  DEFAULT CHARSET=utf8;";

$queries[] = "CREATE TABLE IF NOT EXISTS `" . _DB_PREFIX_ . "lofblogs_category_lang` (
              `id_lofblogs_category` int(10) NOT NULL,
              `id_lang` int(10) NOT NULL,
              `name` varchar(255) NOT NULL,
              `link_rewrite` varchar(128) default NULL,
              `short_desc` text,
              `description` text,
              `meta_title` varchar(128) default NULL,
              `meta_keywords` varchar(255) default NULL,
              `meta_description` varchar(255) default NULL,
              PRIMARY KEY (`id_lofblogs_category`,`id_lang`)
            ) ENGINE=" . _MYSQL_ENGINE_ . " DEFAULT CHARSET=utf8;";
//install comment table : 
$queries[] = "CREATE TABLE IF NOT EXISTS `" . _DB_PREFIX_ . "lofblogs_comment` (
              `id` int(11) NOT NULL auto_increment,
              `item_id` int(11) NOT NULL,
              `name` varchar(255) NOT NULL,
              `content` text NOT NULL,
              `email` varchar(255) NOT NULL,
              `website` varchar(255) NOT NULL,
              `date_add` datetime default NULL,
              `published` tinyint(1) NOT NULL default '0',
              `vote_up` mediumint(5) NOT NULL default '0',
              `vote_down` mediumint(5) NOT NULL default '0',
              PRIMARY KEY  (`id`)
            ) ENGINE=" . _MYSQL_ENGINE_ . " DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$queries[] = "CREATE TABLE IF NOT EXISTS `" . _DB_PREFIX_ . "lofblogs_comment_clients` (
              `id` int(11) NOT NULL auto_increment,
              `comment_id` int(11) NOT NULL,
              `client_ip` varchar(255) NOT NULL,
              PRIMARY KEY  (`id`)
            ) ENGINE=" . _MYSQL_ENGINE_ . " DEFAULT CHARSET=utf8;";

$queries[] = "CREATE TABLE IF NOT EXISTS `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` (
              `id` mediumint(5) NOT NULL auto_increment,
              `filename` varchar(255) NOT NULL,
              `key` varchar(255) NOT NULL,
              PRIMARY KEY  (`id`)
            ) ENGINE=" . _MYSQL_ENGINE_ . " DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
$queries[] = "CREATE TABLE IF NOT EXISTS `" . _DB_PREFIX_ . "lofblogs_rate_clients` (
               `id` int(11) NOT NULL auto_increment,
              `itemid` int(11) NOT NULL,
              `client_ip` varchar(255) NOT NULL,
              PRIMARY KEY  (`id`)
            ) ENGINE=" . _MYSQL_ENGINE_ . " DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$queries[] = "CREATE TABLE IF NOT EXISTS `" . _DB_PREFIX_ . "lofblogs_blocks` (
                `id_lofblogs_blocks` int(11) NOT NULL AUTO_INCREMENT,
                `position` varchar(255) NOT NULL,
                `published` tinyint(1) NOT NULL DEFAULT '1',
                `template` varchar(255) NOT NULL,
                `ordering` int(11) NOT NULL DEFAULT '0',
                PRIMARY KEY (`id_lofblogs_blocks`)
            ) ENGINE=" . _MYSQL_ENGINE_ . " DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$queries[] = "CREATE TABLE IF NOT EXISTS `" . _DB_PREFIX_ . "lofblogs_blocks_lang` (
                `id_lofblogs_blocks` int(11) NOT NULL,
                `title` varchar(255) NOT NULL,
                `content` text,
                `id_lang` int(11) NOT NULL,
        PRIMARY KEY  (`id_lofblogs_blocks`,`id_lang`)
            ) ENGINE=" . _MYSQL_ENGINE_ . " DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$queries[] = "CREATE TABLE IF NOT EXISTS `" . _DB_PREFIX_ . "lofblogs_publication_product` (
              `id_lofblogs_publication` int(11) NOT NULL,
              `id_product` int(11) NOT NULL,
              PRIMARY KEY (`id_lofblogs_publication`,`id_product`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$queries[] = "CREATE TABLE IF NOT EXISTS `" . _DB_PREFIX_ . "lofblogs_tag` (
              `id_lofblogs_tag` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `id_lang` int(11) unsigned NOT NULL,
              `name` varchar(32) NOT NULL,
              PRIMARY KEY (`id_lofblogs_tag`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;";

$queries[] = "CREATE TABLE IF NOT EXISTS `" . _DB_PREFIX_ . "lofblogs_tag_article` (
            `id_lofblogs_tag` int(11) NOT NULL,
            `id_lofblogs_publication` int(11) NOT NULL,
            PRIMARY KEY (`id_lofblogs_tag`,`id_lofblogs_publication`)
          ) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

//install some default values :

$queries[] = "DELETE FROM `" . _DB_PREFIX_ . "lofblogs_category` WHERE `" . _DB_PREFIX_ . "lofblogs_category`.`id_lofblogs_category` = 2 LIMIT 1;";
$queries[] = "DELETE FROM `" . _DB_PREFIX_ . "lofblogs_category` WHERE `" . _DB_PREFIX_ . "lofblogs_category`.`id_lofblogs_category` = 1 LIMIT 1;";
$langs = Language::getLanguages(false);
if($langs)
	foreach($langs as $lang){
		$queries[] = "DELETE FROM `" . _DB_PREFIX_ . "lofblogs_category_lang` WHERE `" . _DB_PREFIX_ . "lofblogs_category_lang`.`id_lofblogs_category` = 2 AND `" . _DB_PREFIX_ . "lofblogs_category_lang`.`id_lang` = ".(int)$lang['id_lang']." LIMIT 1;";
		$queries[] = "DELETE FROM `" . _DB_PREFIX_ . "lofblogs_category_lang` WHERE `" . _DB_PREFIX_ . "lofblogs_category_lang`.`id_lofblogs_category` = 1 AND `" . _DB_PREFIX_ . "lofblogs_category_lang`.`id_lang` = ".(int)$lang['id_lang']." LIMIT 1;";
	}

$queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_category` VALUES (1, -1, 0, 1, 0, NULL, '');";
$queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_category` VALUES (2, 1, 1, 1, 0, NULL, '');";
if($langs)
	foreach($langs as $lang){
		$queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_category_lang` VALUES (1, ".(int)$lang['id_lang'].", 'ROOT', 'ROOT', NULL, NULL, NULL, NULL, NULL);";
		$queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_category_lang` VALUES (2, ".(int)$lang['id_lang'].", 'Home', 'home', NULL, NULL, NULL, NULL, NULL);";
	}

foreach ($queries as $query) {
    $db->Execute($query);
}
$queries = array();
//install emoticons key if table empty :
if (!$db->getValue('SELECT COUNT(id) FROM ' . _DB_PREFIX_ . 'lofblogs_comment_emoticons')) {
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (1, 'img1__gif', ':)');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (2, 'img10__gif', ':P');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (3, 'img100__gif', ':)]');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (4, 'img101__gif', ':call');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (5, 'img103__gif', ':bye');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (6, 'img104__gif', ':time');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (7, 'img105__gif', ':w)');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (8, 'img11__gif', ':kiss');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (9, 'img12__gif', ':bh)');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (10, 'img13__gif', ':o');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (11, 'img14__gif', ':angry');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (12, 'img15__gif', ':bm)');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (13, 'img16__gif', ':im)');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (14, 'img17__gif', ':~]]');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (15, 'img18__gif', '#:-S');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (16, 'img19__gif', '>:)');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (17, 'img2__gif', ':(');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (18, 'img20__gif', ':((');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (19, 'img21__gif', ':))');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (20, 'img22__gif', ':|');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (21, 'img23__gif', ':oo');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (22, 'img24__gif', '=))');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (23, 'img25__gif', ':angel');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (24, 'img26__gif', ':lm)');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (25, 'img27__gif', ':stopit');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (26, 'img28__gif', ':sleeping');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (27, 'img29__gif', '8-|');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (28, 'img3__gif', ';)');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (29, 'img30__gif', ':loser');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (30, 'img31__gif', ':-&');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (31, 'img32__gif', ':-s');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (32, 'img33__gif', ':nonono');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (33, 'img34__gif', ':0)');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (34, 'img35__gif', ':silly');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (35, 'img37__gif', '(:|');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (36, 'img38__gif', ':~p');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (37, 'img39__gif', ':thinking');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (38, 'img4__gif', ':D');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (39, 'img40__gif', ':wth');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (40, 'img41__gif', ':bravo');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (41, 'img42__gif', ':-ss');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (42, 'img43__gif', ':@@');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (43, 'img44__gif', ':--)');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (44, 'img45__gif', ':waiting');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (45, 'img46__gif', ':sigh');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (46, 'img47__gif', ':~^p');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (47, 'img48__gif', '<):)');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (48, 'img5__gif', ':0^0');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (49, 'img7__gif', ':s');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (50, 'img8__gif', ':loveyou');";
    $queries[] = "INSERT INTO `" . _DB_PREFIX_ . "lofblogs_comment_emoticons` VALUES (51, 'img9__gif', ':blushing');";
}

if($queries)
	foreach ($queries as $query) {
		$db->Execute($query);
	}