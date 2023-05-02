<?php

namespace App\Model;

use App\Database\Connection;
use App\Entity\Paciente;
use App\Database\Database;
use Exception;
use PDO;

class PacienteModel
{
    private PDO $conn;
    private Connection $obj;
    private string $db_table = "paciente";
    private array $listPaciente = [];

    public function __construct()
    {
        $this->obj = new Connection;
        $this->conn = $this->obj->connect();
        $this->load();
    }

    public function readAll(): array
    {
        return $this->listPaciente;
    }

    public function readById(int $id): false|string
    {
        $sqlQuery = "SELECT id, nome, cpf FROM " . $this->db_table . " WHERE id = ? ";
        $record = $this->conn->prepare($sqlQuery);
        $record->execute(array($id));
        $dataRow = $record->fetch();

        if (!$dataRow) {
            http_response_code(404);
            return json_encode(array("result" => "Não encontrado."));
        }

        $pac_arr = array(
            "id" => $id,
            "nome" => $dataRow['nome'],
            "cpf" => $dataRow['cpf']
        );

        http_response_code(200);
        return json_encode($pac_arr);
    }

    public function create(Paciente $paciente)
    {
        $values = [
            $paciente->getNome(),
            $paciente->getCpf()
        ];
        $insertQuery = "INSERT INTO cadastro.paciente (id, nome, cpf) VALUES (NULL,?,?);";
        $selectQuery = "SELECT * FROM cadastro.paciente WHERE id = LAST_INSERT_ID();";

        $insertRecord = $this->conn->prepare($insertQuery);
        $selectRecord = $this->conn->prepare($selectQuery);

        try {
            $this->conn->beginTransaction();
            $insertRecord->execute($values);
            $selectRecord->execute();
            $this->conn->commit();

            $result = $selectRecord->fetch(PDO::FETCH_ASSOC);
            http_response_code(201);
            return json_encode($result);
        } catch (Exception $e) {
            $this->conn->rollback();
            http_response_code(400);
            return json_encode(array("result" => "Não foi possível a criação."));
        }
    }

    public function update(Paciente $paciente): string
    {
        $values = [
            $paciente->getNome(),
            $paciente->getCpf(),
            $paciente->getId()
        ];
        $sqlQuery = "UPDATE " . $this->db_table . " SET nome = ?, cpf = ? WHERE id = ?";
        $selectQuery = "SELECT * FROM " . $this->db_table . " WHERE id = ?";

        $updateRecord = $this->conn->prepare($sqlQuery);
        $selectRecord = $this->conn->prepare($selectQuery);

        try {
            $this->conn->beginTransaction();
            $updateRecord->execute($values);
            $selectRecord->execute(array($paciente->getId()));
            $this->conn->commit();

            $result = $selectRecord->fetch(PDO::FETCH_ASSOC);
            http_response_code(200);
            return json_encode($result);
        } catch (Exception $e) {
            $this->conn->rollback();
            http_response_code($e->getCode());
            return json_encode(array("result" => "Não foi possível a alteração."));
        }
    }

    public function delete(int $id): string
    {
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
        $record = $this->conn->prepare($sqlQuery);
        try {
            $this->conn->beginTransaction();
            $record->execute([$id]);
            $this->conn->commit();
            http_response_code(201);
            return json_encode(array("result" => "OK"));
        } catch (Exception $e) {
            $this->conn->rollback();
            http_response_code($e->getCode());
            return json_encode(array("result" => "Não foi possivel a alteração."));
        }
    }

    private function load(): void
    {
        $records = $this->conn->query('SELECT id, nome, cpf FROM ' . $this->db_table);

        if (!$records) {
            http_response_code($records->errorCode());
            json_encode(array("result" => "Não encontrado."));
            return;
        }

        while ($row = $records->fetch()) {
            $this->listPaciente[] = $row;
        }
    }
}