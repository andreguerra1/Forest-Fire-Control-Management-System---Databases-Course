<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../style.css">
        <title>BD | Meio</title>
    </head>
    
    <body>
        <?php
        $nome_meio = $_REQUEST['nome_meio'];
        $nome_entidade = $_REQUEST['nome_entidade'];
        $n_meio = $_REQUEST['n_meio'];
        
        try{
            $host = "db.ist.utl.pt";
            $user ="ist186500";
            $password = "to_insert";
            $dbname = $user;
            $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password); $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "INSERT INTO meio VALUES(:n_meio,:nome_meio,:nome_entidade);";
            $result = $db->prepare($sql);
            $result->execute([':n_meio' => $n_meio,':nome_meio' => $nome_meio,':nome_entidade' => $nome_entidade]); 
            
            echo("<p> Inserido com sucesso </p>");
            $db = null;
        }
        catch (PDOException $e){
            echo("<p>ERROR: {$e->getMessage()}</p>"); 
        }

        ?>
        <button type='button' class='back' onclick="window.location.href='meios.php';"> Voltar </button>
</body>
</html>