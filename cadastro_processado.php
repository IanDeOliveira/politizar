<?php
include 'banco_usuario.php';
?>

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
            <h1 id="titulo">Resultado do cadastro</h1>
        </div>
        <div id="formulario">
            <?php

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $nome = isset($_POST['Nome']) ? $_POST['Nome'] : "";
                $sobrenome = isset($_POST['Sobrenome']) ? $_POST['Sobrenome'] : "";
                $cpf = isset($_POST['Cpf']) ? $_POST['Cpf'] : "";
                $email = isset($_POST['email']) ? $_POST['email'] : "";
                $senha = isset($_POST['Senha']) ? $_POST['Senha'] : "";

                $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

                $sql_verifica_email = "SELECT count(*) FROM politizar.tb_usuario WHERE email_usuario = :email";
                $stmt_verifica_email = $conn->prepare($sql_verifica_email);
                $stmt_verifica_email->bindParam(':email', $email);
                $stmt_verifica_email->execute();
                $email_existente = $stmt_verifica_email->fetchColumn();

                if ($email_existente > 0) {
                    echo "Este e-mail já está registrado.";
                    echo "<br><a href='login.php'>Ir para a tela de login</a>";
                } else {
                    $sql = "INSERT INTO politizar.tb_usuario (nm_usuario, cpf_usuario, email_usuario, senha_usuario) VALUES (:nome, :cpf, :email, :senha)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':nome', $nome);
                    $stmt->bindParam(':cpf', $cpf);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':senha', $senha_hash);

                    if ($stmt->execute()) {
                        echo "Cadastro bem-sucedido!";
                        echo "<br><a href='login.php'>Voltar para o cadastro/login</a>";
                    } else {
                        echo "Erro ao cadastrar: " . $stmt->errorInfo()[2];
                        echo "<br><a href='cadastro.html'>Voltar para o cadastro</a>";
                    }
                }
            }
            ?>
        </div>
    </main>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
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
