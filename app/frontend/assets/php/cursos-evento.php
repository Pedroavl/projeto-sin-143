<?php 
    include "../../../backend/database/connection/connect.inc.php";
    include "../../../backend/class/Curso/curso.class.php";
    include "../../../backend/class/CursosEvento/cursoseventos.class.php";

    $cursosEvento = new CursosEvento($conn);

    $data = $cursosEvento->read_cursos_evento($_POST['id_evento']);

    echo json_encode($data);
?>

