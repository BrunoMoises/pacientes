<?php

namespace App\Model;

use App\Entity\Paciente;
use App\Database\Database;
use mysqli;

class PacienteModel
{
    private $db;
    private $items;
    private $listPaciente = [];

    public function __construct()
    {
        $this->db = new mysqli('localhost', 'root', '', 'cadastro');
        $this->items = new Database($this->db);
        $this->load();
    }

    public function readAll(): array
    {
        return $this->listPaciente;
    }

    public function readById(int $id)
    {
        $this->items->id = $id;
        $this->items->getId();

        if ($this->items->nome === null) {
            http_response_code(404);
            return json_encode(array("message" => "Não encontrado."));
        }

        $pac_arr = array(
            "id" => $this->items->id,
            "nome" => $this->items->nome,
            "cpf" => $this->items->cpf
        );

        http_response_code(200);

        return json_encode($pac_arr);
    }

    public function create(Paciente $paciente)
    {
        $this->items->nome = $paciente->getNome();
        $this->items->cpf = $paciente->getCpf();

        if (!$this->items->createPaciente()) {
            return "Erro ao gravar";
        }

        return "ok";
    }

    public function update(Paciente $paciente)
    {
        $this->items->id = $paciente->getId();
        $this->items->nome = $paciente->getNome();
        $this->items->cpf = $paciente->getCpf();

        if (!$this->items->updatePaciente()) {
            return "Erro ao gravar";
        }

        return "ok";
    }

    public function delete(int $id)
    {
        $this->items->id = $id;

        if (!$this->items->deletePaciente()) {
            return "Erro ao gravar";
        }

        return "ok";
    }

    private function load()
    {
        $records = $this->items->getPacientes();
        $itemCount = $records->num_rows;

        if ($itemCount === 0) {
            http_response_code(404);
            return json_encode(array("message" => "Não encontrado."));
        }

        while ($row = $records->fetch_assoc()) {
            array_push($this->listPaciente, $row);
        }
    }
}