<html>
    <body>
<?php
    try
    {
        $host = "db.ist.utl.pt";
        $user ="ist186500";
        $password = "belakor";
        $dbname = $user;
        
        
        $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $sql = "SELECT morada_local FROM localizacao;";
        $result = $db->prepare($sql);
        $result->execute();
           
        echo("<table border=\"1\">\n");
        echo("<tr><td>morada_local</td></tr>\n");
        foreach($result as $row)
        {
            echo("<tr><td>");
            echo($row['morada_local']);
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
