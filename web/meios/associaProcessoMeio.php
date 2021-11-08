<html>
<head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../style.css">
        <title>BD | Meio</title>
    </head>
    <h3> Associar Processo ao meio <?=$_REQUEST['n_meio']?> <?=$_REQUEST['nome_entidade']?></h3>
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


            $sql = "SELECT n_proc_socorro FROM processo_socorro EXCEPT (SELECT distinct n_proc_socorro FROM acciona WHERE n_meio=:n_meio AND nome_entidade=:nome_entidade);";
            $result = $db->prepare($sql);
            $result->execute([':n_meio' => $n_meio,':nome_entidade' => $nome_entidade]);
            
            echo("<form action='/associaMeiosProc.php'>
            <p><input type='hidden' name='n_meio' value=\"$n_meio\"></p>
            <p><input type='hidden' name='nome_entidade' value=\"$nome_entidade\"></p>
            Numero do Processo: <select style='position:absolute; left:220px;' name='n_proc_socorro'>\n");
            foreach ($result as $row){
                echo("<option value=\"{$row['n_proc_socorro']}\">{$row['n_proc_socorro']}</option>");
            }
            echo("</select>");
            echo("<input style='position:absolute; left:280px;' type='submit' value='Associar'></form>");

            $db = null;
            }
            catch (PDOException $e)
            {
                echo("<p>ERROR: {$e->getMessage()}</p>");
            }
        ?>  
    <br>
    <br>
    <button type='button' class='back' onclick="window.location.href='/associaMeios.php';"> Voltar </button>

</body>
</html>