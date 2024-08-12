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
        // Verifica se o estudante já está inscrito em outro curso no mesmo horário
        if ($this->is_horario_conflitante($data)) {
            return false;
        }

        $query = "INSERT INTO " . $this->table_name . " (id_evento, id_curso, quantidade_vagas, quantidade_inscritos, id_administrador, data, horario_inicio, horario_fim) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iiiiisss", $data['id_evento'], $data['id_curso'], $data['quantidade_vagas'], $data['quantidade_inscritos'], $data['id_administrador'], $data['data'], $data['horario_inicio'], $data['horario_fim']);
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

