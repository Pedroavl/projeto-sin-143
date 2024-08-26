<?php 
    include "../../../backend/database/connection/connect.inc.php";
    include "../../../backend/class/Usuario/usuario.class.php";
    include "../../../backend/class/Estudante/estudante.class.php";
    include "../../../backend/class/Administrador/administrador.class.php";

    if($_POST['old_role'] == 1){

        $user = new Usuario($conn);
        $user->update_user_adm($_POST);

        if($_POST['old_role'] != $_POST['role_id']){
            $estudante = new Estudante($conn);
            $adm = new Administrador($conn);

            //$matricula = $estudante->get_student_by_user($_POST['id_usuario']);
            //$estudante->delete_student($matricula['matricula']);
            $res = $estudante->delete_student_by_user_id($_POST['id_usuario']);

            $adm->create_administrador($_POST);
        }

        header("Location: ../html/administrator/users-adm.html");

    }else if($_POST['old_role'] == 0){

        $user = new Usuario($conn);
        $user->update_user_adm($_POST);

        if($_POST['old_role'] != $_POST['role_id']){
            $estudante = new Estudante($conn);
            $adm = new Administrador($conn);
            
            $id_adm = $adm->get_administrador_by_user($_POST['id_usuario']);

            $adm->delete_administrador($id_adm['id_administrador']);

            $data = [
                'matricula' => $_POST['matricula'],
                'id_usuario' => $_POST['id_usuario'],
                'pontuacao' => 0
            ];

            $estudante->create_student($data);
        }

        header("Location: ../html/administrator/users-adm.html");
    }

?>