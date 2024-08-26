<?php
    include "../../../backend/class/Evento/evento.class.php";
    include "../../../backend/database/connection/connect.inc.php";

    $evento = new Evento($conn);
    if(isset($_POST['editar_evento'])) {
        $data = [
            'nome' => $_POST['title'],
            'descricao' => $_POST['description'],
            'quantidade_cursos' => 0,
            'data_inicio' => $_POST['beginData'],
            'data_fim' => $_POST['endData'],
            'local' => $_POST['location'],
            'id_administrador' => 1,
            'encerrado' => '0',
            'imagem_evento' => '',
            'id_evento' => $_POST['id_evento']
        ];

        //print_r($_FILES['imagem_evento']['full_path']);

        $evento->update_evento($data);

        //header("Location: ../html/administrator/main-page-adm.html");
    }
?>