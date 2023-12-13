<?php

namespace App\controller;

class MyTable
{ //attributs

    private \PDO $connexion;
    private string $table;


    public function __construct(string $_table)
    {
        $this->table = $_table;
    }
    //propriétes



}
