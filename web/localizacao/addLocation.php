<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../style.css">
        <title>BD | Locais</title>
    </head>
<body>
    <?php
        $local = $_REQUEST['local'];
        try{
            $host = "db.ist.utl.pt";
            $user ="ist186500";
            $password = "to_insert";
            $dbname = $user;
            $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO localizacao VALUES(:local);";
            echo("<p>$sql</p>");
            $result = $db->prepare($sql);
            $result->execute([':local' => $local]);

            echo("$local accionado à lista de locais");
            $db = null;
        }
        catch (PDOException $e){
            echo("<p>ERROR: {$e->getMessage()}</p>");
        }
    ?>

    <br><br><button type='button' class='back' onclick="window.location.href='locais.php';"> Voltar </button>
</body>
</html>