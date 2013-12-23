<?php

/**
 * $ModDesc
 * 
 * @version		$Id: helper.php $Revision
 * @package		modules
 * @subpackage	$Subpackage
 * @copyright	Copyright (C) May 2010 LandOfCoder.com <@emai:landofcoder@gmail.com>. All rights reserved.
 * @website 	htt://landofcoder.com
 * @license		GNU General Public License version 2
 */
if (!defined('_CAN_LOAD_FILES_')) {
    define('_CAN_LOAD_FILES_', 1);
}
if (!class_exists('LofMiniGalleryFolderDataSource', false)) {

    class LofMiniGalleryFolderDataSource extends LofMiniGalleryDataSourceBase {

        /**
         * @var string $__name;
         *
         * @access private
         */
        var $__name = 'custom';

        /**
         * override method: get list image from folder.
         */
        function getListByParameters($params, $images) {
            global $smarty, $cookie;
            $list = array();
            $id_lang = $cookie->id_lang;
            
            foreach ($images as $i => $image) {
                $index = $i;
                $name = 'gfi_'.$id_lang . "-" . $i;
                $list[$index]["name"] = $params->get($name. "-title", "");
                $list[$index]["link"] = $params->get($name . "-link", "");
                $list[$index]["image"] = $params->get($name . "-image", "");
                $list[$index]["mainImge"] = $list[$index]["image"];
                $list[$index]["thumbImge"] = $list[$index]["image"];

                if ($list[$index]["thumbImge"]) {
                    if ($params->get("cre_thumb", 1)) {
                        $list[$index] = $this->generateImages($list[$index], $params);
                    }
                }
                $list[$index]["description"] = $params->get($name . "-desc", "");
                if (($list[$index]["name"]) != "") {
                    $list[$index]["name"] = $list[$index]["name"];
                }
                if ($list[$index]['link']) {
                    $list[$index]['link'] = $this->addhttp($list[$index]['link']);
                    $list[$index]['description'] = $list[$index]['description'] . "<a href='" . $list[$index]['link'] . "' title='" . $list[$index]['title'] . "' >" . $params->get('readmore_txt', '[More...]') . "</a>";
                }
            }
            //echo '<pre>'; die(print_r($list));
            return $list;
        }

    }

}
?>