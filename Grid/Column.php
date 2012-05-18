<?php

namespace Openify\Bundle\JqGridBundle\Grid;

use Openify\Bundle\JqGridBundle\Tool\Tool;

/**
 * Description of Column
 *
 * @author pascal
 */
class Column {
    
    private $name;
    private $colmodel;
    private $router;
    
    public function __construct($router, $name = null) {
        
        $this->router = $router;
        if ($name != null) {
            $this->name = $name;
        }
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function setName($name) {
        $this->name = $name;
    }
    
    public function setColModel(array $colmodel) {
        $this->colmodel = $colmodel;
    }
    
    public function getColModel() {
        return $this->colmodel;
    }
    
    public function getFieldName() {
        return $this->colmodel ['name'];
    }
    
    public function getFieldValue() {
        if (array_key_exists ( 'value', $this->colmodel )) {
            return $this->colmodel ['value'];
        }
        else {
            return false;
        }
    }
    
    public function getFieldIndex() {
        if (array_key_exists ( 'index', $this->colmodel )) {
            return $this->colmodel ['index'];
        }
        else {
            return false;
        }
    }
    
    public function getFieldTwig() {
        if (array_key_exists ( 'twig', $this->colmodel )) {
            return $this->colmodel ['twig'];
        }
        else {
            return false;
        }
    }
    
    public function getFieldHaving() {
        if (array_key_exists ( 'having', $this->colmodel )) {
            return $this->colmodel ['having'];
        }
        else {
            return false;
        }
    }
    
    public function getFieldAutocomplete() {
        return $this->getField ( 'autocomplete' );
    }
    
    public function getFieldFormatter() {
        if (array_key_exists ( 'formatter', $this->colmodel )) {
            return $this->colmodel ['formatter'];
        }
        else {
            return false;
        }
    }
    
    public function getColModelJson($prefix = '') {
        $model = $this->colmodel;
        $dp = '';
        
        if (array_key_exists ( 'datepicker', $model ) && $model ['datepicker']) {
            $dp = ' ,"searchoptions" : {dataInit : datePick, "attr" : { "title": "Choisir une date" }}';
        }
        
        if (array_key_exists ( 'autocomplete', $model )) {
            $route = $this->router->generate ( $model ['autocomplete'] );
            $dp = ' ,"searchoptions" : {dataInit : function(elem) { $(elem).autocomplete({source:\'' . $route . '\',minLength:2}) }}';
        }
        
        unset ( $model ['twig'] );
        unset ( $model ['having'] );
        unset ( $model ['value'] );
        unset ( $model ['datepicker'] );
        unset ( $model ['autocomplete'] );
        
        //prefix index
        if (array_key_exists ( 'name', $model )) {
            $model ['name'] = $prefix . $model ['name'];
        }
        
        $models = Tool::json_encode_jsfunc ( $model );
        
        $models = substr ( $models, 0, strlen ( $models ) - 1 ) . $dp . '}';
        
        return $models;
    }

}

