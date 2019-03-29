<?php

namespace Core;

class Router {

    private $pool = [];
    private static $instance;

    public static function getInstance() {

        if (static::$instance === null) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    public function add($method, $path, $func) {

        $route = new \stdClass;
        $route->method = $method;
        $route->path = $path;
        $route->func = $func;

        $this->pool[] = $route;
    }
    public function start() {

        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach($this->pool as $route) {

            if ($route->method === $_SERVER['REQUEST_METHOD'] && $route->path === $path) {
                ($route->func)();
            }
        }
    }
}
