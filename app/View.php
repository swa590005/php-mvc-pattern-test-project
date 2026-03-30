<?php
declare(strict_types=1);

namespace App;
use App\Exceptions\ViewNotFoundException;

class View
{
    public function __construct(
        protected string $view,
        protected array $data = []
    ) {
    }

    public static function make(string $view, array $data = []):static
    {
        return new static($view, $data);
    }

    public function render():string
    {
        $viewPath = VIEW_PATH . '/' . $this->view . '.php';
        if (!file_exists($viewPath)) {
            throw new ViewNotFoundException();
        }
        ob_start();
        include $viewPath;
        return (string) ob_get_clean();
    }

    public function __toString():string
    {
        return $this->render();
    }

}