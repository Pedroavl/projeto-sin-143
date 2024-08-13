<?php 
    include "../../../backend/database/connection/connect.inc.php";
    include "../../../backend/class/Evento/evento.class.php";

    $eventos = new Evento($conn);

    $data = $eventos->read_eventos();

    //var_dump($eventos->read_eventos());

    echo json_encode($data);

    exit();
?>

