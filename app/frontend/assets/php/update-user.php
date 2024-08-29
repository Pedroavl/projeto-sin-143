<?php 
    session_start();
    include "../../../backend/database/connection/connect.inc.php";
    include "../../../backend/class/Usuario/usuario.class.php";

    $user = new Usuario($conn);

    if($_POST['senha'] != ""){
            if($user->read_user_by_email($_POST['email']) == NULL || $_POST['email'] == $_SESSION['email']){
                
                $user->update_user($_POST);
        
                session_destroy();
                header("Location: ../html/login.html");
            } else {
                echo "O email já está registrado!";
                exit();
            }
    }

?>