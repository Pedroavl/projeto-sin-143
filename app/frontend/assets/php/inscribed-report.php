<?php 
    include "../../../backend/database/connection/connect.inc.php";

    $query = 
    "SELECT es.matricula, u.nome, ece.pontuacao, e.nome AS evento, c.titulo AS curso
    FROM estudante_cursos_evento AS ece JOIN Evento AS e
    ON ece.id_evento = e.id_evento
    JOIN curso AS c
    ON ece.id_curso = c.idCurso
    JOIN estudante AS es
    ON ece.matricula = es.matricula
    JOIN usuario AS u 
    ON es.id_usuario = u.id_usuario";

    $stmt = $conn->prepare($query);
    $stmt->execute();

    echo json_encode($stmt->get_result()->fetch_all(MYSQLI_ASSOC));
?>

