<?php

namespace App;

use App\Exceptions\RouterNotFoundException;

class App
{
    public function __construct(protected $router, protected array $request)
    {
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