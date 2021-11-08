<html>
    <head>
            <meta charset="UTF-8">
            <link rel="stylesheet" href="../style.css">
            <title>BD | Locais</title>
    </head>
    <body>
        <h2>Locais</h2>
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

        <div id="Inserir">
            <button type="button" onclick="toggleDisplay('insert');"> Inserir </button><br>
            <form id='insert' class='view' style="display:none"action="insertLocation.php" method="POST">
                <td>
                    <br>
                    <tr>Nome da cidade: <input type="text" name="morada_local"/> </tr> 
                    <tr><input type="submit" value="Submeter"/> </tr> 
                </td>
            </form>
        </div><br>

        <div id='Listar'> 
        <button type='button' onclick='toggleDisplay("list");'> Listar </button>
        </div><br>

        <div id='Remover'> 
        <button type='button' onclick='toggleDisplay("remove");'> Remover </button>
        </div><br>

        

        <?php
            try{
                $host = "db.ist.utl.pt";
                $user ="ist186500";
                $password = "to_insert";
                $dbname = $user;
                $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password); 
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                $sql = "SELECT v.morada_local FROM (SELECT morada_local FROM localizacao EXCEPT (SELECT DISTINCT morada_local FROM vigia UNION (SELECT morada_local FROM evento_emergencia))) v;";
                $result = $db->prepare($sql);
                $result->execute();
    
                echo("<table class='view' id='remove' style='display: none'>\n");
                echo("<tr><th> morada_local </th><th></th></tr>\n");
                foreach ($result as $row){
                    echo("<tr>\n<td> {$row['morada_local']} </td>\n");
                    echo("<td> <a href=\"removeLocation.php?morada_local={$row['morada_local']}\"> Remover </a></td>\n");
                    echo("</tr>\n");
    
                }
    
                echo("</table>");
    
                $sql = "SELECT morada_local FROM localizacao;";
                $result = $db->prepare($sql);
                $result->execute();
    
                echo("<table class='view' id='list' style='display: inline; left:45%;'>\n");
                echo("<tr><th> morada_local </th></tr>\n");
                
                foreach ($result as $row){
                    echo("<tr>\n<td> {$row['morada_local']} </td>\n</tr>\n");
                }
    
                echo("</table>");
    
                $db = null;
            } catch(PDOException $e) {
                echo("<p>ERROR: {$e->getMessage()}</p>");
            }
            
        ?>

        <button type='button' class='back' onclick="window.location.href='../index.html';"> Voltar </button>

        

    </body>
</html>