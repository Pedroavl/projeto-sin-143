<?php
    include "../../../backend/class/CursosEvento/cursoseventos.class.php";
    include "../../../backend/database/connection/connect.inc.php";

    //começar sessão do adm

    $cursosEvento = new CursosEvento($conn);


    if (isset($_POST['cadastrar_curso_evento'])) {
        $data = [
            'id_evento' => $_POST['id_evento'],
            'id_curso' => $_POST['id_curso'],
            'data' => $_POST['date'],
            'horario_inicio' => $_POST['startTime'],
            'horario_fim' => $_POST['endTime'],
            'quantidade_vagas' => $_POST['vacancy'],
            'quantidade_inscritos' => 0,
            'id_administrador' => 1
        ];

        $cursosEvento->create_curso_evento($data);

        header("Location: ../html/administrator/cursos-evento-adm.php?id_evento={$data['id_evento']}");
    }
?>