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

   

    public function create_student($data) {
        // Vê se um estudante existe na tabela de Estudante pela sua matricula
        if($this->estudante_existe($data['matricula'])) {
            return false; // Usuário não existe
        }

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

    // Método para verificar se um estudante já existe pela sua matricula
    public function estudante_existe($matricula) {
        $query = "SELECT matricula FROM " . $this->table_name . " WHERE matricula = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $matricula);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    public function ranking_estudantes($matricula) {
        // Query para obter a classificação e a pontuação de um estudante específico
        $query = "
            SELECT classificacao, matricula, pontuacao
            FROM (
                SELECT 
                    @rank := IF(@prev_pontuacao = E.pontuacao, @rank, @rank + 1) AS classificacao,
                    E.matricula, 
                    E.pontuacao,
                    @prev_pontuacao := E.pontuacao
                FROM 
                    " . $this->table_name . " AS E
                    CROSS JOIN (SELECT @rank := 0, @prev_pontuacao := NULL) AS vars
                ORDER BY 
                    E.pontuacao DESC
            ) AS ranking
            WHERE matricula = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $matricula);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0) {
            return $res->fetch_assoc();
        } else {
            return null;
        }
    }
}
