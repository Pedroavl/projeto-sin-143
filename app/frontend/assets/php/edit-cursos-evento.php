<?php
    include "../../../backend/class/CursosEvento/cursoseventos.class.php";
    include "../../../backend/database/connection/connect.inc.php";

    $cursosEvento = new cursosEvento($conn);

    if(isset($_POST['editar_cursos_evento'])) {
        $data = [
            'quantidade_vagas' => $_POST['vacancy'],
            'data' => $_POST['date'],
            'horario_inicio' => $_POST['startTime'],
            'horario_fim' => $_POST['endTime'],
            'id_evento' => $_POST['id_evento'],
            'id_curso' => $_POST['id_curso']
        ];

        $cursosEvento->update_curso_evento($data);

        header("Location: ../html/administrator/cursos-evento-adm.php?id_evento={$data['id_evento']}");
    }
?>