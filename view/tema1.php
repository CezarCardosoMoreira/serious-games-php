<?php
session_start();

// Array com as 5 perguntas/cenários do Tema 1: Segurança da Informação
$perguntas = [
    1 => [
        "titulo" => "Cenário 1: O E-mail Suspeito",
        "contexto" => "Você recebe um e-mail do 'Suporte de TI da Empresa' informando que sua senha vai expirar em 2 horas e exigindo que você clique em um link externo para atualizá-la imediatamente.",
        "pergunta" => "Qual deve ser a sua atitude correta?",
        "opcoes" => [
            "A" => "Clicar no link imediatamente para evitar que minha senha expire.",
            "B" => "Ignorar o link do e-mail, abrir os canais oficiais de suporte da empresa e verificar se tal procedimento é verídico.",
            "C" => "Encaminhar o e-mail para todos os meus colegas de trabalho para avisá-los."
        ],
        "correta" => "B",
        "explicacao" => "Parabéns! Phishing é um golpe comum. O suporte real nunca exige alteração de senha por links externos urgentes sem validação oficial."
    ],
    2 => [
        "titulo" => "Cenário 2: A Senha do Sistema",
        "contexto" => "Você precisa criar uma nova senha para acessar o painel corporativo principal da empresa. O sistema exige padrões elevados de segurança.",
        "pergunta" => "Qual destas opções representa uma senha ideal e segura?",
        "opcoes" => [
            "A" => "12345678 (fácil de lembrar e digitar rapidamente).",
            "B" => "MeuNome2026 (usa parte do nome pessoal com o ano atual).",
            "C" => "S#g3r@_98!Corp (combina letras maiúsculas, minúsculas, números e caracteres especiais sem dados óbvios)."
        ],
        "correta" => "C",
        "explicacao" => "Excelente! Senhas fortes misturam caracteres complexos e evitam dados pessoais fáceis de adivinhar por engenharia social."
    ],
    3 => [
        "titulo" => "Cenário 3: O Pendrive Encontrado",
        "contexto" => "Ao chegar para trabalhar, você encontra um pendrive perdido no estacionamento da empresa com uma etiqueta atraente escrita 'Salários e Bônus 2026'.",
        "pergunta" => "O que você deve fazer com este dispositivo?",
        "opcoes" => [
            "A" => "Conectar no meu computador de trabalho para ver de quem é e devolver o arquivo.",
            "B" => "Entregar o pendrive diretamente ao departamento de Segurança da Informação / TI da empresa sem conectá-lo.",
            "C" => "Conectar em um computador pessoal em casa para verificar o conteúdo."
        ],
        "correta" => "B",
        "explicacao" => "Muito bem! Dispositivos desconhecidos encontrados em locais públicos costumam conter códigos maliciosos (malware) programados para infectar sistemas automaticamente ao serem conectados."
    ],
    4 => [
        "titulo" => "Cenário 4: Trabalho Remoto e Wi-Fi Público",
        "contexto" => "Você está trabalhando remotamente em uma cafeteria e precisa acessar dados confidenciais da empresa através de uma rede Wi-Fi aberta e gratuita.",
        "pergunta" => "Qual é a conduta de segurança recomendada para essa situação?",
        "opcoes" => [
            "A" => "Acessar normalmente, pois a rede é rápida e prática.",
            "B" => "Utilizar obrigatoriamente a rede VPN corporativa segura antes de acessar qualquer dado sensível.",
            "C" => "Desativar o firewall do notebook para melhorar a velocidade da conexão pública."
        ],
        "correta" => "B",
        "explicacao" => "Perfeito! Redes Wi-Fi públicas são inseguras e vulneráveis a interceptação de dados. A VPN corporativa criptografa todo o tráfego protegendo as informações."
    ],
    5 => [
        "titulo" => "Cenário 5: Mesa Limpa e Tela Bloqueada",
        "contexto" => "Você precisa se ausentar da sua mesa de trabalho por alguns minutos para ir a uma reunião rápida com a diretoria.",
        "pergunta" => "O que você deve fazer com o seu computador antes de sair?",
        "opcoes" => [
            "A" => "Deixar a tela aberta, pois volto em menos de cinco minutos.",
            "B" => "Bloquear a tela do computador (atalho Windows + L) para impedir o acesso não autorizado de terceiros.",
            "C" => "Desligar completamente a CPU da tomada."
        ],
        "correta" => "B",
        "explicacao" => "Correto! A política de 'mesa limpa e tela bloqueada' evita que pessoas não autorizadas tenham acesso a dados corporativos confidenciais na ausência do colaborador."
    ]
];

// Controle de qual pergunta está ativa (padrão é a 1)
$idPerguntaAtual = isset($_GET['p']) ? (int)$_GET['p'] : 1;
if ($idPerguntaAtual < 1 || $idPerguntaAtual > 5) {
    $idPerguntaAtual = 1;
}

$perguntaAtual = $perguntas[$idPerguntaAtual];
$feedbackMensagem = "";
$feedbackStatus = "";

