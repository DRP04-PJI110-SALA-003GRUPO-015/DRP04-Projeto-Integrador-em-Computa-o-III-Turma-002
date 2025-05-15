<?php

// Pegando os dados do formulário
$nome = $_POST['validationDefault01'] ?? null;
$sobrenome = $_POST['validationDefault02'] ?? null;
$email = $_POST['validationDefaultUsername'] ?? null;
$data_nasc = $_POST['validationDefault03'] ?? null;
$especialista = $_POST['validationDefault04'] ?? null;
$genero = $_POST['validationDefault05'] ?? null;
$cidade = $_POST['validationDefault06'] ?? null;
$estado = $_POST['validationDefault07'] ?? null;
$data = date('Y-m-d');
$hora = date('H:i:s');

// Validando campos obrigatórios
if (!$nome || !$sobrenome || !$email || !$data_nasc || !$especialista || !$genero || !$cidade || !$estado) {
    die("Erro: Preencha todos os campos obrigatórios.");
}

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

// Upload de imagem
$imagem_path = null;
if (isset($_FILES['validationDefaultImage']) && $_FILES['validationDefaultImage']['error'] === UPLOAD_ERR_OK) {
    $imagem_dir = 'uploads/';
    $imagem_nome = basename($_FILES['validationDefaultImage']['name']);
    $imagem_path = $imagem_dir . uniqid() . "_" . $imagem_nome;

    if (!is_dir($imagem_dir)) {
        mkdir($imagem_dir, 0777, true);
    }

    if (!move_uploaded_file($_FILES['validationDefaultImage']['tmp_name'], $imagem_path)) {
        die("Erro ao salvar a imagem.");
    }
}

// Preparação e execução da query
$smtp = $conn->prepare("INSERT INTO clientes (nome, sobrenome, email, data_nascimento, especialidade, genero, cidade, estado, data, hora) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
if ($smtp === false) {
    die("Erro ao preparar a query: " . $conn->error);
}
$smtp->bind_param("ssssssssss", $nome, $sobrenome, $email, $data_nasc, $especialista, $genero, $cidade, $estado, $data, $hora);

if ($smtp->execute()) {
    echo '<div class="mensagem-sucesso">Cadastro Realizado com Sucesso!</div>';
} else {
    echo '<div class="mensagem-erro">Erro no cadastro de usuário: ' . $smtp->error . '</div>';
}

//if ($smtp->execute()) {
    echo "Cadastro Realizado com Sucesso!";
//} else {
//    echo "Erro no cadastro de usuário: " . $smtp->error;
//}

$smtp->close();
$conn->close();

?>
