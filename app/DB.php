<?php

namespace App;

use PDO;

/**
 * @mixin PDO;
 */
class DB
{
    private PDO $pdo;
    public function __construct(protected array $config)
    {
        $defaultOptions = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        try{
            $this->pdo = new PDO($this->config['driver'].':host='.$this->config['host'].';dbname='. $this->config['database'],
                $this->config['user'],
                $this->config['db_pass'],
                $this->config['options'] ?? $defaultOptions);

        }catch (\PDOException $e){
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }

    }

    public function __call(string $name, array $arguments)
    {
        return call_user_func_array([$this->pdo, $name], $arguments);
    }

}