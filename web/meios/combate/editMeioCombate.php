<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../../style.css">
        <title>BD | Meio Combate</title>
    </head>
    
    <body>
        <?php
        $nome_entidade = explode(":", $_REQUEST['params'])[1];
        $n_meio = intval(explode(":", $_REQUEST['params'])[0]);
        $nome_meio = $_REQUEST['nome_meio'];

        
        
        try{
            $host = "db.ist.utl.pt";
            $user ="ist186500";
            $password = "to_insert";
            $dbname = $user;
            $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password); $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "UPDATE meio SET nome_meio=:nome_meio WHERE n_meio=:n_meio AND nome_entidade=:nome_entidade";
            $result = $db->prepare($sql);
            $result->execute(['nome_meio' => $nome_meio, ':n_meio' => $n_meio,':nome_entidade' => $nome_entidade]); 
            
            echo("<p> Alterado com sucesso </p>");
            $db = null;
        }
        catch (PDOException $e){
            echo("<p>ERROR: {$e->getMessage()}</p>"); 
        }

        ?>
        <button type='button' class='back' onclick="window.location.href='MeioCombate.php';"> Voltar </button>
</body>
</html>