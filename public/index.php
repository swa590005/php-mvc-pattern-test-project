<?php

declare(strict_types = 1);

use App\App;
use App\Router;
use App\Controllers\HomeController;
use App\Controllers\InvoicesController;
use App\Config;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

const STORAGE_PATH = __DIR__ . '/../storage';
const VIEW_PATH = __DIR__ . '/../views';



$router = new Router();

$router->get('/', [HomeController::class,'index'])
        ->post('/upload', [HomeController::class,'upload'])
        ->get('/invoices', [InvoicesController::class,'index'])
        ->get('/invoices/create', [InvoicesController::class,'create'])
        ->post('/invoices/create', [InvoicesController::class,'store']);


(new App($router,
    [
        'uri'=> $_SERVER['REQUEST_URI'],
        'method'=>$_SERVER['REQUEST_METHOD']
    ],
    new Config($_ENV)
))->run();