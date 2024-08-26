<?php 
    include "../../../backend/database/connection/connect.inc.php";
    include "../../../backend/class/Usuario/usuario.class.php";
    include "../../../backend/class/Estudante/estudante.class.php";
    include "../../../backend/class/Administrador/administrador.class.php";



    if($_POST['role'] == 0){

        $user = new Usuario($conn);

        if($user->read_user_by_email($_POST['email']) == NULL){
            $user->create_user($_POST);
            $id = $user->read_user_by_email($_POST['email'])['id_usuario'];

            $data = [
                'id_usuario' => $id
            ];

            $adm = new Administrador($conn);
            $adm->create_administrador($data);

            header("Location: ../html/administrator/users-adm.html");

        }else {
            print_r('email já registrado');
        }
        
    }else if($_POST['role'] == 1){

        $user = new Usuario($conn);
        
        if($user->read_user_by_email($_POST['email']) == NULL){
            $user->create_user($_POST);
            $id = $user->read_user_by_email($_POST['email'])['id_usuario'];

            $data = [
                'matricula' => $_POST['matricula'], 
                'pontuacao' => 0, 
                'id_usuario' => $id
            ];

            $student = new Estudante($conn);
            $student->create_student($data);

            header("Location: ../html/administrator/users-adm.html");

        }else {
            print_r('email já registrado');
        }
    }

?>