<?php 
include 'conecta.php';
// criando consulta SQL 
$consultaSql = "SELECT * FROM cliente order by nome asc, cod_cliente asc"; // negócio???
// buscando e listando os dados da tabela (completa)
$lista = $conn->query($consultaSql);
// separar em linhas
$row = $lista->fetch();
// retornando o númaru de linhas
$num_rows = $lista->rowCount();

// buscar cliente por id
$nome = "";
$cpf = "";
$cod = 0;
if(isset($_GET['codedit']))
{
    $cliente = $conn->query(
        "select * from cliente where cod_cliente = ".$_GET['codedit'])->fetch();
    $nome = $cliente['nome'];
    $cpf = $cliente['cpf'];
    $cod = $_GET['codedit'];
} 
// atualiza o registro de cliente
if(isset($_POST['alterar']))
{
    $cod = $_POST['cod'];
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $resultado = $conn->query("update cliente set nome = '$nome', cpf = '$cpf' where cod_cliente = $cod");
    header('location: cliente.php');
}

// insere cliente na tabela
if(isset($_POST['inserir']))
{
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $insertSql = "insert cliente (nome, cpf) values('$nome','$cpf');";
    $resultado = $conn->query($insertSql);
    header('location: cliente.php');
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes (<?php echo $num_rows?>)</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <form action="cliente.php" method="post">
        <div hidden>
            <label for="cod">Código
                <input type="text" name="cod" id="" value="<?php echo $cod;?>"></label>
        </div>
        <div class="campo">
            <label for="nome">Nome
                <input type="text" name="nome" id="" value="<?php echo $nome;?>"></label>
        </div>
        <div class="campo">
            <label for="cpf">CPF
                <input type="number" name="cpf" id=""  value="<?php echo $cpf;?>"></label>
        </div>
        <div class="campo">
             <button type="submit" 
             name="<?php echo $cod==0?'inserir':'alterar' ?>">
             <?php echo $cod==0?'Inserir':'Alterar' ?>
            </button>
        </div>
       
    </form>
    <table class="tabelinha">
        <thead>
            <th>Cod</th>
            <th>Nome</th>
            <th>CPF</th>
            <th colspan="2">Ações</th>
        </thead>
        <tbody>
            <?php do {?>
                <tr>
                    <td><?php echo $row['cod_cliente'];?></td>
                    <td><?php echo $row['nome'];?></td>
                    <td><?php echo $row['cpf'];?></td>
                    <td><a href="cliente.php?codedit=<?php echo $row['cod_cliente'];?>">Editar</a></td>
                    <td><a href="cliente.php?codarq=<?php echo $row['cod_cliente'];?>">Arquivar</a></td>
                </tr>
            <?php } while ($row = $lista->fetch())?>
        </tbody>
    </table>
</body>
</html>

