<?php
/**
 * User: Amir Aslan Aslani
 * Date: 6/28/19
 * Time: 3:00 AM
 */

namespace Dor\AnnotationParser;

class Annotation{

    public $methods = [];

    private $methode_annotations = [];
    private $array_delimiter = ',';
    private $docs = [
        'class' => '',
        'methods' => []
    ];

    public function __construct(string $class_name, string $array_delimiter = ','){
        $this->array_delimiter = $array_delimiter;
        $class_reflector = new \ReflectionClass($class_name);
        $this->docs['class'] = $class_reflector->getDocComment();

        foreach ($class_reflector->getMethods() as $method_reflector) {
            $method_name = $method_reflector->name;
            $methods[] = $method_name;
            $this->docs['methods'][$method_name] = $method_reflector->getDocComment();
            $this->methode_annotations[$method_name] = $this->getMethod($method_name);
        }
    }

    public function getMethods(){
        return $this->methode_annotations;
    }

    public function hasMethod($name){
        return in_array($name, $this->methodes);
    }

    public function getMethod($name){
        return new MethodAnnotation(
            $this->getMethodAnnotation($name)
        );
    }

    public function getMethodAnnotation($method_name){
        return $this->parseAnnotation($this->docs['methods'][$method_name]);
    }

    public function getClassAnnotation(){
        return $this->parseAnnotation($this->docs['class']);
    }

    // Privates

    private function parseAnnotation($text){
        $annotation_list = $this->getAnnotationsList($text);
        $annos_content = [];
        foreach($annotation_list as $anno_one){
            $anno_detail = $this->getAnnoDetails($anno_one);
            $annos_content[$anno_detail[0]] = $anno_detail[1];
        }
        return $this->setAnnotationsArrays($annos_content);
    }

    private function setAnnotationsArrays($annos_content){
        foreach($annos_content as $key => $value){
            $exploded = explode($this->array_delimiter, $value);
            if(count($exploded) > 1)
                $annos_content[$key] = $exploded;
        }
        return $annos_content;
    }

    private function getAnnoDetails($anno){
        $details = ['', ''];
        $splited = explode('(', $anno);
        $details[0] = str_replace(' ', '', $splited[0]);
        $splited = explode(')', $splited[1]);
        $details[1] = trim($splited[0]);
        return $details;
    }

    private function getAnnotationsList($text){
        $annotations_list = [];
        preg_match_all('/([a-zA-Z0-9_])+\s*\(.*\)/', $text, $annotations_list);
        return $annotations_list[0];
    }

}