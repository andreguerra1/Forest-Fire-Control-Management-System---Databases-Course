<html>
    <head>
        <link rel="stylesheet" href="../style.css">
        <title>BD | Meio</title>
    </head>
    <body>
    <h3>Meios accionados pelo processo <?=$_REQUEST['n_proc_socorro']?></h3>

    <?php
        $n_proc_socorro = $_REQUEST['n_proc_socorro'];
        try {
            $host = "db.ist.utl.pt";
            $user ="ist186500";
            $password = "to_insert";
            $dbname = $user;
            $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT n_meio, nome_meio, nome_entidade FROM acciona natural join meio WHERE n_proc_socorro = :n_proc;";
            $result = $db->prepare($sql);
            $result->execute([':n_proc' => $n_proc_socorro]);
            

            echo("<table>\n");
            echo("<tr><th>Numero Meio</th><th>Nome Meio</th><th>Nome Entidade</th></tr>\n");
            foreach ($result as $row){
                echo("<tr>\n<td> {$row['n_meio']} </td>\n");
                echo("<td> {$row['nome_meio']} </td>\n");
                echo("<td> {$row['nome_entidade']} </td>\n");
                echo("</tr>\n");
            }
            echo("</table>");

            $db = null;
            }
        catch (PDOException $e)
            {
            echo("<p>ERROR: {$e->getMessage()}</p>");
            }
        ?>
        <button type='button' class='back' onclick="window.location.href='meios.php';"> Voltar </button>
    </body>
</html>
