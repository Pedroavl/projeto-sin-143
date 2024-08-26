<?php
    include "../../../backend/class/Curso/curso.class.php";
    include "../../../backend/database/connection/connect.inc.php";

    $curso = new Curso($conn);
    if(isset($_POST['editar_curso'])) {
        $data = [
            'titulo' => $_POST['title'],
            'descricao' => $_POST['description'],
            'id_administrador' => 1,
            'idCurso' => $_POST['id_curso']
        ];

        $curso->update_curso($data);

        header("Location: ../html/administrator/cursos-adm.html");
    }
?>