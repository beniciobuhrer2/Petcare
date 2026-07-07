<?php
session_start();

require_once "config/db.php";

$logado = isset($_SESSION['usuario_id']);
$nomeUsuario = $_SESSION['usuario_nome'] ?? null;

$totalPets = 0;
$totalConsultas = 0;

if ($logado) {
    $resultadoPets = mysqli_query($db, "SELECT COUNT(*) AS total FROM animais");
    $dadosPets = mysqli_fetch_assoc($resultadoPets);
    $totalPets = $dadosPets['total'];

    $resultadoConsultas = mysqli_query($db, "SELECT COUNT(*) AS total FROM consultas");
    $dadosConsultas = mysqli_fetch_assoc($resultadoConsultas);
    $totalConsultas = $dadosConsultas['total'];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetCare | Sistema de Gestão da Clínica</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="topbar">
    <div class="topbar__marca">
        <span>PetCare</span>
    </div>

    <nav class="topbar__nav">
        <?php if ($logado): ?>
            <a href="animais/listar.php">Pets</a>
            <a href="consultas/listar.php">Consultas</a>
            <a href="usuarios/listar.php">Usuários</a>
            <span class="topbar__usuario">Olá, <?= htmlspecialchars($nomeUsuario) ?></span>
            <a href="usuarios/sair.php" class="botao botao--fantasma">Sair</a>
        <?php else: ?>
            <a href="usuarios/login.php" class="botao botao--fantasma">Entrar</a>
        <?php endif; ?>
    </nav>
</header>

<main>
    <?php if (!$logado): ?>

        <section class="hero">
            <div class="hero__texto">
                <span class="hero__eyebrow">Sistema de gestão para clínicas veterinárias</span>

                <h1>
                    Cuidar de cada pet começa por organizar cada detalhe.
                </h1>

                <p>
                    Cadastre pets, acompanhe consultas e mantenha o histórico da
                    clínica em um só lugar, de forma simples e rápida.
                </p>

                <a href="usuarios/login.php" class="botao botao--primario">Fazer login</a>
            </div>

            <div class="hero__imagem">
                <img src="img/cão.png" alt="Ilustração de pet">
            </div>
        </section>

        <section class="servicos">
            <h2>Nossos Serviços</h2>
            <p class="secao-subtitulo">
                Tudo que sua clínica precisa para organizar melhor o atendimento.
            </p>

            <div class="cards-servicos">
                <div class="card-servico">
                    <span>🐾</span>
                    <h3>Cadastro de Pets</h3>
                    <p>Registre nome, espécie, raça, idade e tutor responsável.</p>
                </div>

                <div class="card-servico">
                    <span>🩺</span>
                    <h3>Consultas</h3>
                    <p>Agende consultas veterinárias de forma prática e organizada.</p>
                </div>

                <div class="card-servico">
                    <span>💉</span>
                    <h3>Vacinação</h3>
                    <p>Acompanhe cuidados importantes para a saúde dos animais.</p>
                </div>

                <div class="card-servico">
                    <span>📋</span>
                    <h3>Histórico</h3>
                    <p>Guarde informações importantes para futuros atendimentos.</p>
                </div>
            </div>
        </section>

        <section class="beneficios">
            <div>
                <h2>Por que escolher a PetCare?</h2>
                <p>
                    A PetCare ajuda clínicas veterinárias a manterem seus atendimentos
                    mais organizados, seguros e fáceis de consultar.
                </p>
            </div>

            <ul>
                <li>✔ Atendimento mais organizado</li>
                <li>✔ Cadastro completo dos pets</li>
                <li>✔ Consultas registradas no sistema</li>
                <li>✔ Interface simples e fácil de usar</li>
            </ul>
        </section>

        <section class="numeros">
            <div class="numero">
                <h2>250+</h2>
                <p>Pets atendidos</p>
            </div>

            <div class="numero">
                <h2>80+</h2>
                <p>Consultas realizadas</p>
            </div>

            <div class="numero">
                <h2>98%</h2>
                <p>Clientes satisfeitos</p>
            </div>
        </section>

    <?php else: ?>

        <section class="painel">
            <div class="painel__cabecalho">
                <h1>Painel de controle</h1>
                <p>Escolha o que você deseja gerenciar hoje.</p>
            </div>

            <div class="cartoes">
                <a href="animais/listar.php" class="cartao">
                    <span class="cartao__icone">🐾</span>
                    <h2>Pets</h2>
                    <p>Cadastrar, editar e remover pets da clínica.</p>
                    <span class="cartao__numero"><?= $totalPets ?></span>
                    <span class="cartao__legenda">pets cadastrados</span>
                </a>

                <a href="consultas/listar.php" class="cartao">
                    <span class="cartao__icone">🩺</span>
                    <h2>Consultas</h2>
                    <p>Agendar, editar e cancelar consultas.</p>
                    <span class="cartao__numero"><?= $totalConsultas ?></span>
                    <span class="cartao__legenda">consultas registradas</span>
                </a>

                <a href="usuarios/listar.php" class="cartao cartao--secundario">
                    <span class="cartao__icone">👤</span>
                    <h2>Usuários</h2>
                    <p>Cadastrar, editar e remover usuários do sistema.</p>
                </a>
            </div>
        </section>

    <?php endif; ?>
</main>

<footer class="rodape">
    <p>PetCare &copy; <?= date('Y') ?> — Todos os direitos reservados - Benício Buhrer de Lima</p>
</footer>

</body>
</html>