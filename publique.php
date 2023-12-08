<?php

session_start();


// Verificar se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
    // Usuário não está logado, redirecione para a página de login
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publique</title>
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
            <h1 id="titulo">Publique</h1>
            <p id="subtitulo">Publique seu artigo na página. Em caso de aprovação do artigo submetido, você receberá por
                e-mail os termos das Normas para envio de artigos</p>
            <br>
        </div>
        <div id="formulario">
            <?php
            // Incluir o arquivo de conexão com o banco de dados (banco.php)
            require_once("banco_usuario.php");

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $nome = isset($_POST['Nome']) ? $_POST['Nome'] : "";
                $sobrenome = isset($_POST['Sobrenome']) ? $_POST['Sobrenome'] : "";
                $email = isset($_POST['email']) ? $_POST['email'] : "";
                $tema = isset($_POST['tema']) ? $_POST['tema'] : "";
                $sobre = isset($_POST['Sobre']) ? $_POST['Sobre'] : "";
                $artigo = isset($_POST['Artigo']) ? $_POST['Artigo'] : "";
                $autorizo = isset($_POST['autorizo']) ? "Sim" : "Não";

                // Inserir os dados na tabela de artigos
                $sql = "INSERT INTO politizar.tb_artigo (nome_autor, id_tema_artigo, conteudo) VALUES (?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$nome . ' ' . $sobrenome, $tema, $artigo]);

                echo "<p>O artigo foi enviado com sucesso!</p>";

                // Você pode adicionar aqui qualquer outra ação após o envio bem-sucedido.
            } else {
                //echo "<p>O formulário não foi enviado corretamente.</p>";
            }
            ?>


            <form action="publique_processado.php" method="POST">

                <div class="campo"> 
                    <?php
                        require_once("banco_usuario.php");
                        // Exibir informações do usuário logado
                        if (isset($_SESSION['id_usuario'])) { 
                            echo "<div class='campo'>";
                            echo "<label for='nome'><strong>Nome: </strong></label>";
                            echo "<input type='text' readonly id='nome' required value='{$_SESSION['nm_usuario']}'>";
                            echo "</div>";

                            echo "<div class='campo'>";
                            echo "<label for='email'><strong>Email: </strong></label>";
                            echo "<input type='text' readonly id='email' required value='{$_SESSION['email_usuario']}'>";
                            echo "</div>";

                            echo "<div style='font-size: 12px; color: #999;'>";
                            echo "Não é você? <a href='logout.php' style='color: #007bff;'>Faça logout</a> e conecte na sua conta";
                            echo "</div>";
                            echo"<hr style='width: 30%;'>";
                        }
                    ?>

                </div>

                

                <div class="campo">
                  <label for="tema"><strong>Tema do Artigo</strong></label>
                     <select name="tema" id="tema" required>
                          <option selected disabled value="">Selecione</option>
                          <option value="1">Atualidades</option>
                          <option value="2">Conceitos</option>
                          <option value="3">Direito</option>
                          <option value="4">Economia</option>
                          <option value="5">Educação</option>
                          <option value="6">História</option>
                          <option value="7">Outros</option>
                   </select>
                </div>


                <div class="campo">
                    <br>
                    <label for="Sobre"><strong>Conte um pouco sobre você</strong></label>
                    <textarea name="Sobre" id="Sobre" cols="60" rows="10" style="width: 80em"></textarea>
                </div>

                <div class="campo">
                    <br>
                    <label for="Artigo"><strong>Artigo</strong></label>
                    <textarea name="Artigo" id="Artigo" cols="30" rows="10" style="width: 80em"></textarea>
                </div>

                <div id="check">
                    <label for="autorizo">Autorizo a coleta dos dados relacionados abaixo pelo Grupo Politizar para fins
                        de
                        cumprimento do
                        procedimento de publicação do conteúdo submetido</label>
                    <label>
                        <input type="radio" name="autorizo" id="autorizo" required>
                    </label>
                </div>

                <!-- Você pode adicionar campos adicionais aqui se necessário -->

                <button class="botao1" type="submit">Enviar artigo</button>
            </form>
        </div>
    </main>

    <footer>
    <img src="logotipo.png" alt="logotipo Politizar" height="85px" width="235px">
        <p style="color: aliceblue;">Nome da rua, 000 - Nome do Bairro</p>
        <p style="color: aliceblue;"> Porto Alegre (RS)</p>
    </footer>
</body>

</html>
