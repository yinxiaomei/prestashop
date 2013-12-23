<?php

/**
 * ***** Lof Content Helper ************
 * @author LandOfCoder
 * @subpackage LofContent
 * @todo Help building system
 * 
 */
class lofBlogsArticlesHelper {

    function getThemeMedia($template='default') {
        $mediaPath = LOFCONTENT_THEMES_FOLDER . $this->template . '/assets/';

        $mediaFiles = array();
        if (file_exists($mediaPath . 'css')) {
            $cssFiles = $this->params->getFilesFromFolder($mediaPath . 'css');

            if (count($cssFiles) && is_array($cssFiles)) {
                foreach ($cssFiles as $filename) {
                    $ext = strtolower(preg_replace('/^.*\./', '', $filename));
                    if ($ext == 'css') {
                        $mediaFiles['css'][] = LOFCONTENT_THEMES_URI . $this->template . '/assets/css/' . $filename;
                    }
                }
            }
        }

        if (file_exists($mediaPath . 'js')) {
            $jsFiles = $this->params->getFilesFromFolder($mediaPath . 'js');

            if (count($jsFiles) && is_array($jsFiles)) {
                foreach ($jsFiles as $filename) {
                    $ext = strtolower(preg_replace('/^.*\./', '', $filename));
                    if ($ext == 'js') {
                        $mediaFiles['js'][] = LOFCONTENT_THEMES_URI . $this->template . '/assets/js/' . $filename;
                    }
                }
            }
        }
        return $mediaFiles;
    }

}

?>