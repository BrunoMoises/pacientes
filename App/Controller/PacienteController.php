<?php

namespace App\Controller;

use App\Entity\Paciente;
use App\Model\PacienteModel;

class PacienteController
{
    private PacienteModel $pacienteModel;
    public function __construct()
    {
        $this->pacienteModel = new PacienteModel();
    }
    function create($data = null): false|string
    {
        $paciente = $this->convertType($data);
        $result = $this->validate($paciente);

        if ($result != "") {
            return json_encode(["result" => $result]);
        }

        return $this->pacienteModel->create($paciente);
    }

    function update(int $id = 0, $data = null): string
    {
        $paciente = $this->convertType($data);
        $paciente->setId($id);
        $result = $this->validate($paciente, true);

        if ($result != "") {
            return json_encode(["result" => $result]);
        }

        return $this->pacienteModel->update($paciente);
    }

    function delete(int $id = 0): false|string
    {
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

        if ($id <= 0)
            return json_encode(["result" => "invalid id"]);

        return $this->pacienteModel->delete($id);
    }

    function readById(int $id = 0): false|string
    {
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

        if ($id <= 0)
            return json_encode(["result" => "invalid id"]);

        return $this->pacienteModel->readById($id);
    }

    function readAll(): false|string
    {
        return json_encode($this->pacienteModel->readAll());
    }

    private function convertType($data): Paciente
    {
        return new Paciente(
            null,
            (isset($data->nome) ? htmlspecialchars($data->nome, ENT_HTML5) : null),
            (isset($data->cpf) ? htmlspecialchars($data->cpf, ENT_HTML5) : null)
        );
    }

    private function validate(Paciente $paciente, $update = false): string
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