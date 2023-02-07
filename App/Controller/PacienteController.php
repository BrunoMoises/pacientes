<?php

namespace App\Controller;

use App\Entity\Paciente;
use App\Model\PacienteModel;

class PacienteController
{
    
    private $pacienteModel;
    public function __construct()
    {
        $this->pacienteModel = new PacienteModel();
    }
    function create($data = null)
    {
        $paciente = $this->convertType($data);
        $result = $this->validate($paciente);

        if ($result != "") {
            return json_encode(["result" => $result]);
        }

        return json_encode(["result" => $this->pacienteModel->create($paciente)]);
    }

    function update($id = 0, $data = null)
    {
        $paciente = $this->convertType($data);
        $paciente->setId($id);
        $result = $this->validate($paciente, true);

        if ($result != "") {
            return json_encode(["result" => $result]);
        }


        $result = $this->pacienteModel->update($paciente);

        return json_encode(["result" => $result]);
    }

    function delete($id = 0)
    {
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

        if ($id <= 0)
            return json_encode(["result" => "invalid id"]);

        $result = $this->pacienteModel->delete($id);

        return json_encode(["result" => $result]);
    }

    function readById($id = 0)
    {
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

        if ($id <= 0)
            return json_encode(["result" => "invalid id"]);

        return $this->pacienteModel->readById($id);
    }

    function readAll()
    {
        return json_encode($this->pacienteModel->readAll());
    }

    private function convertType($data)
    {
        return new Paciente(
            null,
            (isset($data['nome']) ? filter_var($data['nome'], FILTER_SANITIZE_STRING) : null),
            (isset($data['cpf']) ? filter_var($data['cpf'], FILTER_SANITIZE_STRING) : null)
        );
    }

    private function validate(Paciente $paciente, $update = false)
    {
        if ($update && $paciente->getId() <= 0)
            return "invalid id";

        if ($paciente->getNome() == "")
            return "invalid nome";

        if ($paciente->getCpf() == "")
            return "invalid cpf";

        return "";
    }
}