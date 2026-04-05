<?php

namespace App\Controllers;

use App\App;
use App\View;
use PDO;

class HomeController
{
    public function index():View
    {

        $db = App::getDb();

        $email ='sam@something';
        $name = 'sam';
        $amount = 23;

        try {
            $db->beginTransaction();
            $newUserStmt = $db->prepare('INSERT INTO users (email, full_name, is_active,created_at)
                    VALUES (?,?,1,NOW())'
            );

            $newInvoiceStmt = $db->prepare(
                'INSERT INTO invoices (amount, user_id) VALUES (?,?)');

            $newUserStmt->execute([$email,$name]);

            $userId = $db->lastInsertId();

            $newInvoiceStmt->execute([$amount,$userId]);

            $db->commit();
        }catch (\Throwable $e){
            if($db->inTransaction())
            {
                $db->rollBack();
            }
            throw $e;
        }

        $fetchStatement = $db->prepare(
            'SELECT invoices.id AS invoice_id, amount,
                    user_id, full_name FROM invoices
                    INNER JOIN users ON invoices.user_id = users.id
                    WHERE email = ?'
        );

        $fetchStatement->execute([$email]);
        echo '<pre>';
        var_dump($fetchStatement->fetchAll(PDO::FETCH_ASSOC));
        echo '</pre>';

        return View::make('index');
    }

}