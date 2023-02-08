<?php

namespace App\Model;

use App\Entity\Paciente;
use App\Database\Database;
use Exception;
use mysqli;

class PacienteModel
{
    private $db;
    private $items;
    private $listPaciente = [];

    public function __construct()
    {
        $this->load();
    }

    public function getConnection()
    {
        $this->db = null;
        try {
            $this->db = new mysqli('localhost', 'root', '', 'cadastro');
        } catch (Exception $e) {
            echo "Database could not be connected: " . $e->getMessage();
        }

        return $this->db;
    }

    public function readAll()
    {
        return $this->listPaciente;
    }

    public function readById($id)
    {
        $this->db = $this->getConnection();
        $this->items = new Database($this->db);

        $this->items->id = $id;
        $this->items->getId();

        if ($this->items->nome != null) {

            $pac_arr = array(
                "id" => $this->items->id,
                "nome" => $this->items->nome,
                "cpf" => $this->items->cpf
            );

            http_response_code(200);

            return json_encode($pac_arr);
        }
    }

    public function create(Paciente $paciente)
    {
        $this->db = $this->getConnection();
        $this->items = new Database($this->db);

        $this->items->nome = $paciente->getNome();
        $this->items->cpf = $paciente->getCpf();

        if (!$this->items->createPaciente())
            return "Erro ao gravar";

        return "ok";
    }


    public function update(Paciente $paciente)
    {
        $this->db = $this->getConnection();
        $this->items = new Database($this->db);

        $this->items->id = $paciente->getId();
        $this->items->nome = $paciente->getNome();
        $this->items->cpf = $paciente->getCpf();

        if (!$this->items->updatePaciente())
            return "Erro ao gravar";

        return "ok";
    }

    public function delete($id)
    {
        $this->db = $this->getConnection();
        $this->items = new Database($this->db);

        $this->items->id = isset($id) ? $id : die();

        if (!$this->items->deletePaciente())
            return "Erro ao gravar";

        return "ok";
    }

    private function load()
    {
        $this->db = $this->getConnection();
        $this->items = new Database($this->db);

        $records = $this->items->getPacientes();
        $itemCount = $records->num_rows;

        if ($itemCount > 0) {
            while ($row = $records->fetch_assoc()) {
                array_push($this->listPaciente, $row);
            }
        } else {
            http_response_code(404);
            return json_encode(
                array("message" => "Não encontrado.")
            );
        }
    }
}