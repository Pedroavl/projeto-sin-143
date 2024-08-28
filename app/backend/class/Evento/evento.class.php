<?php
/**
 * Classe Evento
 * Criação, Listagem, Atualização e Remoção
 */ 

class Evento {
    private $conn;
    private $table_name = "Evento";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read_evento($id_evento) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_evento = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $id_evento);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }


    public function read_eventos() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function create_evento($data) {
        $query = "INSERT INTO " . $this->table_name . " (nome, descricao, quantidade_cursos, data_inicio, data_fim, encerrado, local, data_criacao, id_administrador, imagem) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        $data_criacao = date("Y-m-d");
        $quantidade_cursos = $this->count_cursos($data['id_evento']);

        if(isset($_POST['cadastrar_evento'])) {
            // print_r($_FILES['imagem_evento']);
            if(!empty($_FILES['imagem_evento']['name'])) {
                $nome_imagem = $_FILES['imagem_evento']['name'];
                $tipo = $_FILES['imagem_evento']['type'];
                $nome_temporario = $_FILES['imagem_evento']['tmp_name'];
                $tamanho = $_FILES['imagem_evento']['size'];
                $erros = array();

                $tamanhoMax = 1024 * 1024 * 6;  // 6MB

                // Valida o tamanho 
                if($tamanho > $tamanhoMax) {
                    $erros[] = "O arquivo excede o tamanho máximo de 6mb!<br/>";
                }

                // tipos de arquivos permitidos
                $arquivos_permitidos = ["png", "jpg", "jpeg", "webp"];

                // pega a extensão do arquivo por exemplo .jpg, .png
                $extensao = pathinfo($nome_imagem, PATHINFO_EXTENSION);

                // var_dump($extensao);

                // Checa se a extensão do arquivo bate com a dos arquivos permitidos
                if(!in_array($extensao, $arquivos_permitidos)) {
                    $erros[] = "O arquivo que você enviou não é permitido!<br />";
                }

                // Mime Types permitidos
                $tipos_permitidos = ["image/png", "image/jpg", "image/jpeg", "image/webp"];

                // Chjeca se o tipo do arquivo bate com a dos mime types permitidos
                if(!in_array($tipo, $tipos_permitidos)) {
                    $erros[] = "O tipo de arquivo não é permitido!<br />";
                }

                // Mostra os erros
                if(!empty($erros)) {
                    foreach($erros as $erro) {
                        echo $erro;
                    }
                } else {
                    $caminho = "../../../frontend/assets/images/";
                    $data_atual = date("d-m-Y_h-i");
                    $destino = $caminho;
                    $novo_nome = '-'.$data_atual.'-'.$nome_imagem;

                    if(move_uploaded_file($nome_temporario, $destino.$novo_nome)) {
                        echo "Envio de arquivo feito com sucesso!<br />";
                    } else {
                        echo "Ocorreu um erro no envio do seu arquivo. Tente novamente!<br />";
                    }
                }
            }
        }

        $imagem_db = $destino.$novo_nome;
        

        $stmt->bind_param("ssisssssss", $data['nome'], $data['descricao'], $quantidade_cursos, $data['data_inicio'], $data['data_fim'], $data['encerrado'], $data['local'], $data_criacao, $data['id_administrador'], $imagem_db);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function update_evento($data) {
        $quantidade_cursos = $this->count_cursos($data['id_evento']);

        $imagem = !empty($_FILES['imagem_evento']['name']) ? $_FILES['imagem_evento']['name'] :   "";


        if(!empty($imagem)) {
            $caminho_img = "../../../frontend/assets/images/";
            if(isset($_POST['editar_evento'])) {
                // print_r($_FILES['imagem_evento']);
                if(!empty($_FILES['imagem_evento']['name'])) {
                    $nome_imagem = $_FILES['imagem_evento']['name'];
                    $tipo = $_FILES['imagem_evento']['type'];
                    $nome_temporario = $_FILES['imagem_evento']['tmp_name'];
                    $tamanho = $_FILES['imagem_evento']['size'];
                    $erros = array();
    
                    $tamanhoMax = 1024 * 1024 * 6;  // 6MB
    
                    // Valida o tamanho 
                    if($tamanho > $tamanhoMax) {
                        $erros[] = "O arquivo excede o tamanho máximo de 6mb!<br/>";
                    }
    
                    // tipos de arquivos permitidos
                    $arquivos_permitidos = ["png", "jpg", "jpeg", "webp"];
    
                    // pega a extensão do arquivo por exemplo .jpg, .png
                    $extensao = pathinfo($nome_imagem, PATHINFO_EXTENSION);
    
                    // var_dump($extensao);
    
                    // Checa se a extensão do arquivo bate com a dos arquivos permitidos
                    if(!in_array($extensao, $arquivos_permitidos)) {
                        $erros[] = "O arquivo que você enviou não é permitido!<br />";
                    }
    
                    // Mime Types permitidos
                    $tipos_permitidos = ["image/png", "image/jpg", "image/jpeg", "image/webp"];
    
                    // Chjeca se o tipo do arquivo bate com a dos mime types permitidos
                    if(!in_array($tipo, $tipos_permitidos)) {
                        $erros[] = "O tipo de arquivo não é permitido!<br />";
                    }
                
                    // Mostra os erros
                    if(!empty($erros)) {
                        foreach($erros as $erro) {
                            echo $erro;
                        }
                    } else {
                        $caminho = $caminho_img;
                        $data_atual = date("d-m-Y_h-i");
                        $destino = $caminho;
                        $novo_nome = '-'.$data_atual.'-'.$nome_imagem;

                        
                        echo $imagem;
                        if(move_uploaded_file($nome_temporario, $destino.$novo_nome)) {
                            echo "Envio de arquivo feito com sucesso!<br />";
                        } else {
                            echo "Ocorreu um erro no envio do seu arquivo. Tente novamente!<br />";
                        }
                    }
                }
            }
        }
        // Verifica se a imagem não esta vazia
        if(!empty($imagem)) {
            $imagem_db = $destino.$novo_nome;
            echo $imagem_db;
            $query = "UPDATE " . $this->table_name . " SET nome = ?, descricao = ?, quantidade_cursos = ?, data_inicio = ?, data_fim = ?, encerrado = ?, local = ?, id_administrador = ?, imagem = ? WHERE id_evento = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ssissssisi", $data['nome'], $data['descricao'], $quantidade_cursos, $data['data_inicio'], $data['data_fim'], $data['encerrado'], $data['local'], $data['id_administrador'], $imagem_db, $data['id_evento']);
        } else {
            $query = "UPDATE " . $this->table_name . " SET nome = ?, descricao = ?, quantidade_cursos = ?, data_inicio = ?, data_fim = ?, encerrado = ?, local = ?, id_administrador = ? WHERE id_evento = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ssissssii", $data['nome'], $data['descricao'], $quantidade_cursos, $data['data_inicio'], $data['data_fim'], $data['encerrado'], $data['local'], $data['id_administrador'], $data['id_evento']);
        }
        

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function delete_evento($id_evento) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_evento = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_evento);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    private function count_cursos($id_evento) {
        $query = "SELECT COUNT(*) as total FROM cursos_evento WHERE id_evento = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_evento);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'];
    }
}
