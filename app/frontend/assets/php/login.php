<?php 
    session_start();
    include "../../../backend/database/connection/connect.inc.php";
    include "../../../backend/class/Usuario/usuario.class.php";
    include "../../../backend/class/Estudante/estudante.class.php";

    //print_r($_REQUEST);

    if($_POST['submit'] == 'login'){   
        $student = new Estudante($conn);
        $user = new Usuario($conn);

        // Se matricula
        if($student->estudante_existe($_POST['emailMat'])){
            // Consulta senha
            $query = "SELECT U.senha, U.id_usuario, U.email, U.nome FROM Usuario as U JOIN Estudante as E ON E.id_usuario = U.id_usuario WHERE E.matricula = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $_POST['emailMat']);
            $stmt->execute();
            $result = $stmt->get_result();
            $data = $result->fetch_assoc();

            // Verifica a senha
            if($data && password_verify($_POST['senha'], $data['senha'])){
                print_r($data);
                $_SESSION['id_usuario'] = $data['id_usuario'];
                $_SESSION['email'] = $data['email'];  
                $_SESSION['nome'] = $data['nome'];
                echo $_SESSION['email'];
                echo $_SESSION['id_usuario'];
                echo $_SESSION['nome'];
                
                if($user->is_administrador($data['id_usuario'])){
                    header('Location: ../html/administrator/main-page-adm.html');
                }elseif($user->is_estudante($data['id_usuario']) && !$user->is_administrador($data['id_usuario'])) {
                    header('Location: ../html/main-page.html');
                }
            }else {
                print_r('Dados Invalidos');
            }

            // Se email
        }else if($user->read_user_by_email($_POST['emailMat'])){
            // Consulta senha
            $query = "SELECT senha, id_usuario, role_id, nome FROM Usuario WHERE email = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $_POST['emailMat']);
            $stmt->execute();
            $result = $stmt->get_result();
            $data = $result->fetch_assoc();

            // Verifica a senha
            if($data && password_verify($_POST['senha'], $data['senha'])){
                print_r($data);
                $_SESSION['id_usuario'] = $data['id_usuario'];
                $_SESSION['email'] = $_POST['emailMat'];
                $_SESSION['nome'] = $data['nome'];
                $_SESSION['role_id'] = $data['role_id'];
                echo $_SESSION['email'];
                echo $_SESSION['id_usuario'];
                echo $_SESSION['nome'];
                echo $_SESSION['role_id'];

                if($user->is_administrador($data['id_usuario'])){
                    header('Location: ../html/administrator/main-page-adm.html');
                }elseif($user->is_estudante($data['id_usuario']) && !$user->is_administrador($data['id_usuario'])) {
                    header('Location: ../html/main-page.html');
                }
            }else {
                print_r('Dados Invalidos');
            }
        }else {
            print_r('Dados Invalidos');
        }

    }/*else {
        header('Location: ../html/login.html');
    }*/

?>