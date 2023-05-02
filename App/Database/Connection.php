<?php

namespace App\Database;

use PDO;

class Connection
{
    public function connect(): PDO
    {
        return new PDO("mysql:host=localhost;dbname=cadastro", 'root','');
    }
}