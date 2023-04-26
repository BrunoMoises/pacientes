<?php

namespace App\Database;

use Exception;
use PDO;

class Database
{
    private PDO $conn;
    private string $db_table = "paciente";
    public string $id;
    public string $nome;
    public string $cpf;

    public function __construct()
    {
        $conn = new PDO("mysql:host=localhost;dbname=cadastro", 'root','');
        $this->conn = $conn;
    }

    public function getPacientes(): false|\PDOStatement
    {
        return $this->conn->query('SELECT id, nome, cpf FROM ' . $this->db_table );
    }

    public function getId(): void
    {
        $sqlQuery = "SELECT id, nome, cpf FROM " . $this->db_table . " WHERE id = ? ";
        $record = $this->conn->prepare($sqlQuery);
        $record->execute(array($this->id));
        $dataRow = $record->fetch();
        $this->nome = $dataRow['nome'];
        $this->cpf = $dataRow['cpf'];
    }

    public function createPaciente(): bool
    {
        $sqlQuery = "INSERT INTO cadastro.paciente (id, nome, cpf) VALUES (NULL,?,?);";
        $record = $this->conn->prepare($sqlQuery);
        try {
            $this->conn->beginTransaction();
            $record->execute([$this->nome,$this->cpf]);
            $this->conn->commit();
            return false;
        }catch (Exception $e){
            $this->conn->rollback();
            return true;
        }
    }

    public function updatePaciente(): bool
    {
        $sqlQuery = "UPDATE " . $this->db_table . " SET nome = ?, cpf = ? WHERE id = ?";
        $record = $this->conn->prepare($sqlQuery);
        try {
            $this->conn->beginTransaction();
            $record->execute([$this->nome,$this->cpf,$this->id]);
            $this->conn->commit();
            return true;
        }catch (Exception $e){
            $this->conn->rollback();
            return false;
        }
    }

    function deletePaciente(): bool
    {
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
        $record = $this->conn->prepare($sqlQuery);
        try {
            $this->conn->beginTransaction();
            $record->execute([$this->id]);
            $this->conn->commit();
            return true;
        }catch (Exception $e){
            $this->conn->rollback();
            return false;
        }
    }
}