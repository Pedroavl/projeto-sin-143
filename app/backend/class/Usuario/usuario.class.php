<?php
/**
 *  Classe Usuários
 *  Criação, Listagem, Atualização e Remoção
 */ 

class Usuario {

    public $conn;

    public function __construct($db) {
        $this->conn = $db;
    } 

    public function create_user($post) {
        $user_pass = $post['senha'];

        // Criptografando a senha
        $user_pass_hash = password_hash($user_pass, PASSWORD_DEFAULT);

        $sql = "INSERT INTO Usuario (email, senha, nome) VALUES ('".$post['email']."', '".$user_pass_hash."', '".$post['nome']."')";

        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            echo "ERRO: $sql<br>".$this->conn->error."<br>";
            return false;
        }
    }

    public function read_user() {
        $sql = "SELECT * FROM Usuario";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

}