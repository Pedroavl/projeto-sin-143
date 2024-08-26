<?php
    include "../../../backend/class/Evento/evento.class.php";
    include "../../../backend/database/connection/connect.inc.php";

    //começar sessão do adm

    $evento = new Evento($conn);

    if (isset($_POST['cadastrar_evento'])) {
        $data = [
            'nome' => $_POST['title'],
            'descricao' => $_POST['description'],
            'quantidade_cursos' => 0,
            'data_inicio' => $_POST['beginData'],
            'data_fim' => $_POST['endData'],
            'local' => $_POST['location'],
            'id_administrador' => 1,
            'encerrado' => '0',
            'imagem_evento' => ''
        ];

        print_r($_FILES['imagem_evento']['full_path']);

        $evento->create_evento($data);

        header("Location: ../html/administrator/main-page-adm.html");

        /*if (isset($_FILES['imagem_evento']) && $_FILES['imagem_evento']['error'] == 0) {
            $nomeArquivo = $_FILES['imagem_evento']['name'];
            $tipoArquivo = $_FILES['imagem_evento']['type'];
            $tamanhoArquivo = $_FILES['imagem_evento']['size'];
            $nomeTemporario = $_FILES['imagem_evento']['tmp_name'];

            $dataAtual = date("d-m-Y_h-i");

            $diretorioDestino = '../../../frontend/assets/images/';
            $novoNome = '-'.$dataAtual.'-'.$nomeArquivo;
            
            if (!is_dir($diretorioDestino)) {
                mkdir($diretorioDestino, 0755, true);
            }

            var_dump(move_uploaded_file($nomeTemporario, $diretorioDestino . $novoNome));

            if (move_uploaded_file($nomeTemporario, $diretorioDestino . $novoNome)) {
                $data['imagem_evento'] = $diretorioDestino . $novoNome;
                $evento->create_evento($data);
                echo "Arquivo enviado com sucesso!";
            } else {
                echo "Erro ao mover o arquivo para o diretório de destino.";
            }
        } else {
            $evento->create_evento($data);
            echo "Erro no upload do arquivo: " . $_FILES['imagem_evento']['error'];
        }*/
    }
?>