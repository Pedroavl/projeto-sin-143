<?php 
    include "../../../backend/database/connection/connect.inc.php";
    include "../../../backend/class/Curso/curso.class.php";
    include "../../../backend/class/CursosEvento/cursoseventos.class.php";

    $cursosEvento = new CursosEvento($conn);

    $data = $cursosEvento->read_curso_evento($_POST['id_evento'], $_POST['id_curso']);

    echo json_encode($data);

    exit();
?>

