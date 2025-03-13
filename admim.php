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

$senhaSecreta = "1234";
$senhaIncorreta = false;
$clientesEncontrados = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $senhaDigitada = $_POST['password'];

    // Verifica se a senha está correta
    if ($senhaDigitada === $senhaSecreta) {
        $sql = "SELECT * FROM clientes";
        $result = $conn->query($sql);
        
        // Verifica se há resultados
        $clientesEncontrados = $result->num_rows > 0;
    } else {
        $senhaIncorreta = true;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Consultório de Psiquiatria</title>
</head>
<body style="display: flex; justify-content: center; align-items: center; height: 100vh; background-color: rgb(69, 168, 214); animation: background-animation 8s infinite alternate; font-family: Arial, sans-serif;">
    <div class="login-container" style="width: 100%; max-width: 400px; padding: 20px;">
        <div class="login-box" style="background-color: #fff; padding: 30px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1); border-radius: 10px;">
            <h2 style="text-align: center; margin-bottom: 20px; color: #333; font-size: 28px;">Login</h2>
            <form method="post">
                <div class="input-group" style="margin-bottom: 15px;">
                    <label for="password" style="display: block; margin-bottom: 5px; color: #555;">Senha</label>
                    <input type="password" id="password" name="password" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px; transition: border-color 0.3s;">
                </div>
                <button type="submit" class="login-button" style="width: 100%; padding: 10px; background-color: rgb(69, 168, 214); color: white; border: none; border-radius: 5px; font-size: 16px; cursor: pointer;">Entrar</button>
            </form>

            <!-- Mensagens de erro e sucesso -->
            <div id="senhaIncorretaMsg" style="display: <?php echo $senhaIncorreta ? 'block' : 'none'; ?>; color: red; margin-top: 10px; text-align: center;">
                Senha incorreta!
            </div>

            <div id="nenhumClienteMsg" style="display: <?php echo (!$clientesEncontrados && !$senhaIncorreta && $_SERVER["REQUEST_METHOD"] == "POST") ? 'block' : 'none'; ?>; color: red; margin-top: 10px; text-align: center;">
                Não há clientes encontrados.
            </div>
        </div>

        <!-- Exibição dos clientes, caso encontrados -->
        <?php if ($clientesEncontrados) : ?>
            <div class="success-message" style="display: block; color: green; margin-top: 10px; text-align: center;">
        <h2>Clientes</h2>
        <ul style="list-style: none; padding: 0;"> <!-- Remove os bullets -->
            <?php while ($row = $result->fetch_assoc()): ?>
                <li style="border-top: 1px solid #ccc; border-bottom: 1px solid #ccc; padding: 10px; margin-top: 10px; background-color: #f9f9f9; border-radius: 5px;">
                    <strong>Nome: </strong><?php echo $row["nome"]; ?><br>
                    <strong>E-mail: </strong><?php echo $row["email"]; ?><br>
                    <strong>Especialidade: </strong><?php echo $row["especialidade"]; ?><br>
                    <strong>Cidade: </strong><?php echo $row["cidade"]; ?><br>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
        <?php endif; ?>
    </div>
</body>
</html>

