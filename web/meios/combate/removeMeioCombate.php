<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../../style.css">
        <title>BD | Meio Combate</title>
    </head>
    <body>
    <?php
        $n_meio = $_REQUEST['n_meio'];
        $nome_entidade = $_REQUEST['nome_entidade'];
        try {
            $host = "db.ist.utl.pt";
            $user ="ist186500";
            $password = "to_insert";
            $dbname = $user;
            $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "DELETE FROM meio_combate WHERE nome_entidade = :nome_entidade AND n_meio=:n_meio;";
            $result = $db->prepare($sql);
            $result->execute([':n_meio' => $n_meio, ":nome_entidade" => $nome_entidade]);

            echo("<p>Removido com sucesso!</p>");
            $db = null;
            }
        catch (PDOException $e)
            {
            echo("<p>ERROR: {$e->getMessage()}</p>");
            }
        ?>
        <button type='button' class='back' onclick="window.location.href='MeioCombate.php';"> Voltar </button>
    </body>
</html>
