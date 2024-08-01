<?php
/**
 * Classe CursosEventos
 * Criação
 */ 
class CursosEvento {
    private $conn;
    private $table_name = "Cursos_Evento";


    public function __construct($db) {
        $this->conn = $db;
    }

    public function create_curso_evento($data) {
        $query = "INSERT INTO " . $this->table_name . " (id_evento, id_curso, quantidade_vagas, quantidade_inscritos, id_administrador, data, horario_inicio, horario_fim) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iiiiisss", $data['id_evento'], $data['id_curso'], $data['quantidade_vagas'], $data['quantidade_inscritos'], $data['id_administrador'], $data['data'], $data['horario_inicio'], $data['horario_fim']);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}

