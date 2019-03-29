<?php

namespace Core;

class Db {

    private static $instance;
    private static $HOST = '127.0.0.1';
    private static $NAME = 'db_feedback';
    private static $USER = 'feedback';
    private static $PORT = '5432';
    private static $PASS = '1234';
    
    private $pdo;

    private function __construct () {

        $dsn = "pgsql" . 
            ":host=" . static::$HOST .
            ";port=" . static::$PORT . 
            ";dbname=" . static::$NAME;
            
        $opt  = array(
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => TRUE,
        );

        $this->pdo = new \PDO( $dsn, static::$USER, static::$PASS, $opt );
    }

    public static function getInstance() {

        if (static::$instance === null) {
            static::$instance = new static;
        }
        return static::$instance;
    }
    public function getPDO() {
        return $this->pdo;
    }

};
