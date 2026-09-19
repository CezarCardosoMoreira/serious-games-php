<?php
// Lógica simples de processamento de login ou exibição de mensagens, se necessário
$mensagem = "";
$status = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'login') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if (!empty($email) && !empty($senha)) {
        // Simulação de verificação no banco de dados (PDO)
        // Em um ambiente de produção real, você faria a consulta na tabela 'usuarios' e verificaria com password_verify()
        $status = "success";
        $mensagem = "<strong>Login realizado com sucesso!</strong> Redirecionando para os módulos de treinamento...";
    } else {
        $status = "error";
        $mensagem = "<strong>Atenção!</strong> Preencha todos os campos para entrar.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plataforma de Serious Games - Treinamento Corporativo</title>
    <link rel="stylesheet" href="./view/css/style.css">
    
    <style>
        /* Estilos adicionais específicos para alternar abas de Acesso / Cadastro */
       
     
        .form-section {
            display: none;
        }
        .form-section.active {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        .intro-box {
            background-color: #f8fafc;
            border-left: 4px solid #3b82f6;
            padding: 16px;
            border-radius: 4px;
            margin-bottom: 24px;
        }
        .intro-box h3 {
            font-size: 1.05rem;
            color: #0f172a;
            margin-bottom: 6px;
        }
        .intro-box p {
            font-size: 0.9rem;
            color: #475569;
            line-height: 1.5;
        }
        .alinhamento {
            display: flex;
            justify-content: center; /* centraliza horizontalmente */
            align-items: center;     /* centraliza verticalmente */
        }
        .btn-login {
            display: inline;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            padding: auto;
            
        }
    </style>
</head>
<body class="alinhamento">
    <div class="game-container" style="max-width: 550px;">
        <!-- Cabeçalho Principal -->
        <header class="game-header">
            <h1>Plataforma de Treinamento Corporativo</h1>
            <p style="color: #94a3b8; font-size: 0.9rem; margin-top: 4px;">Ambiente de Simulação e Serious Games Educacionais</p>
        </header>

        <main class="scenario-box">
            
            <!-- Introdução Rápida sobre o Projeto -->
            <div class="intro-box">
                <h3>Sobre a Plataforma</h3>
                <p>Bem-vindo ao sistema de capacitação profissional baseado em simulações interativas. Aqui, você aprimora habilidades e toma decisões estratégicas em cenários corporativos reais com feedback instantâneo e seguro.</p>
            </div>

            <!-- Exibição de Mensagens/Feedback do Sistema -->
            <?php if (!empty($mensagem)): ?>
                <div class="feedback-box <?php echo $status; ?>" style="margin-bottom: 20px;">
                    <p><?php echo $mensagem; ?></p>
                </div>
            <?php endif; ?>

            <!-- Abas de Navegação (Entrar / Criar Conta) -->
            <div >
                <a href="login.php"  class="btn-login">Login</a>
                <a href="cadastro.php" class="btn-login">Cadastro</a>          
            </div>

            

            
        </main>
    </div>

   
</body>
</html>