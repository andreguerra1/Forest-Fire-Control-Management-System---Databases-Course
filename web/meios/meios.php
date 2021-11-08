<html>
    <head>
            <meta charset="UTF-8">
            <link rel="stylesheet" href="../style.css">
            <title>BD | Meio</title>
    </head>
    <body>
        <h2>Meio</h2>
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

        <?php
            try {
                $host = "db.ist.utl.pt";
                $user ="ist186500";
                $password = "to_insert";
                $dbname = $user;
                $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password); 
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                
                
                $sql = "SELECT nome_entidade FROM entidade_meio;";
                $result = $db->prepare($sql);
                $result->execute();
            
                echo("<button type=\"button\" onclick=\"toggleDisplay('Inserir');\"> Inserir </button><br><br>");
                echo("<div style='display: none' class='view' id=\"Inserir\">\n\n");
                echo("<form style='position:absolute; left:330px;' action='insertMeios.php' id='insertform'> Nome do Meio: <input type='text' name='nome_meio'>");
                echo("<input style='position:absolute; left:250px;' type='submit'></form>");
                echo("Nome da Entidade: <select style='position:absolute; left:190px;' name='nome_entidade' form='insertform'>\n");
                foreach ($result as $row){
                    echo("<option value=\"{$row['nome_entidade']}\">{$row['nome_entidade']}</option>");
                }
                echo("</select>");
                

                $sql = "SELECT count(*) FROM meio;";
                $result = $db->prepare($sql);
                $result->execute();
                foreach ($result as $row){
                    echo("<p><input form='insertform' type='hidden' name='n_meio' value=\"{$row['count']}\"></p>\n");
                }
                echo("</div>");


                $sql = "SELECT * FROM meio EXCEPT (SELECT n_meio, nome_meio, nome_entidade FROM acciona natural join meio);";
                $result = $db->prepare($sql);
                $result->execute();
                echo("<div id='Remover'><button type='button' onclick='toggleDisplay(\"remove\");'> Remover </button></div><br>");
                echo("<table class='view' id='remove' style='display: none'>\n");
                echo("<tr><th>Numero Meio</th><th>Nome Meio</th><th>Nome Entidade</th></tr>\n");
                foreach ($result as $row){
                    echo("<tr>\n<td> {$row['n_meio']} </td>\n");
                    echo("<td> {$row['nome_meio']} </td>\n");
                    echo("<td> {$row['nome_entidade']} </td>\n");
                    $n_meio = $row['n_meio'];
                    $nome_entidade = $row['nome_entidade'];
                    echo("<td><button type='button' onclick=\"window.location.href='removeMeio.php?n_meio=$n_meio&nome_entidade=$nome_entidade'\"> Remover </button>");           
                    echo("</td></tr>\n");
    
                }
                echo("</table>");
                
                $sql = "SELECT * FROM meio;";
                $result = $db->prepare($sql);
                $result->execute();
                echo("<div id='Listar'><button type='button' onclick='toggleDisplay(\"listM\");'> Listar </button></div><br>");
                echo("<table class='view' id='listM' style='display: none'>\n");
                echo("<tr><th>Numero Meio</th><th>Nome Meio</th><th>Nome Entidade</th></tr>\n");
                foreach ($result as $row){
                    echo("<tr>\n<td> {$row['n_meio']} </td>\n");
                    echo("<td> {$row['nome_meio']} </td>\n");
                    echo("<td> {$row['nome_entidade']} </td>\n");
                    echo("</tr>\n");
    
                }
    
                echo("</table>");


                $sql = "SELECT distinct n_proc_socorro FROM acciona;";
                $result = $db->prepare($sql);
                $result->execute();

                echo("<button type=\"button\" onclick=\"toggleDisplay('list');\"> Listar Meios accionados por um Processo </button>");
                echo("<div style='display: none' class='view' id=\"list\">\n\n");
                echo("<form action='listMeios.php' id='listform'>");
                echo("<input style='position:absolute; left:270px;' type='submit'></form>");
                echo("Número do Processo: <select style='position:absolute; left:210px;' name='n_proc_socorro' form='listform'>\n");
                foreach ($result as $row){
                    echo("<option value=\"{$row['n_proc_socorro']}\">{$row['n_proc_socorro']}</option>");
                }
                echo("</select></div><br><br>");
                
                echo("<button type=\"button\" onclick=\"window.location.href='associaMeios.php';\"> Associar processo </button>");

                $db = null;                
            } catch(PDOException $e) {
                echo("<p>ERROR: {$e->getMessage()}</p>");
            }

        ?>

        <br><br><button type='button' onclick="window.location.href='apoio/MeioApoio.php';"> Meios de Apoio </button><br>
        <br><button type='button' onclick="window.location.href='socorro/MeioSocorro.php';"> Meios de Socorro</button><br>
        <br><button type='button' onclick="window.location.href='combate/MeioCombate.php';"> Meios de Combate </button><br>
        <br><br><button type='button' class='back' onclick="window.location.href='../index.html';"> Voltar </button>

        

    </body>
</html>