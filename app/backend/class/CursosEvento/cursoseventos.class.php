<?php
/**
 * Classe CursosEventos
 * Criação, Update, Delete
 */ 
class CursosEvento {
    private $conn;
    private $table_name = "Cursos_Evento";


    public function __construct($db) {
        $this->conn = $db;
    }

    public function read_cursos_evento($id_evento) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_evento = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_evento);
        if ($stmt->execute()) {
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } else {
            return false;
        }
    }

    public function create_curso_evento($data) {
        $query = "INSERT INTO " . $this->table_name . " (id_evento, id_curso, quantidade_vagas, quantidade_inscritos, id_administrador, data, horario_inicio, horario_fim, data_criacao) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $data_criacao = date('Y-m-d');

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssiissss", $data['id_evento'], $data['id_curso'], $data['quantidade_vagas'], $data['quantidade_inscritos'], $data['id_administrador'], $data['data'], $data['horario_inicio'], $data['horario_fim'], $data_criacao);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function update_curso_evento($data) {
        $query = "UPDATE " . $this->table_name . " SET quantidade_vagas = ?, quantidade_inscritos = ?, data = ?, horario_inicio = ?, horario_fim = ? WHERE id_evento = ? AND id_curso = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iisssii", $data['quantidade_vagas'], $data['quantidade_inscritos'], $data['data'], $data['horario_inicio'], $data['horario_fim'], $data['id_evento'], $data['id_curso']);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function delete_curso_evento($id_evento, $id_curso) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_evento = ? AND id_curso = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $id_evento, $id_curso);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function is_horario_conflitante($data) {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name . " WHERE id_evento = ? AND data = ? AND ((horario_inicio < ? AND horario_fim > ?) OR (horario_inicio < ? AND horario_fim > ?) OR (horario_inicio = ? AND horario_fim = ?))";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("isssssss", $data['id_evento'], $data['data'], $data['horario_fim'], $data['horario_inicio'], $data['horario_fim'], $data['horario_inicio'], $data['horario_inicio'], $data['horario_fim']);

        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        // Se o total for maior que 0, tem conflito de horário e vai retorna true caso tenha conflito e false o contrário
        return $row['total'] > 0;
    }
}

