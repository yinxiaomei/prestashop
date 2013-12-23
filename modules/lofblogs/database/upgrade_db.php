<?php

//execute all queries :
$db = Db::getInstance();
$helper = new lofContentHelper();
if(!$helper->lofblogsTableExist('blocks_lang')) {
    $db->execute("DROP TABLE IF EXISTS `" . _DB_PREFIX_ . "lofblogs_blocks`");
}
