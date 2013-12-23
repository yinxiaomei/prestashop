<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class LOFPagination {
    
    public $total = 0;
    public $limit = 10;
    public $limitstart = 0;


    function __construct($total = 0, $limit = 10, $limitstart = 0) {
        $this->total = $total;
        $this->limit = $limit;
        $this->limitstart = $limitstart;
    }
    
    function getPageLink() {
        
    }
}