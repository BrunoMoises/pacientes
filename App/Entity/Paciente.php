<?php

namespace App\Entity;

class Paciente
{
    private int $id;
    private string $nome;
    private string $cpf;

    public function __construct(int $id = null, string $nome = '', string $cpf = '') {
        $this->id = $id;
        $this->nome = $nome;
        $this->cpf = $cpf;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function setNome($nome): void
    {
        $this->nome = $nome;
    }

    public function setCpf($cpf): void
    {
        $this->cpf = $cpf;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getCpf(): string
    {
        return $this->cpf;
    }
}