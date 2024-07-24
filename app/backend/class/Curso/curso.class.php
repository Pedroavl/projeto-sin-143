<?php
/**
 * Classe Curso
 * Criação, Listagem, Atualização e Remoção
 */ 

class Curso {
    private $conn;
    private $table_name = "Curso";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read_cursos() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function create_curso($data) {
        // pega a data atual
        $data_criacao = date('Y-m-d');

        $query = "INSERT INTO " . $this->table_name . " (titulo, descricao, data_criacao, id_administrador) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssi", $data['titulo'], $data['descricao'], $data_criacao, $data['id_administrador']);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function update_curso($data) {
        $query = "UPDATE " . $this->table_name . " SET titulo = ?, descricao = ?, id_administrador = ? WHERE idCurso = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssii", $data['titulo'], $data['descricao'], $data['id_administrador'], $data['idCurso']);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function delete_curso($idCurso) {
        $query = "DELETE FROM " . $this->table_name . " WHERE idCurso = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $idCurso);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}