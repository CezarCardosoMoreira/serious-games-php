# Plataforma de Treinamento Corporativo

Projeto de Trabalho de Conclusão de Curso (TCC): uma plataforma de capacitação profissional baseada em simulações interativas e serious games. O objetivo é apresentar situações do cotidiano corporativo para apoiar o aprendizado sobre segurança da informação, engenharia social e privacidade.

[Projeto-TCC-seriousgames](https://serious-games-php-production.up.railway.app)

link de acesso: 

## Funcionalidades

- Cadastro de colaboradores com nome, idade, setor, cargo, e-mail e senha.
- Autenticação de usuários com senha armazenada por meio de hash.
- Painel para escolher entre três módulos de treinamento.
- Cinco cenários de múltipla escolha em cada módulo, com feedback explicativo após cada resposta.
- Indicador visual da etapa atual dentro dos módulos.

### Módulos

1. **Segurança da Informação:** phishing, senhas, dispositivos desconhecidos, Wi-Fi público e bloqueio de tela.
2. **Engenharia Social:** solicitações suspeitas, validação de identidade, vishing e proteção de credenciais.
3. **Conformidade e LGPD:** compartilhamento, descarte e tratamento de dados pessoais, além de resposta a incidentes.

## Tecnologias

- PHP 8.3 ou superior
- MySQL
- Extensões PHP `pdo`, `pdo_mysql` e `mysqli` (requisitos declarados no `composer.json`)
- Composer para verificar os requisitos definidos no projeto

## Como executar localmente

1. Clone o repositório para a pasta de projetos do Laragon, por exemplo `C:\laragon\www\TCC`.
2. Inicie o Apache e o MySQL pelo Laragon.
3. Crie um banco de dados MySQL, por exemplo `tcc`.
4. Crie a tabela usada pelo cadastro e pelo login:

   ```sql
   CREATE TABLE usuarios (
       id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
       nome VARCHAR(150) NOT NULL,
       idade INT NOT NULL,
       setor VARCHAR(100) NOT NULL,
       cargo VARCHAR(100) NOT NULL,
       email VARCHAR(255) NOT NULL UNIQUE,
       senha VARCHAR(255) NOT NULL
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
   ```

5. Defina as variáveis de ambiente de conexão antes de iniciar o PHP ou o Apache:

   | Variável | Exemplo local |
   | --- | --- |
   | `DB_HOST` | `127.0.0.1` |
   | `DB_PORT` | `3306` |
   | `DB_NAME` | `tcc` |
   | `DB_USERNAME` | `root` |
   | `DB_PASSWORD` | senha configurada no MySQL (vazia se não houver) |

   A aplicação também reconhece os nomes `MYSQLHOST`, `MYSQLPORT`, `MYSQL_DATABASE`/`MYSQLDATABASE`, `MYSQLUSER` e `MYSQLPASSWORD` para ambientes que os forneçam.

6. Na raiz do projeto, execute `composer install`.
7. Abra `http://localhost/TCC/` no navegador.

O cadastro de usuário e o login dependem do banco de dados configurado. O restante da interface pode ser explorado localmente, mas os módulos fazem parte do fluxo de treinamento após o acesso.

## Estrutura do projeto

```text
.
├── index.php             # Página inicial
├── composer.json         # Requisitos de PHP e extensões
├── model/
│   └── conexao.php       # Conexão PDO com MySQL
└── view/
    ├── cadastro.php     # Cadastro de colaboradores
    ├── login.php        # Autenticação
    ├── dashboard.php    # Seleção dos módulos
    ├── tema1.php        # Segurança da Informação
    ├── tema2.php        # Engenharia Social
    ├── tema3.php        # Conformidade e LGPD
    └── css/style.css    # Estilos
```

## Estado do projeto

Este projeto é acadêmico e está em desenvolvimento. Atualmente, as respostas e a conclusão dos módulos não são salvas como resultados ou pontuação. A validação de sessão também não está aplicada às páginas dos módulos; portanto, o fluxo de login não deve ser considerado um mecanismo de controle de acesso pronto para produção.
