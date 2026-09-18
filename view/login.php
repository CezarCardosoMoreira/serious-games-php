<?php
require_once './model/conexao.php';
// Configurações de Conexão com o Banco de Dados (PDO)
$host = 'localhost';
$dbname = 'db_serious_games';
$username = 'root'; // Altere conforme o seu ambiente
$password = '';     // Altere conforme a sua senha

$mensagem = "";
$status = "";

// Verifica se o formulário de login foi submetido via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if (!empty($email) && !empty($senha)) {
        try {
            // Conexão com o banco via PDO
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Busca o usuário pelo e-mail na tabela
            $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':email' => $email]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verifica se o usuário existe e se a senha está correta
            // Verifica se o usuário existe e se a senha está correta
            if ($usuario && password_verify($senha, $usuario['senha'])) {
                
                // 1. Inicia a sessão para salvar os dados do usuário
                session_start();
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nome'] = $usuario['nome'];
                $_SESSION['usuario_email'] = $usuario['email'];

                // 2. Redireciona o navegador diretamente para o painel de escolhas (dashboard)
                header("Location: dashboard.php");
                exit(); // Encerra a execução do script para garantir o redirecionamento

           
            } else {
                $status = "error";
                $mensagem = "<strong>Erro:</strong> E-mail ou senha incorretos.";
            }

        } catch (PDOException $e) {
            $status = "error";
            $mensagem = "<strong>Erro de Conexão:</strong> " . $e->getMessage();
        }
    } else {
        $status = "error";
        $mensagem = "<strong>Atenção!</strong> Preencha o e-mail e a senha.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Plataforma de Serious Games</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <div class="game-container" style="max-width: 450px;">
        <!-- Cabeçalho -->
        <header class="game-header">
            <h1>Acesso à Plataforma</h1>
            <p style="color: #94a3b8; font-size: 0.9rem; margin-top: 4px;">Entre com suas credenciais corporativas</p>
        </header>

        <!-- Formulário de Login -->
        <main class="scenario-box">
            
            <?php if (!empty($mensagem)): ?>
                <div class="feedback-box <?php echo $status; ?>" style="margin-bottom: 20px;">
                    <p><?php echo $mensagem; ?></p>
                </div>
            <?php endif; ?>

            <form action="login.php" method="POST" style="display: flex; flex-direction: column; gap: 18px;">
                
                <div>
                    <label style="display: block; font-size: 0.9rem; font-weight: 600; color: #334155; margin-bottom: 6px;">E-mail Corporativo</label>
                    <input type="email" name="email" required placeholder="seu.nome@empresa.com" style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.95rem; outline: none;">
                </div>

                <div>
                    <label style="display: block; font-size: 0.9rem; font-weight: 600; color: #334155; margin-bottom: 6px;">Senha</label>
                    <input type="password" name="senha" required placeholder="Digite sua senha" style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.95rem; outline: none;">
                </div>

                <button type="submit" class="btn-decision" style="justify-content: center; background-color: #0f172a; color: #fff; border-color: #0f172a; font-weight: 600; margin-top: 10px; cursor: pointer;">
                    Entrar no Sistema
                </button>
                <a href="index.php" class="btn-decision" style="justify-content: center; background-color: #0f172a; color: #fff; border-color: #0f172a; font-weight: 600; margin-top: 10px; cursor: pointer;">
                    Voltar
            </a>

            </form>

            <div style="text-align: center; margin-top: 20px; font-size: 0.85rem; color: #64748b;">
                Ainda não possui cadastro? <a href="cadastro.php" style="color: #3b82f6; text-decoration: none; font-weight: 600;">Cadastre-se aqui</a>
            </div>
        </main>
    </div>
</body>
</html>