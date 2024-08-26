<?php 
    include "../../../backend/database/connection/connect.inc.php";
    include "../../../backend/class/Curso/curso.class.php";

    $cursos = new Curso($conn);

    $data = $cursos->read_cursos();

    echo json_encode($data);

    exit();
?>

