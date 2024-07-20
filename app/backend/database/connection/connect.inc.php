<?php 

// Informações de acesso ao banco de dados
$host = "localhost";
$dbname = "EventControlDB";
$username = "root";
$password = "26122001";


$conn = new mysqli($host, $username, $password, $dbname);

// Verifica se a conn foi feita
if($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
