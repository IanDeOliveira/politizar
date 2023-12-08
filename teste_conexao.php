<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Teste de Conexão</title>
</head>
<body>
    <?php
    session_start();
    include 'banco_usuario.php'; // Inclui o arquivo com a conexão ao banco de dados

    // Verifica se a variável de sessão está definida e não está vazia
    if(isset($_SESSION['id_usuario']) && !empty($_SESSION['id_usuario'])) {
        echo "O ID do usuário autenticado é: " . $_SESSION['id_usuario'];
    } else {
        echo "Nenhum usuário autenticado encontrado.";
    }

    // O código abaixo é apenas um exemplo de utilização da conexão para executar uma consulta
    try {
        $query = "SELECT version()";
        $result = $conn->query($query);
        $row = $result->fetch(PDO::FETCH_ASSOC);

        echo "<br>Versão do PostgreSQL: " . $row['version'];
    } catch (PDOException $e) {
        echo "<br>Erro de conexão: " . $e->getMessage();
    }
    ?>
</body>
</html>
