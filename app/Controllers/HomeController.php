<?php

namespace App\Controllers;

use App\Models\Invoice;
use App\Models\SignUp;
use App\Models\User;
use App\View;

class HomeController
{
    public function index():View
    {
        $email ='user@something';
        $name = 'user';
        $amount = 44;

        $userModel = new User();
        $invoiceModel = new Invoice();

        $invoiceId = (new SignUp($userModel, $invoiceModel))->register(
            [
                'email' => $email,
                'name' => $name,
            ],
            [
                'amount' => $amount,
            ]
        );
        $invoice = $invoiceModel->find($invoiceId);
        return View::make('index',['invoice'=>$invoice]);

    }

}