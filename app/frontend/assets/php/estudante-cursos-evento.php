<?php
    session_start();
    include "../../../backend/class/EstudanteCursosEvento/estudantecursoseventos.class.php";
    include "../../../backend/class/cursosEvento/cursoseventos.class.php";
    include "../../../backend/database/connection/connect.inc.php";
    include "../../../backend/class/Estudante/estudante.class.php";

    $estudanteCursosEvento = new EstudanteCursosEvento($conn);

    $cursosEvento = new CursosEvento($conn);

    $estudante = new Estudante($conn);

    $matricula = $estudante->get_student_by_user($_SESSION['id_usuario']);


    $data = [
        'matricula' => $matricula['matricula'],
        'id_evento' => $_POST['id_evento'],
        'id_curso' => $_POST['id_curso'],
        'horario_fim' => $_POST['horario_fim'],
        'horario_inicio' => $_POST['horario_inicio'],
        'data' => $_POST['data']
    ];


    $res = $estudanteCursosEvento->create_estudante_curso_evento($data);

    echo json_encode($res);

    exit();
?>