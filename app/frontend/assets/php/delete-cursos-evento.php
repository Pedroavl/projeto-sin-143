<?php
    include "../../../backend/class/CursosEvento/cursoseventos.class.php";
    include "../../../backend/database/connection/connect.inc.php";

    $cursosEvento = new CursosEvento($conn);

    if (isset($_POST['deletar_curso_evento'])) {
        $cursosEvento->delete_curso_evento($_POST['id_evento'], $_POST['id_curso']);
    }
?>