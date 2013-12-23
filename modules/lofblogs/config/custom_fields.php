<?php

/**
 * Custom field for LOFParamsField 
 * 
 * - Define some field for individual module -
 * 
 * How to named your field : <get><MyfieldName><Field>. e.g : getMyelementField($field) {}
 * 
 */


class LOFParamsFieldLofblogs extends LOFParamsField {
    function getGroupField($field){
        global $cookie;
        
        $groups = Group::getGroups(intval($cookie->id_lang));  
        
        $options = array();
        $options[] = array('text' => '-- all --', 'value' => '0');
        foreach ($groups as $group) {
            $options[] = array('text' => $group['name'], 'value' => $group['id_group']);
        }
        
        $field['options'] = $options;
        return $this->getListField($field);
    }
        
}