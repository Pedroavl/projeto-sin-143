<?php 
    include "../../../backend/database/connection/connect.inc.php";
    include "../../../backend/class/Curso/curso.class.php";

    $cursos = new Curso($conn);

    $data = $cursos->read_curso($_POST['id_curso']);

    echo json_encode($data);

    exit();
?>

