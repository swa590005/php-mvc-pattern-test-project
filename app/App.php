<?php

namespace App;

use App\Exceptions\RouterNotFoundException;

class App
{
    private static DB $db;
    public function __construct(protected $router, protected array $request, protected Config $config)
    {
        static::$db = new DB($config->db ?? []);
    }

    public static function getDb(): DB
    {
        return static::$db;
    }

    public function run()
    {
        try {
            $this->router->resolve($this->request['uri'], strtolower($this->request['method']));
        } catch (RouterNotFoundException) {
            http_response_code(404);
            echo \App\View::make('error/404');
        }
    }
}