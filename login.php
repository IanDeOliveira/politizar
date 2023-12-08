<?php
session_start();
include 'banco_usuario.php';

if (isset($_SESSION['id_usuario'])) {
    $id_usuario = $_SESSION['id_usuario'];

    // Consulta para obter o nome do usuário
    $sql = "SELECT nm_usuario FROM politizar.tb_usuario WHERE id_usuario = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id_usuario);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $nome_usuario = $result['nm_usuario'];
        echo '<script>
                if(confirm("Você já está logado como ' . $nome_usuario . '. Será redirecionado para a página inicial.")) {
                    window.location.href = "index_logado.php";
                }
              </script>';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login de Usuário</title>
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
                    <li><a href="http://localhost/ProjetoPolitizar/login.php">LOGIN</a></li>
                    <li><a href="http://localhost/ProjetoPolitizar/cadastro.html">CADASTRE-SE</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="apresentacao">
            <h1 class="subtitulos">Faça Login</h1>
        </div>

        <div id="formulario-login">
            <form action="usuario_processado.php" method="POST">
                <!-- Formulário de login -->
                <div class="campo">
                    <label for="email-login"><strong>E-mail</strong></label>
                    <input type="text" name="email-login" id="email-login" required>
                </div>

                <div class="campo">
                    <label for="Senha-login"><strong>Senha</strong></label>
                    <input type="password" name="Senha-login" id="Senha-login" required>
                </div>

                <button class="botao2" type="submit">Entrar</button>
            </form>
        </div>
    </main>
    <br>
    <br>
    <br>
    <footer>
        <img src="logotipo.png" alt="logotipo Politizar" height="85px" width="235px">
        <p style="color: aliceblue;">Nome da rua, 000 - Nome do Bairro</p>
        <p style="color: aliceblue;">Porto Alegre (RS)</p>
    </footer>
</body>

</html>