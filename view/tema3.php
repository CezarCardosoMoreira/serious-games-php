<?php
session_start();

// Array com as 5 perguntas/cenários do Tema 3: Conformidade e LGPD
$perguntas = [
    1 => [
        "titulo" => "Cenário 1: O Pedido de Dados por E-mail",
        "contexto" => "Um parceiro comercial antigo envia um e-mail pedindo a listagem completa com os dados pessoais e telefones de contato de todos os clientes da empresa para uma campanha promocional conjunta.",
        "pergunta" => "Como você deve agir de acordo com as diretrizes da LGPD?",
        "opcoes" => [
            "A" => "Enviar a planilha imediatamente, pois eles já são parceiros de longa data da empresa.",
            "B" => "Recusar o envio direto e verificar com o Encarregado de Dados (DPO) ou setor jurídico se existe base legal e termo de consentimento válido para esse compartilhamento.",
            "C" => "Enviar apenas os nomes e ocultar os números de telefone para ser mais rápido."
        ],
        "correta" => "B",
        "explicacao" => "Perfeito! A LGPD exige controle rígido sobre o compartilhamento de dados pessoais. O envio só pode ocorrer se houver previsão legal ou consentimento explícito do titular."
    ],
    2 => [
        "titulo" => "Cenário 2: O Descarte de Documentos Impressos",
        "contexto" => "Você precisa limpar sua mesa e encontra dezenas de folhas impressas antigas contendo nomes, CPFs e endereços de clientes que já encerraram contratos com a empresa.",
        "pergunta" => "Qual é a forma correta de descartar esses papéis?",
        "opcoes" => [
            "A" => "Rasgar os papéis com as mãos e jogá-los na lixeira comum do escritório.",
            "B" => "Colocá-los em uma caixa de reciclagem comum no corredor.",
            "C" => "Destruí-los utilizando a fragmentadora de papel da empresa ou destiná-los ao descarte seguro e confidencial."
        ],
        "correta" => "C",
        "explicacao" => "Excelente! Descartar dados pessoais em lixeiras comuns configura infração à segurança da informação e à LGPD, pois qualquer pessoa pode recuperar essas informações (vazamento físico)."
    ],
    3 => [
        "titulo" => "Cenário 3: A Solicitação do Titular",
        "contexto" => "Um cliente liga para a empresa exigindo saber quais dados pessoais o sistema armazena sobre ele e requisitando a exclusão imediata dessas informações do banco de dados.",
        "pergunta" => "Como o colaborador deve proceder diante dessa solicitação prevista na LGPD?",
        "opcoes" => [
            "A" => "Dizer que a empresa não faz exclusão de dados e desligar a chamada.",
            "B" => "Encaminhar o pedido ao canal oficial de atendimento aos direitos dos titulares (DPO / Privacidade), seguindo os prazos e procedimentos regulamentados.",
            "C" => "Apagar manualmente os dados dele na mesma hora para resolver logo o problema."
        ],
        "correta" => "B",
        "explicacao" => "Muito bem! Os titulares têm direito de acesso e exclusão (com exceções legais de retenção). O atendimento deve seguir o fluxo oficial de governança de dados da empresa."
    ],
    4 => [
        "titulo" => "Cenário 4: Uso de Planilhas Pessoais",
        "contexto" => "Para facilitar o seu trabalho diário de vendas, você decide baixar uma tabela com dados de contato de clientes para o seu computador pessoal em casa.",
        "pergunta" => "Essa prática está em conformidade com as normas de proteção de dados?",
        "opcoes" => [
            "A" => "Sim, desde que eu apague a planilha do computador pessoal assim que terminar o trabalho.",
            "B" => "Não. Dados corporativos e pessoais de clientes não devem ser copiados para ambientes não controlados ou dispositivos pessoais.",
            "C" => "Sim, pois agiliza o atendimento fora do horário comercial."
        ],
        "correta" => "B",
        "explicacao" => "Correto! O princípio da segurança da LGPD exige que os dados sejam protegidos contra acessos não autorizados e perda, proibindo o trânsito livre de informações sensíveis em computadores particulares sem criptografia."
    ],
    5 => [
        "titulo" => "Cenário 5: O Incidente de Vazamento",
        "contexto" => "Você percebe acidentalmente que um arquivo contendo senhas e dados confidenciais de funcionários foi publicado publicamente por engano em uma pasta de rede aberta a todos.",
        "pergunta" => "Qual deve ser sua atitude imediata?",
        "opcoes" => [
            "A" => "Avisar imediatamente o setor de TI e o responsável pela segurança de dados para que a falha seja mitigada e comunicada conforme a lei.",
            "B" => "Ficar em silêncio para evitar que descubram que o arquivo foi exposto.",
            "C" => "Apenas fechar a pasta e fingir que não viu nada."
        ],
        "correta" => "A",
        "explicacao" => "Perfeito! A LGPD e as normas de governança exigem notificação imediata de incidentes de segurança para conter danos e cumprir os prazos legais de resposta."
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
    <title>Tema 3: Conformidade e LGPD - Serious Game</title>
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
            <h1>Tema 3: Conformidade e LGPD</h1>
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
                        <a href="tema3.php?p=<?php echo $idPerguntaAtual + 1; ?>" class="btn-decision" style="text-decoration: none; text-align: center; background-color: #0f172a; color: #fff; padding: 10px 20px; border-radius: 6px; font-weight: 600;">
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
                <form action="tema3.php?p=<?php echo $idPerguntaAtual; ?>" method="POST" style="display: flex; flex-direction: column; gap: 12px;">
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