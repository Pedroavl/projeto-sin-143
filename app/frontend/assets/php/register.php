<?php 
    session_start();
    include "../../../backend/database/connection/connect.inc.php";
    include "../../../backend/class/Usuario/usuario.class.php";
    include "../../../backend/class/Estudante/estudante.class.php";



    if($_POST['submit'] == 'register'){
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

            $_SESSION['id_usuario'] = $data['id_usuario'];
            $_SESSION['email'] = $_POST['email'];
            echo $_SESSION['id_usuario'];
            echo $_SESSION['email'];

        }else {
            print_r('email já registrado');
        }

    }

?>