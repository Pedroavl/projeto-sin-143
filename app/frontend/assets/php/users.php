<?php 
    include "../../../backend/database/connection/connect.inc.php";
    include "../../../backend/class/Usuario/usuario.class.php";

    $users = new Usuario($conn);

    $data = $users->read_user();

    echo json_encode($data);

    exit();
?>

