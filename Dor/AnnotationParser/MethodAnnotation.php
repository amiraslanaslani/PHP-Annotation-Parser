<?php
/**
 * User: Amir Aslan Aslani
 * Date: 6/28/19
 * Time: 4:37 AM
 */

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

    public function getAnnotationKeys(){
        return array_keys($this->list);
    }

    public function toArray(){
        return $this->list;
    }
}