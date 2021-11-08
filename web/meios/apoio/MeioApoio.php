<html>
    <head>
            <meta charset="UTF-8">
            <link rel="stylesheet" href="../../style.css">
            <title>BD | Meio Apoio</title>
    </head>
    <body>
        <h2>Meio de Apoio</h2>
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

                
                
                $sql = "SELECT n_meio, nome_entidade FROM meio EXCEPT(SELECT n_meio, nome_entidade FROM meio_apoio);";
                $result = $db->prepare($sql);
                $result->execute();
                
                echo("<button type=\"button\" onclick=\"toggleDisplay('Inserir');\"> Inserir </button><br>");
                echo("<div style='display: none' class='view' id=\"Inserir\">\n\n");
                echo("<br><form style='position:absolute; left:330px;' action='insertMeioApoio.php' id='insertform'>");
                echo("<input style='position:absolute; left:20px;' type='submit'></form>");
                echo("Nome da Entidade: <select style='position:absolute; left:190px;' name='params' form='insertform'>\n");
                foreach ($result as $row){
                    $n_meio = $row['n_meio'];
                    $nome_entidade = $row['nome_entidade'];
                    echo("<option value=\"$n_meio:$nome_entidade\">{$row['n_meio']} | {$row['nome_entidade']}</option>");
                }
                echo("</select>");
                echo("<br></div>");


                $sql = "SELECT * FROM meio_apoio EXCEPT (SELECT n_meio, nome_entidade FROM alocado);";
                $result = $db->prepare($sql);
                $result->execute();
                echo("<br><div id='Remover'><button type='button' onclick='toggleDisplay(\"remove\");'> Remover </button></div><br>");
                echo("<table class='view' id='remove' style='display: none'>\n");
                echo("<tr><th>Numero Meio</th><th>Nome Entidade</th></tr>\n");
                foreach ($result as $row){
                    echo("<tr>\n<td> {$row['n_meio']} </td>\n");
                    echo("<td> {$row['nome_entidade']} </td>\n");
                    $n_meio = $row['n_meio'];
                    $nome_entidade = $row['nome_entidade'];
                    echo("<td><button type='button' onclick=\"window.location.href='removeMeioApoio.php?n_meio=$n_meio&nome_entidade=$nome_entidade'\"> Remover </button>");           
                    echo("</td></tr>\n");
    
                }
                echo("</table>");


                $sql = "SELECT n_meio, nome_entidade FROM meio_apoio;";
                $result = $db->prepare($sql);
                $result->execute();
                
                echo("<button type=\"button\" onclick=\"toggleDisplay('Editar');\"> Editar </button><br>");
                echo("<div style='display: none' class='view' id=\"Editar\">\n\n");
                echo("<br><form action='editMeioApoio.php'>");
                echo("Meio: <select style='margin-right:10px' name='params'>\n");
                foreach ($result as $row){
                    $n_meio = $row['n_meio'];
                    $nome_entidade = $row['nome_entidade'];
                    echo("<option value=\"$n_meio:$nome_entidade\">{$row['n_meio']} | {$row['nome_entidade']}</option>");
                }
                echo("</select>");
                echo("Novo nome: <input style='margin-left:5px;' type='text' name='nome_meio'>");
                echo("<input  type='submit'></form>");
                echo("<br></div>");

                $db = null;                
            } catch(PDOException $e) {
                echo("<p>ERROR: {$e->getMessage()}</p>");
            }

        ?>

        <br><br><button type='button' class='back' onclick="window.location.href='../meios.php';"> Voltar </button>


    </body>
</html>