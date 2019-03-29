<?php

namespace Controller\IndexPage;

class Controller {

    public function __construct() {

        $router = \Core\Router::getInstance();
        $router->add('GET', '/', function() {

            $html = file_get_contents(__DIR__ . '/../../../index.html'); 
            die($html);
        });
    }
}
