<?php

namespace Dor\AnnotationParser;

class MethodAnnotation{

    private $list = [];

    public function __construct($list){
        $this->list = $list;
    }

    public function hasAnnotation($name){
        return isset($this->list[$name]);
    }

    public function getAnnotation($name){
        return $this->list[$name];
    }

    public function toArray(){
        return $this->list;
    }
}