<?php
    include "../../../backend/class/Curso/curso.class.php";
    include "../../../backend/database/connection/connect.inc.php";

    $curso = new Curso($conn);

    if (isset($_POST['deletar_curso'])) {
        $curso->delete_curso($_POST['id_curso']);
    }
?>