<?php
// Inicia a sessão para recuperar o nome do usuário logado (exemplo)
session_start();
$nomeUsuario = $_SESSION['usuario_nome'] ?? 'Colaborador';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Treinamento - Serious Games</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .module-grid {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 20px;
        }
        .module-card {
            background-color: #f8fafc;
            border: 2px solid #cbd5e1;
            border-radius: 8px;
            padding: 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .module-card:hover {
            border-color: #3b82f6;
            background-color: #eff6ff;
            transform: translateY(-2px);
        }
        .module-info h3 {
            font-size: 1.05rem;
            color: #0f172a;
            margin-bottom: 4px;
        }
        .module-info p {
            font-size: 0.85rem;
            color: #64748b;
        }
        .module-action {
            background-color: #0f172a;
            color: #fff;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        .module-card:hover .module-action {
            background-color: #3b82f6;
        }
    </style>
</head>
<body>
    <div class="game-container" style="max-width: 650px;">
        <!-- Cabeçalho -->
        <header class="game-header">
            <h1>Trilha de Treinamento Corporativo</h1>
            <p style="color: #94a3b8; font-size: 0.9rem; margin-top: 4px;">Olá, <strong><?php echo htmlspecialchars($nomeUsuario); ?></strong>. Selecione um módulo abaixo para iniciar os desafios:</p>
        </header>

        <!-- Corpo com a Lista de Escolhas (Temas 1, 2 e 3) -->
        <main class="scenario-box">
            <h2 style="font-size: 1.15rem; color: #0f172a; margin-bottom: 5px;">Módulos Disponíveis</h2>
            <p style="font-size: 0.9rem; color: #475569; margin-bottom: 20px;">Escolha por qual cenário de simulação deseja começar sua jornada:</p>

            <div class="module-grid">
                <!-- Tema 1 -->
                <a href="tema1.php" class="module-card">
                    <div class="module-info">
                        <h3>Tema 1: Segurança da Informação</h3>
                        <p>Identificação de e-mails suspeitos e prevenção contra phishing.</p>
                    </div>
                    <div class="module-action">Iniciar</div>
                </a>

                <!-- Tema 2 -->
                <a href="tema2.php" class="module-card">
                    <div class="module-info">
                        <h3>Tema 2: Engenharia Social</h3>
                        <p>Análise de abordagens maliciosas e proteção de dados corporativos.</p>
                    </div>
                    <div class="module-action">Iniciar</div>
                </a>

                <!-- Tema 3 -->
                <a href="tema3.php" class="module-card">
                    <div class="module-info">
                        <h3>Tema 3: Conformidade e LGPD</h3>
                        <p>Boas práticas no tratamento e armazenamento de informações sensíveis.</p>
                    </div>
                    <div class="module-action">Iniciar</div>
                </a>
            </div>

            <!-- Botão de Sair / Logout -->
            <div style="margin-top: 25px; text-align: center;">
                <a href="login.php" style="color: #ef4444; font-size: 0.85rem; text-decoration: none; font-weight: 600;">Encerrar Sessão (Sair)</a>
            </div>
        </main>
    </div>
</body>
</html>