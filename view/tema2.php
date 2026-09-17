<?php
session_start();

// Array com as 5 perguntas/cenários do Tema 2: Engenharia Social
$perguntas = [
    1 => [
        "titulo" => "Cenário 1: A Urgência da Diretoria",
        "contexto" => "Você recebe uma mensagem urgente no chat corporativo de um perfil que parece ser do Diretor Executivo da empresa, pedindo para você transferir dados confidenciais de clientes imediatamente para uma agência parceira devido a uma 'auditoria surpresa'.",
        "pergunta" => "Qual deve ser a sua conduta diante dessa solicitação?",
        "opcoes" => [
            "A" => "Enviar os dados imediatamente para não desagradar à diretoria.",
            "B" => "Confirmar a veracidade do pedido utilizando um canal secundário oficial (como ligar para o ramal interno do diretor ou contatar o gestor direto) antes de qualquer envio.",
            "C" => "Responder na mesma mensagem pedindo mais detalhes e enviar logo em seguida."
        ],
        "correta" => "B",
        "explicacao" => "Perfeito! Ataques de engenharia social costumam usar falsas autoridades e urgência simulada para induzir o funcionário ao erro. Validar por um canal seguro é a barreira ideal."
    ],
    2 => [
        "titulo" => "Cenário 2: O Falso Técnico de Suporte",
        "contexto" => "Um homem de colete e crachá aparente entra na recepção da empresa afirmando ser um técnico terceirizado contratado para fazer manutenção imediata nos servidores e pede para você liberar a entrada dele na sala de servidores sem crachá de visitante.",
        "pergunta" => "Como você deve proceder nesta situação?",
        "opcoes" => [
            "A" => "Liberar a entrada, pois ele está vestido adequadamente para a função.",
            "B" => "Conduzir a pessoa até a recepção oficial, solicitar identificação e acionar o setor de TI ou segurança interna para validar a visita.",
            "C" => "Ignorar a presença dele e continuar trabalhando sem interferir."
        ],
        "correta" => "B",
        "explicacao" => "Excelente! O golpe do 'Tailgating' (seguir alguém para dentro de áreas restritas) é clássico. Todo prestador de serviço deve ser rigorosamente identificado e acompanhado."
    ],
    3 => [
        "titulo" => "Cenário 3: A Ligação da Falsa Central de Atendimento",
        "contexto" => "Você recebe uma ligação telefônica de alguém que diz ser da operadora de telefonia da empresa, afirmando que há uma pane técnica e exigindo que você confirme o código de acesso e a senha da sua conta corporativa para regularizar o sistema.",
        "pergunta" => "Qual é a atitude correta?",
        "opcoes" => [
            "A" => "Fornecer os dados rapidamente para o serviço de internet da empresa não cair.",
            "B" => "Desligar imediatamente a chamada, pois empresas sérias e o suporte interno jamais solicitam senhas por telefone.",
            "C" => "Pedir para o atendente repetir mais devagar e anotar as instruções dele."
        ],
        "correta" => "B",
        "explicacao" => "Muito bem! O 'Vishing' (phishing por voz) explora a persuasão por telefone. Nenhuma equipe de suporte legítima pede senhas de acesso aos colaboradores."
    ],
    4 => [
        "titulo" => "Cenário 4: Pesquisa de Clima Suspeita",
        "contexto" => "Um e-mail externo convida os funcionários a participarem de uma pesquisa de satisfação corporativa em troca de um vale-presente valioso, exigindo que você preencha seu CPF, data de nascimento e o nome da sua mãe.",
        "pergunta" => "Como classificar e lidar com esta abordagem?",
        "opcoes" => [
            "A" => "Preencher os dados para garantir o prêmio e ajudar na pesquisa.",
            "B" => "Descartar o e-mail e reportar como tentativa de roubo de dados pessoais (Phishing / Coleta maliciosa).",
            "C" => "Responder perguntando se o vale-presente é real antes de preencher."
        ],
        "correta" => "B",
        "explicacao" => "Correto! Iscas atraentes combinadas com pedidos de dados pessoais sensíveis são estratégias típicas para roubo de identidade e engenharia social."
    ],
    5 => [
        "titulo" => "Cenário 5: O Colega Curioso na Lanchonete",
        "contexto" => "Enquanto você toma café na copa da empresa, um colega de outro departamento começa a puxar conversa de forma amigável e, sutilmente, faz perguntas detalhadas sobre as senhas e acessos administrativos que você utiliza no seu projeto atual.",
        "pergunta" => "Qual deve ser a sua postura diante dessas perguntas?",
        "opcoes" => [
            "A" => "Conversar abertamente e compartilhar os detalhes, afinal ele trabalha na mesma empresa.",
            "B" => "Manter a discrição profissional, desviando do assunto e lembrando que informações de credenciais são estritamente individuais e confidenciais.",
            "C" => "Convidá-lo para olhar o código e o painel direto na sua tela para tirar as dúvidas."
        ],
        "correta" => "B",
        "explicacao" => "Perfeito! A engenharia social presencial ('Eavesdropping' ou conversas informais manipuladoras) busca obter credenciais explorando a simpatia e a distração do colaborador."
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
    <title>Tema 2: Engenharia Social - Serious Game</title>
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
            <h1>Tema 2: Engenharia Social</h1>
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
                        <a href="tema2.php?p=<?php echo $idPerguntaAtual + 1; ?>" class="btn-decision" style="text-decoration: none; text-align: center; background-color: #0f172a; color: #fff; padding: 10px 20px; border-radius: 6px; font-weight: 600;">
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
                <form action="tema2.php?p=<?php echo $idPerguntaAtual; ?>" method="POST" style="display: flex; flex-direction: column; gap: 12px;">
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