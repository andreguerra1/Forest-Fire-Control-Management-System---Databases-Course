<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../style.css">
        <title>BD | Eventos</title>
    </head>

<body>
<?php
$numero_telefone = $_REQUEST['n_telefone'];
$instante_chamada = $_REQUEST['inst_chamada'];
$n_proc_socorro = $_REQUEST['n_proc_socorro'];

try
{
$host = "db.ist.utl.pt";
$user ="ist186500";
$password = "to_insert";
$dbname = $user;
$db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "SELECT * FROM evento_emergencia WHERE n_proc_socorro = :n_proc_socorro;";
$result = $db->prepare($sql);
$result->execute([':n_proc_socorro' => $n_proc_socorro]);
$count = $result->rowCount();

$sql = "DELETE FROM evento_emergencia WHERE n_telefone = :numero_telefone AND inst_chamada = :instante_chamada;";
$result = $db->prepare($sql);
$result->execute([':numero_telefone' => $numero_telefone,':instante_chamada' => $instante_chamada]);
//echo("<p>$sql</p>");



if($count==1){


    $sql = "DELETE FROM processo_socorro WHERE n_proc_socorro = :n_proc_socorro;";
    $result = $db->prepare($sql);
    $result->execute([':n_proc_socorro' => $n_proc_socorro]);
}

echo("Evento Removido");

$db = null;
}
catch (PDOException $e)
{
echo("<p>ERROR: {$e->getMessage()}</p>");
}


?>
<br>
<br>
<button type='button' class='back' onclick="window.location.href='events.php';"> Voltar </button>    
</body>
</html>

