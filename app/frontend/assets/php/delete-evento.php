<?php
    include "../../../backend/class/Evento/evento.class.php";
    include "../../../backend/database/connection/connect.inc.php";

    $evento = new Evento($conn);
    if (isset($_POST['deletar_evento'])) {
        $evento->delete_evento($_POST['id_evento']);
    }
?>