<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../style.css">
        <title>BD | Locais</title>
    </head>
    <body>
    <?php
        $local = $_REQUEST['morada_local'];
        try {
            $host = "db.ist.utl.pt";
            $user ="ist186500";
            $password = "to_insert";
            $dbname = $user;
            $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "DELETE FROM localizacao WHERE morada_local = :local;";
            $result = $db->prepare($sql);
            $result->execute([':local' => $local]);

            echo("<p>Removido com sucesso!</p>");
            $db = null;
            }
        catch (PDOException $e)
            {
            echo("<p>ERROR: {$e->getMessage()}</p>");
            }
        ?>
        <button type='button' class='back' onclick="window.location.href='locais.php';"> Voltar </button>
    </body>
</html>
