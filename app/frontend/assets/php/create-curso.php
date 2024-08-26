<?php
    include "../../../backend/class/Curso/curso.class.php";
    include "../../../backend/database/connection/connect.inc.php";

    //começar sessão do adm

    $curso = new Curso($conn);

    if (isset($_POST['cadastrar_curso'])) {
        $data = [
            'titulo' => $_POST['title'],
            'descricao' => $_POST['description'],
            'id_administrador' => 1
        ];


        $curso ->create_curso($data);

        header("Location: ../html/administrator/cursos-adm.html");
    }
?>