<?php
/**
 * Classe EstudanteCursosEvento
 * Criação
 */
class EstudanteCursosEvento {
    private $conn;
    private $table_name = "Estudante_Cursos_Evento";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create_estudante_curso_evento($data) {
        $query = "INSERT INTO " . $this->table_name . " (matricula, id_evento, id_curso, pontuacao) VALUES (?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iiii", $data['matricula'], $data['id_evento'], $data['id_curso'], 10);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
