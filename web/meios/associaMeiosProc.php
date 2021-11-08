<html>
<head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../style.css">
        <title>BD | Meio</title>
    </head>
<body>
    <?php
        $n_proc_socorro = $_REQUEST['n_proc_socorro'];
        $n_meio = intval($_REQUEST['n_meio']);
        $nome_entidade = $_REQUEST['nome_entidade'];

        
        try {
            $host = "db.ist.utl.pt";
            $user ="ist186500";
            $password = "to_insert";
            $dbname = $user;
            $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


            $sql = "INSERT INTO acciona VALUES(:n_meio, :nome_entidade, :n_proc);";
            $result = $db->prepare($sql);
            $result->execute([':n_proc' => $n_proc_socorro,':n_meio' => $n_meio,':nome_entidade' => $nome_entidade]);


            $db = null;
            echo("Processo {$n_proc_socorro} associado ao Meio {$n_meio} {$nome_entidade}");
            }
            catch (PDOException $e)
            {
                echo("<p>ERROR: {$e->getMessage()}</p>");
            }
        ?>  
    <br>
    <br>
    <button type='button' class='back' onclick="window.location.href='associaMeios.php';"> Voltar </button>

</body>
</html>