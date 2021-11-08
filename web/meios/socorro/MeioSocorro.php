<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../../style.css">
        <title>BD | Meio Socorro</title>
    </head>
    <body>
        <h2>Meio de Socorro</h2>
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

                
                
                $sql = "SELECT n_meio, nome_entidade FROM meio EXCEPT(SELECT n_meio, nome_entidade FROM meio_socorro);";
                $result = $db->prepare($sql);
                $result->execute();
                
                echo("<button type=\"button\" onclick=\"toggleDisplay('Inserir');\"> Inserir </button><br>");
                echo("<div style='display: none' class='view' id=\"Inserir\">\n\n");
                echo("<br><form style='position:absolute; left:330px;' action='insertMeioSocorro.php' id='insertform'>");
                echo("<input style='position:absolute; left:20px;' type='submit'></form>");
                echo("Nome da Entidade: <select style='position:absolute; left:190px;' name='params' form='insertform'>\n");
                foreach ($result as $row){
                    $n_meio = $row['n_meio'];
                    $nome_entidade = $row['nome_entidade'];
                    echo("<option value=\"$n_meio:$nome_entidade\">{$row['n_meio']} | {$row['nome_entidade']}</option>");
                }
                echo("</select>");
                echo("<br></div>");


                $sql = "SELECT * FROM meio_socorro EXCEPT (SELECT n_meio, nome_entidade FROM transporta);";
                $result = $db->prepare($sql);
                $result->execute();
                echo("<br><div id='Remover'><button type='button' onclick='toggleDisplay(\"remove\");'> Remover </button></div><br>");
                echo("<table class='view' id='remove' style='display: none;left:47%'>\n");
                echo("<tr><th>Numero Meio</th><th>Nome Entidade</th></tr>\n");
                foreach ($result as $row){
                    echo("<tr>\n<td> {$row['n_meio']} </td>\n");
                    echo("<td> {$row['nome_entidade']} </td>\n");
                    $n_meio = $row['n_meio'];
                    $nome_entidade = $row['nome_entidade'];
                    echo("<td><button type='button' onclick=\"window.location.href='removeMeioSocorro.php?n_meio=$n_meio&nome_entidade=$nome_entidade'\"> Remover </button>");           
                    echo("</td></tr>\n");
    
                }
                echo("</table>");


                $sql = "SELECT n_meio, nome_entidade FROM meio_socorro;";
                $result = $db->prepare($sql);
                $result->execute();
                
                echo("<button type=\"button\" onclick=\"toggleDisplay('Editar');\"> Editar </button><br>");
                echo("<div style='display: none' class='view' id=\"Editar\">\n\n");
                echo("<br><form action='editMeioSocorro.php'>");
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
                

                //Listar os meios de Socorro acionados em processos de socorro originados num dado local de incêndio
                $sql = "SELECT morada_local FROM localizacao;";
                $result = $db->prepare($sql);
                $result->execute();
                
                echo("<br><button type=\"button\" onclick=\"toggleDisplay('MeioLocal');\"> Listar meios de Socorro accionados dado num local </button><br>");
                echo("<div style='display: none' class='view' id=\"MeioLocal\">\n\n");
                echo("<br><form action='listMeioLocal.php'>");
                echo("Local: <select style='margin-right:10px' name='morada_local'>\n");
                foreach ($result as $row){
                    echo("<option value=\"{$row['morada_local']}\">{$row['morada_local']}</option>");
                }
                echo("</select>");
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