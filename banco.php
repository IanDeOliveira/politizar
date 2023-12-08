<?php
$bd_host = "200.19.1.18";
$sgbd = "pgsql";
$base_de_dados = "iansilva2";
$bd_usuario = "iansilva2";
$bd_senha = "123456";

switch ($sgbd) {
    case "mysql":
        try {
            $dsn_mysql = "mysql:host=".$bd_host.";dbname=".$base_de_dados;
            $conn = new PDO($dsn_mysql, $bd_usuario, $bd_senha);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die('ERROR: ' . $e->getMessage());
        }
        break;
    case "pgsql":
        try {
            $dsn_pgsql = "pgsql:host=$bd_host;port=5432;dbname=$base_de_dados;";
            // make a database connection
            $conn = new PDO(
                $dsn_pgsql,
                $bd_usuario,
                $bd_senha,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        break;
    case "sqlite":
        $conn = new PDO('sqlite:./sql/catalogo_de_games.sqlite3');
        // Set errormode to exceptions
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        break;
}

// Verifique se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = isset($_POST['Nome']) ? $_POST['Nome'] : "";
    $idTema = isset($_POST['tema']) ? $_POST['tema'] : ""; // Agora recebe o ID do tema
    $artigo = isset($_POST['Artigo']) ? $_POST['Artigo'] : "";

    // Consulta SQL para inserir os dados na tabela politizar.tb_artigo
    $sql = "INSERT INTO politizar.tb_artigo (nome_autor, id_tema_artigo, conteudo) VALUES (:nome, :idTema, :artigo)";

    // Preparar a consulta
    $stmt = $conn->prepare($sql);

    // Vincular parâmetros
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':idTema', $idTema); // Usando o ID do tema
    $stmt->bindParam(':artigo', $artigo);

    // Executar a consulta
    if ($stmt->execute()) {
        echo "Inserção bem-sucedida!";
    } else {
        echo "Erro ao inserir os dados: " . $stmt->errorInfo()[2];
    }
}
?>