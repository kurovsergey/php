<?php

class View{

    private $content;

    public function setContent($content = '', $params = []){
        include $_SERVER['DOCUMENT_ROOT'].'/views/'.$content.'.php';
    }

}