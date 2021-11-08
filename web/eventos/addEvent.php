<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../style.css">
        <title>BD | Eventos</title>
    </head>
<body>
<?php
$n_telefone = $_REQUEST['n_telefone'];
$inst_chamada = $_REQUEST['inst_chamada'];
$nome_pessoa = $_REQUEST['nome_pessoa'];
$morada_local = $_REQUEST['morada_local'];
$n_proc = $_REQUEST['n_processo'];

try
{
$host = "db.ist.utl.pt";
$user ="ist186500";
$password = "to_insert";
$dbname = $user;
$db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "INSERT INTO evento_emergencia VALUES(:n_telefone,:inst_chamada,:nome_pessoa,:morada_local,:n_proc);";
$result = $db->prepare($sql);
$result->execute([':n_telefone' => $n_telefone,':inst_chamada' => $inst_chamada,':nome_pessoa' => $nome_pessoa,':morada_local' => $morada_local,':n_proc' => $n_proc]);
$db = null;
echo("Evento Inserido");
}
catch (PDOException $e)
{
echo("<p>ERROR: {$e->getMessage()}</p>");
}
?>

<br><br><button type='button' class='back' onclick="window.location.href='events.php';"> Voltar </button>

</body>
</html>