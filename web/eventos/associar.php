<html>
<head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../style.css">
        <title>BD | Eventos</title>
    </head>
    <body>

<h2 style="text-align:center;">Associar Processos de Socorro a Eventos de Emergência</h2>
<br><button type='button' class='back' onclick="window.location.href='events.php';"> Voltar </button>    
<?php
    try
    {
        $host = "db.ist.utl.pt";
        $user ="ist186500";
        $password = "to_insert";
        $dbname = $user;
        
        
        $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $sql = "SELECT * FROM evento_emergencia;";
        $result = $db->prepare($sql);
        $result->execute();
        
        $sql = "SELECT * FROM processo_socorro;";
        $result2 = $db->prepare($sql);
        $result2->execute();
        $array = $result2->fetchAll();
        
        echo("<table style='position:relative; margin:auto; left:0;'>\n");
        echo("<tr><th>Nº Telefone</th><th>Instante da Chamada</th><th>Nome Pessoa</th><th>Morada</th><th>Processo</th><th>Processo a Associar</th><th></th></tr>\n");
        foreach($result as $row)
        {
            echo("<tr><td>");
            echo($row['n_telefone']);
            echo("</td>");
            echo("<td>");  
            echo($row['inst_chamada']);
            echo("</td>");
            echo("<td>");
            echo($row['nome_pessoa']);
            echo("</td>");
            echo("<td>");
            echo($row['morada_local']);
            echo("</td>");
            echo("<td>");
            echo($row['n_proc_socorro']);
            echo("</td>");
            echo("<td>");
            $procOld = strval($row['n_proc_socorro']);
            $n_telefone = $row['n_telefone'];
            $inst_chamada = $row['inst_chamada'];
            echo("<form action='associaProcesso.php' method='post'>
            <input type='hidden' name='n_telefone' value=\"$n_telefone\">
            <input type='hidden' name='inst_chamada' value=\"$inst_chamada\">
            <input type='hidden' name='n_processo_Old' value=\"$procOld\">");
            
            echo("<select name='n_proc_socorro'>\n");
            foreach ($array as $row2){
                echo("<option value=\"{$row2['n_proc_socorro']}\">{$row2['n_proc_socorro']}</option>");
            }

            reset($array);
            echo("</select></td>");
            echo("<td><input type='submit' value='Associar'/></form>");           
            echo("</td></tr>\n");
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