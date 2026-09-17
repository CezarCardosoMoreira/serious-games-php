<?php
require_once '../model/conexao.php';
// Configurações de Conexão com o Banco de Dados (PDO)
$host = 'localhost';
$dbname = 'db_serious_games';
$username = 'root'; // Altere conforme o seu ambiente (Laragon/MySQL)
$password = '';     // Altere conforme a sua senha

$mensagem = "";
$status = "";

// Verifica se o formulário foi submetido via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $idade = filter_var($_POST['idade'] ?? 0, FILTER_VALIDATE_INT);
    $setor = trim($_POST['setor'] ?? '');
    $cargo = trim($_POST['cargo'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senhaPura = $_POST['senha'] ?? '';

    // Validação básica dos campos
    if (!empty($nome) && $idade > 0 && !empty($setor) && !empty($cargo) && !empty($email) && !empty($senhaPura)) {
        try {
            // Conexão com o banco via PDO
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Criptografia segura da senha
            $senhaCriptografada = password_hash($senhaPura, PASSWORD_DEFAULT);

            // Query de inserção com os novos campos
            $sql = "INSERT INTO usuarios (nome, idade, setor, cargo, email, senha) VALUES (:nome, :idade, :setor, :cargo, :email, :senha)";
            $stmt = $pdo->prepare($sql);
            
            $stmt->execute([
                ':nome' => $nome,
                ':idade' => $idade,
                ':setor' => $setor,
                ':cargo' => $cargo,
                ':email' => $email,
                ':senha' => $senhaCriptografada
            ]);

            $status = "success";
            $mensagem = "<strong>Sucesso!</strong> Colaborador <strong>{$nome}</strong> cadastrado com sucesso no sistema.";

        } catch (PDOException $e) {
            $status = "error";
            if ($e->getCode() == 23000) {
                $mensagem = "<strong>Erro:</strong> Este e-mail já está cadastrado no sistema.";
            } else {
                $mensagem = "<strong>Erro no Banco de Dados:</strong> " . $e->getMessage();
            }
        }
    } else {
        $status = "error";
        $mensagem = "<strong>Atenção!</strong> Preencha todos os campos corretamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Colaborador - Plataforma de Treinamento</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <div class="game-container" style="max-width: 600px;">
        <!-- Cabeçalho -->
        <header class="game-header">
            <h1>Cadastro de Colaborador</h1>
            <p style="color: #94a3b8; font-size: 0.9rem; margin-top: 4px;">Insira as informações profissionais para acesso ao treinamento</p>
        </header>

        <!-- Formulário -->
        <main class="scenario-box">
            
            <?php if (!empty($mensagem)): ?>
                <div class="feedback-box <?php echo $status; ?>" style="margin-bottom: 20px;">
                    <p><?php echo $mensagem; ?></p>
                </div>
            <?php endif; ?>

            <form action="cadastro.php" method="POST" style="display: flex; flex-direction: column; gap: 15px;">
                
                <div>
                    <label style="display: block; font-size: 0.9rem; font-weight: 600; color: #334155; margin-bottom: 5px;">Nome Completo</label>
                    <input type="text" name="nome" required placeholder="Digite o nome completo" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.95rem; outline: none;">
                </div>

                <div style="display: flex; gap: 15px;">
                    <div style="flex: 1;">
                        <label style="display: block; font-size: 0.9rem; font-weight: 600; color: #334155; margin-bottom: 5px;">Idade</label>
                        <input type="number" name="idade" required min="18" max="100" placeholder="Ex: 30" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.95rem; outline: none;">
                    </div>
                    <div style="flex: 2;">
                        <label style="display: block; font-size: 0.9rem; font-weight: 600; color: #334155; margin-bottom: 5px;">Setor</label>
                        <input type="text" name="setor" required placeholder="Ex: Tecnologia da Informação" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.95rem; outline: none;">
                    </div>
                </div>

                <div>
                    <label style="display: block; font-size: 0.9rem; font-weight: 600; color: #334155; margin-bottom: 5px;">Cargo</label>
                    <input type="text" name="cargo" required placeholder="Ex: Desenvolvedor Back-end" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.95rem; outline: none;">
                </div>

                <div>
                    <label style="display: block; font-size: 0.9rem; font-weight: 600; color: #334155; margin-bottom: 5px;">E-mail Corporativo</label>
                    <input type="email" name="email" required placeholder="seu.nome@empresa.com" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.95rem; outline: none;">
                </div>

                <div>
                    <label style="display: block; font-size: 0.9rem; font-weight: 600; color: #334155; margin-bottom: 5px;">Senha de Acesso</label>
                    <input type="password" name="senha" required placeholder="Mínimo de 6 caracteres" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.95rem; outline: none;">
                </div>

                <button type="submit" class="btn-decision" style="justify-content: center; background-color: #0f172a; color: #fff; border-color: #0f172a; font-weight: 600; margin-top: 10px; cursor: pointer;">
                    Cadastrar Colaborador
                </button>
                <a href="index.php" class="btn-decision" style="justify-content: center; background-color: #0f172a; color: #fff; border-color: #0f172a; font-weight: 600; margin-top: 10px; cursor: pointer;">
                    Voltar
            </a>
            </form>
        </main>
    </div>
</body>
</html>