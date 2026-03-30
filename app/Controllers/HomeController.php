<?php

namespace App\Controllers;

use App\View;

class HomeController
{
    public function index():View
    {
        return View::make('index');
    }

    public function upload()
    {
        $filePath = STORAGE_PATH .'/'. $_FILES["file"]["name"];
        move_uploaded_file($_FILES["file"]["tmp_name"], $filePath);

        echo "<pre>";
        var_dump(pathinfo($filePath));
        echo "</pre>";

    }
}