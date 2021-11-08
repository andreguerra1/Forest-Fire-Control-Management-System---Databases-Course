<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../style.css">
        <title>BD | Processos Socorro</title>
    </head>
    <body>
    <?php
        $n_proc_socorro = intval($_REQUEST['n_proc_socorro']);
        echo($n_proc_socorro);
        try {
            $host = "db.ist.utl.pt";
            $user ="ist186500";
            $password = "to_insert";
            $dbname = $user;
            $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "DELETE FROM evento_emergencia WHERE n_proc_socorro=:n_proc_socorro;";
            $result = $db->prepare($sql);
            $result->execute([ ":n_proc_socorro" => $n_proc_socorro]);
            $sql = "DELETE FROM processo_socorro WHERE n_proc_socorro=:n_proc_socorro;";
            $result = $db->prepare($sql);
            $result->execute([ ":n_proc_socorro" => $n_proc_socorro]);

            echo("<p>Removido com sucesso!</p>");
            $db = null;
            }
        catch (PDOException $e)
            {
            echo("<p>ERROR: {$e->getMessage()}</p>");
            }
        ?>
        <button type='button' class='back' onclick="window.location.href='processosSocorro.php';"> Voltar </button>
    </body>
</html>