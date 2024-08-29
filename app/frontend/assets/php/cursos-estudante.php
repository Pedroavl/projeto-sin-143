<?php
    include "../../../backend/database/connection/connect.inc.php";
    include "../../../backend/class/Estudante/estudante.class.php";
    include "../../../backend/class/Curso/curso.class.php";
    include "../../../backend/class/Evento/evento.class.php";
    include "../../../backend/class/CursosEvento/cursoseventos.class.php";
    include "../../../backend/class/EstudanteCursosEvento/estudantecursoseventos.class.php";

    session_start();

    $estudante = new Estudante($conn);
    $curso = new Curso($conn);
    $evento = new Evento($conn);
    $cursosEvento = new CursosEvento($conn);
    $estudanteCursosEvento = new EstudanteCursosEvento($conn);

    $matricula = $estudante->get_student_by_user($_SESSION['id_usuario'])['matricula'];


    $inscricoes = $estudanteCursosEvento->read_estudante_inscriptions($matricula);

    $data = [];

    foreach ($inscricoes as $inscricao) {

        $nomeCurso = $curso->read_curso($inscricao['id_curso'])['titulo'];
        $nomeEvento = $evento->read_evento($inscricao['id_evento'])['nome'];
        $dataCursosEvento = $cursosEvento->read_curso_evento($inscricao['id_evento'], $inscricao['id_curso']);

        $data[] = [
            'nome_evento' => $nomeEvento,
            'nome_curso' => $nomeCurso,
            'data' => $dataCursosEvento['data'],
            'horario' => $dataCursosEvento['horario_inicio'],
            'pontuacao' => $inscricao['pontuacao']
        ];
    }

    //var_dump($data);
    //var_dump($inscricoes);
    echo json_encode($data);
?>