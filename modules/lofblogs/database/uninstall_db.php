<?php

$queries = array();
$queries[] = "DROP TABLE IF EXISTS `" . _DB_PREFIX_ . "lofblogs_blocks`";
$queries[] = "DROP TABLE IF EXISTS `" . _DB_PREFIX_ . "lofblogs_blocks_lang`";
$queries[] = "DROP TABLE IF EXISTS `" . _DB_PREFIX_ . "lofblogs_categories`";
$queries[] = "DROP TABLE IF EXISTS `" . _DB_PREFIX_ . "lofblogs_category`";
$queries[] = "DROP TABLE IF EXISTS `" . _DB_PREFIX_ . "lofblogs_category_lang`";
$queries[] = "DROP TABLE IF EXISTS `" . _DB_PREFIX_ . "lofblogs_comment`";
$queries[] = "DROP TABLE IF EXISTS `" . _DB_PREFIX_ . "lofblogs_comment_clients`";
$queries[] = "DROP TABLE IF EXISTS `" . _DB_PREFIX_ . "lofblogs_comment_emoticons`";
$queries[] = "DROP TABLE IF EXISTS `" . _DB_PREFIX_ . "lofblogs_publication`";
$queries[] = "DROP TABLE IF EXISTS `" . _DB_PREFIX_ . "lofblogs_publication_lang`";
$queries[] = "DROP TABLE IF EXISTS `" . _DB_PREFIX_ . "lofblogs_rate_clients`";

$queries[] = "DROP TABLE IF EXISTS `" . _DB_PREFIX_ . "lofblogs_publication_product`";
$queries[] = "DROP TABLE IF EXISTS `" . _DB_PREFIX_ . "lofblogs_tag`";
$queries[] = "DROP TABLE IF EXISTS `" . _DB_PREFIX_ . "lofblogs_tag_article`";

//execute all queries :
$db = Db::getInstance();
foreach ($queries as $query) {
    $db->Execute($query);
}