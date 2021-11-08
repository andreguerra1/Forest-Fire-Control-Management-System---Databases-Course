<html>
<head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../style.css">
        <title>BD | Eventos</title>
    </head>
<body>


<?php

$n_proc_New = $_REQUEST['n_proc_socorro'];
$n_telefone = $_REQUEST['n_telefone'];
$inst_chamada = $_REQUEST['inst_chamada'];
$n_proc_Old = intval($_REQUEST['n_processo_Old']);

try
{
$host = "db.ist.utl.pt";
$user ="ist186500";
$password = "to_insert";
$dbname = $user;
$db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$sql = "SELECT * FROM evento_emergencia WHERE n_proc_socorro = :n_proc_socorro";
$result = $db->prepare($sql);
$result->execute([':n_proc_socorro' => $n_proc_Old]);
$count = $result->rowCount();

$sql = "UPDATE evento_emergencia SET n_proc_socorro = :n_proc WHERE n_telefone = :n_telefone AND inst_chamada = :inst_chamada";
$result = $db->prepare($sql);
$result->execute([':n_proc' => $n_proc_New,':n_telefone' => $n_telefone,':inst_chamada' => $inst_chamada]);

if($count == 1 && $n_proc_Old != $n_proc_New ){
    $sql = "DELETE FROM processo_socorro WHERE n_proc_socorro = :n_proc_socorro;";
    $result = $db->prepare($sql);
    $result->execute([':n_proc_socorro' => $n_proc_Old]);
}




$db = null;
echo("<br><p>Processo de socorro $n_proc_New associado ao Evento de Emergência $n_telefone | $inst_chamada</p>");
}
catch (PDOException $e)
{
    $sql = "UPDATE evento_emergencia SET n_proc_socorro = :n_proc WHERE n_telefone = :n_telefone AND inst_chamada = :inst_chamada";
    $result = $db->prepare($sql);
    $result->execute([':n_proc' => $n_proc_Old,':n_telefone' => $n_telefone,':inst_chamada' => $inst_chamada]);

    echo("<p>ERROR: {$e->getMessage()}</p>");
}
?>

<br><button type='button' class='back' onclick="window.location.href='events.php';"> Voltar </button>

</body>
</html>