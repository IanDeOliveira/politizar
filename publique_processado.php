<?php
include 'banco_usuario.php';
session_start();

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
            <h1 id="titulo">Dados do Formulário</h1>
        </div>
        <div id="formulario">

            <?php
            require_once("banco_usuario.php");

            // Verificar se o formulário foi enviado
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Obter os dados do formulário
                $nomeAutor = isset($_SESSION['nm_usuario']) ? $_SESSION['nm_usuario'] : "";
                $tema = isset($_POST['tema']) ? $_POST['tema'] : "";
                $conteudo = isset($_POST['Artigo']) ? $_POST['Artigo'] : "";

                // Obter o ID do usuário da sessão
                $idUsuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : null;

                if ($idUsuario !== null) {
                    // Consulta SQL para inserir os dados na tabela politizar.tb_artigo
                    $sql = "INSERT INTO politizar.tb_artigo (id_usuario, nome_autor, id_tema_artigo, conteudo) VALUES (:idUsuario, :nomeAutor, :tema, :conteudo)";
                
                    // Preparar a consulta
                    $stmt = $conn->prepare($sql);
                
                    // Vincular parâmetros
                    $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
                    $stmt->bindParam(':nomeAutor', $nomeAutor, PDO::PARAM_STR);
                    $stmt->bindParam(':tema', $tema, PDO::PARAM_INT);
                    $stmt->bindParam(':conteudo', $conteudo, PDO::PARAM_STR);
                
                    // Executar a consulta
                    if ($stmt->execute()) {
                        echo "Inserção bem-sucedida!";
                    } else {
                        echo "Erro ao inserir os dados: " . $stmt->errorInfo()[2];
                    }
                } else {
                    echo "Erro: ID do usuário não encontrado na sessão.";
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
    <footer>
        <img src="logotipo.png" alt="logotipo Politizar" height="85px" width="235px">
        <p style="color: aliceblue;">Nome da rua, 000 - Nome do Bairro</p>
        <p style="color: aliceblue;"> Porto Alegre (RS)</p>
    </footer>
</body>

</html>
