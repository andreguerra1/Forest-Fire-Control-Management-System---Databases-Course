<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../../style.css">
        <title>BD | Meio Socorro</title>
    </head>
    <body>
    <h3>Meios de Socorro accionados em <?=$_REQUEST['morada_local']?></h3>

    <?php
        $morada_local = $_REQUEST['morada_local'];
        try {
            $host = "db.ist.utl.pt";
            $user ="ist186500";
            $password = "to_insert";
            $dbname = $user;
            $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT n_meio, nome_meio, nome_entidade FROM meio_socorro natural join meio natural join evento_emergencia natural join acciona WHERE morada_local = :morada_local;";
            $result = $db->prepare($sql);
            $result->execute([':morada_local' => $morada_local]);
            

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
        <button type='button' class='back' onclick="window.location.href='MeioSocorro.php';"> Voltar </button>
    </body>
</html>
