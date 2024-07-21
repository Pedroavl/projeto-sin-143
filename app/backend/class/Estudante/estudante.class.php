<?php
/**
 *  Classe Estudante
 *  Criação, Listagem, Atualização e Remoção
 */ 

class Estudante {
    private $conn;
    private $table_name = "Estudante";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para verificar se um estudante já existe pela sua matricula
    private function student_exists($matricula) {
        $query = "SELECT matricula FROM " . $this->table_name . " WHERE matricula = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $matricula);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    public function create_student($data) {
        $query = "INSERT INTO " . $this->table_name . " (matricula, pontuacao, id_usuario) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iii", $data['matricula'], $data['pontuacao'], $data['id_usuario']);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function read_student() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function update_student($data) {
        $query = "UPDATE " . $this->table_name . " SET pontuacao = ?, id_usuario = ? WHERE matricula = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iii", $data['pontuacao'], $data['id_usuario'], $data['matricula']);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function delete_student($matricula) {
        $query = "DELETE FROM " . $this->table_name . " WHERE matricula = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $matricula);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
