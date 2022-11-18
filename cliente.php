<?php 
include 'conecta.php';
// criando consulta SQL 
$consultaSql = "SELECT * FROM cliente where deleted is null order by nome asc, cod_cliente asc"; // negócio???
$consultaSqlArq = "SELECT * FROM cliente where deleted is not null order by nome asc, cod_cliente asc"; // negócio???
// buscando e listando os dados da tabela (completa)
$lista = $conn->query($consultaSql);
$listaArq = $conn->query($consultaSqlArq);
// separar em linhas
$row = $lista->fetch();
$rowArq = $listaArq->fetch();
// retornando o númaru de linhas
$num_rows = $lista->rowCount();
$num_rows_arq = $listaArq->rowCount();

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
// arquivando registro de clientes
if(isset($_GET['codarq']))
{
    $cliente = $conn->query(
        'update cliente set deleted = now() where cod_cliente ='.$_GET['codarq'])->fetch();
    header('location: cliente.php');
}
// restaurando registro de clientes
if(isset($_GET['codrest']))
{
    $cliente = $conn->query(
        'update cliente set deleted = null where cod_cliente ='.$_GET['codrest'])->fetch();
    header('location: cliente.php');
}
// excluindo definitivamente registro de clientes
if(isset($_GET['coddel']))
{
    $cliente = $conn->query(
        'delete from cliente where cod_cliente ='.$_GET['coddel'])->fetch();
    header('location: cliente.php');
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
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
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
    <h4>Clientes Cadastrados</h4>
    <table class="tabelinha">
        <?php if ($num_rows>0) {?>
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
                    <td><a href="cliente.php?codedit=<?php echo $row['cod_cliente'];?>">
                        <span class="material-icons">edit</span></a></td>
                    <td><a href="cliente.php?codarq=<?php echo $row['cod_cliente'];?>">
                        <span class="material-icons">drive_file_move_outline</span></a></td>
                </tr>
            <?php } while ($row = $lista->fetch());
        }else{
            echo '<td colspan=5>Não há clientes Cadastrados ativos</td>';
        }
            ?>
        </tbody>
    </table>
    <h4>Clientes Arquivados</h4>
    <table class="tabelinha">
        <?php if ($num_rows_arq>0) {?>
        <thead>
            <th>Cod</th>
            <th>Nome</th>
            <th>CPF</th>
            <th colspan="2">Ações</th>
        </thead>
        <tbody>
            <?php do {?>
                <tr>
                    <td><?php echo $rowArq['cod_cliente'];?></td>
                    <td><?php echo $rowArq['nome'];?></td>
                    <td><?php echo $rowArq['cpf'];?></td>
                    <td ><a href="cliente.php?codrest=<?php echo $rowArq['cod_cliente'];?>">
                        <span class="material-icons">restore_page</span>Restaurar
                    </a></td>
                    <td><a href="cliente.php?coddel=<?php echo $rowArq['cod_cliente'];?>">Deletar</a></td>
                </tr>
            <?php } while ($rowArq = $listaArq->fetch());
        }else{
            echo '<td colspan=5>Não há clientes arquivados</td>';
        }?>
        </tbody>
    </table>
</body>
</html>

