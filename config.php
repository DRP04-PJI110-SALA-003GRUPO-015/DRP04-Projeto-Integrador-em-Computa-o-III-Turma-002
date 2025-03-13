<?php




// Configurações do banco de dados
$server = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'formulario1';

// Conexão com o banco
$conn = new mysqli($server, $usuario, $senha, $banco);
if ($conn->connect_error) {
    die("Falha ao se comunicar com o banco de dados: " . $conn->connect_error);
}



?>