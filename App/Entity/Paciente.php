<?php

namespace App\Entity;

class Paciente
{
    private $id;
    private $nome;
    private $cpf;

    public function __construct($id = '', $nome = '', $cpf = '') {
        $this->id = $id;
        $this->nome = $nome;
        $this->cpf = $cpf;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getCpf()
    {
        return $this->cpf;
    }
}