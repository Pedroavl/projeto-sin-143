<?php 
    include "../../../backend/database/connection/connect.inc.php";
    include "../../../backend/class/Usuario/usuario.class.php";
    include "../../../backend/class/Estudante/estudante.class.php";

    //print_r($_REQUEST);

    if($_POST['submit'] == 'login'){
        
        print_r($_REQUEST);

    }else if($_POST['submit'] == 'register'){
        $user = new Usuario($conn);

        //verifica se o email já está registrado
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

        }else {
            var_dump('email já registrado');
        }

    }else {
        header('Location: ../html/login.html');
    }

?>