// Processa a resposta enviada pelo usuário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $respostaUsuario = $_POST['resposta'] ?? '';
    if ($respostaUsuario === $perguntaAtual['correta']) {
        $feedbackStatus = "success";
        $feedbackMensagem = "<strong>Resposta Correta!</strong> " . $perguntaAtual['explicacao'];
    } else {
        $feedbackStatus = "error";
        $feedbackMensagem = "<strong>Atenção (Resposta Incorreta).</strong> A opção correta era a <strong>{$perguntaAtual['correta']}</strong>. " . $perguntaAtual['explicacao'];
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tema 1: Segurança da Informação - Serious Game</title>
    <link rel="stylesheet" href="./css/style.css">
    <style>
        .progress-bar {
            display: flex;
            gap: 6px;
            margin-bottom: 20px;
        }
        .progress-step {
            flex: 1;
            height: 6px;
            background-color: #cbd5e1;
            border-radius: 3px;
        }
        .progress-step.active {
            background-color: #3b82f6;
        }
        .progress-step.completed {
            background-color: #10b981;
        }
        .option-label {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 12px 16px;
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 0.95rem;
            color: #334155;
        }
        .option-label:hover {
            border-color: #3b82f6;
            background-color: #eff6ff;
        }
        .option-input {
            margin-top: 3px;
        }
    </style>
</head>
<body>
    <div class="game-container" style="max-width: 650px;">
        <!-- Cabeçalho -->
        <header class="game-header">
            <h1>Tema 1: Segurança da Informação</h1>
            <p style="color: #94a3b8; font-size: 0.9rem; margin-top: 4px;">Simulação de Tomada de Decisão Corporativa (Questão <?php echo $idPerguntaAtual; ?> de 5)</p>
        </header>

        <!-- Barra de Progresso das 5 Questões -->
        <div class="progress-bar">
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <div class="progress-step <?php echo ($i < $idPerguntaAtual) ? 'completed' : (($i === $idPerguntaAtual) ? 'active' : ''); ?>"></div>
            <?php endfor; ?>
        </div>

        <main class="scenario-box">
            <!-- Título e Contexto do Cenário -->
            <h2 style="font-size: 1.1rem; color: #0f172a; margin-bottom: 10px;"><?php echo $perguntaAtual['titulo']; ?></h2>
            <p style="font-size: 0.92rem; color: #475569; line-height: 1.6; margin-bottom: 15px; background: #f8fafc; padding: 12px; border-left: 4px solid #3b82f6; border-radius: 4px;">
                <?php echo $perguntaAtual['contexto']; ?>
            </p>

            <p style="font-size: 0.95rem; font-weight: 600; color: #1e293b; margin-bottom: 15px;">
                <?php echo $perguntaAtual['pergunta']; ?>
            </p>

            <!-- Exibição de Feedback após submeter a resposta -->
            <?php if (!empty($feedbackMensagem)): ?>
                <div class="feedback-box <?php echo $feedbackStatus; ?>" style="margin-bottom: 20px;">
                    <p><?php echo $feedbackMensagem; ?></p>
                </div>

                <!-- Botões de Navegação Pós-Resposta -->
                <div style="display: flex; justify-content: flex-end; margin-top: 15px;">
                    <?php if ($idPerguntaAtual < 5): ?>
                        <a href="tema1.php?p=<?php echo $idPerguntaAtual + 1; ?>" class="btn-decision" style="text-decoration: none; text-align: center; background-color: #0f172a; color: #fff; padding: 10px 20px; border-radius: 6px; font-weight: 600;">
                            Próxima Pergunta &rarr;
                        </a>
                    <?php else: ?>
                        <a href="dashboard.php" class="btn-decision" style="text-decoration: none; text-align: center; background-color: #10b981; color: #fff; padding: 10px 20px; border-radius: 6px; font-weight: 600;">
                            Finalizar Módulo e Voltar ao Painel &check;
                        </a>
                    <?php endif; ?>
                </div>

            <?php else: ?>
                <!-- Formulário de Escolha da Resposta -->
                <form action="tema1.php?p=<?php echo $idPerguntaAtual; ?>" method="POST" style="display: flex; flex-direction: column; gap: 12px;">
                    <?php foreach ($perguntaAtual['opcoes'] as $letra => $textoOpcao): ?>
                        <label class="option-label">
                            <input type="radio" name="resposta" value="<?php echo $letra; ?>" required class="option-input">
                            <span><strong><?php echo $letra; ?>)</strong> <?php echo $textoOpcao; ?></span>
                        </label>
                    <?php endforeach; ?>

                    <button type="submit" class="btn-decision" style="justify-content: center; background-color: #0f172a; color: #fff; border-color: #0f172a; font-weight: 600; margin-top: 15px; cursor: pointer;">
                        Confirmar Resposta
                    </button>
                </form>
            <?php endif; ?>

            <!-- Link para voltar ao painel de escolha geral -->
            <div style="margin-top: 25px; text-align: center; border-top: 1px solid #e2e8f0; padding-top: 15px;">
                <a href="dashboard.php" style="color: #64748b; font-size: 0.85rem; text-decoration: none;">&larr; Voltar para a Seleção de Módulos</a>
            </div>
        </main>
    </div>
</body>
</html>