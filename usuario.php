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
    die("<div style='text-align: center; color: red; font-size: 18px;'>Erro: Preencha todos os campos obrigatórios.</div>");
}

// Configurações do banco de dados
$server = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'formulario1';

// Conexão com o banco
$conn = new mysqli($server, $usuario, $senha, $banco);
if ($conn->connect_error) {
    die("<div style='text-align: center; color: red; font-size: 18px;'>Falha ao se comunicar com o banco de dados: " . $conn->connect_error . "</div>");
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
        die("<div style='text-align: center; color: red; font-size: 18px;'>Erro ao salvar a imagem.</div>");
    }
}

// Preparação e execução da query
$smtp = $conn->prepare("INSERT INTO clientes (nome, sobrenome, email, data_nascimento, especialidade, genero, cidade, estado, data, hora) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
if ($smtp === false) {
    die("<div style='text-align: center; color: red; font-size: 18px;'>Erro ao preparar a query: " . $conn->error . "</div>");
}
$smtp->bind_param("ssssssssss", $nome, $sobrenome, $email, $data_nasc, $especialista, $genero, $cidade, $estado, $data, $hora);

if ($smtp->execute()) {
    echo '<div style="text-align: center; color: green; font-size: 20px; background-color: #d4edda; padding: 20px; border-radius: 10px; margin: 20px auto; max-width: 400px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">Cadastro Realizado com Sucesso!</div>';
} else {
    echo '<div style="text-align: center; color: red; font-size: 20px; background-color: #f8d7da; padding: 20px; border-radius: 10px; margin: 20px auto; max-width: 400px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">Erro no cadastro de usuário: ' . $smtp->error . '</div>';
}

// Fechando conexão
$smtp->close();
$conn->close();
?>
