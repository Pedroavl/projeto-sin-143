<?php 
    include "../../../backend/database/connection/connect.inc.php";
    include "../../../backend/class/Usuario/usuario.class.php";
    include "../../../backend/class/Estudante/estudante.class.php";
    include "../../../backend/class/Administrador/administrador.class.php";

    if(isset($_POST['delete_user'])){
        if($_POST['role'] == 0){

            $user = new Usuario($conn);
            $adm = new Administrador($conn);

            $adm->delete_administrador_by_user_id($_POST['id_usuario']);
            $user->delete_user($_POST['id_usuario']);

            header("Location: ../html/administrator/users-adm.html");
            
        }else if($_POST['role'] == 1){

            $user = new Usuario($conn);
            $student = new Estudante($conn);
        
            $student->delete_student_by_user_id($_POST['id_usuario']);
            $user->delete_user($_POST['id_usuario']);

            header("Location: ../html/administrator/users-adm.html");

        }
    }

?>