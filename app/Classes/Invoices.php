<?php

namespace App\Classes;

class Invoices
{
    public function index():string
    {
        return "Invoices";
    }
    public function create():string
    {
        return '<form action="/invoices/create" method="POST"><label for="amount">Amount</label><input type="text" name="amount" id="amount"><button type="submit">Create Invoice</button></form>';

    }
    public function store()
    {
        $amount= $_POST['amount'];
        var_dump($amount);
    }
}