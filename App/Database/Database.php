<?php

namespace App\Database;

class Database
{
    private $db;
    private $db_table = "paciente";
    public $id;
    public $nome;
    public $cpf;
    public $result;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getPacientes()
    {
        $sqlQuery = "SELECT id, nome, cpf FROM " . $this->db_table;
        return $this->db->query($sqlQuery);
    }

    public function getId()
    {
        $sqlQuery = "SELECT id, nome, cpf FROM " . $this->db_table . " WHERE id = " . $this->id;
        $record = $this->db->query($sqlQuery);
        $dataRow = $record->fetch_assoc();
        $this->nome = $dataRow['nome'];
        $this->cpf = $dataRow['cpf'];
    }

    public function createPaciente()
    {
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->cpf = htmlspecialchars(strip_tags($this->cpf));
        $sqlQuery = "INSERT INTO cadastro.paciente (id, nome, cpf) VALUES (NULL,'" . $this->nome . "','" . $this->cpf . "');";
        $this->db->query($sqlQuery);
        if ($this->db->affected_rows > 0) {
            return true;
        }
        return false;
    }

    public function updatePaciente()
    {
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->cpf = htmlspecialchars(strip_tags($this->cpf));

        $sqlQuery = "UPDATE " . $this->db_table . " SET nome = '" . $this->nome . "',
                    cpf = '" . $this->cpf . "'
                    WHERE id = " . $this->id;

        $this->db->query($sqlQuery);
        if ($this->db->affected_rows > 0) {
            return true;
        }
        return false;
    }

    function deletePaciente()
    {
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = " . $this->id;
        $this->db->query($sqlQuery);
        if ($this->db->affected_rows > 0) {
            return true;
        }
        return false;
    }
}