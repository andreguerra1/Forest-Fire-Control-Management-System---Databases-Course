<html>
<head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../style.css">
        <title>BD | Eventos</title>

    </head>

    <script>
        function toggleDisplay(name) {
            var el = document.getElementById(name);
            var views = document.getElementsByClassName("view");
            el.style.display = (el.style.display == 'inline' ? 'none' : 'inline');
            
            for (let i = 0; i < views.length; i++) {
                if(views[i].id != name)
                    views[i].style.display = 'none';
            }
                
        }
    </script>
    <body>

    <h2>Eventos de Emergência</h2>
    <button type="button" onclick="toggleDisplay('insert');">Inserir</button><br><br>
    
    <form class='view' id='insert' style="display: none;" action="addEvent.php" method="post">
    <table style="position: absolute; left:25%; top: 10%;">
    <tr><td>numero de telefone: </td><td><input type="text" name="n_telefone"/></td></tr>
    <tr><td>instante da chamda: </td><td><input type="text" name="inst_chamada"/></td></tr>
    <tr><td>nome da pessoa:     </td><td><input type="text" name="nome_pessoa"/></td></tr>
    <tr><td>morada local:     </td><td><input type="text" name="morada_local"/></td></tr>
    <tr><td><p>numero do processo: </td><td><input type="text" name="n_processo"/></td></tr>
    <tr></td><td><td><p><input type="submit" value="Adicionar"/></p></td></tr>
    </table>
    </form>

    <button type='button' onclick="window.location.href='associar.php'"> Associar Processos de Socorro </button><br><br>

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
        
        echo('<button type="button" onclick="toggleDisplay(\'remove\');">Remover</button>');
        
        echo("<table style='display: none; position: absolute; left:25%; top: 10%;' id='remove' class='view'>\n");
        echo("<tr><th>n_telefone</th><th>inst_chamada</th><th>nome_pessoa</th><th>morada_local</th><th>n_proc_socorro</th><th></th></tr>\n");
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
            $n_telefone = $row['n_telefone'];
            $inst_chamada = $row['inst_chamada'];
            $proc_socorro = $row['n_proc_socorro'];
            echo("<button type='button' onclick=\"window.location.href='removeEvent.php?n_telefone=$n_telefone&inst_chamada=$inst_chamada&n_proc_socorro=$proc_socorro'\"> Remover </button>");           
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
    
    <br><br><button type='button' class='back' onclick="window.location.href='../index.html';"> Voltar </button>    

    </body>
</html>