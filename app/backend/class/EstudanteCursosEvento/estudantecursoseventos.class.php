<?php
/**
 * Classe EstudanteCursosEvento
 * Criação
 */
class EstudanteCursosEvento {
    private $conn;
    private $table_name = "Estudante_Cursos_Evento";

    private $CursosEventos;

    public function __construct($db) {
        $this->conn = $db;
        $this->CursosEventos = new CursosEvento($db);
    }

    public function create_estudante_curso_evento($data) {
        // Verifica se o estudante já está inscrito em outro curso no mesmo horário
        if ($this->CursosEventos->is_horario_conflitante($data)) {
            return false;
        }

        // Vê se ainda tem vagas no curso
        if (!$this->check_qtd_inscritos_and_vagas($data)) {
            return "Erro 1"; // Erro 1 quer dizer que não há mais vagas
        }

        // Verifica se o estudante já está inscrito no mesmo curso e evento
        if (!$this->check_estudante_inscrito_curso_evento($data)) {
            $pontuacao = 10;

            $query = "INSERT INTO " . $this->table_name . " (matricula, id_evento, id_curso, pontuacao) VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("iiii", $data['matricula'], $data['id_evento'], $data['id_curso'], $pontuacao);

            if ($stmt->execute()) {
                $this->update_sum_pontuacao($data);
                return true;
            } else {
                return false;
            }
        }
    }

    // Método para contar os cursos inscritos do estudante
    public function count_cursos_inscritos($matricula) {
        $query = "SELECT COUNT(*) as total_cursos FROM " . $this->table_name . " WHERE matricula = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $matricula);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row['total_cursos'];
    }
    public function qtd_inscritos($data) {
        $query = "SELECT quantidade_inscritos FROM Cursos_Evento WHERE id_evento = ? AND id_curso = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $data['id_evento'], $data['id_curso']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row['quantidade_inscritos'];
    }


    // Método para verificar se existe vaga em um curso
    public function check_qtd_inscritos_and_vagas($data) {
        $query = "SELECT quantidade_inscritos, quantidade_vagas FROM Cursos_Evento WHERE id_evento = ? AND id_curso = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $data['id_evento'], $data['id_curso']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row['quantidade_inscritos'] < $row['quantidade_vagas']) {
            return true;
        } else {
            return false;
        }
    }

    public function update_sum_pontuacao($data) {
        // Atualiza a pontuação somando 10 pontos
        $query = "UPDATE Estudante SET pontuacao = pontuacao + 10 WHERE matricula = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $data['matricula']);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Verifica se o estudante está inscrito em um evento e curso específico
    public function check_estudante_inscrito_curso_evento($data) {
        $query = "SELECT 1 FROM ".$this->table_name." WHERE matricula = ? AND id_evento = ? AND id_curso = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iii", $data['matricula'], $data['id_evento'], $data['id_curso']);
        $stmt->execute();
        $stmt->store_result();

        return $stmt->num_rows > 0;
    }

    public function read_estudante_eventos($matricula) {
        $query = "SELECT * FROM vw_eventos_incritos_usuario WHERE matricula = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $matricula);

        if ($stmt->execute()) {
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } else {
            return false;
        }
    }

    public function read_estudante_cursos($matricula) {
        $query = "SELECT * FROM vw_cursos_incritos_usuario WHERE matricula = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $matricula);
        if ($stmt->execute()) {
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } else {
            return false;
        }
    }
}
