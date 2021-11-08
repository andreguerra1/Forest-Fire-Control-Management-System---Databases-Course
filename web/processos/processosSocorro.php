<html>
    <head>
            <meta charset="UTF-8">
            <link rel="stylesheet" href="../style.css">
            <title>BD | Processos Socorro</title>
    </head>
    <body>
        <h2>Processos Socorro</h2>
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

                

                $sql = "SELECT * FROM processo_socorro EXCEPT (SELECT n_proc_socorro FROM acciona);";
                $result = $db->prepare($sql);
                $result->execute();
                echo("<br><div id='Remover'><button type='button' onclick='toggleDisplay(\"remove\");'> Remover </button></div><br>");
                echo("<table class='view' id='remove' style='display: none'>\n");
                echo("<tr><th>Numero Processo</th></tr>\n");
                foreach ($result as $row){
                    echo("<tr>\n<td> {$row['n_proc_socorro']} </td>\n");
                    $n_proc_socorro = strval($row['n_proc_socorro']);
                    echo("<td><button type='button' onclick=\"window.location.href='removeProcSocorro.php?n_proc_socorro=$n_proc_socorro'\"> Remover </button>");           
                    echo("</td></tr>\n");
    
                }
                echo("</table>");

                $db = null;                
            } catch(PDOException $e) {
                echo("<p>ERROR: {$e->getMessage()}</p>");
            }

        ?>

        <br><br><button type='button' class='back' onclick="window.location.href='../index.html';"> Voltar </button>


    </body>
</html>