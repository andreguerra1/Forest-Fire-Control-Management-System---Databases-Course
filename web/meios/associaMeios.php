<html>
<head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../style.css">
        <title>BD | Meio</title>
    </head>
    <body>

<h3 style="text-align:center;">Associar Meios</h3>

<button type='button' class='back' onclick="window.location.href='meios.php';"> Voltar </button>
<?php
    try
    {
        $host = "db.ist.utl.pt";
        $user ="ist186500";
        $password = "to_insert";
        $dbname = $user;
        
        
        $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $sql = "SELECT * FROM meio;";
        $result = $db->prepare($sql);
        $result->execute();
        
        $sql = "SELECT * FROM processo_socorro;";
        $result2 = $db->prepare($sql);
        $result2->execute(); 
        $array = $result2->fetchAll();
        echo("<table style='position: relative; margin:auto; left:0;'>\n");
        echo("<tr><th>Numero</th><th>Nome</th><th>Entidade</th><th></th></tr>\n");
        foreach($result as $row)
        {
            echo("<tr><td>");
            echo($row['n_meio']);
            echo("</td>");
            echo("<td>");  
            echo($row['nome_meio']);
            echo("</td>");
            echo("<td>");
            echo($row['nome_entidade']);
            echo("</td>");
            echo("<td>");
            echo("<form action='associaProcessoMeio.php' method='post'>
            <input type='hidden' name='n_meio' value=\"{$row['n_meio']}\"/>
            <input type='hidden' name='nome_meio' value=\"{$row['nome_meio']}\"/>
            <input type='hidden' name='nome_entidade' value=\"{$row['nome_entidade']}\"/>
            <input type='submit' value='Associar Processo'/></td></tr></form>");
        }
        echo("</table>\n");
    
        $db = null;
    }
    catch (PDOException $e)
    {
        echo("<p>ERROR: {$e->getMessage()}</p>");
    }
?>

    </body>
</html>