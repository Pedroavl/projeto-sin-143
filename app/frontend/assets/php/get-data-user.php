<?php 
    include "../../../backend/database/connection/connect.inc.php";
    include "../../../backend/class/Estudante/estudante.class.php";

    session_start();

    $estudante = new Estudante($conn);

    $dataEstudante = $estudante->get_student_by_user($_SESSION['id_usuario']);
    $ranking = $estudante->ranking_estudantes($dataEstudante['matricula'])['classificacao'];

    $data = [
        'pontuacao' => $dataEstudante['pontuacao'],
        'ranking' => $ranking
    ];

    echo json_encode($data);
?>