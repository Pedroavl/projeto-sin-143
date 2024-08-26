<?php 
    include "../../../backend/class/Usuario/usuario.class.php";
    include "../../../backend/database/connection/connect.inc.php";

    $user = new Usuario($conn);

    if($user->is_logged()){
        echo "O usuário está logado";
    }else {
        session_destroy();
        //echo "O usuário não está logado";
        echo '<script>window.location.href = "../html/about.html";</script>';
        //header("Location: ../html/about.html");
    }
?>