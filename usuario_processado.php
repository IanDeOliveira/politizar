<?php
session_start();
include 'banco_usuario.php';

// Verificar se $_SESSION['id_usuario'] já está definido
if (!isset($_SESSION['id_usuario'])) {
    $email = isset($_POST['email-login']) ? $_POST['email-login'] : "";
    $senha = isset($_POST['Senha-login']) ? $_POST['Senha-login'] : "";

    // Verificar se os campos não estão vazios
    if (empty($email) || empty($senha)) {
        echo "<script>alert('Por favor, preencha todos os campos.'); window.location.href = 'login.php';</script>";
        exit();
    }

    // Buscar usuário pelo e-mail usando prepared statement
    $sql_busca_usuario = "SELECT * FROM politizar.tb_usuario WHERE email_usuario = :email";
    $stmt_busca_usuario = $conn->prepare($sql_busca_usuario);
    $stmt_busca_usuario->bindParam(':email', $email);
    $stmt_busca_usuario->execute();
    $usuario = $stmt_busca_usuario->fetch(PDO::FETCH_ASSOC);

    // Verificar se o usuário foi encontrado e a senha está correta
    if ($usuario && password_verify($senha, $usuario['senha_usuario'])) {
        // Definir a variável de sessão com o ID do usuário diretamente da tabela
        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        $_SESSION['nm_usuario'] = $usuario['nm_usuario'];
        $_SESSION['email_usuario'] = $usuario['email_usuario'];


        // Usuário autenticado com sucesso
        header("Location: index_logado.php");
        exit();
    } else {
        // E-mail ou senha incorretos
        echo "<script>alert('Usuário inexistente ou informações de login incorretas.'); window.location.href = 'login.php';</script>";
        exit();
    }
} else {
    // Usuário já autenticado, redirecionar para a página adequada
    header("Location: index_logado.php");
    exit();
}
?>

/*
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dados do Formulário</title>
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="formulario.css">
</head>

<body>
    <header>
        <div class="conteudo-cabecalho">
            <h1><img src="logotipo.png" alt="logotipo Politizar" height="85px" width="235px"></h1>
            <nav>
                <ul>
                    <li><a href="">ARTIGOS</a></li>
                    <li><a href="">NOTÍCIAS</a></li>
                    <li><a href="">PUBLIQUE</a></li>
                    <li><a href="">ASSINE</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="pub">
            <h1 id="titulo">Dados do Formulário</h1>
        </div>
        <div id="formulario">
        </div>
    </main>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <footer>
        <img src="logotipo.png" alt="logotipo Politizar" height="85px" width="235px">
        <p style="color: aliceblue;">Nome da rua, 000 - Nome do Bairro</p>
        <p style="color: aliceblue;"> Porto Alegre (RS)</p>
    </footer>
</body>

</html>
*/