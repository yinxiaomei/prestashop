<?php

class Dispatcher extends DispatcherCore {

    function __construct() {
        $lofblogs_rule = array(
                'controller' => 'articles',
                'rule' => 'blogs/{id}-{rewrite}.html',
                'keywords' => array(
                    'id' => array('regexp' => '[0-9]+', 'param' => 'id'),
                    'rewrite' => array('regexp' => '[_a-zA-Z0-9-\pL]*'),
                ),
                'params' => array(
                    'fc' => 'module',
                    'module' => 'lofblogs',
                    'view' => 'content'
                )
            );
            $lofblogs_category_rule = array(
                'controller' => 'articles',
                'rule' => 'blogs/category/{id}-{rewrite}.html',
                'keywords' => array(
                    'id' => array('regexp' => '[0-9]+', 'param' => 'id'),
                    'rewrite' => array('regexp' => '[_a-zA-Z0-9-\pL]*'),
                ),
                'params' => array(
                    'fc' => 'module',
                    'module' => 'lofblogs',
                    'view' => 'category'
                )
            );
            $lofblogs_tag_rule = array(
                'controller' => 'articles',
                'rule' => 'blogs/tags/{tag}.html',
                'keywords' => array(
                    'tag' => array('regexp' => '[ _a-zA-Z0-9-\pL]*', 'param' => 'tag')
                ),
                'params' => array(
                    'fc' => 'module',
                    'module' => 'lofblogs',
                    'view' => 'tag'
                )
            );
            $lofblogs_search_rule = array(
                'controller' => 'articles',
                'rule' => 'blogs/search/search.html',
                'keywords' => array(),
                'params' => array(
                    'fc' => 'module',
                    'module' => 'lofblogs',
                    'view' => 'search'
                )
            );
            
            array_unshift($this->default_routes, $lofblogs_search_rule);
            array_unshift($this->default_routes, $lofblogs_tag_rule);
            array_unshift($this->default_routes, $lofblogs_category_rule);
            array_unshift($this->default_routes, $lofblogs_rule);

        parent::__construct();
    }

}

